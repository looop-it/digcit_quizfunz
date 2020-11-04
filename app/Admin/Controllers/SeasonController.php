<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Cache;

use App\Admin\Models\Season;
use Carbon\Carbon;

class SeasonController extends AdminController
{
    const STATUS_NAME = [
        'ready' => '準備中',
        'open' => '開放',
        'closed' => '已完結',
        'cancelled' => '已取消',
    ];
    
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '賽季';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Season());

        $grid->id('ID');
        $grid->name('賽季名稱');
        $grid->status('狀態')->display(function ($status) {
            if ($status == 'open') {
                return "<label class='label label-success'>".self::STATUS_NAME[$status].'</label>';
            }

            return "<label class='label label-default'>".self::STATUS_NAME[$status].'</label>';
        });

        $grid->start_at('開始時間');
        $grid->end_at('結束時間');

        $grid->is_intercollegiate('是否校際賽')->display(function ($is_intercollegiate) {
            if ($is_intercollegiate) {
                return "<label class='label label-success'>是</label>";
            }

            return '否';
        });

        $grid->column('參加人數')->display(function () {
            return $this->participants;
        });

        $grid->created_at('創建時間');

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();

            $filter->where(function ($query) {
                $query->where('name', 'like', "%{$this->input}%");
            }, '名稱');

            $filter->between('created_at', '建立時間')->datetime();
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
        $form = new Form(new Season);

        $form->tab('賽季詳情', function ($form) {
            $form->text('name', '名稱')->rules('required|min:2|max:255');
            $form->select('status', '狀態')->options(
                self::STATUS_NAME
            );

            $states = [
                'on' => ['value' => 1, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
            ];

            $form->switch('is_intercollegiate', '是否校際賽')->states($states);

            $form->text('times_limit', '參賽次數')->rules('required|numeric|min:1')->help('本賽季可參賽次數');
            $form->text('daily_times_limit', '每日參賽次數')->rules('required|numeric|min:1')->help('每日可參賽次數');
            $form->text('time_interval', '參賽間隔')->rules('required|numeric|min:0')->help('參賽時間間隔（分鐘）');
            $form->datetime('start_at', '開始時間')->default(Carbon::now());
            $form->datetime('end_at', '結束時間')->default(Carbon::now()->addWeeks(1));
        })->tab('比賽時間', function ($form) {
            $form->checkbox('enable_days', '開放日子')->options([
                1 => '星期一',
                2 => '星期二',
                3 => '星期三',
                4 => '星期四',
                5 => '星期五',
                6 => '星期六',
                7 => '星期日',
            ]);
            $form->timeRange('day_start_time', 'day_end_time', '開放時間');
        })->tab('試卷設定', function ($form) {
            $form->text('general_questions', '通用題目')->rules('required');
            $form->text('other_questions', '類別題目')->rules('required')->help('總題目 = 通用題目 + 類別題目 x (9+2)');
            $form->text('difficulty', '難度')->rules('required')->help('總題目 x 1 ~ 總題目 x 3');
            $form->text('difficulty_offset', '難度偏移')->rules('required');
            $form->text('question_time_limit', '題目限時')->rules('required')->help('每題答題時間（秒）');
            $form->text('paper_time_limit', '試卷限時')->rules('required')->help('總題目 x 題目限時（秒）');
        });

        $form->saved(function ($form) {
            // Clear current season cache.
            Cache::forget('current_season');
        });

        return $form;
    }
}
