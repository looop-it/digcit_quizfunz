<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Admin\Models\Consultant;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Permission;

class ConsultantController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        Permission::check('consultant.view');

        return Admin::content(function (Content $content) {
            $content->header('顧問');
            $content->description('列表');

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
        Permission::check('consultant.edit');

        return Admin::content(function (Content $content) use ($id) {
            $content->header('顧問');
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
        Permission::check('consultant.create');
        
        return Admin::content(function (Content $content) {
            $content->header('顧問');
            $content->description('建立');

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
        return Admin::grid(Consultant::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->name("姓名");
            $grid->image('圖像');
            $grid->url("連結");
            $grid->enabled('啟用?')->switch($this->getEnabledStates());
            $grid->created_at('建立時間');

            // -------Grid基本設置-------
            $grid->disableExport();
            $grid->perPages([10, 20, 30, 40, 50]);

            $grid->filter(function ($filter) {
                // 禁用id查询框
                $filter->disableIdFilter();
                $filter->like('title', '搜索');
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
        return Admin::form(Consultant::class, function (Form $form) {
            $form->text('name', '姓名')->placeholder('請輸入姓名');
            $form->image('image', '圖像');
            $form->text('url', '連結')->placeholder('請輸入連結');

            $form->switch('enabled', '啟用？')->states($this->getEnabledStates())->default(1);
        });
    }

    private function getEnabledStates()
    {
        return [
            'on'  => ['value' => 1, 'text' => '啟用', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '停用', 'color' => 'danger'],
        ];
    }
}
