<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;

use App\Admin\Models\School;
use App\Admin\Models\SchoolRegistration;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;

class SchoolRegistrationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '教師登記';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SchoolRegistration());

        $grid->model()->orderBy('id', 'desc');
        
        $grid->id('ID');
        $grid->column('school.name', '學校名稱');
        $grid->column('name', '負責老師');
        $grid->column('subject', '負責科目');
        $grid->column('phone', '聯絡電話');
        $grid->column('email', '聯絡電郵');

        $grid->verified('已驗證？')->display(function ($verified) {
            return ($verified) ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
        });

        $grid->approved('已核實？')->display(function ($approved) {
            return ($approved) ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
        });

        $grid->actions(function ($actions) {
            if (!Admin::user()->can('school_registration.edit')) {
                $actions->disableEdit();
            }

            if (!Admin::user()->can('school_registration.delete')) {
                $actions->disableDelete();
            }
        });

        $grid->tools(function ($tools) {
            if (!Admin::user()->isRole('project.manager')) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            }
        });

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();

            $filter->where(function ($query) {
                $query->where('name', 'like', "%{$this->input}%");
            }, '學校名稱');

            $filter->equal('type', '學校類型')->select(['secondary' => '中學', 'university' => '大學']);
        });

        if (!Admin::user()->inRoles(['administrator', 'project.manager'])) {
            $grid->disableExport();
            $grid->disableRowSelector();
        }

        if (!Admin::user()->can('school.create')) {
            $grid->disableCreateButton();
        }
        
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SchoolRegistration);
        
        $states = [
            'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'NO', 'color' => 'default'],
        ];

        $form->select('school_id', '學校名稱')->options(
            School::approved()->ofType('secondary')->orderBy('id', 'asc')->pluck('name', 'id')
        );

        $form->text('address', '學校地址')->rules('required');

        $form->text('name', '負責老師')->rules('required');
        $form->text('subject', '負責科目')->rules('required');
        $form->text('phone', '聯絡電話')->rules('required');
        $form->text('email', '聯絡電郵')->rules('required');
        $form->switch('verified', '已驗證？')->states($states)->help('是否驗證');
        $form->switch('approved', '已核實？')->states($states)->help('是否核實');

        return $form;
    }
}
