<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\User_Roles;
use App\Models\User_RolesCopy2;
use App\Models\CompanyRoles;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\Leave\LeaveCategory;
use App\Models\Client;
use App\Models\POS\Activity;
use App\Models\Notification;
use App\Models\Currency;
use App\Models\System;
use App\Models\Location;
use App\Models\LocationManager;
use Image;

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
    protected $redirectTo = RouteServiceProvider::INDEX;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function phonefind(Request $request){
        
        $phoneID = $request->id;
        
        $user = User::where('phone', $phoneID)->first();
        
        if(!empty($user)){
            $price="Phone exists";
        }
        else{
            $price='';
        }
        
        return response()->json($price);
        
    }
    
    public function emailfind(Request $request){
        
        $emailID = $request->id;
        
        $user = User::where('email', $emailID)->first();
        
        if(!empty($user)){
            $price="Email exists";
        }
        else{
            $price='';
        }
        
        return response()->json($price);
        
    }
     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     
     public function forgetPassword(){
         
         return view('auth.forgetPassword');
     }
     
     
     public function verify_user(Request $request)
   {

 $user_info=User::where('phone', $request->id)->where('disabled','0')->orWhere('email', $request->id)->where('disabled','0')->first();  

 if(empty($user_info)){
 $price="User not found " ;
 }


 else{
 $price='' ;
  }




 return response()->json($price);                      
 
     }
     
     
      public function get_otp(Request $request)
    {
        //
  
        $name =$request->email ;
         $user_info=User::where('phone', $name)->where('disabled','0')->orWhere('email', $name)->where('disabled','0')->first();  
         
           if(!empty($user_info)){
          $random = substr(str_shuffle(str_repeat($x='0123456789', ceil(6/strlen($x)) )),1,6);
          
         $data=DB::table('user_otp')->insert([
                        
                        'user_id' => $user_info->id,
                        'otp' =>  $random,
                        'status' => '0',
                        
                    ]);
                    
                   
                        
        $key = "891bf62609dcbefad622090d577294dcab6d0607";
        
        // $key="3b3e9650a2888de375cb46b285b4bea6e3a797e4";
        
    //   " https://sms.ema.co.tz/services/send.php?key=891bf62609dcbefad622090d577294dcab6d0607&number=0620650846&message=hello&option=1&type=sms&prioritize=0"
        
        
        $number = $user_info->phone;
        $message = "Dear  $user_info->name,You have requested to reset your password.Please use this OTP $random , to complete the process.Do not share OTP for security reasons. Assistance: +255 655 973 248. \n Powered by UjuziNet.";
          
          $option11 = 1;
          $type = "sms";
          $useRandomDevice = 1;
          $prioritize = 1;
          
        //   $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
           
           
           $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0")->json();
             
              //dd($response);       https://sms.ema.co.tz/services/send.php?key=3b3e9650a2888de375cb46b285b4bea6e3a797e4&number=#DESTINATION_NUMBER#&message=#MESSAGE_CONTENT#&option=1&type=sms&prioritize=0     
            return redirect(route('otp')); 
                        
                    }
            
            else{
               return redirect(route('otp'))->with(['error'=>'Failed.Please try again.']);; 
            }
             
        

      
        
      
        
    }
    
    
     public function verify_otp(Request $request)
   {

 $user_info=DB::table('user_otp')->where('otp', $request->id)->where('status','0')->latest('id')->first();  

 if(empty($user_info)){
 $price="OTP not found " ;
 }


 else{
 $price='' ;
  }




 return response()->json($price);                      
 
     }
     
     
      public function update_user(Request $request)
    {
        //
  
        $name =$request->email ;
         $data=DB::table('user_otp')->where('otp', $request->number)->where('status','0')->latest('id')->first(); 
         //dd($data);
         if(!empty($data)){
         $user_info=User::find($data->user_id);
         
         DB::table('user_otp')->where('otp', $request->number)->where('status','0')->latest('id')->update(['status' => '1']);
         $user_info->update(['password'=> Hash::make('11223344')]);            
                    
                    
                        
                         $notif = array(
                        'name' => 'Reset Password',
                        'description' =>'Your Password has been reset'  ,
                        'date' =>   date('Y-m-d'),
                      'from_user_id' =>  $user_info->id,
                      'added_by' =>  $user_info->added_by);
                       
                        Notification::create($notif);  ;
                        
     
        // $key="3b3e9650a2888de375cb46b285b4bea6e3a797e4";
        
        $key ="891bf62609dcbefad622090d577294dcab6d0607";
        $number = $user_info->phone;
        $message = "Dear  $user_info->name,Your password has been reset successfully. Your new password is 11223344.Please login and update password. Do not share your password for security reasons. Assistance: +255 655 973 248. \n Powered by UjuziNet.";
          
          $option11 = 1;
          $type = "sms";
          $useRandomDevice = 1;
          $prioritize = 1;
        $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0")->json();
             
              //dd($response);          
            return redirect(route('login')); 
                        
                    }
            
            else{
               return redirect(route('otp'))->with(['error'=>'Failed.Please try again.']);; 
            }
             
        

      
        
      
        
    }
     
     
     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function otp(){
         
         return view('auth.otp');
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
            'phone' => ['required', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
            'register_as' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
       
       //dd($data['picture']);
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'reference_no' => $data['reference_no'],
            'address' => $data['address'],
            'user_type' => 'customer',
            'password' => Hash::make($data['password']),
        ]);
        
        $due_date = $user->created_at->addDays(7);
        
        User::where('id',$user->id)->update(['added_by'=>$user->id, 'due_date' => $due_date,'last_login' => Carbon::now()->format('Y-m-d')]);

        $user->roles()->attach($data['register_as']);
        
         $data1['name'] = $data['name'];
        $data1['currency']=$data['currency'];
        $data1['tin'] = $data['tin'];
        $data1['vat'] = $data['vat'];
        $data1['email'] = $data['email'];
        $data1['address'] = $data['address'];
        $data1['phone']=$data['phone'];
        $data1['reference_no'] = $data['reference_no'];
       $data1['added_by'] = $user->id;
       
       
            
            	
            	  if (!empty($data['picture'])) {
     
					$photo=$data['picture'];
					
						//dd($photo);
					
					$fileType=$photo->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$logo=$fileName;
					$data1['picture'] = $logo;
					 
                $destinationPath = public_path('/assets/img/logo');
                $img = Image::make($photo->path());
                $img->resize(300, 300, function ($constraint) {
                   $constraint->aspectRatio();
                })->save($destinationPath.'/'.$logo);
        
                $destinationPath = public_path('/assets/img/original');
                $photo->move($destinationPath, $logo);
					
            	}
            	
            	
            	else{
            	  
            	  
            	  $oldPath = 'default_logo.jpg'; // publc/images/1.jpg

                    $fileExtension = \File::extension($oldPath);
                    $fileName=rand(1,1000).date('dmyhis').".".$fileExtension;
                    $logo=$fileName;
                    $data1['picture'] = $logo;

                    $destinationPath = public_path('/assets/img/logo');
                    $img = Image::make('default_logo.jpg');
                    $img->resize(300, 300, function ($constraint) {
                       $constraint->aspectRatio();
                    })->save($destinationPath.'/'.$logo);
                    
                    $newPathWithName = 'assets/img/original/'.$logo;
 
                    if (\File::copy($oldPath , $newPathWithName)) {
                        //dd("success");
                    }
     
					

            	}
            
            $system = System::create($data1);
            
        $data2['name']=$user->name.' Store';    
        $data2['type']='3';
        $data2['main']='1';
        $data2['added_by']=$user->id;
        $location = Location::create($data2);


             if(!empty($user)){
           
                    $data3 = array(
                        'manager' => $user->id,
                        'name' =>   $user->name,
                       'main' =>   '1',
                       'location_id'=>$location->id,
                         'order_no' => '0',
                        'added_by' => $user->id);
                       
                      $manager = LocationManager::create($data3);
    
    
               
        }    
        
        
        
        //register in user role copy for expire date and others
        
        $prc = Role::find($data['register_as']);
        $day=number_format($prc->day);
        $month=number_format($prc->month);
        $year=number_format($prc->year);
        
        $usrRoles = User_RolesCopy2::create([
            'user_id' => $user->id,
            'role_id' => $data['register_as'],
            'day' => $prc->day,
            'month' => $prc->month,
            'year' => $prc->year,
            'disabled' => 0,
            'due_date' => $due_date,
        ]);
        
        //hr category
        
          if($data['register_as'] == 31 ){
              

        $leave= LeaveCategory::create([
          'leave_category' => 'Annual Leave',
            'days' => '28',
            'limitation' => 'Yes',
             'added_by' => $user->id,
        ]);
        
          }
        
        //register as client  
       
        $admin=User::where('email','info@ujuzinet.com')->first();
      $client = Client::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'TIN' =>     $data['tin'],
             'VRN' => $data['vat'],
            'user_id' => $admin->id,
            'owner_id' => $admin->added_by,
            'member_id' => $user->id,
        ]);
        
        
          $dd=date('d/m/Y', strtotime($due_date));
               $notif = array(
                        'name' => 'User Registration',
                        'description' =>'Dear ' .$user->name .', You have registered to use '. $prc->slug.' package.Your Free Trial will end on '. $dd.' .Please upgrade your subscription to ensure that you take full advantage of our services'  ,
                        'date' =>   date('Y-m-d'),
                      'to_user_id' => $user->id,
                      'added_by' => $user->id);
                       
                        Notification::create($notif);  ;
                        
                         $price_notif = array(
                        'name' => 'User Registration Package',
                        'description' =>'Dear ' .$user->name .', Please check the subscription price for  '. $prc->slug.' package. Daily Price - '. $day.' TSHS , Monthly Price - '. $month.' TSHS and Yearly Price -  '. $year.' TSHS .Please upgrade your subscription to ensure that you take full advantage of our services'  ,
                        'date' =>   date('Y-m-d'),
                      'to_user_id' => $user->id,
                      'added_by' => $user->id);
                       
                        Notification::create($price_notif);  ;
                        
                        
                        $ema_notif = array(
                        'name' => 'User Registration',
                        'description' =>'User ' .$user->name .', has registered to use '. $prc->slug.' package.Free Trial will end on '. $dd  ,
                        'date' =>   date('Y-m-d'),
                        'from_user_id' => $admin->id,
                        'to_user_id' => $user->id,
                         'added_by' => $admin->added_by);
                       
                        Notification::create($ema_notif);  ;
                        
                        
                        
                         $admin_notif = array(
                        'name' => 'User Registration',
                        'description' =>'User ' .$user->name .', has registered to use '. $prc->slug.' package.Free Trial will end on '. $dd  ,
                        'date' =>   date('Y-m-d'),
                        'from_user_id' => '1',
                        'to_user_id' => $user->id,
                         'added_by' => '1');
                       
                        Notification::create($admin_notif);  ;
    

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
      
        
        // AccountType::create(['added_by'=>$user->id,'type'=>'Assets','value'=>10000]);  due_date  addDays(30)
        // AccountType::create(['added_by'=>$user->id,'type'=>'Liability','value'=>20000]);
        // AccountType::create(['added_by'=>$user->id,'type'=>'Equity','value'=>30000]);
        // AccountType::create(['added_by'=>$user->id,'type'=>'Expense','value'=>40000]);
        // AccountType::create(['added_by'=>$user->id,'type'=>'Income','value'=>50000]);  
        
        //shule  accounting -management
        if($data['register_as'] == 55 || $data['register_as'] == 64  ){
                
                //for school roles 
                
                 $account_typeSchoolOld = DB::table('gl_account_type_school')->get();
                
                foreach($account_typeSchoolOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                
                 $account_classSchoolOld = DB::table('gl_account_class_school')->get();
                
                foreach($account_classSchoolOld as $row){
                    
                    
                        
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
                
                
                $account_groupSchoolOld = DB::table('gl_account_group_school')->get();
        
                foreach($account_groupSchoolOld as $row){
            
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
                
                
               
                
                $account_codesSchoolOld = DB::table('gl_account_codes_school')->get();
                
                foreach($account_codesSchoolOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user->id)->first();
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
                
               
        
        }
        
        //manufacture role
        
        elseif($data['register_as'] == 72 || $data['register_as'] == 46 ){
                
                //for manufacture roles 
                
                   $account_typeManuOld = DB::table('gl_account_typeOld')->get();
                
                foreach($account_typeManuOld as $row){
                    
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                
                 $account_classManuOld = DB::table('gl_account_classOld')->get();
                
                foreach($account_classManuOld as $row){
                    
                    
                        
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
                
                
                $account_groupManuOld = DB::table('gl_account_group_manufact')->get();
        
                foreach($account_groupManuOld as $row){
            
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
                
                
               
                
                 $account_codesManuOld = DB::table('gl_account_codes_manufact')->get();
                
                foreach($account_codesManuOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user->id)->first();
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
                
               

        }
        
        //courier roles
        elseif($data['register_as'] == 34 ){
                
                //for courier roles 
                
                     $account_typeCourOld = DB::table('gl_account_type_courier')->get();
                
                foreach($account_typeCourOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                
                 $account_classCourOld = DB::table('gl_account_class_courie')->get();
                
                foreach($account_classCourOld as $row){
                    
                    
                        
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
                
                
                $account_groupCourOld = DB::table('gl_account_group_cour')->get();
        
                foreach($account_groupCourOld as $row){
            
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
                
                
               
                
               $account_codesCourOld = DB::table('gl_account_codes_courier')->get();
                
                foreach($account_codesCourOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user->id)->first();
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
                
                
        
        }
        
        //logistic role
        elseif($data['register_as'] == 13){
                
                //for logistics roles 
                
                   $account_typeCourOld = DB::table('gl_account_typelogis')->get();
                
                foreach($account_typeCourOld as $row){
                    
                   
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                
                 $account_classCourOld = DB::table('gl_account_classlogis')->get();
                
                foreach($account_classCourOld as $row){
                    
                    
                        
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
                
                
               $account_groupCourOld = DB::table('gl_account_grouplogis')->get();
        
                foreach($account_groupCourOld as $row){
            
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
                
                
               
                
                $account_codesCourOld = DB::table('gl_account_codeslogis')->get();
                
                foreach($account_codesCourOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user->id)->first();
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
                
               
        
        }
        
         //Vehicle inventory role
        elseif($data['register_as'] == 33){
                
                //for Vehicle inventory roles 
                
                   $account_typeCourOld = DB::table('gl_account_typeInv')->get();
                
                foreach($account_typeCourOld as $row){
                    
                   
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                
                 $account_classCourOld = DB::table('gl_account_classInv')->get();
                
                foreach($account_classCourOld as $row){
                    
                    
                        
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
                
                
               $account_groupCourOld = DB::table('gl_account_groupInv')->get();
        
                foreach($account_groupCourOld as $row){
            
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
                
                
               
                
                $account_codesCourOld = DB::table('gl_account_codesInv')->get();
                
                foreach($account_codesCourOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user->id)->first();
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
                
               
        
        }
        
          //clearing role
        elseif($data['register_as'] == 50){
                
                //for Cleariing roles 
                
                   $account_typeCourOld = DB::table('gl_account_typeCl')->get();
                
                foreach($account_typeCourOld as $row){
                    
                   
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                
                 $account_classCourOld = DB::table('gl_account_classCl')->get();
                
                foreach($account_classCourOld as $row){
                    
                    
                        
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
                
                
               $account_groupCourOld = DB::table('gl_account_groupCl')->get();
        
                foreach($account_groupCourOld as $row){
            
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
                
                
               
                
                $account_codesCourOld = DB::table('gl_account_codesCl')->get();
                
                foreach($account_codesCourOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$user->id)->first();
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
                
               
        
        }
        
        //other roles
        else{
            
                $account_typeOld = DB::table('gl_account_typeOld')->get();
            
            foreach($account_typeOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
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
            
            
           
        }
        
        // $key = "891bf62609dcbefad622090d577294dcab6d0607";
        //   $number = "0747022515";
        
        $rl=Role::find($data['register_as']);
        
        $key="3b3e9650a2888de375cb46b285b4bea6e3a797e4";
        $number = $user->phone;
        $message = "Dear  $user->name, $rl->message ";
          
          $option11 = 1;
          $type = "sms";
          $useRandomDevice = 1;
          $prioritize = 1;
          
        //   $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
           
           $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0 ")->json();
            
           

        return $user;
    }
    
    public function affiliate_register(){
        
        return view('auth.affiliate_register');
    }
    
    public function affiliate_register_store(Request $request){
        
        $this->validate($request,[
            
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'address' => ['required', 'string', 'max:255'],
            'register_as' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
        ]); 
        
        $user =  User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'user_type' => 'affiliate',
            'password' => Hash::make($request['password']),
        ]);
        
        if($user){
            
            $affiliate = "EMA0".$user->id;


            User::where('id',$user->id)->update(['added_by'=>$user->id, 'affiliate_no' => $affiliate]);
        
            $roles_added2 = Role::where('slug', $request['register_as'])->first();
                    
            $role_user_id =  $roles_added2->id;
    
            $user->roles()->attach($role_user_id);
            
            return redirect()->route('login');

        }
        else{
            
                    return back()->with('error', "Registration Failed, Please Try Again Later.");
        }
        
        
    }
    
    
    
    
    
    
    
    
    public function ema80x_register(){
        
        return view('auth.ema80x_register');
    }
    
    public function ema80x_register_store(Request $request){
        
        $this->validate($request,[
            
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'address' => ['required', 'string', 'max:255'],
            'register_as' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
        ]); 
        
        $user =  User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'user_type' => 'ema80x',
            'password' => Hash::make($request['password']),
        ]);
        
        if($user){
            
            $affiliate = "EMA80X".$user->id;


            User::where('id',$user->id)->update(['added_by'=>$user->id, 'affiliate_no' => $affiliate]);
        
            $roles_added2 = Role::where('slug', $request['register_as'])->first();
                    
            $role_user_id =  $roles_added2->id;
    
            $user->roles()->attach($role_user_id);
            
            return redirect()->route('login');

        }
        else{
            
                    return back()->with('error', "Registration Failed, Please Try Again Later.");
        }
        
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}