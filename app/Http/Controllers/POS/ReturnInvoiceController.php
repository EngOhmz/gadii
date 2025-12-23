<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\POS\Activity;
use App\Models\POS\InvoicePayments;
use App\Models\POS\ReturnInvoicePayments;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\MasterHistory;
use App\Models\POS\SerialList;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\Client;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\POS\ReturnInvoice;
use App\Models\POS\ReturnInvoiceItems;
use App\Models\POS\Items;
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
        $client=Client::all()->where('disabled','0')->where('owner_id',auth()->user()->added_by);;
        $name =Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->where('bar','0')->where('disabled','0')->get(); 
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
        $type="";
       return view('pos.sales.return',compact('name','client','currency','invoices','type','bank_accounts'));
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
          $count=ReturnInvoice::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $invoice=Invoice::find($request->invoice_id);
        $data['reference_no']= "CN0".$pro;
        $data['client_id']=$request->client_id;
        $data['invoice_id']=$request->invoice_id;
        $data['return_date']=$request->return_date;
        $data['due_date']=$request->due_date;
        $data['bank_id']=$request->bank_id;
          $data['notes']=$request->notes;
        $data['exchange_code']=$invoice->exchange_code;
        $data['exchange_rate']=$invoice->exchange_rate;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['status']='0';
        $data['good_receive']='0';
 $data['user_id']= auth()->user()->id;
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
                        'invoice_id' =>$request->invoice_id);
                       
                         ReturnInvoiceItems::create($items);  ;
    
    
                }
            }
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            ReturnInvoiceItems::where('return_id',$return->id)->update($cost);
        }    

        ReturnInvoice::find($return->id)->update($cost);

        if(!empty($return)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$return->id,
                             'module'=>'Credit Note',
                            'activity'=>"Credit Note created for Invoice with reference no  " .  $invoice->reference_no ,
                        ]
                        );                      
       }

        return redirect(route('credit_note.show',$return->id));
        
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
        
        return view('pos.sales.return_details',compact('invoices','invoice_items','payments'));
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
        $client=Client::all()->where('disabled','0')->where('owner_id',auth()->user()->added_by);;
        $name =Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->where('bar','0')->where('disabled','0')->get();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
        $data=ReturnInvoice::find($id);
        $items=ReturnInvoiceItems::where('return_id',$id)->get();
         $invoice=Invoice::where('client_id', $data->client_id)->whereIn('status', [1,2,3])->get();      
        $type="";
       return view('pos.sales.edit_return',compact('name','client','currency','data','id','items','type','invoice','bank_accounts'));
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
        $data['bank_id']=$request->bank_id;
          $data['notes']=$request->notes;
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
                 ReturnInvoiceItems::where('return_id',$id)->delete(); 
                 
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $cost['invoice_amount'] +=$costArr[$i];
                        $cost['invoice_tax'] +=$taxArr[$i];
    
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
                        'invoice_id' =>$request->invoice_id);
                           
                            
           ReturnInvoiceItems::create($items);   
                   
                
         
  
                    }
                }
                $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
               ReturnInvoiceItems::where('return_id',$id)->update($cost);
            }    
    
              ReturnInvoice::find($id)->update($cost);
            
            
            $rn= ReturnInvoice::find($id);
                          $crn= Invoice::where('id',$request->invoice_id)->first();
                         $nxt['invoice_amount']=$crn->invoice_amount - $rn->invoice_amount ;
                         $nxt['invoice_tax']=$crn->invoice_tax - $rn->invoice_tax ;
                         
                         if($crn->status == '1'){
                        $nxt['due_amount']=$crn->due_amount -   $rn->due_amount ;
                        }
                        
                        elseif($crn->status == '2'){
                            
                            if($crn->due_amount -   $rn->due_amount <= '0'){
                              $nxt['due_amount']=0 ; 
                              $nxt['status']=3 ; 
                            }
                        
                            
                            else{
                               $nxt['due_amount']=$crn->due_amount -   $rn->due_amount ; 
                              $nxt['status']=2 ; 
                            }
                        }
                        
                        
                         elseif($crn->status == '3'){
                             $nxt['due_amount']=0 ; 
                              $nxt['status']=3 ;
                         }
                         
                          
                         Invoice::where('id',$request->invoice_id)->update($nxt);
                         
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                        $lists= array(
                            'quantity' =>   $qtyArr[$i],
                              'price' =>   $priceArr[$i],
                             'item_id' => $nameArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'user_id' => auth()->user()->id,
                               'client_id' =>   $data['client_id'],
                               'location' =>   $invoice->location,
                             'return_date' =>  $data['return_date'],
                               'invoice_date' =>  $data['return_date'],
                               'return_id' =>  $id,
                            'type' =>   'Credit Note',
                            'invoice_id' =>$request->invoice_id);
                           
                         InvoiceHistory::create($lists);   
                         
                         
                         $mlists = [
                        'in' => $qtyArr[$i],
                        'price' => $priceArr[$i],
                        'item_id' => $nameArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'client_id' =>   $data['client_id'],
                        'location' =>   $invoice->location,
                        'date' => $data['return_date'],
                        'return_id' =>  $id,
                        'type' =>   'Credit Note',
                        'invoice_id' =>$request->invoice_id,
                    ];

                    MasterHistory::create($mlists);
          
                        $inv_qty=Items::where('id',$nameArr[$i])->first();
                        $q=$inv_qty->quantity + $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);

                           $loc=Location::where('id', $invoice->location)->first();
                        $lq['quantity']=$loc->quantity + $qtyArr[$i];
                         Location::where('id',$invoice->location)->update($lq);
                         
                         
                        
                       $due_qty= InvoiceItems::where('id',$idArr[$i])->first();
                       $prev['return_quantity']=$due_qty->return_quantity + $qtyArr[$i];
                       $prev['due_quantity']=$due_qty->due_quantity - $qtyArr[$i];
                       $prev['total_tax']=$due_qty->total_tax - $taxArr[$i];
                       $prev['total_cost']=$due_qty->total_cost - $costArr[$i];
                          InvoiceItems::where('id',$idArr[$i])->update($prev);
                          
 
                      //$chk=SerialList::where('invoice_id',$request->invoice_id)->where('brand_id',$nameArr[$i])->where('status','2')->take($qtyArr[$i])->update(['status'=> '0']) ;
                 
                    }
                }
            
            }    
    
    
    
            $total_cost=0;
              
                 $x_items= ReturnInvoiceItems::where('return_id',$id)->get()  ;
                 foreach($x_items as $x){
                   $a=Items::where('id',$x->item_name)->first(); 
                   if($a->type == '4'){
                    $total_cost=0;   
                   }
                   else{
                    $total_cost+=$a->cost_price * $x->quantity;
                   }
                     
                 }    
            $inv = ReturnInvoice::find($id);
             $sales=Invoice::find($inv->invoice_id);
            $supp=Client::find($inv->client_id);
            
            $cr= AccountCodes::where('account_name','Sales')->where('added_by',auth()->user()->added_by)->first();
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
         $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by',auth()->user()->added_by)->first();
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
        
          $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
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
    
          if($total_cost > 0){
         $stock= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
           $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_credit_note';
          $journal->name = 'Credit Note';
          $journal->debit =$total_cost ;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Return Stock  for Sales  Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
           $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_credit_note';
          $journal->name = 'Credit Note';
          $journal->credit = $total_cost ;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
        $journal->notes= "Return Cost of Goods Sold  for Sales  Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
          $journal->save();
          }
          
          
          if($sales->status == 2 || $sales->status == 3){
              
            $tt=InvoicePayments::where('invoice_id',$inv->invoice_id)->sum('amount');
              
          $journal = new JournalEntry();
        $journal->account_id = $inv->bank_id;
       $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_credit_note';
          $journal->name = 'Credit Note';
           $journal->reference = 'Credit Note Deposit';
          if($tt < $inv->due_amount){
        $journal->credit = $tt *  $inv->exchange_rate;
          }
          else{
        $journal->credit = $inv->due_amount *  $inv->exchange_rate;
          }
          
        $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Return Deposit for Sales  Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();


        $rec= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
         $journal = new JournalEntry();
        $journal->account_id = $rec->id;
       $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
       $journal->transaction_type = 'pos_credit_note';
          $journal->name = 'Credit Note';
          $journal->reference = 'Credit Note Deposit';
        if($tt < $inv->due_amount){
        $journal->debit = $tt *  $inv->exchange_rate;
          }
          else{
        $journal->debit = $inv->due_amount *  $inv->exchange_rate;
          }
        $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Return Clear Receivable for Sales  Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();
          }
          

