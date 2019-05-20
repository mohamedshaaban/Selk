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

class ProductOptionValues extends Model
{


    protected $table = 'product_option_values';
}
