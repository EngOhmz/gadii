<?php

namespace App\Http\Controllers\Pharmacy\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
use App\Models\Pharmacy\Supplier;
use App\Models\Pharmacy\InventoryList;
use App\Models\ServiceType;
use App\Models\Pharmacy\Purchase;
use App\Models\Pharmacy\PurchaseItems;
use App\Models\Pharmacy\Items;
use App\Models\Pharmacy\PurchaseHistory;
use App\Models\Pharmacy\PurchasePayments;
use App\Models\Pharmacy\PurchaseSerial;
use App\Models\Pharmacy\PurchaseSerialItems;
use App\Models\Pharmacy\PurchaseSerialList;
use App\Models\Pharmacy\PurchaseSerialHistory;
use App\Models\Pharmacy\PurchaseSerialPayments;
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
       $data=Purchase::where('added_by',auth()->user()->added_by);
       $purchases=PurchaseSerial::where('added_by',auth()->user()->added_by)->union($data)->get();
        $supplier=Supplier::where('user_id',auth()->user()->added_by)->get();
        $name =Items::where('user_id',auth()->user()->added_by)->get();
        $location =  Location::where('added_by',auth()->user()->added_by)->get();;
        $type="";
    $edit="";
       return view('pharmacy.pos.purchases.index',compact('name','supplier','currency','purchases','location','type','edit'));
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
        $data['reference_no']= "BPH0".$pro;
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
        $data['shipping_cost']='1';
        $data['status']='0';
        $data['good_receive']='0';
        $data['added_by']= auth()->user()->added_by;

        $purchase = Purchase::create($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        //$batchArr = $request->batch_number;
        //$expireArr = $request->expire_date;
        $priceArr = $request->price;
       $categoryArr = $request->category;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $shipArr =  str_replace(",","",$request->shipping_cost);
        
        $savedArr =$request->item_name ;
        
        $cost['purchase_amount'] = 0;
        $cost['purchase_tax'] = 0;
         $cost['shipping_cost']=0;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['purchase_amount'] +=$costArr[$i];
                    $cost['purchase_tax'] +=$taxArr[$i];
                    $cost['shipping_cost'] =$shipArr[0];

                       $d=Items::where('id',$nameArr[$i])->first();
                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                          'due_quantity' =>   $qtyArr[$i],
                        //'batch_number' =>  $batchArr[$i],
                        //'expire_date' =>  $expireArr[$i],
                        'category' =>  $categoryArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $d->unit,
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
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'] +$cost['shipping_cost'] ;
            PurchaseItems::where('id',$purchase->id)->update($cost);
        }    

        Purchase::find($purchase->id)->update($cost);;

        
        return redirect(route('pharmacy_purchase.show',$purchase->id));
        
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
        $purchase_items=PurchaseItems::where('purchase_id',$id)->get();
        $payments=PurchasePayments::where('purchase_id',$id)->get();
        
        return view('pharmacy.pos.purchases.purchase_details',compact('purchases','purchase_items','payments'));
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
           $supplier=Supplier::where('user_id',auth()->user()->added_by)->get();
        $name =Items::where('user_id',auth()->user()->added_by)->get();
        $location =  Location::where('added_by',auth()->user()->added_by)->get();;
        $data=Purchase::find($id);
        $items=PurchaseItems::where('purchase_id',$id)->get();
        $type="";
     $edit="";
       return view('pharmacy.pos.purchases.index',compact('name','supplier','currency','location','data','id','items','type','edit'));
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
            //$data['good_receive']='1';
          $data['status']='1';
            $data['added_by']= auth()->user()->added_by;
    
            $purchase->update($data);
            
            $amountArr = str_replace(",","",$request->amount);
            $totalArr =  str_replace(",","",$request->tax);
           $costArr = str_replace(",","",$request->total_cost)  ;

            $nameArr =$request->item_name ;
            $qtyArr = $request->quantity  ;
             //$batchArr = $request->batch_number;
        //$expireArr = $request->expire_date;
        $priceArr = $request->price;
       $categoryArr = $request->category;
            $rateArr = $request->tax_rate ;
            $unitArr = $request->unit  ;
            $costArr = str_replace(",","",$request->total_cost)  ;
            $taxArr =  str_replace(",","",$request->total_tax );
            $shipArr =  str_replace(",","",$request->shipping_cost);
            $remArr = $request->removed_id ;
            $expArr = $request->saved_items_id ;
            $savedArr =$request->item_name ;
            
            $cost['purchase_amount'] = 0;
        $cost['purchase_tax'] = 0;
         $cost['shipping_cost']=0;

                     
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    PurchaseItem::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $cost['purchase_amount'] +=$costArr[$i];
                        $cost['purchase_tax'] +=$taxArr[$i];
                         $cost['shipping_cost'] =$shipArr[0];

                              $d=Items::where('id',$nameArr[$i])->first();
                        $items = array(
                            'item_name' => $nameArr[$i],
                            'quantity' =>   $qtyArr[$i],
                               'due_quantity' =>   $qtyArr[$i],
                             //'batch_number' =>  $batchArr[$i],
                        //'expire_date' =>  $expireArr[$i],
                        'category' =>  $categoryArr[$i],
                            'tax_rate' =>  $rateArr [$i],
                             'unit' => $d->unit,
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
                 
                       if($categoryArr[$i] == 'Serial'){     
                  if(!empty($qtyArr[$i])){
            for($x = 1; $x <= $qtyArr[$i]; $x++){    
                $name=Items::where('id', $savedArr[$i])->first();
                $dt=date('Y',strtotime($data['purchase_date']));
                    $lists = array(
                        'serial_no' => $name->name."_" .$id."_".$x,                      
                         'brand_id' => $savedArr[$i],
                           'added_by' => auth()->user()->added_by,
                           'purchase_id' =>   $id,
                         'purchase_date' =>  $data['purchase_date'],
                           'location' => $data['location'],
                           'status' => '0');
                       
     
                    PurchaseSerialList::create($lists);   
      
                }
            }
       }

  
                    }
                }
                $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'] +$cost['shipping_cost'] ;
                Purchase::where('id',$id)->update($cost);
            }    
    
            
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if($categoryArr[$i] == 'Batch'){
                       
                       $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'due_quantity' =>   $qtyArr[$i],
                            //'batch_number' =>  $batchArr[$i],
                            //'expire_date' =>  $expireArr[$i],
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
                    }
                }
            
            }    
    

          if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if($categoryArr[$i] == 'Serial'){
                       
                    $s_lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'due_quantity' =>   $qtyArr[$i],
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'supplier_id' => $data['supplier_id'],
                              'location' =>    $data['location'],
                             'purchase_date' =>  $data['purchase_date'],
                            'type' =>   'Purchases',
                            'purchase_id' =>$id);
                           
                         PurchaseSerialHistory::create($s_lists);   
          
                        $inv=Items::where('id',$nameArr[$i])->first();
                        $q=$inv->quantity + $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);
                           
                       
                    }
                }
            
            }  

    
            $inv = Purchase::find($id);
            $supp=Supplier::find($inv->supplier_id);
            $cr= AccountCodes::where('account_name','Purchases')->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
      $journal->transaction_type = 'pos_pharmacy_purchase';
          $journal->name = 'Purchases';
          $journal->debit = $inv->purchase_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
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
            $journal->transaction_type = 'pos_pharmacy_purchase';
          $journal->name = 'Purchases';
          $journal->debit = $inv->purchase_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Purchase Tax for Purchase Order " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
        }
 if($inv->shipping_cost > 0){
         $ship= AccountCodes::where('account_name','Shipping Cost')->first();
            $journal = new JournalEntry();
          $journal->account_id = $ship->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
            $journal->transaction_type = 'pos_pharmacy_purchase';
          $journal->name = 'Purchases';
          $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Shipping Cost for Purchase Order " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
        }
        
          $codes= AccountCodes::where('account_name','Payables')->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_pharmacy_purchase';
          $journal->name = 'Purchases';
          $journal->income_id= $inv->id;
          $journal->credit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Credit for Purchase Order  " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
    
    
            return redirect(route('pharmacy_purchase.show',$id));
    

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
         $costArr = str_replace(",","",$request->total_cost)  ;

        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        //$batchArr = $request->batch_number;
        //$expireArr = $request->expire_date;
        $priceArr = $request->price;
       $categoryArr = $request->category;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
         $costArr = str_replace(",","",$request->total_cost)  ;
            $taxArr =  str_replace(",","",$request->total_tax );
            $shipArr =  str_replace(",","",$request->shipping_cost);
            $remArr = $request->removed_id ;
            $expArr = $request->saved_items_id ;
            $savedArr =$request->item_name ;
            
            $cost['purchase_amount'] = 0;
        $cost['purchase_tax'] = 0;
         $cost['shipping_cost']=0;

       

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                PurchaseItem::where('id',$remArr[$i])->delete();        
                   }
               }
           }

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['purchase_amount'] +=$costArr[$i];
                    $cost['purchase_tax'] +=$taxArr[$i];
                    $cost['shipping_cost'] =$shipArr[0];

                       $d=Items::where('id',$nameArr[$i])->first();
                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        'due_quantity' =>   $qtyArr[$i],
                        //'batch_number' =>  $batchArr[$i],
                        //'expire_date' =>  $expireArr[$i],
                        'category' =>  $categoryArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $d->unit,
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
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'] +$cost['shipping_cost'] ;
            Purchase::where('id',$id)->update($cost);
        }    

        

        return redirect(route('pharmacy_purchase.show',$id));

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
        $purchases->delete();
        return redirect(route('pharmacy_purchase.index'))->with(['success'=>'Deleted Successfully']);
    }





    public function findPrice(Request $request)
    {
               $price= Items::where('id',$request->id)->get();
                return response()->json($price);                      

    }
 public function addSupplier(Request $request){
       
    
        $client= Supplier::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        'TIN' => $request['TIN'],
        'VRN' => $request['VRN'],
            'user_id'=> auth()->user()->added_by,
        ]);
        
      

        if (!empty($client)) {           
            return response()->json($client);
         }

       
   }

   public function discountModal(Request $request)
    {
               
                 }

           public function save_reference (Request $request){
                     //
                     $inv=   InventoryList::find($request->id);
                     $data['reference']=$request->reference;
                     $data['assign_reference']='1';
                     $inv->update($data);

                     return redirect(route('inventory.list'))->with(['success'=>'Inventory Reference Assigned Successfully']);
                 }


    public function approve($id)
    {
        //
        $purchase = Purchase::find($id);
        //$data['status'] = 1;
        $data['good_receive'] = 1;
        $purchase->update($data);
        return redirect(route('pharmacy_purchase.index'))->with(['success'=>'Good Receive Successfully']);
    }

    public function cancel($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['status'] = 4;
        $purchase->update($data);
        return redirect(route('pharmacy_purchase.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $supplier=Supplier::all();
        $name = Items::all();
        $location = Location::all();
        $data=Purchase::find($id);
        $items=PurchaseItems::where('purchase_id',$id)->get();
        $type="receive";
     $edit="";
       return view('pharmacy.pos.purchases.index',compact('name','supplier','currency','location','data','id','items','type','edit'));
    }



   public function purchase_list()
    {
        //
        $list= PurchaseHistory::where('added_by',auth()->user()->added_by)->get();
       return view('pharmacy.pos.purchases.purchase_list',compact('list'));
    }

    public function make_payment($id)
    {
        //
        $invoice = Purchase::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('pharmacy.pos.purchases.purchase_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function inv_pdfview(Request $request)
    {
        //
        $purchases = Purchase::find($request->id);
        $purchase_items=PurchaseItems::where('purchase_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pharmacy.pos.purchases.purchase_details_pdf')->setPaper('a4', 'potrait');
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
             $purchases= Purchase::where('supplier_id', $request->account_id)->whereBetween('purchase_date',[$start_date,$end_date])->where('status','!=',0);
            $data= PurchaseSerial::where('supplier_id', $request->account_id)->whereBetween('purchase_date',[$start_date,$end_date])->where('status','!=',0)->union($purchases)->get();
        }else{
            $data=[];
        }

       

        return view('pharmacy.pos.purchases.creditors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }

  public function save_batch (Request $request){
                     //
                     $inv=   PurchaseHistory::find($request->id);
                     $data['expire_date']=$request->expire_date;
                    $data['batch_number']=$request->batch_number;
                    $data['serial_no']=$request->batch_number;
                     $inv->update($data);

                     return redirect(route('pharmacy.purchase_list'))->with(['success'=>' Assigned Successfully']);
                 }


}
