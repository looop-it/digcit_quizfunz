<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;

use App\Admin\Models\Feature;
use App\Admin\Models\Post;
use App\Admin\Models\FeaturePost;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Permission;

class FeatureController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        Permission::check('manage_promo');
        return Admin::content(function (Content $content) {
            $content->header('Promo Type');
            $content->description('setting');
            // $content->body(phpinfo());
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
        Permission::check('manage_promo');
        return Admin::content(function (Content $content) use ($id) {
            $content->header('Promo Type');
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
        Permission::check('manage_promo');
        return Admin::content(function (Content $content) {
            $content->header('Promo Type');
            $content->description('create');

            $content->body($this->form());
        });
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function sort($id)
    {
        return Admin::content(function (Content $content) {
            $content->header('header');
            $content->description('description');

            $content->body(FeaturePost::tree());
        });
    }

    protected function tree()
    {
        return FeaturePost::tree(function (Tree $tree) {
            $tree->branch(function ($branch) {
                $status = ($branch['status']==1)?'active':'inactive';

                return "{$branch['id']} - {$branch['title']} {{$status}}";
            });
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Feature::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->title('Type');
            $states = [
                'on'  => ['value' => 1, 'text' => 'active', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'inactive', 'color' => 'default'],
            ];
            $grid->status('Status')->switch($states);
            $grid->column('Articles')->display(function () {
                return '<a href="/admin/promo-articles?feature_id='.$this->id.'" title="manage articles and ordering under this feature"><i class="fa fa-list"></i></a>';
            });
            // -------Grid基本設置-------
            $grid->disableExport();
            $grid->perPages([10, 20, 30, 40, 50]);

            $grid->filter(function ($filter) {
                // 禁用id查询框
                $filter->disableIdFilter();
                // sql: ... WHERE `user.name` LIKE "%$name%";
                $filter->like('title', 'Search');
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
        return Admin::form(Feature::class, function (Form $form) {

            
            // $form->display('id', 'ID');
            $form->text('title', 'Type')->rules('required|min:2|max:50');
            $form->text('remark', 'Remark')->placeholder('e.g:position description');
            $states = [
                'on'  => ['value' => 1, 'text' => 'active', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'inactive', 'color' => 'default'],
            ];
            $form->switch('status', 'Status')->states($states);
            // $form->display('created_at', 'Created At');
            // $form->display('updated_at', 'Updated At');
        });
    }
}
