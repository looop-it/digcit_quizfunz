<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;

use Route;
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
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Auth\Permission;

use App\Admin\Extensions\Tools\PublishPost;
use Intervention\Image\ImageManagerStatic as Image;

class PostController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        Permission::check('list_article');

        return Admin::content(function (Content $content) {
            $content->header('Article');
            $content->description('Management');

            $content->body($this->grid());
            $box = new Box('About Features Icon',
                '<i class="fa fa-lock text-warning" aria-hidden="true"><a name="locked"></a> Locked: You are not the creator of this article and You don\'t have permission to edit other people\'s articles</i><br><i class="fa fa-star text-info" aria-hidden="true"> Featured: This article is marked as feature article</i><br><i class="fa fa-video-camera text-info" aria-hidden="true" > Video Article:This article is marked as video article (contain video content)</i>');
            $content->row($box->style('danger'));
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {

        Permission::check('edit_article');

        $post = Post::findOrFail($id);

        // Permission check for user who can only edit own article(excerpt Administrator)
        if (!Admin::user()->isRole('administrator')
            && Admin::user()->can('edit_own_article')
            && Admin::user()->id != $post->user_id
        ) {
            admin_toastr('You don not have permission to edit this article <a href="#locked">[Why?]</a>', 'error');
            return back();
        }

        return Admin::content(function (Content $content) use ($post) {
            $content->header('Article');
            $content->description('Edit');
            $content->body($this->form()->edit($post->id));

            // Show post info
            // $post = Post::findOrFail($id);
            $headers = ['Option', 'Value'];
            $prevewUrl = Utility::getPreviewUrl($post->category->title, $post->id, $post->slug);
            $rows = [
                'Preview Url' => ($prevewUrl) ? '<a target=_blank href=' . $prevewUrl . '>' . $prevewUrl . '</a>' : null,
                'Created at' => $post->created_at,
                'Created by' => $post->initEditor->name ?? 'none',
                'Updated at' => $post->updated_at,
                'Last modified by' => ($post->last_modify_user > 0) ? $post->lastModifyEditor->name : 'none',
                'Hits' => $post->hits,
            ];

            $table = new Table($headers, $rows);
            $content->row((new Box('Article Info', $table))->style('default')->solid());
        });

    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        Permission::check('create_article');

        return Admin::content(function (Content $content) {
            $content->header('Article');
            $content->description('Create');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Post::class, function (Grid $grid) {
            // Default orderBy

            $grid->model()->orderBy('published_at', 'desc');
            $grid->column('title', 'Caption')->display(function () {
                if (\Config::get('app.public_url') && $this->published == 1) {
                    return '<a target="_blank" href="' . Utility::getPreviewUrl($this->category_id, $this->id,
                            $this->slug) . '" ><i class="fa fa-eye text-info" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="View this post at public site"></i></a>' . $this->title . '';
                } else {
                    return $this->title;
                }
            });
            $grid->category()->title("Category")->label('success');
            $grid->column("Features")->display(function () {
                // show article features about:lock,featured,video.
                $features = "";
                if (Admin::user()->can('edit_own_article') && Admin::user()->id != $this->user_id) {
                    $features .= ' <i class="fa fa-lock text-warning" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Locked : You can only edit the articles created by yourself."></i> ';
                }
                if ($this->featured == 1) {
                    $features .= ' <i class="fa fa-star-o text-info" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Featured Article"></i> ';
                }

                return $features;
            });
            // check publish permission
           // dd(Admin::user()->can('publish_article'));
            if (Admin::user()->can('publish_article')) {
                $states = [
                    'on' => ['text' => 'YES'],
                    'off' => ['text' => 'NO'],
                ];
                $grid->published('Publish Status')->switch($states);
            } else {
                $grid->published('Status')->display(function ($published) {
                    return ($published == 1) ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-warning" aria-hidden="true"></i>';
                });
            }

            $grid->published_at('Publish Date')->sortable();
            $grid->id('ID')->sortable();

            $grid->actions(function ($actions) {

                if (Admin::user()->cannot('delete_article')) {
                    $actions->disableDelete();
                }
            });

            $grid->filter(function ($filter) {

                // $filter->useModal();
                // 禁用id查询框
                // $filter->disableIdFilter();
                $filter->like('title', 'Search Article');
                $filter->equal('category_id', 'Category')->select(Category::active()->get()->pluck('title', 'id'));
                $filter->equal('user_id', 'Editor')->select(Administrator::pluck('name', 'id'));
                $filter->between('published_at', 'Publish date')->datetime();
            });

            // -------Grid基本設置-------
            $grid->disableExport();
            $grid->perPages([10, 20, 30, 40, 50]);

            $grid->tools(function ($tools) {
                // $tools->append(new Trashed());

                $tools->batch(function (Grid\Tools\BatchActions $batch) {
                    if (Admin::user()->cannot('delete_article')) {


                        $batch->disableDelete();
                    }

                    if (Admin::user()->can('publish_article')) {
                        $batch->add('Publish', new PublishPost(1));
                    }
                    // $batch->add('撤回', new RestorePost());
                    // $batch->add('Show selected', new ShowSelected());
                });
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Post::class, function (Form $form) {
            $form->tab('Content', function ($form) {

                $form->text('title', 'Caption')->rules('required|min:2|max:255');
                /*     $form->text('author', 'Author')->rules('required|min:2|max:255');    */
                $form->select('category_id',
                    'Category')->options(Category::selectOptions())->rules('required|numeric|min:1',
                    ['min' => 'Please select the post category']);
                // $form->text('writer', 'Writer')->rules('max:20');
                $form->image('cover_image',
                    'Cover Image')->uniqueName()->help('size:800x800,type:jpg/png')->dir('articles/cover/' . date('Ymd',
                        time()));
                $form->editor('content', 'Content');

            })->tab('Recommend', function ($form) {


                $states = [
                    'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'NO', 'color' => 'default'],
                ];
                $form->switch('featured',
                    'Featured')->states($states)->help('Featured article will display at category headline');


                $form->hasMany('feature', 'Promotions', function (Form\NestedForm $form) {
                    $form->select('feature_id', 'Position')->options(Feature::where('status', 1)->pluck('title', 'id'));
                    $form->text('caption',
                        'Custom Caption')->placeHolder('Customize Title, leave it blank will same as article caption');
                    // $form->image('cover', 'Custom Cover Image')->uniqueName()->fit(800,600)->help('size:800x600,type:jpg/png')->dir('articles/promotion_cover/'.date('Ymd',time()));
                    $form->datetime('start_date', 'Start date')->default(Carbon::now());
                    $form->datetime('end_date', 'End date')->default(Carbon::now()->addWeeks(1));
                    // $form->datetime('updated_at', '更新时间')->default(date('Y-M-d HH:ii:ss',time()))->help('前台排序根据更新时间倒排，如要更改顺序请更新时间');
                });
            })->tab('Publish', function ($form)  {
                if (Admin::user()->can('publish_article')) {


                    $states = [
                        'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
                        'off' => ['value' => 0, 'text' => 'No', 'color' => 'default'],
                    ];
                    $form->switch('published', 'Publish')->states($states);

                }
                //  這是個bug
            //  $time=date('Y-m-d H:i:s',time());
                $form->datetime('published_at', 'Publish Date')->default(Carbon::now())->help('If you set a future time, the system will be automatically published at that time');



            });


            $form->saving(function (Form $form) {
                // $form->slug = Utility::makeSlug($form->title);
                // Slack::send('文章：'.$form->title.'發佈成功');

                // 此處回調進行表單內容預處理，將base64編碼的圖片上傳到服務器
                // 目前已經改為ajax實時上傳
                // $form->content = $this->contentPretreatment($form->content);
            });

            $form->saved(function ($form) {
                $success = new MessageBag([
                    'title' => 'Article saved',
                    // 'message' => 'message....',
                ]);

                // use redirect() instead of back(), to stay edit from create.
                return redirect(route('posts.edit', [$form->model()->id]))->with(compact('success'));
            });

            $form->tools(function (Form\Tools $tools) {
                // 添加一个按钮, 参数可以是字符串, 或者实现了Renderable或Htmlable接口的对象实例
                $request = request();
                $current_post_id = $request->route('post');
                if (isset($current_post_id)) {
                    $tools->add(
                        <<<EOT
<a class='btn btn-default btn-sm' href=# onClick="javascript:window.open('/admin/related-articles/$current_post_id', '', 'width=800,height=400,toolbar=no, status=no, menubar=no, resizable=yes, scrollbars=yes');return false;"><i class="fa fa-sort-alpha-asc text-info"></i> Related Posts Sorting</a>&nbsp;&nbsp;

EOT
                    );
                }
            });
        });
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
