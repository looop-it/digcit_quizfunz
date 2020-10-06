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

            $grid->id('ID')->sortable();
            $grid->name('Name');
            $grid->school_name('School');
//            $grid->capacity('Capacity');
//            $grid->tel('Phone');
//            $grid->email('Email');
            $grid->enquiry('Enquiry');
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
            $form->display('name', 'Name');
            $form->display('school_name', 'School');
            $form->display('capacity', 'Capacity');
            $form->display('tel', 'Phone');
            $form->display('email', 'Email');
            $form->display('enquiry', 'Enquiry');

        });
    }

}
