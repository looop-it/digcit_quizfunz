<?php

namespace App\Admin\Controllers;

use Carbon\Carbon;
use App\Admin\Models\Feature;
use App\Admin\Models\Post;
use App\Admin\Models\FeaturePost;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Permission;
use App\Admin\Extensions\Tools\PromoSelect;

class FeaturePostsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        Permission::check('manage_promo_articles');
        return Admin::content(function (Content $content) {
            $content->header('Promoted Articles');
            $content->description('management');
            $content->body($this->grid());
            // $content->body(FeaturePosts::tree());
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
        Permission::check('manage_promo_articles');
        return Admin::content(function (Content $content) use ($id) {
            $content->header('Promoted Articles');
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
        Permission::check('manage_promo_articles');
        return Admin::content(function (Content $content) {
            $content->header('Promoted Articles');
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
        return Admin::grid(FeaturePost::class, function (Grid $grid) {
            if (empty(request('feature_id'))) {
                $grid->model()->where('feature_id', Feature::where('status', 1)->first()->id);
            }
           /* $grid->model()->ordered();*/
            $grid->feature()->title('Promotion Type');
            $grid->column('caption', 'Articles Caption(Customize)')->editable();
            // $grid->
            $grid->start_date('Start Date')->editable("datetime");
            $grid->end_date('End Date')->editable("datetime");
            $grid->order('Ordering')->orderable();
            // $grid->id('Id');
            

            // -------Grid基本設置-------
            $grid->disableExport();
            $grid->disableCreation();
            $grid->perPages([10, 20, 30, 40, 50]);
            $grid->actions(function ($actions) {
                // $actions->disableEdit();
                if (!Admin::user()->can('delete_article')) {
                    $actions->disableDelete();
                }
            });

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });

                $tools->append(new PromoSelect());
            });

            

            $grid->filter(function ($filter) {
                // 禁用id查询框
                $filter->disableIdFilter();
                // sql: ... WHERE `user.name` LIKE "%$name%";
                $filter->equal('feature_id', 'Filter by Type')->select(Feature::where('status', 1)->pluck('title', 'id'));
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(FeaturePost::class, function (Form $form) {
            $form->display('feature.title', 'Promotion Type');
            $form->text('caption', 'Custom Caption')->placeHolder('Customize Title, leave it blank will same as article caption');
            $form->image('cover_image', 'Custom Cover Image')->uniqueName()->fit(800, 800)->help('size:800x800,type:jpg/png')->dir('articles/promotion_cover/'.date('Ymd', time()));
            $form->datetime('start_date', 'Start date')->default(Carbon::now());
            $form->datetime('end_date', 'End date')->default(Carbon::now()->addWeeks(1));
        });
    }
}
