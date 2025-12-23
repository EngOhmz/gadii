<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Truck;
use App\Models\InventoryHistory;
use App\Models\InventoryPayment;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
use App\Models\Purchase_items;
use App\Models\PurchaseInventory;
use App\Models\PurchaseItemInventory;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Supplier;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\User;
use PDF;
use App\Models\Branch;
use App\Models\MechanicalItem;
use App\Models\MechanicalRecommedation;

use Illuminate\Http\Request;

class RequisitionController extends Controller
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
        $purchases=Requisition::where('added_by',auth()->user()->added_by)->get();
        $supplier=Supplier::where('user_id',auth()->user()->added_by)->get();
        $name =Inventory::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
        $truck =Truck::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $type="";
       return view('inventory.manage_requisition',compact('name','supplier','currency','purchases','location','type','truck'));
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
        $count = Requisition::where('added_by', auth()->user()->added_by)->count();
        $pro = $count + 1;
        $data['reference_no']='REQ0' . $pro;
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
         $data['branch_id'] = $request->branch_id;
        $data['user_agent'] = $request->user_agent;
        $data['user_id'] = auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $purchase = Requisition::create($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
        $truckArr =$request->truck_id ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );

        $savedArr =$request->item_name ;
        
        $subArr = str_replace(',', '', $request->subtotal);
        $totalArr = str_replace(',', '', $request->tax);
        $amountArr = str_replace(',', '', $request->amount);
        $disArr = str_replace(',', '', $request->discount);
        $shipArr = str_replace(',', '', $request->shipping_cost);
        
        if (!empty($nameArr)) {
            for ($i = 0; $i < count($amountArr); $i++) {
                if (!empty($amountArr[$i])) {
                    $t = [
                        'purchase_amount' => $subArr[$i],
                        'purchase_tax' => $totalArr[$i],
                        'shipping_cost' => $shipArr[$i],
                        'discount' => $disArr[$i],
                        'due_amount' => $amountArr[$i],
                    ];

                   Requisition::where('id', $purchase->id)->update($t);
                }
            }
        }

        
        
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'truck_id' => $truckArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'purchase_id' =>$purchase->id);
                       
                    RequisitionItem::create($items);  ;
    
    
                }
            }

            
        }    

        
        return redirect(route('requisition.show',$purchase->id));
        
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
        $purchases = Requisition::find($id);
        $purchase_items=RequisitionItem::where('purchase_id',$id)->get();

        
        return view('inventory.requisition_details',compact('purchases','purchase_items'));
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
        $name =Inventory::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
         $truck =Truck::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
         $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $data=Requisition::find($id);
        $items=RequisitionItem::where('purchase_id',$id)->get();
         $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $type="";
       return view('inventory.manage_requisition',compact('name','supplier','currency','location','data','id','items','type','branch','user','truck'));
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

        if($request->edit_type == 'receive'){
            $purchase = Requisition::find($id);

            $data['supplier_id']=$request->supplier_id;
            $data['purchase_date']=$request->purchase_date;
            $data['due_date']=$request->due_date;
            $data['location']=$request->location;
            $data['exchange_code']=$request->exchange_code;
            $data['exchange_rate']=$request->exchange_rate;
            $data['purchase_amount']='1';
            $data['due_amount']='1';
            $data['purchase_tax']='1';
             $data['branch_id'] = $request->branch_id;
        $data['user_agent'] = $request->user_agent;
        $data['user_id'] = auth()->user()->id;
         $data['approved_by']= auth()->user()->id;
            $data['added_by']= auth()->user()->added_by;
    
            $purchase->update($data);
            
            $amountArr = str_replace(",","",$request->amount);
            $totalArr =  str_replace(",","",$request->tax);
    
            $nameArr =$request->item_name ;
            $truckArr =$request->truck_id ;
            $qtyArr = $request->quantity  ;
            $priceArr = $request->price;
            $rateArr = $request->tax_rate ;
            $unitArr = $request->unit  ;
            $costArr = str_replace(",","",$request->total_cost)  ;
            $taxArr =  str_replace(",","",$request->total_tax );
            $remArr = $request->removed_id ;
            $expArr = $request->saved_items_id ;
            $savedArr =$request->item_name ;
            
            
            
        $subArr = str_replace(',', '', $request->subtotal);
        $totalArr = str_replace(',', '', $request->tax);
        $amountArr = str_replace(',', '', $request->amount);
        $disArr = str_replace(',', '', $request->discount);
        $shipArr = str_replace(',', '', $request->shipping_cost);
        
        if (!empty($nameArr)) {
            for ($i = 0; $i < count($amountArr); $i++) {
                if (!empty($amountArr[$i])) {
                    $t = [
                        'purchase_amount' => $subArr[$i],
                        'purchase_tax' => $totalArr[$i],
                        'shipping_cost' => $shipArr[$i],
                        'discount' => $disArr[$i],
                        'due_amount' => $amountArr[$i],
                    ];

                   Requisition::where('id', $id)->update($t);
                }
            }
        }

            
            
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                   RequisitionItem::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        
    
                        $items = array(
                            'item_name' => $nameArr[$i],
                            'truck_id' => $truckArr[$i],
                            'quantity' =>   $qtyArr[$i],
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
                               RequisitionItem::where('id',$expArr[$i])->update($items);  
          
          }
          else{
           RequisitionItem::create($items);   
          }
                      
              
         
  
                    }
                }
               
            }    
    
            
    
           
    
    
            $inv = Requisition::find($id);

        $count =  PurchaseInventory::where('added_by', auth()->user()->added_by)->count();
        $pro = $count + 1;
        $list['reference_no'] = 'PINV0' . $pro;
        $list['supplier_id']= $inv->supplier_id;
        $list['req_id']= $id;
        $list['purchase_date']= $inv->purchase_date;
        $list['due_date']= $inv->due_date;
        $list['location']= $inv->location;
        $list['exchange_code']= $inv->exchange_code;
        $list['exchange_rate']= $inv->exchange_rate;
        $list['purchase_amount']=$inv->purchase_amount;
        $list['due_amount']=$inv->due_amount;
        $list['shipping_cost'] = $inv->shipping_cost;
        $list['discount'] = $inv->discount;
        $list['purchase_tax']=$inv->purchase_tax;
        $list['branch_id'] = $request->branch_id;
        $list['user_agent'] = $request->user_agent;
        $list['user_id'] = auth()->user()->id;
        $list['approved_by']= auth()->user()->id;
        $list['status']='1';
        $list['good_receive']='0';
        $list['added_by']= auth()->user()->added_by;

        $req = PurchaseInventory::create($list);

 $req_items=RequisitionItem::where('purchase_id',$id)->get();

 if(!empty($req_items)){
            foreach($req_items as $it){

                    $i = array(
                        'item_name' => $it->item_name,
                        'quantity' =>   $it->quantity,
                         'due_quantity' => $it->quantity,
                        'tax_rate' =>  $it->tax_rate,
                         'unit' => $it->unit,
                           'price' =>  $it->price,
                        'total_cost' => $it->total_cost,
                        'total_tax' =>   $it->total_tax,
                         'items_id' => $it->items_id,
                           'order_no' => $it->order_no,
                           'added_by' => auth()->user()->added_by,
                        'purchase_id' =>$req->id);
                       
                     PurchaseItemInventory::create($i);  ;
    
    
                }
            }


          
            $supp = Supplier::find($req->supplier_id);

           if ($req->discount > 0) {
                $disc = AccountCodes::where('account_name', 'Purchase Discount')->where('added_by', auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $disc->id;
                $date = explode('-', $req->purchase_date);
                $journal->date = $req->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'inventory';
                $journal->name = 'Inventory Purchase';
                $journal->debit = $req->discount * $req->exchange_rate;
                $journal->income_id = $req->id;
                $journal->branch_id = $req->branch_id;
                $journal->currency_code = $req->exchange_code;
                $journal->exchange_rate = $req->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Inventory Purchase Discount for Purchase Order ' . $req->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();

                $cr = AccountCodes::where('account_name', 'Inventory')
                    ->where('added_by', auth()->user()->added_by)
                    ->first();
                $journal = new JournalEntry();
                $journal->account_id = $cr->id;
                $date = explode('-', $req->purchase_date);
                $journal->date = $req->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'inventory';
                $journal->name = 'Inventory Purchase';
                $journal->credit = $req->discount * $req->exchange_rate;
                $journal->income_id = $req->id;
                $journal->currency_code = $req->exchange_code;
                $journal->exchange_rate = $req->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Inventory Purchase Discount for Purchase Order ' . $req->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();
            }

            if ($req->shipping_cost > 0) {
                $shp = AccountCodes::where('account_name', 'Shipping Cost')
                    ->where('added_by', auth()->user()->added_by)
                    ->first();
                $journal = new JournalEntry();
                $journal->account_id = $shp->id;
                $date = explode('-', $req->purchase_date);
                $journal->date = $req->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
               $journal->transaction_type = 'inventory';
                $journal->name = 'Inventory Purchase';
                $journal->debit = $req->shipping_cost * $req->exchange_rate;
                $journal->income_id = $req->id;
                $journal->currency_code = $req->exchange_code;
                $journal->exchange_rate = $req->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Inventory Purchase Shipping Cost for Purchase Order ' . $req->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();

                $codes = AccountCodes::where('account_name', 'Payables')
                    ->where('added_by', auth()->user()->added_by)
                    ->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                $date = explode('-', $req->purchase_date);
                $journal->date = $req->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'inventory';
                $journal->name = 'Inventory Purchase';
                $journal->income_id = $req->id;
                $journal->credit = $req->shipping_cost * $req->exchange_rate;
                $journal->currency_code = $req->exchange_code;
                $journal->exchange_rate = $req->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Credit Inventory Shipping Cost for Purchase Order  ' . $req->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();
            }
           
            
            
        $new['status']='1';
          $inv->update($new);
    
            return redirect(route('purchase_inventory.index'))->with(['success'=>'Approved Successfully']);;
    

        }

        else{
        $purchase = Requisition::find($id);
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
         $data['branch_id'] = $request->branch_id;
        $data['user_agent'] = $request->user_agent;
        $data['user_id'] = auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $purchase->update($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
        $truckArr =$request->truck_id ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        $savedArr =$request->item_name ;
        
       
        $subArr = str_replace(',', '', $request->subtotal);
        $totalArr = str_replace(',', '', $request->tax);
        $amountArr = str_replace(',', '', $request->amount);
        $disArr = str_replace(',', '', $request->discount);
        $shipArr = str_replace(',', '', $request->shipping_cost);
        
        if (!empty($nameArr)) {
            for ($i = 0; $i < count($amountArr); $i++) {
                if (!empty($amountArr[$i])) {
                    $t = [
                        'purchase_amount' => $subArr[$i],
                        'purchase_tax' => $totalArr[$i],
                        'shipping_cost' => $shipArr[$i],
                        'discount' => $disArr[$i],
                        'due_amount' => $amountArr[$i],
                    ];

                   Requisition::where('id', $id)->update($t);
                }
            }
        }


        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
               RequisitionItem::where('id',$remArr[$i])->delete();        
                   }
               }
           }

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'truck_id' => $truckArr[$i],
                        'quantity' =>   $qtyArr[$i],
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
                           RequisitionItem::where('id',$expArr[$i])->update($items);  
      
      }
      else{
       RequisitionItem::create($items);   
      }
                    
                }
            }
            
        }    

        

        return redirect(route('requisition.show',$id));

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
       RequisitionItem::where('purchase_id', $id)->delete();
        $purchases = Requisition::find($id);
        $purchases->delete();
        return redirect(route('requisition.index'))->with(['success'=>'Deleted Successfully']);
    }




   
    public function cancel($id)
    {
        //
        $purchase = Requisition::find($id);
        $data['status'] = 4;
        $data['rejected_by']= auth()->user()->id;
        $purchase->update($data);
        return redirect(route('requisition.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $supplier=Supplier::where('user_id',auth()->user()->added_by)->get();
        $name =Inventory::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
         $truck =Truck::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $data=Requisition::find($id);
        $items=RequisitionItem::where('purchase_id',$id)->get();
         $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $type="receive";
       return view('inventory.manage_requisition',compact('name','supplier','currency','location','data','id','items','type','branch','user','truck'));
    }


    
    public function requisition_pdfview(Request $request)
    {
        //
        $purchases = Requisition::find($request->id);
        $purchase_items=RequisitionItem::where('purchase_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('inventory.requisition_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('REQUISITION REF NO # ' .  $purchases->reference_no . ".pdf");
        }
        return view('requisition_pdfview');
    }
}
