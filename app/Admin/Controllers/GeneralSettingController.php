<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Permission;

use App\Admin\Models\Company;
use App\Models\Season;

class GeneralSettingController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        // Permission::check('list_article');
        return Admin::content(function (Content $content) {
            $content->header('System Global Setting');
            $content->description('');

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
        Permission::check('general_setting');
        return Admin::content(function (Content $content) use ($id) {
            $content->header('System Global Setting');
            $content->description('edit');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    // public function create()
    // {
    //     Permission::check('create_article');
    //     return Admin::content(function (Content $content) {

    //         $content->header('header');
    //         $content->description('description');

    //         $content->body($this->form());
    //     });
    // }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Company::class, function (Grid $grid) {
            $grid->name('Company Name')->ucfirst()->limit(30);
            $grid->website_name('Website name');
            $grid->slogan('Slug');
            

            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });

            // -------Grid基本設置-------
            $grid->disableExport();
            $grid->disableCreation();
            $grid->disablePagination();
            $grid->disableFilter();

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
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
        return Admin::form(Company::class, function (Form $form) {
            $form->tab('General', function ($form) {
                $form->text('name', '公司名稱')->rules('required|min:2|max:255');
                $form->text('website_name', '網站名稱')->rules('required|min:2|max:255');
                $form->text('slogan', 'Slug');
                $states = [
                    'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
                ];
                $form->switch('rank_status', '顯示排行榜')->states($states)->default(false);
                $form->select('ranking_season', '排行榜顯示賽季')->options(function () {
                    $seasons = Season::whereIn('status', ['open', 'closed'])->get();
                
                    if ($seasons) {
                        return $seasons->pluck('name', 'id')->toArray();
                    }
                });
                $form->text('total_number', '接觸人數')->default(0);
            })->tab('DashBoard', function ($form) {
                $form->switch('quick_launch', 'Quick Launch')->help('Display quick launch buttons in DashBoard');
                $form->switch('ga_chart', 'GA Charts')->help('Display Google Analytics Charts in DashBoard');
                $form->number('ga_chart_period', 'Chart Period')->rules('numeric|min:1|max:90')->help('Set last period days for Google Analytics Charts');
            })->tab('Contact', function ($form) {
                $form->mobile('phone_number', 'TEL');
                $form->mobile('fax_number', 'FAX');
                $form->text('address', 'Address');
                $form->divide();
                $form->email('email');
                $form->email('contact_email');
                $form->email('sales_email');
                $form->email('support_email');
            })->tab('App Info', function ($form) {
                $form->url('android_app_url', 'Android App Url');
                $form->url('ios_app_url', 'iOS app url');
                $form->url('app_info_url', 'App description page');
            })->tab('EDM', function ($form) {
                $form->text('edm_from_name', 'From Name')->help('the mail sender show in user\'s mail box');
                $form->email('edm_reply_to', 'Reply To')->help('the mail address that user can reply back');
                $form->text('edm_test_mail', 'Test Mail')->help('mail address for revcive testing mail');
                $form->divide();
                $form->rate('edm_report_threshold1', 'Threshold1')->options(['max' => 100, 'min' => 1, 'step' => 1, 'postfix' => '%'])->help('<span class="label label-danger">======process bar======</span> Open rate less than this ');
                $form->rate('edm_report_threshold2', 'Threshold2')->options(['max' => 100, 'min' => 1, 'step' => 1, 'postfix' => '%'])->help('<span class="label label-warning">======process bar======</span> More than Threshold1 and less than this');
                $form->rate('edm_report_threshold3', 'Threshold3')->options(['max' => 100, 'min' => 1, 'step' => 1, 'postfix' => '%'])->help('<span class="label label-info">======process bar======</span> More than Threshold2 and less than this, or <span class="label label-success">======process bar======</span>');
            })->tab('SEO', function ($form) {
                $form->text('keywords');
                $form->text('description');
                $form->textarea('ga_code', 'Google Analytics Code');
            })->tab('API', function ($form) {
                $form->url('facebook', 'Facebook');
                $form->text('facebook_app_id', 'Facebook AppID');
                $form->url('twitter', 'Twitter');
                $form->text('google_maps_key_api');
            })->tab('About Us', function ($form) {
                $form->ckeditor('about_us', 'About us');
            })->tab('Privacy Policy', function ($form) {
                $form->ckeditor('privacy_policy', 'Privacy Policy');
            })->tab('Terms & Condition', function ($form) {
                $form->ckeditor('terms_of_service', 'Terms & Condition');
            })->tab('Sponsor Images', function ($form) {
                $form->image('sponsor_image', 'Image for desktop')->uniqueName()->help('size:200x200,type:jpg/png')->dir('sponsor');
                $form->image('sponsor_image_mobile', 'Image for mobile')->uniqueName()->help('size:200x200,type:jpg/png')->dir('sponsor');
                $form->text('sponsor_page_url', 'Sponsor page URL');
            })->tab('pop-up message', function ($form) {
                $states = [
                    'on'  => ['value' => 1, 'text' => 'active', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => 'inactive', 'color' => 'default'],
                ];
                $form->switch('pop_up_status', 'rank Status')->states($states)->default(1);
                $form->ckeditor('pop_up_content', 'Pop up content');
            });

            // $form->saved(function (Form $form) {
            //     if ($form->ga_chart == 'on') {
            //         dispatch(new FetchUVPV($form->ga_chart_period));
            //     }
            //     // debug($form);
            //     // return redirect('/general-setting/1/edit');
            // });
        });
    }
}
