<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;


use Carbon\Carbon;
use App\Helpers\Utility;

use App\Admin\Models\Post;
use App\Admin\Models\Category;
use App\Admin\Models\Feature;
use App\Admin\Models\FeaturePost;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Auth\Permission;

use App\Admin\Extensions\Tools\PublishPost;
use Intervention\Image\ImageManagerStatic as Image;

class PostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '最新消息';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $content->body($this->grid());
        $box = new Box(
            'About Features Icon',
            '<i class="fa fa-lock text-warning" aria-hidden="true"><a name="locked"></a> Locked: You are not the creator of this article and You don\'t have permission to edit other people\'s articles</i><br><i class="fa fa-star text-info" aria-hidden="true"> Featured: This article is marked as feature article</i><br><i class="fa fa-video-camera text-info" aria-hidden="true" > Video Article:This article is marked as video article (contain video content)</i>'
        );
        
        $content->row($box->style('danger'));
        
        return $content;
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    // public function edit($id, Content $content)
    // {
    //     $post = Post::findOrFail($id);

    //     $content->body($this->form()->edit($post->id));

    //     // Show post info
    //     $headers = ['Option', 'Value'];
    //     $prevewUrl = Utility::getPreviewUrl($post->category->title, $post->id, $post->slug);

    //     $rows = [
    //         'Preview Url' => ($prevewUrl) ? '<a target=_blank href=' . $prevewUrl . '>' . $prevewUrl . '</a>' : null,
    //         'Created at' => $post->created_at,
    //         'Created by' => $post->initEditor->name ?? 'none',
    //         'Updated at' => $post->updated_at,
    //         'Last modified by' => ($post->last_modify_user > 0) ? $post->lastModifyEditor->name : 'none',
    //         'Hits' => $post->hits,
    //     ];

    //     $table = new Table($headers, $rows);
    //     $content->row((new Box('Article Info', $table))->style('default')->solid());


    // }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Post);

        $grid->model()->orderBy('published_at', 'desc');

        $grid->id('#');
        $grid->category()->title("分類")->label('success');
        $grid->title('標題');

        $grid->published_at('發表日期')->sortable();

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('title', '標題');
            $filter->equal('category_id', '分類')->select(Category::active()->get()->pluck('title', 'id'));
            $filter->between('published_at', '發佈日期')->datetime();
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Post);

        $form->text('title', '標題')->rules('required|min:2|max:255');
        /*     $form->text('author', 'Author')->rules('required|min:2|max:255');    */
        $form->select(
            'category_id',
            '分類'
        )->options(Category::selectOptions())->rules(
            'required|numeric|min:1',
            ['min' => 'Please select the post category']
        );

        $form->image(
            'cover_image',
            '封面圖片'
        )->uniqueName()->help('size:800x800,type:jpg/png')->dir('articles/cover/' . date('Ymd', time()));

        $form->ckeditor('content', '內容');

        if (Admin::user()->can('publish_article')) {
            $states = [
                'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'No', 'color' => 'default'],
            ];
            $form->switch('published', '發佈？')->states($states);
        }
        
        $form->datetime('published_at', '發佈日期')->default(Carbon::now())->help('If you set a future time, the system will be automatically published at that time');

        return $form;
    }

    /**
     * upload function for summernote inline edit
     * @return [type] [description]
     */
    public function upload()
    {
        $file = Input::file('file');

        $input = array('image' => $file);
        $rules = array(
            'image' => 'image'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $destinationPath = 'articles/' . date('Ymd', time());

        $filename = $filename = uniqid() . '_' . $file->getClientOriginalName();
        // $file->move($destinationPath, $filename);

        $fileuploaded = Storage::put($destinationPath, $file);

        return Response::json(
            [
                'success' => true,
                'url' => config('app.cdn_url') . '/' . $fileuploaded,
            ]
        );
    }


    /**
     * POST /admin/posts/publish
     *
     * @param Request $request
     * @return void
     */
    public function publish(Request $request)
    {
        foreach (Post::find($request->get('ids')) as $post) {
            $post->published = $request->get('action');
            $post->save();
        }
    }


    /**
     * POST /admin/demo/posts/restore
     *
     * @param Request $request
     * @return void
     */
    public function restore(Request $request)
    {
        return Post::onlyTrashed()->find($request->get('ids'))->each(function ($post) {
            Post::withoutSyncingToSearch(function () use ($post) {
                // 执行模型动作...
                $post->restore();
            });
        });
    }
}
