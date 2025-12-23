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
use App\Models\Notification;
use Illuminate\Support\Facades\Http;
use App\Models\Dd_Version;
use App\Models\AppVersion;

use Carbon\Carbon;

// use App\Models\User_Roles;
// use App\Models\User_RolesCopy2;

class Auth_ApiController extends Controller
{
   
    /**
     * Login function.
     *
     * @return \Illuminate\Http\Response
     */
     public function login44(Request $request)
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
                    
                    $usersdd = User_RolesCopy2::where('user_id', $user->id)->first();
                    
                    $user['subscription_day'] = $usersdd->day;
                    
                    $user['subscription_week'] = $usersdd->day * 7;
                    
                    $user['subscription_month'] = $usersdd->month;
                    
                    $user['subscription_year'] = $usersdd->year;
        
                    
        
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
    
    public function get_version2(){

        $tools = Dd_Version::select('id','name','priority')->orderBy('id', 'DESC')->first();

    //    $tools = DB::table('db_Version')->select('id','name','priority')->orderBy('id', 'DESC')->limit('1');

        if($tools){

            

            $response=['success'=>true,'error'=>false,'message'=>'Version Found successful', 'data' => $tools];
           return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'Version Not Found'];
            return response()->json($response,200);

        }


   }
   
   
   public function store_test(){
        
        
        // $companyToken = "7ACE1FBA-C486-4848-BE90-2F37E31049A4";
        $companyToken = "8D3DA73D-9D7F-4E09-96D4-3D44E7A83EA3";
        // $paymentAmount = $order->total_amount;
        $paymentAmount = 30.00;
        $paymentCurrency = "USD";
        // $companyRef = $order->order_number;
        $companyRef = "ORD900";
        // $redirectUrl = "https://finehairtextures.co.tz/redirectUrl";
        $redirectUrl = "https://finehairtextures.co.tz/redirectUrl";
        $backUrl = "https://finehairtextures.co.tz/backUrl";
        $ptl = 5;
        $serviceType = 45;
        $serviceDescription = "Buying with finehairtextures";
        $serviceDate = Carbon::now()->format('Y/m/d H:i');
        $customerFname = "UJUZINET";
        $customeLname = "TEST";
        $customerEmail = "rajabupazi89@gmail.com";
        $customerPhone = "255747022515";
        
        // dd($serviceDate);   https://secure.3gdirectpay.com/payv3.php?ID=token
          
        
        
        
        $endpoint = "https://secure.3gdirectpay.com/API/v6/";
        
        
        $xmlData = "<?xml version=\"1.0\" encoding=\"utf-8\"?><API3G><CompanyToken>$companyToken</CompanyToken><Request>createToken</Request><Transaction><PaymentAmount>$paymentAmount</PaymentAmount><PaymentCurrency>$paymentCurrency</PaymentCurrency><CompanyRef>$companyRef</CompanyRef><RedirectURL>$redirectUrl</RedirectURL><BackURL>$backUrl </BackURL><CompanyRefUnique>0</CompanyRefUnique><PTL>$ptl</PTL></Transaction><Services><Service><ServiceType>$serviceType</ServiceType><ServiceDescription>$serviceDescription</ServiceDescription><ServiceDate>$serviceDate</ServiceDate></Service></Services></API3G>";
        
        // dd($xmlData);
        $ch = curl_init();
        
        if (!$ch) {
            die("Couldn't initialize a cURL handle");
        }
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
        
        
        $result = curl_exec($ch);
        
        if($result === false){
			throw new Exception(curl_error($ch),curl_errno($ch));
			
		}
		
		dd($result);
		
		$encode_response = json_encode(simplexml_load_string($result));   

        $decode_response = json_decode($encode_response, TRUE);
        
        //   dd($decode_response['ResultExplanation']);
		
// 		$xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);

		
// 		dd($xml->ResultExplanation);

        $xytt22 = $decode_response['ResultExplanation'];

        $xytt = "Your product successfully placed in order succefully, and TokenCreation returns $xytt22";
        
        // dd($xytt);
        
        curl_close($ch);
        
        $response=['success'=>true,'error'=>false,'message'=>'successfully','output'=>$xytt22];
        return response()->json($response,200);
        
    }
    
    public function app_version_index()
   {
       //
               
               $client = AppVersion::latest()->first();
        
               if(!empty($client)){
        
                // foreach($client as $row){
        
                    $data = $client;
        
                    $farmers = $data;
         
                // }
        
                $response=['success'=>true,'error'=>false,'message'=>'successfully','app_version'=>$farmers];
                return response()->json($response,200);
            }
            else{
        
                $response=['success'=>false,'error'=>true,'message'=>'No Such Date found'];
                return response()->json($response,200);
            }
     
       
       
      
   }
    
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
         $usrDD = User::where('phone',$request->email)->where('disabled','0')->orWhere('email', $request->email)->where('disabled','0')->get()->first();
        $last_login = $usrDD->update(['last_login' => Carbon::now()->format('Y-m-d')]); 
                    
        $user=User::where('phone', $request->email)->orWhere('email', $request->email)->first();
        
        if(!empty($user)){
        
        $userRole =  User_Roles::where('user_id',$user->added_by)->value('role_id');
        
        // dd($userRole);
        
            
            if($userRole == 53 || $userRole == 66 || $userRole == 67 || $userRole == 58 || $userRole == 46 || $userRole == 72 || $userRole == 1){
                
                // dd($userRole);
                
                if($user && Hash::check($request->password,$user->password))
                {
                    // dd($userRole);
                    // $role = $user->roles()->name;
                    $department_id = $user->department_id;
                    $designation_id = $user->designation_id;
                //    $role =  Role::where('u')
                    $roleId = DB::table('users_roles')->where('user_id', $user->id)->value('role_id');
                    $role = Role::where('id', $roleId)->value('slug');
                    $user['role'] = $role;
                    
                    $nowDT = Carbon::now();
                    
                    // dd($user->added_by);
    
                    $usrRoles11 = User_RolesCopy2::where('user_id', $user->added_by)->whereDate('due_date', '<', $nowDT)->get();
                    // dd($user->added_by);
                    
                    
                    if($usrRoles11->isNotEmpty()){
                        
                        // dd($usrRoles11);
        
                        foreach($usrRoles11 as $row22){
                            
                            $usr_rol = User_Roles::where('user_id', $row22->user_id)->where('role_id', $row22->role_id)->first();
                            
                            if(!empty($usr_rol)){
                                
                                $xyzDD =  User::find($usr_rol->user_id);
                                
                                $ttupdt =  $xyzDD->update(['mobile_status' => 'inactive']);
                                
                                $xyzDD->roles()->detach($usr_rol->role_id);
                            }
                            
                            
                            
                        }
                        
                            $usersdd = User_RolesCopy2::where('user_id', $row22->user_id)->first();
                            
                            $user['due_date'] = $usersdd->due_date;
                    
                            $user['subscription_day'] = $usersdd->day;
                            
                            $user['subscription_week'] = strval($usersdd->day * 7);
                            
                            $user['subscription_month'] = $usersdd->month;
                            
                            $user['subscription_year'] = $usersdd->year;
                        
                        $countUr = User_Roles::where('user_id', $user->added_by)->count();
                        
                        if($countUr == 0){
                            
                            // $response=['success'=>false,'error'=>true,'message'=>'incorrect email or password'];
                            // return response()->json($response,200);
                            
                            $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user];
        
                            return response()->json($response,200);
                            
                            
                        }
                        else{
                            
                            $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user];
        
                            return response()->json($response,200);
                            
                        }
                        
                    }
                    
                    else{
                        
                        $usersdd = User_RolesCopy2::where('user_id', $user->added_by)->first();
                            $user['due_date'] = $usersdd->due_date;
                    
                            $user['subscription_day'] = $usersdd->day;
                            
                            $user['subscription_week'] = strval($usersdd->day * 7);
                            
                            $user['subscription_month'] = $usersdd->month;
                            
                            $user['subscription_year'] = $usersdd->year;
                        
                            $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user];
        
                            return response()->json($response,200);
                        
                    }
        
                    
        
                    // $token= $user->createToken('Personal Access Token')->plainTextToken;
                    // $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user,'token'=>$token];
                    // $response=['success'=>true,'error'=>false,'message'=>'User login successfully','user'=>$user];
        
                    // return response()->json($response,200);
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
    
    
    public function forgetPassword(Request $request){
        
        
        $user_info=User::where('phone', $request->input('user_validation'))->where('disabled','0')->orWhere('email', $request->input('user_validation'))->where('disabled','0')->first();  

         if(!empty($user_info)){
             
                $random = substr(str_shuffle(str_repeat($x='0123456789', ceil(6/strlen($x)) )),1,6);
             
                $data=DB::table('user_otp')->insert([
                        
                        'user_id' => $user_info->id,
                        'otp' =>  $random,
                        'status' => '0',
                        
                    ]);
                    
                    
                     if(!empty($data)){
                        
                    // $key = "891bf62609dcbefad622090d577294dcab6d0607";
                    
                    $key="3b3e9650a2888de375cb46b285b4bea6e3a797e4";
                    
                    
                    $number = $user_info->phone;
                    $message = "Dear  $user_info->name,You have requested to reset your password.Please use this OTP $random , to complete the process.Do not share OTP for security reasons. Assistance: +255 655 973 248. \n Powered by UjuziNet.";
                      
                      $option11 = 1;
                      $type = "sms";
                      $useRandomDevice = 1;
                      $prioritize = 1;
                      
                    //   $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
                       
                       
                       $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0 ")->json();
                            
                        // return redirect(route('otp')); 
                        
                        
                            $response=['success'=>true,'error'=>false,'message'=>'OTP Successfully Sent'];
        
                            return response()->json($response,200);
                        
                    }
            
                    else{
                       
                       $response=['success'=>false,'error'=>true,'message'=>'Failed,Please try again'];
                        return response()->json($response,200);
                    }
         
         }
        
        
         else{
             
                        $response=['success'=>false,'error'=>true,'message'=>'User Not Found'];
                        return response()->json($response,200);
         
          }
         
        //  return view('auth.forgetPassword');
     }
     
     
     
    public function update_user_password(Request $request)
    {
        //
  
        // $name =$request->email ;
         $data=DB::table('user_otp')->where('otp', $request->input('otp'))->where('status','0')->latest('id')->first(); 
         //dd($data);
         if(!empty($data)){
             
                     $user_info=User::find($data->user_id);
                     
                     DB::table('user_otp')->where('otp', $request->input('otp'))->where('status','0')->latest('id')->update(['status' => '1']);
                     $user_info->update(['password'=> Hash::make('11223344')]);            
                                
                                
                                    
                                     $notif = array(
                                    'name' => 'Reset Password',
                                    'description' =>'Your Password has been reset'  ,
                                    'date' =>   date('Y-m-d'),
                                  'from_user_id' =>  $user_info->id,
                                  'added_by' =>  $user_info->added_by);
                                   
                                    Notification::create($notif);  ;
                                    
                 
                    $key="3b3e9650a2888de375cb46b285b4bea6e3a797e4";
                    $number = $user_info->phone;
                    $message = "Dear  $user_info->name,Your password has been reset successfully. Your new password is 11223344.Please login and update password. Do not share your password for security reasons. Assistance: +255 655 973 248. \n Powered by UjuziNet.";
                      
                      $option11 = 1;
                      $type = "sms";
                      $useRandomDevice = 1;
                      $prioritize = 1;
                    $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0 ")->json();
                         
                          //dd($response);          
                        // return redirect(route('login')); 
                        
                            $response=['success'=>true,'error'=>false,'message'=>'Password Successfully Reseted'];
        
                            return response()->json($response,200);
                        
                    }
            
            else{
                
                
            //   return redirect(route('otp'))->with(['error'=>'Failed.Please try again.']);; 
               
               $response=['success'=>false,'error'=>true,'message'=>'Failed, OTP Not Found, Please try again'];
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
                User::where('id',$user->id)->update(['added_by'=>$user->id, 'due_date' => $due_date,'last_login' => Carbon::now()->format('Y-m-d')]);
                
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
                        'description' =>'Dear ' .$user->name .', Please check the subscription price for  '. $prc->slug.' package. Daily Price - '. $prc->day.' TSHS , Monthly Price - '. $prc->month.' TSHS and Yearly Price -  '. $prc->year.' TSHS .Please upgrade your subscription to ensure that you take full advantage of our services'  ,
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
            
        
            //  $key = "891bf62609dcbefad622090d577294dcab6d0607";
            
            
             $rl = Role::where('id', 53)->first();
            $key= "3b3e9650a2888de375cb46b285b4bea6e3a797e4";
            $number = $user->phone;
           $message = "Dear  $user->name, $rl->message ";
          $option11 = 1;
          $type = "sms";
          $useRandomDevice = 1;
          $prioritize = 1;
          
        //   $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
       
       $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0 ")->json();
       
       
       
                            $usersdd = User_RolesCopy2::where('user_id', $user->id)->first();
                            
                            $user['due_date'] = $usersdd->due_date;
                    
                            $user['subscription_day'] = $usersdd->day;
                            
                            $user['subscription_week'] = strval($usersdd->day * 7);
                            
                            $user['subscription_month'] = $usersdd->month;
                            
                            $user['subscription_year'] = $usersdd->year;
                            
                            $user['mobile_status']   = 'active';
            
        
        
        
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