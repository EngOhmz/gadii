<?php

namespace App\Http\Controllers\Pharmacy\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Pharmacy\InvoicePayments;
use App\Models\Pharmacy\ReturnInvoicePayments;
use App\Models\Pharmacy\InvoiceHistory;
use App\Models\Pharmacy\PurchaseHistory;
use App\Models\Pharmacy\PurchaseSerialList;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
use App\Models\Pharmacy\Client;
use App\Models\Pharmacy\Invoice;
use App\Models\Pharmacy\InvoiceItems;
use App\Models\Pharmacy\ReturnInvoice;
use App\Models\Pharmacy\ReturnInvoiceItems;
use App\Models\Pharmacy\Items;
use App\Models\User;
use PDF;


use Illuminate\Http\Request;

class ReturnInvoiceController extends Controller
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
        $invoices=ReturnInvoice::all()->where('added_by',auth()->user()->added_by);
        $client=Client::all()->where('user_id',auth()->user()->added_by);;
       $name =Items::where('user_id',auth()->user()->added_by)->get(); 
       
        $type="";
       return view('pharmacy.pos.sales.return',compact('name','client','currency','invoices','type'));
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
          $count=ReturnInvoice::count();
        $pro=$count+1;
        $invoice=Invoice::find($request->invoice_id);
        $data['reference_no']= "PHCN0".$pro;
        $data['client_id']=$request->client_id;
        $data['invoice_id']=$request->invoice_id;
        $data['return_date']=$request->return_date;
        $data['due_date']=$request->due_date;
        $data['location']=$invoice->location;
        $data['exchange_code']=$invoice->exchange_code;
        $data['exchange_rate']=$invoice->exchange_rate;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['status']='0';
        $data['good_receive']='0';
        $data['added_by']= auth()->user()->added_by;

        $return= ReturnInvoice::create($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->items_id ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;    
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $idArr =$request->id ;
        
        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['invoice_amount'] +=$costArr[$i];
                    $cost['invoice_tax'] +=$taxArr[$i];
                    if($costArr[$i] == '0'){
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
                        'invoice_id' =>$request->invoice_id);
                       
                         ReturnInvoiceItems::create($items);  ;
    
    
                }
            }
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            ReturnInvoiceItems::where('return_id',$return->id)->update($cost);
        }    

        ReturnInvoice::find($return->id)->update($cost);

        
        return redirect(route('pharmacy_credit_note.show',$return->id));
        
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
        $invoices = ReturnInvoice::find($id);
        $invoice_items=ReturnInvoiceItems::where('return_id',$id)->get();
        $payments=ReturnInvoicePayments::where('return_id',$id)->get();
        
        return view('pharmacy.pos.sales.return_details',compact('invoices','invoice_items','payments'));
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
        $client=Client::all()->where('user_id',auth()->user()->added_by);;
        $name =Items::where('user_id',auth()->user()->added_by)->get();       
        $data=ReturnInvoice::find($id);
        $items=ReturnInvoiceItems::where('return_id',$id)->get();
         $invoice=Invoice::where('client_id', $data->client_id)->where('status',1)->get();    
             $type="";  
       return view('pharmacy.pos.sales.edit_return',compact('name','client','currency','data','id','items','type','invoice'));
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
           $return= ReturnInvoice::find($id);
            $invoice=Invoice::find($request->invoice_id);

        $data['client_id']=$request->client_id;
        $data['invoice_id']=$request->invoice_id;
        $data['return_date']=$request->return_date;
        $data['due_date']=$request->due_date;
        $data['location']=$invoice->location;
        $data['exchange_code']=$invoice->exchange_code;
        $data['exchange_rate']=$invoice->exchange_rate;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
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
            
            $cost['invoice_amount'] = 0;
            $cost['invoice_tax'] = 0;
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    ReturnInvoiceItems::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $cost['invoice_amount'] +=$costArr[$i];
                        $cost['invoice_tax'] +=$taxArr[$i];
    
                        if($costArr[$i] == '0'){
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
                        'invoice_id' =>$request->invoice_id);
                           
                            if(!empty($expArr[$i])){
                                ReturnInvoiceItems::where('id',$expArr[$i])->update($items);  
          
          }
          else{
           ReturnInvoiceItems::create($items);   
          }
                      
                  if(!empty($qtyArr[$i])){
   
            }
         
  
                    }
                }
                $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
               ReturnInvoiceItems::where('return_id',$id)->update($cost);
            }    
    
              ReturnInvoice::find($id)->update($cost);
            
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){

                         $inv_items= InvoiceItems::where('id',$idArr[$i])->first();

                       if($inv_items->category == 'Batch'){
                      $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
                      $batch=$bt->batch_number;
                     $expire=$bt->expire_date;
                    $serial='';
                    
                       }
                        else{
                       $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
                      $batch='';
                     $expire='';
                       $serial= $st->serial_no;
                       }
    
                        $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'item_name' => $nameArr[$i],
                            'item_id' => $inv_items->type,
                               'added_by' => auth()->user()->added_by,
                               'client_id' =>   $data['client_id'],
                             'return_date' =>  $data['return_date'],
                               'return_id' =>  $id,
                            'type' =>   'Credit Note',
                           'category' => $inv_items->category,
                            'batch_number' =>  $batch,                        
                        'expire_date' => $expire,
                         'serial_no' =>  $serial,
                            'invoice_id' =>$request->invoice_id);
                           
                         InvoiceHistory::create($lists);   
 
                      $due_qty= InvoiceItems::where('id',$idArr[$i])->first();
                        $prev['due_quantity']=$due_qty->quantity - $qtyArr[$i];
                        $prev['total_tax']=$due_qty->total_tax - $taxArr[$i];
                       $prev['total_cost']=$due_qty->total_tax - $costArr[$i];
                         InvoiceItems::where('id',$idArr[$i])->update($prev);

                         $crn= Invoice::where('id',$request->invoice_id)->first();
                        $nxt['invoice_amount ']=$crn->invoice_amount - $cost['invoice_amount'] ;
                        $nxt['invoice_tax']=$crn->invoice_tax - $cost['invoice_tax'] ;
                         $nxt['due_amount']=$crn->due_amount -   $cost['due_amount']  ;
                        Invoice::where('id',$request->invoice_id)->update($nxt);
          
                        $inv_qty=Items::where('id',$due_qty->type)->first();
                        $q=$inv_qty->quantity + $qtyArr[$i];
                        Items::where('id',$due_qty->type)->update(['quantity' => $q]);

                      if($due_qty->category == 'Batch'){
                      $bbt=  PurchaseHistory::where('id',$nameArr[$i])->first();
                       $due=$bbt->due_quantity + $qtyArr[$i];
                        PurchaseHistory::where('id',$nameArr[$i])->update(['due_quantity' => $due]);
                    
                       }
                        else{
                        PurchaseSerialList::where('id',$nameArr[$i])->update(['status' => '2']);  
                     
                       }

                 
                    }
                }
            
            }    
    
    
            $inv = ReturnInvoice::find($id);
             $sales=Invoice::find($inv->invoice_id);
            $supp=Client::find($inv->client_id);
            $cr= AccountCodes::where('account_name','Sales')->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_credit_note';
          $journal->name = 'Credit Note';
          $journal->debit= $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Return Sales for Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
          $journal->save();
        
        if($inv->invoice_tax > 0){
         $tax= AccountCodes::where('account_name','VAT OUT')->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_credit_note';
          $journal->name = 'Credit Note';
          $journal->debit= $inv->invoice_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
           $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Return Sales Tax for Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
          $journal->save();
        }
        
          $codes=AccountCodes::where('account_group','Receivables')->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
            $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_credit_note';
          $journal->name = 'Credit Note';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->credit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
            $journal->notes= "Return Receivables for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
          $journal->save();
    
         $stock= AccountCodes::where('account_name','Inventory')->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
           $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_credit_note';
          $journal->name = 'Credit Note';
          $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Return Stock  for Sales  Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Goods Sold')->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
           $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_credit_note';
          $journal->name = 'Credit Note';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Return Cost of Goods Sold  for Sales  Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
          $journal->save();

            return redirect(route('pharmacy_credit_note.show',$id));
    

        }

        else{
        $return= ReturnInvoice::find($id);
            $invoice=Invoice::find($request->invoice_id);

        $data['client_id']=$request->client_id;
        $data['invoice_id']=$request->invoice_id;
        $data['return_date']=$request->return_date;
        $data['due_date']=$request->due_date;
        $data['location']=$invoice->location;
        $data['exchange_code']=$invoice->exchange_code;
        $data['exchange_rate']=$invoice->exchange_rate;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
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
            
            $cost['invoice_amount'] = 0;
            $cost['invoice_tax'] = 0;
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    ReturnInvoiceItems::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $cost['invoice_amount'] +=$costArr[$i];
                        $cost['invoice_tax'] +=$taxArr[$i];
    
                        if($costArr[$i] == '0'){
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
                        'invoice_id' =>$request->invoice_id);
                           
                            if(!empty($expArr[$i])){
                                ReturnInvoiceItems::where('id',$expArr[$i])->update($items);  
          
          }
          else{
           ReturnInvoiceItems::create($items);   
          }
                      
               
         
  
                    }
                }
                $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
               ReturnInvoiceItems::where('return_id',$id)->update($cost);
            }    
    
              ReturnInvoice::find($id)->update($cost);
            
    


            return redirect(route('pharmacy_credit_note.show',$id));

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
       ReturnInvoiceItems::where('return_id', $id)->delete();
        ReturnInvoicePayments::where('return_id', $id)->delete();
       
        $invoices = ReturnInvoice::find($id);
        $invoices->delete();
     
        return redirect(route('pharmacy_credit_note.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price=  Invoice::where('client_id', $request->id)->where('status',1)->get();               
                return response()->json($price);	                  

    }
public function showInvoice(Request $request)
    {
               $data['items']=  InvoiceItems::where('invoice_id', $request->id)->where('due_quantity','>', '0')->get();  
               //$data['name'] = Items::where('user_id',auth()->user()->added_by)->get();           
                //return response()->json($items);	                  
               return response()->json(['html' => view('pharmacy.pos.sales.view_items', $data)->render()]);  
    }

public function editshowInvoice(Request $request)
    {
               $data['items']=  InvoiceItems::where('invoice_id', $request->id)->where('due_quantity','>', '0')->get();  
               //$data['name'] = Items::where('added_by',auth()->user()->added_by)->get();            
                //return response()->json($items);	                  
               return response()->json(['html' => view('pharmacy.pos.sales.edit_view_items', $data)->render()]);  
    }

 public function findQty(Request $request)
    {
 
$item=$request->item;


$item_info=InvoiceItems::where('id', $item)->first();  
 if (!empty( $item_info)) {

if($request->id >  $item_info->due_quantity){
$price="You have exceeded your Invoice Quantity. Choose quantity between 1.00 and ".  $item_info->due_quantity ;
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
        $invoice = ReturnInvoice::find($id);
        $data['status'] = 1;
        $invoice->update($data);
        return redirect(route('pharmacy_credit_note.index'))->with(['success'=>'Approved Successfully']);
    }
  

    public function cancel($id)
    {
        //
        $invoice =  ReturnInvoice::find($id);
        $data['status'] = 4;
        $invoice->update($data);
        return redirect(route('pharmacy_credit_note.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
       $currency= Currency::all();
        $client=Client::all()->where('user_id',auth()->user()->added_by);;
        $name =Items::where('user_id',auth()->user()->added_by)->get();       
        $data=ReturnInvoice::find($id);
        $items=ReturnInvoiceItems::where('return_id',$id)->get();
         $invoice=Invoice::where('client_id', $data->client_id)->where('status',1)->get();    
             $type="receive";  
       return view('pharmacy.pos.sales.edit_return',compact('name','client','currency','data','id','items','type','invoice'));
    }


    public function make_payment($id)
    {
        //
        $invoice = ReturnInvoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('pharmacy.pos.sales.return_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function credit_note_pdfview(Request $request)
    {
        //
        $invoices = ReturnInvoice::find($request->id);
        $invoice_items=ReturnInvoiceItems::where('return_id',$request->id)->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pharmacy.pos.sales.return_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('CREDIT NOTE INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('pharmacy.credit_note_pdfview');
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

       

        return view('pharmacy.pos.sales.debtors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }
}
