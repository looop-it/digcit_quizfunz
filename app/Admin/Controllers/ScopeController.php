<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;

use App\Admin\Models\Scope;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class ScopeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '問題範籌';
    
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Scope());

        $grid->name('名稱')->ucfirst()->limit(30);
        $grid->questions('問題')->display(function ($questions) {
            $count = count($questions);

            return "<span class='label label-default'>{$count}</span>";
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
        $form = new Form(new Scope);

        $form->text('name', 'Name')->rules('required|min:2|max:255');
        
        return $form;
    }
}
