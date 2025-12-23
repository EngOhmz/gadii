<?php

namespace App\Http\Controllers\AzamPesa;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\User_Roles;
use App\Models\User_RolesCopy2;

use PDF;

use App\Models\AccountCodes;
use App\Models\POS\Activity;
use App\Models\POS\InvoicePayments;
use App\Models\POS\Items;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
use App\Models\Client;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\POS\InvoiceAttachment;
use App\Models\Branch;

use App\Models\POS\InvoiceHistory;


use Exception;
use App\Models\AzamPesa\CallBackData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\UserDetails\DueDate;


class IntegrationDepositController extends Controller
{   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
       //
       $items = DB::table('integration_deposits')->where('user_id',  Auth::user()->id)->select("*")->orderBy('id', 'desc')->select("*")->get();
       
       $roles = Role::leftJoin('user_role_copy2', 'roles.id','user_role_copy2.role_id')
                          ->where('user_role_copy2.user_id',auth()->user()->id)
                           ->where('roles.status','1')
                           ->select('roles.*')
                              ->get()  ;
                              
                              //dd($role);
      
       return view('AzamPesa.index',compact('items','roles'));
   }
   
   public function api_index(int $id)
   {
       //
       
       $usr = User::find($id);
       
       if(!empty($usr)){
           
       $items = DB::table('integration_deposits')->where('user_id',  $usr->added_by)->where('status', 2)->select("*")->orderBy('id', 'desc')->select("*")->get();
       
           if($items->isNotEmpty()){
                   foreach($items as $row){
                       
                       $data = $row;
                   }
               
                $response=['success'=>true,'error'=>false,'message'=>'successfully','user_payment_details'=>$data];
                return response()->json($response,200);
               
               
           }
           else{
               
               $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                    return response()->json($response,200);
               
           }
           
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
   }
   
   public function index2(Request $request)
   {
       //
       $items = DB::table('integration_deposits')->where('user_id',  Auth::user()->id)->select("*")->orderBy('id', 'desc')->get();
       
       $roles = Role::leftJoin('user_role_copy2', 'roles.id','user_role_copy2.role_id')
                          ->where('user_role_copy2.user_id',auth()->user()->id)
                           ->where('roles.status','1')
                           ->select('roles.*')
                              ->get()  ;
      
       return view('AzamPesa.index2',compact('items', 'roles'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {

        // $url = "https://sandbox.azampay.co.tz/azampay/mno/checkout";
        
        $url = "https://checkout.azampay.co.tz/azampay/mno/checkout";
        // $url = "https://checkout.azampay.co.tz/";
        
       
        
        $token = $this->get_token();
        
        // $xamount = str_replace(",","",$request->amount);
		
		$data['accountNumber'] = $request->accountNumber;
		$data['amount'] = str_replace(",","",$request->amount);
		$data['currency'] = "TZS";
		$data['externalId'] = "021";
		$data['provider'] = $request->provider;
		
        
        $authorization = "Authorization: Bearer ".$token;

	
            $header = array(
             'Content-Type: application/json',
             $authorization,
             );
	try{
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data));
		
		$result = curl_exec($ch);
		
		if($result === false){
			throw new Exception(curl_error($ch),curl_errno($ch));
			
		}
		$result = json_decode($result);
		
		$saved_data['user_id'] = Auth::user()->id;
		$saved_data['phone'] = $data['accountNumber'];
		$saved_data['amount'] = $data['amount'];
		$saved_data['status'] = 1;
		$saved_data['reference_no'] = $result->transactionId;
		$saved_data['added_by'] = Auth::user()->added_by;
		$saved_data['role_id'] = $request->role_id;
		
		$saved_data['mobile_user'] = 1;
		
// 		$saved_data['user_id'] = Auth::user()->id;
// 		$saved_data['user_id'] =Auth::user()->id;
		
		
	      DB::table('integration_deposits')->insert($saved_data);
		
		
// 		dd($result);
		
		return redirect()->back()->with(['success'=>$result->message]);
		 
	   // echo $result.transactionId;
		
	}
	
	catch(Exception $e){
		
		trigger_error(sprintf('ERROR  #%d :%s',$e->getCode(),$e->getMessage()),E_USER_ERROR);
		//echo $request;
	}
	
	finally {
		if(is_resource($ch)){
		curl_close($ch);
		}

	}	

      // return redirect(route('items.index'));
   }
   
   public function store_api(Request $request)
   {

        // $url = "https://sandbox.azampay.co.tz/azampay/mno/checkout";
        
        $url = "https://checkout.azampay.co.tz/azampay/mno/checkout";
        // $url = "https://checkout.azampay.co.tz/";
        
       
        
        $token = $this->get_token();
        
        // $xamount = str_replace(",","",$request->amount);
		
		$data['accountNumber'] = $request->phone;
		$data['amount'] = $request->amount;
		$data['currency'] = "TZS";
		$data['externalId'] = "021";
		$data['provider'] = $request->provider;
		
        
        $authorization = "Authorization: Bearer ".$token;

	
            $header = array(
             'Content-Type: application/json',
             $authorization,
             );
	try{
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data));
		
		$result = curl_exec($ch);
		
		if($result === false){
			throw new Exception(curl_error($ch),curl_errno($ch));
			
		}
		$result = json_decode($result);
		
		$usr = User::find($request->id);
		
		
		$saved_data['user_id'] = $usr->id;
		$saved_data['phone'] = $data['accountNumber'];
		$saved_data['amount'] = $data['amount'];
		$saved_data['status'] = 1;
		$saved_data['reference_no'] = $result->transactionId;
		$saved_data['added_by'] = $usr->added_by;
		$saved_data['role_id'] = 53;
		
		$saved_data['mobile_user'] = 1;
		
// 		$saved_data['user_id'] = Auth::user()->id;
// 		$saved_data['user_id'] =Auth::user()->id;
		
		
	   $xyDB =   DB::table('integration_deposits')->insert($saved_data);
	     
	     $dbID = $result->message;
		
		
// 		dd($result);

    if($xyDB){
        
            $response=['success'=>true,'error'=>false,'message'=>'successfully','deposit'=>$dbID];
            return response()->json($response,200);
        
    }
    else{
            $response=['success'=>false,'error'=>true,'message'=>'Failed to save'];
            return response()->json($response,200);
    }
		
// 		return redirect()->back()->with(['success'=>$result->message]);
		 
	   // echo $result.transactionId;
		
	}
	
	catch(Exception $e){
		
		trigger_error(sprintf('ERROR  #%d :%s',$e->getCode(),$e->getMessage()),E_USER_ERROR);
		//echo $request;
	}
	
	finally {
		if(is_resource($ch)){
		curl_close($ch);
		}

	}	

      // return redirect(route('items.index'));
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       //
   }
   
   public function get_call_back_data(Request $request){
       
         
        $data= new CallBackData();
        
        $data->amount=$request->amount;
        $data->message=$request->message;
        $data->msisdn=$request->msisdn;
        $data->operator=$request->operator;
        $data->reference=$request->reference;
        $data->submerchantAcc=$request->submerchantAcc;
        $data->transactionstatus=$request->transactionstatus;
        $data->utilityref=$request->utilityref;
        $data->save();
        
        
        if($data->transactionstatus == "success"){
            
            
            
            
          $dbDeposit = DB::table('integration_deposits')->where('reference_no', $data->reference)->latest('id')->first();
          
          
          
          $usr = User::find($dbDeposit->user_id);
          
          if(!empty($usr)){
              
              $checkusrRole = User_Roles::where('user_id', $usr->id)->where('role_id', $dbDeposit->role_id)->first();
              
              if(!empty($checkusrRole)){
                  
                  $checkusrRoleCopy2 = User_RolesCopy2::where('user_id', $usr->id)->where('role_id', $dbDeposit->role_id)->first();
                  
                  if(!empty($checkusrRoleCopy2)){
                      
                      $prc = Role::find($dbDeposit->role_id);
                      
                      //daily
                      if($checkusrRoleCopy2->day <= $data->amount && $data->amount <  $checkusrRoleCopy2->month ){
                        $x=$data->amount/ $checkusrRoleCopy2->day;
                         $due_date=floor($x);;
                               
                               $nowDT = Carbon::now();
                                $due_dateOld = Carbon::createFromFormat('Y-m-d',  $checkusrRoleCopy2->due_date); 
                                
                                // dd($due_dateOld);
                                
                                if($due_dateOld > $nowDT)
                                {
                                    $now = $due_dateOld;
                                }
                                else{
                                    
                                    $now = $nowDT;
                                    
                                }
                            
                                       
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                            $xx=$due_date.' days';;
                             //dd($xx);
                             
                   
                    }
                        
                        //monthly
                       else if($checkusrRoleCopy2->month <= $data->amount && $data->amount <  $checkusrRoleCopy2->year ){
                        $x=$data->amount/ $checkusrRoleCopy2->month;
                         $due_date=ceil($x * 30.436875);
                          $y=0;
       
                        $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) 
                		$m = floor($m); // Remove
                
                		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                	    $d = floor($d); // the rest of days
                        
                        if($m > 0 && $d > 0){
                		$xx=$m.' months and '.$d.' days';
                        }
                        else if($m > 0 && $d== 0){
                          $xx=$m.' months';  
                        }
                               
                               $nowDT = Carbon::now();
                                $due_dateOld = Carbon::createFromFormat('Y-m-d',  $checkusrRoleCopy2->due_date); 
                                
                                // dd($due_dateOld);
                                
                                if($due_dateOld > $nowDT)
                                {
                                    $now = $due_dateOld;
                                }
                                else{
                                    
                                    $now = $nowDT;
                                    
                                }
                            
                                     
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                           
                             //dd($xx);
                             
                   
                    }
                    
                    //yearly
                    else if($data->amount >= $checkusrRoleCopy2->year ){
                        $x=$data->amount/ $checkusrRoleCopy2->year;
                         $ii=floor($x);;
                         
                         $rem=$data->amount - ($ii * $checkusrRoleCopy2->year);
            
                            $nd=0;
                           
                            if($rem > 0){
                                
                            if($checkusrRoleCopy2->day <= $rem && $rem < $checkusrRoleCopy2->month ){
                            $rx=$rem/$checkusrRoleCopy2->day;
                            $nd=floor($rx);
                        }
                        
                         else if($checkusrRoleCopy2->month <= $rem && $rem < $checkusrRoleCopy2->year ){
                            $rx=$rem/$checkusrRoleCopy2->month;
                            $nd=ceil($rx * 30.436875);
                           
                                
                        } 
                            
                               
                            }
                            
                            $due_date=($ii * 365) + $nd;
                            //dd($nd);
        
                            $y = ($due_date / 365) ; // days / 365 days
                    		$y = floor($y); // Remove all decimals
                                
                           $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) 
                    		$m = floor($m); // Remove
                    
                    		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                    		$d = floor($d); // the rest of days
                    
                            if($y > 0 && $m > 0 && $d > 0){
                            $xx= $y.' years , '.$m.' months and '.$d.' days';
                            }
                            else if($y > 0 && $m == 0 && $d > 0){
                    		$xx=$y.' years and '.$d.' days';
                            }
                            else if($y > 0 && $m > 0 && $d == 0){
                    		$xx=$y.' years and '.$m.' months';
                            }
                           else if($y > 0 && $m == 0 && $d == 0){
                              $xx=$y.' years';  
                            }
                                                   
                               $nowDT = Carbon::now();
                                $due_dateOld = Carbon::createFromFormat('Y-m-d',  $checkusrRoleCopy2->due_date); 
                                
                                // dd($due_dateOld);
                                
                                if($due_dateOld > $nowDT)
                                {
                                    $now = $due_dateOld;
                                }
                                else{
                                    
                                    $now = $nowDT;
                                    
                                }
                            
                                         
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                          
                             //dd($xx);
                             
                   
                    }
                               
                                
                              
                                     $dlist['user_id']=$checkusrRoleCopy2->user_id;
                                     $dlist['role_id']=$checkusrRoleCopy2->role_id;
                                     $dlist['old_date']=$now;
                                     $dlist['new_date']=$due_dateNew;
                                     $dlist['deposit_id']=$dbDeposit->id;
                                     $dlist['duration']=$xx;
                                     $dlist['added_by']=$checkusrRoleCopy2->user_id;
                                     //dd($dlist);
                                    DueDate::create( $dlist);  
                          
                           User_RolesCopy2::find($checkusrRoleCopy2->id)->update([
                                'user_id' => $checkusrRoleCopy2->user_id,
                                'role_id' => $checkusrRoleCopy2->role_id,
                                'day' => $checkusrRoleCopy2->day,
                                'month' => $checkusrRoleCopy2->month,
                                'year' => $checkusrRoleCopy2->year,
                                'disabled' => 0,
                                'due_date' => $due_dateNew
                            ]);
                            
                            User::find($checkusrRoleCopy2->user_id)->update([
                                'due_date' => $due_dateNew
                            ]);
                      
                      
                  }
                  else{
                      
                      $prc = Role::find($dbDeposit->role_id);
                        
                                    //daily
                      if($prc->day <= $data->amount && $data->amount <  $prc->month ){
                        $x=$data->amount/ $prc->day;
                         $due_date=floor($x);;
                               
                               $now = Carbon::now();       
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                            $xx=$due_date.' days';;
                             //dd($xx);
                             
                   
                    }
                        
                        //monthly
                       else if($prc->month <= $data->amount && $data->amount <  $prc->year ){
                        $x=$data->amount/ $prc->month;
                         $due_date=ceil($x * 30.436875);
                          $y=0;
       
                        $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) 
                		$m = floor($m); // Remove
                
                		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                	    $d = floor($d); // the rest of days
                        
                        if($m > 0 && $d > 0){
                		$xx=$m.' months and '.$d.' days';
                        }
                        else if($m > 0 && $d== 0){
                          $xx=$m.' months';  
                        }
                               
                               $now = Carbon::now();     
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                           
                             //dd($xx);
                             
                   
                    }
                    
                    //yearly
                    else if($data->amount >= $prc->year ){
                        $x=$data->amount/ $prc->year;
                         $ii=floor($x);;
                         
                         $rem=$data->amount - ($ii * $prc->year);
            
                            $nd=0;
                           
                            if($rem > 0){
                                
                            if($prc->day <= $rem && $rem < $prc->month ){
                            $rx=$rem/$prc->day;
                            $nd=floor($rx);
                        }
                        
                         else if($prc->month <= $rem && $rem < $prc->year ){
                            $rx=$rem/$prc->month;
                            $nd=ceil($rx * 30.436875);
                           
                                
                        } 
                            
                               
                            }
                            
                            $due_date=($ii * 365) + $nd;
        
                            $y = ($due_date / 365) ; // days / 365 days
                    		$y = floor($y); // Remove all decimals
                                
                           $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31)
                    		$m = floor($m); // Remove
                    
                    		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                    		$d = floor($d); // the rest of days
                    
                            if($y > 0 && $m > 0 && $d > 0){
                            $xx= $y.' years , '.$m.' months and '.$d.' days';
                            }
                            else if($y > 0 && $m == 0 && $d > 0){
                    		$xx=$y.' years and '.$d.' days';
                            }
                            else if($y > 0 && $m > 0 && $d == 0){
                    		$xx=$y.' years and '.$m.' months';
                            }
                           else if($y > 0 && $m == 0 && $d == 0){
                              $xx=$y.' years';  
                            }
                                                   
                               $now = Carbon::now();
                                    
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                          
                             //dd($xx);
                             
                   
                    }
                                
                                  $dlist['user_id']=$dbDeposit->user_id;
                                     $dlist['role_id']=$dbDeposit->role_id;
                                     $dlist['old_date']=$now;
                                     $dlist['new_date']=$due_dateNew;
                                     $dlist['deposit_id']=$dbDeposit->id;
                                     $dlist['duration']=$xx;
                                     $dlist['added_by']=$dbDeposit->user_id;
                                     //dd($dlist);
                                    DueDate::create( $dlist); 
            
                            $usrRoles = User_RolesCopy2::create([
                                'user_id' => $dbDeposit->user_id,
                                'role_id' => $dbDeposit->role_id,
                                'day' => $prc->day,
                                 'month' => $prc->month,
                                  'year' => $prc->year,
                                'disabled' => 0,
                                'due_date' =>  $due_dateNew,
                            ]);
                            
                            User::find($dbDeposit->user_id)->update([
                                'due_date' =>  $due_dateNew
                            ]);
                      
                  }
                  
                  
                  
                  
                  
              }
              else{
                  
                  $checkusrRoleCopy2 = User_RolesCopy2::where('user_id', $usr->id)->where('role_id', $dbDeposit->role_id)->first();
                  
                  if(!empty($checkusrRoleCopy2)){
                      
                      User_Roles::insert([
                            'user_id' => $checkusrRoleCopy2->user_id,
                            'role_id' => $checkusrRoleCopy2->role_id,
                        ]);
                      
                    
                    $prc = Role::find($dbDeposit->role_id);
                    
                    
                         //daily
                      if($checkusrRoleCopy2->day <= $data->amount && $data->amount <  $checkusrRoleCopy2->month ){
                        $x=$data->amount/ $checkusrRoleCopy2->day;
                         $due_date=floor($x);;
                               
                               $nowDT = Carbon::now();
                                $due_dateOld = Carbon::createFromFormat('Y-m-d',  $checkusrRoleCopy2->due_date); 
                                
                                // dd($due_dateOld);
                                
                                if($due_dateOld > $nowDT)
                                {
                                    $now = $due_dateOld;
                                }
                                else{
                                    
                                    $now = $nowDT;
                                    
                                }
                            
                                       
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                            $xx=$due_date.' days';;
                             //dd($xx);
                             
                   
                    }
                        
                        //monthly
                       else if($checkusrRoleCopy2->month <= $data->amount && $data->amount <  $checkusrRoleCopy2->year ){
                        $x=$data->amount/ $checkusrRoleCopy2->month;
                         $due_date=ceil($x * 30.436875);
                          $y=0;
       
                        $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) 
                		$m = floor($m); // Remove
                
                		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                	    $d = floor($d); // the rest of days
                        
                        if($m > 0 && $d > 0){
                		$xx=$m.' months and '.$d.' days';
                        }
                        else if($m > 0 && $d== 0){
                          $xx=$m.' months';  
                        }
                               
                               $nowDT = Carbon::now();
                                $due_dateOld = Carbon::createFromFormat('Y-m-d',  $checkusrRoleCopy2->due_date); 
                                
                                // dd($due_dateOld);
                                
                                if($due_dateOld > $nowDT)
                                {
                                    $now = $due_dateOld;
                                }
                                else{
                                    
                                    $now = $nowDT;
                                    
                                }
                            
                                     
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                           
                             //dd($xx);
                             
                   
                    }
                    
                    //yearly
                    else if($data->amount >= $checkusrRoleCopy2->year ){
                        $x=$data->amount/ $checkusrRoleCopy2->year;
                         $ii=floor($x);;
                         
                         $rem=$data->amount - ($ii * $checkusrRoleCopy2->year);
            
                            $nd=0;
                           
                            if($rem > 0){
                                
                            if($checkusrRoleCopy2->day <= $rem && $rem < $checkusrRoleCopy2->month ){
                            $rx=$rem/$checkusrRoleCopy2->day;
                            $nd=floor($rx);
                        }
                        
                         else if($checkusrRoleCopy2->month <= $rem && $rem < $checkusrRoleCopy2->year ){
                            $rx=$rem/$checkusrRoleCopy2->month;
                            $nd=ceil($rx * 30.436875);
                           
                                
                        } 
                            
                               
                            }
                            
                            $due_date=($ii * 365) + $nd;
        
                            $y = ($due_date / 365) ; // days / 365 days
                    		$y = floor($y); // Remove all decimals
                                
                           $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) ;)
                    		$m = floor($m); // Remove
                    
                    		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                    		$d = floor($d); // the rest of days
                    
                            if($y > 0 && $m > 0 && $d > 0){
                            $xx= $y.' years , '.$m.' months and '.$d.' days';
                            }
                            else if($y > 0 && $m == 0 && $d > 0){
                    		$xx=$y.' years and '.$d.' days';
                            }
                            else if($y > 0 && $m > 0 && $d == 0){
                    		$xx=$y.' years and '.$m.' months';
                            }
                           else if($y > 0 && $m == 0 && $d == 0){
                              $xx=$y.' years';  
                            }
                                                   
                               $nowDT = Carbon::now();
                                $due_dateOld = Carbon::createFromFormat('Y-m-d',  $checkusrRoleCopy2->due_date); 
                                
                                // dd($due_dateOld);
                                
                                if($due_dateOld > $nowDT)
                                {
                                    $now = $due_dateOld;
                                }
                                else{
                                    
                                    $now = $nowDT;
                                    
                                }
                            
                                         
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                          
                             //dd($xx);
                             
                   
                    }
                               
                            $dlist['user_id']=$checkusrRoleCopy2->user_id;
                             $dlist['role_id']=$checkusrRoleCopy2->role_id;
                             $dlist['old_date']=$now;
                             $dlist['new_date']=$due_dateNew;
                             $dlist['deposit_id']=$dbDeposit->id;
                             $dlist['duration']=$xx;
                             $dlist['added_by']=$checkusrRoleCopy2->user_id;
                             //dd($dlist);
                            DueDate::create($dlist);  
                            
                            
                      
                       User_RolesCopy2::find($checkusrRoleCopy2->id)->update([
                            'user_id' => $checkusrRoleCopy2->user_id,
                            'role_id' => $checkusrRoleCopy2->role_id,
                            'day' => $checkusrRoleCopy2->day,
                            'month' => $checkusrRoleCopy2->month,
                            'year' => $checkusrRoleCopy2->year,
                            'disabled' => 0,
                            'due_date' => $due_dateNew
                        ]);
                        
                        User::find($checkusrRoleCopy2->user_id)->update([
                            'due_date' => $due_dateNew
                        ]);
                        
                        
                      
                  }
                  else{
                      
                      User_Roles::insert([
                            'user_id' => $dbDeposit->user_id,
                            'role_id' => $dbDeposit->role_id,
                        ]);
                        
                        
                        $prc = Role::find($dbDeposit->role_id);
                        
                             //daily
                      if($prc->day <= $data->amount && $data->amount <  $prc->month ){
                        $x=$data->amount/ $prc->day;
                         $due_date=floor($x);;
                               
                               $now = Carbon::now();       
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                            $xx=$due_date.' days';;
                             //dd($xx);
                             
                   
                    }
                        
                        //monthly
                       else if($prc->month <= $data->amount && $data->amount <  $prc->year ){
                        $x=$data->amount/ $prc->month;
                         $due_date=ceil($x * 30.436875);
                          $y=0;
       
                        $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) 
                		$m = floor($m); // Remove
                
                		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                	    $d = floor($d); // the rest of days
                        
                        if($m > 0 && $d > 0){
                		$xx=$m.' months and '.$d.' days';
                        }
                        else if($m > 0 && $d== 0){
                          $xx=$m.' months';  
                        }
                               
                               $now = Carbon::now();     
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                           
                             //dd($xx);
                             
                   
                    }
                    
                    //yearly
                    else if($data->amount >= $prc->year ){
                        $x=$data->amount/ $prc->year;
                         $ii=floor($x);;
                         
                         $rem=$data->amount - ($ii * $prc->year);
            
                            $nd=0;
                           
                            if($rem > 0){
                                
                            if($prc->day <= $rem && $rem < $prc->month ){
                            $rx=$rem/$prc->day;
                            $nd=floor($rx);
                        }
                        
                         else if($prc->month <= $rem && $rem < $prc->year ){
                            $rx=$rem/$prc->month;
                            $nd=ceil($rx * 30.436875);
                           
                                
                        } 
                            
                               
                            }
                            
                            $due_date=($ii * 365) + $nd;
        
                            $y = ($due_date / 365) ; // days / 365 days
                    		$y = floor($y); // Remove all decimals
                                
                           $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) ;)
                    		$m = floor($m); // Remove
                    
                    		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                    		$d = floor($d); // the rest of days
                    
                            if($y > 0 && $m > 0 && $d > 0){
                            $xx= $y.' years , '.$m.' months and '.$d.' days';
                            }
                            else if($y > 0 && $m == 0 && $d > 0){
                    		$xx=$y.' years and '.$d.' days';
                            }
                            else if($y > 0 && $m > 0 && $d == 0){
                    		$xx=$y.' years and '.$m.' months';
                            }
                           else if($y > 0 && $m == 0 && $d == 0){
                              $xx=$y.' years';  
                            }
                                                   
                               $now = Carbon::now();
                                    
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                          
                             //dd($xx);
                             
                   
                    }
                    
                     $dlist['user_id']=$dbDeposit->user_id;
                     $dlist['role_id']=$dbDeposit->role_id;
                     $dlist['old_date']=$now;
                     $dlist['new_date']=$due_dateNew;
                     $dlist['deposit_id']=$dbDeposit->id;
                     $dlist['duration']=$xx;
                     $dlist['added_by']=$dbDeposit->user_id;
                     //dd($dlist);
                    DueDate::create( $dlist); 
        
                        $usrRoles = User_RolesCopy2::create([
                            'user_id' => $dbDeposit->user_id,
                            'role_id' => $dbDeposit->role_id,
                            'day' => $prc->day,
                            'month' => $prc->month,
                            'year' => $prc->year,
                            'disabled' => 0,
                            'due_date' =>  $due_dateNew,
                        ]);
                        
                        User::find($dbDeposit->user_id)->update([
                            'due_date' => $due_dateNew
                        ]);
                        
                      
                  }
                  
                  
                  
                  
              }
              
            //   -----------------------------------------------
            
            $usrRoleCopy2 = User_RolesCopy2::where('user_id', $usr->id)->where('role_id', $dbDeposit->role_id)->first();
            
            
                $admin=User::where('email','info@ujuzinet.com')->first();
                $bank=AccountCodes::where('account_name','AZAM PAY')->where('added_by', $admin->added_by)->first();
                 $loc=Location::where('added_by',$admin->id)->first();
                $br=Branch::where('added_by',$admin->id)->where('name','EMASUITE ERP')->first();
                $usx=Client::where('member_id',$usrRoleCopy2->user_id)->first();
                
                $count=Invoice::where('added_by', $admin->added_by)->count();
                $pro=$count+1;
               
                $data22['reference_no']= "S0".$pro;
                $data22['client_id']=$usx->id;
                $data22['invoice_date']=date('Y-m-d');
                $data22['due_date']=$usrRoleCopy2->due_date;
                $data22['location']=$loc->id;
                $data22['exchange_code']='TZS';
                $data22['exchange_rate']='1';
                $data22['invoice_amount']='1';
                $data22['due_amount']='1';
                $data22['branch_id']=$br->id;
                $data22['invoice_tax']='1';
                $data22['sales_type']='Cash Sales';
                $data22['good_receive']='1';
                $data22['invoice_status']=1;
                $data22['status']=1;
                $data22['user_id']= $admin->id;
                $data22['user_agent']=$admin->id;
                $data22['added_by']= $admin->added_by;
        
                $invoice = Invoice::create($data22);
                
        
                $nameArr = $usrRoleCopy2->role_id;
                $priceArr = $data->amount;
                $costArr = $data->amount;
                $amountArr = $data->amount;
        
             if(!empty($nameArr)){
                    if(!empty($amountArr)){
                        $t = array(
                            'invoice_amount' => $amountArr,
                             'invoice_tax' =>  '0',                     
                             'shipping_cost' => '0',
                              'discount' =>  '0', 
                             'due_amount' =>  $amountArr);
        
                               Invoice::where('id',$invoice->id)->update($t);  
        
        
                    }
                }
             
        
                
                $cost['invoice_amount'] = $costArr;
                $cost['invoice_tax'] = 0;
                
                if(!empty($nameArr)){
                    
                    $client=Client::where('id',$invoice->client_id)->first();
                    
                    // dd($client);
                    $role=Role::find($nameArr);
                    
                    $chk_items=Items::where('role_id',$nameArr)->where('added_by', $admin->added_by)->where('disabled','0')->first();
                    if(empty($chk_items)){
                        
                     $new_items = Items::create([
                    'name' => $role->slug,
                    'type' => '4',
                    'cost_price' =>'0',
                    'tax_rate' =>'0',
                    'sales_price' => $role->year,
                    'added_by' => $admin->added_by,
                    'role_id' => $nameArr,
                ]);
        
                            if(!empty($new_items)){
                            $activity =Activity::create(
                                [ 
                                     'added_by'=>$admin->added_by,
                                      'user_id'=>$admin->id,
                                    'module_id'=>$new_items->id,
                                     'module'=>'Inventory',
                                    'activity'=>"Inventory " .  $new_items->name. "  Created",
                                ]
                                );                      
               }
               
        
                       $role_name= $new_items->id;     
                      }
                      
                      else{
                        $role_name= $chk_items->id; 
                          
                      }
                            $items = array(
                            'item_name' => $role_name,
                                'description' =>'Subscription Payment from ' .$client->name .' for '. $role->slug ,
                                'quantity' =>   '1',
                                'due_quantity' =>   '1',
                                'tax_rate' =>  '0',
                                'price' =>  $priceArr,
                                'total_cost' =>  $costArr,
                                'total_tax' =>   '0',
                                 'items_id' =>  $role_name,
                                 'order_no' => '0',
                                 'added_by' => $admin->added_by,
                                'invoice_id' =>$invoice->id);
                               
                                InvoiceItems::create($items);  ;
                                
                                
                                 $lists= array(
                                    'quantity' =>  '1',
                                     'price' =>    $priceArr,
                                     'item_id' => $role_name,
                                      'added_by' => $admin->added_by,
                                      'client_id' =>   $invoice->client_id,
                                     'location' =>   $invoice->location,
                                     'invoice_date' =>  $invoice->invoice_date,
                                    'type' =>   'Sales',
                                    'invoice_id' =>$invoice->id);
                                   
                 
                               InvoiceHistory::create($lists);
            
            
         
                    
                    $cost['due_amount'] =  $costArr + $cost['invoice_tax'];
                    InvoiceItems::where('id',$invoice->id)->update($cost);
                }  
                
                
         
                           
                           
            
                    $inv = Invoice::find($invoice->id);
                    $supp=Client::where('id',$inv->client_id)->first();
                    
                    
                    $cr= AccountCodes::where('account_name','Sales')->where('added_by', $admin->added_by)->first();
                    $journal = new JournalEntry();
                  $journal->account_id = $cr->id;
                  $date = explode('-',$inv->invoice_date);
                  $journal->date =   $inv->invoice_date;
                  $journal->year = $date[0];
                  $journal->month = $date[1];
                 $journal->transaction_type = 'pos_invoice';
                  $journal->name = 'Invoice';
                  $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
                  $journal->income_id= $inv->id;
                 $journal->client_id= $inv->client_id;
                   $journal->currency_code =  $inv->exchange_code;
                  $journal->exchange_rate= $inv->exchange_rate;
                  $journal->added_by=$admin->added_by;
                 $journal->branch_id= $inv->branch_id;
                     $journal->notes= "Sales for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
                  $journal->save();
                
             
                  $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by', $admin->added_by)->first();
                  $journal = new JournalEntry();
                  $journal->account_id = $codes->id;
                  $date = explode('-',$inv->invoice_date);
                  $journal->date =   $inv->invoice_date ;
                  $journal->year = $date[0];
                  $journal->month = $date[1];
                  $journal->transaction_type = 'pos_invoice';
                  $journal->name = 'Invoice';
                  $journal->income_id= $inv->id;
                $journal->client_id= $inv->client_id;
                  $journal->debit =($inv->invoice_amount + $inv->invoice_tax)  *  $inv->exchange_rate;
                  $journal->currency_code =  $inv->exchange_code;
                  $journal->exchange_rate= $inv->exchange_rate;
                  $journal->added_by=$admin->added_by;
                   $journal->branch_id= $inv->branch_id;
                    $journal->notes= "Receivables for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
                  $journal->save();
            
              
        
            
        
            if(!empty($invoice)){
                            $activity =Activity::create(
                                [ 
                                    'added_by'=>$admin->added_by,
                                    'user_id'=>$admin->id,
                                    'module_id'=>$invoice->id,
                                     'module'=>'Invoice',
                                    'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Created",
                                ]
                                );                      
               }
        
        
        //invoice payment
        
                      $sales =Invoice::find($inv->id);
                    $method= Payment_methodes::where('name','Cash')->first();
                     $count=InvoicePayments::count();
                    $pro=$count+1;
        
                        $receipt['trans_id'] = "TBSPH-".$pro;
                        $receipt['invoice_id'] = $inv->id;
                      $receipt['amount'] = $inv->due_amount;
                        $receipt['date'] = $inv->invoice_date;
                       $receipt['account_id'] = $bank->id;
                         $receipt['payment_method'] = $method->id;
                          $receipt['user_id'] = $sales->user_agent;
                        $receipt['added_by'] = $admin->added_by;
                        
                        //update due amount from invoice table
                        $b['due_amount'] =  0;
                       $b['status'] = 3;
                      
                        $sales->update($b);
                         
                        $payment = InvoicePayments::create($receipt);
        
                        $supp=Client::where('id',$sales->client_id)->first();
        
                       $cr= AccountCodes::where('id',$bank->id)->first();
                  $journal = new JournalEntry();
                $journal->account_id = $bank->id;
                $date = explode('-',$sales->invoice_date);
                $journal->date =   $sales->invoice_date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
               $journal->transaction_type = 'pos_invoice_payment';
                $journal->name = 'Invoice Payment';
                $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
                $journal->payment_id= $payment->id;
                $journal->client_id= $sales->client_id;
                 $journal->currency_code =   $sales->currency_code;
                $journal->exchange_rate=  $sales->exchange_rate;
                  $journal->added_by=$admin->added_by;
                   $journal->branch_id= $sales->branch_id;
                   $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
                $journal->save();
        
        
                $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by', $admin->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$sales->invoice_date);
                $journal->date =   $sales->invoice_date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
                  $journal->transaction_type = 'pos_invoice_payment';
                $journal->name = 'Invoice Payment';
                $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
                  $journal->payment_id= $payment->id;
              $journal->client_id= $sales->client_id;
                 $journal->currency_code =   $sales->currency_code;
                $journal->exchange_rate=  $sales->exchange_rate;
                $journal->added_by=$admin->added_by;
                 $journal->branch_id= $sales->branch_id;
                 $journal->notes= "Clear Receivable for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
                $journal->save();
                
  
        
        
                if(!empty($payment)){
                            $activity =Activity::create(
                                [ 
                                    'added_by'=>$admin->added_by,
                                    'user_id'=>$admin->id,
                                    'module_id'=>$payment->id,
                                     'module'=>'Invoice Payment',
                                    'activity'=>"Invoice with reference no  " .  $sales->reference_no. "  is Paid",
                                ]
                                );                      
               }
              
            //   -----------------------------------------------
              
               DB::table('integration_deposits')->where('id', $dbDeposit->id)->update(['status'=>2]);
               
               $aa=Role::find($dbDeposit->role_id);
               $bb = User_RolesCopy2::where('user_id', $usr->id)->where('role_id', $dbDeposit->role_id)->first();
               $dd=date('d/m/Y', strtotime($bb->due_date));
               $cc= DueDate::where('deposit_id', $dbDeposit->id)->first();
          
              $key = "891bf62609dcbefad622090d577294dcab6d0607";
              $number = $data->msisdn;
              $number22 = $usr->phone;
               $message = "Dear $usr->name , Payment confirmed! You have paid for $aa->slug package for $cc->duration, which will end on $dd. Enjoy managing your business like a pro!.Assistance: +255655973248.\n Powered by UjuziNet.";
              
              $message22 = "Dear $usr->name , Payment confirmed! You have paid for $aa->slug package for $cc->duration, which will end on $dd. Enjoy managing your business like a pro!.Assistance: +255655973248.\n Powered by UjuziNet.";
              
              
              $option11 = 1;
              $type = "sms";
              $useRandomDevice = 1;
              $prioritize = 1;
              
              $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
              
              
              $response22 = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number22&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
               
               
               if(!empty($dbDeposit->mobile_user)){
                   if($dbDeposit->mobile_user == 1){
                       
                     $mobile_user_verification11 =  $this->mobile_user_verification($dbDeposit->user_id);
                       
                   }
               } 
              
          }
          else{
              
               $key = "891bf62609dcbefad622090d577294dcab6d0607";
            //   $number = $data->msisdn;
              $number = "0620650846";
               $message = "Unkown user with id $dbDeposit->user_id , paid  $data->amount , successfuly on AzamPay but not known on database. \n Powered by UjuziNet.";
              $option11 = 1;
              $type = "sms";
              $useRandomDevice = 1;
              $prioritize = 1;
              
              $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
           
              
          }
           
        }
        else{
            
            $dbDeposit = DB::table('integration_deposits')->where('reference_no', $data->reference)->latest('id')->first();
            
            
            DB::table('integration_deposits')->where('id', $dbDeposit->id)->update(['status'=>3]);
        }
    
    
        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Call Back Data Created successful', 'call_back_data' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Call Back Data Successfully'];
            return response()->json($response,200);
        }
       
   }
   
    public function mobile_user_verification(int $id){
        
        $user = User::find($id);
        
        $ttupdt33 =  $user->update(['mobile_status' => 'active']);
        
    }
    
    public function user_verification(int $id){
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
           $dbDeposit = DB::table('integration_deposits')->where('user_id', $usr->id)->where('status', 2)->latest('id')->first();
           
               if(!empty($dbDeposit)){
                   
                   $aa=Role::find($dbDeposit->role_id);
                   $bb = User_RolesCopy2::where('user_id', $usr->id)->where('role_id', $dbDeposit->role_id)->first();
                   $dd=date('d/m/Y', strtotime($bb->due_date));
                   $cc= DueDate::where('deposit_id', $dbDeposit->id)->first();
                   
                //   dd($dbDeposit);
                   
                    // $message = "Dear $usr->name , Payment confirmed! You have paid for $aa->slug package for $cc->duration, which will end on $dd. Enjoy managing your business like a pro!.Assistance: +255655973248.\n Powered by UjuziNet.";
                   
                   $data['name'] = $usr->name;
                   
                   $data['latest_paid_date'] = $dbDeposit->created_at;
                   
                   $data['latest_paid_package'] = $aa->slug;
                   
                   $data['latest_paid_amount']  = $dbDeposit->amount;
                   
                   $data['latest_paid_phone_used'] = $dbDeposit->phone;
                   
                  
                   
                   $data['latest_duration'] = $cc->duration;
                   
                   $data['latest_package_due_date'] = $dd;
                   
                   $data['latest_user_status'] = $usr->mobile_status;
            
                
                $response=['success'=>true,'error'=>false,'message'=>'successfully','payment_detail'=>$data];
                return response()->json($response,200);
               
           }
           else{
               
                $response=['success'=>false,'error'=>true,'message'=>'Payment Details not found, please verifiy payment'];
                return response()->json($response,200);
               
           }
           
           
           
           
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
        
    }
    
    public function get_token(){
       
       	// $url = "https://authenticator-sandbox.azampay.co.tz/AppRegistration/GenerateToken";
       	
       	$url = "https://authenticator.azampay.co.tz/AppRegistration/GenerateToken";
       	
       	$data['appName'] = "EMASUITE_APP";
		$data['clientId'] = "995be37b-8fec-4c34-bd94-14936d7e8eba";
// 		$data['clientSecret'] = "Oq5ngZYa7vq2JPiSnBNdlp7/vrO4jAc2lGX3sY142n4bxzxbQUArEtWU7hHIYUxuMrW+SEFR8DwhLQD7a6RMi1wcHOakdpxLThUB9a4i1SMwF2RLNjVYBzqDqVMndbAI7C4vFBTe1u3BAg9GefEIxv/+PDQi1gHV7/u5NDLWovH9I3oZEHOx1fMeOuGWkTmTGgxQRLKGkf5y+HQMS+yUuJojW9RY8FJNv9nH1HlSySHY1E9jT2jRgxvj3BpO526Mg8oBPf6gfkJ/eSlA66rqICGvOFo2asx6pR/8V+KBhcvi5LCzL+hCOLVBAASd+wQ3nmCTWF2mJjuih/4eDnkYZpopYpED6LtlmS+CEABL/X5xntQBq4kcZCshsV2Z6VFWCxIuoxP5z/S+ftNJfBsWCK/qge0dqRUHMFw211qSJx244f/cDHFHcjFvD8XbRO9yNfyLmxkbI7GPY44AQpuO7B2AGR8dQTpNWO8GIwcQx2/fPakteuS3a4IE/WStqGOhB1xknfPn6qqmZtlOXl0suGbTtr6HPJyNnMGVjcFqo5lNINTD/kYHrwTIiM6CcGCKI+i5L0cHRaeA5nbDoPvtbRYFMr81BvkG7G2/jI8D6fdosYRim1/HzAAjBRKd2YNxJql5RtHgNbSTymPg9AWcLrKjAUmJ3ZWSPFMnN4/HsLg=";

		$data['clientSecret'] = "RLFSbY3pAP+GnXQKYudlcBtgj8N4aQScWFJwgODIRYpBZW7zITobqS6oXE5/j2FNLVv9okRDeA0YSJuwWT0ssr3m2991o7edk1pAlWi526WgH9/yUkfVRJaTrzLzIlzjyqAWONQWu6riE75WgfuP2PWspxUX1KWdsWjtML2U67snzB3W83oZ2ZKxuGIs7MOTjAMvtWHJhIlevj2tgyaP8ZS8aCs3bUrzd2z8oYUmLgdTZ1nOKIjTCIlWkMLbaJtx7VkeeyZjN6MjHN7hHoeYRx1yFUxlb/L6xBUZlrQDanzjmV76yD9WmaPF5Qu0jt7WVTPQtx4CApfwbBvO3UTcu6ZmV3BUnjNOmMguCS2kDts9RqKspoOC067ZcehX3+wvCCZgDrKrftx3RjdwXERjRbO6tA+g6TrVMWK0j+z2LitEw9BTrO4waX5OqutfhVdtmXZ2OeiJGoECYXcxuFszmVCmfXjDCZq1SRAM4FyrXgOniljDsQzxuPFMGQcS8Icnma65mMosK/PWD3kKf6jMw6KdfYrS8/agjq3V5GbpI7nqyAmdtwttvn/5/ilcEvFgktfo0sFpfpK4oQtv952/bTqnEsBBK9e/vmdhsBUTcuxM3nIsnK84BpjYUBS8g67UQV/HRQqyfpsFNV3mbj+4Mbc9G1lIEHYqJd0xkiwYLck=";
       	
       	// $url = https://authenticator.azampay.co.tz/
       	
//       	$data['appName'] = "EMASUITE APP";
// 		$data['clientId'] = "6d0bd3c0-b1e4-48cd-9322-de430c7acdc5";
// 		$data['clientSecret'] = "Atqzuixkh0m5lySBXXJL9yny4QbAADYJwc12dJ4+RSH3PpdJoJ1XQptySLWy94QkBbMzX1qQtaunxn0Q6X4CrwKbUZU7lq+EDLk95GD2FTwh46RbOyvN70kMZgiUkkXWGV61gGm39il/Fk65Ra8X3RWrJskbQBmZGbx/UnALm/66lAogCbRH3T6LxeMy/UTKiXRL9ImxChRBKihJyd/OcdqQZ8vqZz9gYEtXPEL4cJKiIURzjr3PomadvRXqL+s8wqsjYmqy6tVHmAetLWT56PJCaVHGF3zOdBq5CGVACVGdoTgPYNfNf8yTD/i7iitYKMIUhBWz9WhiteeC15dgdN3TcfGZysdUy2DfcllpSgOALglFpz600idAnMq8xTa7qxCNU/el+wE00ANMbFDUghBrG9qJJMiaylfrT7XzZ3HxNvR1s1/VHKO27+gO35KXNqrwmoNjXhWT9u6iLMKTKXeDdmQLQrdkuZ0e550bitBLJNLayQMx89iGSed8nJc6ZyzMkCNUsRYvbMuPTpk9TnALMTmZ5i5zQX5nQVzc3t+4unvbQWYGS7SBqH6FyQrMZrUbpCBoqCmogw5XrrN6Meh23hnBPn9tqIwZWyuGOqktSXLJGswIHE1tyMon81J1FloiR0iqgwfLjHuRAzUw4WEQy9ghU9smoeDEVWxu4Eg=";
	
		
// 		$data['appName'] = "EMA ERP";
// 		$data['clientId'] = "69f08554-52d7-433d-b520-c43918790381";
// 		$data['clientSecret'] = "JEmXsXtWyCLFD117bZbr57Hj0Z4NfbW75yOaACYu2nsClLvPkhwBioIE5NXcrAGc0kptki4a+xp7dj0s0pSrk+WV1MdHbQOUK1EtOt8+twCGTey1ozIOlblUdtuBGqQIbXX9ul1Okar3qitXaMsePQdZHj0g5cPNfGx2wBUGwjIKfaDMyomphw60eoh0b0Z3pFocT/UrtS+oztDP97+80u5QtXH33VB9UaXMM2ATFswNs4J0J9qaKm/Uvly1VydEQ+2eKbT34GnhPqfBkKEOUtpfOpNEpvqZojVLvQ5NqYg+muNFpbOhoU6r/RUQ7zmwPjDEgkGPnixaCpY1v0/Asf8heF//hP2e6T4+c/8B8LOYtuxnh5jvjRjvhpRHbYo/d+fYR/w32imGa3aGc4puSV+uqGHZEy9eD/rz/lBey9AR+cJ7/GPElChVH3w1DYASVMsoa6npix2KKAX4kiFnc54EG0fV3BDDM2uk6FlT8VpE14O+NuvKlOC2jIAxiOPuji8yZoYehvebeDYL2wc6gFXZDlxKq208nP9Wq/oFcMTnrBdXpZ8HMcEjnhS2CcHJtyQDgmSnqPrGz25LQZ8gTmui7zChmb4RS2f/CSdMOI3YdyZF2mIk5FV0w0C5EVF/hJzJUdRjOXjDsOgM4pVNsNkKfMAaTlLvvcLtY3nzmy8=";

	
	
 $header = array(
             'Content-Type: application/json',
             );
	try{
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data));
		
		$result = curl_exec($ch);
		
		if($result === false){
			throw new Exception(curl_error($ch),curl_errno($ch));
			
		}
		
		
		
		 
	    
	    $data = json_decode($result);
	    
	   // dd($data);
	    
	      return $data->data->accessToken;
	      
	      
	    
	   // echo $data->accessToken;
		
	}
	
	catch(Exception $e){
		
		trigger_error(sprintf('ERROR  #%d :%s',$e->getCode(),$e->getMessage()),E_USER_ERROR);
		//echo $request;
	}
	
	finally {
		if(is_resource($ch)){
		curl_close($ch);
		}

	}	
   }


   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $data =  Items::find($id);
       $items = Items::all();
       return view('items.items',compact('data','items','id'));

   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    
	public static function sendJSONRequest($request, $url){
		
		// $url = site_url('../protected/customer/get_nida_verification');
		
		$data['appName'] = "EMAERP";
		$data['clientId'] = "6d0bd3c0-b1e4-48cd-9322-de430c7acdc5";
		$data['clientSecret'] = "Oq5ngZYa7vq2JPiSnBNdlp7/vrO4jAc2lGX3sY142n4bxzxbQUArEtWU7hHIYUxuMrW+SEFR8DwhLQD7a6RMi1wcHOakdpxLThUB9a4i1SMwF2RLNjVYBzqDqVMndbAI7C4vFBTe1u3BAg9GefEIxv/+PDQi1gHV7/u5NDLWovH9I3oZEHOx1fMeOuGWkTmTGgxQRLKGkf5y+HQMS+yUuJojW9RY8FJNv9nH1HlSySHY1E9jT2jRgxvj3BpO526Mg8oBPf6gfkJ/eSlA66rqICGvOFo2asx6pR/8V+KBhcvi5LCzL+hCOLVBAASd+wQ3nmCTWF2mJjuih/4eDnkYZpopYpED6LtlmS+CEABL/X5xntQBq4kcZCshsV2Z6VFWCxIuoxP5z/S+ftNJfBsWCK/qge0dqRUHMFw211qSJx244f/cDHFHcjFvD8XbRO9yNfyLmxkbI7GPY44AQpuO7B2AGR8dQTpNWO8GIwcQx2/fPakteuS3a4IE/WStqGOhB1xknfPn6qqmZtlOXl0suGbTtr6HPJyNnMGVjcFqo5lNINTD/kYHrwTIiM6CcGCKI+i5L0cHRaeA5nbDoPvtbRYFMr81BvkG7G2/jI8D6fdosYRim1/HzAAjBRKd2YNxJql5RtHgNbSTymPg9AWcLrKjAUmJ3ZWSPFMnN4/HsLg=";

// 		$data['clientSecret'] = "Atqzuixkh0m5lySBXXJL9yny4QbAADYJwc12dJ4+RSH3PpdJoJ1XQptySLWy94QkBbMzX1qQtaunxn0Q6X4CrwKbUZU7lq+EDLk95GD2FTwh46RbOyvN70kMZgiUkkXWGV61gGm39il/Fk65Ra8X3RWrJskbQBmZGbx/UnALm/66lAogCbRH3T6LxeMy/UTKiXRL9ImxChRBKihJyd/OcdqQZ8vqZz9gYEtXPEL4cJKiIURzjr3PomadvRXqL+s8wqsjYmqy6tVHmAetLWT56PJCaVHGF3zOdBq5CGVACVGdoTgPYNfNf8yTD/i7iitYKMIUhBWz9WhiteeC15dgdN3TcfGZysdUy2DfcllpSgOALglFpz600idAnMq8xTa7qxCNU/el+wE00ANMbFDUghBrG9qJJMiaylfrT7XzZ3HxNvR1s1/VHKO27+gO35KXNqrwmoNjXhWT9u6iLMKTKXeDdmQLQrdkuZ0e550bitBLJNLayQMx89iGSed8nJc6ZyzMkCNUsRYvbMuPTpk9TnALMTmZ5i5zQX5nQVzc3t+4unvbQWYGS7SBqH6FyQrMZrUbpCBoqCmogw5XrrN6Meh23hnBPn9tqIwZWyuGOqktSXLJGswIHE1tyMon81J1FloiR0iqgwfLjHuRAzUw4WEQy9ghU9smoeDEVWxu4Eg=";
	
		
// 		$data['appName'] = "EMA ERP";
// 		$data['clientId'] = "69f08554-52d7-433d-b520-c43918790381";
// 		$data['clientSecret'] = "JEmXsXtWyCLFD117bZbr57Hj0Z4NfbW75yOaACYu2nsClLvPkhwBioIE5NXcrAGc0kptki4a+xp7dj0s0pSrk+WV1MdHbQOUK1EtOt8+twCGTey1ozIOlblUdtuBGqQIbXX9ul1Okar3qitXaMsePQdZHj0g5cPNfGx2wBUGwjIKfaDMyomphw60eoh0b0Z3pFocT/UrtS+oztDP97+80u5QtXH33VB9UaXMM2ATFswNs4J0J9qaKm/Uvly1VydEQ+2eKbT34GnhPqfBkKEOUtpfOpNEpvqZojVLvQ5NqYg+muNFpbOhoU6r/RUQ7zmwPjDEgkGPnixaCpY1v0/Asf8heF//hP2e6T4+c/8B8LOYtuxnh5jvjRjvhpRHbYo/d+fYR/w32imGa3aGc4puSV+uqGHZEy9eD/rz/lBey9AR+cJ7/GPElChVH3w1DYASVMsoa6npix2KKAX4kiFnc54EG0fV3BDDM2uk6FlT8VpE14O+NuvKlOC2jIAxiOPuji8yZoYehvebeDYL2wc6gFXZDlxKq208nP9Wq/oFcMTnrBdXpZ8HMcEjnhS2CcHJtyQDgmSnqPrGz25LQZ8gTmui7zChmb4RS2f/CSdMOI3YdyZF2mIk5FV0w0C5EVF/hJzJUdRjOXjDsOgM4pVNsNkKfMAaTlLvvcLtY3nzmy8=";
	
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		//curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
		
		$result = curl_exec($ch);

		//read xml response
		//$xml=simplexml_load_string($result) or die("Error1: Cannot create object");
		$json=json_encode($result);
		curl_close($ch);
		echo $json;
	}
	
   public function update(Request $request, $id)
   {
      


   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       //

     
   }
   
   
   
   public function findMinimum(Request $request)
    {
       


$amount=str_replace(",","",$request->id)  ;
$role=$request->role;
$data= User_RolesCopy2::where('role_id',$role)->where('user_id',auth()->user()->id)->first();



 if ($amount > 0) {

if($amount <  $data->day ){
$price="The Minimum Amount is ".  number_format($data->day) ." . Please Enter the Right Amount";
}

else{
$price='' ;
 }

}

else{
$price="Choose Amount Greater then zero." ;

}

                                                                                          
               return response()->json($price);

}
   
   
   
   
   
}
