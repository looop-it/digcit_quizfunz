<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Admin\Models\Scope;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Auth\Permission;

class ScopeController extends Controller
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
            $content->header('範籌管理');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        Permission::check('scope.list');

        return Admin::content(function (Content $content) use ($id) {
            $content->header('範籌管理');
            $content->description('修改');

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
        // Permission::check('create_article');

        return Admin::content(function (Content $content) {
            $content->header('範籌管理');
            $content->description('新增');

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
        return Admin::grid(Scope::class, function (Grid $grid) {
            $grid->name('名稱')->ucfirst()->limit(30);
            $grid->questions('問題')->display(function ($questions) {
                $count = count($questions);

                return "<span class='label label-default'>{$count}</span>";
            });

            $grid->actions(function ($actions) {
                if (Admin::user()->cannot('delete_scope')) {
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
        return Admin::form(Scope::class, function (Form $form) {
            $form->text('name', 'Name')->rules('required|min:2|max:255');
        });
    }
}
