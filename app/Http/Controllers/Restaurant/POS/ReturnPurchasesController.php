<?php

namespace App\Http\Controllers\Restaurant\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\InventoryHistory;
use App\Models\Restaurant\POS\InvoicePayments;
use App\Models\Restaurant\POS\ReturnInvoicePayments;
use App\Models\Restaurant\POS\InvoiceHistory;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
use App\Models\Restaurant\POS\Activity;
use App\Models\Restaurant\POS\Client;
use App\Models\Restaurant\POS\EmptyHistory;
use App\Models\Restaurant\POS\Invoice;
use App\Models\Restaurant\POS\InvoiceItems;
use App\Models\Restaurant\POS\ReturnInvoice;
use App\Models\Restaurant\POS\ReturnInvoiceItems;
use App\Models\Restaurant\POS\Items;
use App\Models\Restaurant\POS\Purchase;
use App\Models\Restaurant\POS\PurchaseItems;
use App\Models\Restaurant\POS\PurchaseHistory;
use App\Models\Restaurant\POS\PurchasePayments;
use App\Models\Restaurant\POS\ReturnPurchases;
use App\Models\Restaurant\POS\ReturnPurchasesItems;
use App\Models\Restaurant\POS\ReturnPurchasesPayments;
use App\Models\Restaurant\POS\Supplier;
use PDF;


use Illuminate\Http\Request;

