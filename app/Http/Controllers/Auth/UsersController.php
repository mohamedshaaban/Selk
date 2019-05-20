<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Symfony\Component\HttpFoundation\Request;
use App\Mail\VerifyUser;

use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
class UsersController extends Controller
{
    public function accountInfo(Request $request)
    {
		$user =Auth::user();           
		return view('customer.account')->with('user',$user);
        
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return Redirect::route('home');
    }
}