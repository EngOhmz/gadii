<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
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
        $purchases=Purchase::all();
        $supplier=Supplier::all();
        $name =Inventory::all();
        $location = Location::all();
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

        $data['reference_no']='1';
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
        $data['added_by']= auth()->user()->id;

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
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$purchase->id);
                       
                        PurchaseItems::create($items);  ;
    
    
                }
            }
            $cost['reference_no']= "PUR_INV-".$purchase->id."-".$data['purchase_date'];
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
            PurchaseItems::where('id',$purchase->id)->update($cost);
        }    

        Purchase::find($purchase->id)->update(['reference_no'=>"PUR_INV-".$purchase->id."-".$data['purchase_date']]);

        
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
        $purchase_items=PurchaseItems::where('purchase_id',$id)->get();
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
        $supplier=Supplier::all();
        $name = Inventory::all();
        $location = Location::all();
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
            $data['reference_no']="PUR_INV-".$id."-".$data['purchase_date'];
            $data['purchase_amount']='1';
            $data['due_amount']='1';
            $data['purchase_tax']='1';
            $data['good_receive']='1';
            $data['added_by']= auth()->user()->id;
    
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
                    PurchaseItem::where('id',$remArr[$i])->delete();        
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
                            'tax_rate' =>  $rateArr [$i],
                             'unit' => $unitArr[$i],
                               'price' =>  $priceArr[$i],
                            'total_cost' =>  $costArr[$i],
                            'total_tax' =>   $taxArr[$i],
                             'items_id' => $savedArr[$i],
                               'order_no' => $i,
                               'added_by' => auth()->user()->id,
                            'purchase_id' =>$id);
                           
                            if(!empty($expArr[$i])){
                                PurchaseItems::where('id',$expArr[$i])->update($items);  
          
          }
          else{
            PurchaseItem::create($items);   
          }
                      
                  if(!empty($qtyArr[$i])){
            for($x = 1; $x <= $qtyArr[$i]; $x++){    
                $name=Inventory::where('id', $savedArr[$i])->first();
                $dt=date('Y',strtotime($data['purchase_date']));
                    $lists = array(
                        'serial_no' => $name->name."_" .$id."_".$x."_" .$dt,                      
                         'brand_id' => $savedArr[$i],
                           'added_by' => auth()->user()->id,
                           'purchase_id' =>   $id,
                         'purchase_date' =>  $data['purchase_date'],
                           'location' => $data['location'],
                           'status' => '0');
                       
     
                    InventoryList::create($lists);   
      
                }
            }
         
  
                    }
                }
                $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
                Purchase::where('id',$id)->update($cost);
            }    
    
            
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                        $items = array(
                            'quantity' =>   $qtyArr[$i],
                             'items_id' => $savedArr[$i],
                               'added_by' => auth()->user()->id,
                               'supplier_id' =>   $data['supplier_id'],
                             'purchase_date' =>  $data['purchase_date'],
                               'location' => $data['location'],
                            'purchase_id' =>$id);
                           
         
                         InventoryHistory::create($items);   
          
                        $inv=Inventory::where('id',$nameArr[$i])->first();
                        $q=$inv->quantity + $qtyArr[$i];
                        Inventory::where('id',$nameArr[$i])->update(['quantity' => $q]);
                    }
                }
            
            }    
    
    
            $inv = Purchase::find($id);
            $supp=Supplier::find($inv->supplier_id);
            $cr= AccountCodes::where('account_name','Inventory')->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory';
          $journal->name = 'Inventory Purchase';
          $journal->debit = $inv->purchase_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->id;
             $journal->notes= "Inventory Purchase with reference no " .$inv->reference_no ." by Supplier ". $supp->name ;
          $journal->save();
        
        if($inv->purchase_tax > 0){
         $tax= AccountCodes::where('account_name','VAT IN')->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'inventory';
          $journal->name = 'Inventory Purchase';
          $journal->debit = $inv->purchase_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->id;
             $journal->notes= "Inventory Purchase Tax with reference no " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
        }
        
          $codes= AccountCodes::where('account_name','Payables')->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'inventory';
          $journal->name = 'Inventory Purchase';
          $journal->income_id= $inv->id;
          $journal->credit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->id;
             $journal->notes= "Credit for Inventory Purchase with reference no " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
    
    
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
        $data['added_by']= auth()->user()->id;

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
                PurchaseItemInventory::where('id',$remArr[$i])->delete();        
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
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$id);
                       
                        if(!empty($expArr[$i])){
                            PurchaseItem::where('id',$expArr[$i])->update($items);  
      
      }
      else{
        PurchaseItem::create($items);   
      }
                    
                }
            }
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
            Purchase::where('id',$id)->update($cost);
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
        //
        PurchaseItems::where('purchase_id', $id)->delete();
        PurchasePayments::where('purchase_id', $id)->delete();
        InventoryHistory::where('purchase_id', $id)->delete();
        $purchases = Purchase::find($id);
        $purchases->delete();
        return redirect(route('purchase.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= Inventory::where('id',$request->id)->get();
                return response()->json($price);	                  

    }
   public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
                  if($type == 'reference'){
                    return view('inventory.addreference',compact('id'));
      }
                elseif($type == 'maintainance'){
                     $name = ServiceType::all();     
                    return view('inventory.addmaintainance',compact('id','name','type'));
      }
            elseif($type == 'service'){
                    $name = ServiceType::all();   
                    return view('inventory.addmaintainance',compact('id','name','type'));
      }
        elseif($type == 'mechanical_maintainance'){
                    $item =  MechanicalItem::where('module_id',$id)->where('module','maintainance')->get(); 
                   $notes =   MechanicalRecommedation::where('module_id',$id)->where('module','maintainance')->get();   
                    return view('inventory.viewreport',compact('id','item','type','notes'));
      }
   elseif($type == 'mechanical_service'){
                    $item =  MechanicalItem::where('module_id',$id)->where('module','service')->get(); 
                   $notes =   MechanicalRecommedation::where('module_id',$id)->where('module','service')->get();   
                    return view('inventory.viewreport',compact('id','item','type','notes'));
      }
     elseif($type == 'requisition_maintainance'){
                    $item =  Inventory::all(); 
                   $module =   'Maintainance';   
                    return view('inventory.addrequistion',compact('id','item','module','id'));
      }
  elseif($type == 'requisition_service'){
                    $item =  Inventory::all(); 
                   $module =   'Service';   
                    return view('inventory.addrequistion',compact('id','item','module','id'));
      }
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
        $data['status'] = 1;
        $purchase->update($data);
        return redirect(route('purchase.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['status'] = 4;
        $purchase->update($data);
        return redirect(route('purchase.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $supplier=Supplier::all();
        $name = Inventory::all();
        $location = Location::all();
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
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('pos.purchases.purchase_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function inv_pdfview(Request $request)
    {
        //
        $purchases = Purchase::find($request->id);
        $purchase_items=PurchaseItems::where('purchase_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pos.purchases.purchase_details_pdf')->setPaper('a4', 'landscape');
         return $pdf->download('PURCHASE REF NO # ' .  $purchases->reference_no . ".pdf");
        }
        return view('inv_pdfview');
    }
}
