<?php

namespace App\Http\Controllers\AzamPesa;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\User;

// use App\Models\Accounting\AccountCodes;
// use App\Models\Accounting\Accounts;
// use App\Models\Accounting\JournalEntry;
// use App\Models\Accounting\Transaction;
// use App\Models\Member\MemberTransaction;
use PDF;


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
       $items = DB::table('integration_deposits')->where('user_id',  Auth::user()->id)->select("*")->get();
      
       return view('AzamPesa.index',compact('items'));
   }
   
   public function index2(Request $request)
   {
       //
       $items = DB::table('integration_deposits')->where('user_id',  Auth::user()->id)->select("*")->get();
      
       return view('AzamPesa.index2',compact('items'));
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
		
		$saved_data['user_id'] = Auth::user()->id;
		$saved_data['phone'] = $data['accountNumber'];
		$saved_data['amount'] = $data['amount'];
		$saved_data['status'] = 1;
		$saved_data['reference_no'] = $result->transactionId;
		$saved_data['added_by'] = Auth::user()->added_by;
		
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
          
        //   dd($usr);
            
           
        //   ---
        
        
        
        //  $member = Member::find($usr->member_id);

        //  $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,5);
         
        //  $cr= AccountCodes::where('account_name','AzamPay')->first();
         
        // //  dd($cr);
         
        //  $dateT = Carbon::now()->format('Y-m-d');
        
        //           $card = Cards::find($member->card_id);
        //           $dataN['member_id'] = $usr->member_id;
        //           $dataN['ref_no'] = $card->reference_no;
        //           $dataN['card_id'] =$member->card_id;
        //           $dataN['debit'] = $data->amount;
        //           $dataN['trans_id'] = "GCD".$random;
        //           $dataN['account_id'] = $cr->account_id;
        //           $dataN['date'] = $dateT;
        //           $dataN['status'] = 1;
        //           $dataN['added_by'] = $usr->id;
                
        //           $deposit = Deposit::create($dataN);
        //           $temp_deposit = TemporaryDeposit::create($dataN);
        
        
        
                   
        //           $journal = new JournalEntry();
        //         $journal->account_id = $cr->account_id;
        //         $date = explode('-',$dateT);
        //         $journal->date =   $dateT;
        //         $journal->year = $date[0];
        //         $journal->month = $date[1];
        //       $journal->transaction_type = 'member_deposit';
        //         $journal->name = 'Member Deposit';
        //         $journal->debit =$data->amount;
        //         $journal->payment_id= $deposit->id;
        //         $journal->member_id= $usr->member_id;
        //           $journal->added_by= $usr->id;
        //           $journal->notes= "Member Deposit with reference ".$deposit->trans_id ." by Member ".$member->full_name ;
        //         $journal->save();
        
        
        //         $codes= AccountCodes::where('account_name','Member`s card deposit')->first();
        //         $journal = new JournalEntry();
        //         $journal->account_id = $codes->id;
        //           $date = explode('-',$dateT);
        //         $journal->date =   $dateT;
        //         $journal->year = $date[0];
        //         $journal->month = $date[1];
        //          $journal->transaction_type = 'member_deposit';
        //         $journal->name = 'Member Deposit';
        //         $journal->credit =$data->amount;
        //         $journal->payment_id= $deposit->id;
        //         $journal->member_id= $usr->member_id;
        //           $journal->added_by=$usr->id;
        //           $journal->notes=  "Member Deposit with reference ".$deposit->trans_id ." by Member ".$member->full_name ;
        //         $journal->save();
                
        // $account= Accounts::where('account_id',$cr->account_id)->first();
        
        // if(!empty($account)){
        // $balance=$account->balance + $data->amount ;
        // $item_to['balance']=$balance;
        // $account->update($item_to);
        // }
        
        // else{
        //   $cr= AccountCodes::where('id',$cr->account_id)->first();
        
        //      $new['account_id']= $cr->account_id;
        //       $new['account_name']= $cr->account_name;
        //       $new['balance']= $data->amount;
        //       $new[' exchange_code']= 'TZS';
        //         $new['added_by']=$usr->id;
        // $balance=$request->amount;
        //      Accounts::create($new);
        // }
                
        //   // save into tbl_transaction
        
        //                              $transaction= Transaction::create([
        //                                 'module' => 'Member Deposit',
        //                                  'module_id' => $deposit->id,
        //                               'account_id' => $cr->account_id,
        //                                 'code_id' => $codes->id,
        //                                 'name' => 'Member Deposit with reference ' .$deposit->trans_id,
        //                                  'transaction_prefix' => $deposit->trans_id,
        //                                 'type' => 'Income',
        //                                 'amount' =>$data->amount ,
        //                                 'credit' => $data->amount,
        //                                  'total_balance' =>$balance,
        //                                 'date' => date('Y-m-d', strtotime($request->date)),
        //                                 'paid_by' => $usr->member_id,
        //                                   'status' => 'paid' ,
        //                                 'notes' => 'This deposit is from member deposit payment. The Reference is ' .$deposit->trans_id .' by Member '. $member->full_name  ,
        //                                 'added_by' =>$usr->id,
        //                             ]);
        
        
        // // save into member_transaction
        
        // $a=route('member_deposit_receipt',['download'=>'pdf','id'=>$deposit->id]);
        
        //                              $mem_transaction= MemberTransaction::create([
        //                                 'module' => 'Member Deposit',
        //                                  'module_id' => $deposit->id,
        //                           'member_id' => $usr->member_id,
        //                               'account_id' => $cr->account_id,
        //                                 'code_id' => $codes->id,
        //                                 'name' => 'Member Deposit with reference ' .$deposit->trans_id,
        //                                  'transaction_prefix' => $deposit->trans_id,
        //                                 'type' => 'Deposit',
        //                                 'amount' =>$data->amount ,
        //                                 'credit' => $data->amount,
        //                                  'total_balance' =>$member->balance + $data->amount,
        //                                 'date' => date('Y-m-d', strtotime($dateT)),
        //                                 'paid_by' => $usr->member_id,
        //                                   'status' => 'paid' ,
        //                                 'notes' => 'This deposit is from member deposit payment. The Reference is ' .$deposit->trans_id .' by Member '. $member->full_name  ,
        //                                     'link'=> $a,
        //                                 'added_by' =>$usr->id,
        //                             ]);
        
        
        // Member::find($usr->member_id)->update(['balance'=>$member->balance + $data->amount]) ;
           
           
           
           
        //   -----
           
        //   $DTn['status'] = 2;
          DB::table('integration_deposits')->where('id', $dbDeposit->id)->update(['status'=>2]);
          
          $key = "891bf62609dcbefad622090d577294dcab6d0607";
          $number = "0747022515";
        //   $number = $data->msisdn;
        //   $message = "Thank you $member->full_name, $member->member_id, for depositing Tsh. $data->amount on $dateT with receipt no: $data->reference to Gymkhana Club. Your deposit balance is now Tsh. $member->balance. \n Powered by UjuziNet.";
           $message = "Thank you $usr->name. \n Powered by UjuziNet.";
          $option11 = 1;
          $type = "sms";
          $useRandomDevice = 1;
          $prioritize = 1;
          
          $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
           
           
           
        }
        else{
            
            $dbDeposit = DB::table('integration_deposits')->where('reference_no', $data->reference)->latest('id')->first();
            
            // $DTn['status'] = 3;
            
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
    public function get_token(){
       
       	// $url = "https://authenticator-sandbox.azampay.co.tz/AppRegistration/GenerateToken";
       	
       	$url = "https://authenticator.azampay.co.tz/AppRegistration/GenerateToken";
       	
       	$data['appName'] = "EMASUITE_APP";
		$data['clientId'] = "995be37b-8fec-4c34-bd94-14936d7e8eba";
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
		$data['clientSecret'] = "Atqzuixkh0m5lySBXXJL9yny4QbAADYJwc12dJ4+RSH3PpdJoJ1XQptySLWy94QkBbMzX1qQtaunxn0Q6X4CrwKbUZU7lq+EDLk95GD2FTwh46RbOyvN70kMZgiUkkXWGV61gGm39il/Fk65Ra8X3RWrJskbQBmZGbx/UnALm/66lAogCbRH3T6LxeMy/UTKiXRL9ImxChRBKihJyd/OcdqQZ8vqZz9gYEtXPEL4cJKiIURzjr3PomadvRXqL+s8wqsjYmqy6tVHmAetLWT56PJCaVHGF3zOdBq5CGVACVGdoTgPYNfNf8yTD/i7iitYKMIUhBWz9WhiteeC15dgdN3TcfGZysdUy2DfcllpSgOALglFpz600idAnMq8xTa7qxCNU/el+wE00ANMbFDUghBrG9qJJMiaylfrT7XzZ3HxNvR1s1/VHKO27+gO35KXNqrwmoNjXhWT9u6iLMKTKXeDdmQLQrdkuZ0e550bitBLJNLayQMx89iGSed8nJc6ZyzMkCNUsRYvbMuPTpk9TnALMTmZ5i5zQX5nQVzc3t+4unvbQWYGS7SBqH6FyQrMZrUbpCBoqCmogw5XrrN6Meh23hnBPn9tqIwZWyuGOqktSXLJGswIHE1tyMon81J1FloiR0iqgwfLjHuRAzUw4WEQy9ghU9smoeDEVWxu4Eg=";
	
		
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
      


       $items = Items::find($id);
       $items->update($request->post());

       return redirect(route('items.index'));
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

       $items = Items::find($id);
       $items->delete();

       return redirect(route('items.index'));
   }
}
