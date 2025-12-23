<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\Service;
use App\Models\User;
use App\Models\ServiceInventory;
use App\Models\ServiceItem;
use App\Models\ServiceType;
use App\Models\Truck;
use Illuminate\Http\Request;
use App\Models\JournalEntry;
use App\Models\AccountCodes;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\PurchaseInventory;
use App\Models\PurchaseItemInventory;
use App\Models\Supplier;
use App\Models\InventoryList;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $service=Service::where('added_by',auth()->user()->added_by)->get();
        $truck = Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get(); 
       $staff=FieldStaff::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
       //$staff=User::where('id','!=','1')->get();  
       $i_name = Inventory::where('added_by',auth()->user()->added_by)->get();
      $name =ServiceType::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
       return view('inventory.service',compact('service','truck','staff','i_name','name'));
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
        $data['date']=$request->date;
        $data['truck']=$request->truck;    
        $data['reading']=$request->reading;
        $data['mechanical']=$request->mechanical;
        $data['history']=$request->history;
        $data['major']=$request->major;
        $data['status']='0';

        $driver=Truck::where('id',$request->truck)->first();
        $data['driver']=$driver->driver;
        $data['added_by']= auth()->user()->added_by;
        $data['truck_name']=$driver->truck_name;
       $data['reg_no']=$driver->reg_no;
        $service = Service::create($data);
        
       

        $nameArr =$request->minor ;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'minor' => $nameArr[$i],
                        'truck' =>    $data['truck'],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'service_id' =>$service->id);
                       
                    ServiceItem::create($items);  ;
    
    
                }
            }
           
        }   


 $itemArr =$request->item_name ;
    $qtyArr =$request->quantity ;
  
        if(!empty($itemArr)){
            for($i = 0; $i < count($itemArr); $i++){
                if(!empty($itemArr[$i])){

                    $report = array(
                        'item_name' => $itemArr[$i],
                          'quantity' => $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'service_id' =>$service->id);
                       
                   ServiceInventory::create($report);  ;
    
    
                }
            }
           
        }     

        return redirect(route('service.index'))->with(['success'=>'Service Created Successfully']);
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
        $data=Service::find($id);
        $items=ServiceItem::where('service_id',$id)->get();
       $inv=ServiceInventory::where('service_id',$id)->get();
        $truck = Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get(); 
       $staff=FieldStaff::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
       //$staff=User::where('id','!=','1')->get();  
       $i_name = Inventory::where('added_by',auth()->user()->added_by)->get();
      $name =ServiceType::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
       return view('inventory.service',compact('data','truck','staff','id','items','i_name','inv','name'));
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
        $service =  Service::find($id);

        $data['date']=$request->date;
        $data['truck']=$request->truck;    
        $data['reading']=$request->reading;
        $data['mechanical']=$request->mechanical;
        $data['history']=$request->history;
        $data['major']=$request->major;

        $driver=Truck::where('id',$request->truck)->first();
        $data['driver']=$driver->driver;
        $data['added_by']= auth()->user()->added_by;
        $data['truck_name']=$driver->truck_name;
        $data['reg_no']=$driver->reg_no;
        $service->update($data);
             

        $nameArr =$request->minor ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                ServiceItem::where('id',$remArr[$i])->delete();        
                   }
               }
           }


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'minor' => $nameArr[$i],
                        'truck' =>    $data['truck'],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'service_id' =>$id);
                       
                        if(!empty($expArr[$i])){
                            ServiceItem::where('id',$expArr[$i])->update($items);  
      
      }
      else{
        ServiceItem::create($items);     
      }
                   
    
    
                }
            }
           
        }    


 $itemArr =$request->item_name ;
$qtyArr =$request->quantity ;
   $invremArr = $request->removed_inv_id ;
        $invexpArr = $request->saved_inv_id ;

        if (!empty($invremArr)) {
            for($i = 0; $i < count($invremArr); $i++){
               if(!empty($invremArr[$i])){        
                ServiceInventory::where('id',$invremArr[$i])->delete();        
                   }
               }
           }

        if(!empty($itemArr)){
            for($i = 0; $i < count($itemArr); $i++){
                if(!empty($itemArr[$i])){

                    $report = array(
                        'item_name' => $itemArr[$i],
                           'quantity' => $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'service_id' =>$id);

                    if(!empty($invexpArr[$i])){
                            ServiceInventory::where('id',$invexpArr[$i])->update($report);  
      
      }
      else{
     ServiceInventory::create($report);  ; 
      }
                       
                  
    
    
                }
            }
           
        }     

        return redirect(route('service.index'))->with(['success'=>'Service Updated Successfully']);
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
        ServiceItem::where('service_id', $id)->delete();
        ServiceInventory::where('service_id', $id)->delete();

        $service =  Service::find($id);
        $service->delete();

 
        return redirect(route('service.index'))->with(['success'=>'Service Deleted Successfully']);
    }

    public function approve($id)
    {
        //
        $service =  Service::find($id);
        $data['status'] = 1;
        $service->update($data);

       $inventory=ServiceInventory::where('service_id',$id)->get();
     foreach($inventory as $inv){
     $list=Inventory::find($inv->item_name);
      $q=$list->quantity -$inv->quantity;
    Inventory::where('id',$inv->item_name)->update(['quantity' => $q]);
}
        return redirect(route('service.index'))->with(['success'=>'Service Completed Successfully']);
    }
    
    
     public function save_purchase(Request $request)
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
        $data['status']='1';
        $data['good_receive']='0';
        $data['branch_id'] = $request->branch_id;
        $data['user_agent'] = $request->user_agent;
        $data['user_id'] = auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $purchase = PurchaseInventory::create($data);
        
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
        
        
         $inv = PurchaseInventory::find($purchase->id);
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
                $journal->credit = $inv->shipping_cost * $inv->exchange_rate;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Credit Inventory Shipping Cost for Purchase Order  ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();
            }

        
         return redirect(route('service.index'))->with(['success'=>'Purchase Order Created Successfully']);
        
    }



}
