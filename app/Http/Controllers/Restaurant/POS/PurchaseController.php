<?php

namespace App\Http\Controllers\Restaurant\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Location as InventoryLocation;
use App\Models\InventoryHistory;
use App\Models\Restaurant\POS\InvoiceHistory;
use App\Models\Restaurant\POS\SupplierOrder;
use App\Models\Restaurant\POS\PurchaseReceive;
use App\Models\Restaurant\POS\PurchaseHistory;
use App\Models\Restaurant\POS\PurchasePayments;
use App\Models\Restaurant\POS\Activity;
use App\Models\Payment_methodes;
//use App\Models\Purchase_items;
use App\Models\PurchaseInventory;
use App\Models\PurchaseItemInventory;
use App\Models\Supplier;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\Restaurant\POS\Purchase;
use App\Models\Restaurant\POS\PurchaseItems;
use App\Models\Restaurant\POS\Items;
use App\Models\User;
use PDF;
use App\Models\MechanicalItem;
use App\Models\MechanicalRecommedation;
use App\Models\Restaurant\POS\EmptyHistory;
use App\Models\Restaurant\POS\Supplier as POSSupplier;
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
        $purchases=Purchase::where('added_by',auth()->user()->added_by)->where('order_status',1)->get();
        $supplier=POSSupplier::where('user_id',auth()->user()->added_by)->get();;
        $name =Items::where('added_by',auth()->user()->added_by)->get();;
        $location = InventoryLocation::where('main','1')->where('added_by',auth()->user()->added_by)->get();;
        $type="";
       return view('restaurant.pos.purchases.index',compact('name','supplier','currency','purchases','location','type'));
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
        $data['supplier_reference_no']=$request->supplier_reference_no;
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
        $cost['total_quantity'] = 0;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['purchase_amount'] +=$costArr[$i];
                    $cost['purchase_tax'] +=$taxArr[$i];
                   $cost['total_quantity'] +=$qtyArr[$i];

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
        $cost['due_quantity'] =  $cost['total_quantity'];
          
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
        
        return redirect(route('restaurant_purchase.show',$purchase->id));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function show($id,Request $request)
    {
        //
        $purchases = Purchase::find($id);
        $purchase_items=PurchaseItems::where('purchase_id',$id)->where('due_quantity','>', '0')->get();
        $payments=PurchasePayments::where('purchase_id',$id)->get();
        $supplier=POSSupplier::where('user_id',auth()->user()->added_by)->get();;
        $name =Items::where('added_by',auth()->user()->added_by)->get();;
        $location = InventoryLocation::where('added_by',auth()->user()->added_by)->get();;
        $orders=SupplierOrder::where('purchase_id',$id)->get();
       $old=SupplierOrder::where('purchase_id',$id)->where('status','1')->first();

        switch ($request->type) {      
     case 'receive':
            return view('restaurant.pos.purchases.item_details',compact('purchases','purchase_items','payments','id','name'));
                    break;
      case 'order':
            return view('restaurant.pos.purchases.create_order',compact('purchases','purchase_items','payments','id','name','supplier','location'));
                    break;
           case 'supplier':
            return view('restaurant.pos.purchases.confirm_supplier',compact('purchases','purchase_items','payments','id','name','supplier','location','orders','old'));
                    break;
         default:
             if($purchases->order_status == '1'){
            return view('restaurant.pos.purchases.purchase_details',compact('purchases','purchase_items','payments'));
             }
            else{
            return view('restaurant.pos.purchases.order_details',compact('purchases','purchase_items','payments','orders'));
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
        //
        $currency= Currency::all();
         $supplier=POSSupplier::where('user_id',auth()->user()->added_by)->get();;
        $name =Items::where('added_by',auth()->user()->added_by)->get();;
       $location = InventoryLocation::where('added_by',auth()->user()->added_by)->where('main','1')->get();;
        $data=Purchase::find($id);
        $items=PurchaseItems::where('purchase_id',$id)->get();
        $type="";
       return view('restaurant.pos.purchases.purchase_requisition',compact('name','supplier','currency','location','data','id','items','type'));
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
            $data['supplier_reference_no']=$request->supplier_reference_no;
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
    
                        $saved=Items::find($savedArr[$i]);

                       $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'supplier_id' => $data['supplier_id'],
                              'location' =>    $data['location'],
                             'purchase_date' =>  $data['purchase_date'],
                            'type' =>   'Purchases',
                            'purchase_id' =>$id);
                           
                         PurchaseHistory::create($lists);   
          
                        $inv=Items::where('id',$nameArr[$i])->first();
                        $q=$inv->quantity + $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);

                        $loc=InventoryLocation::where('id',$data['location'])->first();
                        $lq['crate']=$loc->crate + $qtyArr[$i];
                        $lq['bottle']=$loc->bottle+ ($qtyArr[$i] * $saved->bottle);
                        InventoryLocation::where('id',$data['location'])->update($lq);

                    }
                }
            
            }    
    


                
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    $saved=Items::find($savedArr[$i]);
                    if($saved->empty == '1'){
    
                        $pur_items= array(
                            'item_id' => $savedArr[$i],
                            'purpose' =>  'Purchase Empty',
                            'purchase_id' =>$id,
                            'date' =>  $data['purchase_date'],
                            'has_empty' =>    $saved->empty,
                            'description' => $saved->description,
                            'empty_in_purchase' => $qtyArr[$i],
                            'purchase_case' => $qtyArr[$i],
                            'purchase_bottle' => $qtyArr[$i] * $saved->bottle,                            
                            'added_by' => auth()->user()->added_by);
                            
                           
                         EmptyHistory::create($pur_items);   
          
                    }
                }
            
            }    

    
            $inv = Purchase::find($id);
            $supp=POSSupplier::find($inv->supplier_id);
            $cr= AccountCodes::where('account_name','Purchases')->first();
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
          $journal->supplier_id= $inv->supplier_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Purchase for Purchase Order " .$inv->reference_no ." by Supplier ". $supp->name ;
          $journal->save();
        
        if($inv->purchase_tax > 0){
         $tax= AccountCodes::where('account_name','VAT IN')->first();
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
          $journal->supplier_id= $inv->supplier_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Purchase Tax for Purchase Order " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
        }
        
          $codes= AccountCodes::where('account_name','Payables')->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_purchase';
          $journal->name = 'Purchases';
          $journal->income_id= $inv->id;
          $journal->supplier_id= $inv->supplier_id;
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
    
    
            return redirect(route('restaurant_purchase.show',$id));
    

        }


