<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;

use App\Admin\Models\Question;
use App\Admin\Models\QuestionCategory;
use App\Admin\Models\Scope;

class QuestionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '問題';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Question());

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

        $grid->disableExport();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Question);
        
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

        return $form;
    }
}
