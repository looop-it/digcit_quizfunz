<?php

namespace App\Admin\Controllers;

use App\Models\Paper;
use App\Models\School;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class StudentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '學生登記';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->model();

        $grid->id('ID');
        $grid->email('電郵地址');
        $grid->verified('已驗證?')->display(function ($verified) {
            // return $verified ? '是' : '否';
            return ($verified) ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
        });

        $grid->participant()->name('姓名');

        $grid->participant()->school_id('學校名稱')->display(function ($school_id) {
            $school = School::find($school_id);

            if ($school) {
                return $school->name;
            }

            return null;
        });

        // $grid->participant()->grade('年級');
        // $grid->participant()->class('班別');

        $grid->column('完成答題卷')->display(function () {
            return Paper::where([
                ['participant_id', $this->participant['id']],
                ['status', 'finished'],
            ])->count();
        });

        $grid->filter(function ($filter) {
            // 禁用id查询框
            $filter->disableIdFilter();

            $filter->like('email', '電郵地址');

            $filter->where(function ($query) {
                $query->whereHas('participant', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });
            }, '姓名');

            $filter->where(function ($query) {
                $query->whereHas('participant', function ($query) {
                    $query->where('school_id', $this->input);
                });
            }, '學校')->select(School::approved()->get()->pluck('name', 'id'));

            $filter->between('created_at', '登記時間')->datetime();
        });

        $grid->actions(function ($actions) {
            if (!Admin::user()->can('student.delete')) {
                $actions->disableDelete();
            }
        });

        if (!Admin::user()->can('student.create')) {
            $grid->disableCreateButton();
        }

        if (!Admin::user()->can('student.export')) {
            $grid->disableExport();
        }

        $grid->export(function ($export) {
            $export->filename('participants_export.csv');

            // $export->only(['id', 'participant.name', 'email', 'verified', 'participant.school.name']);

            // $export->originalValue(['column1', 'column2' ...]);

            $export->column('verified', function ($value, $original) {
                return $original ? 'Yes' : 'No';
            });
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
        $form = new Form(new User());

        $form->tab('帳號', function ($form) {
            $form->email('email', '電郵')->rules('required|email');
            $form->text('name', '暱稱');
            $form->mobile('mobile', '聯絡電話')->options(['mask' => '99999999']);
        })->tab('參賽資料', function ($form) {
            $form->text('participant.name', '姓名');
            $form->select('participant.school_id', '學校')->options(function () {
                return School::approved()->get()->pluck('name', 'id');
            })->rules('required');
            $form->text('participant.grade', '年級');
            $form->text('participant.class', '班級');
        });

        return $form;
    }
}
