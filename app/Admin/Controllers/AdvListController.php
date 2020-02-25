<?php

namespace App\Admin\Controllers;

use App\Admin\Models\AdvList;
use App\Admin\Models\AdvType;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Permission;
use App\Admin\Extensions\Tools\AdvSelect;
use Carbon\Carbon;

class AdvListController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        Permission::check('manage_ad_type');
        return Admin::content(function (Content $content) {
            $content->header('AdvList');
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
        Permission::check('manage_ad_type');
        return Admin::content(function (Content $content) use ($id) {
            $content->header('Advertisement');
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
        Permission::check('manage_ad_type');
        return Admin::content(function (Content $content) {
            $content->header('Advertisement');
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
        return Admin::grid(AdvList::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID');
            $grid->title('Caption')->editable();
            $grid->type()->title('Position');
            $grid->url('Preview')->display(function ($value) {
                if (!empty($value)) {
                    $img_prefix= env('CDN_URL');
                    $modal=<<<EOT
<button type="button" class="btn btn-success" data-toggle="modal" data-target=".preview{$this->id}">Preview</button>
<div class="modal preview{$this->id}" tabindex="-1" >
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <h3>{$this->title}</h3>
        <a href="{$this->url}" target=_blank><img style="width:400px;height:auto" src="{$img_prefix}/{$this->image_path}" alt=""></a>
    </div>
  </div>
</div>
EOT;
                    return $modal;
                } else {
                    return "<button type='button' class='btn btn-default'>none</button>";
                }
            });
            $grid->start_date('Start Date');
            $grid->end_date('End Date');
            $grid->hits('Hits');
            $states = [
                'on'  => ['value' => 1, 'text' => 'Online', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'Offline', 'color' => 'default'],
            ];

            $grid->column('Status')->switchGroup([
                'status' => 'Status'
            ], $states);

            // $grid->updated_at();

            // -------Grid基本設置-------
            $grid->disableExport();
            $grid->perPages([10, 20, 30, 40, 50]);

            $grid->filter(function ($filter) {
                // 禁用id查询框
                $filter->disableIdFilter();
                // sql: ... WHERE `user.name` LIKE "%$name%";
                $filter->like('title', 'Search');
                $filter->equal('type_id', 'Position')->select(AdvType::where('status', 1)->pluck('title', 'id'));
            });

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });

                $tools->append(new AdvSelect());
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
        return Admin::form(AdvList::class, function (Form $form) {

            
            // $form->display('id', 'ID');
            $form->text('title', 'Caption')->rules('required|min:2|max:50');
            $form->text('remark', 'Remark');
            $form->select('type_id', 'Position')->options(AdvType::selectOptions())->rules('required|min:1');

            $form->text('url', 'URL');
            $states = [
                'on'  => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'No', 'color' => 'default'],
            ];
            $form->switch('target', 'Open new window')->states($states);

            $form->image('image_path', 'Image')->uniqueName()->help('type:jpg/png')->dir('promotion/'.date('Ymd', time()));
            $states = [
                'on'  => ['value' => 1, 'text' => 'Online', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'Offline', 'color' => 'default'],
            ];
            $form->switch('status', 'Status')->states($states);
            $form->datetime('start_date', 'Start Date')->default(Carbon::now())->rules('required');
            $form->datetime('end_date', 'End Date')->default(Carbon::now())->rules('required');
            // $form->display('created_at', 'Created At');
            // $form->display('updated_at', 'Updated At');

        });
    }
}
