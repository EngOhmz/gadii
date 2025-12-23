<?php

namespace App\Http\Controllers\Api_controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\TechTransfer\Respondant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Throwable\Exception;

class Auth_ApiController extends Controller
{
   
    /**
     * Login function.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //validation 
        $rules = [
            'email'=>'required|string',
            'password'=>'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            if($validator->errors()->first('name')){
                $massage =$validator->errors()->first('name');
            }
            else if($validator->errors()->first('password')){
                $massage =$validator->errors()->first('password');
            }
            $response=['success'=>false,'error'=>true,'message'=>$massage];
            return response()->json($response,200);

        }
        
        //Authentication done when all fields are validated
        $user=User::where('email',$request->email)->first();
        
        if($user && Hash::check($request->password,$user->password))
        {
            $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user];

            return response()->json($response,200);
        }
        else{
            $response=['success'=>false,'error'=>true,'message'=>'incorrect email or password'];
            return response()->json($response,200);
        }
    }

    public function register_as()
    {
        $roles = Role::all()->whereNotIn('slug', 'superAdmin');
        return response()->json($roles);
    }

    public function user_email(String $email)
    {
        $emailFind = User::all()->where('email', $email)->first();
        if($emailFind){
            $response=['success'=>false,'error'=>true, 'message'=>'Email exists'];
            return response()->json($response,200);
        }
        else{
            $response=['success'=>true,'error'=>false, 'message'=>'Proceed'];
            return response()->json($response,200);
        }
        // $roles = Role::all()->whereNotIn('slug', 'superAdmin');
        
    }

    

    

    // public function get_countries()
    // {
    //     $countries = DB::table('countries')->get();
    //     return response()->json($countries);
    // }


   
}