else if($request->type == 'approve'){
        $purchase = Purchase::find($id);
        $data['supplier_id']=$request->supplier_id;
        $data['supplier_reference_no']=$request->supplier_reference_no;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
        $data['added_by']= auth()->user()->added_by;
       $data['approval_1']= auth()->user()->id;
       $data['approval_1_date'] =date('Y-m-d');
        $data['status'] = 1;
        $data['purchase_status'] = 1;

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
        $cost['total_quantity'] = 0;

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
                $cost['total_quantity'] +=$qtyArr[$i];
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
          $cost['due_quantity'] =  $cost['total_quantity'];
            Purchase::where('id',$id)->update($cost);
        }    

         if(!empty($purchase)){
             $p=Purchase::find($id);
               $user=User::find($p->approval_1);
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"First Approval of Purchase with reference no " .  $purchase->reference_no. " by " .$user->name ,
                        ]
                        );                      
       }

        //return redirect(route('restaurant_purchase.show',$id));

        return redirect(route('restaurant_purchase.order'));
    }



        else{
        $purchase = Purchase::find($id);
        //$data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        //$data['location']=$request->location;
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
        $cost['total_quantity'] = 0;

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
                    $cost['due_quantity'] =  $cost['total_quantity'];

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
               $cost['due_quantity'] =  $cost['total_quantity'];
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

        return redirect(route('restaurant_purchase.show',$id));

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
        PurchaseItems::where('purchase_id', $id)->delete();
        PurchasePayments::where('purchase_id', $id)->delete();
       // InventoryHistory::where('purchase_id', $id)->delete();
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
        $purchases->delete();

                return redirect(route('restaurant_purchase.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= Items::where('id',$request->id)->get();
                return response()->json($price);                      

    }
   public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
               
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
        
        return redirect(route('restaurant_purchase.index'))->with(['success'=>'Approved Successfully']);
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
        ;
        return redirect(route('restaurant_purchase.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
          $supplier=POSSupplier::where('user_id',auth()->user()->added_by)->get();;
        $name =Items::where('added_by',auth()->user()->added_by)->get();;
       $location = InventoryLocation::where('added_by',auth()->user()->added_by)->where('main','1')->get();;
        $data=Purchase::find($id);
        $items=PurchaseItems::where('purchase_id',$id)->get();
        $type="receive";
       return view('bar.pos.purchases.index',compact('name','supplier','currency','location','data','id','items','type'));
    }


 public function first_approval($id)
    {
        //
        $currency= Currency::all();
          $supplier=POSSupplier::where('user_id',auth()->user()->added_by)->get();;
        $name =Items::where('added_by',auth()->user()->added_by)->get();;
       $location = InventoryLocation::where('added_by',auth()->user()->added_by)->where('main','1')->get();;
        $data=Purchase::find($id);
        $items=PurchaseItems::where('purchase_id',$id)->get();
        $type="approve";
       return view('restaurant.pos.purchases.purchase_requisition',compact('name','supplier','currency','location','data','id','items','type'));
    }


    public function second_approval($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['approval_2'] = auth()->user()->id;
      $data['approval_2_date'] =date('Y-m-d');
        $purchase->update($data);

    if(!empty($purchase)){
             $p=Purchase::find($id);
               $user=User::find($p->approval_2);
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"Second Approval of Purchase with reference no " .  $purchase->reference_no. " by " .$user->name ,
                        ]
                        );                      
       }

        return redirect(route('restaurant_purchase.index'))->with(['success'=>'First Approval is Successfully']);
    }

    public function final_approval($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['approval_3'] = auth()->user()->id;
      $data['approval_3_date'] =date('Y-m-d');
        //$data['status'] = 1;
        //$data['purchase_status'] = 1;
        $purchase->update($data);

    if(!empty($purchase)){
             $p=Purchase::find($id);
               $user=User::find($p->approval_3);
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"Final Approval of Purchase with reference no " .  $purchase->reference_no. " by " .$user->name ,
                        ]
                        );                      
       }

        return redirect(route('restaurant_purchase.index'))->with(['success'=>'Final Approval is Successfully']);
    }



    public function second_disapproval($id)
    {
        //
        $purchase = Purchase::find($id);
          $data['approval_1'] = '';
       $data['approval_1_date'] ='';
        $purchase->update($data);

    if(!empty($purchase)){
               $user=User::find(auth()->user()->id);
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"First  Approval has been reversed for Purchase with reference no " .  $purchase->reference_no. " by " .$user->name ,
                        ]
                        );                      
       }

       return redirect(route('restaurant_purchase.requisition'))->with(['success'=>'Disapproval is Successfully']);
    }

    public function final_disapproval($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['approval_2'] = '';
          $data['approval_2_date'] ='';
          //$data['approval_1'] = '';
        $purchase->update($data);

    if(!empty($purchase)){
               $user=User::find(auth()->user()->id);
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"First and Second Approval has been reversed for Purchase with reference no " .  $purchase->reference_no. " by " .$user->name ,
                        ]
                        );                      
       }

       return redirect(route('restaurant_purchase.index'))->with(['success'=>'Disapproval is Successfully']);
    }


  public function save_order(Request $request)
    {
        //
     $id=$request->purchase_id;
     $location =$request->location ;
     $supplier = $request->supplier_id   ;


        $purchase = Purchase::find($id);

    
                       $lists= array(
                            'quantity' =>  $purchase->total_quantity,
                               'added_by' => auth()->user()->added_by,
                               'supplier_id' =>  $supplier,
                              'location' =>     $location,
                             'purchase_date' =>  $purchase->purchase_date,
                            'purchase_id' =>$id);
                           
                        SupplierOrder::create($lists); 

          
                      
    if(!empty($purchase)){
               $user=Supplier::find($request->supplier_id );
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>" Purchase Order created with reference no " .  $purchase->reference_no. " to supplier  " .$user->name ,
                        ]
                        );                      
       }


        return redirect(route('restaurant_purchase.show',$id))->with(['success'=>'Created Successfully']);
    }

