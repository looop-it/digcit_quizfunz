<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Admin\Models\QuestionCategory;
use App\Admin\Models\Question;

class QuestionCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '問題類別';

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $content->body($this->grid());
        $content->body($this->difficultyGrid());

        return $content;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new QuestionCategory());

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
        $form = new Form(new QuestionCategory);

        $form->text('name', '分類名稱')->rules('required|min:2|max:255');

        return $form;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function difficultyGrid()
    {
        return Admin::grid(Question::class, function (Grid $grid) {
            $grid->model()->selectRaw('level, count(1) as questions')->groupBy('level');

            $grid->column('ID')->display(function () {
                return $this->level;
            });

            $grid->level('難度')->display(function ($value) {
                $levelText = [
                    '1' => '淺',
                    '2' => '中',
                    '3' => '難',
                    '4' => '未設定'
                ];

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
