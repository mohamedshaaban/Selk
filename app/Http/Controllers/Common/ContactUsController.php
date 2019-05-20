<?php

namespace App\Http\Controllers\common;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\Careers;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Settings;
use Mail;
use App\Mail\ContactUsMail;
use \App\Models\Category;
use App\Models\Brand;
use App\Models\Character;
use Session;
use Auth;

class ContactUsController extends Controller
{

    public function index(Request $request)
    {

        $countries = Countries::all();
        $setting = Settings::find(1);
        return view('common.contact_us', compact(['countries', 'setting']));
    }
    public function store(Request $request)
    {
        $setting = Settings::find(1);
        Mail::to($setting->email_support)->send(new ContactUsMail($request->all()));

        Session::flash('success', '');
        Session::flash('message', __('website.contact_us_success_message'));
        
        return redirect()->route('website.common.contact_us');
    }
    public function sitemap(Request $request)
    {
        $categories = Category::all();
        $record = new Category();
        $Characters = Character::all();
        $brands = Brand::all();

        $authcategories = (object)array_combine($record->getFillable(),  array_fill(0, count($record->getFillable()), ''));
        $auth = Auth::user();
        if ($auth) {
            $authcategories = $auth->categories();
        }

        return view('common.sitemap', compact(['categories', 'authcategories', 'Characters', 'brands']));
    }
}
