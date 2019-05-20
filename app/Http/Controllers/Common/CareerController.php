<?php

namespace App\Http\Controllers\common;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\Careers;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use Session;

class CareerController extends Controller
{

    public function index(Request $request)
    {

        $countries = Countries::all();

        return view('common.career', compact(['countries']));
    }

    public function store(Request $request)
    {
        //        dd($request->all());


        //        return response()->download((storage_path('app/careers/'.$fileName)));
        //        dd( \Storage::download((storage_path('app/careers/')).$fileName));


        $request->validate([
            'first_name' => 'required:max:1',
            'email' => 'required',
            'tel' => 'required|numeric',
            'nationality' => 'required',
            'position' => 'required', 'fileToUpload',
            'attachment' => 'required|file|max:1024',
        ]);

        $fileName = "career_" . time() . '.' . $request->attachment->getClientOriginalExtension();
        $request->attachment->storeAs('careers', $fileName);


        Careers::create([
            'attachment' => 'careers/' . $fileName,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'tel' => $request->tel,
            'nationality' => $request->nationality,
            'position' => $request->position,
        ]);

        \Session::flash('success', '');
        \Session::flash('message',  __('website.career_success'));

        $countries = Countries::all();

        $message = __('website.career_success');
        return view('common.career', compact(['message','countries']));

//        return \Redirect::back();
    }
}
