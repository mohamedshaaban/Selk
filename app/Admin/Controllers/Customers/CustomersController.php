<?php

namespace App\Admin\Controllers\Customers;

use App\Http\Controllers\Controller;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Tag;
use App\Models\Countries;
use App\Models\Provience;
use Encore\Admin\Admin;
use App\User;

class CustomersController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */

    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->id('ID')->sortable();
        $grid->name('Name')->sortable();
        $grid->email('Email')->sortable();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $ide
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->id('ID')->sortable();
        $show->name('Name')->sortable();
        $show->email('Email')->sortable();

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */

    protected function form()
    {
        $form = new Form(new User);
        $form->tab('Customer Information', function ($form) {
            /** @var Form $form */
            $form->text('name', 'English')->required();;
            $form->text('first_name', 'First Name')->required();;
            $form->text('last_name', 'Last Name')->required();;
            $form->text('email', 'Email')->required();;
            $form->password('password')->default(function ($form) {
                return $form->model()->password;
            })->required();

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });
            $form->radio('is_active', 'Active')->options(['0' => 'No', '1' => 'Yes']);
            $form->radio('email_notification', 'email notification')->options(['0' => 'No', '1' => 'Yes']);
            $form->radio('sms_notification', 'sms notification')->options(['0' => 'No', '1' => 'Yes']);
        })->tab('User Address', function ($form) {
            $form->hasMany('useraddress', 'user Address', function (Form\NestedForm $form) {
                $form->text('user_label', 'user label');
                $form->text('address_type', 'address type');
                $form->text('first_name', 'first name');
                $form->text('last_name', 'last name');
                $form->select('governorate_id', 'governorate_id')->options(Countries::all()->pluck('title_en', 'id'))->rules('required');
                $form->select('province', 'Province')->options(Provience::all()->pluck('title_en', 'id'))->rules('required');
                $form->text('post_code', 'post code');
                $form->text('first_address', 'first_address');
                $form->text('second_address', 'second_address');
                $form->text('mobile_no', 'mobile_no');
                $form->text('phone_no', 'phone_no');
                $form->text('is_default', 'is_default');
            });
        });
        return $form;
    }
}
