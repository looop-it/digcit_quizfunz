<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Admin\Models\Question;
use App\Admin\Models\QuestionCategory;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Scope;

class QuestionController extends Controller
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
            $content->header('賽題');
            $content->description('管理');

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
            $content->header('賽題');
            $content->description('編輯');

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
            $content->header('賽題');
            $content->description('新建');

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
        return Admin::grid(Question::class, function (Grid $grid) {
            $grid->id('ID');
            $grid->name('題目');
            $grid->answers('答案')->display(function ($answers) {
                $answers_list = '<ul>';
                if (count($answers)) {
                    foreach ($answers as $answer) {
                        $correct = ($answer['correct']) ? 'text-success' : 'text-danger';
                        $answers_list = $answers_list."<li class={$correct}>{$answer['content']}</li>";
                    }
                }

                return $answers_list.'</ul>';
            });
            $grid->category()->name('分類')->label('default');
            $grid->scope()->name('範籌')->label('default');
            $grid->level('難度')->display(function ($value) {
                $levelText = ['1' => '淺', '2' => '中', '3' => '難'];

                return $levelText[$value];
            })->label('default')->sortable();
            $grid->status('是否啟用')->switch();
            $grid->hit('題目採用率%')->badge('gray')->sortable();
            $grid->correct_rate('答題正確率%')->badge('gray')->sortable();

            // $grid->created_at('建立時間');

            $grid->filter(function ($filter) {
                // $filter->useModal();
                // 禁用id查询框
                $filter->disableIdFilter();
                // $filter->like('email','Search by email account');
                $filter->where(function ($query) {
                    $query->where('name', 'like', "%{$this->input}%")
                        ->orWhere('description', 'like', "%{$this->input}%");
                }, 'Search');
                // $filter->is('role', 'Role')->select(['person'=>'person','business'=>'business','person'=>'person']);
                $filter->equal('category_id', 'Category')->select(QuestionCategory::all()->pluck('name', 'id'));
                $filter->equal('scope_id', 'Scope')->select(Scope::all()->pluck('name', 'id'));
                // $filter->between('created_at', 'Registration time')->datetime();
            });

            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->exporter('CsvExporter');
            // -------Grid基本設置-------
            $grid->disableRowSelector();
            $grid->disableExport();
            //   $grid->disableCreateButton();
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
        return Admin::form(Question::class, function (Form $form) {
            $form->text('name', '問題名稱')->rules('required|min:2|max:255');

            $form->select('category_id', '分類')
                ->options(QuestionCategory::all()->pluck('name', 'id'))
                ->rules('required|numeric|min:1', ['min' => 'Please select the question category']);

            $form->select('scope_id', '範疇')
                ->options(Scope::all()->pluck('name', 'id'))
                ->rules('required|numeric|min:1', ['min' => 'Please select the scope']);

            $form->select('level', '難度')->options(['1' => '淺', '2' => '中', '3' => '難'])->rules('required|numeric|min:1', ['min' => 'Please select the level']);
            $form->switch('status', '狀態');
            $form->text('description', '備註');

            $form->hasMany('answers', 'Answers', function (Form\NestedForm $form) {
                $form->text('content', 'Content')->placeHolder('賽題答案');

                $states = [
                    'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'NO', 'color' => 'default'],
                ];
                $form->switch('correct', 'Correct')->states($states);
            });

            // 在表单提交前调用
            $form->submitted(function (Form $form) {
                $post = Input::all();
                $is_status = '';
                if (count($post) == 3) {
                    if ($post['_method'] == 'PUT') {
                        $is_status = true;
                    }
                }

                if (!$is_status) {
                    if (!isset($post['answers'])) {
                        $error = new MessageBag([
                            'title' => '必須填寫答案',
                            //  'message' => 'message....',
                        ]);

                        return back()->withInput()->with(compact('error'));
                    }

                    if (count($post['answers']) < 3) {
                        $error = new MessageBag([
                            'title' => '至少3個答案',
                            // 'message' => 'message....',
                        ]);

                        return back()->withInput()->with(compact('error'));
                    }
                    $a = '';
                    foreach ($post['answers'] as $key => $v) {
                        if ($v['correct'] == 'on') {
                            $a = 'ok';
                        }
                    }
                    if ($a != 'ok') {
                        $error = new MessageBag([
                            'title' => '至少有一個個答案是正確的',
                            // 'message' => 'message....',
                        ]);

                        return back()->withInput()->with(compact('error'));
                    }
                }
            });

            $form->saved(function ($form) {
                $success = new MessageBag([
                    'title' => '保存成功',
                    // 'message' => 'message....',
                ]);
                // use redirect() instead of back(), to stay edit from create.
                return redirect(route('questions.edit', [$form->model()->id]))->with(compact('success'));
            });
        });
    }
}
