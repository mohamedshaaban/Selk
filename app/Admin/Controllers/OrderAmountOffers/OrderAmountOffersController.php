<?php

namespace App\Admin\Controllers\OrderAmountOffers;

use App\Http\Controllers\Controller;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\OrderAmountOffer;

class OrderAmountOffersController extends Controller
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
        $grid = new Grid(new OrderAmountOffer);

        $grid->id('ID')->sortable();

        $grid->column('amount')->display(function () {
            return "<span>" . $this->amount . "</span>";
        });
        $grid->column('fixed')->display(function () {
            return "<span>" . $this->is_fixed == 1 ? 'yes' : 'no' . "</span>";
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
        $show = new Show(OrderAmountOffer::findOrFail($id));

        $show->id('ID')->sortable();
        $show->amount('amount');
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
        $form = new Form(new OrderAmountOffer);
        $form->number('amount')->required();
        $form->radio('is_fixed')->options(['0' => 'No', '1' => 'Yes'])->default(0);
        $form->date('from')->required();
        $form->date('to')->required();
        $form->radio('status', 'Active')->options(['0' => 'No', '1' => 'Yes'])->default(1);

        return $form;
    }
}
