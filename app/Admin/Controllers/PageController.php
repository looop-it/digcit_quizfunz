<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Page;
// use App\Admin\Models\Tags;
// use App\Admin\Models\Categories;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Tab;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Encore\Admin\Auth\Permission;
// use App\Admin\Extensions\Tools\PublishPost;
// use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        // Permission::check('list_article');
        return Admin::content(function (Content $content) {
            $content->header('Info Page');
            $content->description('management');

            $content->body($this->grid());
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
        Permission::check('general_setting');
        return Admin::content(function (Content $content) use ($id) {
            $content->header('Info Page');
            $content->description('edit');

            $content->body($this->form()->edit($id));
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
            $content->header('Info Page');
            $content->description('create');

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
        return Admin::grid(Page::class, function (Grid $grid) {
            $grid->name('Name')->ucfirst()->limit(30);
            $grid->slug('Slug');
            $states = [
                'on' => ['text' => 'active'],
                'off' => ['text' => 'inactive'],
            ];
            $grid->column('Status', 'Status')->switchGroup([
                'status' => 'Status'
            ], $states);

            $grid->actions(function ($actions) {
                if (Admin::user()->cannot('delete_page')) {
                    $actions->disableDelete();
                }
            });
            // -------Grid基本設置-------
            $grid->disableExport();
            // $grid->disableCreation();
            // $grid->disablePagination();
            $grid->disableFilter();

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
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
        return Admin::form(Page::class, function (Form $form) {
            $form->text('name', 'Name')->rules('required|min:2|max:255');
            $form->text('slug', 'Slug')->rules('required|min:2|max:255');
            $states = [
                    'on'  => ['value' => 1, 'text' => 'active', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'inactive', 'color' => 'default'],
                ];
            $form->switch('status', 'status')->states($states)->default(1);
            $form->editor('content', 'Content');
        });
    }

    /**
     * upload function for summernote inline edit
     * @return mixed json
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

        $destinationPath = 'pages';
        $filename = $filename = uniqid().'_'.$file->getClientOriginalName();
        // $file->move($destinationPath, $filename);
        $fileuploaded = Storage::put($destinationPath, $file);
        return Response::json(
            [
                'success' => true,
                'url' => config('app.cdn_url').'/'.$fileuploaded,
            ]
        );
    }
}
