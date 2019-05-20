<?php

namespace App\Admin\Controllers\Products;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Character;
use App\Models\Tag;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Supplier;
use App\Jobs\MoveProductImagesJob;
use App\Jobs\ProductAvailabilityNotificationJob;


class ProductsController extends Controller
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
            ->body($this->form($id)->edit($id));
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
        $grid = new Grid(new Product);

        $grid->actions(function ($actions) use ($grid) {
            $actions->disableView();
        });

        $grid->filter(function ($filter) {

            $filter->in('in_stock', 'stock')->multipleSelect([1 => 'in stock', 2 => 'out of stock']);
            $filter->like('slug_name', 'slug name');
            $filter->scope('is_active', 'active')->where('status', true);
            $filter->scope('not_active', 'not active')->where('status', false);
        });

        $grid->id('ID')->sortable();
        $grid->name_en('name_en');
        $grid->name_ar('name_en');

        $states = [
            'on' => ['value' => 0, 'text' => 'no', 'color' => 'danger'],
            'off' => ['value' => 1, 'text' => 'yes', 'color' => 'success'],
        ];
        $grid->status('Active')->switch($states);

        $states = [
            'on' => ['value' => 1, 'text' => 'yes', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'no', 'color' => 'danger'],
        ];
        $grid->is_new('New')->switch($states);
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
        $show = new Show(Product::findOrFail($id));

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
    protected function form($id = null)
    {
        $form = new Form(new Product);
        $form->tab('Product Informations', function ($form) {
            $form->display('id', 'ID');
            $form->text('name_en', 'Name English')->required();
            $form->text('name_ar', 'Name Arabic')->required();

            $brands = Brand::all()->pluck('name_en', 'id');
            $form->select('brand_id')->options($brands);

            $characters = Character::all()->pluck('name_en', 'id');
            $form->multipleSelect('characters')->options($characters);

            $categories = Category::all()->pluck('name_en', 'id');
            $form->multipleSelect('categories')->options($categories);

            $relatedProducts = Product::all()->pluck('name_en', 'id');
            $form->multipleSelect('relatedproducts', 'Related Products')->options($relatedProducts);

            $tags = Tag::all()->pluck('name_en', 'id');
            $form->multipleSelect('tags')->options($tags);

            $supplier = Supplier::all()->pluck('vend_name_en', 'id');
            $form->select('supplier_id')->options($supplier);

            $form->text('slug_name');
            $form->text('sku');
            $states = [
                'on'  => ['value' => 1, 'text' => 'enable', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'disable', 'color' => 'danger'],
            ];

            $form->switch('is_new', 'New')->states($states);
            $form->textarea('short_description_en')->required();
            $form->textarea('short_description_ar')->required();
            $form->textarea('description_en');
            $form->textarea('description_ar');
            $form->textarea('delivery_and_return_en');
            $form->textarea('delivery_and_return_ar');
            $form->textarea('description_ar');
            $form->number('price')->default(1)->required();
            $form->number('quantity')->default(1)->required();
            $form->number('minimum_order')->default(1)->help('keep it 0 if no minimum order')->required();
            $form->number('maxima_order')->default(1)->help('keep it 0 if no maxima order')->required();
            $form->number('height')->default(1);
            $form->number('weight')->default(1);
            $form->radio('is_featured')->options(['0' => 'no', '1' => 'yes']);
            $form->radio('status', 'active')->options(['0' => 'no', '1' => 'yes']);
            $form->radio('free_return')->options(['0' => 'no', '1' => 'yes']);
            $form->radio('in_stock', 'In Stock')->options(['0' => 'no', '1' => 'yes']);
            $form->radio('pre_order', "Pre Order")->options(['0' => 'no', '1' => 'yes']);
            $form->number('pre_order_days')->default(1);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        })->tab('Options', function ($form) use ($id) {
            $options = Option::with('optionValue')->get()->keyBy('id');
            $selected_options = [];
            if (!is_null($id)) {
                $selected_options = \DB::table('product_option_values')->where('product_id', $id)->get()->groupBy('option_id')->toArray();
            }
            $form->html($this->javascript($id ? 'edit' : 'create'));
            $form->hidden('options_json')->default(json_encode($options));
            $form->hidden('selected_options_json')->default(json_encode($selected_options));
            $form->html("<div class='empty_options_div'></div>");
            $form->html("<div class='add btn btn-success btn-sm add_new_option'>Add Option</div>");
            $form->html("<div class='add btn btn-danger btn-sm generate_option_btn pull-right'>Generate Options Table</div>");
            $form->html("<div class='generate_options_table'></div>");
        })->tab('Vend', function ($form) {
            $form->display('vend_id');
            $form->display('vend_supplier_price');
            $form->display('vend_price');
            $form->radio('vend_tracking_inventory')->options(['0' => 'no', '1' => 'yes']);
            $form->display('vend_updated_at');
        })->tab('images', function ($form) {
            $form->image('main_image', 'Image ')->move(Carbon::now()->year . '/products')->uniqueName()->required();
            $form->multipleImage('images')->move(Carbon::now()->year . '/products')->uniqueName();;
        });
        // productsTogetherPrice
        $form->saved(function ($form) {
            $this->afterSave($form);
        });

        return $form;
    }

    public function beforSave(Form $form)
    { }

    public function afterSave(Form $form)
    {
        $productModel = $form->model();
        if (request('main_image')) {
            MoveProductImagesJob::dispatch($productModel, true);
        }
        if (request('images')) {
            MoveProductImagesJob::dispatch($productModel, false);
        }

        ProductAvailabilityNotificationJob::dispatch($productModel);

        if (request()->options) {
            $options = request()->options;
            $optionsArray = [];
            $optionsValuesArray = [];
            foreach ($options as $option) {
                $optionsArray[] = [
                    'option_id' => $option['option_id'],
                    'product_id' => $productModel->id
                ];
                if (isset($option['option_values_ids'])) {
                    foreach ($option['option_values_ids'] as $optionValues) {
                        $optionsValuesArray[] = [
                            'product_id' => $productModel->id,
                            'option_id' => $option['option_id'],
                            'option_value_id' => $optionValues,
                            'price_combination' => json_encode(request()->options_price_combinations),
                        ];
                    }
                }
            }
            if (count($optionsArray)) {
                \DB::table('product_options')->where('product_id', $productModel->id)->delete();
                \DB::table('product_options')->insert($optionsArray);
            }
            if (count($optionsValuesArray)) {
                \DB::table('product_option_values')->where('product_id', $productModel->id)->delete();
                \DB::table('product_option_values')->insert($optionsValuesArray);
            }
        }
    }

    public function javascript($action)
    {
        return view('admin.products.option')
            ->with('action', $action)
            ->render();
    }

    protected function possibleCombos($groups, $prefix = '')
    {
        $result = array();
        $group = array_shift($groups);
        foreach ($group as $selected) {
            if ($groups) {
                $result = array_merge($result, $this->possibleCombos($groups, $prefix . $selected . ' '));
            } else {
                $result[] = $prefix . $selected;
            }
        }
        return $result;
    }

    public function generateOptionsTable(request $request)
    {
        $groups = $request->options;
        if (is_null($groups)) {
            return;
        }
        $arrayOptions = $this->possibleCombos($groups);

        return view('admin.products.generate_options_table')
            ->with([
                'arrayOptions' => $arrayOptions,
                'optionValues' => OptionValue::all()->keyBy('id')
            ]);
    }
}
