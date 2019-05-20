<?php

namespace App\Admin\Controllers\Orders;

use App\Http\Controllers\Controller;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Order;

class PreOrderController extends Controller
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
            ->title('title')
            ->status('status')
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
        $grid = new Grid(new Order);

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
            $actions->disableEdit();
            $actions->prepend('<a href="/admin/order/' . $actions->getKey()  . '"' . '><i class="fa fa-eye"></i></a>');
        });
        $grid->model()->where('has_pre_order', 1);

        $grid->id('Id');
        $grid->user()->name('Customer');
        $grid->unique_id('Order');
    
        $grid->delivery_charges('Delivery charges');
        $grid->total('Total');
        $grid->is_paid('Is paid')->display(function ($field) {
            if ($field) {
                return '<span class="badge badge-success">Payed</span>';
            }
            return '<span class="badge badge-danger">Not Payed</span>';
        });
        $grid->payment_method('Payment method')->display(function ($field) {
            switch ($field) {
                case Order::KNET_PAYMENT_METHOD:
                    return '<span class="badge badge-primary">Knet</span>';
                case Order::CASH_ON_DELIVERY_PAYMENT_METHOD:
                    return '<span class="badge badge-primary">Cash</span>';
                case Order::MASTER_PAYMENT_METHOD:
                    return '<span class="badge badge-primary">MasterCard</span>';
                case Order::VISA_PAYMENT_METHOD:
                    return '<span class="badge badge-primary">Visa Card</span>';
            }
            return '';
        });
        $grid->shippingMethod()->title_en('Shipping method');
        $grid->order_date('Order date');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->id('ID');

        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);

        return $form;
    }
}
