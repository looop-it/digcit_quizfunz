<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Enquiry;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;

class EnquiryController extends Controller
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

            $content->header('Enquiry');
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
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Enquiry');
            $content->description('management');

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

            $content->header('Enquiry');
            $content->description('management');

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
        return Admin::grid(Enquiry::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            
            $grid->id('ID')->sortable();
            $grid->name('姓名');
            $grid->enquiry('查詢內容');
            $grid->school_name('學校名稱');
            $grid->tel('聯絡電話');
            $grid->email('聯絡電郵');
            $grid->status('狀態')->editable('select', ['new' => '新查詢', 'processed' => '已處理', 'closed' => '關閉']);

            $grid->created_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Enquiry::class, function (Form $form) {

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

        });
    }

}