if(!empty($return)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Credit Note',
                            'activity'=>"Credit Note approved for Invoice with reference no  " .  $invoice->reference_no ,
                        ]
                        );                      
       }

            return redirect(route('credit_note.show',$id));
    

        }

        else{
 $return= ReturnInvoice::find($id);
            $invoice=Invoice::find($request->invoice_id);

        $data['client_id']=$request->client_id;
        $data['invoice_id']=$request->invoice_id;
        $data['return_date']=$request->return_date;
        $data['due_date']=$request->due_date;
        $data['location']=$invoice->location;
        $data['bank_id']=$request->bank_id;
          $data['notes']=$request->notes;
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
                 ReturnInvoiceItems::where('return_id',$id)->delete(); 
                 
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $cost['invoice_amount'] +=$costArr[$i];
                        $cost['invoice_tax'] +=$taxArr[$i];
    
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
                        'invoice_id' =>$request->invoice_id);
                           
                         
           ReturnInvoiceItems::create($items);   
         
                      
                 
         
  
                    }
                }
                $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
               ReturnInvoiceItems::where('return_id',$id)->update($cost);
            }    
    
              ReturnInvoice::find($id)->update($cost);
        
 if(!empty($return)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Credit Note',
                            'activity'=>"Credit Note updated for Invoice with reference no  " .  $invoice->reference_no ,
                        ]
                        );                      
       }

        return redirect(route('credit_note.show',$id));

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
        //InvoicePayments::where('invoice_id', $id)->delete();
       
        $invoices = ReturnInvoice::find($id);
   $inv=Invoice::find($invoices->invoice_id);
        if(!empty($invoices)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Credit Note',
                            'activity'=>"Credit Note deleted for Invoice with reference no  " .  $inv->reference_no ,
                        ]
                        );                      
       }
        $invoices->delete();
        return redirect(route('credit_note.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price=  Invoice::where('client_id', $request->id)->whereIn('status', [1,2,3])->get();               
                return response()->json($price);                      

    }
  public function findPrice2(Request $request)
    {
               $price=  Invoice::where('client_id', $request->id)->where('project_id',$request->project)->where('status',1)->get();               
                return response()->json($price);                      

    }
public function showInvoice(Request $request)
    {
               $data['items']=   InvoiceItems::leftJoin('tbl_items', 'tbl_items.id','pos_invoice_items.item_name')
                          ->where('pos_invoice_items.invoice_id', $request->id)
                          ->where('pos_invoice_items.due_quantity','>', '0')
                           ->whereIn('tbl_items.type', [1,2])    
                           ->select('pos_invoice_items.*')
                              ->get()  ;  
               
         
               $data['name'] = Items::where('added_by',auth()->user()->added_by)->get(); 
                $data['invoice_id']=  $request->id; 
                //return response()->json($items);                    
               return response()->json(['html' => view('pos.sales.view_items', $data)->render()]);  
    }

public function editshowInvoice(Request $request)
    {
               $data['items']=  $data['items']=   InvoiceItems::leftJoin('tbl_items', 'tbl_items.id','pos_invoice_items.item_name')
                          ->where('pos_invoice_items.invoice_id', $request->id)
                          ->where('pos_invoice_items.due_quantity','>', '0')
                           ->whereIn('tbl_items.type', [1,2])    
                           ->select('pos_invoice_items.*')
                              ->get()  ; 
               $data['name'] = Items::where('added_by',auth()->user()->added_by)->get(); 
               $data['invoice_id']=  $request->id; 
                //return response()->json($items);                    
               return response()->json(['html' => view('pos.sales.edit_view_items', $data)->render()]);  
    }

 public function findQty(Request $request)
    {
 
$item=$request->item;

$item_info=InvoiceItems::where('id', $item)->first();  

$due=InvoiceHistory::where('invoice_id',$item_info->invoice_id)->where('item_id',$item_info->item_name)->where('type', 'Sales')->where('added_by',auth()->user()->added_by)->sum('quantity');
$return=InvoiceHistory::where('invoice_id',$item_info->invoice_id)->where('item_id',$item_info->item_name)->where('type', 'Credit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');
 $qty=$due-$return;
 if (!empty( $item_info)) {

if($request->id >  $qty){
$price="You have exceeded your Invoice Quantity. Choose quantity between 0.00 and ".  number_format($qty,2) ;
}
else if($request->id <=  0){
$price="Choose quantity between 0.00 and ".  number_format($qty,2) ;
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
         $inv=Invoice::find($invoice->invoice_id);
     if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Credit Note',
                            'activity'=>"Credit Note approved for Invoice with reference no  " .  $inv->reference_no ,
                        ]
                        );                      
       }
        return redirect(route('credit_note.index'))->with(['success'=>'Approved Successfully']);
    }
  

    public function cancel($id)
    {
        //
        $invoice =  ReturnInvoice::find($id);
        $data['status'] = 4;
        $invoice->update($data);
        $inv=Invoice::find($invoice->invoice_id);
    if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Credit Note',
                            'activity'=>"Credit Note cancelled for Invoice with reference no  " .  $inv->reference_no ,
                        ]
                        );                      
       }
        return redirect(route('credit_note.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //

     $currency= Currency::all();
     $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();    
        $name =Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->where('bar','0')->where('disabled','0')->get(); 
       
        $data=ReturnInvoice::find($id);
        $items=ReturnInvoiceItems::where('return_id',$id)->get();
         $invoice=Invoice::where('client_id', $data->client_id)->whereIn('status', [1,2,3])->get();    
             $type="receive";  
 $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
       return view('pos.sales.edit_return',compact('name','client','currency','data','id','items','invoice','type','bank_accounts'));
    }


    public function make_payment($id)
    {
        //
        $invoice = ReturnInvoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->get() ;
        return view('pos.sales.return_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function credit_note_pdfview(Request $request)
    {
        //
        $invoices = ReturnInvoice::find($request->id);
        $invoice_items=ReturnInvoiceItems::where('return_id',$request->id)->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pos.sales.return_details_pdf')->setPaper('a4', 'portrait');
        
        // Get dompdf instance and add page numbers
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        
        // Add page numbers - this will be executed for each page
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $font = $fontMetrics->get_font("helvetica", "normal");
            $size = 8;

            // Page number (right aligned at bottom)
            $pageText = "Page $pageNumber of $pageCount";
            $pageWidth = $fontMetrics->get_text_width($pageText, $font, $size);
            $xPage = $canvas->get_width() - $pageWidth - 20; // right margin
            $yPage = $canvas->get_height() - 20; // push up from bottom
            $canvas->text($xPage, $yPage, $pageText, $font, $size, [0, 0, 0]);
        });
        
         return $pdf->download('CREDIT NOTE INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('credit_note_pdfview');
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

       

        return view('pos.sales.debtors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }
}

