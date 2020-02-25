<?php

namespace App\Admin\Controllers;

use App\Admin\Models\AdvType;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Permission;

class AdvTypeController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        Permission::check('manage_ad_type');
        return Admin::content(function (Content $content) {
            $content->header('AdvType');
            $content->description('setting');

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
        Permission::check('manage_ad_type');
        return Admin::content(function (Content $content) use ($id) {
            $content->header('Advertisement');
            $content->description('setting');

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
        Permission::check('manage_ad_type');
        return Admin::content(function (Content $content) {
            $content->header('Advertisement');
            $content->description('setting');

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
        return Admin::grid(AdvType::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->title();
            $grid->position();
            $grid->size();



            $states = [
                'on' => ['text' => 'active'],
                'off' => ['text' => 'inactive'],
            ];

            $grid->column('Status')->switchGroup([
                'status' => 'Status'
            ], $states);

            // $grid->updated_at();

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
        return Admin::form(AdvType::class, function (Form $form) {

            
            // $form->display('id', 'ID');
            $form->text('title', 'Type Name')->rules('required|min:2|max:50');
            $form->text('position', 'Position')->placeholder('Position description');
            $form->text('size', 'Size')->placeholder('Size description:e.g 720x90');
            $form->textarea('3rd_ad_code', 'Default 3rd party Code', 5);
            $states = [
                'on'  => ['value' => 1, 'text' => 'active', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'inactive', 'color' => 'default'],
            ];
            $form->switch('status', 'Status')->states($states)->default(1);
            // $form->display('created_at', 'Created At');
            // $form->display('updated_at', 'Updated At');
        });
    }
}
