<?php

namespace App\Http\Controllers\Tyre;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Tyre\Tyre;
use App\Models\Tyre\TyreHistory;
use App\Models\Tyre\MasterHistory;
use App\Models\Tyre\TyrePayment;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
use App\Models\Tyre\PurchaseTyre;
use App\Models\Tyre\PurchaseItemTyre;
use App\Models\Tyre\ReturnPurchases;
use App\Models\Tyre\ReturnPurchasesItems;
use App\Models\Tyre\TyreBrand;
use App\Models\Supplier;
use App\Models\User;
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
        $name =TyreBrand::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 
       $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
        $type="";
       return view('tyre.return',compact('name','client','currency','invoices','type','bank_accounts'));
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
          $count=ReturnPurchases::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $invoice=PurchaseTyre::find($request->purchase_id);
        $data['reference_no']= "DNT0".$pro;
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_id']=$request->purchase_id;
        $data['return_date']=$request->return_date;
        $data['due_date']=$request->due_date;
        $data['bank_id']=$request->bank_id;
        $data['notes']=$request->notes;
        $data['exchange_code']=$invoice->exchange_code;
        $data['exchange_rate']=$invoice->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
        $data['status']='0';
        $data['good_receive']='0';
         $data['user_id']= auth()->user()->id;
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

      
        
        return redirect(route('tyre_debit_note.show',$return->id));
        
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
        $payments='';
        
        return view('tyre.return_details',compact('invoices','invoice_items','payments'));
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
        $name =TyreBrand::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 
       $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
        $data=ReturnPurchases::find($id);
        $items=ReturnPurchasesItems::where('return_id',$id)->get();
         $invoice=PurchaseTyre::where('supplier_id', $data->supplier_id)->where('good_receive', 0)->whereIn('status', [1,2,3])->get();      
        $type="";
       return view('tyre.edit_return',compact('name','client','currency','data','id','items','type','invoice','bank_accounts'));
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
            $invoice=PurchaseTyre::find($request->purchase_id);

        $data['supplier_id']=$request->supplier_id;
        $data['purchase_id']=$request->purchase_id;
        $data['return_date']=$request->return_date;
        $data['due_date']=$request->due_date;
        $data['bank_id']=$request->bank_id;
          $data['notes']=$request->notes;
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
                 ReturnPurchasesItems::where('return_id',$id)->delete();
                 
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
                           
           ReturnPurchasesItems::create($items);   
         
                      
                 
         
  
                    }
                }

                 $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
               ReturnPurchasesItems::where('return_id',$id)->update($cost);
            }    
    
              ReturnPurchases::find($id)->update($cost);
            
    
                       $rn= ReturnPurchases::find($id);
                        $crn= PurchaseTyre::where('id',$request->purchase_id)->first();
                        $nxt['purchase_amount']=$crn->purchase_amount - $rn->purchase_amount ;
                        $nxt['purchase_tax']=$crn->purchase_tax - $rn->purchase_tax ;
                        
                        
                        if($crn->status == '1'){
                        $nxt['due_amount']=$crn->due_amount -   $rn->due_amount ;
                        }
                        
                        elseif($crn->status == '2'){
                            
                            if($crn->due_amount -   $rn->due_amount <= '0'){
                              $nxt['due_amount']=0 ; 
                              $nxt['status']=3 ; 
                              
          $os=Supplier::find($crn->supplier_id);
          $new=abs($crn->due_amount -   $rn->due_amount); 
          $journal = new JournalEntry();
          $journal->account_id = $request->bank_id;
          $date = explode('-',$request->return_date);
          $journal->date =   $request->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'tire_debit_note';
          $journal->name = 'Tire Debit Note';
          $journal->debit= $new *  $invoice->exchange_rate;
          $journal->income_id= $id;
          $journal->supplier_id= $invoice->supplier_id;
          $journal->currency_code =  $invoice->exchange_code;
          $journal->exchange_rate= $invoice->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Return Purchases for Tire Purchase Order " .$crn->reference_no ." to Supplier ". $os->name ;
          $journal->save();
      
          $cd=AccountCodes::where('account_name','Debit Note Control')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $cd->id;
          $date = explode('-',$request->return_date);
          $journal->date =   $request->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'tire_debit_note';
          $journal->name = 'Tire Debit Note';
          $journal->income_id= $id;
          $journal->supplier_id= $invoice->supplier_id;
          $journal->credit =$new *  $invoice->exchange_rate;
          $journal->currency_code =  $invoice->exchange_code;
          $journal->exchange_rate= $invoice->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Return Debit for Tire Purchase Order " .$crn->reference_no ." to Supplier ". $os->name ;
          $journal->save();
                              
                            }
                            
                            else{
                               $nxt['due_amount']=$crn->due_amount -   $rn->due_amount ; 
                              $nxt['status']=2 ; 
                            }
                        }
                        
                        
                         elseif($crn->status == '3'){
                             $nxt['due_amount']=0 ; 
                              $nxt['status']=3 ;
                              

          $os=Supplier::find($crn->supplier_id);
          $new=abs($crn->due_amount -   $rn->due_amount); 
          $journal = new JournalEntry();
          $journal->account_id = $request->bank_id;
          $date = explode('-',$request->return_date);
          $journal->date =   $request->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'tire_debit_note';
          $journal->name = 'Tire Debit Note';
          $journal->debit= $new *  $invoice->exchange_rate;
          $journal->income_id= $id;
          $journal->supplier_id= $invoice->supplier_id;
          $journal->currency_code =  $invoice->exchange_code;
          $journal->exchange_rate= $invoice->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Return Purchases for Purchase Order " .$crn->reference_no ." to Supplier ". $os->name ;
          $journal->save();
      
          $cd=AccountCodes::where('account_name','Debit Note Control')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $cd->id;
          $date = explode('-',$request->return_date);
          $journal->date =   $request->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'tire_debit_note';
          $journal->name = 'Tire Debit Note';
          $journal->income_id= $id;
          $journal->supplier_id= $invoice->supplier_id;
          $journal->credit =$new *  $invoice->exchange_rate;
          $journal->currency_code =  $invoice->exchange_code;
          $journal->exchange_rate= $invoice->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Return Debit for Purchase Order " .$crn->reference_no ." to Supplier ". $os->name ;
          $journal->save();
    
                        }
                        
                        
                  //dd($nxt);
                         PurchaseTyre::where('id',$request->purchase_id)->update($nxt);

  

            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                      $saved=TyreBrand::find($nameArr[$i]);

                        $lists= array(
                            'quantity' =>   $qtyArr[$i],
                               'price' =>   $priceArr[$i],
                             'item_id' => $nameArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'supplier_id' =>   $data['supplier_id'],
                               'location' =>    $invoice->location,
                             'return_date' =>  $data['return_date'],
                            'purchase_date' =>  $data['return_date'],
                               'return_id' =>  $id,
                            'type' =>   'Debit Note',
                            'purchase_id' =>$request->purchase_id);
                           
                        TyreHistory::create($lists);   
                        
                        
                               $mlists = [
                        'out' => $qtyArr[$i],
                        'price' => $priceArr[$i],
                        'item_id' => $nameArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'supplier_id' =>   $data['supplier_id'],
                        'location' =>    $invoice->location,
                        'date' => $data['return_date'],
                        'return_id' =>  $id,
                        'type' =>   'Debit Note',
                         'purchase_id' =>$request->purchase_id,
                    ];

                    MasterHistory::create($mlists);
          
                        $inv_qty=TyreBrand::where('id',$nameArr[$i])->first();
                        $q=$inv_qty->quantity - $qtyArr[$i];
                        TyreBrand::where('id',$nameArr[$i])->update(['quantity' => $q]);

                        $loc=Location::where('id', $invoice->location)->first();
                         $lq['quantity']=$loc->quantity - $qtyArr[$i];
                               if($saved->bar == '1'){ 
                              $lq['crate']=$loc->crate - $qtyArr[$i];
                              $lq['bottle']=$loc->bottle - ($qtyArr[$i] * $saved->bottle);
                                }
                         Location::where('id',$invoice->location)->update($lq);


         

                       $due_qty= PurchaseItemTyre::where('id',$idArr[$i])->first();
                       $prev['return_quantity']=$due_qty->return_quantity + $qtyArr[$i];
                       $prev['due_quantity']=$due_qty->due_quantity - $qtyArr[$i];
                       $prev['total_tax']=$due_qty->total_tax - $taxArr[$i];
                       $prev['total_cost']=$due_qty->total_cost - $costArr[$i];
                       PurchaseItemTyre::where('id',$idArr[$i])->update($prev);

                       
                       
                     $chk=Tyre::where('purchase_id',$request->purchase_id)->where('brand_id',$nameArr[$i])->where('status','0')->take($qtyArr[$i])->update(['status'=> '1']) ; 
                 
                    }
                }
            
            }    
    

           

    
            $inv = ReturnPurchases::find($id);
             $sales=PurchaseTyre::find($inv->purchase_id);
            $supp=Supplier::find($inv->supplier_id);
            $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
        $journal->transaction_type = 'tire_debit_note';
          $journal->name = 'Tire Debit Note';
          $journal->credit= $inv->purchase_amount *  $inv->exchange_rate;
          $journal->income_id= $id;
          $journal->supplier_id= $inv->supplier_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Return Purchases for Tire Purchase Order " .$sales->reference_no ." to Supplier ". $supp->name ;
          $journal->save();
        
        if($inv->purchase_tax > 0){
         $tax= AccountCodes::where('account_name','VAT IN')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'tire_debit_note';
          $journal->name = 'Debit Note';
          $journal->credit=$inv->purchase_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
          $journal->supplier_id= $inv->supplier_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
           $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Return Purchases Tax for Tire Purchase Order " .$sales->reference_no ." to Supplier ". $supp->name ;
          $journal->save();
        }
        
          $codes=AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
            $date = explode('-',$inv->return_date);
          $journal->date =   $inv->return_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'tire_debit_note';
          $journal->name = 'Tire Debit Note';
          $journal->income_id= $inv->id;
          $journal->supplier_id= $inv->supplier_id;
          $journal->debit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Return Debit for Tire Purchase Order " .$sales->reference_no ." to Supplier ". $supp->name ;
          $journal->save();
    
         



            return redirect(route('tyre_debit_note.show',$id));
    

        }

        else{
          $return= ReturnPurchases::find($id);
          $invoice=PurchaseTyre::find($request->purchase_id);

      $data['supplier_id']=$request->supplier_id;
      $data['purchase_id']=$request->purchase_id;
      $data['return_date']=$request->return_date;
      $data['due_date']=$request->due_date;
        $data['bank_id']=$request->bank_id;
          $data['notes']=$request->notes;
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
               ReturnPurchasesItems::where('return_id',$id)->delete();
               
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
                         
                        
         ReturnPurchasesItems::create($items);   
       
                    
               
       

                  }
              }

               $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
             ReturnPurchasesItems::where('return_id',$id)->update($cost);
          }    
  
            ReturnPurchases::find($id)->update($cost);
        



        return redirect(route('tyre_debit_note.show',$id));

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

         
      

        $invoices->delete();

        return redirect(route('tyre_debit_note.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               //$price=  PurchaseTyre::where('supplier_id', $request->id)->where('good_receive', 0)->where('status',1)->get();
               $price=  PurchaseTyre::where('supplier_id', $request->id)->where('good_receive', 0)->whereIn('status', [1,2,3])->get();
                return response()->json($price);                      

    }
  
public function showInvoice(Request $request)
    {
               $data['items']=  PurchaseItemTyre::where('purchase_id', $request->id)->where('due_quantity','>', '0')->get();  
               $data['name'] = TyreBrand::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();    
                $data['purchase_id']=  $request->id;        
                //return response()->json($items);                    
               return response()->json(['html' => view('tyre.view_items', $data)->render()]);  
    }

public function editshowInvoice(Request $request)
    {
               $data['items']=  PurchaseItemTyre::where('purchase_id', $request->id)->where('due_quantity','>', '0')->get();  
               $data['name'] = TyreBrand::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();      
              $data['purchase_id']=  $request->id;       
                //return response()->json($items);                    
               return response()->json(['html' => view('tyre.edit_view_items', $data)->render()]);  
    }

 public function findQty(Request $request)
    {
 
$item=$request->item;


$item_info=PurchaseItemTyre::where('id', $item)->first();  
$due=TyreHistory::where('purchase_id',$item_info->purchase_id)->where('item_id',$item_info->item_name)->where('type', 'Purchases')->where('added_by',auth()->user()->added_by)->sum('quantity');
$return=TyreHistory::where('purchase_id',$item_info->purchase_id)->where('item_id',$item_info->item_name)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');
 $qty=$due-$return;

 if (!empty( $item_info)) {

if($request->id >  $qty){
$price="You have exceeded your Purchases Quantity. Choose quantity between 0.00 and ".  number_format($qty,2) ;
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
        $invoice = ReturnPurchases::find($id);
        $data['status'] = 1;
        $invoice->update($data);

        
        return redirect(route('tyre_debit_note.index'))->with(['success'=>'Approved Successfully']);
    }
  

    public function cancel($id)
    {
        //
        $invoice =   ReturnPurchases::find($id);
        $data['status'] = 4;
        $invoice->update($data);

     

        return redirect(route('tyre_debit_note.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //

     $currency= Currency::all();
        $client=Supplier::all()->where('user_id',auth()->user()->added_by);;
        $name =TyreBrand::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 
       $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
        $data= ReturnPurchases::find($id);
        $items=ReturnPurchasesItems::where('return_id',$id)->get();
         $invoice=PurchaseTyre::where('supplier_id', $data->supplier_id)->where('good_receive', 0)->whereIn('status', [1,2,3])->get();    
             $type="receive";  

       return view('tyre.edit_return',compact('name','client','currency','data','id','items','invoice','type','bank_accounts'));
    }


  
    
    public function debit_note_pdfview(Request $request)
    {
        //
        $invoices = ReturnPurchases::find($request->id);
        $invoice_items=ReturnPurchasesItems::where('return_id',$request->id)->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('tyre.return_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('TIRE DEBIT NOTE NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('debit_note_pdfview');
    }

}
