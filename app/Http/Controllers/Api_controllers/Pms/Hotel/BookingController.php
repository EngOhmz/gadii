<?php

namespace App\Http\Controllers\Api_controllers\Pms\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Carbon\Carbon;

use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Hotel\Client;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelItems;
use App\Models\Hotel\HouseType;
use App\Models\Hotel\RoomType;
use App\Models\Hotel\Invoice;
use App\Models\Hotel\InvoiceItems;
use App\Models\Hotel\InvoicePayments;
use App\Models\Hotel\InvoiceHistory;
use App\Models\Restaurant\POS\Activity;
use App\Models\Hotel\Booked;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Payment_methodes;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class BookingController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(int $id)
    {
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
            
        $invoices=Invoice::where('added_by', $added_by)->orderBy('created_at', 'desc')->get();
        
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;
                
                $hotel_id = $row->hotel_id;
                if(!empty($hotel_id)){

                $data['hotel_name'] =  Hotel::find(intval($row->hotel_id))->name;
                
                }
                else{

                    $data['hotel_name'] =  null;
                }
                
                
                $client_id = Client::find(intval($row->client_id));
                
                if(!empty($client_id)){

                $data['client'] =  Client::find(intval($row->client_id))->name;

                $data['client_tin'] =  Client::find(intval($row->client_id))->TIN;

                $data['client_email'] =  Client::find(intval($row->client_id))->email;

                $data['client_phone'] =  Client::find(intval($row->client_id))->phone;

                $data['client_address'] =  Client::find(intval($row->client_id))->address;
                
                $data['client_nationality'] =  Client::find(intval($row->client_id))->nationality; 
                
                $data['client_place_of_birth'] =  Client::find(intval($row->client_id))->place_of_birth; 
                
                $data['client_occupation'] =  Client::find(intval($row->client_id))->occupation; 
                
                $data['client_identity_type'] =  Client::find(intval($row->client_id))->identity_type; 
                
                $data['client_identity_no'] =  Client::find(intval($row->client_id))->identity_no; 
                
                $data['client_dob'] =  Client::find(intval($row->client_id))->dob; 
                
                $data['client_tribe'] =  Client::find(intval($row->client_id))->tribe; 
                
                $data['client_VRN'] =  Client::find(intval($row->client_id))->VRN; 
                }
                else{

                    $data['client'] =  null;

                    $data['client_tin'] =  null;
    
                    $data['client_email'] =  null;
    
                    $data['client_phone'] =  null;
    
                    $data['client_address'] =  null;
                    
                    
                    $data['client_nationality'] =  null;
    
                    $data['client_place_of_birth'] =  null;
    
                    $data['client_occupation'] =  null;
    
                    $data['client_identity_type'] =  null;
                    
                    
                    $data['client_identity_no'] =  null;
    
                    $data['client_dob'] =  null;
    
                    $data['client_tribe'] =  null;
    
                    $data['client_VRN'] =  null;
                }

               if($row->status == 0){
                    $data['status'] = 'Not Approved';
                }
                elseif($row->status == 1){
                    $data['status'] = 'Not Paid';
                }
                elseif($row->status == 2){
                    $data['status'] = 'Partially Paid';
                }
                elseif($row->status == 3){
                    $data['status'] = 'Fully Paid';
                }
                elseif($row->status == 4){
                    $data['status'] = 'Cancelled';
                }


                // if($row->status == 0){
                //     $data['status'] = 'Inactive';
                // }
                // elseif($row->status == 1){
                //     $data['status'] = 'Active';
                // }

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','invoice'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Invoice found'];
            return response()->json($response,200);
        } 
        
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       } 
    }
    
    
    public function shopkeeper_index(int $id)
    {
        

        $invoices=Hotel::where('status',1)->where('manager_id', $id)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        
        if($invoices->isNotEmpty()){

             foreach($invoices as $row){

                $data = $row;
                
                $client_id = $row->type;
                if(!empty($client_id)){

                $data['type'] =  HouseType::find(intval($row->type))->name;
                
                }
                else{

                    $data['type'] =  null;
                }
               


                if($row->status == 0){
                    $data['status'] = 'Inactive';
                }
                elseif($row->status == 1){
                    $data['status'] = 'Active';
                }

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','hotel'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Hotel found managed by that id'];
            return response()->json($response,200);
        } 
        
        
       
       
    }

    public function indexOff(int $id, int $lastId)
    {
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
        
        
        $invoices= Invoice::where('added_by', $added_by)->where('id', '>' ,$lastId)->orderBy('created_at', 'desc')->get();
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;
                
                $hotel_id = $row->hotel_id;
                if(!empty($hotel_id)){

                $data['hotel_name'] =  Hotel::find(intval($row->hotel_id))->name;
                
                }
                else{

                    $data['hotel_name'] =  null;
                }
                
                
                $client_id = Client::find(intval($row->client_id));
                
                if(!empty($client_id)){

                $data['client'] =  Client::find(intval($row->client_id))->name;

                $data['client_tin'] =  Client::find(intval($row->client_id))->TIN;

                $data['client_email'] =  Client::find(intval($row->client_id))->email;

                $data['client_phone'] =  Client::find(intval($row->client_id))->phone;

                $data['client_address'] =  Client::find(intval($row->client_id))->address;
                
                $data['client_nationality'] =  Client::find(intval($row->client_id))->nationality; 
                
                $data['client_place_of_birth'] =  Client::find(intval($row->client_id))->place_of_birth; 
                
                $data['client_occupation'] =  Client::find(intval($row->client_id))->occupation; 
                
                $data['client_identity_type'] =  Client::find(intval($row->client_id))->identity_type; 
                
                $data['client_identity_no'] =  Client::find(intval($row->client_id))->identity_no; 
                
                $data['client_dob'] =  Client::find(intval($row->client_id))->dob; 
                
                $data['client_tribe'] =  Client::find(intval($row->client_id))->tribe; 
                
                $data['client_VRN'] =  Client::find(intval($row->client_id))->VRN; 
                }
                else{

                    $data['client'] =  null;

                    $data['client_tin'] =  null;
    
                    $data['client_email'] =  null;
    
                    $data['client_phone'] =  null;
    
                    $data['client_address'] =  null;
                    
                    
                    $data['client_nationality'] =  null;
    
                    $data['client_place_of_birth'] =  null;
    
                    $data['client_occupation'] =  null;
    
                    $data['client_identity_type'] =  null;
                    
                    
                    $data['client_identity_no'] =  null;
    
                    $data['client_dob'] =  null;
    
                    $data['client_tribe'] =  null;
    
                    $data['client_VRN'] =  null;
                }

               if($row->status == 0){
                    $data['status'] = 'Not Approved';
                }
                elseif($row->status == 1){
                    $data['status'] = 'Not Paid';
                }
                elseif($row->status == 2){
                    $data['status'] = 'Partially Paid';
                }
                elseif($row->status == 3){
                    $data['status'] = 'Fully Paid';
                }
                elseif($row->status == 4){
                    $data['status'] = 'Cancelled';
                }


                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','hotel'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Hotel found'];
            return response()->json($response,200);
        } 
        
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       } 
       
    }
    
    public function house_items(){
        
        // $date = Carbon::now()->format('Y-m-d');
        
        $items = HouseType::where('added_by', 1)->get();
        
        if($items->isNotEmpty()){

        foreach($items as $row){

            $data = $row;

            $farmers[] = $data;
 
        }

        $response=['success'=>true,'error'=>false,'message'=>'successfully','house_type'=>$farmers];
        return response()->json($response,200);
        }
        else{
    
            $response=['success'=>false,'error'=>true,'message'=>'No House Type  found'];
            return response()->json($response,200);
        }
        
    }
    
    public function room_items(){
        
        // $date = Carbon::now()->format('Y-m-d');
        
        $items = RoomType::where('added_by', 1)->get();
        
        if($items->isNotEmpty()){

        foreach($items as $row){

            $data = $row;

            $farmers[] = $data;
 
        }

        $response=['success'=>true,'error'=>false,'message'=>'successfully','room_type'=>$farmers];
        return response()->json($response,200);
        }
        else{
    
            $response=['success'=>false,'error'=>true,'message'=>'No Room Type  found'];
            return response()->json($response,200);
        }
        
    }


    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nowDate = Carbon::now()->format('Y-m-d');
        
        $usr = User::find($request['id']);
       
       if(!empty($usr)){
           
       $added_by =  $usr->added_by;
  
        
        $random = substr(str_shuffle(str_repeat($x='0123456789', ceil(6/strlen($x)) )),1,6);
        $count=Invoice::where('added_by', $added_by)->count();
        $pro=$count+1;
        $hx=Hotel::find($request->hotel_id);
        
        $words = preg_split("/\s+/", $hx->name);
        $acronym = "";
        
        foreach ($words as $w) {
          $acronym .= mb_substr($w, 0, 1);
        }
        $a=strtoupper($acronym);
        //dd($a);
        
        
        $count=Invoice::where('added_by', $added_by)->count();
         $data['reference_no']=  $a.$random.$pro;
         $data['check_in']=$request->start_date;
        $data['client_id']=$request->client_id;
        $data['invoice_date']=date('Y-m-d');
        $data['hotel_id']=$request->hotel_id;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['invoice_amount']=$request->subtotal;
        $data['due_amount']=$request->subtotal;
        $data['branch_id']=$request->branch_id;
        $data['invoice_tax']='0';
        $data['status']='0';
        $data['sales_type']=$request->sales_type;
        $data['bank_id']=$request->bank_id;
       //$data['status']='1';

       $data['user_id']= $usr->id;
       $data['user_agent']= $request->user_agent;
        $data['added_by']= $added_by;

        $invoice = Invoice::create($data);
        
        
        
        
            if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>$added_by,
                            'user_id'=>$usr->id,
                            'module_id'=>$invoice->id,
                             'module'=>'Property',
                            'activity'=>"Property Invoice with reference no  " .  $invoice->reference_no. "  is Created",
                        ]
                        );                      
               }

         
         
         if($invoice->sales_type == 'Cash Sales'){
        
            
                    $inv = Invoice::find($invoice->id);
            $supp=Client::find($inv->client_id);
            
            $cr= AccountCodes::where('account_name','Property Sales')->where('added_by', $added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'book_rooms';
          $journal->name = 'Booking';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=$added_by;
           $journal->branch_id= $inv->branch_id;
           $journal->notes= "Sales of Property " .$hx->name ." with Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
       
        
          $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',$added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'book_rooms';
          $journal->name = 'Booking';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->debit =($inv->invoice_amount + $inv->invoice_tax)  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=$added_by;
           $journal->branch_id= $inv->branch_id;
            $journal->notes= "Receivables for Sales of Property " .$hx->name ." with Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
    
       
          


              $sales =Invoice::find($inv->id);
            $method= Payment_methodes::where('name','Cash')->first();
             $count=InvoicePayments::where('added_by',$added_by)->count();
            $pro=$count+1;

              $rm = substr(str_shuffle(str_repeat($x='0123456789', ceil(4/strlen($x)) )),1,4);
               
                $receipt['trans_id'] = $a."P".$rm.$pro;
                $receipt['invoice_id'] = $inv->id;
              $receipt['amount'] = $inv->due_amount;
                $receipt['date'] = $inv->invoice_date;
               $receipt['account_id'] = $request->bank_id;
                 $receipt['payment_method'] = $method->id;
                  $receipt['user_id'] = $sales->user_agent;
                $receipt['added_by'] = $added_by;
                
                //update due amount from invoice table
                $b['due_amount'] =  0;
               $b['status'] = 3;
              
                $sales->update($b);
                 
                $payment = InvoicePayments::create($receipt);

                $supp=Client::find($sales->client_id);

               $cr= AccountCodes::where('id','$request->bank_id')->first();
          $journal = new JournalEntry();
        $journal->account_id = $request->bank_id;
        $date = explode('-',$inv->invoice_date);
        $journal->date =   $inv->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'book_rooms_payment';
          $journal->name = 'Booking Payment';
        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
        $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
          $journal->added_by=$added_by;
           $journal->branch_id= $sales->branch_id;
           $journal->notes= "Deposit for Sales of Property " .$hx->name ." with Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();


        $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',$added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
        $journal->date =   $inv->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
         $journal->transaction_type = 'book_rooms_payment';
          $journal->name = 'Booking Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
          $journal->payment_id= $payment->id;
      $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
        $journal->added_by=$added_by;
         $journal->branch_id= $sales->branch_id;
         $journal->notes= "Clear Receivable of Property " .$hx->name ." for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();
        
                $journal->save();
                
        
        
        
                if(!empty($payment)){
                            $activity =Activity::create(
                                [ 
                                    'added_by'=>$added_by,
                                     'user_id'=>$usr->id,
                                    'module_id'=>$payment->id,
                                     'module'=>'Property Payment',
                                    'activity'=>"Property Invoice with reference no  " .  $sales->reference_no. "  is Paid",
                                ]
                                );                      
               }        
        
        }


        
                  
     
        if($invoice)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Booking Invoice Created successful', 'invoice' => $invoice];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Booking Invoice Successfully'];
            return response()->json($response,200);
        }
        
    }
            else{
                
                $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Booking Invoice Cause User ID not found on users table Successfully'];
                return response()->json($response,200);
            }

    }
    
    public function item_index(int $id){
        $invoices=InvoiceItems::where('invoice_id', $id)->orderBy('created_at', 'desc')->get();
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;

                $data['invoice_id'] = intval($row->invoice_id);


                $data['purchase_item_id'] = intval($row->id);


                // $data['id'] = intval($row->items_id);
                
                // $data['item_name'] = Items::find(intval($row->items_id))->name;

                // $data['inventory_id'] = intval($row->items_id);

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','invoice_item'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No invoice item  found'];
            return response()->json($response,200);
        } 
    }
    
    
     public function item_indexOff(int $id, int $lastId){

        $invoices=InvoiceItems::where('invoice_id', $id)->where('id', '>', $lastId)->orderBy('created_at', 'desc')->get();
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;

                $data['invoice_id'] = intval($row->invoice_id);


                $data['purchase_item_id'] = intval($row->id);
                
                // $data['item_name'] = Items::find(intval($row->items_id))->name;


                // $data['id'] = intval($row->items_id);

                // $data['inventory_id'] = intval($row->items_id);

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','invoice_item'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No invoice item  found'];
            return response()->json($response,200);
        } 

    }
    
   
      public function item_store(Request $request){

        $this->validate($request,[
            'room_id' => 'required',
            'price' => 'required',
            'room_type' => 'required',

            'invoice_id' => 'required',

        ]);

        

        $invoice = Invoice::find(intval($request->invoice_id));



        if(!empty($invoice)){
            
                            $iyt = InvoiceItems::where('invoice_id', $invoice->id)->orderBy('created_at', 'desc')->first();
                
                            if(!empty($iyt)){
                                $iy = $iyt->order_no + 1;
                            }
                            else{
                
                                $iy = 1;
                            }

                              $se=$request->start_date ." - ".$request->end_date ;
                    
                                $items = array(
                                'room_id' => $request->room_id,
                                'room_type' =>$request->room_type,
                                'dates' =>  $se,
                                'check_in' =>  $request->start_date,
                                'check_out' => $request->end_date,
                                'checkout_time' =>  $request->checkout_time,
                                'price' =>  $request->price,
                                'nights' =>  $request->nights,
                                'total_cost' =>  $request->total_cost,
                                'items_id' => $request->room_id,
                                'order_no' => $iy,
                                'added_by' => $invoice->added_by,
                                'hotel_id' =>$invoice->hotel_id,
                                'invoice_id' =>$invoice->id);
                                   
                              $invtms =  InvoiceItems::create($items);  ;
                                
                                
                                if($invoice->sales_type == 'Cash Sales'){

                                       
                                       
                                       if($request->start_date == date('Y-m-d') ){
                                           $status = 1;
                                       }
                                       else{
                                            $status = 0;
                                       }
                                       
                                        $lists= array(
                                                'quantity' =>  1,
                                                'price' =>  $request->total_cost,
                                                'room_type'=>$request->room_type,
                                                'room_id' => $request->room_id,
                                                 'added_by' => $invoice->added_by,
                                                 'client_id' =>   $invoice->client_id,
                                                 'hotel_id' =>   $invoice->hotel_id,
                                                 'invoice_date' =>  $invoice->invoice_date,
                                                'type' =>   'Sales',
                                                 'invoice_item_id' =>$invtms->id,
                                                'invoice_id' =>$invoice->id);
                                                   
                                 
                                               InvoiceHistory::create($lists);
                                               
                                               
                                               
                            
                                                $new= array(
                                                'check_in' =>  $request->start_date,
                                                 'check_out' => $request->end_date,
                                                'room_id' => $request->room_id,
                                                'hotel_id' =>   $invoice->hotel_id,
                                                 'added_by' => $invoice->added_by,
                                                 'status' =>   $status,
                                                 'invoice_item_id' =>$invtms->id,
                                                'invoice_id' =>$invoice->id);
                                                   
                                 
                                               Booked::create($new); 
                                               
                                    
            
                                }
                               
                               
                               
       
      
          
                        $response=['success'=>true,'error'=>false, 'message' => 'Invoice Items Created successful', 'invoice_item' => $invtms];
                        return response()->json($response, 200);


                     
 
                    

        }
        else
        {
                      
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Invoice Items Successfully'];
             return response()->json($response,200);
        } 
    }

    
    public function item_sales_delete(int $id){

        $invoice_item = InvoiceItems::find($id);

        $invoice_id = $invoice_item->hotel_id; 

        $invoice = Invoice::find($invoice_id);

        $invoice_items99 =  $invoice_item->delete();


        if($invoice_items99)
        {
            

            $response=['success'=>true,'error'=>false,'message'=>'Deleted Successfully'];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Deleted Successfully'];
            return response()->json($response,200);
        }

    }

    public function item_sales_update(Request $request){

        $this->validate($request,[
            'room_id' => 'required',
            'price' => 'required',
            'room_type' => 'required',

            'invoice_id' => 'required',

        ]);

      

                    $invoice = Invoice::find(intval($request->invoice_id));
                    

                    if (!empty($invoice)) {




                        if(!empty($request->purchase_item_id)){

                        $invoice_item = InvoiceItems::find($request->purchase_item_id);


                       $se=$request->start_date ." - ".$request->end_date ;
                    
                                $items23 = array(
                                'room_id' => $request->room_id,
                                'room_type' =>$request->room_type,
                                'dates' =>  $se,
                                'check_in' =>  $request->start_date,
                                'check_out' => $request->end_date,
                                'checkout_time' =>  $request->checkout_time,
                                'price' =>  $request->price,
                                'nights' =>  $request->nights,
                                'total_cost' =>  $request->total_cost,
                                'items_id' => $request->room_id,
                                'order_no' => $iy,
                                'added_by' => $invoice->added_by,
                                'hotel_id' =>$invoice->hotel_id,
                                'invoice_id' =>$invoice->id);

                        $invoice_item_updated =  InvoiceItems::where('id',$invoice_item->id)->update($items23);

                       

                        if ($invoice_item_updated) {
                            $response=['success'=>true,'error'=>false, 'message' => 'Invoice Items Updated successful',];
                            return response()->json($response, 200);
                        }
                        else
                        {
                                                
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Update Invoice Items Successfully'];
                            return response()->json($response,200);
                        }

                        // --------------------------------------------

                        }
                        else{

                            
                        // ----------------------------
                     

                         $iyt = InvoiceItems::where('invoice_id', $invoice->id)->orderBy('created_at', 'desc')->first();
                
                            if(!empty($iyt)){
                                $iy = $iyt->order_no + 1;
                            }
                            else{
                
                                $iy = 1;
                            }

                              $se=$request->start_date ." - ".$request->end_date ;
                    
                                $items = array(
                                'room_id' => $request->room_id,
                                'room_type' =>$request->room_type,
                                'dates' =>  $se,
                                'check_in' =>  $request->start_date,
                                'check_out' => $request->end_date,
                                'checkout_time' =>  $request->checkout_time,
                                'price' =>  $request->price,
                                'nights' =>  $request->nights,
                                'total_cost' =>  $request->total_cost,
                                'items_id' => $request->room_id,
                                'order_no' => $iy,
                                'added_by' => $invoice->added_by,
                                'hotel_id' =>$invoice->hotel_id,
                                'invoice_id' =>$invoice->id);

                        $pt =  InvoiceItems::create($items);  ;
                        
                        
                        if($invoice->sales_type == 'Cash Sales'){

                                       
                                       
                                       if($request->start_date == date('Y-m-d') ){
                                           $status = 1;
                                       }
                                       else{
                                            $status = 0;
                                       }
                                       
                                        $lists= array(
                                                'quantity' =>  1,
                                                'price' =>  $request->total_cost,
                                                'room_type'=>$request->room_type,
                                                'room_id' => $request->room_id,
                                                 'added_by' => $invoice->added_by,
                                                 'client_id' =>   $invoice->client_id,
                                                 'hotel_id' =>   $invoice->hotel_id,
                                                 'invoice_date' =>  $invoice->invoice_date,
                                                'type' =>   'Sales',
                                                 'invoice_item_id' =>$invtms->id,
                                                'invoice_id' =>$invoice->id);
                                                   
                                 
                                               InvoiceHistory::create($lists);
                                               
                                               
                                               
                            
                                                $new= array(
                                                'check_in' =>  $request->start_date,
                                                 'check_out' => $request->end_date,
                                                'room_id' => $request->room_id,
                                                'hotel_id' =>   $invoice->hotel_id,
                                                 'added_by' => $invoice->added_by,
                                                 'status' =>   $status,
                                                 'invoice_item_id' =>$invtms->id,
                                                'invoice_id' =>$invoice->id);
                                                   
                                 
                                               Booked::create($new); 
                                               
                                    
            
                                }


                        if ($pt) {
                            $response=['success'=>true,'error'=>false, 'message' => 'Invoice Items Created successful'];
                            return response()->json($response, 200);
                        }
                        else
                        {
                                                
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Invoice Items Successfully'];
                            return response()->json($response,200);
                        }

                        // --------------------------------------------
                        }


                    }
                        else
                        {
                            
                            $response=['success'=>false,'error'=>true,'message'=>'Invoice Not found'];
                            return response()->json($response,200);
                        }
          
    }
    
    
    public function order_receive(int $id){
        
           $invoice  = Order::find($id);
         
            $data['status']= 5;
    
          $inv =  $invoice->update($data);
          
          
          if($invoice->status == 0){
                    $invoice['status'] = 'Not Approved';
                }
                elseif($invoice->status == 1){
                    $invoice['status'] = 'Not Paid';
                }
                elseif($invoice->status == 2){
                    $invoice['status'] = 'Partially Paid';
                }
                elseif($invoice->status == 3){
                    $invoice['status'] = 'Fully Paid';
                }
                elseif($invoice->status == 4){
                    $invoice['status'] = 'Cancelled';
                }
                elseif($invoice->status == 7){
                    $invoice['status'] = 'Paid';
                }
                elseif($invoice->status == 5){
                    $invoice['status'] = 'Delivered';
                }
          
          if ($inv) {

                               

          $response=['success'=>true,'error'=>false, 'message' => 'Order Delivered successful', 'order' => $invoice];
          return response()->json($response, 200);
        }
         else{
                                                
              $response=['success'=>false,'error'=>true,'message'=>'Failed to  Delivered Order Successfully'];
              return response()->json($response,200);
             }
        
    }
    
    public function order_cancel(int $id){
        
           $invoice  = Order::find($id);
         
            $data['status']= 4;
    
          $inv =  $invoice->update($data);
          
          if($invoice->status == 0){
                    $invoice['status'] = 'Not Approved';
                }
                elseif($invoice->status == 1){
                    $invoice['status'] = 'Not Paid';
                }
                elseif($invoice->status == 2){
                    $invoice['status'] = 'Partially Paid';
                }
                elseif($invoice->status == 3){
                    $invoice['status'] = 'Fully Paid';
                }
                elseif($invoice->status == 4){
                    $invoice['status'] = 'Cancelled';
                }
                elseif($invoice->status == 7){
                    $invoice['status'] = 'Paid';
                }
                elseif($invoice->status == 5){
                    $invoice['status'] = 'Delivered';
                }
          
          if ($inv) {

          $response=['success'=>true,'error'=>false, 'message' => 'Order Delivered successful', 'order' => $invoice];
          return response()->json($response, 200);
        }
         else{
                                                
              $response=['success'=>false,'error'=>true,'message'=>'Failed to  Delivered Order Successfully'];
              return response()->json($response,200);
             }
        
    }


   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

       OrderItem::where('invoice_id', $id)->delete();
       OrderPayments::where('invoice_id', $id)->delete();
       
        $invoices =Order::find($id);
        $invoices->delete();

        Toastr::success('Order Deleted Successfully','Success');
        return redirect(route('orders.index'));
    }


  public function showType(Request $request)
    {
         if($request->id == 'Bar'){
       $item= Items::all(); 
         }

         else if($request->id == 'Kitchen'){

           $item=Menu::where('status','1')->get(); 
        
                 }
                                                                                          
               return response()->json($item);

}

 



 
}
