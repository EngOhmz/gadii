<?php

namespace App\Http\Controllers\Retail\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Retail\InvoicePayments;
use App\Models\Retail\InvoiceHistory;
use App\Models\Retail\Invoice;
use App\Models\Retail\InvoiceItems;
use App\Models\Retail\PurchaseHistory;
use App\Models\Retail\PurchaseSerialList;
use App\Models\Retail\Items;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\JournalEntry;
use App\Models\Retail\Location;
use App\Models\Region;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\Retail\Activity;
use App\Models\Retail\Client;
use App\Models\Retail\InventoryList;
use App\Models\Retail\InvoiceSerialPayments;
use App\Models\Retail\InvoiceSerialHistory;
use App\Models\Retail\InvoiceSerial;
use App\Models\Retail\InvoiceSerialItems;
use App\Models\ServiceType;
use App\Models\User;
use PDF;


use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currency= Currency::all();
       $invoices=Invoice::where('invoice_status',1)->where('added_by',auth()->user()->added_by)->get();
        $client=Client::where('user_id',auth()->user()->added_by)->get(); 
        $name =Items::where('user_id',auth()->user()->added_by)->get(); 
      $s_name =PurchaseSerialList::where('status',0)->orwhere('status','2')->where('added_by',auth()->user()->added_by)->get();
       //$bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get(); 
      $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get(); 
     $location =  Location::where('added_by',auth()->user()->added_by)->get();;
        $region =Region::all();
         $edit="";
        $item_type="";
       return view('retail.pos.sales.invoice',compact('name','client','currency','invoices','item_type','edit','s_name','bank_accounts','location','region'));
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

// $request->validate([
//             'attach_reference' => 'mimes:pdf,xlx,csv|max:2048',
//         ]);

