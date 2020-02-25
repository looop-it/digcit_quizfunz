<?php

namespace App\Admin\Controllers;
use App\Admin\Models\CompetitionInfo;     
use App\Http\Controllers\Controller;  


use Encore\Admin\Form;  
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;

use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Tree;
use Encore\Admin\Auth\Permission;  

     

class CompetitionInfoController extends Controller
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
            Permission::check('manage_category');
            $content->header('CompetitonInfo');
            $content->description('management');

            $content->body(CompetitionInfo::tree());
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
        Permission::check('manage_category');
        return Admin::content(function (Content $content) use ($id) {
            $content->header('CompetitonInfo');
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
        return Admin::content(function (Content $content) {
            Permission::check('manage_category');
            $content->header('CompetitonInfo');
            $content->description('create');

            $content->body($this->form());
        });
    }

    protected function tree()
    {
        return CompetitionInfo::tree(function (Tree $tree) {
            $tree->branch(function ($branch) {
                return "{$branch['title']} - {$branch['title']} {$branch['status']}";
            });
        });
    }

    protected function form()
    {


        return Admin::form(CompetitionInfo::class, function (Form $form) {
             $form->display('id', 'ID');  
            $form->select('parent_id', 'Parent Category')->options(CompetitionInfo::selectOptions())->help('Please select ROOT if you want to create a 1st level category');
            $form->text('title', 'Category Name');
           $states = [
                    'on'  => ['value' => 1, 'text' => 'active', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'inactive', 'color' => 'default'],
                ];
			$form->number('order')->help('排序');  
            $form->switch('status', 'Status')->states($states)->default(1);      
            $form->editor('content');   
        });      

    }
  

  



}
