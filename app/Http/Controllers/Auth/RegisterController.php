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
use Auth;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        if($validate->fails())
        {

            return ['status'=>'false','errors'=>$validate->errors()->all()];

        }
        $code = 'EN' . Carbon::now().$request->first_name;
            $user =  User::create([
            'name' => $request->first_name .' '.$request->last_name,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'code'=> substr(preg_replace('/[^A-Za-z0-9\-]/', '', Hash::make($code)),0,6) 
        ]);

        \Session::flash( 'success', "Your Account Has Been created , Please check your email to activate it" );
        \Session::flash( 'title', "Congratulations!" );
        Mail::to($request->email)->send(new VerifyUser($user));
         session(['userEmail'=> $request->email]);

        return ['status'=>'true'];
       
    }
    public function verifyAccount(Request $request)
    {
        $verifycode = implode('', $request->code);
        $user = User::where('code',$verifycode)->update(['is_active' => 1,'code'=>'' ,'email_verified_at'=> Carbon::now()]);
        return $user;
        
    }

    public function verifyAccountLink(Request $request)
    {

        $verifycode =   $request->code;

        $user = User::where('code',$verifycode)->update(['is_active' => 1,'code'=>'' ,'email_verified_at'=> Carbon::now()]);

            \Session::flash( 'success', "Your Account Has Been Verified" );
            \Session::flash( 'title', "Congratulations!" );
            return redirect(route('login'));


    }
    public function resendCode(Request $request)
    {
        
        $user= User::where('email', session('userEmail'))->first()->toArray();
        Mail::to(session('userEmail'))->send(new VerifyUser($user));
    }
    public function login(Request $request)
    {
        
        $chkemail = User::where('email',$request->email)->first();
        
        if(!$chkemail)
        {
            return response()->json([ 'logged'=>false ,'code'=>1 ,'message'=>'Invalid Email']);// 
        }
         $credentials = array(
            'email' => $request->email,
            'password' => ($request->password),
            'is_active' => 1
        );

        if (Auth::attempt($credentials))
        {
            if(isset($request->cart))
            {
                return response()->json([ 'logged'=>true ,'cart'=>$request->cart ]);
            }
         return response()->json([ 'logged'=>true ]);
            

        }
        else
        {
           return response()->json([ 'logged'=>false ,'code'=>2  ,'message'=>'Wrong Password']);//            return redirect()->rout('customer.login')->withErrors('Invalid Login credentials');
        }

    }
    public function showLoginForm(Request $requst)
    {
        return view('login');
    }
}
