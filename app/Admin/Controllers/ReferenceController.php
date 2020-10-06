<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Reference;
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

class ReferenceController extends Controller
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
            $content->header('Reference');
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
            $content->header('Reference');
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
            $content->header('Reference');
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
        return Admin::grid(Reference::class, function (Grid $grid) {
            $grid->name('Name')->ucfirst()->limit(30);
            $states = [
                'on' => ['text' => 'active'],
                'off' => ['text' => 'inactive'],
            ];
            $grid->column('status', 'Status')->switchGroup([
                'status' => 'Status'
            ], $states);

            $grid->actions(function ($actions) {
                if (Admin::user()->cannot('delete_article')) {
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
        return Admin::form(Reference::class, function (Form $form) {
            $form->text('name', 'Name')->rules('required|min:2|max:255');
            //$form->text('author', 'Author')->rules('required|min:2|max:255');
            $form->image('cover_image', 'Cover')->uniqueName()->help('size:200x200,type:jpg/png')->dir('references');
            $form->text('link', 'Link');
            $form->textarea('desc', 'Desc');
            $states = [
                    'on'  => ['value' => 1, 'text' => 'active', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'inactive', 'color' => 'default'],
                ];
            $form->switch('status', 'status')->states($states)->default(1);
            $form->ckeditor('content', 'Content');
        });
    }

/*   protected function destroy($id){

       if ($this->form()->delete($id)) {
           return response()->json([
               'status'  => true,
               'message' => trans('admin.delete_succeeded'),
           ]);
       } else {
           return response()->json([
               'status'  => false,
               'message' => trans('admin.delete_failed'),
           ]);
       }
    }*/

}
