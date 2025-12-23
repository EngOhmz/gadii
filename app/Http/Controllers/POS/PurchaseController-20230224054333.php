<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\Activity;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\PurchasePayments;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
//use App\Models\Purchase_items;
use App\Models\PurchaseInventory;
use App\Models\PurchaseItemInventory;
use App\Models\Supplier;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\POS\Purchase;
use App\Models\POS\PurchaseItems;
use App\Models\POS\Items;
use App\Models\User;
use PDF;
use App\Models\MechanicalItem;
use App\Models\MechanicalRecommedation;

use Illuminate\Http\Request;

class PurchaseController extends Controller
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
        $purchases=Purchase::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled','0')->get();;
        $name =Items::whereIn('type', [1,4])->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $location = Location::where('type',3)->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $type="";
       return view('pos.purchases.index',compact('name','supplier','currency','purchases','location','type'));
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

         $count=Purchase::count();
        $pro=$count+1;
        $data['reference_no']= "P0".$pro;
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
        $data['status']='0';
        $data['good_receive']='0';
        $data['added_by']= auth()->user()->added_by;

        $purchase = Purchase::create($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );

        
        $savedArr =$request->item_name ;
        
        $cost['purchase_amount'] = 0;
        $cost['purchase_tax'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['purchase_amount'] +=$costArr[$i];
                    $cost['purchase_tax'] +=$taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                      'due_quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'purchase_id' =>$purchase->id);
                       
                        PurchaseItems::create($items);  ;
    
    
                }
            }
            //$cost['reference_no']= "PUR-".$purchase->id."-".$data['purchase_date'];
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
            PurchaseItems::where('id',$purchase->id)->update($cost);
        }    

        Purchase::find($purchase->id)->update($cost);;

         if(!empty($purchase)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$purchase->id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchase->reference_no. "  is Created",
                        ]
                        );                      
       }
        
        return redirect(route('purchase.show',$purchase->id));
        
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
        $purchases = Purchase::find($id);
        $purchase_items=PurchaseItems::where('purchase_id',$id)->where('due_quantity','>', '0')->get();
        $payments=PurchasePayments::where('purchase_id',$id)->get();
        
        return view('pos.purchases.purchase_details',compact('purchases','purchase_items','payments'));
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
         $supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled','0')->get();;
        $name =Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $location = Location::where('type',3)->where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $data=Purchase::find($id);
        $items=PurchaseItems::where('purchase_id',$id)->get();
        $type="";
       return view('pos.purchases.index',compact('name','supplier','currency','location','data','id','items','type'));
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
            $purchase = Purchase::find($id);
            $data['supplier_id']=$request->supplier_id;
            $data['purchase_date']=$request->purchase_date;
            $data['due_date']=$request->due_date;
            $data['location']=$request->location;
            $data['exchange_code']=$request->exchange_code;
            $data['exchange_rate']=$request->exchange_rate;
            //$data['reference_no']="PUR-".$id."-".$data['purchase_date'];
            $data['purchase_amount']='1';
            $data['due_amount']='1';
            $data['purchase_tax']='1';
            $data['good_receive']='1';
            $data['added_by']= auth()->user()->added_by;
    
            $purchase->update($data);
            
            $amountArr = str_replace(",","",$request->amount);
            $totalArr =  str_replace(",","",$request->tax);
    
            $nameArr =$request->item_name ;
            $qtyArr = $request->quantity  ;
            $priceArr = $request->price;
            $rateArr = $request->tax_rate ;
            $unitArr = $request->unit  ;
            $costArr = str_replace(",","",$request->total_cost)  ;
            $taxArr =  str_replace(",","",$request->total_tax );
            $remArr = $request->removed_id ;
            $expArr = $request->saved_items_id ;
            $savedArr =$request->item_name ;
            
            $cost['purchase_amount'] = 0;
            $cost['purchase_tax'] = 0;
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    PurchaseItems::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $cost['purchase_amount'] +=$costArr[$i];
                        $cost['purchase_tax'] +=$taxArr[$i];
    
                        $items = array(
                            'item_name' => $nameArr[$i],
                            'quantity' =>   $qtyArr[$i],
                            'due_quantity' =>   $qtyArr[$i],
                            'tax_rate' =>  $rateArr [$i],
                             'unit' => $unitArr[$i],
                               'price' =>  $priceArr[$i],
                            'total_cost' =>  $costArr[$i],
                            'total_tax' =>   $taxArr[$i],
                             'items_id' => $savedArr[$i],
                               'order_no' => $i,
                               'added_by' => auth()->user()->added_by,
                            'purchase_id' =>$id);
                           
                            if(!empty($expArr[$i])){
                                PurchaseItems::where('id',$expArr[$i])->update($items);  
          
          }
          else{
            PurchaseItems::create($items);   
          }
                      
                 // if(!empty($qtyArr[$i])){
           // for($x = 1; $x <= $qtyArr[$i]; $x++){    
               // $name=Inventory::where('id', $savedArr[$i])->first();
               // $dt=date('Y',strtotime($data['purchase_date']));
                    //$lists = array(
                        //'serial_no' => $name->name."_" .$id."_".$x."_" .$dt,                      
                         //'brand_id' => $savedArr[$i],
                          // 'added_by' => auth()->user()->added_by,
                          // 'purchase_id' =>   $id,
                        // 'purchase_date' =>  $data['purchase_date'],
                         //  'location' => $data['location'],
                          // 'status' => '0');
                       
     
                    //InventoryList::create($lists);   
      
                //}
            //}
         
  
                    }
                }
                $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
                Purchase::where('id',$id)->update($cost);
            }    
    
            
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                       $lists= array(
                            'quantity' =>   $qtyArr[$i],
                               'price' =>   $priceArr[$i],
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'supplier_id' => $data['supplier_id'],
                              'location' =>    $data['location'],
                             'purchase_date' =>  $data['purchase_date'],
                            'type' =>   'Purchases',
                            'purchase_id' =>$id);
                           
                         PurchaseHistory ::create($lists);   
          
                        $inv=Items::where('id',$nameArr[$i])->first();
                        $q=$inv->quantity + $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);
                        
                        $loc=Location::where('id',$purchase->location)->first();
                        // $lq['quantity']=$loc->quantity + $request->quantity;
                        $lq['quantity']=$loc->quantity + $qtyArr[$i];
                        $loc_qun =   Location::where('id',$purchase->location)->update($lq);
                    }
                }
            
            }    
    
    
            $inv = Purchase::find($id);
            $supp=Supplier::find($inv->supplier_id);
            $cr= AccountCodes::where('account_name','Purchases')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
      $journal->transaction_type = 'pos_purchase';
          $journal->name = 'Purchases';
          $journal->debit = $inv->purchase_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Purchase for Purchase Order " .$inv->reference_no ." by Supplier ". $supp->name ;
          $journal->save();
        
        if($inv->purchase_tax > 0){
         $tax= AccountCodes::where('account_name','VAT IN')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
           $journal->transaction_type = 'pos_purchase';
          $journal->name = 'Purchases';
          $journal->debit = $inv->purchase_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Purchase Tax for Purchase Order " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
        }
        
          $codes= AccountCodes::where('account_name','Payables')->where('added_by', auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_purchase';
          $journal->name = 'Purchases';
          $journal->income_id= $inv->id;
          $journal->credit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Credit for Purchase Order  " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
    
    
 if(!empty($purchase)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchase->reference_no. "  Goods Received",
                        ]
                        );                      
       }
            return redirect(route('purchase.show',$id));
    

        }

        else{
        $purchase = Purchase::find($id);
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
        $data['added_by']= auth()->user()->added_by;

        $purchase->update($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        $savedArr =$request->item_name ;
        
        $cost['purchase_amount'] = 0;
        $cost['purchase_tax'] = 0;

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                 PurchaseItems::where('id',$remArr[$i])->delete();        
                   }
               }
           }

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['purchase_amount'] +=$costArr[$i];
                    $cost['purchase_tax'] +=$taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                           'due_quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'purchase_id' =>$id);
                       
                        if(!empty($expArr[$i])){
                            PurchaseItems::where('id',$expArr[$i])->update($items);  
      
      }
      else{
        PurchaseItems::create($items);   
      }
                    
                }
            }
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
            Purchase::where('id',$id)->update($cost);
        }    

         if(!empty($purchase)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchase->reference_no. "  is Updated",
                        ]
                        );                      
       }

        return redirect(route('purchase.show',$id));

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
        /*
        PurchaseItems::where('purchase_id', $id)->delete();
       PurchasePayments::where('purchase_id', $id)->delete();
        InventoryHistory::where('purchase_id', $id)->delete();
      
*/



        $purchases = Purchase::find($id);
          if(!empty($purchases)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchases->reference_no. "  is Deleted",
                        ]
                        );                      
       }
        $purchases->update(['disabled'=> '1']);

                  return redirect(route('purchase.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= Items::where('id',$request->id)->get();
                return response()->json($price);                      

    }
   public function discountModal(Request $request)
    {
               
                 }

         

    public function approve($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['status'] = 1;
        $purchase->update($data);
     if(!empty($purchase)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchase->reference_no. "  is Approved",
                        ]
                        ); 
}
          
        return redirect(route('purchase.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['status'] = 4;
        $purchase->update($data);

  if(!empty($purchase)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchase->reference_no. "  is Cancelled",
                        ]
                        );                      
       }
       
        return redirect(route('purchase.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
         $supplier=Supplier::where('user_id',auth()->user()->added_by)->get();;
        $name =Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->get();;
        $location = Location::where('type',3)->where('added_by',auth()->user()->added_by)->get();;
        $data=Purchase::find($id);
        $items=PurchaseItems::where('purchase_id',$id)->get();
        $type="receive";
       return view('pos.purchases.index',compact('name','supplier','currency','location','data','id','items','type'));
    }

  public function inventory_list()
    {
        //
        $tyre= InventoryList ::all();
       return view('inventory.list',compact('tyre'));
    }
    public function make_payment($id)
    {
        //
        $invoice = Purchase::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
        return view('pos.purchases.purchase_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function inv_pdfview(Request $request)
    {
        //
        $purchases = Purchase::find($request->id);
        $purchase_items=PurchaseItems::where('purchase_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pos.purchases.purchase_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('PURCHASES REF NO # ' .  $purchases->reference_no . ".pdf");
        }
        return view('inv_pdfview');
    }
public function creditors_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (Supplier::where('user_id',auth()->user()->added_by)->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        if($request->isMethod('post')){
            $data= Purchase::where('supplier_id', $request->account_id)->whereBetween('purchase_date',[$start_date,$end_date])->where('status','!=',0)->get();
        }else{
            $data=[];
        }

       

        return view('pos.purchases.creditors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }

 public function summary(Request $request)
    {
        //

    $all_employee=User::where('added_by',auth()->user()->added_by)->get();

 $search_type = $request->search_type;
 $check_existing_payment='';
$start_date='';
$end_date='';
$by_month='';
$user_id='';
$flag = $request->flag;

 

if (!empty($flag)) {
            if ($search_type == 'employee') {
             $user_id = $request->user_id;
             $check_existing_payment =Activity::where('user_id', $user_id)->get();
            }
          
            else if ($search_type == 'period') {
              $start_date = $request->start_date;
              $end_date= $request->end_date;
             $check_existing_payment = Activity::all()->where('added_by',auth()->user()->added_by)->whereBetween('date',[$start_date,$end_date]);
            }
           elseif ($search_type == 'activities') {
             $check_existing_payment =Activity::where('added_by',auth()->user()->added_by)->get();
            }
}
else{
 $check_existing_payment='';
$start_month='';
$end_month='';
$search_type='';
$by_month='';
$user_id='';
        }

 

 return view('pos.purchases.summary',compact('all_employee','check_existing_payment','start_date','end_date','search_type','user_id','flag'));
    }
}
