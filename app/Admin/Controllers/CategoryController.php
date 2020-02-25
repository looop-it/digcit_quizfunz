<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Category;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Tree;
use Encore\Admin\Auth\Permission;

class CategoryController extends Controller
{
    use ModelForm, ModelTree, AdminBuilder;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            Permission::check('manage_category');
            $content->header('Category');
            $content->description('management');

            $content->body(Category::tree());
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
        Permission::check('manage_category');
        return Admin::content(function (Content $content) use ($id) {
            $content->header('Category');
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
        return Admin::content(function (Content $content) {
            Permission::check('manage_category');
            $content->header('Category');
            $content->description('create');

            $content->body($this->form());
        });
    }

    protected function tree()
    {
        return Category::tree(function (Tree $tree) {
            $tree->branch(function ($branch) {
                // $status = ($branch['status']===1)?'啟用':'停用';
                // $index_menu = ($branch['index_menu']===1)?'導航顯示':'導航不現實';
                // var_dump($branch);

                return "{$branch['title']} - {$branch['title']} {$branch['status']}";
            });
        });
    }

    protected function form()
    {
        return Category::form(function (Form $form) {
            $form->display('id', 'ID');

            $form->select('parent_id', 'Parent Category')->options(Category::selectOptions())->help('Please select ROOT if you want to create a 1st level category');

            $form->text('title', 'Category Name');
            $form->textarea('desc', 'Category Introduction');
            $states = [
                'on'  => ['value' => 1, 'text' => 'active', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'inactive', 'color' => 'default'],
            ];
            $form->switch('status', 'Status')->states($states)->default(1);
        });
    }
}
