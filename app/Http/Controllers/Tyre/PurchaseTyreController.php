<?php

namespace App\Http\Controllers\Tyre;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Branch;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
use App\Models\Supplier;
use App\Models\Truck;
use App\Models\Tyre\PurchaseItemTyre;
use App\Models\Tyre\PurchaseTyre;
use App\Models\Tyre\Tyre;
use App\Models\Tyre\TruckTyre;
use App\Models\Tyre\TyreAssignment;
use App\Models\Tyre\TyreActivity;
use App\Models\Tyre\TyreBrand;
use App\Models\Tyre\TyreHistory;
use App\Models\Tyre\MasterHistory;
use App\Models\Tyre\TyrePayment;
use App\Models\Tyre\TyreReturn;
use App\Models\Tyre\TyreReturnItems;
use App\Models\Tyre\TyreReallocationItems;
use App\Models\Tyre\TyreDisposalItems;
use Illuminate\Http\Request;
use PDF;
use DB;

class PurchaseTyreController extends Controller
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
        $purchases=PurchaseTyre::where('added_by',auth()->user()->added_by)->get();
        $supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
        $name = TyreBrand::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
         $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $type="";
        
        
        $pos_purchase= PurchaseTyre::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw(' ((purchase_amount + purchase_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= PurchaseTyre::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= PurchaseTyre::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->count();
         $unpaid= PurchaseTyre::where('added_by',auth()->user()->added_by)->where('status','1')->count();
         $part= PurchaseTyre::where('added_by',auth()->user()->added_by)->where('status','2')->count();
         $paid= PurchaseTyre::where('added_by',auth()->user()->added_by)->where('status','3')->count();
       return view('tyre.manage_purchase_tyre',compact('name','supplier','currency','purchases','location','type','branch','user',
       'pos_purchase','pos_due','total','unpaid','part','paid'));
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
       $count =  PurchaseTyre::where('added_by', auth()->user()->added_by)->count();
        $pro = $count + 1;
        $data['reference_no'] = 'PT0' . $pro;
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

        $purchase = PurchaseTyre::create($data);
        
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

                    PurchaseTyre::where('id', $purchase->id)->update($t);
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
                       
                     PurchaseItemTyre::create($items);  ;
    
    
                }
            }
            
           
        }    

        if(!empty($purchase)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$purchase->id,
                    'module'=>'Purchase',
                    'activity'=>"Purchase Created",
                   'date'=>$request->purchase_date,
                ]
                );                      
}
        
        return redirect(route('purchase_tyre.show',$purchase->id));
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
        $purchases = PurchaseTyre::find($id);
        $purchase_items=PurchaseItemTyre::where('purchase_id',$id)->where('due_quantity','>', '0')->get();
        $payments=TyrePayment::where('purchase_id',$id)->get();
        
          $dn=AccountCodes::where('account_name','Debit Note Control')->where('added_by',auth()->user()->added_by)->first();
        if(!empty($dn)){
        
         $added_by = auth()->user()->added_by;
        
       $a = "SELECT tyre_return_purchases.reference_no,tyre_return_purchases.return_date,journal_entries.credit,tyre_return_purchases.bank_id,journal_entries.id FROM tyre_return_purchases INNER JOIN journal_entries ON tyre_return_purchases.id=journal_entries.income_id 
        INNER JOIN purchase_tyres ON tyre_return_purchases.purchase_id = purchase_tyres.id WHERE tyre_return_purchases.added_by = '".$added_by."' AND purchase_tyres.id = '".$id."' AND journal_entries.account_id = '".$dn->id."' AND journal_entries.transaction_type = 'tyre_debit_note' ";
        
        $deposits = DB::select($a);
        }
        
        else{
            $deposits=[];
        }
        
        
        return view('tyre.purchase_tyre_details',compact('purchases','purchase_items','payments','deposits'));
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
        $data=PurchaseTyre::find($id);
        $items=PurchaseItemTyre::where('purchase_id',$id)->get();
        
         $supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
        $name = TyreBrand::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
         $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $type="";
        
        
        $pos_purchase= PurchaseTyre::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw(' ((purchase_amount + purchase_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= PurchaseTyre::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= PurchaseTyre::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->count();
         $unpaid= PurchaseTyre::where('added_by',auth()->user()->added_by)->where('status','1')->count();
         $part= PurchaseTyre::where('added_by',auth()->user()->added_by)->where('status','2')->count();
         $paid= PurchaseTyre::where('added_by',auth()->user()->added_by)->where('status','3')->count();
        
        $type="";
       return view('tyre.manage_purchase_tyre',compact('name','supplier','currency','location','type','data','id','items','branch','user',
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
            $purchase = PurchaseTyre::find($id);
            $data['supplier_id']=$request->supplier_id;
            $data['purchase_date']=$request->purchase_date;
            $data['due_date']=$request->due_date;
            $data['location']=$request->location;
            $data['exchange_code']=$request->exchange_code;
            $data['exchange_rate']=$request->exchange_rate;
              $data['status']='1';
            $data['purchase_amount']='1';
            $data['due_amount']='1';
            $data['purchase_tax']='1';
             $data['user_agent'] = $request->user_agent;
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

                     PurchaseTyre::where('id', $purchase->id)->update($t);
                }
            }
        }
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    PurchaseItemTyre::where('id',$remArr[$i])->delete();        
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
                            'purchase_id' =>$id);
                           
                            if(!empty($expArr[$i])){
                               PurchaseItemTyre::where('id',$expArr[$i])->update($items);  
          
          }
          else{
            PurchaseItemTyre::create($items);   
          }

          
                    }
                }
                
            }    
    
            
    
    
            if(!empty($purchase)){
                $activity = TyreActivity::create(
                    [ 
                        'added_by'=>auth()->user()->added_by,
                        'module_id'=>$id,
                        'module'=>'Purchase',
                        'activity'=>"Purchase Updated to Good Receive",
                       'date'=>$request->purchase_date,
                    ]
                    );                      
    }


    $inv = PurchaseTyre::find($id);
            $supp=Supplier::find($inv->supplier_id);
            
                if ($inv->discount > 0) {
                $disc = AccountCodes::where('account_name', 'Purchase Discount')->where('added_by', auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $disc->id;
                $date = explode('-', $inv->purchase_date);
                $journal->date = $inv->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'tire';
                $journal->name = 'Tire Purchase';
                $journal->debit = $inv->discount * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->branch_id = $inv->branch_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Tire Purchase Discount for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
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
                $journal->transaction_type = 'tire';
                $journal->name = 'Tire Purchase';
                $journal->credit = $inv->discount * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                 $journal->branch_id = $inv->branch_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Tire Purchase Discount for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
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
               $journal->transaction_type = 'tire';
                $journal->name = 'Tire Purchase';
                $journal->debit = $inv->shipping_cost * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                 $journal->branch_id = $inv->branch_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Tire Purchase Shipping Cost for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
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
                $journal->transaction_type = 'tire';
                $journal->name = 'Tire Purchase';
                $journal->income_id = $inv->id;
                 $journal->branch_id = $inv->branch_id;
                $journal->credit = $inv->shipping_cost * $inv->exchange_rate;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Credit Tire Shipping Cost for Purchase Order  ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();
            }

            return redirect(route('purchase_tyre.show',$id));
    

        }

        else{
       $purchase = PurchaseTyre::find($id);
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

                     PurchaseTyre::where('id', $purchase->id)->update($t);
                }
            }
        }
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    PurchaseItemTyre::where('id',$remArr[$i])->delete();        
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
                            'purchase_id' =>$id);
                           
                            if(!empty($expArr[$i])){
                               PurchaseItemTyre::where('id',$expArr[$i])->update($items);  
          
          }
          else{
            PurchaseItemTyre::create($items);   
          }

          
                    }
                }
                
            }    
    
            
    
    
            if(!empty($purchase)){
                $activity = TyreActivity::create(
                    [ 
                        'added_by'=>auth()->user()->added_by,
                        'module_id'=>$id,
                        'module'=>'Purchase',
                        'activity'=>"Purchase Updated",
                       'date'=>$request->purchase_date,
                    ]
                    );                      
    }


            
        return redirect(route('purchase_tyre.show',$id));

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
        PurchaseItemTyre::where('purchase_id', $id)->delete();
        TyrePayment::where('purchase_id', $id)->delete();
        TyreHistory::where('purchase_id', $id)->delete();
        $purchases = PurchaseTyre::find($id);

        if(!empty($purchases)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$id,
                    'module'=>'Purchase',
                    'activity'=>"Purchase Deleted",
                   'date'=>date('Y-m-d'),
                ]
                );                      
}

        $purchases->delete();
        return redirect(route('purchase_tyre.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= TyreBrand::where('id',$request->id)->get();
                return response()->json($price);                      

    }

    public function approve($id)
    {
        //
        $purchase = PurchaseTyre::find($id);
        $data['status'] = 1;
        $purchase->update($data);

        if(!empty($purchase)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$id,
                    'module'=>'Purchase',
                    'activity'=>"Purchase Approved",
                    'date'=>date('Y-m-d'),
                ]
                );                      
}
        return redirect(route('purchase_tyre.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $purchase = PurchaseTyre::find($id);
        $data['status'] = 4;
        $purchase->update($data);

        if(!empty($purchase)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$id,
                    'module'=>'Purchase',
                    'activity'=>"Purchase Cancelled",
                    'date'=>date('Y-m-d'),
                ]
                );                      
}
        return redirect(route('purchase_tyre.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $data=PurchaseTyre::find($id);
        $items=PurchaseItemTyre::where('purchase_id',$id)->get();
        
         $supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
        $name = TyreBrand::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
         $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
 
        $pos_purchase= PurchaseTyre::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw(' ((purchase_amount + purchase_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= PurchaseTyre::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= PurchaseTyre::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->count();
         $unpaid= PurchaseTyre::where('added_by',auth()->user()->added_by)->where('status','1')->count();
         $part= PurchaseTyre::where('added_by',auth()->user()->added_by)->where('status','2')->count();
         $paid= PurchaseTyre::where('added_by',auth()->user()->added_by)->where('status','3')->count();
        $type="receive";
       return view('tyre.manage_purchase_tyre',compact('name','supplier','currency','location','type','data','id','items','branch','user',
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

        $purchase = PurchaseTyre::find($id);

        if (!empty($nameArr)) {
            for ($i = 0; $i < count($nameArr); $i++) {
                if (!empty($nameArr[$i])) {
                    $saved = TyreBrand::find($savedArr[$i]);

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

                   TyreHistory::create($lists);
                   
                   
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


                    $it = TyreBrand::where('id', $nameArr[$i])->first();
                    $q = $it->quantity + $qtyArr[$i];
                    TyreBrand::where('id', $nameArr[$i])->update(['quantity' => $q]);

                    $loc = Location::where('id', $purchase->location)->first();
                    $lq['quantity'] = $loc->quantity + $qtyArr[$i];
                    Location::where('id', $purchase->location)->update($lq);

                    $random = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4 / strlen($x)))), 1, 4);
                    //dd(1);
                    
                   
                   
                    if (!empty($qtyArr[$i])) {
                        for ($x = 1; $x <= $qtyArr[$i]; $x++) {
                            $name = TyreBrand::where('id', $savedArr[$i])->first();

                          $words = preg_split("/\s+/", $name->brand);
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

                            Tyre::create($series);
                        }
                    }
                    
                      



                    $inv = PurchaseTyre::find($id);
                    $supp = Supplier::find($inv->supplier_id);

                    $itm = PurchaseItemTyre::where('purchase_id', $id)->where('item_name', $savedArr[$i])->first();
                    $acc = TyreBrand::find($savedArr[$i]);

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
                    $journal->transaction_type = 'tire';
                    $journal->name = 'Tire Purchase';
                    $journal->debit = $cost * $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->supplier_id = $inv->supplier_id;
                     $journal->branch_id = $inv->branch_id;
                    $journal->currency_code = $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Tire Purchase for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
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
                       $journal->transaction_type = 'tire';
                    $journal->name = 'Tire Purchase';
                        $journal->debit = $tax * $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->supplier_id = $inv->supplier_id;
                         $journal->branch_id = $inv->branch_id;
                        $journal->currency_code = $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = 'Tire Purchase Tax for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
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
                    $journal->transaction_type = 'tire';
                    $journal->name = 'Tire Purchase';
                    $journal->income_id = $inv->id;
                    $journal->supplier_id = $inv->supplier_id;
                     $journal->branch_id = $inv->branch_id;
                    $journal->credit = ($cost + $tax) * $inv->exchange_rate;
                    $journal->currency_code = $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Credit for Tire Purchase Order  ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();
                }
            }

           

            return redirect(route('purchase_tyre.index'))->with(['success' => 'Good Receive Done Successfully']);
        } else {
            return redirect(route('purchase_tyre.index'))->with(['error' => 'No data found']);
        }
    }

    public function issue($id)
    {
        //
        $purchase = PurchaseTyre::find($id);
        $data['good_receive'] = 1;
        $purchase->update($data);

       
        
         $codes = AccountCodes::where('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->first();
         $supp = Supplier::find($purchase->supplier_id);
         $cr = AccountCodes::where('account_name', 'GRN Control')->where('added_by', auth()->user()->added_by)->first();
         $a=JournalEntry::where('account_id',$codes->id)->where('transaction_type','inventory')->where('income_id',$id)->where('added_by', auth()->user()->added_by)->sum('credit');
         $grn=$a/$purchase->exchange_rate;
         $tt=TyrePayment::where('purchase_id',$id)->sum('amount');
         
         if($tt > $grn){
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', date('Y-m-d'));
                    $journal->date = date('Y-m-d');
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'tire_issue_supplier';
                    $journal->name = 'Tire Purchase';
                    $journal->income_id = $id;
                    $journal->supplier_id = $purchase->supplier_id;
                     $journal->branch_id =$purchase->branch_id;
                    $journal->debit = ($tt - $grn ) * $purchase->exchange_rate;
                    $journal->currency_code = $purchase->exchange_code;
                    $journal->exchange_rate = $purchase->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Credit for Issued Tire Purchase Order  ' . $purchase->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();
                    
                    
                     $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', date('Y-m-d'));
                    $journal->date = date('Y-m-d');
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'tire_issue_supplier';
                   $journal->name = 'Tire Purchase';
                    $journal->income_id = $id;
                    $journal->supplier_id = $purchase->supplier_id;
                     $journal->branch_id =$purchase->branch_id;
                    $journal->credit = ($tt - $grn ) * $purchase->exchange_rate;
                    $journal->currency_code =  $purchase->exchange_code;
                    $journal->exchange_rate =  $purchase->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Credit for Issued Tire Purchase Order  ' . $purchase->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();
                    
         }
         
         
         

        return redirect(route('purchase_tyre.index'))->with(['success' => 'Issued Successfully']);
    }


    public function make_payment($id)
    {
        //
        $invoice = PurchaseTyre::find($id);
        $payment_method = Payment_methodes::all();
      $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get() ;
        return view('tyre.tyre_payment',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function tyre_pdfview(Request $request)
    {
        //
        $purchases = PurchaseTyre::find($request->id);
        $purchase_items=PurchaseItemTyre::where('purchase_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('tyre.purchase_tyre_pdf')->setPaper('a4', 'potrait');
     return $pdf->download('PURCHASE_TIRE REF NO # ' .  $purchases->reference_no . ".pdf");
   

        }
        return view('tyre_pdfview');
    }
    
    
    public function inv_issue_pdfview(Request $request)
    {
        //
        $purchases = PurchaseTyre::find($request->id);
        $purchase_items=PurchaseItemTyre::where('purchase_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['purchases' => $purchases, 'purchase_items' => $purchase_items]);

        if ($request->has('download')) {
            $pdf = PDF::loadView('tyre.issue_supplier_pdf')->setPaper('a4', 'potrait');
            return $pdf->download('ISSUED PURCHASES REF NO # ' . $purchases->reference_no . '.pdf');
        }
        return view('inv_issue_pdfview');
    }
    
    
    public function grn_pdfview(Request $request)
    {
        //
        $purchases = PurchaseHistory::find($request->id);
        //$purchase_items = PurchaseItems::where('purchase_id', $request->id)->where('due_quantity','>', '0')->get();

        view()->share(['purchases' => $purchases]);

        if ($request->has('download')) {
            $pdf = PDF::loadView('pos.purchases.grn_pdf')->setPaper('a4', 'potrait');
            return $pdf->download('GOOD RECEIVE.pdf');
        }
        return view('grn_pdfview');
    }




    public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
                 if($type == 'refill'){
                    return view('tyre.addtyre',compact('id'));
                
                 }elseif($type == 'assign'){
                    $data =  Truck::find($id);
                     $staff=FieldStaff::where('disabled','0')->where('added_by', auth()->user()->added_by)->get();
                      //$staff=User::where('id','!=','1')->get();
                    $name=Tyre::where('status','0')->where('added_by', auth()->user()->added_by)->get();
                   $truck=TruckTyre::where('truck_id',$id)->where('added_by', auth()->user()->added_by)->first();
                    return view('tyre.addtyre',compact('id','data','staff','name','truck'));   
                 }
                     elseif($type == 'reference'){
                         $data=Tyre::find($id);
                    return view('tyre.addreference',compact('id','data'));
      }
            elseif($type == 'list'){
               $tyre=TyreAssignment::where('truck_id',$id)->get();
                    return view('tyre.tyre_list',compact('tyre'));
      }
      
            elseif($type == 'supplier'){
                return view('pos.purchases.supplier_modal');

      }
      
      elseif($type == 'receive'){
        $purchases = PurchaseTyre::find($id);
        $purchase_items =  PurchaseItemTyre::where('purchase_id', $id)->where('due_quantity', '>', '0')->get();
         $name = TyreBrand::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
       
        return view('tyre.item_details', compact('purchases', 'purchase_items', 'id', 'name'));

      }
      
         elseif($type == 'return'){
               $tyre=TyreReturnItems::where('return_id',$id)->get();
                    return view('tyre.return_list',compact('tyre'));
      }
      
       elseif($type == 'reallocation'){
               $tyre=TyreReallocationItems::where('reallocation_id',$id)->get();
                    return view('tyre.reallocation_list',compact('tyre'));
      }
      
         elseif($type == 'disposal'){
               $tyre=TyreDisposalItems::where('disposal_id',$id)->get();
                    return view('tyre.disposal_list',compact('tyre'));
      }
     elseif($type == 'edit'){
                  $item = TyreBrand::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
                  $name=$request->item_name[0];
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
                  
                return view('tyre.edit_modal', compact('item','name','qty','price','cost','tax','unit','rate','order','type','saved'));
     }
     
      
                 }
                 
                 
                 
                  public function add_item(Request $request)
    {
        //dd($request->all());

       $data=$request->all();
       
       
        
          $list = '';
          $list1 = ''; 
          
           $it=TyreBrand::where('id',$request->checked_item_name)->first();
                $a =  $it->brand ; 
          
                   
          $name=$request->checked_item_name[0];
          $qty=$request->checked_quantity[0];
          $price=str_replace(",","",$request->checked_price[0]);
          $cost=$request->checked_total_cost[0];
          $tax=$request->checked_total_tax[0];
          $order=$request->checked_no[0];
          $unit=$request->checked_unit[0];
          $rate=$request->checked_tax_rate[0];
          
          if($rate == '0'){
              $r='0%';
          }
         else if($rate == '0.18'){
              $r='18%';
          }
          
          if(!empty($request->saved_items_id[0])){
            $saved=$request->saved_items_id[0];
            }
            else{
            $saved='';   
                  }
          
          if(!empty($request->type) && $request->type == 'edit'){
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'</td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$cost.'</td>';
            $list .= '<td>'.$r.'</td>';
            $list .= '<td>'.$tax.'</td>';
             if(!empty($saved)){
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger rem" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '" value="'.$saved.'"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
                }
            else{
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            }
            
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_qty" id="qty lst'.$order.'"  value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            
            if(!empty($saved)){
            $list1 .= '<input type="hidden" name="saved_items_id[]" class="form-control item_saved'.$order.'" value="'.$saved.'"  required/>';
                }
          }
            else{
            $list .= '<tr class="trlst'.$order.'">';
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'</td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$cost.'</td>';
            $list .= '<td>'.$r.'</td>';
            $list .= '<td>'.$tax.'</td>';
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            $list .= '</tr>';
                    
            $list1 .= '<div class="line_items" id="lst'.$order.'">';
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_qty" id="qty lst'.$order.'"  value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
             $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            $list1 .= '</div>';
            }


             return response()->json([
            'list'          => $list,
            'list1' => $list1
    ]);
        
    }           

         public function addSupp(Request $request){
       
    
        $supplier= Supplier::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        'TIN' => $request['TIN'],
            'user_id'=> auth()->user()->added_by,
        ]);
        
      

        if (!empty($supplier)) {           
            return response()->json($supplier);
         }

       
   }

                 
    public function tyre_list()
    {
        //
        $tyre= Tyre::where('added_by', auth()->user()->added_by)->get();
       return view('tyre.tyre',compact('tyre'));
    }

    public function assign_truck()
    {
        //
        $truck = TruckTyre::where('disabled','0')->where('added_by', auth()->user()->added_by)->get();
       return view('tyre.assign_truck',compact('truck'));
    }

 public function save_reference (Request $request){
                     //
                     $tyre=   Tyre::find($request->id);
                     $data['serial_no']=$request->reference;
                     $data['reference']=$request->reference;
                     $data['assign_reference']='1';
                     $tyre->update($data);

                   
                     if(!empty($tyre)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->added_by,
                                'module_id'=>$request->id,
                                'module'=>'Tyre Reference Assigned',
                                'activity'=>"Tyre " . $tyre->serial_no. " Assigned Reference no " . $request->reference,
                                'date'=>date('Y-m-d'),

                            ]
                            );                      
            }
              
                     return redirect(route('tyre.list'))->with(['success'=>'Tyre Reference Assigned Successfully']);
                 }

    public function save_truck(Request $request){
                     //

                 $t1Arr =$request->tyre_1 ;
                 $t2Arr =$request->tyre_2 ;
                 $t3Arr =$request->tyre_3 ;
                 $t4Arr =$request->tyre_4 ;
                 $t5Arr =$request->tyre_5 ;
                 $t6Arr =$request->tyre_6 ; 
                  
                 $p1Arr = $request->position_1  ;
                 $p2Arr = $request->position_2  ;
                 $p3Arr = $request->position_3  ;
                 $p4Arr = $request->position_4  ;
                 $p5Arr = $request->position_5  ;
                 $p6Arr = $request->position_6  ;


                     $truck = TruckTyre::where('truck_id',$request->id)->first();

  if(!empty($t1Arr)){
$a= count($t1Arr);
}else{
$a= 0;
}

if(!empty($t2Arr)){
$b= count($t2Arr);
}else{
$b=0;
}

if(!empty($t3Arr)){
$c= count($t3Arr );
}else{
$c=0;
}

if(!empty($t4Arr)){
$d= count($t4Arr );
}else{
$d=0;
}

if(!empty($t5Arr)){
$e= count($t5Arr );
}else{
$e=0;
}
if(!empty($t6Arr)){
$f= count($t6Arr );
}else{
$f=0;
}


if($a + $b + $c + $d + $e + $f == '0'){
$status='0';
}

else{
if($a + $b + $c + $d + $e + $f == $truck->total_tyre){
$status='2';
}
else if($a + $b + $c + $d + $e + $f < $truck->total_tyre){
$status='1';
}
}

                        $data['staff']=$request->staff;
                     $data['reading']=$request->reading;
                   $data['status']=$status;
                   $data['due_1']= $truck->due_1 - $a;
                   $data['due_2']= $truck->due_2 - $b;
                   $data['due_3']= $truck->due_3 - $c;
                    $data['due_4']= $truck->due_4 - $d;
                    $data['due_5']= $truck->due_5 - $e;
                    $data['due_6']= $truck->due_6 - $f;
                   $data['due_tyre']=$truck->due_tyre - ($a + $b + $c + $d + $e + $f);
                      
                     $truck->update($data);

                  

               //position 1
                   if(!empty($t1Arr)){
        for($i = 0; $i < count($t1Arr); $i++){
            if(!empty( $t1Arr[$i])){
                $items = array(
                     'position' =>   $p1Arr[$i],
                    'added_by' => auth()->user()->added_by,
                     'tyre_id' => $t1Arr[$i], 
                      'status' => '1' , 
                   'staff' =>   $request->staff,
                    'truck_id' =>  $request->id);

                     $ta=TyreAssignment::create($items);  ;
                     
  
                   $name=Tyre::where('id',$t1Arr[$i])->first();

                     $list['truck_id']=$request->id;
                     $list['position']= $p1Arr[$i];
                     $list['status']='3';
                     Tyre::where('id',$t1Arr[$i])->update($list);


                 $inv=TyreBrand::where('id',$name->brand_id)->first();
                     $q=$inv->quantity - 1;
                     TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);

if(!empty($name->purchase_id)){
   $tt=PurchaseItemTyre::where('purchase_id', $name->purchase_id)->where('item_name', $name->brand_id)->first();
   $p=PurchaseTyre::find($name->purchase_id);
   $total=$tt->price *  $p->exchange_rate;
}
else if(empty($name->purchase_id)){
   $total= $inv->price;
}

  $d=date('Y-m-d');
  
  
   $mlists = [
                        'out' => 1,
                        'price' => $total,
                        'item_id' => $name->brand_id,
                        'serial_id' => $t1Arr[$i],
                         'staff_id' => $request->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $name->location,
                        'date' =>$d,
                        'type' =>   'Good Assignment',
                        'other_id' =>$ta->id,
                    ];

                    MasterHistory::create($mlists);
  
  
  
   $t=Truck::find($request->id);


                     if(!empty($truck)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->added_by,
                                'module_id'=>$request->id,
                                'module'=>'Assign Tyre',
                                'activity'=>"Tyre " . $name->reference. " Assigned to " . $t->truck_name,
                                'date'=>date('Y-m-d'),

                            ]
                            );                      
            }


            }
        }
    }    

             //position 2
                   if(!empty($t2Arr)){
        for($i = 0; $i < count($t2Arr); $i++){
            if(!empty( $t2Arr[$i])){
                $items = array(
                     'position' =>   $p2Arr[$i],
                    'added_by' => auth()->user()->added_by,
                     'tyre_id' => $t2Arr[$i], 
                      'status' => '1' , 
                   'staff' =>   $request->staff,
                    'truck_id' =>  $request->id);

                     $ta=TyreAssignment::create($items);  ;
                     
  
                   $name=Tyre::where('id',$t2Arr[$i])->first();

                     $list['truck_id']=$request->id;
                     $list['position']= $p2Arr[$i];
                     $list['status']='3';
                     Tyre::where('id',$t2Arr[$i])->update($list);


                 $inv=TyreBrand::where('id',$name->brand_id)->first();
                     $q=$inv->quantity - 1;
                     TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);

if(!empty($name->purchase_id)){
   $tt=PurchaseItemTyre::where('purchase_id', $name->purchase_id)->where('item_name', $name->brand_id)->first();
   $p=PurchaseTyre::find($name->purchase_id);
   $total=$tt->price *  $p->exchange_rate;
}
else if(empty($name->purchase_id)){
   $total= $inv->price;
}

  $d=date('Y-m-d');
  
  
   $mlists = [
                        'out' => 1,
                        'price' => $total,
                        'item_id' => $name->brand_id,
                        'serial_id' => $t2Arr[$i],
                         'staff_id' => $request->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $name->location,
                        'date' =>$d,
                        'type' =>   'Good Assignment',
                        'other_id' =>$ta->id,
                    ];

                    MasterHistory::create($mlists);
  
  
  
   $t=Truck::find($request->id);


                     if(!empty($truck)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->added_by,
                                'module_id'=>$request->id,
                                'module'=>'Assign Tyre',
                                'activity'=>"Tyre " . $name->reference. " Assigned to " . $t->truck_name,
                                'date'=>date('Y-m-d'),

                            ]
                            );                      
            }


            }
        }
    }    

 //position 3
                   
 if(!empty($t3Arr)){
        for($i = 0; $i < count($t3Arr); $i++){
            if(!empty( $t3Arr[$i])){
                $items = array(
                     'position' =>   $p3Arr[$i],
                    'added_by' => auth()->user()->added_by,
                     'tyre_id' => $t3Arr[$i], 
                      'status' => '1' , 
                   'staff' =>   $request->staff,
                    'truck_id' =>  $request->id);

                     $ta=TyreAssignment::create($items);  ;
                     
  
                   $name=Tyre::where('id',$t3Arr[$i])->first();

                     $list['truck_id']=$request->id;
                     $list['position']= $p3Arr[$i];
                     $list['status']='3';
                     Tyre::where('id',$t3Arr[$i])->update($list);


                 $inv=TyreBrand::where('id',$name->brand_id)->first();
                     $q=$inv->quantity - 1;
                     TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);

if(!empty($name->purchase_id)){
   $tt=PurchaseItemTyre::where('purchase_id', $name->purchase_id)->where('item_name', $name->brand_id)->first();
   $p=PurchaseTyre::find($name->purchase_id);
   $total=$tt->price *  $p->exchange_rate;
}
else if(empty($name->purchase_id)){
   $total= $inv->price;
}

  $d=date('Y-m-d');
  
  
   $mlists = [
                        'out' => 1,
                        'price' => $total,
                        'item_id' => $name->brand_id,
                        'serial_id' => $t3Arr[$i],
                         'staff_id' => $request->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $name->location,
                        'date' =>$d,
                        'type' =>   'Good Assignment',
                        'other_id' =>$ta->id,
                    ];

                    MasterHistory::create($mlists);
  
  
  
  
   $t=Truck::find($request->id);


                     if(!empty($truck)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->added_by,
                                'module_id'=>$request->id,
                                'module'=>'Assign Tyre',
                                'activity'=>"Tyre " . $name->reference. " Assigned to " . $t->truck_name,
                                'date'=>date('Y-m-d'),

                            ]
                            );                      
            }


            }
        }
    }    

 //position 4
                   if(!empty($t4Arr)){
        for($i = 0; $i < count($t4Arr); $i++){
            if(!empty( $t4Arr[$i])){
                $items = array(
                     'position' =>   $p4Arr[$i],
                    'added_by' => auth()->user()->added_by,
                     'tyre_id' => $t4Arr[$i], 
                      'status' => '1' , 
                   'staff' =>   $request->staff,
                    'truck_id' =>  $request->id);

                     $ta=TyreAssignment::create($items);  ;
                     
  
                   $name=Tyre::where('id',$t4Arr[$i])->first();

                     $list['truck_id']=$request->id;
                     $list['position']= $p4Arr[$i];
                     $list['status']='3';
                     Tyre::where('id',$t4Arr[$i])->update($list);


                 $inv=TyreBrand::where('id',$name->brand_id)->first();
                     $q=$inv->quantity - 1;
                     TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);

if(!empty($name->purchase_id)){
   $tt=PurchaseItemTyre::where('purchase_id', $name->purchase_id)->where('item_name', $name->brand_id)->first();
   $p=PurchaseTyre::find($name->purchase_id);
   $total=$tt->price *  $p->exchange_rate;
}
else if(empty($name->purchase_id)){
   $total= $inv->price;
}

  $d=date('Y-m-d');
  
  
   $mlists = [
                        'out' => 1,
                        'price' => $total,
                        'item_id' => $name->brand_id,
                        'serial_id' => $t4Arr[$i],
                         'staff_id' => $request->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $name->location,
                        'date' =>$d,
                        'type' =>   'Good Assignment',
                        'other_id' =>$ta->id,
                    ];

                    MasterHistory::create($mlists);
  
  
  
   $t=Truck::find($request->id);


                     if(!empty($truck)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->added_by,
                                'module_id'=>$request->id,
                                'module'=>'Assign Tyre',
                                'activity'=>"Tyre " . $name->reference. " Assigned to " . $t->truck_name,
                                'date'=>date('Y-m-d'),

                            ]
                            );                      
            }


            }
        }
    }    

 //position 5
                  if(!empty($t5Arr)){
        for($i = 0; $i < count($t5Arr); $i++){
            if(!empty( $t5Arr[$i])){
                $items = array(
                     'position' =>   $p5Arr[$i],
                    'added_by' => auth()->user()->added_by,
                     'tyre_id' => $t5Arr[$i], 
                      'status' => '1' , 
                   'staff' =>   $request->staff,
                    'truck_id' =>  $request->id);

                     $ta=TyreAssignment::create($items);  ;
                     
  
                   $name=Tyre::where('id',$t5Arr[$i])->first();

                     $list['truck_id']=$request->id;
                     $list['position']= $p5Arr[$i];
                     $list['status']='3';
                     Tyre::where('id',$t5Arr[$i])->update($list);


                 $inv=TyreBrand::where('id',$name->brand_id)->first();
                     $q=$inv->quantity - 1;
                     TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);

if(!empty($name->purchase_id)){
   $tt=PurchaseItemTyre::where('purchase_id', $name->purchase_id)->where('item_name', $name->brand_id)->first();
   $p=PurchaseTyre::find($name->purchase_id);
   $total=$tt->price *  $p->exchange_rate;
}
else if(empty($name->purchase_id)){
   $total= $inv->price;
}

  $d=date('Y-m-d');
  
  
   $mlists = [
                        'out' => 1,
                        'price' => $total,
                        'item_id' => $name->brand_id,
                        'serial_id' => $t5Arr[$i],
                         'staff_id' => $request->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $name->location,
                        'date' =>$d,
                        'type' =>   'Good Assignment',
                        'other_id' =>$ta->id,
                    ];

                    MasterHistory::create($mlists);
  
  
  
   $t=Truck::find($request->id);


                     if(!empty($truck)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->added_by,
                                'module_id'=>$request->id,
                                'module'=>'Assign Tyre',
                                'activity'=>"Tyre " . $name->reference. " Assigned to " . $t->truck_name,
                                'date'=>date('Y-m-d'),

                            ]
                            );                      
            }


            }
        }
    }    

 //position 6
                   if(!empty($t6Arr)){
        for($i = 0; $i < count($t6Arr); $i++){
            if(!empty( $t6Arr[$i])){
                $items = array(
                     'position' =>   $p6Arr[$i],
                    'added_by' => auth()->user()->added_by,
                     'tyre_id' => $t6Arr[$i], 
                      'status' => '1' , 
                   'staff' =>   $request->staff,
                    'truck_id' =>  $request->id);

                     $ta=TyreAssignment::create($items);  ;
                     
  
                   $name=Tyre::where('id',$t6Arr[$i])->first();

                     $list['truck_id']=$request->id;
                     $list['position']= $p6Arr[$i];
                     $list['status']='3';
                     Tyre::where('id',$t6Arr[$i])->update($list);


                 $inv=TyreBrand::where('id',$name->brand_id)->first();
                     $q=$inv->quantity - 1;
                     TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);

if(!empty($name->purchase_id)){
   $tt=PurchaseItemTyre::where('purchase_id', $name->purchase_id)->where('item_name', $name->brand_id)->first();
   $p=PurchaseTyre::find($name->purchase_id);
   $total=$tt->price *  $p->exchange_rate;
}
else if(empty($name->purchase_id)){
   $total= $inv->price;
}

  $d=date('Y-m-d');
  
  
   $mlists = [
                        'out' => 1,
                        'price' => $total,
                        'item_id' => $name->brand_id,
                        'serial_id' => $t6Arr[$i],
                         'staff_id' => $request->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $name->location,
                        'date' =>$d,
                        'type' =>   'Good Assignment',
                        'other_id' =>$ta->id,
                    ];

                    MasterHistory::create($mlists);
  
  
  
   $t=Truck::find($request->id);


                     if(!empty($truck)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->added_by,
                                'module_id'=>$request->id,
                                'module'=>'Assign Tyre',
                                'activity'=>"Tyre " . $name->reference. " Assigned to " . $t->truck_name,
                                'date'=>date('Y-m-d'),

                            ]
                            );                      
            }


            }
        }
    }    


 

                 Truck::find($request->id)->update(['reading' => $request->reading]);

                     return redirect(route('purchase_tyre.assign'))->with(['success'=>'Tyre Assigned Successfully']);
                 }



}
