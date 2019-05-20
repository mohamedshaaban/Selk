<?php

namespace App\Admin\Controllers\Promotions;

use App\Http\Controllers\Controller;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Tag;
use Encore\Admin\Admin;
use App\Models\ProductsTogetherPrice;
use App\Models\Product;

class PromotionsController extends Controller
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
            // ->title('title')
            // ->status('status')
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
        $grid = new Grid(new ProductsTogetherPrice);

        $grid->id('ID')->sortable();
        $grid->productWith()->name_en('Name');
        $grid->productBelong()->name_en('Name');

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
        $show = new Show(ProductsTogetherPrice::findOrFail($id));

        $show->id('ID')->sortable();
        $show->productWith()->name_en('Product 1');
        $show->productBelong()->name_en('Product 2');
        $show->price('price');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */

    protected function form()
    {
        $form = new Form(new ProductsTogetherPrice);
        $products = Product::all()->pluck('name_en', 'id');

        $form->select('product_id', 'product Name')->options($products)->required();
        $form->select('with_product_id', 'product Name')->options($products)->required();
        $form->number('price')->required();

        return $form;
    }


}
