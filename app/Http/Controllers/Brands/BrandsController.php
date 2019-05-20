<?php

namespace App\Http\Controllers\Brands;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = $this->filter();

        return view('brands.index')->with([
            'brands' => $brands,
        ]);
    }

    public function filter()
    {
        return json_encode(Brand::where('status',1)->orderBy('sort_order', 'desc')->paginate(16));
    }
}
