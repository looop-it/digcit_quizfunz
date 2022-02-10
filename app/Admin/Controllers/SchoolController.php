<?php

namespace App\Admin\Controllers;

use App\Admin\Models\School;
use App\Jobs\GenerateSchoolCode;
use App\Jobs\SendSchoolCode;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Support\MessageBag;

class SchoolController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '學校';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new School());

        $grid->id('ID');
        $grid->name('學校名')->label('success');
        // $grid->type('類型')->display(function () {
        //     if (isset(School::$type[$this->type])) {
        //         return School::$type[$this->type];
        //     } else {
        //         return '未指定';
        //     }
        // });

        $grid->approved('是否已核實？')->display(function ($approved) {
            return ($approved) ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
        });

        $grid->student('學生人數')->badge('gray');
        $grid->actual_participant('實際參賽人數')->badge('green');

        $grid->actions(function ($actions) {
            if (!Admin::user()->isRole('project.manager') && !Admin::user()->can('school.edit')) {
                $actions->disableEdit();
            }

            // if (!Admin::user()->isRole('project.manager') && !Admin::user()->can('school.delete')) {
            $actions->disableDelete();
            // }
        });

        $grid->tools(function ($tools) {
            if (!Admin::user()->isRole('project.manager')) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            }
        });

        $grid->filter(function ($filter) {
            // $filter->useModal();
            // 禁用id查询框
            $filter->disableIdFilter();
            // $filter->like('email','Search by email account');
            $filter->where(function ($query) {
                $query->where('name', 'like', "%{$this->input}%");
            }, '學校名稱');
        });

        if (!Admin::user()->isRole('project.manager')) {
            $grid->disableExport();
            $grid->disableRowSelector();
        }

        // if (!Admin::user()->isRole('project.manager') && !Admin::user()->can('school.create')) {
        $grid->disableCreateButton();
        // }

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new School());

        $form->tab('學校資料', function ($form) {
            $boolean = [
                'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'NO', 'color' => 'default'],
            ];

            $form->text('name', '學校名稱')->rules('required|min:2|max:255');

            // $form->text('fax', 'Fax');
            // $form->number('student', '學生人數')->rules('required|numeric|min:1');
            // $form->number('expected_participant', '預期參賽人數')->rules('required|numeric|min:1');

            $form->display('code', '上傳學生名單驗證碼')->help('系統自動產生，不可手動修改');
            $form->switch('approved', '已核實？')->states($boolean)->help('是否核實');
        });

        // $form->saved(function (Form $form) {
        //     if (!$form->model()->code) {
        //         dispatch(new GenerateSchoolCode($form->model()));

        //         sleep(1);
        //     } else {
        //         if ($form->model()->approved) {
        //             dispatch(new SendSchoolCode($form->model()));
        //         }
        //     }

        //     $success = new MessageBag([
        //         'title' => '保存成功',
        //     ]);

        //     return redirect(route('schools.edit', [$form->model()->id]))->with(compact('success'));
        // });

        return $form;
    }
}
