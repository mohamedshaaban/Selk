<?php

namespace App\Http\Controllers\Categories;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index(request $request)
    {
        $categories = $this->filter($request);

        return view('categories.index')->with([
            'categories' => $categories,
        ]);
    }

    public function filter(request $request)
    {
        if($request->category_id && is_numeric($request->category_id)){
            $categories = Category::where('parent_id' , $request->category_id)
            ->paginate(10);
        }else{
            $categories = Category::paginate(10);
        }

        return json_encode($categories);
    }
}
