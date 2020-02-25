<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Tab;
use Illuminate\Http\Request;
use Encore\Admin\Auth\Permission;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

use App\Models\School;
use App\Models\Participant;
use App\Helpers\Utility;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Paper;

class ParticipantController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        Permission::check('student.view');

        return Admin::content(function (Content $content) {
            $content->header('學生');
            $content->description('management');

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
        Permission::check('student.edit');

        return Admin::content(function (Content $content) use ($id) {
            $content->header('學生');
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
        Permission::check('student.create');

        return Admin::content(function (Content $content) {
            $content->header('學生');
            $content->description('create');

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
        return Admin::grid(User::class, function (Grid $grid) {
            $grid->model()->competition();
            
            $grid->id('ID');
            $grid->email('電郵地址');
            $grid->verified('已驗證?')->display(function ($verified) {
                // return $verified ? '是' : '否';
                return ($verified) ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
            });

            $grid->participant()->name("姓名");

            $grid->participant()->school_id("學校名稱")->display(function ($school_id) {
                $school = School::find($school_id);

                if ($school) {
                    return $school->name;
                }

                return null;
            })->label('success');

            $grid->participant()->grade('班級');
            $grid->participant()->class('年級');

            $grid->column('完成答題卷')->display(function () {
                return Paper::where([
                    ['participant_id', $this->participant['id']],
                    ['status', 'finished']
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

            $grid->disableRowSelector();
            $grid->disableExport();
            
            $grid->perPages([10, 20, 30, 40, 50]);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {
            $form->tab('帳號', function ($form) {
                $form->email('email', '電郵')->rules('required|email');
                $form->text('name', '暱稱');
                $form->mobile('mobile', '聯絡電話')->options(['mask' => '99999999']);
                $form->select('gender', '性別')->options([
                    'm' => '男',
                    'f' => '女'
                ]);
                $form->date('birthday', '出生年月')->format('YYYY-MM');
            })->tab('參賽資料', function ($form) {
                $form->text('participant.name', '姓名');
                $form->select('participant.school_id', '學校')->options(function () {
                    return School::approved()->get()->pluck('name', 'id');
                })->rules('required');
                $form->text('participant.grade', '年級');
                $form->text('participant.class', '班級');
            });

            $form->saving(function ($form) {
                $form->birthday = "{$form->birthday}-01";
            });

            $form->saved(function ($form) {
                $success = new MessageBag([
                    'title'   => '保存成功',
                ]);

                return redirect(route('students.edit', [$form->model()->id]))->with(compact('success'));
            });
        });
    }
}
