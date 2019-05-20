<?php

namespace App\Admin\Controllers\ShippingMethods;

use App\Http\Controllers\Controller;

use App\Models\ShippingSetting;
use App\Models\Countries;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Carbon\Carbon;
use Encore\Admin\Form\Builder;

class ShippingSettingsController extends Controller
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
            //            ->title('title')
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
        $grid = new Grid(new ShippingSetting);

        $grid->actions(function ($actions) use ($grid) {
            $actions->disableView();
        });

        $grid->id('ID')->sortable();
        $grid->title_en('Title');



        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(ShippingSetting::findOrFail($id));

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
        $form = new Form(new ShippingSetting);

        $form->display('id', 'ID');
        $form->select('country_id', 'Country')->options(Countries::pluck('title_en', 'id'))->required();
        $form->text('postal_code', 'postal code')->required();
        $form->text('city', 'city')->required();
        $form->text('street_line1', 'street address 1')->required();
        $form->text('street_line2', 'street address 2')->required();

        $form->text('contact_name', 'contact name')->required();
        $form->text('contact_phone', 'contact phone')->required();
        $form->text('contact_ext', 'contact phone ext')->required();
        $form->text('contact_email', 'contact email')->required();
        $form->text('contact_fax', 'contact fax');

        return $form;
    }
}
