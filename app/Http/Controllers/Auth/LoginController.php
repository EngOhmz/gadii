<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User_Roles;
use App\Models\User;
use App\Models\CompanyRoles;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    
     { 
         
    $email = $request->email; 

         if(!empty($request->login_as)){
        $user = User::where('email',$email)->get()->first();
         $login_as = $request->login_as;
         $result = CompanyRoles::where('user_id',$user->id)->where('admin_role',$login_as)->get()->first();
       if(!empty($result)){ 
        $data['role_id'] = $result->role_id;
        $data['role_id'] = $result->role_id;
        
        if($user->id != $user->added_by){
        if(!empty($user))
        $role = User_Roles::where('user_id',$user->id)->update($data);
        }
        }
             
             
         }
        
      $this->middleware('guest')->except('logout');
    }
}
