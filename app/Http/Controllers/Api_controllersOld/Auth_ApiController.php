<?php

namespace App\Http\Controllers\Api_controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            return response()->json($response,400);

        }
        
        //Authentication done when all fields are validated
        $user=User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password))
        {
            $token= $user->createToken('Personal Access Token')->plainTextToken;
            $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user,'token'=>$token];
            return response()->json($response,200);
        }else{
            $response=['success'=>false,'error'=>true,'message'=>'incorrect email or password'];
            return response()->json($response,400);
        }
    }

    /**
     * Register users in system.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //validation 
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'phone' => 'required|string',
            'address' => 'required|string',
            'password' => 'required',
            'register_as'=>'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        // taking each message of field error
        if($validator->fails())
        {
            if($validator->errors()->first('name')){
                $massage =$validator->errors()->first('name');
            }
            else if($validator->errors()->first('email')){
                $massage =$validator->errors()->first('email');
            }
            else if($validator->errors()->first('phone')){
                $massage =$validator->errors()->first('phone');
            }
            else if($validator->errors()->first('address')){
                $massage =$validator->errors()->first('address');
            }
            else if($validator->errors()->first('password')){
                $massage =$validator->errors()->first('password');
            }
            else if($validator->errors()->first('register_as')){
                $massage =$validator->errors()->first('register_as');
            }else{
                $massage =$validator->errors();
            }
            $response=['success'=>false,'error'=>true,'message'=>$massage];
            return response()->json($response,400);
        }

        try {
            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => Hash::make($request->password),
            ]);
            if($user){
                User::where('id',$user->id)->update(['added_by'=>$user->id]);
                $user->roles()->attach($request->register_as);
                $token= $user->createToken('Personal Access Token')->plainTextToken;
                $response=['success'=>true,'error'=>false,'message'=>'User registered successfully','user'=>$user,'token'=>$token];
                return response()->json($response,200);
            }else{
                $response=['success'=>false,'error'=>true,'message'=>'User registered fail'];
            }
        } catch (Exception $e) {
            $response=['success'=>false,'error'=>true,'message'=> $e];
          
        }
        
        return response()->json($response,500);
       
    }


   
}