<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use App\Admin\Models\Consultant;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Permission;

class ConsultantController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '顧問';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Consultant());

        $grid->id('ID')->sortable();
        $grid->name("姓名");
        $grid->image('圖像');
        $grid->url("連結");
        $grid->enabled('啟用?')->switch($this->getEnabledStates());
        $grid->created_at('建立時間');

        $grid->filter(function ($filter) {
            // 禁用id查询框
            $filter->disableIdFilter();
            $filter->like('title', '搜索');
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
        $form = new Form(new Consultant);
        
        $form->text('name', '姓名')->placeholder('請輸入姓名');
        $form->image('image', '圖像');
        $form->text('url', '連結')->placeholder('請輸入連結');

        $form->switch('enabled', '啟用？')->states($this->getEnabledStates())->default(1);

        return $form;
    }

    private function getEnabledStates()
    {
        return [
            'on'  => ['value' => 1, 'text' => '啟用', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '停用', 'color' => 'danger'],
        ];
    }
}
