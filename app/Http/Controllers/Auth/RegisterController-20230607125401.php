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
use App\Models\User_Roles;
use App\Models\User_RolesCopy2;
use App\Models\CompanyRoles;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\Client;
use App\Models\POS\Activity;


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
        
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'user_type' => 'customer',
            'password' => Hash::make($data['password']),
        ]);
        
        $due_date = $user->created_at->addDays(7);
        
        User::where('id',$user->id)->update(['added_by'=>$user->id, 'due_date' => $due_date]);

        $user->roles()->attach($data['register_as']);
        
        //register in user role copy for expire date and others
        
        $prc = Role::find($data['register_as']);
        
        $usrRoles = User_RolesCopy2::create([
            'user_id' => $user->id,
            'role_id' => $data['register_as'],
            'price' => $prc->price,
            'disabled' => 0,
            'due_date' => $due_date,
        ]);
        
        //register as client  
       
        $admin=User::where('email','info@ujuzinet.com')->first();
      $client = Client::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
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
        
        
        // AccountType::create(['added_by'=>$user->id,'type'=>'Assets','value'=>10000]);  due_date  addDays(30)
        // AccountType::create(['added_by'=>$user->id,'type'=>'Liability','value'=>20000]);
        // AccountType::create(['added_by'=>$user->id,'type'=>'Equity','value'=>30000]);
        // AccountType::create(['added_by'=>$user->id,'type'=>'Expense','value'=>40000]);
        // AccountType::create(['added_by'=>$user->id,'type'=>'Income','value'=>50000]);  
        
        //shule  accounting -management
        if($data['register_as'] == 55 || $data['register_as'] == 64  ){
                
                //for school roles 
                
                $account_groupSchoolOld = DB::table('gl_account_group_school')->get();
        
                foreach($account_groupSchoolOld as $row){
            
            
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $row->group_id,
                    'name' => $row->name,
                    'class' => $row->class,
                    'type' => $row->type,
                    'order_no' => $row->order_no,
                    'added_by' => $user->id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                    
                    
                ]);
                
            
                }
                
                
                $account_typeSchoolOld = DB::table('gl_account_type_school')->get();
                
                foreach($account_typeSchoolOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                $account_codesSchoolOld = DB::table('gl_account_codes_school')->get();
                
                foreach($account_codesSchoolOld as $row){
                    
                    
                        
                    $cID =    DB::table('gl_account_codes')->insertGetId([
                            
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
                
                $account_classSchoolOld = DB::table('gl_account_class_school')->get();
                
                foreach($account_classSchoolOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'disabled' => $row->disabled,
                            'added_by' => $user->id,
                            
                        ]);
                     
                    
                }
        
        }
        
        //manufacture role
        
        elseif($data['register_as'] == 72 || $data['register_as'] == 46 ){
                
                //for school roles 
                
                $account_groupManuOld = DB::table('gl_account_group_manufact')->get();
        
                foreach($account_groupManuOld as $row){
            
            
                
                    DB::table('gl_account_group')->insert([
                        
                        'group_id' => $row->group_id,
                    'name' => $row->name,
                    'class' => $row->class,
                    'type' => $row->type,
                    'order_no' => $row->order_no,
                    'added_by' => $user->id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                        
                    ]);
                
            
                }
                
                
                $account_typeManuOld = DB::table('gl_account_typeOld')->get();
                
                foreach($account_typeManuOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                $account_codesManuOld = DB::table('gl_account_codes_manufact')->get();
                
                foreach($account_codesManuOld as $row){
                    
                    
                        
                     $cID =  DB::table('gl_account_codes')->insertGetId([
                            
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
                
                $account_classManuOld = DB::table('gl_account_classOld')->get();
                
                foreach($account_classManuOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'disabled' => $row->disabled,
                            'added_by' => $user->id,
                            
                        ]);
                     
                    
                }
        
        }
        
        //courier roles
        elseif($data['register_as'] == 34 ){
                
                //for courier roles 
                
                $account_groupCourOld = DB::table('gl_account_group_cour')->get();
        
                foreach($account_groupCourOld as $row){
            
            
                
                    DB::table('gl_account_group')->insert([
                        
                    'group_id' => $row->group_id,
                    'name' => $row->name,
                    'class' => $row->class,
                    'type' => $row->type,
                    'order_no' => $row->order_no,
                    'added_by' => $user->id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                        
                    ]);
                
            
                }
                
                
                $account_typeCourOld = DB::table('gl_account_type_courier')->get();
                
                foreach($account_typeCourOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                $account_codesCourOld = DB::table('gl_account_codes_courier')->get();
                
                foreach($account_codesCourOld as $row){
                    
                    
                        
                    $cID  =  DB::table('gl_account_codes')->insertGetId([
                            
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
                
                $account_classCourOld = DB::table('gl_account_class_courie')->get();
                
                foreach($account_classCourOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'disabled' => $row->disabled,
                            'added_by' => $user->id,
                            
                        ]);
                     
                    
                }
        
        }
        
        //logistic role
        elseif($data['register_as'] == 13){
                
                //for courier roles 
                
                $account_groupCourOld = DB::table('gl_account_grouplogis')->get();
        
                foreach($account_groupCourOld as $row){
            
            
                
                    DB::table('gl_account_group')->insert([
                        
                        'group_id' => $row->group_id,
                    'name' => $row->name,
                    'class' => $row->class,
                    'type' => $row->type,
                    'order_no' => $row->order_no,
                    'added_by' => $user->id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                        
                    ]);
                
            
                }
                
                
                $account_typeCourOld = DB::table('gl_account_typelogis')->get();
                
                foreach($account_typeCourOld as $row){
                    
                   
                        
                        DB::table('gl_account_type')->insert([
                            // 'account_type_id' => $row->account_type_id,
                            'value' => $row->value,
                            'type' => $row->type,
                            'added_by' => $user->id,
                            
                        ]);
                        
                    
                }
                
                $account_codesCourOld = DB::table('gl_account_codeslogis')->get();
                
                foreach($account_codesCourOld as $row){
                    
                    
                        
                    $cID  =    DB::table('gl_account_codes')->insertGetId([
                            
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
                
                $account_classCourOld = DB::table('gl_account_classlogis')->get();
                
                foreach($account_classCourOld as $row){
                    
                    
                        
                        DB::table('gl_account_class')->insert([
                            
                            'class_id' => $row->class_id,
                            'class_name' => $row->class_name,
                            'class_type' => $row->class_type,
                            'order_no' => $row->order_no,
                            'disabled' => $row->disabled,
                            'added_by' => $user->id,
                            
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
                    'added_by' => $user->id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                        
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
            
            $account_classOld = DB::table('gl_account_classOld')->get();
            
            foreach($account_classOld as $row){
                
                
                    
                    DB::table('gl_account_class')->insert([
                        
                       'class_id' => $row->class_id,
                        'class_name' => $row->class_name,
                        'class_type' => $row->class_type,
                        'order_no' => $row->order_no,
                        'disabled' => $row->disabled,
                        'added_by' => $user->id,
                        
                    ]);
                 
                
            }
        }
        
        $key = "891bf62609dcbefad622090d577294dcab6d0607";
        //   $number = "0747022515";
          $number = $user->phone;
        //   $message = "Thank you $member->full_name, $member->member_id, for depositing Tsh. $data->amount on $dateT with receipt no: $data->reference to Gymkhana Club. Your deposit balance is now Tsh. $member->balance. \n Powered by UjuziNet.";
           $message = "Welcome to EMASUITE $user->name , Your registration is successful. If you have any questions or need assistance, call us on +255 655 973 248. \n Powered by UjuziNet.";
          $option11 = 1;
          $type = "sms";
          $useRandomDevice = 1;
          $prioritize = 1;
          
          $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
           
           

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
}
