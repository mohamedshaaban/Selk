<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Character;
use App\Models\Brand;
use App\Models\ProductReview;
use App\Models\ProductsTogetherPrice;
use App\Common;
use function GuzzleHttp\json_decode;

class Product extends Model
{
    protected $appends = [
        'is_new', 'main_image_path',
        'images_path', 'currency_name',
        'currency_exchange_rate', 'name'
    ];
    protected $fillable = [
        'id', 'name_en', 'name_ar', 'slug_name', 'sku',
        'short_description_en', 'short_description_ar', 'description_en',
        'description_ar', 'price', 'quantity', 'minimum_order',
        'main_image', 'images', 'brand_id',
        'is_featured', 'status', 'in_stock', 'pre_order',
        'vend_updated_at', 'vend_price', 'vend_supplier_price',
        'vend_tracking_inventory', 'vend_id', 'pre_order_days',
        'weight', 'height', 'supplier_id', 'free_return',
        'delivery_and_return_en', 'delivery_and_return_ar',
        'maxima_order','is_new'
    ];
    public function options()
    {
        return $this->belongsToMany(Option::class, 'product_options', 'product_id', 'option_id');
    }

    public function optionValues()
    {
        return  $this->belongsToMany(OptionValue::class, 'product_option_values', 'product_id', 'option_value_id')
            ->withPivot('option_id', 'price_combination');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'product_characters', 'product_id', 'character_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'product_related', 'product_id', 'related_product_id');
    }

    public function offer()
    {
        return $this->hasOne(ProductOffer::class)
            ->whereDate('from', '<=', date('Y-m-d'))
            ->whereDate('to', '>=', date('Y-m-d'));
    }

    public function setImagesAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['images'] = json_encode($images);
        }
    }

    public function getImagesAttribute($pictures)
    {

        if ($pictures == "" || json_decode($pictures, true) == null) {
            return [];
        }

        return json_decode($pictures, true);
    }

    public function getMainImagePathAttribute()
    {
        if (substr($this->main_image, 0, 6) == 'https:') {
            return $this->main_image;
        } else {
            if (!is_null($this->main_image) && file_exists(public_path() . '/uploads/' . $this->main_image)) {
                return url('/') . '/uploads/' . $this->main_image;
            }
            return  url('/') . '/uploads/no-image-white-standard.png';
        }
    }

    public function getImagesPathAttribute()
    {

        if (count($this->images) == 0) {
            return [];
        }
        $images =  $this->images;

        $imagesPath = [];
        foreach ($images as $image) {
            if (substr($image, 0, 6) == 'https:') {
                $imagesPath[] =  $image;
            } else {
                if (!is_null($image) && file_exists(public_path() . '/uploads/' . $image)) {
                    $imagesPath[] =  url('/') . '/uploads/' . $image;
                } else {
                    $imagesPath[] =   url('/') . '/uploads/no-image-white-standard.png';
                }
            }
        }

        return $imagesPath;
    }

    public function getIsNewAttribute()
    {
        return $this->created_at >= \Carbon\Carbon::now()->subDays(app('settings')->new_arrival_days)->toDateTimeString() ? true : false;
    }

    // appended attribute
    public function getCurrencyExchangeRateAttribute()
    {
        $currency = app('currencies')->where('id', session('currency'))->first();

        return $currency->value;
    }
    public function getCurrencyNameAttribute()
    {
        $currency = app('currencies')->where('id', session('currency'))->first();

        return Common::nameLanguage($currency->symbol_en, $currency->symbol_ar);
    }
    public function getNameAttribute()
    {
        return Common::nameLanguage($this->name_en, $this->name_ar);
    }
}
