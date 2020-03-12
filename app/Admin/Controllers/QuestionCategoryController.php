<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Admin\Models\QuestionCategory;
use App\Admin\Models\Question;

class QuestionCategoryController extends Controller
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
            $content->header('問題分類');

            $content->body($this->grid());
            $content->body($this->difficultyGrid());
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
            $content->header('問題分類');
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
        return Admin::content(function (Content $content) {
            $content->header('問題分類');
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
        return Admin::grid(QuestionCategory::class, function (Grid $grid) {
            $grid->name('分類名稱');
            $grid->questions('問題')->display(function ($questions) {
                $count = count($questions);

                return "<span class='label label-default'>{$count}</span>";
            });

            $grid->filter(function ($filter) {
                $filter->disableIdFilter();

                $filter->where(function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                }, '名稱');
            });

            if (!Admin::user()->isAdministrator()) {
                $grid->actions(function ($actions) {
                    $actions->disableDelete();
                    $actions->disableEdit();
                    // $actions->disableView();
                });

                $grid->disableCreateButton();
                $grid->disableRowSelector();
                $grid->disableExport();
                $grid->disableFilter();

                $grid->tools(function ($tools) {
                    $tools->batch(function ($batch) {
                        $batch->disableDelete();
                    });
                });
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
        return Admin::form(QuestionCategory::class, function (Form $form) {
            $form->text('name', '分類名稱')->rules('required|min:2|max:255');
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function difficultyGrid()
    {
        $index = 0;

        return Admin::grid(Question::class, function (Grid $grid) {
            $grid->model()->selectRaw('level, count(1) as questions')->groupBy('level');

            $grid->column('ID')->display(function () {
                return $this->level;
            });

            $grid->level('難度')->display(function ($value) {
                $levelText = ['1' => '淺', '2' => '中', '3' => '難', '4' => '未設定'];

                return $levelText[$value];
            })->label('default')->sortable();

            $grid->questions('問題')->display(function ($questions) {
                return "<span class='label label-default'>{$questions}</span>";
            });

            // -------Grid基本設置-------
            $grid->disableCreateButton();
            $grid->disableFilter();
            $grid->disableExport();
            $grid->disableRowSelector();
            $grid->disableActions();
        });
    }
}
