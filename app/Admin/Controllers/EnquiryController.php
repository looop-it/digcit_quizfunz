<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Enquiry;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class EnquiryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '查詢';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Enquiry());
        
        $grid->model()->orderBy('id', 'desc');
        
        $grid->id('ID')->sortable();
        $grid->name('姓名');
        $grid->enquiry('查詢內容')->style('max-width: 200px; overflow-wrap: anywhere; white-space:inherit;');
        $grid->school_name('學校名稱');
        $grid->tel('聯絡電話');
        $grid->email('聯絡電郵');
        $grid->status('狀態')->editable('select', ['new' => '新查詢', 'processed' => '已處理', 'closed' => '關閉']);

        $grid->created_at();

        $grid->disableCreateButton();

        $grid->filter(function ($filter) {
            // Remove the default id filter
            $filter->disableIdFilter();
        

            $filter->equal('status', '狀態')->select([
                'new' => '新查詢',
                'processed' => '已處理',
                'closed' => '已關閉'
            ]);
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
        $form = new Form(new Enquiry);

        $form->display('id', 'ID');
        $form->display('name', '姓名');
        $form->display('school_name', '學校名稱');
        // $form->display('capacity', 'Capacity');
        $form->display('tel', '聯絡電話');
        $form->display('email', '聯絡電郵');
        $form->display('enquiry', '查詢內容');
        $form->select('status', '狀態')->options([
            'new' => '新查詢',
            'processed' => '已處理',
            'closed' => '關閉',
        ]);

        return $form;
    }
}
