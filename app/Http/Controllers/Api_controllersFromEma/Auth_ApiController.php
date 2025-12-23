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
            if($validator->errors()->first('email')){
                $massage =$validator->errors()->first('email');
            }
            else if($validator->errors()->first('password')){
                $massage =$validator->errors()->first('password');
            }
            $response=['success'=>false,'error'=>true,'message'=>$massage];
            return response()->json($response,200);

        }
        
        //Authentication done when all fields are validated
        $user=User::where('phone', $request->email)->orWhere('email', $request->email)->first();
        
        if($user && Hash::check($request->password,$user->password))
        {
            // $role = $user->roles()->name;
            $department_id = $user->department_id;
            $designation_id = $user->designation_id;
        //    $role =  Role::where('u')
            $roleId = DB::table('users_roles')->where('user_id', $user->id)->value('role_id');
            $role = Role::where('id', $roleId)->value('slug');
            $user['role'] = $role;

            

            // $token= $user->createToken('Personal Access Token')->plainTextToken;
            // $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user,'token'=>$token];
            $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user];

            return response()->json($response,200);
        }else{
            $response=['success'=>false,'error'=>true,'message'=>'incorrect email or password'];
            return response()->json($response,200);
        }
    }

    public function register_as()
    {
        $roles = Role::all()->whereIn('slug', ['Retail']);
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
    
    public function country_update(){
        
        // $users = ::all();
        
        $data = User::all();
        if($data->isNotEmpty()){
            
        foreach($data as $row){
            $row2 = $row->update(['country' => 'Tanzania']);
            
            $farmers[] = $row2;
            
        }
        
        
            $response=['success'=>true,'error'=>false, 'message'=>'country updated', 'data' => $farmers];
            return response()->json($response,200);
        }
        else{
            $response=['success'=>false,'error'=>true, 'message'=>'failed'];
            return response()->json($response,200);
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
            // 'country' => 'required|string',  
            'email' => 'required|string|unique:users',
            'phone' => 'required|string|unique:users',
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
            return response()->json($response,200);
        }

        try {
            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                // 'country' => $request->country,  
                'phone' => $request->phone,
                'address' => $request->address,
                'reference_no' => $request->reference_no,
                'user_type' => 'customer',
                'password' => Hash::make($request->password),
            ]);
            
         
            if($user){
                
                
                User::where('id',$user->id)->update(['added_by'=>$user->id]);
                
                $roles_added2 = Role::where('slug', $request['register_as'])->first();
                
                $role_user_id =  $roles_added2->id;
                
                
                $user->roles()->attach($role_user_id);
                
                
                $account_groupOld = DB::table('gl_account_groupOld')->get();
        
                foreach($account_groupOld as $row){
            
            
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $row->group_id,
                    'name' => $row->name,
                    'class' => $row->class,
                    'type' => $row->type,
                    'order_no' => $row->order_no,
                    'added_by' => $user->id,
                    
                ]);
                
            
        }
        
        
        $account_typeOld = DB::table('gl_account_typeOld')->get();
        
        foreach($account_typeOld as $row){
            
           
                
                DB::table('gl_account_type')->insert([
                    
                    'account_type_id' => $row->account_type_id,
                    'value' => $row->value,
                    'type' => $row->type,
                    'added_by' => $user->id,
                    
                ]);
                
            
        }
        
        $account_codesOld = DB::table('gl_account_codesOld')->get();
        
        foreach($account_codesOld as $row){
            
            
                
                DB::table('gl_account_codes')->insert([
                    
                    'account_codes' => $row->account_codes,
                    'account_name' => $row->account_name,
                    'account_group' => $row->account_group,
                    'account_type' => $row->account_type,
                    'account_status' => $row->account_status,
                    'allow_manual' => $row->allow_manual,
                    'account_id' => $row->account_id,
                    'order_no' => $row->order_no,
                    'added_by' => $user->id,
                    
                ]);
                
               
            
        }
        
        $account_classOld = DB::table('gl_account_classOld')->get();
        
        foreach($account_classOld as $row){
            
            
                
                DB::table('gl_account_class')->insert([
                    
                    'class_id' => $row->class_id,
                    'class_name' => $row->class_name,
                    'class_type' => $row->class_type,
                    'order_no' => $row->order_no,
                    'added_by' => $user->id,
                    
                ]);
             
            
        }
        
        
        
                $response=['success'=>true,'error'=>false,'message'=>'User registered successfully','user'=>$user];

                return response()->json($response,200);
            }else{
                $response=['success'=>false,'error'=>true,'message'=>'User registered fail'];
                return response()->json($response,200);
            }
        } catch (Exception $e) {
            $response=['success'=>false,'error'=>true,'message'=> $e];
          
        }
        
        return response()->json($response,500);
       
    }

    

    // public function get_countries()
    // {
    //     $countries = DB::table('countries')->get();
    //     return response()->json($countries);
    // }


   
}