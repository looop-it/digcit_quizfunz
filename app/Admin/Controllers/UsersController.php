<?php

namespace App\Admin\Controllers;

// use App\Admin\Models\Tags;
// use App\Admin\Models\Categories;
use App\Admin\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Tab;
use Illuminate\Http\Request;
use Encore\Admin\Auth\Permission;

// use App\Admin\Extensions\Tools\PublishPost;
// use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class UsersController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        Permission::check('manage_membership');
        return Admin::content(function (Content $content) {
            $content->header('User');
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
        Permission::check('manage_membership');
        return Admin::content(function (Content $content) use ($id) {
            $content->header('User');
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
        Permission::check('manage_membership');
        return Admin::content(function (Content $content) {
            $content->header('User');
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
        return Admin::grid(User::class, function (Grid $grid) {
            $grid->id('ID');
            $grid->name('Name');
            $grid->email('Email');
            $grid->login_at('Last login');
            $grid->login_ip('Last login ip');
            $grid->login_count('Login count');

            $grid->created_at('created_at');

            $grid->filter(function ($filter) {

                // $filter->useModal();
                // 禁用id查询框
                $filter->disableIdFilter();
                // $filter->like('email','Search by email account');
                $filter->where(function ($query) {
                    $query->where('name', 'like', "%{$this->input}%")
                        ->orWhere('email', 'like', "%{$this->input}%");
                }, 'Search');
                // $filter->is('role', 'Role')->select(['person'=>'person','business'=>'business','person'=>'person']);
                // $filter->is('author_id', '作者')->select(Author::where('status',1)->pluck('name', 'id'));
                $filter->between('created_at', 'Registration time')->datetime();
            });

            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });

            // -------Grid基本設置-------
            $grid->disableRowSelector();
            $grid->disableExport();
            $grid->disableCreateButton();
            $grid->perPages([10, 20, 30, 40, 50]);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {
            $columns = Schema::getColumnListing('users');
            // debug($columns);
            foreach ($columns as $column) {
                if ($column == 'features') {
                } elseif ($column == 'status') {
                    $form->select('status')->options([
                        'active' => 'active',
                        'inactive' => 'inactive',
                        'reviewing' => 'reviewing',
                        'terminated' => 'terminated',
                    ]);
                } else {
                    $form->display($column);
                }
            }
        });
    }
}
