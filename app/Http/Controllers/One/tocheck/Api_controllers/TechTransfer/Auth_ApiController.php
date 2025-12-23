<?php

namespace App\Http\Controllers\Api_controllers\TechTransfer;

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
            // $role = $user->roles()->name;
            
        //    $role =  Role::where('u')
            // $roleId = DB::table('users_roles')->where('user_id', $user->id)->value('role_id');
            // $role = Role::where('id', $roleId)->value('slug');
            // $user['role'] = $role;

            $user['name'] = Respondant::where('user_id', $user->id)->value('name');
            $user['phone'] = Respondant::where('user_id', $user->id)->value('phone');
            $user['gender'] = Respondant::where('user_id', $user->id)->value('gender');
            $user['id'] = Respondant::where('user_id', $user->id)->value('id');

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
            'gender' => 'required|string',
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
            else if($validator->errors()->first('gender')){
                $massage =$validator->errors()->first('gender');
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
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->register_as,
            ]);
            
            if($user){
                User::where('id',$user->id)->update(['added_by'=>$user->id]);
                // $user->roles()->attach($request->register_as);

                $user_id = $user->id;

                $respondant = Respondant::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'user_id' => $user_id,
                ]);

                $data = $respondant;

                $data['role'] = $user->role;

                $data['email'] = User::where('id', $data->user_id)->value('email');

                $result = $data;


                $response=['success'=>true,'error'=>false,'message'=>'User registered successfully','user'=>$result];

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