<?php

namespace App\Admin\Controllers;

use App\Admin\Models\School;
use App\Admin\Models\SchoolRegistration;

use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;

use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\MessageBag;

class SchoolRegistrationController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('學校登記');
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
        return Admin::content(function (Content $content) use ($id) {
            $content->header('學校登記');
            $content->description('修改');

            $content->body($this->form('edit')->edit($id));
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
            $content->header('學校登記');
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
        return Admin::grid(SchoolRegistration::class, function (Grid $grid) {
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
                if (!Admin::user()->isRole('project.manager') && !Admin::user()->can('school.edit')) {
                    $actions->disableEdit();
                }

                if (!Admin::user()->isRole('project.manager') && !Admin::user()->can('school.delete')) {
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
                }, 'School Name');

                $filter->equal('type', 'Type')->select(['secondary' => '中學', 'university' => '大學']);
            });

            if (!Admin::user()->isRole('project.manager')) {
                $grid->disableExport();
                $grid->disableRowSelector();
            }

            if (!Admin::user()->isRole('project.manager') && !Admin::user()->can('school.create')) {
                $grid->disableCreation();
            }
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(SchoolRegistration::class, function (Form $form) {
            $states = [
                'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'NO', 'color' => 'default'],
            ];

            $form->select('school_id', '學校名稱')->options(
                School::approved()->ofType('secondary')->orderBy('id', 'asc')->pluck('name', 'id')
            );

            $form->text('name', '負責老師')->rules('required');
            $form->text('subject', '負責科目')->rules('required');
            $form->text('phone', '聯絡電話')->rules('required');
            $form->text('email', '聯絡電郵')->rules('required');
            $form->switch('verified', '已驗證？')->states($states)->help('是否驗證');
            $form->switch('approved', '已核實？')->states($states)->help('是否核實');
        });
    }
}
