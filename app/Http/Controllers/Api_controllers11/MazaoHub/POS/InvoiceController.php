<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\POS\InvoicePayments;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\POS\PurchaseHistory;
use App\Models\Retail\PurchaseSerialList;
use App\Models\POS\Items;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Region;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\POS\Activity;
use App\Models\Client;
use App\Models\Retail\InventoryList;
use App\Models\Retail\InvoiceSerialPayments;
use App\Models\Retail\InvoiceSerialHistory;
use App\Models\Retail\InvoiceSerial;
use App\Models\Retail\InvoiceSerialItems;
use App\Models\POS\Purchase;
use App\Models\POS\PurchaseItems;
use App\Models\ServiceType;
use App\Models\User;
use Exception;
use PDF;


use Illuminate\Http\Request;

class InvoiceController extends Controller
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
            
        $invoices=Invoice::where('invoice_status',1)->where('added_by', $added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;
                if (!empty($row->store_id)) {
                    $data['location_id'] = intval($row->store_id);
                    $location = Location::find($row->store_id);
                    if(!empty($location)){
                        $loc2= Location::where('id', $row->store_id)->value('name');


                        $data['location'] = $loc2;
                    }

                    else{
                        $data['location'] = null;

                    }

                    
                }
                else{
                    $data['location_id'] = null;

                    // $loc2= Location::where('id', $row->location)->value('name');


                    $data['location'] = null;
                }
                if(!empty($row->client_id)){
                    $data['client_id'] =  intval($row->client_id);
                }
                else{
                    $data['client_id'] =  null;
                }

                

                $client_id = Client::find(intval($row->client_id));
                if(!empty($client_id)){

                $data['client'] =  Client::find(intval($row->client_id))->name;

                $data['client_tin'] =  Client::find(intval($row->client_id))->TIN;

                $data['client_email'] =  Client::find(intval($row->client_id))->email;

                $data['client_phone'] =  Client::find(intval($row->client_id))->phone;

                $data['client_address'] =  Client::find(intval($row->client_id))->address;
                }
                else{

                    $data['client'] =  null;

                    $data['client_tin'] =  null;
    
                    $data['client_email'] =  null;
    
                    $data['client_phone'] =  null;
    
                    $data['client_address'] =  null;
                }

                // $region = Region::find($row->region);
                
                if(!empty($row->region)){

                    $data['region']  = $row->region;

                }
                else{
                    $data['region']  = null;

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
                elseif($row->status == 5){
                    $data['status'] = 'Received';
                }

                elseif($row->status == 6){
                    $data['status'] = 'Scanned and Paid';
                }
                elseif($row->status == 7){
                    $data['status'] = 'Paid';
                }

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','invoice'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Invoices found'];
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
        

        $invoices=Invoice::where('invoice_status',1)->where('store_id', $id)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;
                if (!empty($row->location)) {
                    $data['location_id'] = intval($row->location);
                    $location = Location::find($row->location);
                    if(!empty($location)){
                        $loc2= Location::where('id', $row->location)->value('name');


                        $data['location'] = $loc2;
                    }

                    else{
                        $data['location'] = null;

                    }

                    
                }
                else{
                    $data['location_id'] = null;

                    // $loc2= Location::where('id', $row->location)->value('name');


                    $data['location'] = null;
                }
                if(!empty($row->client_id)){
                    $data['client_id'] =  intval($row->client_id);
                }
                else{
                    $data['client_id'] =  null;
                }

                

                $client_id = Client::find(intval($row->client_id));
                if(!empty($client_id)){

                $data['client'] =  Client::find(intval($row->client_id))->name;

                $data['client_tin'] =  Client::find(intval($row->client_id))->TIN;

                $data['client_email'] =  Client::find(intval($row->client_id))->email;

                $data['client_phone'] =  Client::find(intval($row->client_id))->phone;

                $data['client_address'] =  Client::find(intval($row->client_id))->address;
                }
                else{

                    $data['client'] =  null;

                    $data['client_tin'] =  null;
    
                    $data['client_email'] =  null;
    
                    $data['client_phone'] =  null;
    
                    $data['client_address'] =  null;
                }

                // $region = Region::find($row->region);
                
                if(!empty($row->region)){

                    $data['region']  = $row->region;

                }
                else{
                    $data['region']  = null;

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
                elseif($row->status == 5){
                    $data['status'] = 'Received';
                }

                elseif($row->status == 6){
                    $data['status'] = 'Scanned and Paid';
                }
                elseif($row->status == 7){
                    $data['status'] = 'Paid';
                }

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','invoice'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Invoices found'];
            return response()->json($response,200);
        } 
        
        
       
       
    }

    public function indexOff(int $id, int $lastId)
    {
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
        
        
        $invoices=Invoice::where('invoice_status',1)->where('added_by', $added_by)->where('id', '>' ,$lastId)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;
                if (!empty($row->location)) {
                    $data['location_id'] = intval($row->location);
                    $location = Location::find(intval($row->location));
                    if(!empty($location)){
                        $loc2= Location::where('id', $row->location)->value('name');


                        $data['location'] = $loc2;
                    }

                    else{
                        $data['location'] = null;

                    }

                    
                }
                else{
                    $data['location_id'] = null;

                    // $loc2= Location::where('id', $row->location)->value('name');


                    $data['location'] = null;
                }

                if(!empty($row->client_id)){
                    $data['client_id'] =  intval($row->client_id);
                }
                else{
                    $data['client_id'] =  null;
                }

               $client_id = Client::find(intval($row->client_id));
                if(!empty($client_id)){

                $data['client'] =  Client::find(intval($row->client_id))->name;

                $data['client_tin'] =  Client::find(intval($row->client_id))->TIN;

                $data['client_email'] =  Client::find(intval($row->client_id))->email;

                $data['client_phone'] =  Client::find(intval($row->client_id))->phone;

                $data['client_address'] =  Client::find(intval($row->client_id))->address;
                }
                else{

                    $data['client'] =  null;

                    $data['client_tin'] =  null;
    
                    $data['client_email'] =  null;
    
                    $data['client_phone'] =  null;
    
                    $data['client_address'] =  null;
                }
                // $region = Region::find($row->region);

                
                if(!empty($row->region)){

                    $data['region']  = $row->region;

                }
                else{
                    $data['region']  = null;

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
                elseif($row->status == 5){
                    $data['status'] = 'Received';
                }

                elseif($row->status == 6){
                    $data['status'] = 'Scanned and Paid';
                }
                elseif($row->status == 7){
                    $data['status'] = 'Paid';
                }

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','invoice'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Invoices found'];
            return response()->json($response,200);
        } 
        
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       } 
       
    }
    
    public function updatelocation(int $id)
    {
        //
        $userinv = Invoice::where('invoice_status',1)->where('disabled','0')->where('added_by', $id)->orderBy('created_at', 'desc')->get();
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){
                
                // $data = $row;

                $data['location'] = 99;
                
                $data['store_id'] = 99;
                
                  Invoice::where('id', $row->id)->update($data);
               

                // $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully'];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Invoices found'];
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
        //

        $this->validate($request,[
            'invoice_date' => 'required',
            // 'due_date' => 'required',
            'exchange_code' => 'required',

            'exchange_rate' => 'required',
            'sales_type' =>'required',


            


        ]);




        $usr = User::find($request->input('id'));
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;

            
          $count=Invoice::where('added_by', $added_by)->count();
          $pro=$count+1;
          $data['reference_no']= "S0".$pro;
          $data['client_id']=$request->client_id;
          $data['project_id']=$request->project_id;
          
          $data['invoice_date']=$request->invoice_date;
          
          $data['due_date']=$request->invoice_date;
  
          $data['exchange_code']=$request->exchange_code;
          $data['exchange_rate']=$request->exchange_rate;
          $data['notes']=$request->notes;
          
          $data['location']=$request->store_id;
          
    
          
          $data['store_id']=$request->store_id;
  
  
          $subtotal = $request->sub_total;
  
          //purchase_amount
          $data['invoice_amount'] = $subtotal;
          //purchase_tax
          $data['invoice_tax'] = $request->total_tax;
          //shipping_cost
          $data['shipping_cost'] = $request->shipping_cost;
          //subtotal+total+shipcost
          $data['due_amount'] = $request->due_amount;

          $data['sales_type']=$request->sales_type;

  
          if($request->sales_type == "Cash Sale"){

            $data['status']=7;

          }
          else{
            $data['status']=1;

          }
          
          $data['user_id']= $request->id;
  
          $data['good_receive']='1';
  
          $data['invoice_status']=1;
  
          $data['bank_id']=$request->bank_id;
          $data['added_by']= $added_by;
  
          $invoice = Invoice::create($data);
          
        //   =============
        
        
        
            $inv = Invoice::find($invoice->id);
            $supp=Client::find($inv->client_id);
            
            $cr= AccountCodes::where('account_name','Sales')->where('added_by', $added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate = $inv->exchange_rate;
          $journal->added_by = $added_by;
             $journal->notes= "Sales for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
        if($inv->invoice_tax > 0){
         $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by', $added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
             $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit= $inv->invoice_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
           $journal->added_by = $added_by;
             $journal->notes= "Sales Tax for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        }
        
        
        if($inv->shipping_cost > 0){    

      $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',$added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by= $added_by;
             $journal->notes= "Sales Shipping Cost for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
         
          $shp= AccountCodes::where('account_name','Shipping Cost')->where('added_by', $added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $shp->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by= $added_by;
             $journal->notes= "Credit Shipping Cost for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
          
     }
        
          $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',$added_by)->first();
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
          $journal->added_by = $added_by;
            $journal->notes= "Receivables for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
    
         $stock= AccountCodes::where('account_name','Inventory')->where('added_by', $added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by = $added_by;
             $journal->notes= "Reduce Stock  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by', $added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by= $added_by;
             $journal->notes= "Cost of Goods Sold  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
          
          
        
     
     
     if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>$invoice->added_by,
                            'user_id'=>$invoice->user_id,
                            'module_id'=>$invoice->id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Created",
                        ]
                        );                      
       }
          
          
        //   -------------------------------------if sales in Cash------------------
        
        
        
        //invoice payment
             if($invoice->sales_type == 'Cash Sales'){
            
                          $sales =Invoice::find($invoice->id);
                        $method= Payment_methodes::where('name','Cash')->first();
                         $count=InvoicePayments::count();
                        $pro=$count+1;
            
                            $receipt['trans_id'] = "TBSPH-".$pro;
                            $receipt['invoice_id'] = $invoice->id;
                          $receipt['amount'] = $invoice->due_amount;
                            $receipt['date'] = $invoice->invoice_date;
                           $receipt['account_id'] = $request->bank_id;
                             $receipt['payment_method'] = $method->id;
                            $receipt['added_by'] = $added_by;
                            
                            //update due amount from invoice table
                            $b['due_amount'] =  0;
                            $b['paid_amount'] = $request->due_amount;
                           $b['status'] = 3;
                          
                            $sales->update($b);
                             
                            $payment = InvoicePayments::create($receipt);
            
                            $supp=Client::find($sales->client_id);
            
                        //   $cr= AccountCodes::where('id','$request->bank_id')->first();
                      $journal = new JournalEntry();
                    $journal->account_id = $request->bank_id;
                    $date = explode('-',$request->invoice_date);
                    $journal->date =   $request->invoice_date ;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                   $journal->transaction_type = 'pos_invoice_payment';
                    $journal->name = 'Invoice Payment';
                    $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
                    $journal->payment_id= $payment->id;
                    $journal->client_id= $sales->client_id;
                     $journal->currency_code =   $sales->currency_code;
                    $journal->exchange_rate=  $sales->exchange_rate;
                      $journal->added_by= $added_by;
                       $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
                    $journal->save();
            
            
                    $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',$added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                      $date = explode('-',$request->invoice_date);
                    $journal->date =   $request->invoice_date ;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                      $journal->transaction_type = 'pos_invoice_payment';
                    $journal->name = 'Invoice Payment';
                    $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
                      $journal->payment_id= $payment->id;
                  $journal->client_id= $sales->client_id;
                     $journal->currency_code =   $sales->currency_code;
                    $journal->exchange_rate=  $sales->exchange_rate;
                    $journal->added_by=$added_by;
                     $journal->notes= "Clear Receivable for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
                    $journal->save();
                    
            $account= Accounts::where('account_id',$request->bank_id)->first();
            
            if(!empty($account)){
            $balance=$account->balance + $payment->amount ;
            $item_to['balance']=$balance;
            $account->update($item_to);
            }
            
            else{
              $cr= AccountCodes::where('id',$request->bank_id)->first();
            
                 $new['account_id']= $request->bank_id;
                   $new['account_name']= $cr->account_name;
                  $new['balance']= $payment->amount;
                   $new[' exchange_code']= $sales->currency_code;
                    $new['added_by']= $added_by;
            $balance=$payment->amount;
                 Accounts::create($new);
            }
                    
               // save into tbl_transaction
            
                                         $transaction= Transaction::create([
                                            'module' => 'POS Invoice Payment',
                                             'module_id' => $payment->id,
                                           'account_id' => $request->bank_id,
                                            'code_id' => $codes->id,
                                            'name' => 'POS Invoice Payment with reference ' .$payment->trans_id,
                                             'transaction_prefix' => $payment->trans_id,
                                            'type' => 'Income',
                                            'amount' =>$payment->amount ,
                                            'credit' => $payment->amount,
                                             'total_balance' =>$balance,
                                            'date' => date('Y-m-d', strtotime($request->date)),
                                            'paid_by' => $sales->client_id,
                                            'payment_methods_id' =>$payment->payment_method,
                                               'status' => 'paid' ,
                                            'notes' => 'This deposit is from pos invoice  payment. The Reference is ' .$sales->reference_no .' by Client '. $supp->name  ,
                                            'added_by' =>$added_by,
                                        ]);
            
            
                    if(!empty($payment)){
                                $activity =Activity::create(
                                    [ 
                                        'added_by'=>$added_by,
                                            'user_id'=>$request->id,
                                        'module_id'=>$payment->id,
                                         'module'=>'Invoice Payment',
                                        'activity'=>"Invoice with reference no  " .  $sales->reference_no. "  is Paid",
                                    ]
                                    );                      
                   }        
            
            
            
            }
        
        
        
        
        
        
        
        // --------------------------------------
          
        
  
  
  
                  if(!empty($invoice)){
                                  $activity =Activity::create(
                                      [ 
                                          'added_by'=>$invoice->added_by,
                                          'user_id'=>$request->id,
                                          'module_id'=>$invoice->id,
                                          'module'=>'Invoice',
                                          'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Created",
                                      ]
                                      );                      
                  }
                      
                 
  
                  if (!empty($invoice->location)) {
                      $invoice['location_id'] = intval($invoice->location);
  
                      $loc2= Location::where('id', $invoice->location)->value('name');
  
  
                      $invoice['location'] = $loc2;
                  }
                  else{
                      $invoice['location_id'] = null;
  
                      // $loc2= Location::where('id', $row->location)->value('name');
  
  
                      $invoice['location'] = null;
                  }

                  
                  if(!empty($invoice->client_id)){
                    $invoice['client_id'] =  intval($invoice->client_id);
                    }
                    else{
                        $invoice['client_id'] =  null;
                    }

                  $client_id = Client::find(intval($invoice->client_id));
                  if(!empty($client_id)){
  
                  $invoice['client'] =  Client::find(intval($invoice->client_id))->name;
  
                  $invoice['client_tin'] =  Client::find(intval($invoice->client_id))->TIN;
  
                  $invoice['client_email'] =  Client::find(intval($invoice->client_id))->email;
  
                  $invoice['client_phone'] =  Client::find(intval($invoice->client_id))->phone;
  
                  $invoice['client_address'] =  Client::find(intval($invoice->client_id))->address;
                  }
                  else{
  
                      $invoice['client'] =  null;
  
                      $invoice['client_tin'] =  null;
      
                      $invoice['client_email'] =  null;
      
                      $invoice['client_phone'] =  null;
      
                      $invoice['client_address'] =  null;
                  }
  
           
  
                      $invoice['invoice_id'] = $invoice->id;

                    //   $region = Region::find($invoice->region);

                
                        if(!empty($invoice->region)){

                            $invoice['region']  = $invoice->region;

                        }
                        else{
                            $invoice['region']  = null;

                        }
  
                        if(!empty($invoice->store_id)){

                            $invoice['store_id']  = intval($invoice->store_id);

                        }
                        else{
                            $invoice['store_id']  = null;

                        }
  
  
  
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
                  elseif($invoice->status == 5){
                      $invoice['status'] = 'Received';
                  }
  
                  elseif($invoice->status == 6){
                      $invoice['status'] = 'Scanned and Paid';
                  }
                  elseif($invoice->status == 7){
                    $invoice['status'] = 'Paid';
                }
  
              if($invoice)
              {
              
  
              $response=['success'=>true,'error'=>false, 'message' => 'Invoice Created successful', 'invoice' => $invoice];
              return response()->json($response, 200);
              }
              else
              {
              
              $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Invoice Successfully'];
              return response()->json($response,200);
              }
  

        
        }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
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
                
                $data['item_name'] = Items::find(intval($row->items_id))->name;

                $data['inventory_id'] = intval($row->items_id);

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','invoice_item'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Invoices Item found'];
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
                
                $data['item_name'] = Items::find(intval($row->items_id))->name;


                // $data['id'] = intval($row->items_id);

                $data['inventory_id'] = intval($row->items_id);

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','invoice_item'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Invoices Item found'];
            return response()->json($response,200);
        } 

    }

    public function item_store(Request $request){

        $this->validate($request,[
            'item_id' => 'required',
            'item_name' => 'required',
            'tax_rate' => 'required',   

            'price' => 'required',
            'total' => 'required',
            'tax' =>'required',

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
                     
 
                     $d=Items::where('id',$request->item_id)->first();

                     if(!empty($d)){

                        try{

                            // if($d->category == 'Batch'){ 
                                $bt =  PurchaseHistory::where('item_id',$request->item_id)->first();
                                  if (!empty($bt)) {
                                    //   $purchase_id =$bt->location;
          
                                    //  $data['location']= $bt->location;
          
                                    //   Invoice::where('id', $invoice->id)->update($data);
                                      $batch=$bt->batch_number;
                                      $expire=$bt->expire_date;
                                      $serial='';
          
                                 }
          
                                  else{
                                    //  $data['location']= null;
          
                                    //   Invoice::where('id', $invoice->id)->update($data);
                                      $batch=null;
                                      $expire=null;
                                      $serial='';
          
                                 }
          
                             
                              $items23 = array(
                                 'type' => $request->item_name,
                            //    'category' => $d->category,
                                  'item_name' => $request->item_id,
                                  'quantity' =>   $request->quantity,
                                    'due_quantity' => $request->quantity,
                                  // 'batch_number' =>  $batch,                        
                                  // 'expire_date' => $expire,
                                  //  'serial_no' =>  $serial,
                                  'tax_rate' =>  $request->tax_rate,
                                   'unit' =>$d->unit,
                                   'price' =>  $request->price,
                                   'total_cost' =>  $request->total,
                                   'total_tax' =>   $request->tax,
                                    'items_id' => $request->item_id,
                                     'purchase_history'=>$request->item_name,
                                     'order_no' => $iy,
                                     'added_by' => $invoice->added_by,
                                     'reference_no' => $invoice->reference_no,
          
                                     'invoice_amount' => $invoice->invoice_amount,
                                     'invoice_tax' => $invoice->invoice_tax,
                                      'shipping_cost' => $invoice->shipping_cost,
                                     //subtotal+total+shipcost
                                     'due_amount' => $invoice->due_amount,
                                  'invoice_id' =>$invoice->id);
                                 
                               $dt2 =   InvoiceItems::create($items23);  ;
    
    
                            //    error_log("++++++++++++++++++++++++++++  invoice items    ========================");
                            
                                         $lists= array(
                                            'item_name' => $request->item_id,
                                                'quantity' =>   $request->quantity,
                                            'batch_number' =>  $batch,                        
                                            'expire_date' => $expire,
                                                'serial_no' =>  $serial,
                                                    'item_id' => $request->item_id,
                                                    'location' =>$invoice->location,
                                                    'price' => $request->price,
                                                    'added_by' => $invoice->added_by,
                                                    'client_id' =>   $invoice->client_id,
                                                    'invoice_date' =>  $invoice->invoice_date,
                                                'type' =>   'Sales',
                                                'invoice_id' =>$invoice->id);
                                                
                                                InvoiceHistory::create($lists);  
                            
                            
    
                            //    error_log( $dt2);
    
                            //    error_log("++++++++++++++++++++++++++++ endd invoice items    ========================");
    
         
         
                               $inv=Items::where('id',$request->item_id)->first();
                               
                            //    error_log("++++++++++++++++++++++++++++  invoice items    ========================");
    
    
                            //    error_log( $inv);
    
                            //    error_log("++++++++++++++++++++++++++++ endd invoice items    ========================");
                               $q=$inv->quantity - $request->quantity;
                           $itm_new =    Items::where('id',$request->item_id)->update(['quantity' => $q]);
                       
                                //    $loc=Location::where('id',$invoice->location)->first();
    
                                //    error_log("++++++++++++++++++++++++++++  invoice items    ========================");
    
    
                                //     error_log( $loc);
    
                                //     error_log("++++++++++++++++++++++++++++ endd invoice items    ========================");
    
                            //    $lq['quantity']=$loc->quantity - $request->quantity;
                            //  $loc_qun =  Location::where('id',$invoice->location)->update($lq);
    
                                                  
                 
                                    //  $dt2['expire_date'] = $pt->expire_date;
    
                                     $dt2['quantity'] = $q;

                                    $dt2['inventory_id'] = intval($dt2->items_id);
                                    
                                    $dt2['item_name'] = Items::find(intval($dt2->items_id))->name;

     
                                    //  $dt2['rem_location_quantity'] = $lq['quantity'];

                        }
                        

                        


                                 catch(Exception $e){

                                    $message = $e->getMessage();
                                    error_log('Exception Message: '. $message);
                        
                                    $code = $e->getCode();       
                                    error_log('Exception Code: '. $code);
                        
                                    $string = $e->__toString();       
                                    error_log('Exception String: '. $string);

                                    exit;
                            
                                }         
          
                        $response=['success'=>true,'error'=>false, 'message' => 'Invoice Items Created successful', 'invoice_item' => $dt2];
                        return response()->json($response, 200);


                     }
                     else{

                        $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Invoice Items Cause There is no item by that id in inventory'];
                        return response()->json($response,200); 
                     }
 
                    

        }
        else
        {
                      
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Invoice Items Successfully'];
             return response()->json($response,200);
        } 
    }

    
    public function item_sales_delete(int $id){

        $invoice_item = InvoiceItems::find($id);

        $invoice_id = $invoice_item->invoice_id; 

        $invoice = Invoice::find($invoice_id);





        $data['purchase_amount'] = $invoice->purchase_amount -  $invoice_item->total_cost;

        $data['purchase_tax'] = $invoice->purchase_tax - $invoice_item->total_tax;

        $data['due_amount'] = $invoice->due_amount - $invoice_item->total_tax - $invoice_item->total_cost;


       


               


                    $invoice->update($data);

                    $invoice_items12 = InvoiceItems::where('invoice_id', $invoice_id)->update($data);

                    $inv=Items::where('id',$invoice_item->items_id)->first();
                    $q=$inv->quantity + $invoice_item->quantity;
                    Items::where('id',$invoice_item->items_id)->update(['quantity' => $q]);
            
                    //     $loc=Location::where('id',$invoice->location)->first();
                    // $lq['quantity']=$loc->quantity + $invoice_item->quantity;
                    // Location::where('id',$invoice->location)->update($lq);
            
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
            'item_id' => 'required',
            // 'item_name' => 'required',
            'item_name' => 'required',

            'tax_rate' => 'required',

            'price' => 'required',
            'total_cost' => 'required',
            'tax' =>'required',

            'invoice_id' => 'required',

        ]);
      

            $itm = Items::where('id',$request->item_id)->first();

            if(!empty($itm)){

                    $invoice = Invoice::find($request->invoice_id);
                    

                    if (!empty($invoice)) {




                        if(!empty($request->purchase_item_id)){

                        $invoice_item = InvoiceItems::find($request->purchase_item_id);

                        $d=Items::where('id', $request->item_id)->first();

                        $items23 = array(
                            'type' => $request->item_name,

                            'category' => $d->category,
                                'item_name' => $request->item_id,
                                'quantity' =>   $request->quantity,
                                'due_quantity' => $request->quantity,
                                'tax_rate' =>  $request->tax_rate,
                                'unit' =>$d->unit,
                                'price' =>  $request->price,
                                'total_cost' =>  $request->total_cost,
                                'total_tax' =>   $request->tax,
                                'items_id' => $request->item_id,

                            
                            'added_by' => $invoice->added_by,

                            'reference_no' => $invoice->reference_no,

                            'invoice_amount' => $invoice->invoice_amount,
                            'invoice_tax' => $invoice->invoice_tax,
                                'shipping_cost' => $invoice->shipping_cost,
                            //subtotal+total+shipcost
                            'due_amount' => $invoice->due_amount,
                            'invoice_id' =>$invoice->id);

                        $invoice_item_updated =  InvoiceItems::where('id',$invoice_item->id)->update($items23);

                        // $purchase_item_updated = $pt122->update($items23);

                        // $pt =  PurchaseItems::create($items23);;

                        $inv=Items::where('id',$request->item_id)->first();
                        $q=$inv->quantity - $request->quantity;
                        Items::where('id',$request->item_id)->update(['quantity' => $q]);
                
                        //     $loc=Location::where('id',$invoice->location)->first();
                        // $lq['quantity']=$loc->quantity - $request->quantity;
                        // Location::where('id',$invoice->location)->update($lq);

                       

                        if ($invoice_item_updated) {
                            $response=['success'=>true,'error'=>false, 'message' => 'Invoice Item Updated successful',];
                            return response()->json($response, 200);
                        }
                        else
                        {
                                                
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Update Invoice Item Successfully'];
                            return response()->json($response,200);
                        }

                        // --------------------------------------------

                        }
                        else{

                            
                        // ----------------------------
                        $iyt = InvoiceItems::where('invoice_id', $invoice->id)->orderBy('created_at', 'desc')->first();

                        if (!empty($iyt)) {
                            $iy = $iyt->order_no + 1;
                        } else {
                            $iy = 1;
                        }

                        $d=Items::where('id', $request->item_id)->first();

                        $items23 = array(
                            'type' => $request->item_name,

                            'category' => $d->category,
                                'item_name' => $request->item_id,
                                'quantity' =>   $request->quantity,
                                'due_quantity' => $request->quantity,
                                'tax_rate' =>  $request->tax_rate,
                                'unit' =>$d->unit,
                                'price' =>  $request->price,
                                'total_cost' =>  $request->total_cost,
                                'total_tax' =>   $request->tax,
                                'items_id' => $request->item_id,

                            'order_no' => $iy,
                            'added_by' => $invoice->added_by,

                            'reference_no' => $invoice->reference_no,

                            'invoice_amount' => $invoice->invoice_amount,
                            'invoice_tax' => $invoice->invoice_tax,
                                'shipping_cost' => $invoice->shipping_cost,
                            //subtotal+total+shipcost
                            'due_amount' => $invoice->due_amount,
                            'invoice_id' =>$invoice->id);

                        $pt =  InvoiceItems::create($items23);;

                        $inv=Items::where('id',$request->item_id)->first();
                        $q=$inv->quantity - $request->quantity;
                        Items::where('id',$request->item_id)->update(['quantity' => $q]);
                
                        //     $loc=Location::where('id',$invoice->location)->first();
                        // $lq['quantity']=$loc->quantity - $request->quantity;
                        // Location::where('id',$invoice->location)->update($lq);

                        

                        if ($pt) {
                            $response=['success'=>true,'error'=>false, 'message' => 'Invoice Created successful'];
                            return response()->json($response, 200);
                        }
                        else
                        {
                                                
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Invoice Successfully'];
                            return response()->json($response,200);
                        }

                        // --------------------------------------------
                        }


                    }
                        else
                        {
                            
                            $response=['success'=>false,'error'=>true,'message'=>'Purchase Not found'];
                            return response()->json($response,200);
                        }
            }
            else{

                $response=['success'=>false,'error'=>true,'message'=>'Items not found'];
                return response()->json($response,200);
            }
    }
    
    
    
    public function item_store222(Request $request){

        $this->validate($request,[
            'item_id' => 'required',
            'item_name' => 'required',
            'tax_rate' => 'required',   

            'price' => 'required',
            'total' => 'required',
            'tax' =>'required',

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
                     
 
                     $d=Items::where('id',$request->item_id)->first();

                     if(!empty($d)){

                        try{

                            // if($d->category == 'Batch'){ 
                                $bt =  PurchaseHistory::where('item_id',$request->item_id)->first();
                                  if (!empty($bt)) {
                                    //   $purchase_id =$bt->location;
          
                                    //  $data['location']= $bt->location;
          
                                    //   Invoice::where('id', $invoice->id)->update($data);
                                      $batch=$bt->batch_number;
                                      $expire=$bt->expire_date;
                                      $serial='';
          
                                 }
          
                                  else{
                                    //  $data['location']= null;
          
                                    //   Invoice::where('id', $invoice->id)->update($data);
                                      $batch=null;
                                      $expire=null;
                                      $serial='';
          
                                 }
          
                              
                                //  }
                                //  else{
                                //  $st=  PurchaseSerialList::where('brand_id',$request->item_id)->first();
                                //      if (!empty($st)) {
                                //              $purchase_id =$st->purchase_id;
                     
                                //              $data['location']= Purchase::find($purchase_id)->location;
                     
                                //              Invoice::where('id', $invoice->id)->update($data);
                                //              $batch='';
                                //              $expire='';
                                //                   //    $serial= $st->serial_no;
                                //       }
                                //  else{
                                //          $data['location']= null;
             
                                //          Invoice::where('id', $invoice->id)->update($data);
                                //      }
                                //  }
                              $items23 = array(
                                 'type' => $request->item_name,
                            //    'category' => $d->category,
                                  'item_name' => $request->item_id,
                                  'quantity' =>   $request->quantity,
                                    'due_quantity' => $request->quantity,
                                  // 'batch_number' =>  $batch,                        
                                  // 'expire_date' => $expire,
                                  //  'serial_no' =>  $serial,
                                  'tax_rate' =>  $request->tax_rate,
                                   'unit' =>$d->unit,
                                   'price' =>  $request->price,
                                   'total_cost' =>  $request->total,
                                   'total_tax' =>   $request->tax,
                                    'items_id' => $request->item_id,
                                     'purchase_history'=>$request->item_name,
                                     'order_no' => $iy,
                                     'added_by' => $invoice->added_by,
                                     'reference_no' => $invoice->reference_no,
          
                                     'invoice_amount' => $invoice->invoice_amount,
                                     'invoice_tax' => $invoice->invoice_tax,
                                      'shipping_cost' => $invoice->shipping_cost,
                                     //subtotal+total+shipcost
                                     'due_amount' => $invoice->due_amount,
                                  'invoice_id' =>$invoice->id);
                                 
                               $dt2 =   InvoiceItems::create($items23);  ;
    
    
                            //    error_log("++++++++++++++++++++++++++++  invoice items    ========================");
                            
                                         $lists= array(
                                            'item_name' => $request->item_id,
                                                'quantity' =>   $request->quantity,
                                            'batch_number' =>  $batch,                        
                                            'expire_date' => $expire,
                                                'serial_no' =>  $serial,
                                                    'item_id' => $request->item_id,
                                                    'location' =>$invoice->location,
                                                    'price' => $request->price,
                                                    'added_by' => $invoice->added_by,
                                                    'client_id' =>   $invoice->client_id,
                                                    'invoice_date' =>  $invoice->invoice_date,
                                                'type' =>   'Sales',
                                                'invoice_id' =>$invoice->id);
                                                
                                                InvoiceHistory::create($lists);  
                            
                            
    
                            //    error_log( $dt2);
    
                            //    error_log("++++++++++++++++++++++++++++ endd invoice items    ========================");
    
         
         
                               $inv=Items::where('id',$request->item_id)->first();
                               
                            //    error_log("++++++++++++++++++++++++++++  invoice items    ========================");
    
    
                            //    error_log( $inv);
    
                            //    error_log("++++++++++++++++++++++++++++ endd invoice items    ========================");
                               $q=$inv->quantity - $request->quantity;
                           $itm_new =    Items::where('id',$request->item_id)->update(['quantity' => $q]);
                       
                                //    $loc=Location::where('id',$invoice->location)->first();
    
                                //    error_log("++++++++++++++++++++++++++++  invoice items    ========================");
    
    
                                //     error_log( $loc);
    
                                //     error_log("++++++++++++++++++++++++++++ endd invoice items    ========================");
    
                            //    $lq['quantity']=$loc->quantity - $request->quantity;
                            //  $loc_qun =  Location::where('id',$invoice->location)->update($lq);
    
                                                    
                 
                                    //  $dt2['expire_date'] = $pt->expire_date;
    
                                     $dt2['quantity'] = $q;

                                    $dt2['inventory_id'] = intval($dt2->items_id);

     
                                    //  $dt2['rem_location_quantity'] = $lq['quantity'];

                        }
                        

                        


                                 catch(Exception $e){

                                    $message = $e->getMessage();
                                    error_log('Exception Message: '. $message);
                        
                                    $code = $e->getCode();       
                                    error_log('Exception Code: '. $code);
                        
                                    $string = $e->__toString();       
                                    error_log('Exception String: '. $string);

                                    exit;
                            
                                }         
          
                        $response=['success'=>true,'error'=>false, 'message' => 'Invoice Items Created successful', 'invoice_item' => $dt2];
                        return response()->json($response, 200);


                     }
                     else{

                        $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Invoice Items Cause There is no item by that id in inventory'];
                        return response()->json($response,200); 
                     }
 
                    

        }
        else
        {
                      
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Invoice Items Successfully'];
             return response()->json($response,200);
        } 
    }

//     public function make_invoice_payment(Request $request){
        
//         $this->validate($request,[
//             'amount'=>'required',
//             'payment_date'=>'required',
//             'payment_method'=>'required',
//             'account_id'=>'required',
//             'id'=>'required',

            
//         ]);


        
//    if($request->hasFile('attach_reference')){
//     $filenameWithExt=$request->file('attach_reference')->getClientOriginalName();
//      $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
//      $extension=$request->file('attach_reference')->getClientOriginalExtension();
//      $fileNameToStore=$filename.'_'.time().'.'.$extension;
//      $path=$request->file('attach_reference')->storeAs('batch/reference',$fileNameToStore);
// }
// else{
// $fileNameToStore='';
// }

//      $invoice = Invoice::find($id);
//      $data['client_id']=$request->client_id;
//      $data['invoice_date']=$request->invoice_date;
//      $data['due_date']=$request->due_date;
//       $data['location']=$request->location;
//       $data['region']=$request->region;
//      $data['order_reference']=$request->order_reference;
// $data['attach_reference']= $fileNameToStore;
//      $data['exchange_code']=$request->exchange_code;
//      $data['exchange_rate']=$request->exchange_rate;
//      $data['notes']=$request->notes;
//      $data['invoice_amount']='1';
//      $data['due_amount']='1';
//      $data['invoice_tax']='1';
//      $data['good_receive']='1';
//      $data['invoice_status'] = 1;
//        $data['status'] = 1;
//   $data['sales_type']=$request->sales_type;
//  $data['bank_id']=$request->bank_id;
//      $data['added_by']= auth()->user()->added_by;

//  if(!empty($invoice->attach_reference)){
//  if($request->hasFile('attach_reference')){
//      unlink('batch/reference/'.$invoice->attach_reference);  
    
//  }
// }

//      $invoice->update($data);
     
//      $amountArr = str_replace(",","",$request->amount);
//      $totalArr =  str_replace(",","",$request->tax);
    
//      $nameArr =$request->item_name ;
//      $typeArr =$request->type ;
//  $categoryArr =$request->category ;
//      $qtyArr = $request->quantity  ;
//      //$batchArr = $request->batch_number;
//     // $expireArr = $request->expire_date;
//      $priceArr = $request->price;
//      $rateArr = $request->tax_rate ;
//      $unitArr = $request->unit  ;
//      $costArr = str_replace(",","",$request->total_cost)  ;
//      $taxArr =  str_replace(",","",$request->total_tax );
//  $shipArr =  str_replace(",","",$request->shipping_cost);
//      $remArr = $request->removed_id ;
//      $expArr = $request->saved_items_id ;
//      $savedArr =$request->item_name ;
     
//      $cost['invoice_amount'] = 0;
//      $cost['invoice_tax'] = 0;
//         $cost['shipping_cost']=0;

//      if (!empty($remArr)) {
//          for($i = 0; $i < count($remArr); $i++){
//             if(!empty($remArr[$i])){        
//              InvoiceItems::where('id',$remArr[$i])->delete();        
//                 }
//             }
//         }

//      if(!empty($nameArr)){
//          for($i = 0; $i < count($nameArr); $i++){
//              if(!empty($nameArr[$i])){
//                  $cost['invoice_amount'] +=$costArr[$i];
//                  $cost['invoice_tax'] +=$taxArr[$i];
//                    $cost['shipping_cost'] =$shipArr[0];

                      
//              $d=Items::where('id',$typeArr[$i])->first();
//               if($categoryArr[$i] == 'Batch'){
//                $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
//                $batch=$bt->batch_number;
//               $expire=$bt->expire_date;
//              $serial='';
             
//                 }
//                  else{
//                 $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
//                $batch='';
//               $expire='';
//                 $serial= $st->serial_no;
//                 }

                 
//                  $items = array(
//                      'item_name' => $nameArr[$i],
//                      'quantity' =>   $qtyArr[$i],
//                      'due_quantity' =>   $qtyArr[$i],
//                      'batch_number' =>  $batch,                        
//                  'expire_date' => $expire,
//                   'serial_no' =>  $serial,
//                  'tax_rate' =>  $rateArr [$i],
//                   'unit' =>$d->unit,
//                         'price' =>  $priceArr[$i],
//                      'total_cost' =>  $costArr[$i],
//                      'total_tax' =>   $taxArr[$i],
//                       'items_id' => $savedArr[$i],
//                         'purchase_history'=>$nameArr[$i],
//                         'order_no' => $i,
//                         'added_by' => auth()->user()->added_by,
//                      'invoice_id' =>$id);
                    
//                      if(!empty($expArr[$i])){
//                          InvoiceItems::where('id',$expArr[$i])->update($items);  
   
//    }
//    else{
//      InvoiceItems::create($items);   
//    }
               
           
  

//              }
//          }
//          $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'] +$cost['shipping_cost'] ;
//          Invoice::where('id',$id)->update($cost);
//      }    

     

//      if(!empty($nameArr)){
//          for($i = 0; $i < count($nameArr); $i++){
//              if(!empty($nameArr[$i])){

 
//                 if($categoryArr[$i] == 'Batch'){
//                $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
//                $batch=$bt->batch_number;
//               $expire=$bt->expire_date;
//              $serial='';
             
//                 }
//                  else{
//                 $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
//                $batch='';
//               $expire='';
//                 $serial= $st->serial_no;
//                 }
            
//                  $lists= array(
//                   'category' => $categoryArr[$i],
//                  'item_name' => $nameArr[$i],
//                      'quantity' =>   $qtyArr[$i],
//                  'batch_number' =>  $batch,                        
//                  'expire_date' => $expire,
//                   'serial_no' =>  $serial,
//                       'item_id' => $typeArr[$i],
//                       'location' =>$data['location'],
//                         'added_by' => auth()->user()->added_by,
//                         'client_id' =>   $data['client_id'],
//                       'invoice_date' =>  $data['invoice_date'],
//                      'type' =>   'Sales',
//                      'invoice_id' =>$id);
                    
//                   InvoiceHistory::create($lists);   
   
//                  $inv=Items::where('id',$typeArr[$i])->first();
//                  $q=$inv->quantity - $qtyArr[$i];
//                  Items::where('id',$typeArr[$i])->update(['quantity' => $q]);

//                    $loc=Location::where('id',$data['location'])->first();
//                  $lq['quantity']=$loc->quantity - $qtyArr[$i];
//                 Location::where('id',$data['location'])->update($lq);

//                     if($categoryArr[$i] == 'Batch'){
//                $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
//                 $due=$bt->due_quantity - $qtyArr[$i];
//                  PurchaseHistory::where('id',$nameArr[$i])->update(['due_quantity' => $due]);
             
//                 }
//                  else{
//                  PurchaseSerialList::where('id',$nameArr[$i])->update(['status' => '1']);  
              
//                 }

                
//              }
//          }
     
//      }    


//      $inv = Invoice::find($id);
//      $supp=Client::find($inv->client_id);
//      $cr= AccountCodes::where('account_name','Sales')->first();
//      $journal = new JournalEntry();
//    $journal->account_id = $cr->id;
//    $date = explode('-',$inv->invoice_date);
//    $journal->date =   $inv->invoice_date ;
//    $journal->year = $date[0];
//    $journal->month = $date[1];
//   $journal->transaction_type = 'pos_pharmacy_invoice';
//    $journal->name = 'Invoice';
//    $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
//    $journal->income_id= $inv->id;
//   $journal->client_id= $inv->client_id;
//     $journal->currency_code =  $inv->exchange_code;
//    $journal->exchange_rate= $inv->exchange_rate;
//    $journal->added_by=auth()->user()->added_by;
//       $journal->notes= "Sales for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//    $journal->save();
 
//  if($inv->invoice_tax > 0){
//   $tax= AccountCodes::where('account_name','VAT OUT')->first();
//      $journal = new JournalEntry();
//    $journal->account_id = $tax->id;
//    $date = explode('-',$inv->invoice_date);
//    $journal->date =   $inv->invoice_date ;
//    $journal->year = $date[0];
//    $journal->month = $date[1];
//      $journal->transaction_type = 'pos_pharmacy_invoice';
//    $journal->name = 'Invoice';
//    $journal->credit= $inv->invoice_tax *  $inv->exchange_rate;
//    $journal->income_id= $inv->id;
//     $journal->client_id= $inv->client_id;
//     $journal->currency_code =  $inv->exchange_code;
//    $journal->exchange_rate= $inv->exchange_rate;
//     $journal->added_by=auth()->user()->added_by;
//       $journal->notes= "Sales Tax for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//    $journal->save();
//  }
 
// if($inv->shipping_cost > 0){
//   $ship= AccountCodes::where('account_name','Shipping Cost')->first();
//      $journal = new JournalEntry();
//    $journal->account_id = $ship->id;
//     $date = explode('-',$inv->invoice_date);
//    $journal->date =   $inv->invoice_date ;
//    $journal->year = $date[0];
//    $journal->month = $date[1];
//     $journal->transaction_type = 'pos_pharmacy_invoice';
//    $journal->name = 'Invoice';
//    $journal->credit= $inv->shipping_cost *  $inv->exchange_rate;
//    $journal->income_id= $inv->id;
// $journal->client_id= $inv->client_id;
//     $journal->currency_code =  $inv->exchange_code;
//    $journal->exchange_rate= $inv->exchange_rate;
//    $journal->added_by=auth()->user()->added_by;
//       $journal->notes= "Shipping Cost for  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//    $journal->save();
//  }
//    $codes=AccountCodes::where('account_group','Receivables')->first();
//    $journal = new JournalEntry();
//    $journal->account_id = $codes->id;
//    $date = explode('-',$inv->invoice_date);
//    $journal->date =   $inv->invoice_date ;
//    $journal->year = $date[0];
//    $journal->month = $date[1];
//    $journal->transaction_type = 'pos_pharmacy_invoice';
//    $journal->name = 'Invoice';
//    $journal->income_id= $inv->id;
//  $journal->client_id= $inv->client_id;
//    $journal->debit =$inv->due_amount *  $inv->exchange_rate;
//    $journal->currency_code =  $inv->exchange_code;
//    $journal->exchange_rate= $inv->exchange_rate;
//    $journal->added_by=auth()->user()->added_by;
//      $journal->notes= "Receivables for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//    $journal->save();

//   $stock= AccountCodes::where('account_name','Inventory')->first();
//      $journal = new JournalEntry();
//    $journal->account_id =  $stock->id;
//    $date = explode('-',$inv->invoice_date);
//    $journal->date =   $inv->invoice_date ;
//    $journal->year = $date[0];
//    $journal->month = $date[1];
//    $journal->transaction_type = 'pos_pharmacy_invoice';
//    $journal->name = 'Invoice';
//    $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
//    $journal->income_id= $inv->id;
//   $journal->client_id= $inv->client_id;
//     $journal->currency_code =  $inv->exchange_code;
//    $journal->exchange_rate= $inv->exchange_rate;
//    $journal->added_by=auth()->user()->added_by;
//       $journal->notes= "Reduce Stock  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//    $journal->save();

//      $cos= AccountCodes::where('account_name','Cost of Goods Sold')->first();
//      $journal = new JournalEntry();
//    $journal->account_id =  $cos->id;
//    $date = explode('-',$inv->invoice_date);
//    $journal->date =   $inv->invoice_date ;
//    $journal->year = $date[0];
//    $journal->month = $date[1];
//   $journal->transaction_type = 'pos_pharmacy_invoice';
//    $journal->name = 'Invoice';
//    $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
//    $journal->income_id= $inv->id;
//   $journal->client_id= $inv->client_id;
//     $journal->currency_code =  $inv->exchange_code;
//    $journal->exchange_rate= $inv->exchange_rate;
//    $journal->added_by=auth()->user()->added_by;
//       $journal->notes= "Cost of Goods Sold  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//    $journal->save();

// if(!empty($invoice)){
//              $activity =Activity::create(
//                  [ 
//                      'added_by'=>auth()->user()->id,
//                      'module_id'=>$id,
//                       'module'=>'Invoice',
//                      'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Approved",
//                  ]
//                  );                      
// }


// //--------------------------------------------------------------------------

//         //invoice payment
//  if($inv->sales_type == 'Cash Sales'){

//     $sales =Invoice::find($inv->id);
//   $method= Payment_methodes::where('name','Cash')->first();
//    $count=InvoicePayments::count();
//   $pro=$count+1;

//       $receipt['trans_id'] = "TBSPH-".$pro;
//       $receipt['invoice_id'] = $inv->id;
//       $receipt['account_id'] = $request->bank_id;
//     $receipt['amount'] = $inv->due_amount;
//       $receipt['date'] = $inv->invoice_date;
//        $receipt['payment_method'] = $method->id;
//       $receipt['added_by'] = auth()->user()->added_by;
      
//       //update due amount from invoice table
//       $b['due_amount'] =  0;
//      $b['status'] = 3;
    
//       $sales->update($b);
       
//       $payment = InvoicePayments::create($receipt);

//       $supp=Client::find($sales->client_id);

//      $cr= AccountCodes::where('id',$request->bank_id)->first();
// $journal = new JournalEntry();
// $journal->account_id = $request->bank_id;
// $date = explode('-',$request->invoice_date);
// $journal->date =   $request->invoice_date ;
// $journal->year = $date[0];
// $journal->month = $date[1];
// $journal->transaction_type = 'pos_pharmacy_invoice_payment';
// $journal->name = 'Invoice Payment';
// $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
// $journal->payment_id= $payment->id;
// $journal->client_id= $sales->client_id;
// $journal->currency_code =   $sales->currency_code;
// $journal->exchange_rate=  $sales->exchange_rate;
// $journal->added_by=auth()->user()->added_by;
//  $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
// $journal->save();


// $codes= AccountCodes::where('account_group','Receivables')->first();
// $journal = new JournalEntry();
// $journal->account_id = $codes->id;
// $date = explode('-',$request->invoice_date);
// $journal->date =   $request->invoice_date ;
// $journal->year = $date[0];
// $journal->month = $date[1];
// $journal->transaction_type = 'pos_pharmacy_invoice_payment';
// $journal->name = 'Invoice Payment';
// $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
// $journal->payment_id= $payment->id;
// $journal->client_id= $sales->client_id;
// $journal->currency_code =   $sales->currency_code;
// $journal->exchange_rate=  $sales->exchange_rate;
// $journal->added_by=auth()->user()->added_by;
// $journal->notes= "Clear Receivable for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
// $journal->save();

// $account= Accounts::where('account_id',$request->bank_id)->first();

// if(!empty($account)){
// $balance=$account->balance + $payment->amount ;
// $item_to['balance']=$balance;
// $account->update($item_to);
// }

// else{
// $cr= AccountCodes::where('id',$request->bank_id)->first();

// $new['account_id']= $request->bank_id;
// $new['account_name']= $cr->account_name;
// $new['balance']= $payment->amount;
// $new[' exchange_code']= $sales->currency_code;
// $new['added_by']=auth()->user()->added_by;
// $balance=$payment->amount;
// Accounts::create($new);
// }

// // save into tbl_transaction

//                    $transaction= Transaction::create([
//                       'module' => 'POS Pharmacy Invoice Payment',
//                        'module_id' => $payment->id,
//                      'account_id' => $request->bank_id,
//                       'code_id' => $codes->id,
//                       'name' => 'POS Invoice Payment with reference ' .$payment->trans_id,
//                        'transaction_prefix' => $payment->trans_id,
//                       'type' => 'Income',
//                       'amount' =>$payment->amount ,
//                       'credit' => $payment->amount,
//                        'total_balance' =>$balance,
//                       'date' => date('Y-m-d', strtotime($request->date)),
//                       'paid_by' => $sales->client_id,
//                       'payment_methods_id' =>$payment->payment_method,
//                          'status' => 'paid' ,
//                       'notes' => 'This deposit is from pos invoice  payment. The Reference is ' .$sales->reference_no .' by Client '. $supp->name  ,
//                       'added_by' =>auth()->user()->added_by,
//                   ]);


//       if(!empty($payment)){
//           $activity =Activity::create(
//               [ 
//                   'added_by'=>auth()->user()->id,
//                   'module_id'=>$payment->id,
//                    'module'=>'Invoice Payment',
//                   'activity'=>"Invoice with reference no  " .  $sales->reference_no. "  is Paid",
//               ]
//               );                      
// }



// }



//                         $sales['location_id'] = intval($sales->location);

//                         $loc2= Location::where('id', $sales->location)->value('name');


//                         $sales['location'] = $loc2;

//                         $sales['supplier'] = $sales->supplier->name;

//                         if($sales->status == 0){
//                             $sales['status'] = 'Not Approved';
//                         }
//                         elseif($sales->status == 1){
//                             $sales['status'] = 'Not Paid';
//                         }
//                         elseif($sales->status == 2){
//                             $sales['status'] = 'Partially Paid';
//                         }
//                         elseif($sales->status == 3){
//                             $sales['status'] = 'Fully Paid';
//                         }
//                         elseif($sales->status == 4){
//                             $sales['status'] = 'Cancelled';
//                         }
//                         elseif($sales->status == 5){
//                             $sales['status'] = 'Received';
//                         }

//                         elseif ($sales->status == 6) {
//                             $purchase['status'] = 'Scanned and Paid';
//                         }



//         if($sales)
//         {
            
        
//             $response=['success'=>true,'error'=>false,'message'=>'Payemnt Successfully', 'purchase' => $sales];
//             return response()->json($response,200);
//         }
//         else
//         {
            
//             $response=['success'=>false,'error'=>true,'message'=>'Failed to Pay Purchases'];
//             return response()->json($response,200);
//         }
//     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $invoices = Invoice::find($id);
        $invoice_items=InvoiceItems::where('invoice_id',$id)->where('due_quantity','>', '0')->get();
        $payments=InvoicePayments::where('invoice_id',$id)->get();
        
        return view('pharmacy.pos.sales.invoice_details',compact('invoices','invoice_items','payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $currency= Currency::all();
         $client=Client::where('user_id',auth()->user()->added_by)->get(); 
        $name =Items::where('user_id',auth()->user()->added_by)->get();        
      $s_name =PurchaseSerialList::where('status',0)->orwhere('status','2')->where('added_by',auth()->user()->added_by)->get();  
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
         //$bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get(); 
      $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get();  
     $location =  Location::where('added_by',auth()->user()->added_by)->get();;
        $region =Region::all();
         $edit="";
        $item_type="";

 
       return view('pharmacy.pos.sales.invoice',compact('name','client','currency','data','id','items','item_type','edit','s_name','bank_accounts','location','region'));
    }

    public function pay_sales(Request $request){

        $this->validate($request,[
            'amount'=>'required',
            'payment_date'=>'required',
            'payment_method'=>'required',
            'account_id'=>'required',
            'invoice_id'=>'required',

            
        ]);

                            // $receipt = $request->all();
                            $sales =Invoice::find($request->invoice_id);

                            if($sales){

                                $count=InvoicePayments::where('added_by', $sales->added_by)->count();
                                $pro=$count+1;
                        //-------------------------------------------------------------------------------
              
    
                        //insert to purchase history if category or batch
                        $items =  InvoiceItems::where('invoice_id', $sales->id)->get();
                        //    dd($items->item_id);
    
                        if (!empty($items)) {
                            
                            // ---------------------------------------------------------------------------------
                                
                                    
                            $receipt['trans_id'] = "TRANS_SP_-".$pro;
                            $receipt['added_by'] = $sales->added_by;

                            $receipt['amount'] = $request->amount;
                            $receipt['date'] = $request->payment_date;
                            $receipt['payment_method']= $request->payment_method;
                            $receipt['account_id'] = $request->account_id;
                            $receipt['invoice_id'] = $request->invoice_id;
                            $receipt['notes'] = $request->notes;

                            
                            //update due amount from invoice table
                            // $data['due_amount'] =  $sales->due_amount;
                            
                        $data['due_amount'] = $sales->due_amount - $request->amount;    

                        $data['paid_amount'] = $sales->paid_amount + $request->amount;

                            if($data['due_amount'] != 0){
                            $data['status'] = 2;
                            }else{
                                $data['status'] = 3;
                            }
                            $sales->update($data);
                            
                            $payment = InvoicePayments::create($receipt);

                            $supp=Client::find(intval($sales->client_id));

                        // $cr= AccountCodes::where('id','$request->account_id')->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $request->account_id;
                    $date = explode('-',$request->payment_date);
                    $journal->date =   $request->payment_date ;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                $journal->transaction_type = 'pos_retail_invoice_payment';
                    $journal->name = 'Invoice Payment';
                    $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
                    $journal->payment_id= $payment->id;
                    $journal->client_id= $sales->client_id;
                    $journal->currency_code =   $sales->currency_code;
                    $journal->exchange_rate=  $sales->exchange_rate;
                    $journal->added_by=$sales->added_by;
                    $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
                    $journal->save();


                    $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',$added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-',$request->payment_date);
                    $journal->date =   $request->payment_date ;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_retail_invoice_payment';
                    $journal->name = 'Invoice Payment';
                    $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
                    $journal->payment_id= $payment->id;
                $journal->client_id= $sales->client_id;
                    $journal->currency_code =   $sales->currency_code;
                    $journal->exchange_rate=  $sales->exchange_rate;
                    $journal->added_by=$sales->added_by;
                    $journal->notes= "Clear Receivable for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
                    $journal->save();
                    
                    //auth()->user()
            $account= Accounts::where('account_id',$request->account_id)->first();

            if(!empty($account)){
            $balance=$account->balance + $payment->amount ;
            $item_to['balance']=$balance;
            $account->update($item_to);
            }

            else{
            $cr= AccountCodes::where('id',$request->account_id)->first();

                $new['account_id']= $request->account_id;
                $new['account_name']= $cr->account_name;
                $new['balance']= $payment->amount;
                $new[' exchange_code']= $sales->currency_code;
                    $new['added_by']=$sales->added_by;
            $balance=$payment->amount;
                Accounts::create($new);
            }

// save into tbl_transaction

                     $transaction= Transaction::create([
                        'module' => 'POS Retail Invoice Payment',
                         'module_id' => $payment->id,
                       'account_id' => $request->account_id,
                        'code_id' => $codes->id,
                        'name' => 'POS Invoice Payment with reference ' .$payment->trans_id,
                         'transaction_prefix' => $payment->trans_id,
                        'type' => 'Income',
                        'amount' =>$payment->amount ,
                        'credit' => $payment->amount,
                         'total_balance' =>$balance,
                        'date' => date('Y-m-d', strtotime($request->payment_date)),
                        'paid_by' => $sales->client_id,
                        'payment_methods_id' =>$payment->payment_method,
                           'status' => 'paid' ,
                        'notes' => 'This deposit is from pos invoice  payment. The Reference is ' .$sales->reference_no .' by Client '. $supp->name  ,
                        'added_by' =>   $sales->added_by,
                    ]);
                    
                    
                    
        
                       

                    //  -----------------------------------------


                    if (!empty($sales->location)) {
                        $sales['location_id'] = intval($sales->location);
                        $location = Location::find($sales->location);
                        if(!empty($location)){
                            $loc2= Location::where('id', $sales->location)->value('name');
    
    
                            $sales['location'] = $loc2;
                        }
    
                        else{
                            $sales['location'] = null;
    
                        }
    
                        
                    }
                    else{
                        $sales['location_id'] = null;
    
                        // $loc2= Location::where('id', $row->location)->value('name');
    
    
                        $sales['location'] = null;
                    }
    
                    $sales['client_id'] =  intval($sales->client_id);
    
                    $client_id = Client::find(intval($sales->client_id));
                    if(!empty($client_id)){
    
                    $sales['client'] =  Client::find(intval($sales->client_id))->name;
    
                    $sales['client_tin'] =  Client::find(intval($sales->client_id))->TIN;
    
                    $sales['client_email'] =  Client::find(intval($sales->client_id))->email;
    
                    $sales['client_phone'] =  Client::find(intval($sales->client_id))->phone;
    
                    $sales['client_address'] =  Client::find(intval($sales->client_id))->address;
                    }
                    else{
    
                        $sales['client'] =  null;
    
                        $sales['client_tin'] =  null;
        
                        $sales['client_email'] =  null;
        
                        $sales['client_phone'] =  null;
        
                        $sales['client_address'] =  null;
                    }
    
                    // $region = Region::find($sales->region);
                    
                    if(!empty($sales->region)){
    
                        $sales['region']  = $sales->region;
    
                    }
                    else{
                        $sales['region']  = null;
    
                    }
    
    
                    // if(!empty($sales->attach_reference)){
    
                    // $sales['attach_reference'] = url('season_images/'.$sales->attach_reference);
    
                    // }
    
    
                    // else{
                    // $sales['attach_reference'] = null;
    
                    // }
    
                    $sales['paid_amount'] = doubleval($sales->paid_amount);
    
                   
    
                    // $loc= Location::where('id', $row->location)->value('name');
    
                   
    
    
                    if($sales->status == 0){
                        $sales['status'] = 'Not Approved';
                    }
                    elseif($sales->status == 1){
                        $sales['status'] = 'Not Paid';
                    }
                    elseif($sales->status == 2){
                        $sales['status'] = 'Partially Paid';
                    }
                    elseif($sales->status == 3){
                        $sales['status'] = 'Fully Paid';
                    }
                    elseif($sales->status == 4){
                        $sales['status'] = 'Cancelled';
                    }
                    elseif($sales->status == 5){
                        $sales['status'] = 'Received';
                    }
    
                    elseif($sales->status == 6){
                        $sales['status'] = 'Scanned and Paid';
                    }
                    elseif($sales->status == 7){
                        $sales['status'] = 'Paid';
                    }


                    // ----------------------------------------
        
                        $response=['success'=>true,'error'=>false,'message'=>'Payemnt Successfully', 'payment' => $sales];
                        return response()->json($response,200);
                        }

                         else{

                                $response=['success'=>false,'error'=>true,'message'=>'Failed to Sale Item cause no item found in inventory'];
                                return response()->json($response, 200);
                            }
                          
       

        }else{
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Sale Items'];
            return response()->json($response, 200);

        }

    }

//     /**
//      * Update the specified resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request, $id)
//     {
//         //

//         if($request->item_type == 'receive'){

// $request->validate([
//             'attach_reference' => 'mimes:pdf,xlx,csv|max:2048',
//         ]);

//    if($request->hasFile('attach_reference')){
//            $filenameWithExt=$request->file('attach_reference')->getClientOriginalName();
//             $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
//             $extension=$request->file('attach_reference')->getClientOriginalExtension();
//             $fileNameToStore=$filename.'_'.time().'.'.$extension;
//             $path=$request->file('attach_reference')->storeAs('batch/reference',$fileNameToStore);
// }
// else{
//    $fileNameToStore='';
// }

//             $invoice = Invoice::find($id);
//             $data['client_id']=$request->client_id;
//             $data['invoice_date']=$request->invoice_date;
//             $data['due_date']=$request->due_date;
//              $data['location']=$request->location;
//              $data['region']=$request->region;
//             $data['order_reference']=$request->order_reference;
//       $data['attach_reference']= $fileNameToStore;
//             $data['exchange_code']=$request->exchange_code;
//             $data['exchange_rate']=$request->exchange_rate;
//             $data['notes']=$request->notes;
//             $data['invoice_amount']='1';
//             $data['due_amount']='1';
//             $data['invoice_tax']='1';
//             $data['good_receive']='1';
//             $data['invoice_status'] = 1;
//               $data['status'] = 1;
//          $data['sales_type']=$request->sales_type;
//         $data['bank_id']=$request->bank_id;
//             $data['added_by']= auth()->user()->added_by;
    
//         if(!empty($invoice->attach_reference)){
//         if($request->hasFile('attach_reference')){
//             unlink('batch/reference/'.$invoice->attach_reference);  
           
//         }
//     }

//             $invoice->update($data);
            
//             $amountArr = str_replace(",","",$request->amount);
//             $totalArr =  str_replace(",","",$request->tax);
           
//             $nameArr =$request->item_name ;
//             $typeArr =$request->type ;
//         $categoryArr =$request->category ;
//             $qtyArr = $request->quantity  ;
//             //$batchArr = $request->batch_number;
//            // $expireArr = $request->expire_date;
//             $priceArr = $request->price;
//             $rateArr = $request->tax_rate ;
//             $unitArr = $request->unit  ;
//             $costArr = str_replace(",","",$request->total_cost)  ;
//             $taxArr =  str_replace(",","",$request->total_tax );
//         $shipArr =  str_replace(",","",$request->shipping_cost);
//             $remArr = $request->removed_id ;
//             $expArr = $request->saved_items_id ;
//             $savedArr =$request->item_name ;
            
//             $cost['invoice_amount'] = 0;
//             $cost['invoice_tax'] = 0;
//                $cost['shipping_cost']=0;

//             if (!empty($remArr)) {
//                 for($i = 0; $i < count($remArr); $i++){
//                    if(!empty($remArr[$i])){        
//                     InvoiceItems::where('id',$remArr[$i])->delete();        
//                        }
//                    }
//                }
    
//             if(!empty($nameArr)){
//                 for($i = 0; $i < count($nameArr); $i++){
//                     if(!empty($nameArr[$i])){
//                         $cost['invoice_amount'] +=$costArr[$i];
//                         $cost['invoice_tax'] +=$taxArr[$i];
//                           $cost['shipping_cost'] =$shipArr[0];

                             
//                     $d=Items::where('id',$typeArr[$i])->first();
//                      if($categoryArr[$i] == 'Batch'){
//                       $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
//                       $batch=$bt->batch_number;
//                      $expire=$bt->expire_date;
//                     $serial='';
                    
//                        }
//                         else{
//                        $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
//                       $batch='';
//                      $expire='';
//                        $serial= $st->serial_no;
//                        }

                        
//                         $items = array(
//                             'item_name' => $nameArr[$i],
//                             'quantity' =>   $qtyArr[$i],
//                             'due_quantity' =>   $qtyArr[$i],
//                             'batch_number' =>  $batch,                        
//                         'expire_date' => $expire,
//                          'serial_no' =>  $serial,
//                         'tax_rate' =>  $rateArr [$i],
//                          'unit' =>$d->unit,
//                                'price' =>  $priceArr[$i],
//                             'total_cost' =>  $costArr[$i],
//                             'total_tax' =>   $taxArr[$i],
//                              'items_id' => $savedArr[$i],
//                                'purchase_history'=>$nameArr[$i],
//                                'order_no' => $i,
//                                'added_by' => auth()->user()->added_by,
//                             'invoice_id' =>$id);
                           
//                             if(!empty($expArr[$i])){
//                                 InvoiceItems::where('id',$expArr[$i])->update($items);  
          
//           }
//           else{
//             InvoiceItems::create($items);   
//           }
                      
                  
         
  
//                     }
//                 }
//                 $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'] +$cost['shipping_cost'] ;
//                 Invoice::where('id',$id)->update($cost);
//             }    
    
            
    
//             if(!empty($nameArr)){
//                 for($i = 0; $i < count($nameArr); $i++){
//                     if(!empty($nameArr[$i])){

        
//                        if($categoryArr[$i] == 'Batch'){
//                       $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
//                       $batch=$bt->batch_number;
//                      $expire=$bt->expire_date;
//                     $serial='';
                    
//                        }
//                         else{
//                        $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
//                       $batch='';
//                      $expire='';
//                        $serial= $st->serial_no;
//                        }
                   
//                         $lists= array(
//                          'category' => $categoryArr[$i],
//                         'item_name' => $nameArr[$i],
//                             'quantity' =>   $qtyArr[$i],
//                         'batch_number' =>  $batch,                        
//                         'expire_date' => $expire,
//                          'serial_no' =>  $serial,
//                              'item_id' => $typeArr[$i],
//                              'location' =>$data['location'],
//                                'added_by' => auth()->user()->added_by,
//                                'client_id' =>   $data['client_id'],
//                              'invoice_date' =>  $data['invoice_date'],
//                             'type' =>   'Sales',
//                             'invoice_id' =>$id);
                           
//                          InvoiceHistory::create($lists);   
          
//                         $inv=Items::where('id',$typeArr[$i])->first();
//                         $q=$inv->quantity - $qtyArr[$i];
//                         Items::where('id',$typeArr[$i])->update(['quantity' => $q]);

//                           $loc=Location::where('id',$data['location'])->first();
//                         $lq['quantity']=$loc->quantity - $qtyArr[$i];
//                        Location::where('id',$data['location'])->update($lq);

//                            if($categoryArr[$i] == 'Batch'){
//                       $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
//                        $due=$bt->due_quantity - $qtyArr[$i];
//                         PurchaseHistory::where('id',$nameArr[$i])->update(['due_quantity' => $due]);
                    
//                        }
//                         else{
//                         PurchaseSerialList::where('id',$nameArr[$i])->update(['status' => '1']);  
                     
//                        }

                       
//                     }
//                 }
            
//             }    
    
    
//             $inv = Invoice::find($id);
//             $supp=Client::find($inv->client_id);
//             $cr= AccountCodes::where('account_name','Sales')->first();
//             $journal = new JournalEntry();
//           $journal->account_id = $cr->id;
//           $date = explode('-',$inv->invoice_date);
//           $journal->date =   $inv->invoice_date ;
//           $journal->year = $date[0];
//           $journal->month = $date[1];
//          $journal->transaction_type = 'pos_pharmacy_invoice';
//           $journal->name = 'Invoice';
//           $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
//           $journal->income_id= $inv->id;
//          $journal->client_id= $inv->client_id;
//            $journal->currency_code =  $inv->exchange_code;
//           $journal->exchange_rate= $inv->exchange_rate;
//           $journal->added_by=auth()->user()->added_by;
//              $journal->notes= "Sales for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//           $journal->save();
        
//         if($inv->invoice_tax > 0){
//          $tax= AccountCodes::where('account_name','VAT OUT')->first();
//             $journal = new JournalEntry();
//           $journal->account_id = $tax->id;
//           $date = explode('-',$inv->invoice_date);
//           $journal->date =   $inv->invoice_date ;
//           $journal->year = $date[0];
//           $journal->month = $date[1];
//             $journal->transaction_type = 'pos_pharmacy_invoice';
//           $journal->name = 'Invoice';
//           $journal->credit= $inv->invoice_tax *  $inv->exchange_rate;
//           $journal->income_id= $inv->id;
//            $journal->client_id= $inv->client_id;
//            $journal->currency_code =  $inv->exchange_code;
//           $journal->exchange_rate= $inv->exchange_rate;
//            $journal->added_by=auth()->user()->added_by;
//              $journal->notes= "Sales Tax for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//           $journal->save();
//         }
        
//  if($inv->shipping_cost > 0){
//          $ship= AccountCodes::where('account_name','Shipping Cost')->first();
//             $journal = new JournalEntry();
//           $journal->account_id = $ship->id;
//            $date = explode('-',$inv->invoice_date);
//           $journal->date =   $inv->invoice_date ;
//           $journal->year = $date[0];
//           $journal->month = $date[1];
//            $journal->transaction_type = 'pos_pharmacy_invoice';
//           $journal->name = 'Invoice';
//           $journal->credit= $inv->shipping_cost *  $inv->exchange_rate;
//           $journal->income_id= $inv->id;
//       $journal->client_id= $inv->client_id;
//            $journal->currency_code =  $inv->exchange_code;
//           $journal->exchange_rate= $inv->exchange_rate;
//           $journal->added_by=auth()->user()->added_by;
//              $journal->notes= "Shipping Cost for  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//           $journal->save();
//         }
//           $codes=AccountCodes::where('account_group','Receivables')->first();
//           $journal = new JournalEntry();
//           $journal->account_id = $codes->id;
//           $date = explode('-',$inv->invoice_date);
//           $journal->date =   $inv->invoice_date ;
//           $journal->year = $date[0];
//           $journal->month = $date[1];
//           $journal->transaction_type = 'pos_pharmacy_invoice';
//           $journal->name = 'Invoice';
//           $journal->income_id= $inv->id;
//         $journal->client_id= $inv->client_id;
//           $journal->debit =$inv->due_amount *  $inv->exchange_rate;
//           $journal->currency_code =  $inv->exchange_code;
//           $journal->exchange_rate= $inv->exchange_rate;
//           $journal->added_by=auth()->user()->added_by;
//             $journal->notes= "Receivables for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//           $journal->save();
    
//          $stock= AccountCodes::where('account_name','Inventory')->first();
//             $journal = new JournalEntry();
//           $journal->account_id =  $stock->id;
//           $date = explode('-',$inv->invoice_date);
//           $journal->date =   $inv->invoice_date ;
//           $journal->year = $date[0];
//           $journal->month = $date[1];
//           $journal->transaction_type = 'pos_pharmacy_invoice';
//           $journal->name = 'Invoice';
//           $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
//           $journal->income_id= $inv->id;
//          $journal->client_id= $inv->client_id;
//            $journal->currency_code =  $inv->exchange_code;
//           $journal->exchange_rate= $inv->exchange_rate;
//           $journal->added_by=auth()->user()->added_by;
//              $journal->notes= "Reduce Stock  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//           $journal->save();

//             $cos= AccountCodes::where('account_name','Cost of Goods Sold')->first();
//             $journal = new JournalEntry();
//           $journal->account_id =  $cos->id;
//           $date = explode('-',$inv->invoice_date);
//           $journal->date =   $inv->invoice_date ;
//           $journal->year = $date[0];
//           $journal->month = $date[1];
//          $journal->transaction_type = 'pos_pharmacy_invoice';
//           $journal->name = 'Invoice';
//           $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
//           $journal->income_id= $inv->id;
//          $journal->client_id= $inv->client_id;
//            $journal->currency_code =  $inv->exchange_code;
//           $journal->exchange_rate= $inv->exchange_rate;
//           $journal->added_by=auth()->user()->added_by;
//              $journal->notes= "Cost of Goods Sold  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//           $journal->save();

//  if(!empty($invoice)){
//                     $activity =Activity::create(
//                         [ 
//                             'added_by'=>auth()->user()->id,
//                             'module_id'=>$id,
//                              'module'=>'Invoice',
//                             'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Approved",
//                         ]
//                         );                      
//        }

// //invoice payment
//  if($inv->sales_type == 'Cash Sales'){

//               $sales =Invoice::find($inv->id);
//             $method= Payment_methodes::where('name','Cash')->first();
//              $count=InvoicePayments::count();
//             $pro=$count+1;

//                 $receipt['trans_id'] = "TBSPH-".$pro;
//                 $receipt['invoice_id'] = $inv->id;
//                 $receipt['account_id'] = $request->bank_id;
//               $receipt['amount'] = $inv->due_amount;
//                 $receipt['date'] = $inv->invoice_date;
//                  $receipt['payment_method'] = $method->id;
//                 $receipt['added_by'] = auth()->user()->added_by;
                
//                 //update due amount from invoice table
//                 $b['due_amount'] =  0;
//                $b['status'] = 3;
              
//                 $sales->update($b);
                 
//                 $payment = InvoicePayments::create($receipt);

//                 $supp=Client::find($sales->client_id);

//                $cr= AccountCodes::where('id',$request->bank_id)->first();
//           $journal = new JournalEntry();
//         $journal->account_id = $request->bank_id;
//         $date = explode('-',$request->invoice_date);
//         $journal->date =   $request->invoice_date ;
//         $journal->year = $date[0];
//         $journal->month = $date[1];
//        $journal->transaction_type = 'pos_pharmacy_invoice_payment';
//         $journal->name = 'Invoice Payment';
//         $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
//         $journal->payment_id= $payment->id;
//         $journal->client_id= $sales->client_id;
//          $journal->currency_code =   $sales->currency_code;
//         $journal->exchange_rate=  $sales->exchange_rate;
//           $journal->added_by=auth()->user()->added_by;
//            $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
//         $journal->save();


//         $codes= AccountCodes::where('account_group','Receivables')->first();
//         $journal = new JournalEntry();
//         $journal->account_id = $codes->id;
//           $date = explode('-',$request->invoice_date);
//         $journal->date =   $request->invoice_date ;
//         $journal->year = $date[0];
//         $journal->month = $date[1];
//           $journal->transaction_type = 'pos_pharmacy_invoice_payment';
//         $journal->name = 'Invoice Payment';
//         $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
//           $journal->payment_id= $payment->id;
//       $journal->client_id= $sales->client_id;
//          $journal->currency_code =   $sales->currency_code;
//         $journal->exchange_rate=  $sales->exchange_rate;
//         $journal->added_by=auth()->user()->added_by;
//          $journal->notes= "Clear Receivable for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
//         $journal->save();
        
// $account= Accounts::where('account_id',$request->bank_id)->first();

// if(!empty($account)){
// $balance=$account->balance + $payment->amount ;
// $item_to['balance']=$balance;
// $account->update($item_to);
// }

// else{
//   $cr= AccountCodes::where('id',$request->bank_id)->first();

//      $new['account_id']= $request->bank_id;
//        $new['account_name']= $cr->account_name;
//       $new['balance']= $payment->amount;
//        $new[' exchange_code']= $sales->currency_code;
//         $new['added_by']=auth()->user()->added_by;
// $balance=$payment->amount;
//      Accounts::create($new);
// }
        
//    // save into tbl_transaction

//                              $transaction= Transaction::create([
//                                 'module' => 'POS Pharmacy Invoice Payment',
//                                  'module_id' => $payment->id,
//                                'account_id' => $request->bank_id,
//                                 'code_id' => $codes->id,
//                                 'name' => 'POS Invoice Payment with reference ' .$payment->trans_id,
//                                  'transaction_prefix' => $payment->trans_id,
//                                 'type' => 'Income',
//                                 'amount' =>$payment->amount ,
//                                 'credit' => $payment->amount,
//                                  'total_balance' =>$balance,
//                                 'date' => date('Y-m-d', strtotime($request->date)),
//                                 'paid_by' => $sales->client_id,
//                                 'payment_methods_id' =>$payment->payment_method,
//                                    'status' => 'paid' ,
//                                 'notes' => 'This deposit is from pos invoice  payment. The Reference is ' .$sales->reference_no .' by Client '. $supp->name  ,
//                                 'added_by' =>auth()->user()->added_by,
//                             ]);


//                 if(!empty($payment)){
//                     $activity =Activity::create(
//                         [ 
//                             'added_by'=>auth()->user()->id,
//                             'module_id'=>$payment->id,
//                              'module'=>'Invoice Payment',
//                             'activity'=>"Invoice with reference no  " .  $sales->reference_no. "  is Paid",
//                         ]
//                         );                      
//        }



// }


//             return redirect(route('pharmacy_invoice.show',$id));
    

//         }

//         else{


// $request->validate([
//             'attach_reference' => 'mimes:pdf,xlx,csv|max:2048',
//         ]);

//    if($request->hasFile('attach_reference')){
//            $filenameWithExt=$request->file('attach_reference')->getClientOriginalName();
//             $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
//             $extension=$request->file('attach_reference')->getClientOriginalExtension();
//             $fileNameToStore=$filename.'_'.time().'.'.$extension;
//             $path=$request->file('attach_reference')->storeAs('batch/reference',$fileNameToStore);
// }
// else{
//    $fileNameToStore='';
// }

//         $invoice = Invoice::find($id);
//         $data['client_id']=$request->client_id;
//         $data['invoice_date']=$request->invoice_date;
//         $data['due_date']=$request->due_date;
//             $data['location']=$request->location;
//             $data['region']=$request->region;
//           $data['order_reference']=$request->order_reference;
//       $data['attach_reference']= $fileNameToStore;
//         $data['exchange_code']=$request->exchange_code;
//         $data['exchange_rate']=$request->exchange_rate;
//       $data['notes']=$request->notes;
//         $data['invoice_amount']='1';
//         $data['due_amount']='1';
//         $data['invoice_tax']='1';
//        $data['sales_type']=$request->sales_type;
//         $data['bank_id']=$request->bank_id;
//         $data['added_by']= auth()->user()->added_by;

//  if(!empty($invoice->attach_reference)){
//         if($request->hasFile('attach_reference')){
//             unlink('batch/reference/'.$invoice->attach_reference);  
           
//         }
//     }

//         $invoice->update($data);
        
//         $amountArr = str_replace(",","",$request->amount);
//         $totalArr =  str_replace(",","",$request->tax);

//         $nameArr =$request->item_name ;
//       $typeArr =$request->type ;
//         $categoryArr =$request->category ;
//         $qtyArr = $request->quantity  ;
//         //$batchArr = $request->batch_number;
//         //$expireArr = $request->expire_date;
//         $priceArr = $request->price;
//         $rateArr = $request->tax_rate ;
//         $unitArr = $request->unit  ;
//         $costArr = str_replace(",","",$request->total_cost)  ;
//         $taxArr =  str_replace(",","",$request->total_tax );
//        $shipArr =  str_replace(",","",$request->shipping_cost);
//         $remArr = $request->removed_id ;
//         $expArr = $request->saved_items_id ;
//         $savedArr =$request->item_name ;
        
//         $cost['invoice_amount'] = 0;
//         $cost['invoice_tax'] = 0;
//            $cost['shipping_cost']=0;

//         if (!empty($remArr)) {
//             for($i = 0; $i < count($remArr); $i++){
//                if(!empty($remArr[$i])){        
//                 InvoiceItems::where('id',$remArr[$i])->delete();        
//                    }
//                }
//            }

//         if(!empty($nameArr)){
//             for($i = 0; $i < count($nameArr); $i++){
//                 if(!empty($nameArr[$i])){
//                     $cost['invoice_amount'] +=$costArr[$i];
//                     $cost['invoice_tax'] +=$taxArr[$i];
//                       $cost['shipping_cost'] =$shipArr[0];

//                   $d=Items::where('id',$typeArr[$i])->first();
//                      if($categoryArr[$i] == 'Batch'){
//                       $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
//                       $batch=$bt->batch_number;
//                      $expire=$bt->expire_date;
//                     $serial='';
                    
//                        }
//                         else{
//                        $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
//                       $batch='';
//                      $expire='';
//                        $serial= $st->serial_no;
//                        }

//                     $items = array(
//                       'type' => $typeArr[$i],
//                       'category' => $categoryArr[$i],
//                         'item_name' => $nameArr[$i],
//                         'quantity' =>   $qtyArr[$i],
//                          'due_quantity' =>   $qtyArr[$i],
//                         'batch_number' =>  $batch,                        
//                         'expire_date' => $expire,
//                          'serial_no' =>  $serial,
//                         'tax_rate' =>  $rateArr [$i],
//                          'unit' =>$d->unit,
//                            'price' =>  $priceArr[$i],
//                         'total_cost' =>  $costArr[$i],
//                         'total_tax' =>   $taxArr[$i],
//                          'items_id' => $savedArr[$i],
//                           'purchase_history'=>$nameArr[$i],
//                            'order_no' => $i,
//                            'added_by' => auth()->user()->added_by,
//                         'invoice_id' =>$id);
                       
//                         if(!empty($expArr[$i])){
//                             InvoiceItems::where('id',$expArr[$i])->update($items);  
      
//       }
//       else{
//         InvoiceItems::create($items);   
//       }
                    
//                 }
//             }
//             $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'] +$cost['shipping_cost'] ;
//             Invoice::where('id',$id)->update($cost);
//         }    

//          if(!empty($invoice)){
//                     $activity =Activity::create(
//                         [ 
//                             'added_by'=>auth()->user()->id,
//                             'module_id'=>$id,
//                              'module'=>'Invoice',
//                             'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Updated",
//                         ]
//                         );                      
//        }

//         return redirect(route('pharmacy_invoice.show',$id));

//     }



//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy($id)
//     {
//         //
//         InvoiceItems::where('invoice_id', $id)->delete();
//         InvoicePayments::where('invoice_id', $id)->delete();
       
//         $invoices = Invoice::find($id);
//          if(!empty($invoices)){
//                     $activity =Activity::create(
//                         [ 
//                             'added_by'=>auth()->user()->id,
//                             'module_id'=>$id,
//                              'module'=>'Invoice',
//                             'activity'=>"Invoice with reference no  " .  $invoices->reference_no. "  is Deleted",
//                         ]
//                         );                      
//        }
//         $invoices->delete();
//         return redirect(route('pharmacy_invoice.index'))->with(['success'=>'Deleted Successfully']);
//     }
//   public function findBatch(Request $request)
//     {

//            $items= Items::where('id',$request->id)->first();
//             $location=$request->location;
//                if($items->category == 'Batch'){
//                 $date = today()->format('Y-m');          
//              $chk= PurchaseHistory::where('item_id',$request->id)->where('due_quantity','>','0')->where('location',$location)->where('added_by',auth()->user()->added_by)->get();

//             foreach($chk as $c){
//           if($c->expire_date != ''){
//             $price= PurchaseHistory::where('item_id',$request->id)->where('due_quantity','>','0')->where('location',$location)->where('added_by',auth()->user()->added_by)->where('expire_date', '>', $date)->get();
// }

// else{
// $price= PurchaseHistory::where('item_id',$request->id)->where('due_quantity','>','0')->where('location',$location)->where('added_by',auth()->user()->added_by)->get();

// }


// }

//                }

//                 else if($items->category == 'Serial'){
//             $price=PurchaseSerialList::where('brand_id',$request->id)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('status',0)->orwhere('status','2')->get();  
//                      }
//                 return response()->json($price);                      

//     }

    public function findPrice(Request $request)
    {
           
               $price= Items::where('id',$request->id)->get();
                return response()->json($price);                      

    }

   public function findQty(Request $request)
    {
    
 if ($request->item == 'Batch') {
$item_info= PurchaseHistory::where('id',$request->id)->first();
$price=$item_info->due_quantity ;
}
else{
$price='1' ;
 }
              

                return response()->json($price);                      
 
    }


   public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;

                    return view('pharmacy.pos.sales.add_delivery',compact('id','type'));
    
               
                 }

       

    public function approve($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 1;
        $invoice->update($data);

  if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Approved",
                        ]
                        );                      
       }
        return redirect(route('pharmacy_invoice.index'))->with(['success'=>'Approved Successfully']);
    }
    public function convert_to_invoice($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['invoice_status'] = 1;
        $invoice->update($data);
        return redirect(route('pharmacy_invoice.index'))->with(['success'=>'Converted  Successfully']);
    }

    public function cancel($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 4;
        $invoice->update($data);

        if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Cancelled",
                        ]
                        ); 
}
        return redirect(route('pharmacy_invoice.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $client=Client::all();
        $name = Items::where('user_id',auth()->user()->added_by)->get(); 
      $s_name =PurchaseSerialList::where('status',0)->orwhere('status','2')->where('added_by',auth()->user()->added_by)->get();  
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
      $location =  Location::where('added_by',auth()->user()->added_by)->get();;
        $region =Region::all();
        $item_type="receive";
         $edit="";
    //$bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get(); 
      $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get(); 
       return view('pharmacy.pos.sales.invoice',compact('name','client','currency','data','id','items','item_type','edit','s_name','bank_accounts','location','region'));
    }

  public function inventory_list()
    {
        //
        $tyre= InventoryList::all();
       return view('inventory.list',compact('tyre'));
    }
    public function make_payment($id)
    {
        //
        $invoice = Invoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get(); 
        return view('pharmacy.pos.sales.invoice_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
      public function invoice_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pharmacy.pos.sales.invoice_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('SALES INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('inv_pdfview');
     //return view('pharmacy.pos.sales.invoice_details_pdf',compact('invoices','invoice_items'));
        
    }

 public function note_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pharmacy.pos.sales.invoice_note_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('DELIVERY NOTE INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('note_pdfview');
    }

   public function save_delivery(Request $request)
    {
        //

$request->validate([
            'attach_delivery' => 'required|mimes:pdf,xlx,csv|max:2048',
        ]);

   if($request->hasFile('attach_delivery')){
           $filenameWithExt=$request->file('attach_delivery')->getClientOriginalName();
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension=$request->file('attach_delivery')->getClientOriginalExtension();
            $fileNameToStore=$filename.'_'.time().'.'.$extension;
            $path=$request->file('attach_delivery')->storeAs('batch/delivery/',$fileNameToStore);
}

   if($request->type == 'batch'){
       $invoice = Invoice::find($request->id);
      $data['attach_delivery']= $fileNameToStore;
            $invoice->update($data);
}


else{
    $invoice = InvoiceSerial::find($request->id);
      $data['attach_delivery']= $fileNameToStore;
            $invoice->update($data);
}

     return redirect(route('pharmacy_invoice.index'))->with(['success'=>'Attachment Uploaded Successfully']);
            
}

public function download_reference($id)
    {
       $invoice = Invoice::find($id);
        $filePath = public_path("/batch/reference/".  $invoice->attach_reference);
        $headers = ['Content-Type: application/pdf'];
        $fileName = time().'.pdf';

        return response()->download($filePath, $fileName, $headers);
    }

public function download_delivery($id)
    {
       $invoice = Invoice::find($id);
        $filePath = public_path("/batch/delivery/".  $invoice->attach_delivery);
        $headers = ['Content-Type: application/pdf'];
        $fileName = time().'.pdf';

        return response()->download($filePath, $fileName, $headers);
    }

public function debtors_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (Client::where('user_id',auth()->user()->added_by)->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        if($request->isMethod('post')){

         $data= Invoice::where('client_id', $request->account_id)->whereBetween('invoice_date',[$start_date,$end_date])->where('status','!=',0)->get();
        }else{
            $data=[];
        }

       

        return view('pharmacy.pos.sales.debtors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }
}