public function save_supplier(Request $request)
    {
        //
     $supplier = $request->supplier_id   ;
      $order= SupplierOrder::find($supplier);

        $purchase = Purchase::find($order->purchase_id);

      if($request->old_id != $request->supplier_id ){
       $old= SupplierOrder::where('purchase_id',$purchase->id)->where('status','1')->update([
      'status' => '0'
   ]);


                           $lists['status']='1' ; 
                        $order->update($lists); 

  }    



              $data['supplier_id']=$order->supplier_id   ;
              $data['location']=$order->location   ;
               $purchase->update($data);
 


          
                     

    if(!empty($purchase)){
               $user=Supplier::find($order->supplier_id );
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$order->purchase_id,
                             'module'=>'Purchase',
                            'activity'=>" Purchase Order confirmed with reference no " .  $purchase->reference_no. " to supplier  " .$user->name ,
                        ]
                        );                      
       }


    return redirect(route('restaurant_purchase.show',$order->purchase_id))->with(['success'=>'Confirmed Successfully']);
    }

  public function grn(Request $request)
    {
        //
     $id=$request->purchase_id;
     $nameArr =$request->items_id ;
     $qtyArr = $request->quantity  ;
      $savedArr =$request->items_id ;

        $purchase = Purchase::find($id);

        if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                
                       $saved=Items::find($savedArr[$i]);
    
                       $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'supplier_id' => $purchase->supplier_id,
                              'location' =>    $purchase->location,
                             'purchase_date' =>  $purchase->purchase_date,
                            'type' =>   'Purchases',
                            'purchase_id' =>$id);
                           
                         PurchaseHistory::create($lists); 
                        PurchaseReceive::create($lists);   
          
                        $it=Items::where('id',$nameArr[$i])->first();
                        $q=$it->quantity + $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);

                 $loc=InventoryLocation::where('id',$purchase->location)->first();
                        $lq['bar_crate']=$loc->bar_crate + $qtyArr[$i];
                        $lq['bar_bottle']=$loc->bar_bottle+ ($qtyArr[$i] * $saved->bottle);
                        InventoryLocation::where('id',$purchase->location)->update($lq);


                  if($saved->empty == '1'){
    
                        $pur_items= array(
                            'item_id' => $savedArr[$i],
                            'purpose' =>  'Purchase Empty',
                            'purchase_id' =>$id,
                            'date' =>  $purchase->purchase_date,
                            'has_empty' =>    $saved->empty,
                            'description' => $saved->description,
                            'empty_in_purchase' => $qtyArr[$i],
                            'purchase_case' => $qtyArr[$i],
                            'purchase_bottle' => $qtyArr[$i] * $saved->bottle,                            
                            'added_by' => auth()->user()->added_by);
                            
                           
                         EmptyHistory::create($pur_items);   
          
                    }




                       $dq=Purchase::find($id);
                        $pdq=$dq->due_quantity - $qtyArr[$i];
                        Purchase::where('id',$id)->update(['due_quantity' => $pdq]);


                       $inv = Purchase::find($id);
                     $supp=Supplier::find($inv->supplier_id);

             $itm=PurchaseItems::where('purchase_id',$id)->where('item_name', $savedArr[$i])->first();
             $acc=Items::find($savedArr[$i]);

             if($itm->total_tax > 0){
               $total_tax=(($itm->price * $qtyArr[$i]) * 0.18 );
              }

