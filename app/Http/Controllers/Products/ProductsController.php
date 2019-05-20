<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Option;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductsTogetherPrice;

use App\Models\Tag;
use Illuminate\Support\Carbon;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;

use App\Models\ProductAvailabilityNotification;
use App\Models\ProductOptionValues;
use App\Models\OptionValue;


class ProductsController extends Controller
{
    public function index(request $request)
    {
        $products = $this->filter($request);
        $options = Option::with('optionValue')->get();
        $categories = Category::with('subCategories')->get(); //all();
        $brands = Brand::all();
        $googleAds = app('settings')->get(['google_ads_1', 'google_ads_2', 'google_ads_3'])->first();

        return view('products.index')->with([
            'products' => $products,
            'options' => $options,
            'categories' => $categories,
            'brands' => $brands,
            'googleAds' => $googleAds

        ]);
    }

    public function show(request $request, $slug)
    {
        $product = Product::with([
            'offer', 'brand',
            'reviews', 'reviews.user',
            'relatedProducts',
            'relatedProducts.offer',
            'relatedProducts.options',
            'relatedProducts.optionValues',
            'options',
            'optionValues'
        ])->where('slug_name', $slug)->firstOrFail();

        $optionValues = $product->optionValues->groupBy('option_id');

        $productsGroup = ProductsTogetherPrice::with(
            [
                'productWith',
                'productBelong',
                'productBelong.options',
                'productBelong.optionValues',
                'productWith.options',
                'productWith.optionValues'
            ]
        )->where('product_id', $product->id)
            ->orWhere('with_product_id', $product->id)->first();

        $sizeChart = $this->getSizeChart($product->optionValues->first());

        return view('products.show')->with([
            'product' => $product,
            'optionValues' => $optionValues,
            'productsGroup' => $productsGroup,
            'sizeChart' => $sizeChart
        ]);
    }


    public function filter(request $request, $clone = false)
    {
        $products = Product::with(['offer', 'options', 'optionValues']);

        if ($request->has('new') && !is_null($request->new)) {
            $products->whereDate('created_at', '>=', Carbon::now()->subDays(app('settings')->new_arrival_days)->toDateTimeString());
            $products->orWhere('is_new',1);
        }
        if ($request->has('options_value') && !is_null($request->options_value)) {
            $products->whereHas('optionValues', function ($q) use ($request) {
                $q->whereIn('option_value_id', $request->options_value);
            });
        }
        if ($request->has('categories') && !is_null($request->categories)) {
            $products->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('id', is_array($request->categories) ? $request->categories : [$request->categories]);
            });
        }
        if ($request->has('characters') && !is_null($request->characters)) {
            $products->whereHas('characters', function ($q) use ($request) {
                $q->whereIn('id', is_array($request->characters) ? $request->characters : [$request->characters]);
            });
        }
        if ($request->has('tags') && !is_null($request->tags)) {
            $products->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('id', is_array($request->tags) ? $request->tags : [$request->tags]);
            });
        }
        if ($request->has('brands') && !is_null($request->brands)) {
            $products->whereIn('brand_id', is_array($request->brands) ? $request->brands : [$request->brands]);
        }
        if (
            $request->has('price_from') && $request->has('price_to')
            && !is_null($request->price_from)  && !is_null($request->price_to)
        ) {
            preg_match_all('!\d+!', $request->price_from, $int_price_from);
            preg_match_all('!\d+!', $request->price_to, $int_price_to);

            $products->whereBetween('price', [$int_price_from[0][0], $int_price_to[0][0]]);
        }
        if ($request->has('sales') && $request->has('sales')) {
            $products->whereHas('offer');
        }
        if ($request->has('q') && !is_null($request->q)) {
            $value = is_array($request->q) ? $request->q[0] : $request->q;
            if (!is_null($value)) {
                $products->whereHas('tags', function ($q) use ($value) {
                    $q->where('name_en', 'like', $value . '%')
                        ->orWhere('name_ar', 'like', $value . '%');
                });
            }
        }
        if ($request->has('sorting') && !is_null($request->sorting)) {
            switch ($request->sorting) {
                case 'asc':
                    $products->orderBy('price', 'asc');
                    break;
                case 'desc':
                    $products->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $products->orderBy('created_at', 'desc');
                    break;
            }
        }

        if ($clone) {
            return $products;
        }
        $products = $products->paginate(15);

        return $products;
    }

    public function notifyCustomerOnceAvailable(request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'product_id' => 'required',
        ]);

        ProductAvailabilityNotification::create($request->all());

        return response()->json(null, 200);
    }

    public function addReview(request $request)
    {
        $this->validate($request, [
            'comment' => 'required|string',
            'rate' => 'required',
            'product_id' => 'required',
        ]);

        ProductReview::create([
            'rate' => $request->rate,
            'comment' => $request->comment,
            'product_id' => $request->product_id,
            'user_id' => Auth::user()->id,

        ]);

        return response()->json(null, 200);
    }

    public function autoCompleteTags()
    {

        $tags = Tag::where('status', 1)->get()->pluck('name_en', 'name_ar');
        return response()->json($tags, 200);
    }

    public function shopByInterest(request $request)
    {
        $auth = Auth::user();
        if (!$auth) {
            return redirect()->route('login');
        }
        $request->merge([
            'tags' => $auth->tags->pluck('id')->toArray(),
            'categories' => $auth->categories->pluck('id')->toArray(),
            'brands' => $auth->brands->pluck('id')->toArray(),
            'characters' => $auth->tags->pluck('id')->toArray()
        ]);

        return $this->index($request);
    }

    private function getSizeChart($productOptionValue)
    {
        $sizeChart = [];
        if ($productOptionValue) {
            if (!is_null($productOptionValue->pivot->price_combination) && $productOptionValue->pivot->price_combination != '') { }
            $optionValues = OptionValue::get()->pluck('value_' . app()->getLocale(), 'id')->toArray();

            $price_combination = json_decode($productOptionValue->pivot->price_combination, true);
            if (isset($price_combination['options'])) {
                foreach ($price_combination['options'] as $key => $values) {
                    $optionValueIds = explode('_', $key);
                    $option_name = '';
                    foreach ($optionValueIds as $key) {
                        $prefix = $key === end($optionValueIds) ? '' : '-';
                        $option_name .= $optionValues[$key] . $prefix;
                    }
                    $sizeChart[] = [
                        'name' => $option_name,
                        'quantity' => $values['quantity'],
                        'price' => $values['price']
                    ];
                }
            }
        }
        return $sizeChart;
    }
}