//   if($request->hasFile('attach_reference')){
//           $filenameWithExt=$request->file('attach_reference')->getClientOriginalName();
//             $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
//             $extension=$request->file('attach_reference')->getClientOriginalExtension();
//             $fileNameToStore=$filename.'_'.time().'.'.$extension;
//             $path=$request->file('attach_reference')->storeAs('batch/reference',$fileNameToStore);
// }
// else{
//   $fileNameToStore='';
// }




          $count=Invoice::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $data['reference_no']= "BSPH0".$pro;
        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
    //  $data['order_reference']=$request->order_reference;
    //   $data['attach_reference']= $fileNameToStore;
    //     $data['due_date']=$request->due_date;
    //   $data['location']=$request->location;
        $data['region']=$request->region;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
      $data['notes']=$request->notes;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        
        if($request->sales_type == "Cash Sale"){

            $data['status']=7;

          }
          else{
            $data['status']=1;

          }
          
        $data['good_receive']='1';
        $data['invoice_status']=1;
         $data['sales_type']=$request->sales_type;
        $data['bank_id']=$request->bank_id;
        $data['added_by']= auth()->user()->added_by;

        $invoice = Invoice::create($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
        $typeArr =$request->type ;
        $categoryArr =$request->category ;
        $qtyArr = $request->quantity  ;
        //$batchArr = $request->batch_number;
        //$expireArr = $request->expire_date;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
       $shipArr =  str_replace(",","",$request->shipping_cost);
        
        $savedArr =$request->item_name ;
        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
        $cost['shipping_cost']=0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['invoice_amount'] +=$costArr[$i];
                    $cost['invoice_tax'] +=$taxArr[$i];
                    $cost['shipping_cost'] =$shipArr[0];

                    $d=Items::where('id',$typeArr[$i])->first();
                    
                     
                      $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
                      
                            if (!empty($bt)) {
                                      $purchase_id =$bt->purchase_id;
          
                                      $data['location']= Purchase::find($purchase_id)->location;
          
                                      Invoice::where('id', $invoice->id)->update($data);
                                      $serial='';
          
                                  }
          
                                  else{
                                      $data['location']= null;
          
                                      Invoice::where('id', $invoice->id)->update($data);
                                      $serial='';
          
                                  }
                      
                     
                       
                       
                    $items = array(
                       'type' => $typeArr[$i],
                      'category' => $categoryArr[$i],
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                         'due_quantity' =>   $qtyArr[$i],
                        // 'batch_number' =>  $batch,                        
                        // 'expire_date' => $expire,
                        //  'serial_no' =>  $serial,
                        'tax_rate' =>  $rateArr [$i],
                         'unit' =>$d->unit,
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'purchase_history'=>$nameArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$invoice->id);
                       
                        InvoiceItems::create($items);  ;
                        
                        
                        
                        $inv=Items::where('id', $savedArr[$i])->first();
                        $q=$inv->quantity - $qtyArr[$i];
                           $itm_new = Items::where('id', $savedArr[$i])->update(['quantity' => $q]);
    
    
                }

            }
            //$cost['reference_no']= "SALES-".$invoice->id."-".$data['invoice_date'];
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'] +$cost['shipping_cost'] ;
            InvoiceItems::where('id',$invoice->id)->update($cost);
        }    

        Invoice::find($invoice->id)->update($cost);
        
        // ----------
        
        
            $inv = Invoice::find($invoice->id);
            $supp=Client::find($inv->client_id);
            $cr= AccountCodes::where('account_name','Sales')->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_retail_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Sales for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
        if($inv->invoice_tax > 0){
         $tax= AccountCodes::where('account_name','VAT OUT')->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
            $journal->transaction_type = 'pos_retail_invoice';
          $journal->name = 'Invoice';
          $journal->credit= $inv->invoice_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
           $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Sales Tax for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        }
        
 if($inv->shipping_cost > 0){
         $ship= AccountCodes::where('account_name','Shipping Cost')->first();
            $journal = new JournalEntry();
          $journal->account_id = $ship->id;
           $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
           $journal->transaction_type = 'pos_retail_invoice';
          $journal->name = 'Invoice';
          $journal->credit= $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
      $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Shipping Cost for  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        }
          $codes=AccountCodes::where('account_group','Receivables')->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_retail_invoice';
          $journal->name = 'Invoice';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->debit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
            $journal->notes= "Receivables for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
    
         $stock= AccountCodes::where('account_name','Inventory')->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_retail_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Reduce Stock  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Goods Sold')->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_retail_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Cost of Goods Sold  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

        
        
        // -----------

      if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$invoice->id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Created",
                        ]
                        );                      
       }
        
        return redirect(route('retail_invoice.index'));
        
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
        $invoices = Invoice::find($id);
        $invoice_items=InvoiceItems::where('invoice_id',$id)->where('due_quantity','>', '0')->get();
        $payments=InvoicePayments::where('invoice_id',$id)->get();
        
        return view('retail.pos.sales.invoice_details',compact('invoices','invoice_items','payments'));
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

 
       return view('retail.pos.sales.invoice',compact('name','client','currency','data','id','items','item_type','edit','s_name','bank_accounts','location','region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

//         if($request->item_type == 'receive'){

// $request->validate([
//             'attach_reference' => 'mimes:pdf,xlx,csv|max:2048',
//         ]);

//   if($request->hasFile('attach_reference')){
//           $filenameWithExt=$request->file('attach_reference')->getClientOriginalName();
//             $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
//             $extension=$request->file('attach_reference')->getClientOriginalExtension();
//             $fileNameToStore=$filename.'_'.time().'.'.$extension;
//             $path=$request->file('attach_reference')->storeAs('batch/reference',$fileNameToStore);
// }
// else{
//   $fileNameToStore='';
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
//           // $expireArr = $request->expire_date;
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
//               $cost['shipping_cost']=0;

//             if (!empty($remArr)) {
//                 for($i = 0; $i < count($remArr); $i++){
//                   if(!empty($remArr[$i])){        
//                     InvoiceItems::where('id',$remArr[$i])->delete();        
//                       }
//                   }
//               }
    
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
                    
//                       }
//                         else{
//                       $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
//                       $batch='';
//                      $expire='';
//                       $serial= $st->serial_no;
//                       }

                        
//                         $items = array(
//                             'item_name' => $nameArr[$i],
//                             'quantity' =>   $qtyArr[$i],
//                             'due_quantity' =>   $qtyArr[$i],
//                             'batch_number' =>  $batch,                        
//                         'expire_date' => $expire,
//                          'serial_no' =>  $serial,
//                         'tax_rate' =>  $rateArr [$i],
//                          'unit' =>$d->unit,
//                               'price' =>  $priceArr[$i],
//                             'total_cost' =>  $costArr[$i],
//                             'total_tax' =>   $taxArr[$i],
//                              'items_id' => $savedArr[$i],
//                               'purchase_history'=>$nameArr[$i],
//                               'order_no' => $i,
//                               'added_by' => auth()->user()->added_by,
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

        
//                       if($categoryArr[$i] == 'Batch'){
//                       $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
//                       $batch=$bt->batch_number;
//                      $expire=$bt->expire_date;
//                     $serial='';
                    
//                       }
//                         else{
//                       $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
//                       $batch='';
//                      $expire='';
//                       $serial= $st->serial_no;
//                       }
                   
//                         $lists= array(
//                          'category' => $categoryArr[$i],
//                         'item_name' => $nameArr[$i],
//                             'quantity' =>   $qtyArr[$i],
//                         'batch_number' =>  $batch,                        
//                         'expire_date' => $expire,
//                          'serial_no' =>  $serial,
//                              'item_id' => $typeArr[$i],
//                              'location' =>$data['location'],
//                               'added_by' => auth()->user()->added_by,
//                               'client_id' =>   $data['client_id'],
//                              'invoice_date' =>  $data['invoice_date'],
//                             'type' =>   'Sales',
//                             'invoice_id' =>$id);
                           
//                          InvoiceHistory::create($lists);   
          
//                         $inv=Items::where('id',$typeArr[$i])->first();
//                         $q=$inv->quantity - $qtyArr[$i];
//                         Items::where('id',$typeArr[$i])->update(['quantity' => $q]);

//                           $loc=Location::where('id',$data['location'])->first();
//                         $lq['quantity']=$loc->quantity - $qtyArr[$i];
//                       Location::where('id',$data['location'])->update($lq);

//                           if($categoryArr[$i] == 'Batch'){
//                       $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
//                       $due=$bt->due_quantity - $qtyArr[$i];
//                         PurchaseHistory::where('id',$nameArr[$i])->update(['due_quantity' => $due]);
                    
//                       }
//                         else{
//                         PurchaseSerialList::where('id',$nameArr[$i])->update(['status' => '1']);  
                     
//                       }

                       
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
//          $journal->transaction_type = 'pos_retail_invoice';
//           $journal->name = 'Invoice';
//           $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
//           $journal->income_id= $inv->id;
//          $journal->client_id= $inv->client_id;
//           $journal->currency_code =  $inv->exchange_code;
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
//             $journal->transaction_type = 'pos_retail_invoice';
//           $journal->name = 'Invoice';
//           $journal->credit= $inv->invoice_tax *  $inv->exchange_rate;
//           $journal->income_id= $inv->id;
//           $journal->client_id= $inv->client_id;
//           $journal->currency_code =  $inv->exchange_code;
//           $journal->exchange_rate= $inv->exchange_rate;
//           $journal->added_by=auth()->user()->added_by;
//              $journal->notes= "Sales Tax for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
//           $journal->save();
//         }
        
//  if($inv->shipping_cost > 0){
//          $ship= AccountCodes::where('account_name','Shipping Cost')->first();
//             $journal = new JournalEntry();
//           $journal->account_id = $ship->id;
//           $date = explode('-',$inv->invoice_date);
//           $journal->date =   $inv->invoice_date ;
//           $journal->year = $date[0];
//           $journal->month = $date[1];
//           $journal->transaction_type = 'pos_retail_invoice';
//           $journal->name = 'Invoice';
//           $journal->credit= $inv->shipping_cost *  $inv->exchange_rate;
//           $journal->income_id= $inv->id;
//       $journal->client_id= $inv->client_id;
//           $journal->currency_code =  $inv->exchange_code;
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
//           $journal->transaction_type = 'pos_retail_invoice';
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
//           $journal->transaction_type = 'pos_retail_invoice';
//           $journal->name = 'Invoice';
//           $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
//           $journal->income_id= $inv->id;
//          $journal->client_id= $inv->client_id;
//           $journal->currency_code =  $inv->exchange_code;
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
//          $journal->transaction_type = 'pos_retail_invoice';
//           $journal->name = 'Invoice';
//           $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
//           $journal->income_id= $inv->id;
//          $journal->client_id= $inv->client_id;
//           $journal->currency_code =  $inv->exchange_code;
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
//       }

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
//               $b['status'] = 3;
              
//                 $sales->update($b);
                 
//                 $payment = InvoicePayments::create($receipt);

//                 $supp=Client::find($sales->client_id);

//               $cr= AccountCodes::where('id',$request->bank_id)->first();
//           $journal = new JournalEntry();
//         $journal->account_id = $request->bank_id;
//         $date = explode('-',$request->invoice_date);
//         $journal->date =   $request->invoice_date ;
//         $journal->year = $date[0];
//         $journal->month = $date[1];
//       $journal->transaction_type = 'pos_retail_invoice_payment';
//         $journal->name = 'Invoice Payment';
//         $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
//         $journal->payment_id= $payment->id;
//         $journal->client_id= $sales->client_id;
//          $journal->currency_code =   $sales->currency_code;
//         $journal->exchange_rate=  $sales->exchange_rate;
//           $journal->added_by=auth()->user()->added_by;
//           $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
//         $journal->save();


//         $codes= AccountCodes::where('account_group','Receivables')->first();
//         $journal = new JournalEntry();
//         $journal->account_id = $codes->id;
//           $date = explode('-',$request->invoice_date);
//         $journal->date =   $request->invoice_date ;
//         $journal->year = $date[0];
//         $journal->month = $date[1];
//           $journal->transaction_type = 'pos_retail_invoice_payment';
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
//       $new['account_name']= $cr->account_name;
//       $new['balance']= $payment->amount;
//       $new[' exchange_code']= $sales->currency_code;
//         $new['added_by']=auth()->user()->added_by;
// $balance=$payment->amount;
//      Accounts::create($new);
// }
        
//   // save into tbl_transaction

//                              $transaction= Transaction::create([
//                                 'module' => 'POS Retail Invoice Payment',
//                                  'module_id' => $payment->id,
//                               'account_id' => $request->bank_id,
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
//                                   'status' => 'paid' ,
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
//       }



// }


//             return redirect(route('retail_invoice.show',$id));
    

//         }

        // else{


// $request->validate([
//             'attach_reference' => 'mimes:pdf,xlx,csv|max:2048',
//         ]);

//   if($request->hasFile('attach_reference')){
//           $filenameWithExt=$request->file('attach_reference')->getClientOriginalName();
//             $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
//             $extension=$request->file('attach_reference')->getClientOriginalExtension();
//             $fileNameToStore=$filename.'_'.time().'.'.$extension;
//             $path=$request->file('attach_reference')->storeAs('batch/reference',$fileNameToStore);
// }
// else{
//   $fileNameToStore='';
// }

        $invoice = Invoice::find($id);
        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
        // $data['due_date']=$request->due_date;
        //     $data['location']=$request->location;
            $data['region']=$request->region;
    //       $data['order_reference']=$request->order_reference;
    //   $data['attach_reference']= $fileNameToStore;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
      $data['notes']=$request->notes;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
       $data['sales_type']=$request->sales_type;
        $data['bank_id']=$request->bank_id;
        $data['added_by']= auth()->user()->added_by;

//  if(!empty($invoice->attach_reference)){
//         if($request->hasFile('attach_reference')){
//             unlink('batch/reference/'.$invoice->attach_reference);  
           
//         }
//     }

        $invoice->update($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
      $typeArr =$request->type ;
        $categoryArr =$request->category ;
        $qtyArr = $request->quantity  ;
        //$batchArr = $request->batch_number;
        //$expireArr = $request->expire_date;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
       $shipArr =  str_replace(",","",$request->shipping_cost);
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        $savedArr =$request->item_name ;
        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
           $cost['shipping_cost']=0;

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
               $inv_neww = InvoiceItems::find($remArr[$i]);
               
                
                    $inv=Items::where('id',$inv_neww->items_id)->first();
                    $q=$inv->quantity + $inv_neww->quantity;
                    Items::where('id',$inv_neww->items_id)->update(['quantity' => $q]);
                    
                    $dt_neww = $inv_neww->delete(); 
            
            
                   }
               }
           }

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['invoice_amount'] +=$costArr[$i];
                    $cost['invoice_tax'] +=$taxArr[$i];
                      $cost['shipping_cost'] =$shipArr[0];

                  $d=Items::where('id',$typeArr[$i])->first();
                    //  if($categoryArr[$i] == 'Batch'){
                    //   $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
                    //   $batch=$bt->batch_number;
                    //  $expire=$bt->expire_date;
                    // $serial='';
                    
                    //   }
                    //     else{
                    //   $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
                    //   $batch='';
                    //  $expire='';
                    //   $serial= $st->serial_no;
                    //   }

                    $items = array(
                      'type' => $typeArr[$i],
                      'category' => $categoryArr[$i],
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                         'due_quantity' =>   $qtyArr[$i],
                        'batch_number' =>  $batch,                        
                        'expire_date' => $expire,
                         'serial_no' =>  $serial,
                        'tax_rate' =>  $rateArr [$i],
                         'unit' =>$d->unit,
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                          'purchase_history'=>$nameArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$id);
                       
                        if(!empty($expArr[$i])){
                            InvoiceItems::where('id',$expArr[$i])->update($items);  
                            
                            $inv=Items::where('id',$savedArr[$i])->first();
                        $q=$inv->quantity - $qtyArr[$i];
                        Items::where('id',$savedArr[$i])->update(['quantity' => $q]);
      
      }
      else{
        InvoiceItems::create($items);  
        
        $inv=Items::where('id',$savedArr[$i])->first();
        $q=$inv->quantity - $qtyArr[$i];
        Items::where('id',$savedArr[$i])->update(['quantity' => $q]);
      }
                    
                }
            }
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'] +$cost['shipping_cost'] ;
            Invoice::where('id',$id)->update($cost);
        }    

         if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Updated",
                        ]
                        );                      
       }

        return redirect(route('retail_invoice.index'));

    // }



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
        InvoiceItems::where('invoice_id', $id)->delete();
        InvoicePayments::where('invoice_id', $id)->delete();
       
        $invoices = Invoice::find($id);
         if(!empty($invoices)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoices->reference_no. "  is Deleted",
                        ]
                        );                      
       }
        $invoices->delete();
        return redirect(route('retail_invoice.index'))->with(['success'=>'Deleted Successfully']);
    }
  public function findBatch(Request $request)
    {

           $items= Items::where('id',$request->id)->first();
            $location=$request->location;
               if($items->category == 'Batch'){
                $date = today()->format('Y-m');          
             $chk= PurchaseHistory::where('item_id',$request->id)->where('due_quantity','>','0')->where('location',$location)->where('added_by',auth()->user()->added_by)->get();

            foreach($chk as $c){
          if($c->expire_date != ''){
            $price= PurchaseHistory::where('item_id',$request->id)->where('due_quantity','>','0')->where('location',$location)->where('added_by',auth()->user()->added_by)->where('expire_date', '>', $date)->get();
}

else{
$price= PurchaseHistory::where('item_id',$request->id)->where('due_quantity','>','0')->where('location',$location)->where('added_by',auth()->user()->added_by)->get();

}


}

               }

                else if($items->category == 'Serial'){
            $price=PurchaseSerialList::where('brand_id',$request->id)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('status',0)->orwhere('status','2')->get();  
                     }
                return response()->json($price);                      

    }

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

                    return view('retail.pos.sales.add_delivery',compact('id','type'));
    
               
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
        return redirect(route('retail_invoice.index'))->with(['success'=>'Approved Successfully']);
    }
    public function convert_to_invoice($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['invoice_status'] = 1;
        $invoice->update($data);
        return redirect(route('retail_invoice.index'))->with(['success'=>'Converted  Successfully']);
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
        return redirect(route('retail_invoice.index'))->with(['success'=>'Cancelled Successfully']);
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
       return view('retail.pos.sales.invoice',compact('name','client','currency','data','id','items','item_type','edit','s_name','bank_accounts','location','region'));
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
        return view('retail.pos.sales.invoice_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
      public function invoice_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('retail.pos.sales.invoice_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('SALES INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('inv_pdfview');
     //return view('retail.pos.sales.invoice_details_pdf',compact('invoices','invoice_items'));
        
    }

 public function note_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('retail.pos.sales.invoice_note_pdf')->setPaper('a4', 'potrait');
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

     return redirect(route('retail_invoice.index'))->with(['success'=>'Attachment Uploaded Successfully']);
            
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

       

        return view('retail.pos.sales.debtors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }
}
