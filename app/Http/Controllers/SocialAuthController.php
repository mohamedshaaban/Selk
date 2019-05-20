<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Redirect;
use App\User;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Hash;
class SocialAuthController extends Controller {
	public function redirect($service) {
		return Socialite::driver ( $service )->redirect ();
	}
	public function callback($service) {
		$user = Socialite::with ( $service )->user();
                
                if($service == 'facebook')
                {
                    $chkUser = User::where('email' , $user->user['email'])->first();
                }
                else if($service == 'twitter' || $service == 'google')
                {
                    $chkUser = User::where('email' , $user->email)->first();
                }
                               
                $serviceId = $service.'_id';
                if(!$chkUser)
                {
                    $chkUser = new User();
                     if($service == 'facebook')
                        {
                            $chkUser->name =  $user->user['name']; 
                            $chkUser->first_name =  $user->user['name']; 
                            $chkUser->email = $user->user['email']; 
                            $chkUser->$serviceId = $user->user['id'] ; 
                            $chkUser->password = Hash::make($user->user['id']);
                        }
                    else if($service == 'twitter' || $service == 'google')
                        {
                            $chkUser->name =  $user->name; 
                            $chkUser->first_name =  $user->name; 
                            $chkUser->email = $user->email; 
                            $chkUser->$serviceId = $user->id ;    
                            $chkUser->password = Hash::make($user->id );
                        }
                    $chkUser->is_active = 1; 
                    $chkUser->code = ''; 
                    $chkUser->email_verified_at = Carbon::now(); 
                    
                    $chkUser->save();
             
                } 
                else 
                {
                       if($service == 'facebook')
                        {
                            $chkUser->name =  $user->user['name']; 
                            $chkUser->first_name =  $user->user['name']; 
                            $chkUser->email = $user->user['email']; 
                            $chkUser->$serviceId = $user->user['id'] ; 
                            $chkUser->password = Hash::make($user->user['id']);
                        }
                    else if($service == 'twitter' || $service == 'google')
                        {
                            $chkUser->name =  $user->name; 
                            $chkUser->first_name =  $user->name; 
                            $chkUser->email = $user->email; 
                            $chkUser->$serviceId = $user->id ;    
                            $chkUser->password = Hash::make($user->id );
                        }
                    $chkUser->is_active = 1; 
                    $chkUser->code = ''; 
                    $chkUser->email_verified_at = Carbon::now(); 
                    
                    $chkUser->update();
                }
                    $credentials = array(
                        'email' => $chkUser->email,
                        $serviceId => $chkUser->$serviceId,
                        'is_active' => 1,
                        'password'=>$chkUser->$serviceId
                    );

                    if (Auth::attempt($credentials)) {
                        return redirect('home');
                    }
                
               
	}
}
