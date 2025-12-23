<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User_Roles;
use App\Models\User;
use App\Models\CompanyRoles;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\POS\Activity;

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
         
        //  'edited' => $row->edited,
         
    $email = $request->email; 
    
    

         if(!empty($request->login_as)){
        $user = User::where('phone', $email)->where('disabled',0)->orWhere('email', $email)->where('disabled',0)->get()->first();
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
         
         
         
          $chk_user =User::where('phone', $email)->where('disabled','0')->orWhere('email', $email)->where('disabled','0')->get()->first();
           if(!empty( $chk_user)){ 
          $chk_client=Client::where('member_id',$chk_user->id)->where('disabled','0')->first();
          
          if(empty($chk_client)){
              
              if($email == 'info@ujuzinet.com'){
                  
              }
              
              else{
                  
                  //register as client
        $admin=User::where('email','info@ujuzinet.com')->first();
      $client = Client::create([
            'name' => $chk_user->name,
            'email' => $chk_user->email,
            'phone' => $chk_user->phone,
            'address' => $chk_user->address,
            'user_id' => $admin->id,
            'owner_id' => $admin->added_by,
            'member_id' => $chk_user->id,
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
       
              }
              
              
          }
         
           }          
          
         $user_og = User::where('email',$email)->get()->first();
         
         if(!empty($user_og)){
             
             
              $gl_account_group =  DB::table('gl_account_group')->where('added_by', $user_og->added_by)->first();
        
        if(empty($gl_account_group)){
            
            $userRole =  User_Roles::where('user_id',$user_og->id)->value('role_id');
            
            if($userRole == 64 || $userRole == 55){
                
                $account_groupSchoolOld = DB::table('gl_account_group_school')->get();
        
                foreach($account_groupSchoolOld as $row){
            
            
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $row->group_id,
                    'name' => $row->name,
                    'class' => $row->class,
                    'type' => $row->type,
                    'order_no' => $row->order_no,
                    'added_by' => $user_og->id,
                    
                ]);
                
            
                }


                
            }
            elseif($userRole == 72 || $userRole == 46){
                
                $account_groupManuOld = DB::table('gl_account_group_manufact')->get();
        
                foreach($account_groupManuOld as $row){
            
            
                
                    DB::table('gl_account_group')->insert([
                        
                        'group_id' => $row->group_id,
                        'name' => $row->name,
                        'class' => $row->class,
                        'type' => $row->type,
                        'order_no' => $row->order_no,
                        'added_by' => $user_og->id,
                        
                    ]);
                
            
                }
                
            }
            elseif($userRole == 34){
                $account_groupCourOld = DB::table('gl_account_group_cour')->get();
        
                foreach($account_groupCourOld as $row){
            
            
                
                    DB::table('gl_account_group')->insert([
                        
                        'group_id' => $row->group_id,
                        'name' => $row->name,
                        'class' => $row->class,
                        'type' => $row->type,
                        'order_no' => $row->order_no,
                        'added_by' => $user_og->id,
                        
                    ]);
                
            
                }
            }
            elseif($userRole == 13){
                
                $account_grouplogOld = DB::table('gl_account_grouplogis')->get();
        
                foreach($account_grouplogOld as $row){
            
            
                
                    DB::table('gl_account_group')->insert([
                        
                        'group_id' => $row->group_id,
                        'name' => $row->name,
                        'class' => $row->class,
                        'type' => $row->type,
                        'order_no' => $row->order_no,
                        'added_by' => $user_og->id,
                        
                    ]);
                
            
                }
            }
            else{
                $account_groupOld = DB::table('gl_account_groupOld')->get();
        
                foreach($account_groupOld as $row){
                    
                    
                        
                        DB::table('gl_account_group')->insert([
                            
                            'group_id' => $row->group_id,
                            'name' => $row->name,
                            'class' => $row->class,
                            'type' => $row->type,
                            'order_no' => $row->order_no,
                            'edited' => $row->edited,
                            'added_by' => $user_og->added_by,
                            
                        ]);
                        
                    
                }
            }
            
            
        }
        
        
        $gl_account_type =  DB::table('gl_account_type')->where('added_by', $user_og->added_by)->first();
        
        if(empty($gl_account_type)){
            
            $userRole =  User_Roles::where('user_id',$user_og->id)->value('role_id');
            
            if($userRole == 64 || $userRole == 55){
                
                 $account_typeSchoolOld = DB::table('gl_account_type_school')->get();
                
                foreach($account_typeSchoolOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user_og->id,
                            
                        ]);
                        
                    
                }
            }
            elseif($userRole == 72 || $userRole = 46){
                
                 $account_typeManuOld = DB::table('gl_account_typeOld')->get();
                
                foreach($account_typeManuOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user_og->id,
                            
                        ]);
                        
                    
                }
                
            }
            elseif($userRole == 34){
                $account_typeCourOld = DB::table('gl_account_type_courier')->get();
                
                foreach($account_typeCourOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user_og->id,
                            
                        ]);
                        
                    
                }
            }
            elseif($userRole == 13){
                $account_typeCourOld = DB::table('gl_account_typelogis')->get();
                
                foreach($account_typeCourOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user_og->id,
                            
                        ]);
                        
                    
                }
            }
            else{
                
                $account_typeOld = DB::table('gl_account_typeOld')->get();
            
                foreach($account_typeOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            
                            'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user_og->id,
                            
                        ]);
                        
                    
                }
            }
            
           
            
        }
        
        
        $gl_account_codes =  DB::table('gl_account_codes')->where('added_by', $user_og->added_by)->first();
        
        if(empty($gl_account_codes)){
            // dd($user_og->id);
            $userRole =  User_Roles::where('user_id',$user_og->id)->value('role_id');
            
            if($userRole == 64 || $userRole == 55){
                
                $account_codesSchoolOld = DB::table('gl_account_codes_school')->get();
                
                foreach($account_codesSchoolOld as $row){
                    
                    
                        
                     $cID  =     DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $row->account_codes,
                            'account_name' => $row->account_name,
                            'account_group' => $row->account_group,
                            'account_type' => $row->account_type,
                            'account_status' => $row->account_status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $row->order_no,
                            'added_by' => $user_og->id,
                            
                        ]);
                        
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                       
                    
                }
            }
            elseif($userRole == 72 || $userRole == 46){
                
                $account_codesManuOld = DB::table('gl_account_codes_manufact')->get();
                
                foreach($account_codesManuOld as $row){
                    
                    
                        
                      $cID  =    DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $row->account_codes,
                            'account_name' => $row->account_name,
                            'account_group' => $row->account_group,
                            'account_type' => $row->account_type,
                            'account_status' => $row->account_status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $row->order_no,
                            'added_by' => $user_og->id,
                            
                        ]);
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                       
                    
                }
            }
            elseif($userRole == 34 ){
                
                 $account_codesCourOld = DB::table('gl_account_codes_courier')->get();
                
                foreach($account_codesCourOld as $row){
                    
                    
                        
                     $cID  =     DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $row->account_codes,
                            'account_name' => $row->account_name,
                            'account_group' => $row->account_group,
                            'account_type' => $row->account_type,
                            'account_status' => $row->account_status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $row->order_no,
                            'added_by' => $user_og->id,
                            
                        ]);
                        
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                       
                    
                }
            }
            elseif($userRole == 13){
                
                $account_codesCourOld = DB::table('gl_account_codeslogis')->get();
                
                foreach($account_codesCourOld as $row){
                    
                    
                        
                     $cID  =     DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $row->account_codes,
                            'account_name' => $row->account_name,
                            'account_group' => $row->account_group,
                            'account_type' => $row->account_type,
                            'account_status' => $row->account_status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $row->order_no,
                            'added_by' => $user_og->id,
                            
                        ]);
                        
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                       
                    
                }
            }
            else{
                
                
                 $account_codesOld = DB::table('gl_account_codesOld')->get();
        
                foreach($account_codesOld as $row){
                    
                    
                        
                     $cID  =   DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $row->account_codes,
                            'account_name' => $row->account_name,
                            'account_group' => $row->account_group,
                            'account_type' => $row->account_type,
                            'account_status' => $row->account_status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $row->order_no,
                             'edited' => $row->edited,
                            'added_by' => $user_og->added_by,
                            
                        ]);
                        
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                       
                    
                }
            }
            
           
        }
        
        
        $gl_account_class =  DB::table('gl_account_class')->where('added_by', $user_og->added_by)->first();
        
        if(empty($gl_account_class)){
            
            $userRole =  User_Roles::where('user_id',$user_og->id)->value('role_id');
            
            if($userRole == 64 || $userRole == 55){
                
                $account_classSchoolOld = DB::table('gl_account_class_school')->get();
                
                foreach($account_classSchoolOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'added_by' => $user_og->id,
                            
                        ]);
                     
                    
                }
            }
            elseif($userRole == 72 || $userRole == 46){
                
                $account_classManuOld = DB::table('gl_account_classOld')->get();
                
                foreach($account_classManuOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'added_by' => $user_og->id,
                            
                        ]);
                     
                    
                }
            }
            elseif($userRole == 34){
                
                $account_classCourOld = DB::table('gl_account_class_courie')->get();
                
                foreach($account_classCourOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'added_by' => $user_og->id,
                            
                        ]);
                     
                    
                }
            }
            elseif($userRole == 13){
                
                 $account_classCourOld = DB::table('gl_account_classlogis')->get();
                
                foreach($account_classCourOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'added_by' => $user_og->id,
                            
                        ]);
                     
                    
                }
            }
            else{
                
                $account_classOld = DB::table('gl_account_classOld')->get();
        
                foreach($account_classOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'added_by' => $user_og->added_by,
                            
                        ]);
                     
                    
                }
            }
            
            
            
        }
        
         }
       
        
        
      $this->middleware('guest')->except('logout');
      
      
      

    }
}
