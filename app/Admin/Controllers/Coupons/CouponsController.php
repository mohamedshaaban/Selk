<?php

namespace App\Admin\Controllers\Coupons;

use App\Http\Controllers\Controller;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Tag;
use Encore\Admin\Admin;
use App\Models\Coupon;

class CouponsController extends Controller
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
        $grid = new Grid(new Coupon);

        $grid->id('ID')->sortable();

        $grid->column('Percantage')->display(function () {
            return "<span>" . $this->percentage . "%" . "</span>";
        });

        $grid->column('total')->display(function () {
            return "<span>" . $this->fixed . " KD" . "</span>";
        });



        $grid->from('From Date');
        $grid->to('To Date');

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
        $show = new Show(Coupon::findOrFail($id));

        $show->id('ID')->sortable();
        $show->percentage('Percantage');
        $show->fixed('fixed price');
        $show->from('From Date');
        $show->to('To Date');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */

    protected function form()
    {
        $form = new Form(new Coupon);
        $form->text('name_en', 'Name English')->required();;
        $form->text('name_ar', 'Name Arabic')->required();;
        $form->text('code', 'Code')->required();;
        $form->number('percentage');
        $form->number('fixed', 'Fixed Price');
        $form->number('minimum_order', 'Minimum Order')->required();;

        $form->radio('is_fixed')->options(['0' => 'No', '1' => 'Yes'])->default(0);
        $form->date('from')->rules('required|date|after:yesterday');
        $form->date('to')->rules('required|date|after:from');
        $form->radio('status', 'Active')->options(['0' => 'No', '1' => 'Yes'])->default(1);

        return $form;
    }
}