else{
               $total_tax=0;

}
                   $cost=$itm->price * $qtyArr[$i];

          $cr= AccountCodes::where('account_name','Purchases')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =$cr->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
       $journal->transaction_type = 'restaurant_pos_purchase';
          $journal->name = 'Restaurant Purchases';
          $journal->debit = ($itm->price * $qtyArr[$i]) *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
          $journal->supplier_id= $inv->supplier_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Restaurant Purchase for Purchase Order " .$inv->reference_no ." by Supplier ". $supp->name ;
          $journal->save();
        
        if($itm->total_tax > 0){
        $tax= AccountCodes::where('account_name','VAT IN')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
            $journal->transaction_type = 'restaurant_pos_purchase';
          $journal->name = 'Restaurant Purchases';
          $journal->debit = (($itm->price * $qtyArr[$i]) * 0.18 ) *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->supplier_id= $inv->supplier_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= " Restaurant Purchase Tax for Purchase Order " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
        }
        
         $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'restaurant_pos_purchase';
          $journal->name = 'Restaurant Purchases';
          $journal->income_id= $inv->id;
         $journal->supplier_id= $inv->supplier_id;
          $journal->credit =($cost + $total_tax) *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Credit for Restaurant Purchase Order  " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();




                    }
                }
            
            }    




   

    if(!empty($purchase)){
               $user=User::find(auth()->user()->id);
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"Good Receive for Purchase with reference no " .  $purchase->reference_no. " by " .$user->name ,
                        ]
                        );                      
       }

       
    return redirect(route('restaurant_purchase.index'))->with(['success'=>'Good Receive Done Successfully']);
    }

 public function confirm_order($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['order_status'] = 1;
        $purchase->update($data);

    if(!empty($purchase)){
              
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase Order with reference no " .  $purchase->reference_no. " has been confirmed ." ,
                        ]
                        );                      
       }

        return redirect(route('restaurant_purchase.index'))->with(['success'=>'Confirmed Successfully']);
    }
  public function issue($id)
    {
        //
        $purchase = Purchase::find($id);

          $items=PurchaseItems::where('purchase_id',$id)->get();

                $data['purchase_amount'] =0;
                    $data['purchase_tax'] = 0;
                   $data['due_quantity'] =0;

           foreach($items as $i){

  $due=PurchaseHistory::where('purchase_id',$id)->where('item_id',$i->item_name)->where('type', 'Purchases')->where('added_by',auth()->user()->added_by)->sum('quantity');
$return=PurchaseHistory::where('purchase_id',$id)->where('item_id',$i->item_name)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');
 $qty=$due-$return;

                         $prev['due_quantity']=$qty;
                         $prev['total_tax']=($i->price *  $qty) *  $i->tax_rate;
                        $prev['total_cost']=$i->price *  $qty;

                     PurchaseItems::where('id',$i->id)->update($prev);

                  $data['purchase_amount'] +=$prev['total_cost'];
                    $data['purchase_tax'] += $prev['total_tax'];
                   $data['due_quantity'] +=$qty;

}



 $purchase_amount=PurchaseItems::where('purchase_id',$id)->sum('total_cost');
$purchase_tax=PurchaseItems::where('purchase_id',$id)->sum('total_tax');

      $data['due_amount'] =  $purchase_amount + $purchase_tax;
        $data['good_receive'] = 1;
        $purchase->update($data);

    if(!empty($purchase)){
               $user=User::find(auth()->user()->id);
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchase->reference_no. " has been issued by " .$user->name ,
                        ]
                        );                      
       }

        return redirect(route('restaurant_purchase.index'))->with(['success'=>'Issued Successfully']);
    }

  
 public function purchase_requisition()
    {
        //
        $currency= Currency::all();
        $purchases=Purchase::all()->where('added_by',auth()->user()->added_by)->where('purchase_status',0)->where('good_receive',0)->where('order_status',0);
        $supplier=POSSupplier::where('user_id',auth()->user()->added_by)->get();;
        $name =Items::where('added_by',auth()->user()->added_by)->get();;
        $location = InventoryLocation::where('added_by',auth()->user()->added_by)->get();;
        $type="";
       return view('restaurant.pos.purchases.purchase_requisition',compact('name','supplier','currency','purchases','location','type'));
    }
 public function purchase_order()
    {
        //
        $currency= Currency::all();
        $purchases=Purchase::all()->where('added_by',auth()->user()->added_by)->where('purchase_status',1)->where('good_receive',0)->where('order_status',0);
        $supplier=POSSupplier::where('user_id',auth()->user()->added_by)->get();;
        $name =Items::where('added_by',auth()->user()->added_by)->get();;
        $location = InventoryLocation::where('added_by',auth()->user()->added_by)->get();;
        $type="";
       return view('restaurant.pos.purchases.purchase_order',compact('name','supplier','currency','purchases','location','type'));
    }
    public function make_payment($id)
    {
        //
        $invoice = Purchase::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
        return view('restaurant.pos.purchases.purchase_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function inv_pdfview(Request $request)
    {
        //
        $purchases = Purchase::find($request->id);
        $purchase_items=PurchaseItems::where('purchase_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
              if($purchases->order_status == '1'){           
        $pdf = PDF::loadView('restaurant.pos.purchases.purchase_details_pdf')->setPaper('a4', 'potrait');
         }
       else{
          $pdf = PDF::loadView('restaurant.pos.purchases.order_details_pdf')->setPaper('a4', 'potrait');
         }
         return $pdf->download('ORDER PURCHASES REF NO # ' .  $purchases->reference_no . ".pdf");
        }
        return view('inv_pdfview');
    }

public function order_pdfview(Request $request)
        {
        //
       $order=SupplierOrder::find($request->id);
        $purchases = Purchase::find($order->purchase_id);
        $purchase_items=PurchaseItems::where('purchase_id',$order->purchase_id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items,'order'=> $order]);

        if($request->has('download')){
        $pdf = PDF::loadView('restaurant.pos.purchases.order_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('SUPPLIER PURCHASES ORDER REF NO # ' .  $purchases->reference_no . ".pdf");
        }
        return view('order_pdfview');
    }
 public function issue_pdfview(Request $request)
    {
        //
        $purchases = Purchase::find($request->id);
        $purchase_items=PurchaseItems::where('purchase_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('restaurant.pos.purchases.issue_supplier_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('ISSUED PURCHASES REF NO # ' .  $purchases->reference_no . ".pdf");
        }
        return view('issue_pdfview');
    }
public function creditors_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (POSSupplier::where('user_id',auth()->user()->added_by)->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        if($request->isMethod('post')){
            $data= Purchase::where('supplier_id', $request->account_id)->whereBetween('purchase_date',[$start_date,$end_date])->where('status','!=',0)->get();
        }else{
            $data=[];
        }

       

        return view('restaurant.pos.purchases.creditors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }
}
