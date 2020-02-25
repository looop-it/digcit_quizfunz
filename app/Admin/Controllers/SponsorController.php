<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Sponsor;
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

class SponsorController extends Controller
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
            $content->header('Sponser');
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
            $content->header('Sponser');
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
            $content->header('Sponser');
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
        return Admin::grid(Sponsor::class, function (Grid $grid) {
            $grid->model()->ordered();
            $grid->title('Name')->ucfirst()->limit(30);
            $grid->logo()->image();
            $states = [
                'on' => ['text' => 'active'],
                'off' => ['text' => 'inactive'],
            ];
            $grid->column('status', 'Status')->switchGroup([
                'status' => 'Status'
            ], $states);
            $grid->order('Ordering')->orderable();
            


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
        return Admin::form(Sponsor::class, function (Form $form) {
            $form->text('title', 'Name')->rules('required|min:2|max:255');
            $form->image('logo', 'Logo')->uniqueName()->help('size:200x200,type:jpg/png')->dir('sponsors');
            $states = [
                    'on'  => ['value' => 1, 'text' => 'active', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'inactive', 'color' => 'default'],
                ];
            $form->switch('status', 'status')->states($states)->default(1);
            $form->text('link', 'Link');
        });
    }
}
