<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\User_Roles;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\POS\Activity;
use Carbon\Carbon;

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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
          if(is_numeric($request->get('email'))){
            return ['phone'=>$request->get('email'),'password'=>$request->get('password'),'disabled'=>'0'];
          }
          elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password'=>$request->get('password'),'disabled'=>'0'];
          }
          
          elseif( is_string($request->get('email'))){
               return ['email'=>$request->get('email'),'password'=>$request->get('password'),'disabled'=>'0'];
              
          }
          
          
    }
        
        
        
        
    protected function validateLogin(Request $request)

    {

        $this->validate($request, [

            'email' => 'required',

            'password' => 'required',

            // new rules here

        ],
        
        [
            'email.required'=> 'Your Email or Phone Number is Required', 
            'password.required'=> 'Password is Required' 
        ]
        );
        
        
    
        if (!Auth::attempt([
            'email' => $request['email'], 
            'password' => $request['password'],
             'disabled'=>'0'
            
            ])) { 
            return redirect()->back()->with(['fail' => 'invalid Email/Phone Number or password']);      
        }
        elseif(Auth::attempt([
            'email' => $request['email'], 
            'password' => $request['password'],
             'disabled'=>'0'
            
            ])){
                
                $email = $request['email'];
             
                   $usrDD = User::where('phone', $email)->where('disabled','0')->orWhere('email', $email)->where('disabled','0')->get()->first();
                    $last_login = $usrDD->update(['last_login' => Carbon::now()->format('Y-m-d')]); 
            
        $chk_user =User::where('phone', $email)->whereColumn('added_by', 'id')->where('disabled','0')->orWhere('email', $email)->whereColumn('added_by', 'id')->where('disabled','0')->get()->first();
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
                 
                       
                 //glsetup
                 if(!empty($user_og)){
                     
                      //account_type
                     $gl_account_type =  DB::table('gl_account_type')->where('added_by', $user_og->added_by)->first();
                
                if(empty($gl_account_type)){
                    
                    $userRole =  User_Roles::where('user_id',$user_og->added_by)->value('role_id');
                    
                    if($userRole == 64 || $userRole == 55){
                        
                        
                        
                         $account_typeSchoolOld = DB::table('gl_account_type_school')->get();
                        
                        foreach($account_typeSchoolOld as $row){
                            
                           
                                
                                DB::table('gl_account_type')->insert([
                                    // 'account_type_id' => $row->account_type_id,
                                    'value' => $row->value,
                                    'type' => $row->type,
                                    'added_by' => $user_og->added_by,
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
                                ]);
                                
                            
                        }
                    }
                    elseif($userRole == 33){
                        $account_typeCourOld = DB::table('gl_account_typeInv')->get();
                        
                        foreach($account_typeCourOld as $row){
                            
                           
                                
                                DB::table('gl_account_type')->insert([
                                    // 'account_type_id' => $row->account_type_id,
                                    'value' => $row->value,
                                    'type' => $row->type,
                                    'added_by' => $user_og->added_by,
                                    
                                ]);
                                
                            
                        }
                    }
                    elseif($userRole == 50){
                        $account_typeCourOld = DB::table('gl_account_typeCl')->get();
                        
                        foreach($account_typeCourOld as $row){
                            
                           
                                
                                DB::table('gl_account_type')->insert([
                                    // 'account_type_id' => $row->account_type_id,
                                    'value' => $row->value,
                                    'type' => $row->type,
                                    'added_by' => $user_og->added_by,
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
                                ]);
                                
                            
                        }
                    }
                    
                   
                    
                }
                
                
                //class account
                
                $gl_account_class =  DB::table('gl_account_class')->where('added_by', $user_og->added_by)->first();
                
                if(empty($gl_account_class)){
                    
                    $userRole =  User_Roles::where('user_id',$user_og->added_by)->value('role_id');
                    
                    if($userRole == 64 || $userRole == 55){
                        
                        $account_classSchoolOld = DB::table('gl_account_class_school')->get();
                        
                        foreach($account_classSchoolOld as $row){
                            
                            
                                
                                DB::table('gl_account_class')->insert([
                                    
                                    'class_id' => $row->class_id,
                                    'class_name' => $row->class_name,
                                    'class_type' => $row->class_type,
                                    'order_no' => $row->order_no,
                                    'disabled' => $row->disabled,
                                    'edited' => '0',
                                    'added_by' => $user_og->added_by,
                                    
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
                                    'disabled' => $row->disabled,
                                    'edited' => '0',
                                    'added_by' => $user_og->added_by,
                                    
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
                                    'disabled' => $row->disabled,
                                    'edited' => '0',
                                    'added_by' => $user_og->added_by,
                                    
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
                                    'disabled' => $row->disabled,
                                    'edited' => '0',
                                    'added_by' => $user_og->added_by,
                                    
                                ]);
                             
                            
                        }
                    }
                     elseif($userRole == 33){
                        
                         $account_classCourOld = DB::table('gl_account_classInv')->get();
                        
                        foreach($account_classCourOld as $row){
                            
                            
                                
                                DB::table('gl_account_class')->insert([
                                    
                                    'class_id' => $row->class_id,
                                    'class_name' => $row->class_name,
                                    'class_type' => $row->class_type,
                                    'order_no' => $row->order_no,
                                    'disabled' => $row->disabled,
                                    'edited' => '0',
                                    'added_by' => $user_og->added_by,
                                    
                                ]);
                             
                            
                        }
                    }
                    
                    elseif($userRole == 50){
                        
                         $account_classCourOld = DB::table('gl_account_classCl')->get();
                        
                        foreach($account_classCourOld as $row){
                            
                            
                                
                                DB::table('gl_account_class')->insert([
                                    
                                    'class_id' => $row->class_id,
                                    'class_name' => $row->class_name,
                                    'class_type' => $row->class_type,
                                    'order_no' => $row->order_no,
                                    'disabled' => $row->disabled,
                                    'edited' => '0',
                                    'added_by' => $user_og->added_by,
                                    
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
                                    'disabled' => $row->disabled,
                                    'edited' => '0',
                                    'added_by' => $user_og->added_by,

                                ]);
                             
                            
                        }
                    }
                    
                    
                    
                }
                  
                     
                //group account     
                //$gl_account_group =  DB::table('gl_account_group')->where('added_by', $user_og->added_by)->first();
                //if(empty($gl_account_group)){
                    
                    $userRole =  User_Roles::where('user_id',$user_og->added_by)->value('role_id');
                    
                    if($userRole == 64 || $userRole == 55){
                        
                $sql="SELECT * FROM gl_account_group_school WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$user_og->added_by."')";
                $account_groupSchoolOld = DB::select($sql);
                        
                        //$account_groupSchoolOld = DB::table('gl_account_group_school')->get();
                
                         if(count($account_groupSchoolOld) > 0){
                        foreach($account_groupSchoolOld as $row){
                    
                           $class=ClassAccount::where('class_name', $row->class)->where('added_by',$user_og->added_by)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$user_og->added_by)->latest('id')->first();
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
                                    'edited' => $row->edited,
                                    'disabled' => $row->disabled,
                                    'added_by' => $user_og->added_by,
                            
                        ]);
                        
                    
                        }
                         }
        
                        
                    }
                    elseif($userRole == 72 || $userRole == 46){
                        
                   //$account_groupManuOld = DB::table('gl_account_group_manufact')->get();
                   
                 $sql="SELECT * FROM gl_account_group_manufact WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$user_og->added_by."')";
                $account_groupManuOld = DB::select($sql);
                
                if(count($account_groupManuOld) > 0){
                foreach($account_groupManuOld as $row){
                    
                    $class=ClassAccount::where('class_name', $row->class)->where('added_by',$user_og->added_by)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$user_og->added_by)->latest('id')->first();
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
                                    'edited' => $row->edited,
                                    'disabled' => $row->disabled,
                                    'added_by' => $user_og->added_by,
                                
                            ]);
                }
                    
                        }
                        
                    }
                    
                    elseif($userRole == 34){
                    //$account_groupCourOld = DB::table('gl_account_group_cour')->get();
                    $sql="SELECT * FROM gl_account_group_cour WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$user_og->added_by."')";
                    $account_groupCourOld = DB::select($sql);
                
                    if(count($account_groupCourOld) > 0){
                    foreach($account_groupCourOld as $row){
                    
                    $class=ClassAccount::where('class_name', $row->class)->where('added_by',$user_og->added_by)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$user_og->added_by)->latest('id')->first();
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
                                    'edited' => $row->edited,
                                    'disabled' => $row->disabled,
                                    'added_by' => $user_og->added_by,
                                
                            ]);
                    }
                    
                        }
                    }
                    
                    elseif($userRole == 13){
                        
                        //$account_grouplogOld = DB::table('gl_account_grouplogis')->get();
                        
                        $sql="SELECT * FROM gl_account_grouplogis WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$user_og->added_by."')";
                        $account_grouplogOld = DB::select($sql);
 
                   
                        if(count($account_grouplogOld) > 0){        
                        foreach($account_grouplogOld as $row){
                    
                    $class=ClassAccount::where('class_name', $row->class)->where('added_by',$user_og->added_by)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$user_og->added_by)->latest('id')->first();
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
                                    'edited' => $row->edited,
                                    'disabled' => $row->disabled,
                                    'added_by' => $user_og->added_by,
                                
                            ]);
                        }
                    
                        }
                    }
                    
                     elseif($userRole == 33){
                        
                        //$account_grouplogOld = DB::table('gl_account_grouplogis')->get();
                        
                        $sql="SELECT * FROM gl_account_groupInv WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$user_og->added_by."')";
                        $account_grouplogOld = DB::select($sql);
 
                   
                        if(count($account_grouplogOld) > 0){        
                        foreach($account_grouplogOld as $row){
                    
                    $class=ClassAccount::where('class_name', $row->class)->where('added_by',$user_og->added_by)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$user_og->added_by)->latest('id')->first();
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
                                    'edited' => $row->edited,
                                    'disabled' => $row->disabled,
                                    'added_by' => $user_og->added_by,
                                
                            ]);
                        }
                    
                        }
                    }
                    
                        elseif($userRole == 50){
                        
                        //$account_grouplogOld = DB::table('gl_account_grouplogis')->get();
                        
                        $sql="SELECT * FROM gl_account_groupCl WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$user_og->added_by."')";
                        $account_grouplogOld = DB::select($sql);
 
                   
                        if(count($account_grouplogOld) > 0){        
                        foreach($account_grouplogOld as $row){
                    
                    $class=ClassAccount::where('class_name', $row->class)->where('added_by',$user_og->added_by)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$user_og->added_by)->latest('id')->first();
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
                                    'edited' => $row->edited,
                                    'disabled' => $row->disabled,
                                    'added_by' => $user_og->added_by,
                                
                            ]);
                        }
                    
                        }
                    }
                    
                    
                    else{
                    //$account_groupOld = DB::table('gl_account_groupOld')->get();
                    
                  $sql="SELECT * FROM gl_account_groupOld WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$user_og->added_by."')";
                $account_groupOld = DB::select($sql);
                
                if(count($account_groupOld) > 0){
                    
                
                        foreach($account_groupOld as $row){
                            
                            $class=ClassAccount::where('class_name', $row->class)->where('added_by',$user_og->added_by)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$user_og->added_by)->latest('id')->first();
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
                                    'edited' => $row->edited,
                                    'disabled' => $row->disabled,
                                    'added_by' => $user_og->added_by,
                                    
                                ]);
                        }    
                            
                        }
                    }
                    
                    
                
                
                
                
                //account codes
  

                    $userRole =  User_Roles::where('user_id',$user_og->added_by)->value('role_id');
                    
                    if($userRole == 64 || $userRole == 55){
                        
                    //$account_codesSchoolOld = DB::table('gl_account_codes_school')->get();
                        
                $sql_codes="SELECT * FROM gl_account_codes_school WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$user_og->added_by."')";
  
                $account_codesSchoolOld = DB::select($sql_codes);
                
                if(count($account_codesSchoolOld) > 0){
                 foreach($account_codesSchoolOld as $row){           
                            
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user_og->added_by)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$user_og->added_by)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                            
                            
                                
                             $cID  =     DB::table('gl_account_codes')->insertGetId([
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
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
                    }
                    
                    elseif($userRole == 72 || $userRole == 46){
                        
                    //$account_codesManuOld = DB::table('gl_account_codes_manufact')->get();
                    
                $sql_codes="SELECT * FROM gl_account_codes_manufact WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$user_og->added_by."')";
  
                $account_codesManuOld = DB::select($sql_codes);
                
                if(count($account_codesManuOld) > 0){
                        
                        foreach($account_codesManuOld as $row){
                            
                             $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user_og->added_by)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$user_og->added_by)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                            
                            
                                
                             $cID  =     DB::table('gl_account_codes')->insertGetId([
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
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
                    }
                    
                    
                    elseif($userRole == 34){
                        
                    //$account_codesCourOld = DB::table('gl_account_codes_courier')->get();
                    
                $sql_codes="SELECT * FROM gl_account_codes_courier WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$user_og->added_by."')";
                $account_codesCourOld = DB::select($sql_codes);
                
                if(count($account_codesCourOld) > 0){
                        
                        foreach($account_codesCourOld as $row){
                            
                             $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user_og->added_by)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$user_og->added_by)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                            
                            
                                
                             $cID  =     DB::table('gl_account_codes')->insertGetId([
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
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
                    }
                    
                    elseif($userRole == 13){
                        
                    //$account_codesCourOld = DB::table('gl_account_codeslogis')->get();
                    
                     $sql_codes="SELECT * FROM gl_account_codeslogis WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$user_og->added_by."')";
                $account_codesCourOld = DB::select($sql_codes);
                
                if(count($account_codesCourOld) > 0){
                        
                        foreach($account_codesCourOld as $row){
                            
                             $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user_og->added_by)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$user_og->added_by)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                            
                            
                                
                             $cID  =     DB::table('gl_account_codes')->insertGetId([
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
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
                    }
                    
                    elseif($userRole == 33){
                        
                    //$account_codesCourOld = DB::table('gl_account_codeslogis')->get();
                    
                     $sql_codes="SELECT * FROM gl_account_codesInv WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$user_og->added_by."')";
                $account_codesCourOld = DB::select($sql_codes);
                
                if(count($account_codesCourOld) > 0){
                        
                        foreach($account_codesCourOld as $row){
                            
                             $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user_og->added_by)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$user_og->added_by)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                            
                            
                                
                             $cID  =     DB::table('gl_account_codes')->insertGetId([
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
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
                    }
                    
                    
                     elseif($userRole == 50){
                        
                    //$account_codesCourOld = DB::table('gl_account_codeslogis')->get();
                    
                     $sql_codes="SELECT * FROM gl_account_codesCl WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$user_og->added_by."')";
                $account_codesCourOld = DB::select($sql_codes);
                
                if(count($account_codesCourOld) > 0){
                        
                        foreach($account_codesCourOld as $row){
                            
                             $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user_og->added_by)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$user_og->added_by)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                            
                            
                                
                             $cID  =     DB::table('gl_account_codes')->insertGetId([
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
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
                    }
                    
                    
                    else{
                        
                        
                         //$account_codesOld = DB::table('gl_account_codesOld')->get();
                         
                $sql_codes="SELECT * FROM gl_account_codesOld WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$user_og->added_by."')";
                $account_codesOld = DB::select($sql_codes);
                
                if(count($account_codesOld) > 0){
                
                foreach($account_codesOld as $row){
                            
                            
                                
                             $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user_og->added_by)->first();
                             //dd($group);
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$user_og->added_by)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                            
                            
                                
                             $cID  =     DB::table('gl_account_codes')->insertGetId([
                                    
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
                                    'added_by' => $user_og->added_by,
                                    
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
                    }
                    
                    
                    //account_codes
                    
                
                 }
                 
                 //glsetup
            }
        
         

    }
}
