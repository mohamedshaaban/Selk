<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GiftCartStorage;
use Illuminate\Support\Facades\Session;
use Auth;
use Illuminate\Support\Str;
use App\Models\ShippingMethods;
use App\Models\Pages;
use App\Models\Faq;
class PagesController extends Controller
{
    public function getPages(Request $request)
    {
        $page = Pages::where('slug' , $request->slug)->firstOrFail();
        return view('pages.page')->with(['page'=>$page]);
    }
    public function getFaqs(Request $request)
    {
        $faqs = Faq::where('status' , 1)->orderByDesc('id')->get();
        return view('pages.faq')->with(['faqs'=>$faqs]);
    }
}
