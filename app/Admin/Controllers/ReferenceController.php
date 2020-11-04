<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;

use App\Admin\Models\Reference;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;

use Encore\Admin\Auth\Permission;

class ReferenceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '參考資料';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Reference());
        
        $grid->model()->orderBy('id', 'desc');

        $grid->id("#");
        $grid->name('Name')->ucfirst()->limit(30);

        $states = [
            'on' => ['text' => 'active'],
            'off' => ['text' => 'inactive'],
        ];

        $grid->column('status', 'Status')->switchGroup([
            'status' => 'Status'
        ], $states);

        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
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
        $form = new Form(new Reference);
    
        $form->text('name', 'Name')->rules('required|min:2|max:255');
        //$form->text('author', 'Author')->rules('required|min:2|max:255');
        $form->image('cover_image', 'Cover')->uniqueName()->help('size:200x200,type:jpg/png')->dir('references');
        $form->text('link', 'Link');
        $form->textarea('desc', 'Desc');
        $states = [
                'on'  => ['value' => 1, 'text' => 'active', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'inactive', 'color' => 'default'],
            ];
        $form->switch('status', 'status')->states($states)->default(1);
        $form->ckeditor('content', 'Content');
        
        return $form;
    }
}
