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
use App\Models\User_Roles;
use App\Models\User_RolesCopy2;
use App\Models\Client;
use App\Models\POS\Activity;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\AccountType;
use Illuminate\Support\Facades\Http;

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
        
        if(!empty($user)){
        
        $userRole =  User_Roles::where('user_id',$user->id)->value('role_id');
            
            if($userRole == 53 || $userRole == 66 || $userRole == 67 || $userRole == 58 || $userRole == 46 || $userRole == 72){
                
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
            else{
                    $response=['success'=>false,'error'=>true,'message'=>'incorrect email or password'];
                    return response()->json($response,200);
            }
            
        }
        else{
                        $response=['success'=>false,'error'=>true,'message'=>'incorrect email or password'];
                        return response()->json($response,200);
        }
        
        
    }
    
    public function login22(Request $request)
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
        
        if(!empty($user)){
        
        $userRole =  User_Roles::where('user_id',$user->id)->value('role_id');
            
            if($userRole == 32){
                
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
            else{
                    $response=['success'=>false,'error'=>true,'message'=>'incorrect email or password'];
                    return response()->json($response,200);
            }
            
        }
        else{
                        $response=['success'=>false,'error'=>true,'message'=>'incorrect email or password'];
                        return response()->json($response,200);
        }
        
        
    }
    // public function login(Request $request)
    // {
    //     //validation 
    //     $rules = [
    //         'email'=>'required|string',
    //         'password'=>'required'
    //     ];
    //     $validator = Validator::make($request->all(),$rules);
    //     if($validator->fails())
    //     {
    //         if($validator->errors()->first('email')){
    //             $massage =$validator->errors()->first('email');
    //         }
    //         else if($validator->errors()->first('password')){
    //             $massage =$validator->errors()->first('password');
    //         }
    //         $response=['success'=>false,'error'=>true,'message'=>$massage];
    //         return response()->json($response,200);

    //     }
        
    //     //Authentication done when all fields are validated
    //     $user=User::where('phone', $request->email)->orWhere('email', $request->email)->first();
        
    //     if($user && Hash::check($request->password,$user->password))
    //     {
    //         // $role = $user->roles()->name;
    //         $department_id = $user->department_id;
    //         $designation_id = $user->designation_id;
    //     //    $role =  Role::where('u')
    //         $roleId = DB::table('users_roles')->where('user_id', $user->id)->value('role_id');
    //         $role = Role::where('id', $roleId)->value('slug');
    //         $user['role'] = $role;

            

    //         // $token= $user->createToken('Personal Access Token')->plainTextToken;
    //         // $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user,'token'=>$token];
    //         $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user];

    //         return response()->json($response,200);
    //     }else{
    //         $response=['success'=>false,'error'=>true,'message'=>'incorrect email or password'];
    //         return response()->json($response,200);
    //     }
    // }

    public function register_as()
    {
        $roles = Role::all()->whereIn('id', [53]);
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
    
    public function testusers(){
        $data = User::all();
        if($data->isNotEmpty()){
            
        foreach($data as $row){
            
            
            $userRoles =  User_Roles::where('user_id',$row->id)->where('role_id', 32)->get();
            foreach($userRoles as $row33){
                
                $data2 = $row;
            
                $farmers[] = $data2;
            }
            
            
            
        }
        
        
            $response=['success'=>true,'error'=>false, 'message'=>'country updated', 'data' => $farmers];
            return response()->json($response,200);
        }
        else{
            $response=['success'=>false,'error'=>true, 'message'=>'failed'];
            return response()->json($response,200);
        }
    }
    
    public function register22(Request $request)
    {
        //validation 
        $rules = [
            'name' => 'required|string',
            // 'country' => 'required|string',  
            'email' => 'required|string|unique:users',
            'phone' => 'required|string|unique:users',
            'address' => 'required|string',
            'password' => 'required'
            // 'register_as'=>'required'
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
            // else if($validator->errors()->first('register_as')){
            //     $massage =$validator->errors()->first('register_as');
            // }
            else{
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
                
                $register_as = 'Test';
                
                
                User::where('id',$user->id)->update(['added_by'=>$user->id]);
                
                $roles_added2 = Role::where('slug', $register_as)->first();
                
                $role_user_id =  $roles_added2->id;
                
                
                $user->roles()->attach($role_user_id);
        
        
        
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
                
                $due_date = $user->created_at->addDays(7);
                User::where('id',$user->id)->update(['added_by'=>$user->id, 'due_date' => $due_date]);
                
                // $roles_added2 = Role::where('slug', $request['register_as'])->first();
                
                $roles_added2 = Role::where('id', 53)->first();
                
                $role_user_id =  $roles_added2->id;
                
                
                $user->roles()->attach($role_user_id);
                
                
                //register in user role copy for expire date and others
        
        $prc = Role::where('id', 53)->first();
        
        $usrRoles = User_RolesCopy2::create([
            'user_id' => $user->id,
            'role_id' => $prc->id,
            'day' => $prc->day,
            'month' => $prc->month,
            'year' => $prc->year,
            'disabled' => 0,
            'due_date' => $due_date,
        ]);
        
        //register as client  
       
        $admin=User::where('email','info@ujuzinet.com')->first();
      $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => $admin->id,
            'owner_id' => $admin->added_by,
            'member_id' => $user->id,
        ]);

if(!empty($client)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>$admin->added_by,
                              'user_id'=>$admin->id,
                            'module_id'=>$client->id,
                             'module'=>'Client',
                            'activity'=>"Client " .  $client->name. "  Created",
                        ]
                        );                      
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
        
        
         $account_classOld = DB::table('gl_account_classOld')->get();
        
        foreach($account_classOld as $row){
            
            
                
                DB::table('gl_account_class')->insert([
                    
                    'class_id' => $row->class_id,
                    'class_name' => $row->class_name,
                    'class_type' => $row->class_type,
                    'order_no' => $row->order_no,
                    'disabled' => $row->disabled,
                    'edited' => '0',
                    'added_by' => $user->id,
                    
                ]);
             
            
        }
                
                $account_groupOld = DB::table('gl_account_groupOld')->get();
        
                foreach($account_groupOld as $row){
            
                $class=ClassAccount::where('class_name', $row->class)->where('added_by',$user->id)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$user->id)->latest('id')->first();
                if(!empty($before)){
                  $group_id =    $before->group_id +100;
                  $group_order = $before->order_no +1;  
                }
                
                else{
                    $group_id=    $class->class_id +100;
                    $group_order = '0'; 
                }
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $group_id,
                    'name' => $row->name,
                    'class' => $class->id,
                    'type' => $row->type,
                    'order_no' => $group_order,
                    'added_by' => $user->id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                    
                    
                ]);
                
                
            
        }
        
        
       
        
        $account_codesOld = DB::table('gl_account_codesOld')->get();
            
            foreach($account_codesOld as $row){
                
       $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user->id)->first();
                    //dd($group);
                    
                    if(!empty($group)){
                        
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$user->id)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                        
                    $cID =    DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $codes,
                            'account_name' => $row->account_name,
                            'account_group' => $group->id,
                            'account_type' => $row->account_type,
                            'account_status' => $status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $code_order,
                            'edited' => $row->edited,
                            'disabled' => $row->disabled,
                            'added_by' => $user->id,
                            
                        ]);
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                       
                    }  
                    
                                  else{
                        $cID =   DB::table('gl_account_codes')->insertGetId([
                        
                        'account_codes' => $row->account_codes,
                        'account_name' => $row->account_name,
                        'account_group' => $row->account_group,
                        'account_type' => $row->account_type,
                        'account_status' => $row->account_status,
                        'allow_manual' => $row->allow_manual,
                        'account_id' => $row->account_id,
                        'order_no' => $row->order_no,
                        'edited' => $row->edited,
                        'disabled' => $row->disabled,
                        'added_by' => $user->id,
                        
                    ]);
                    
                    
                    $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);  
                     }
                     
                     
                }
            
        
             $key = "891bf62609dcbefad622090d577294dcab6d0607";
            $number = $user->phone;
        //   $message = "Welcome to EMASUITE RETAIL, $user->name . Your registration is successful. If you have any questions or need assistance, call us on +255 655 973 248. \n Powered by UjuziNet.";
           $message = "Dear  $user->name, Congratulations on joining EMASUITE RETAIL! Manage finances, inventories, staffs, operations, customers and more. Pay now or within 7 days. Assistance: +255 655 973 248. \n Powered by UjuziNet.";
          $option11 = 1;
          $type = "sms";
          $useRandomDevice = 1;
          $prioritize = 1;
          
          $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
       
        
        
        
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
    
    public function payroll_acc(){
        
        $added_by = 339;
                
               
                $account_groupOld = DB::table('gl_account_group_payr')->get();
        
                foreach($account_groupOld as $row){
            
            
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $row->group_id,
                    'name' => $row->name,
                    'class' => $row->class,
                    'type' => $row->type,
                    'order_no' => $row->order_no,
                    'added_by' => $added_by,
                    
                ]);
                
            
        }
        
        
        
        $account_codesOld = DB::table('gl_account_codes_payr')->get();
        
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
                    'added_by' => $added_by,
                    
                ]);
                
               
            
        }
        
        
        
        $account_classOld = DB::table('gl_account_class_payr')->get();
        
        foreach($account_classOld as $row){
            
            
                
                DB::table('gl_account_class')->insert([
                    
                    'class_id' => $row->class_id,
                    'class_name' => $row->class_name,
                    'class_type' => $row->class_type,
                    'order_no' => $row->order_no,
                    'added_by' => $added_by,
                    
                ]);
             
            
        }
        
        
        
        $response=['success'=>true,'error'=>false,'message'=>'added_by successfully'];
    }

    

    // public function get_countries()
    // {
    //     $countries = DB::table('countries')->get();
    //     return response()->json($countries);
    // }


   
}