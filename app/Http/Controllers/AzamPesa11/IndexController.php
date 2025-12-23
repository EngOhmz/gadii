<?php

namespace App\Http\Controllers\AzamPesa;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Items;
use Exception;
use App\Models\AzamPesa\CallBackData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
     public function index(Request $request)
   {
       //
       $items = DB::table('integration_deposits')->select("*")->get();
      
       return view('AzamPesa.index',compact('items'));
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

        $url = "https://sandbox.azampay.co.tz/azampay/mno/checkout";
        
       
        
        $token = $this->get_token();
		
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
		
// 		$saved_data['user_id'] = Auth::user()->id;
// 		$saved_data['user_id'] = Auth::user()->id;
// 		$saved_data['user_id'] =Auth::user()->id;
		
		
	      DB::table('integration_deposits')->insert($saved_data);
		
		
		//dd($result);
		
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
       
   }
    public function get_token(){
       
       	$url = "https://authenticator-sandbox.azampay.co.tz/AppRegistration/GenerateToken";
		
		$data['appName'] = "EMA ERP";
		$data['clientId'] = "69f08554-52d7-433d-b520-c43918790381";
		$data['clientSecret'] = "JEmXsXtWyCLFD117bZbr57Hj0Z4NfbW75yOaACYu2nsClLvPkhwBioIE5NXcrAGc0kptki4a+xp7dj0s0pSrk+WV1MdHbQOUK1EtOt8+twCGTey1ozIOlblUdtuBGqQIbXX9ul1Okar3qitXaMsePQdZHj0g5cPNfGx2wBUGwjIKfaDMyomphw60eoh0b0Z3pFocT/UrtS+oztDP97+80u5QtXH33VB9UaXMM2ATFswNs4J0J9qaKm/Uvly1VydEQ+2eKbT34GnhPqfBkKEOUtpfOpNEpvqZojVLvQ5NqYg+muNFpbOhoU6r/RUQ7zmwPjDEgkGPnixaCpY1v0/Asf8heF//hP2e6T4+c/8B8LOYtuxnh5jvjRjvhpRHbYo/d+fYR/w32imGa3aGc4puSV+uqGHZEy9eD/rz/lBey9AR+cJ7/GPElChVH3w1DYASVMsoa6npix2KKAX4kiFnc54EG0fV3BDDM2uk6FlT8VpE14O+NuvKlOC2jIAxiOPuji8yZoYehvebeDYL2wc6gFXZDlxKq208nP9Wq/oFcMTnrBdXpZ8HMcEjnhS2CcHJtyQDgmSnqPrGz25LQZ8gTmui7zChmb4RS2f/CSdMOI3YdyZF2mIk5FV0w0C5EVF/hJzJUdRjOXjDsOgM4pVNsNkKfMAaTlLvvcLtY3nzmy8=";

	
	
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
		
		$data['appName'] = "EMA ERP";
		$data['clientId'] = "69f08554-52d7-433d-b520-c43918790381";
		$data['clientSecret'] = "JEmXsXtWyCLFD117bZbr57Hj0Z4NfbW75yOaACYu2nsClLvPkhwBioIE5NXcrAGc0kptki4a+xp7dj0s0pSrk+WV1MdHbQOUK1EtOt8+twCGTey1ozIOlblUdtuBGqQIbXX9ul1Okar3qitXaMsePQdZHj0g5cPNfGx2wBUGwjIKfaDMyomphw60eoh0b0Z3pFocT/UrtS+oztDP97+80u5QtXH33VB9UaXMM2ATFswNs4J0J9qaKm/Uvly1VydEQ+2eKbT34GnhPqfBkKEOUtpfOpNEpvqZojVLvQ5NqYg+muNFpbOhoU6r/RUQ7zmwPjDEgkGPnixaCpY1v0/Asf8heF//hP2e6T4+c/8B8LOYtuxnh5jvjRjvhpRHbYo/d+fYR/w32imGa3aGc4puSV+uqGHZEy9eD/rz/lBey9AR+cJ7/GPElChVH3w1DYASVMsoa6npix2KKAX4kiFnc54EG0fV3BDDM2uk6FlT8VpE14O+NuvKlOC2jIAxiOPuji8yZoYehvebeDYL2wc6gFXZDlxKq208nP9Wq/oFcMTnrBdXpZ8HMcEjnhS2CcHJtyQDgmSnqPrGz25LQZ8gTmui7zChmb4RS2f/CSdMOI3YdyZF2mIk5FV0w0C5EVF/hJzJUdRjOXjDsOgM4pVNsNkKfMAaTlLvvcLtY3nzmy8=";
	
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