class ReturnPurchasesController extends Controller
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
        $invoices=ReturnPurchases::all()->where('added_by',auth()->user()->added_by);
        $client=Supplier::all()->where('user_id',auth()->user()->added_by);;
        $name =Items::where('added_by',auth()->user()->added_by)->get(); 
       
        $type="";
       return view('restaurant.pos.purchases.return',compact('name','client','currency','invoices','type'));
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
          $count=ReturnPurchases::count();
        $pro=$count+1;
        $invoice=Purchase::find($request->purchase_id);
        $data['reference_no']= "DN0".$pro;
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_id']=$request->purchase_id;
        $data['return_date']=$request->return_date;
        $data['due_date']=$request->due_date;
     
        $data['exchange_code']=$invoice->exchange_code;
        $data['exchange_rate']=$invoice->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
        $data['status']='0';
        $data['good_receive']='0';
        $data['added_by']= auth()->user()->added_by;

        $return= ReturnPurchases::create($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->items_id ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;    
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
         $idArr =$request->id ;
        
        
         $cost['purchase_amount'] = 0;
         $cost['purchase_tax'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                  $cost['purchase_amount'] +=$costArr[$i];
                  $cost['purchase_tax'] +=$taxArr[$i];
                    if($taxArr[$i] == '0'){
                      $rateArr[$i]=0;
                      }else{
                   $rateArr[$i]=0.18;
                      }

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' =>$nameArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                         'return_id' =>$return->id,
                        'return_item'=>$idArr[$i],
                        'purchase_id' =>$request->purchase_id);
                       
                         ReturnPurchasesItems::create($items);  ;
    
    
                }
            }
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
            ReturnPurchasesItems::where('return_id',$return->id)->update($cost);
        }    

        ReturnPurchases::find($return->id)->update($cost);

     if(!empty($return)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
   'user_id'=>auth()->user()->id,
                            'module_id'=>$return->id,
                             'module'=>'Debit Note',
                            'activity'=>"Debit Note created for Invoice with reference no  " .  $invoice->reference_no ,
                        ]
                        );                      
       }
        
        return redirect(route('restaurant_debit_note.show',$return->id));
        
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
        $invoices = ReturnPurchases::find($id);
        $invoice_items=ReturnPurchasesItems::where('return_id',$id)->get();
        $payments=ReturnPurchasesPayments::where('return_id',$id)->get();
        
        return view('restaurant.pos.purchases.return_details',compact('invoices','invoice_items','payments'));
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
        $client=Supplier::all()->where('user_id',auth()->user()->added_by);;
        $name =Items::where('added_by',auth()->user()->added_by)->get(); 
       
        $data=ReturnPurchases::find($id);
        $items=ReturnPurchasesItems::where('return_id',$id)->get();
         $invoice=Purchase::where('supplier_id', $data->supplier_id)->where('order_status', 1)->where('status',1)->get();      
        $type="";
       return view('restaurant.pos.purchases.edit_return',compact('name','client','currency','data','id','items','type','invoice'));
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

        if($request->type == 'receive'){
            $return= ReturnPurchases::find($id);
            $invoice=Purchase::find($request->purchase_id);

        $data['supplier_id']=$request->supplier_id;
        $data['purchase_id']=$request->purchase_id;
        $data['return_date']=$request->return_date;
        $data['due_date']=$request->due_date;
     
        $data['exchange_code']=$invoice->exchange_code;
        $data['exchange_rate']=$invoice->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
        $data['status']='1';
        $data['good_receive']='1';
        $data['added_by']= auth()->user()->added_by;
    
            $return->update($data);
            
          $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->items_id ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;    
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
         $idArr =$request->id ;
        $remArr = $request->removed_id ;
        $expArr = $request->item_id ;
            
        $cost['purchase_amount'] = 0;
        $cost['purchase_tax'] = 0;
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    ReturnPurchasesItems::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                      $cost['purchase_amount'] +=$costArr[$i];
                      $cost['purchase_tax'] +=$taxArr[$i];
    
                        if($taxArr[$i] == '0'){
                      $rateArr[$i]=0;
                      }else{
                   $rateArr[$i]=0.18;
                      }

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr[$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' =>$nameArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                         'return_id' =>$id,
                        'return_item'=>$idArr[$i],
                        'purchase_id' =>$request->purchase_id);
                           
                            if(!empty($expArr[$i])){
                                ReturnPurchasesItems::where('id',$expArr[$i])->update($items);  
          
          }
          else{
           ReturnPurchasesItems::create($items);   
          }
                      
                 
         
  
                    }
                }

                 $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
               ReturnPurchasesItems::where('return_id',$id)->update($cost);
            }    
    
              ReturnPurchases::find($id)->update($cost);

                     /*
               $rn= ReturnPurchases::find($id);
                        $crn= Purchase::where('id',$request->purchase_id)->first();
                        $nxt['purchase_amount']=$crn->purchase_amount - $rn->purchase_amount ;
                        $nxt['purchase_tax']=$crn->purchase_tax - $rn->purchase_tax ;
                        $nxt['due_amount']=$crn->due_amount -   $rn->due_amount ;
                         Purchase::where('id',$request->purchase_id)->update($nxt);
             */

    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                      $saved=Items::find($nameArr[$i]);

                        $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'item_id' => $nameArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'supplier_id' =>   $data['supplier_id'],
                               'location' =>    $invoice->location,
                             'return_date' =>  $data['return_date'],
                               'return_id' =>  $id,
                            'type' =>   'Debit Note',
                            'purchase_id' =>$request->purchase_id);
                           
                        PurchaseHistory::create($lists);   
          
                        $inv_qty=Items::where('id',$nameArr[$i])->first();
                        $q=$inv_qty->quantity - $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);

                    /*
                         $due_qty= PurchaseItems::where('id',$idArr[$i])->first();
                         $prev['due_quantity']=$due_qty->due_quantity - $qtyArr[$i];
                         $prev['total_tax']=$due_qty->total_tax - $taxArr[$i];
                        $prev['total_cost']=$due_qty->total_cost - $costArr[$i];
                        PurchaseItems::where('id',$idArr[$i])->update($prev);

                        $pur_qty= Purchase::where('id',$request->purchase_id)->first();
                        $dq=$pur_qty->due_quantity + $qtyArr[$i];
                       Purchase::where('id',$request->purchase_id)->update(['due_quantity' => $dq]);

                        */

                         $loc=Location::where('id', $invoice->location)->first();
                         $lq['bar_crate']=$loc->bar_crate - $qtyArr[$i];
                         $lq['bar_bottle']=$loc->bar_bottle - ($qtyArr[$i] * $saved->bottle);
                         Location::where('id',$invoice->location)->update($lq);
                 
                    }
                }
            
            }    
    

            if(!empty($nameArr)){
              for($i = 0; $i < count($nameArr); $i++){
                  $saved=Items::find($nameArr[$i]);
                  if($saved->empty == '1'){
  
                      $pur_items= array(
                          'item_id' => $nameArr[$i],
                          'purpose' =>  'Debit Note',
                          'purchase_id' =>$request->purchase_id,
                          'return_id' =>$id,
                          'date' =>  $data['return_date'],
                          'has_empty' =>    $saved->empty,
                          'description' => $saved->description,
                          'empty_out_purchase' => $qtyArr[$i],
                          'return_purchase' => $qtyArr[$i],
                          'return_case' => $qtyArr[$i],
                          'return_bottle' => $qtyArr[$i] * $saved->bottle,                            
                          'added_by' => auth()->user()->added_by);
                          
                         
                       EmptyHistory::create($pur_items);   
        
                  }
              }
          
          }    

    
            $inv = ReturnPurchases::find($id);
             $sales=Purchase::find($inv->purchase_id);
            $supp=Supplier::find($inv->supplier_id);
            $cr= AccountCodes::where('account_name','Purchases')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'restaurant_pos_debit_note';
          $journal->name = 'Restaurant Debit Note';
          $journal->credit= $inv->purchase_amount *  $inv->exchange_rate;
          $journal->income_id= $id;
          $journal->supplier_id= $inv->supplier_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Return Restaurant Purchases for Purchase Order " .$sales->reference_no ." to Supplier ". $supp->name ;
          $journal->save();
        
        if($inv->purchase_tax > 0){
         $tax= AccountCodes::where('account_name','VAT IN')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'restaurant_pos_debit_note';
          $journal->name = 'Restaurant Debit Note';
          $journal->credit=$inv->purchase_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
          $journal->supplier_id= $inv->supplier_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
           $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Return Restaurant Purchases Tax for Purchase Order " .$sales->reference_no ." to Supplier ". $supp->name ;
          $journal->save();
        }
        
          $codes=AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
            $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'restaurant_pos_debit_note';
          $journal->name = 'Restaurant Debit Note';
          $journal->income_id= $inv->id;
          $journal->supplier_id= $inv->supplier_id;
          $journal->debit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Return Debit for Restaurant Purchase Order " .$sales->reference_no ." to Supplier ". $supp->name ;
          $journal->save();
    
         if(!empty($return)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
   'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Debit Note',
                            'activity'=>"Debit Note approved for Invoice with reference no  " .  $invoice->reference_no ,
                        ]
                        );                      
       }


            return redirect(route('restaurant_debit_note.show',$id));
    

        }

        else{
          $return= ReturnPurchases::find($id);
          $invoice=Purchase::find($request->purchase_id);

      $data['supplier_id']=$request->supplier_id;
      $data['purchase_id']=$request->purchase_id;
      $data['return_date']=$request->return_date;
      $data['due_date']=$request->due_date;
   
      $data['exchange_code']=$invoice->exchange_code;
      $data['exchange_rate']=$invoice->exchange_rate;
      $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
      $data['added_by']= auth()->user()->added_by;
  
          $return->update($data);
          
        $amountArr = str_replace(",","",$request->amount);
      $totalArr =  str_replace(",","",$request->tax);

      $nameArr =$request->items_id ;
      $qtyArr = $request->quantity  ;
      $priceArr = $request->price;    
      $unitArr = $request->unit  ;
      $costArr = str_replace(",","",$request->total_cost)  ;
      $taxArr =  str_replace(",","",$request->total_tax );
       $idArr =$request->id ;
      $remArr = $request->removed_id ;
      $expArr = $request->item_id ;
          
      $cost['purchase_amount'] = 0;
      $cost['purchase_tax'] = 0;
  
          if (!empty($remArr)) {
              for($i = 0; $i < count($remArr); $i++){
                 if(!empty($remArr[$i])){        
                  ReturnPurchasesItems::where('id',$remArr[$i])->delete();        
                     }
                 }
             }
  
          if(!empty($nameArr)){
              for($i = 0; $i < count($nameArr); $i++){
                  if(!empty($nameArr[$i])){
                    $cost['purchase_amount'] +=$costArr[$i];
                    $cost['purchase_tax'] +=$taxArr[$i];
  
                    if($taxArr[$i] == '0'){
                    $rateArr[$i]=0;
                    }else{
                 $rateArr[$i]=0.18;
                    }

                  $items = array(
                      'item_name' => $nameArr[$i],
                      'quantity' =>   $qtyArr[$i],
                      'tax_rate' =>  $rateArr [$i],
                       'unit' => $unitArr[$i],
                         'price' =>  $priceArr[$i],
                      'total_cost' =>  $costArr[$i],
                      'total_tax' =>   $taxArr[$i],
                       'items_id' =>$nameArr[$i],
                         'order_no' => $i,
                         'added_by' => auth()->user()->added_by,
                       'return_id' =>$id,
                      'return_item'=>$idArr[$i],
                      'purchase_id' =>$request->purchase_id);
                         
                          if(!empty($expArr[$i])){
                              ReturnPurchasesItems::where('id',$expArr[$i])->update($items);  
        
        }
        else{
         ReturnPurchasesItems::create($items);   
        }
                    
               
       

                  }
              }

               $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
             ReturnPurchasesItems::where('return_id',$id)->update($cost);
          }    
  
            ReturnPurchases::find($id)->update($cost);
        
 if(!empty($return)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
   'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Debit Note',
                            'activity'=>"Debit Note updated for Invoice with reference no  " .  $invoice->reference_no ,
                        ]
                        );                      
       }

        return redirect(route('restaurant_debit_note.show',$id));

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
        //
        ReturnPurchasesItems::where('return_id', $id)->delete();
        ReturnPurchasesPayments::where('return_id', $id)->delete();
       
        $invoices = ReturnPurchases::find($id);
       $inv=Purchase::find($invoices->purchase_id);
        if(!empty($invoices)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
   'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Debit Note',
                            'activity'=>"Debit Note deleted for Invoice with reference no  " .  $inv->reference_no ,
                        ]
                        );                      
       }
        $invoices->delete();

                return redirect(route('restaurant_debit_note.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= Purchase::where('supplier_id', $request->id)->where('order_status', 1)->where('status',1)->get();              
                return response()->json($price);                      

    }
public function showInvoice(Request $request)
    {
               $data['items']=  PurchaseItems::where('purchase_id', $request->id)->where('due_quantity','>', '0')->get();  
               $data['name'] = Items::where('added_by',auth()->user()->added_by)->get();  
                 $data['purchase_id']=  $request->id;           
                //return response()->json($items);                    
               return response()->json(['html' => view('restaurant.pos.purchases.view_items', $data)->render()]);  
    }

public function editshowInvoice(Request $request)
    {
               $data['items']=  PurchaseItems::where('purchase_id', $request->id)->where('due_quantity','>', '0')->get();  
               $data['name'] = Items::where('added_by',auth()->user()->added_by)->get();    
               $data['purchase_id']=  $request->id;         
                //return response()->json($items);                    
               return response()->json(['html' => view('restaurant.pos.purchases.edit_view_items', $data)->render()]);  
    }

 public function findQty(Request $request)
    {
 
$item=$request->item;

$item_info=PurchaseItems::where('id', $item)->first();  
$due=PurchaseHistory::where('purchase_id',$item_info->purchase_id)->where('item_id',$item_info->item_name)->where('type', 'Purchases')->where('added_by',auth()->user()->added_by)->sum('quantity');
$return=PurchaseHistory::where('purchase_id',$item_info->purchase_id)->where('item_id',$item_info->item_name)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');
 $qty=$due-$return;

 if (!empty( $item_info)) {

if($request->id >  $qty){
$price="You have exceeded your Purchases Quantity. Choose quantity between 1.00 and ".  number_format($qty,2) ;
}
else if($request->id <=  0){
$price="Choose quantity between 1.00 and ".  $item_info->due_quantity ;
}
else{
$price='' ;
 }

}

                return response()->json($price);                      
 
    }



    public function approve($id)
    {
        //
        $invoice = ReturnPurchases::find($id);
        $data['status'] = 1;
        $invoice->update($data);
   $inv=Purchase::find($invoice->purchase_id);
     if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
   'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Debit Note',
                            'activity'=>"Debit Note approved for Invoice with reference no  " .  $inv->reference_no ,
                        ]
                        );                      
       }
        
        return redirect(route('_debit_note.index'))->with(['success'=>'Approved Successfully']);
    }
  

    public function cancel($id)
    {
        //
        $invoice =   ReturnPurchases::find($id);
        $data['status'] = 4;
        $invoice->update($data);

 $inv=Purchase::find($invoice->purchase_id);
        if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
   'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Debit Note',
                            'activity'=>"Debit Note cancelled for Invoice with reference no  " .  $inv->reference_no ,
                        ]
                        );                      
       }
        ;
        return redirect(route('restaurant_debit_note.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //

     $currency= Currency::all();
        $client=Supplier::all()->where('user_id',auth()->user()->added_by);;
        $name =Items::where('added_by',auth()->user()->added_by)->get(); 
       
        $data= ReturnPurchases::find($id);
        $items=ReturnPurchasesItems::where('return_id',$id)->get();
         $invoice=Purchase::where('supplier_id', $data->supplier_id)->where('order_status', 1)->where('status',1)->get();    
             $type="receive";  

       return view('restaurant.pos.purchases.edit_return',compact('name','client','currency','data','id','items','invoice','type'));
    }


    public function make_payment($id)
    {
        //
        $invoice = ReturnPurchases::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('pos.purchases.return_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function debit_note_pdfview(Request $request)
    {
        //
        $invoices = ReturnPurchases::find($request->id);
        $invoice_items=ReturnPurchasesItems::where('return_id',$request->id)->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('restaurant.pos.purchases.return_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('ORDER DEBIT NOTE INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('restaurant_debit_note_pdfview');
    }
public function debtors_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (Client::all() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        if($request->isMethod('post')){
            $data=Invoice::where('client_id', $request->account_id)->whereBetween('invoice_date',[$start_date,$end_date])->where('status','!=',0)->get();
        }else{
            $data=[];
        }

       

        return view('restaurant.pos.sales.debtors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }
}
