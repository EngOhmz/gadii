<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\MasterHistory;
use App\Models\InventoryPayment;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
use App\Models\Purchase_items;
use App\Models\PurchaseInventory;
use App\Models\PurchaseItemInventory;
use App\Models\Supplier;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\Service;
use App\Models\ServiceInventory;
use App\Models\User;
use App\Models\Branch;
use App\Models\Truck;
use PDF;
use DB;
use App\Models\MechanicalItem;
use App\Models\MechanicalRecommedation;

use Illuminate\Http\Request;

class PurchaseInventoryController extends Controller
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
        $purchases=PurchaseInventory::where('added_by',auth()->user()->added_by)->get();
        $supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
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
        
        $pos_purchase= PurchaseInventory::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw(' ((purchase_amount + purchase_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= PurchaseInventory::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= PurchaseInventory::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->count();
         $unpaid= PurchaseInventory::where('added_by',auth()->user()->added_by)->where('status','1')->count();
         $part= PurchaseInventory::where('added_by',auth()->user()->added_by)->where('status','2')->count();
         $paid= PurchaseInventory::where('added_by',auth()->user()->added_by)->where('status','3')->count();
         
       return view('inventory.manage_purchase_inv',compact('name','supplier','currency','purchases','location','type','branch','user','truck',
       'pos_purchase','pos_due','total','unpaid','part','paid'
       ));
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

        $count =  PurchaseInventory::where('added_by', auth()->user()->added_by)->count();
        $pro = $count + 1;
        $data['reference_no'] = 'PINV0' . $pro;
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
        $data['branch_id'] = $request->branch_id;
        $data['user_agent'] = $request->user_agent;
        $data['user_id'] = auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $purchase = PurchaseInventory::create($data);
        
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

                     PurchaseInventory::where('id', $purchase->id)->update($t);
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
                       
                     PurchaseItemInventory::create($items);  ;
    
    
                }
            }
          
            
        }    

        
        return redirect(route('purchase_inventory.show',$purchase->id));
        
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
        $purchases = PurchaseInventory::find($id);
        $purchase_items=PurchaseItemInventory::where('purchase_id',$id)->where('due_quantity','>', '0')->get();
        $payments=InventoryPayment::where('purchase_id',$id)->get();
        
         $dn=AccountCodes::where('account_name','Debit Note Control')->where('added_by',auth()->user()->added_by)->first();
        if(!empty($dn)){
        
         $added_by = auth()->user()->added_by;
        
       $a = "SELECT inventory_return_purchases.reference_no,inventory_return_purchases.return_date,journal_entries.credit,inventory_return_purchases.bank_id,journal_entries.id FROM inventory_return_purchases INNER JOIN journal_entries ON inventory_return_purchases.id=journal_entries.income_id 
        INNER JOIN purchase_inventories ON inventory_return_purchases.purchase_id = purchase_inventories.id WHERE inventory_return_purchases.added_by = '".$added_by."' AND purchase_inventories.id = '".$id."' AND journal_entries.account_id = '".$dn->id."' AND journal_entries.transaction_type = 'inventory_debit_note' ";
        
        $deposits = DB::select($a);
        }
        
        else{
            $deposits=[];
        }
        
        
        return view('inventory.purchase_inv_details',compact('purchases','purchase_items','payments','deposits'));
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
        $supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
        $name =Inventory::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
         $truck =Truck::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $data=PurchaseInventory::find($id);
        $items=PurchaseItemInventory::where('purchase_id',$id)->get();
         $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $type="";
        
        $pos_purchase= PurchaseInventory::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw(' ((purchase_amount + purchase_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= PurchaseInventory::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= PurchaseInventory::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->count();
         $unpaid= PurchaseInventory::where('added_by',auth()->user()->added_by)->where('status','1')->count();
         $part= PurchaseInventory::where('added_by',auth()->user()->added_by)->where('status','2')->count();
         $paid= PurchaseInventory::where('added_by',auth()->user()->added_by)->where('status','3')->count();
       return view('inventory.manage_purchase_inv',compact('name','supplier','currency','location','data','id','items','type','branch','user','truck',
       'pos_purchase','pos_due','total','unpaid','part','paid'));
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
            $purchase = PurchaseInventory::find($id);
            $data['supplier_id']=$request->supplier_id;
            $data['purchase_date']=$request->purchase_date;
            $data['due_date']=$request->due_date;
            $data['location']=$request->location;
            $data['exchange_code']=$request->exchange_code;
            $data['exchange_rate']=$request->exchange_rate;
            $data['purchase_amount']='1';
            $data['due_amount']='1';
             $data['status']='1';
            $data['purchase_tax']='1';
              $data['user_agent'] = $request->user_agent;
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

                     PurchaseInventory::where('id', $purchase->id)->update($t);
                }
            }
        }
    
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
                       
    
                        $items = array(
                            'item_name' => $nameArr[$i],
                            'truck_id' => $truckArr[$i],
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
                                PurchaseItemInventory::where('id',$expArr[$i])->update($items);  
          
          }
          else{
            PurchaseItemInventory::create($items);   
          }
                      
                 
         
  
                    }
                }
               
            }    
    
            
    
          
    
            $inv = PurchaseInventory::find($id);
            $supp=Supplier::find($inv->supplier_id);
            
                if ($inv->discount > 0) {
                $disc = AccountCodes::where('account_name', 'Purchase Discount')->where('added_by', auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $disc->id;
                $date = explode('-', $inv->purchase_date);
                $journal->date = $inv->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'inventory';
                $journal->name = 'Inventory Purchase';
                $journal->debit = $inv->discount * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->branch_id = $inv->branch_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Inventory Purchase Discount for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();

                $cr = AccountCodes::where('account_name', 'Inventory')
                    ->where('added_by', auth()->user()->added_by)
                    ->first();
                $journal = new JournalEntry();
                $journal->account_id = $cr->id;
                $date = explode('-', $inv->purchase_date);
                $journal->date = $inv->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'inventory';
                $journal->name = 'Inventory Purchase';
                $journal->credit = $inv->discount * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                 $journal->branch_id = $inv->branch_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Inventory Purchase Discount for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();
            }

            if ($inv->shipping_cost > 0) {
                $shp = AccountCodes::where('account_name', 'Shipping Cost')
                    ->where('added_by', auth()->user()->added_by)
                    ->first();
                $journal = new JournalEntry();
                $journal->account_id = $shp->id;
                $date = explode('-', $inv->purchase_date);
                $journal->date = $inv->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
               $journal->transaction_type = 'inventory';
                $journal->name = 'Inventory Purchase';
                $journal->debit = $inv->shipping_cost * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                 $journal->branch_id = $inv->branch_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Inventory Purchase Shipping Cost for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();

                $codes = AccountCodes::where('account_name', 'Payables')
                    ->where('added_by', auth()->user()->added_by)
                    ->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                $date = explode('-', $inv->purchase_date);
                $journal->date = $inv->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'inventory';
                $journal->name = 'Inventory Purchase';
                $journal->income_id = $inv->id;
                 $journal->branch_id = $inv->branch_id;
                $journal->credit = $inv->shipping_cost * $inv->exchange_rate;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Credit Inventory Shipping Cost for Purchase Order  ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();
            }
    
    
            return redirect(route('purchase_inventory.show',$id));
    

        }

        else{
        $purchase = PurchaseInventory::find($id);
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
          $data['user_agent'] = $request->user_agent;
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

                     PurchaseInventory::where('id', $purchase->id)->update($t);
                }
            }
        }

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
                   

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'truck_id' => $truckArr[$i],
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
                            PurchaseItemInventory::where('id',$expArr[$i])->update($items);  
      
      }
      else{
        PurchaseItemInventory::create($items);   
      }
                    
                }
            }
            
        }    

        

        return redirect(route('purchase_inventory.show',$id));

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
        PurchaseItemInventory::where('purchase_id', $id)->delete();
        InventoryPayment::where('purchase_id', $id)->delete();
        InventoryHistory::where('purchase_id', $id)->delete();
        $purchases = PurchaseInventory::find($id);
        $purchases->delete();
        return redirect(route('purchase_inventory.index'))->with(['success'=>'Deleted Successfully']);
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
                      $data=InventoryList::find($id);
                    return view('inventory.addreference',compact('id','data'));
      }
                elseif($type == 'maintainance'){
                     $name = ServiceType::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();     
                    return view('inventory.addmaintainance',compact('id','name','type'));
      }
       elseif($type == 'service'){
                     $name = ServiceType::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();     
                    return view('inventory.addmaintainance',compact('id','name','type'));
      }
        elseif($type == 'mechanical_maintainance'){
                    $item =  MechanicalItem::where('module_id',$id)->where('module','maintainance')->where('added_by',auth()->user()->added_by)->get(); 
                   $notes =   MechanicalRecommedation::where('module_id',$id)->where('module','maintainance')->where('added_by',auth()->user()->added_by)->get();   
                    return view('inventory.viewreport',compact('id','item','type','notes'));
      }
   elseif($type == 'mechanical_service'){
                    $item =  MechanicalItem::where('module_id',$id)->where('module','service')->where('added_by',auth()->user()->added_by)->get(); 
                   $notes =   MechanicalRecommedation::where('module_id',$id)->where('module','service')->where('added_by',auth()->user()->added_by)->get();   
                    return view('inventory.viewreport',compact('id','item','type','notes'));
      }
 
  elseif($type == 'location'){
                      $data =  Location::find($id);  
                    $item =  LocationManager::where('location_id',$id)->where('added_by',auth()->user()->added_by)->get();  
                    return view('inventory.location_manager',compact('id','item','data'));
      }
      elseif($type == 'supplier'){
                return view('pos.purchases.supplier_modal');

      }
      
      elseif($type == 'receive'){
        $purchases = PurchaseInventory::find($id);
        $purchase_items =  PurchaseItemInventory::where('purchase_id', $id)->where('due_quantity', '>', '0')->get();
        
         $name = Inventory::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
         
         
                
        return view('inventory.item_details', compact('purchases', 'purchase_items', 'id', 'name'));

      }
      
       elseif($type == 'purchase'){
        $items =  ServiceInventory::where('service_id', $id)->get();
        $data = Service::find($id);
        $currency= Currency::all();
        $supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
        $name =Inventory::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
      
                
        return view('inventory.purchase_order', compact('name','supplier','currency','location','branch','user', 'items', 'id', 'data'));

      }
      
      
     elseif($type == 'edit'){
                  $item = Inventory::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
                  $truck = Truck::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
                  $name=$request->item_name[0];
                  $truck_id=$request->truck_id[0];
                  $qty=$request->quantity[0];
                  $price=str_replace(",","",$request->price[0]) ;
                  $cost=$request->total_cost[0];
                  $tax=$request->total_tax[0];
                  $unit=$request->unit[0];
                  $rate=$request->tax_rate[0];
                  $order=$request->no[0];
                  if(!empty($request->saved_items_id[0])){
                  $saved=$request->saved_items_id[0];
                  }
                  else{
                   $saved='';   
                  }
                  
                return view('inventory.edit_modal', compact('item','name','qty','price','cost','tax','unit','rate','order','type','saved','truck','truck_id'));
     }
     
     
      
                 }
                 
                 
                 
      public function add_item(Request $request)
    {
        //dd($request->all());

       $data=$request->all();
       
       
        
          $list = '';
          $list1 = ''; 
          
           $it=Inventory::where('id',$request->checked_item_name)->first();
                $a =  $it->name ; 
                
          $t=Truck::where('id',$request->checked_truck_id)->first();
          if(!empty($t)){
                $b =  $t->truck_name.'-'.$t->reg_no ; 
          }
          else{
           $b =  '' ;     
          }
          
          $name=$request->checked_item_name[0];
          $truck=$request->checked_truck_id[0];
          $qty=$request->checked_quantity[0];
          $price=str_replace(",","",$request->checked_price[0]);
          
          
          $order=$request->checked_no[0];
          $unit=$request->checked_unit[0];
          $rate=$request->checked_tax_rate[0];
          
          if($rate == '0'){
             $r='Inclusive';
             $sub=(($qty * $price)/1.18);
             $tax=($qty * $price) - $sub;
             $cost=$qty * $price;
             
          }
         else if($rate == '0.18'){
              $r='Exclusive';
              $sub=$qty * $price;
              $tax=($qty * $price) * 0.18;
              $cost=($qty * $price) + $tax;

          }
          
          if(!empty($request->saved_items_id[0])){
            $saved=$request->saved_items_id[0];
            }
            else{
            $saved='';   
                  }
          
          if(!empty($request->type) && $request->type == 'edit'){
            $list .= '<td>'.$a.'<br>'.$b.'</td>';
            $list .= '<td>'.number_format($qty,2).'</td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$r.'</td>';
            $list .= '<td>'.number_format($tax,2).'</td>';
            $list .= '<td>'.number_format($cost,2).'</td>';
            
             if(!empty($saved)){
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger rem" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '" value="'.$saved.'"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
                }
            else{
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            }
            
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_qty" id="qty lst'.$order.'"  value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="sub[]" class="form-control item_sub" id="sub lst'.$order.'"  value="'.$sub.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="truck_id[]" class="form-control item_truck" id="truck lst'.$order.'"  value="'.$truck.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            
            if(!empty($saved)){
            $list1 .= '<input type="hidden" name="saved_items_id[]" class="form-control item_saved'.$order.'" value="'.$saved.'"  required/>';
                }
          }
            else{
            $list .= '<tr class="trlst'.$order.'">';
            $list .= '<td>'.$a.'<br>'.$b.'</td>';
            $list .= '<td>'.number_format($qty,2).'</td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$r.'</td>';
            $list .= '<td>'.number_format($tax,2).'</td>';
            $list .= '<td>'.number_format($cost,2).'</td>';
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            $list .= '</tr>';
                    
            $list1 .= '<div class="line_items" id="lst'.$order.'">';
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_qty" id="qty lst'.$order.'"  value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="sub[]" class="form-control item_sub" id="sub lst'.$order.'"  value="'.$sub.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="truck_id[]" class="form-control item_truck" id="truck lst'.$order.'"  value="'.$truck.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
             $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            $list1 .= '</div>';
            }


             return response()->json([
            'list'          => $list,
            'list1' => $list1
    ]);
        
    }           

           public function save_reference (Request $request){
                     //
                    
                     $inv=   InventoryList::find($request->id);
                     $data['reference']=$request->reference;
                     $data['serial_no']=$request->reference;
                     $data['assign_reference']='1';
                     $inv->update($data);
                     
                      //dd($inv);

                     return redirect(route('inventory.list'))->with(['success'=>'Inventory Reference Assigned Successfully']);
                 }


    public function approve($id)
    {
        //
        $purchase = PurchaseInventory::find($id);
        $data['status'] = 1;
        $purchase->update($data);
        return redirect(route('purchase_inventory.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $purchase = PurchaseInventory::find($id);
        $data['status'] = 4;
        $data['rejected_by']= auth()->user()->id;
        $purchase->update($data);
        return redirect(route('purchase_inventory.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
         $supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
        $name =Inventory::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
         $truck =Truck::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
         $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $data=PurchaseInventory::find($id);
        $items=PurchaseItemInventory::where('purchase_id',$id)->get();
        $type="receive";
         $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        
        $pos_purchase= PurchaseInventory::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw(' ((purchase_amount + purchase_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= PurchaseInventory::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= PurchaseInventory::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->count();
         $unpaid= PurchaseInventory::where('added_by',auth()->user()->added_by)->where('status','1')->count();
         $part= PurchaseInventory::where('added_by',auth()->user()->added_by)->where('status','2')->count();
         $paid= PurchaseInventory::where('added_by',auth()->user()->added_by)->where('status','3')->count();
       return view('inventory.manage_purchase_inv',compact('name','supplier','currency','location','data','id','items','type','branch','user','truck',
       'pos_purchase','pos_due','total','unpaid','part','paid'));
    }

public function grn(Request $request)
    {
        //
        $id = $request->purchase_id;
        $nameArr = $request->items_id;
        $priceArr = $request->price;
        $qtyArr = $request->quantity;
        $recArr = $request->receive_date;
        $savedArr = $request->items_id;

        $purchase = PurchaseInventory::find($id);

        if (!empty($nameArr)) {
            for ($i = 0; $i < count($nameArr); $i++) {
                if (!empty($nameArr[$i])) {
                    $saved = Inventory::find($savedArr[$i]);

                    $lists = [
                        'quantity' => $qtyArr[$i],
                        'price' => $priceArr[$i],
                        'item_id' => $savedArr[$i],
                         'user_id' => auth()->user()->id,
                        'added_by' => auth()->user()->added_by,
                        'supplier_id' => $purchase->supplier_id,
                        'location' => $purchase->location,
                        'purchase_date' => $recArr[$i],
                        'type' => 'Purchases',
                        'purchase_id' => $id,
                    ];

                   InventoryHistory::create($lists);
                   
                   
                   $mlists = [
                        'in' => $qtyArr[$i],
                        'price' => $priceArr[$i],
                        'item_id' => $savedArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'supplier_id' => $purchase->supplier_id,
                        'location' => $purchase->location,
                        'date' =>$recArr[$i],
                        'type' => 'Purchases',
                        'purchase_id' => $id,
                    ];

                     MasterHistory::create($mlists);


                    $it = Inventory::where('id', $nameArr[$i])->first();
                    $q = $it->quantity + $qtyArr[$i];
                    Inventory::where('id', $nameArr[$i])->update(['quantity' => $q]);

                    $loc = Location::where('id', $purchase->location)->first();
                    $lq['quantity'] = $loc->quantity + $qtyArr[$i];
                    Location::where('id', $purchase->location)->update($lq);

                    $random = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4 / strlen($x)))), 1, 4);
                    //dd(1);
                    
                   
                   
                    if (!empty($qtyArr[$i])) {
                        for ($x = 1; $x <= $qtyArr[$i]; $x++) {
                            $name = Inventory::where('id', $savedArr[$i])->first();

                          $words = preg_split("/\s+/", $name->name);
                          $acronym = "";
                            
                           foreach ($words as $w) {
                              $acronym .= mb_substr($w, 0, 1);
                            }
                            $a=strtoupper($acronym);
                           

                            $series = [
                                'serial_no' =>  $a.$random.$x,
                                'brand_id' => $savedArr[$i],
                                'added_by' => auth()->user()->added_by,
                                'purchase_id' => $id,
                                'location' => $purchase->location,
                                'purchase_date' => $recArr[$i],
                                'quantity' => 1,
                                'due_quantity' => 1,
                                'source_store' => $purchase->location,
                                'status' => '0',
                            ];
                            
                            //dd($series);

                            InventoryList::create($series);
                        }
                    }
                    
                      



                    $inv = PurchaseInventory::find($id);
                    $supp = Supplier::find($inv->supplier_id);

                    $itm = PurchaseItemInventory::where('purchase_id', $id)->where('item_name', $savedArr[$i])->first();
                    $acc = Inventory::find($savedArr[$i]);

                    $tax = $itm->price * $qtyArr[$i] * $itm->tax_rate;
                    $cost = $itm->price * $qtyArr[$i];

                    $cr = AccountCodes::where('account_name', 'Inventory')
                        ->where('added_by', auth()->user()->added_by)
                        ->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                      $date = explode('-', $recArr[$i]);
                    $journal->date = $recArr[$i];
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'inventory';
                    $journal->name = 'Inventory Purchase';
                    $journal->debit = $cost * $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->supplier_id = $inv->supplier_id;
                     $journal->branch_id = $inv->branch_id;
                    $journal->currency_code = $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Inventory Purchase for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();

                    if ($tax > 0) {
                        $vat = AccountCodes::where('account_name', 'VAT IN')
                            ->where('added_by', auth()->user()->added_by)
                            ->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $vat->id;
                         $date = explode('-', $recArr[$i]);
                    $journal->date = $recArr[$i];
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'inventory';
                        $journal->name = 'Inventory Purchase';
                        $journal->debit = $tax * $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->supplier_id = $inv->supplier_id;
                         $journal->branch_id = $inv->branch_id;
                        $journal->currency_code = $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = 'Inventory Purchase Tax for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                        $journal->save();
                    }

                    $codes = AccountCodes::where('account_name', 'Payables')
                        ->where('added_by', auth()->user()->added_by)
                        ->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                     $date = explode('-', $recArr[$i]);
                    $journal->date = $recArr[$i];
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'inventory';
                    $journal->name = 'Inventory Purchase';
                    $journal->income_id = $inv->id;
                    $journal->supplier_id = $inv->supplier_id;
                     $journal->branch_id = $inv->branch_id;
                    $journal->credit = ($cost + $tax) * $inv->exchange_rate;
                    $journal->currency_code = $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Credit for Inventory Purchase Order  ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();
                }
            }

           

            return redirect(route('purchase_inventory.index'))->with(['success' => 'Good Receive Done Successfully']);
        } else {
            return redirect(route('purchase_inventory.index'))->with(['error' => 'No data found']);
        }
    }

    public function issue($id)
    {
        //
        $purchase = PurchaseInventory::find($id);
        $data['good_receive'] = 1;
        $purchase->update($data);

       
        
         $codes = AccountCodes::where('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->first();
         $supp = Supplier::find($purchase->supplier_id);
         $cr = AccountCodes::where('account_name', 'GRN Control')->where('added_by', auth()->user()->added_by)->first();
         $a=JournalEntry::where('account_id',$codes->id)->where('transaction_type','inventory')->where('income_id',$id)->where('added_by', auth()->user()->added_by)->sum('credit');
         $grn=$a/$purchase->exchange_rate;
         $tt=InventoryPayment::where('purchase_id',$id)->sum('amount');
         
         if($tt > $grn){
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', date('Y-m-d'));
                    $journal->date = date('Y-m-d');
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'inventory_issue_supplier';
                    $journal->name = 'Inventory Purchase';
                    $journal->income_id = $id;
                    $journal->supplier_id = $purchase->supplier_id;
                     $journal->branch_id =$purchase->branch_id;
                    $journal->debit = ($tt - $grn ) * $purchase->exchange_rate;
                    $journal->currency_code = $purchase->exchange_code;
                    $journal->exchange_rate = $purchase->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Credit for Issued Inventory Purchase Order  ' . $purchase->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();
                    
                    
                     $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', date('Y-m-d'));
                    $journal->date = date('Y-m-d');
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'inventory_issue_supplier';
                   $journal->name = 'Inventory Purchase';
                    $journal->income_id = $id;
                    $journal->supplier_id = $purchase->supplier_id;
                     $journal->branch_id =$purchase->branch_id;
                    $journal->credit = ($tt - $grn ) * $purchase->exchange_rate;
                    $journal->currency_code =  $purchase->exchange_code;
                    $journal->exchange_rate =  $purchase->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Credit for Issued Inventory Purchase Order  ' . $purchase->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();
                    
         }
         
         
         

        return redirect(route('purchase_inventory.index'))->with(['success' => 'Issued Successfully']);
    }


  public function inventory_list()
    {
        //
        $tyre= InventoryList::where('added_by',auth()->user()->added_by)->get();
       return view('inventory.list',compact('tyre'));
    }
    public function make_payment($id)
    {
        //
        $invoice = PurchaseInventory::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get() ;
        return view('inventory.inventory_payment',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function inv_pdfview(Request $request)
    {
        //
        $purchases = PurchaseInventory::find($request->id);
        $purchase_items=PurchaseItemInventory::where('purchase_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('inventory.purchase_inv_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('PURCHASE_INVENTORY REF NO # ' .  $purchases->reference_no . ".pdf");
        }
        return view('inv_pdfview');
    }
    
     public function inv_issue_pdfview(Request $request)
    {
        //
        $purchases = PurchaseInventory::find($request->id);
        $purchase_items=PurchaseItemInventory::where('purchase_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['purchases' => $purchases, 'purchase_items' => $purchase_items]);

        if ($request->has('download')) {
            $pdf = PDF::loadView('inventory.issue_supplier_pdf')->setPaper('a4', 'potrait');
            return $pdf->download('ISSUED PURCHASES REF NO # ' . $purchases->reference_no . '.pdf');
        }
        return view('inv_issue_pdfview');
    }
}
