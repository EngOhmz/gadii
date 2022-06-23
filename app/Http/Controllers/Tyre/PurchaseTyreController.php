<?php

namespace App\Http\Controllers\Tyre;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
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
use App\Models\Tyre\TyrePayment;
use Illuminate\Http\Request;
use PDF;

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
        $purchases=PurchaseTyre::all();
        $supplier=Supplier::all();
        $name = TyreBrand::all();
        $location = Location::all();
        $type="";
       return view('tyre.manage_purchase_tyre',compact('name','supplier','currency','purchases','location','type'));
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
                       
                     PurchaseItemTyre::create($items);  ;
    
    
                }
            }
            $cost['reference_no']= "PUR_TIRE_".$purchase->id."_".$data['purchase_date'];
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
            PurchaseTyre::where('id',$purchase->id)->update($cost);
        }    

        if(!empty($purchase)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->id,
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
        $purchase_items=PurchaseItemTyre::where('purchase_id',$id)->get();
        $payments=TyrePayment::where('purchase_id',$id)->get();
        
        return view('tyre.purchase_tyre_details',compact('purchases','purchase_items','payments'));
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
        $supplier=Supplier::all();
        $name = TyreBrand::all();
        $location = Location::all();
        $type="";
       return view('tyre.manage_purchase_tyre',compact('name','supplier','currency','location','type','data','id','items',));
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
                    PurchaseItemTyre::where('id',$remArr[$i])->delete();        
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
                               PurchaseItemTyre::where('id',$expArr[$i])->update($items);  
          
          }
          else{
            PurchaseItemTyre::create($items);   
          }

          if(!empty($qtyArr[$i])){
            for($x = 1; $x <= $qtyArr[$i]; $x++){    
                $name=TyreBrand::where('id', $savedArr[$i])->first();
                $dt=date('Y',strtotime($data['purchase_date']));
                    $lists = array(
                        'serial_no' => $name->brand."_" .$id."_".$x."_" .$dt,                      
                         'brand_id' => $savedArr[$i],
                           'added_by' => auth()->user()->id,
                           'purchase_id' =>   $id,
                         'purchase_date' =>  $data['purchase_date'],
                           'location' => $data['location'],
                           'status' => '0');
                       
     
                     Tyre::create($lists);   
      
                }
            }
         
    
    
                        
                    }
                }
                $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
                PurchaseTyre::where('id',$id)->update($cost);
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
                           
         
                         TyreHistory::create($items);   
          
                        $inv=TyreBrand::where('id',$nameArr[$i])->first();
                        $q=$inv->quantity + $qtyArr[$i];
                        TyreBrand::where('id',$nameArr[$i])->update(['quantity' => $q]);
                    }
                }
            
            }    
    
    
    
            if(!empty($purchase)){
                $activity = TyreActivity::create(
                    [ 
                        'added_by'=>auth()->user()->id,
                        'module_id'=>$id,
                        'module'=>'Purchase',
                        'activity'=>"Purchase Updated to Good Receive",
                       'date'=>$request->purchase_date,
                    ]
                    );                      
    }


    $tyre = PurchaseTyre::find($id);
    $supp=Supplier::find($tyre->supplier_id);
    $cr= AccountCodes::where('account_name','Tire')->first();
    $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$tyre->purchase_date);
  $journal->date =   $tyre->purchase_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'tire';
  $journal->name = 'Tire Purchase';
  $journal->debit = $tyre->purchase_amount *  $tyre->exchange_rate;
  $journal->income_id= $tyre->id;
   $journal->currency_code =  $tyre->exchange_code;
  $journal->exchange_rate= $tyre->exchange_rate;
 $journal->added_by=auth()->user()->id;
     $journal->notes= "Tire Purchase with reference no " .$tyre->reference_no ." by Supplier ". $supp->name ;
  $journal->save();

if($tyre->purchase_tax > 0){
 $tax= AccountCodes::where('account_name','VAT IN')->first();
    $journal = new JournalEntry();
  $journal->account_id = $tax->id;
  $date = explode('-',$tyre->purchase_date);
  $journal->date =   $tyre->purchase_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'tire';
  $journal->name = 'Tire Purchase';
  $journal->debit = $tyre->purchase_tax *  $tyre->exchange_rate;
  $journal->income_id= $tyre->id;
   $journal->currency_code =  $tyre->exchange_code;
  $journal->exchange_rate= $tyre->exchange_rate;
 $journal->added_by=auth()->user()->id;
     $journal->notes= "Tire Purchase Tax with reference no " .$tyre->reference_no ." by Supplier ".  $supp->name ;
  $journal->save();
}

  $codes= AccountCodes::where('account_name','Payables')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
  $date = explode('-',$tyre->purchase_date);
  $journal->date =   $tyre->purchase_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'tire';
  $journal->name = 'Tire Purchase';
  $journal->income_id= $tyre->id;
  $journal->credit =$tyre->due_amount *  $tyre->exchange_rate;
  $journal->currency_code =  $tyre->exchange_code;
  $journal->exchange_rate= $tyre->exchange_rate;
 $journal->added_by=auth()->user()->id;
     $journal->notes= "Credit for Tire Purchase with reference no " .$tyre->reference_no ." by Supplier ".  $supp->name ;
  $journal->save();

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
                PurchaseItemTyre::where('id',$remArr[$i])->delete();        
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
                            PurchaseItemTyre::where('id',$expArr[$i])->update($items);  
      
      }
      else{
        PurchaseItemTyre::create($items);   
      }
                    
                }
            }
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
            PurchaseTyre::where('id',$id)->update($cost);
        }    

        if(!empty($purchase)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->id,
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
                    'added_by'=>auth()->user()->id,
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
                    'added_by'=>auth()->user()->id,
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
                    'added_by'=>auth()->user()->id,
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
        $supplier=Supplier::all();
        $name = TyreBrand::all();
        $location = Location::all();
        $data=PurchaseTyre::find($id);
        $items=PurchaseItemTyre::where('purchase_id',$id)->get();
        $type="receive";
       return view('tyre.manage_purchase_tyre',compact('name','supplier','currency','location','data','id','items','type'));
    }

    public function make_payment($id)
    {
        //
        $invoice = PurchaseTyre::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('tyre.tyre_payment',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function tyre_pdfview(Request $request)
    {
        //
        $purchases = PurchaseTyre::find($request->id);
        $purchase_items=PurchaseItemTyre::where('purchase_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('tyre.purchase_tyre_pdf')->setPaper('a4', 'landscape');
     return $pdf->download('PURCHASE_TIRE REF NO # ' .  $purchases->reference_no . ".pdf");
   

        }
        return view('tyre_pdfview');
    }


    public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
                 if($type == 'refill'){
                    return view('tyre.addtyre',compact('id'));
                
                 }elseif($type == 'assign'){
                    $data =  Truck::find($id);
                     $staff=FieldStaff::all();
                      //$staff=User::where('id','!=','1')->get();
                    $name=Tyre::where('status','0')->orwhere('status','2')->get();
                   $truck=TruckTyre::where('truck_id',$id)->first();
                    return view('tyre.addtyre',compact('id','data','staff','name','truck'));   
                 }
                     elseif($type == 'reference'){
                    return view('tyre.addreference',compact('id'));
      }
            elseif($type == 'list'){
               $tyre=TyreAssignment::where('truck_id',$id)->get();
                    return view('tyre.tyre_list',compact('tyre'));
      }
                 }

         public function addSupp(Request $request){
       
    
        $supplier= Supplier::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        'TIN' => $request['TIN'],
            'user_id'=> auth()->user()->id,
        ]);
        
      

        if (!empty($supplier)) {           
            return response()->json($supplier);
         }

       
   }

                 
    public function tyre_list()
    {
        //
        $tyre= Tyre::all();
       return view('tyre.tyre',compact('tyre'));
    }

    public function assign_truck()
    {
        //
        $truck = TruckTyre::all();
       return view('tyre.assign_truck',compact('truck'));
    }

 public function save_reference (Request $request){
                     //
                     $tyre=   Tyre::find($request->id);
                     $data['reference']=$request->reference;
                     $data['assign_reference']='1';
                     $tyre->update($data);

                   
                     if(!empty($tyre)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->id,
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

               $diffArr =$request->tyre_diff ;
                   $dpArr = $request->diff_position  ;
                   $rearArr =$request->tyre_rear ;
                   $rpArr = $request->rear_position  ;
                   $trArr =$request->tyre_trailer ;
                   $tpArr = $request->trailer_position  ;

                     $truck = TruckTyre::where('truck_id',$request->id)->first();

  if(!empty($diffArr)){
$a= count($diffArr);
}else{
$a= 0;
}

if(!empty($rpArr)){
$b= count($rpArr);
}else{
$b=0;
}

if(!empty($trArr)){
$c= count($trArr );
}else{
$c=0;
}

if($a + $b + $c == '0'){
$status='0';
}

else{
if($a + $b + $c == $truck->total_tyre){
$status='2';
}
else if($a + $b + $c < $truck->total_tyre){
$status='1';
}
}

                        $data['staff']=$request->staff;
                     $data['reading']=$request->reading;
                   $data['status']=$status;
                   $data['due_diff']= $truck->due_diff - $a;
                   $data['due_rear']= $truck->due_rear - $b;
                   $data['due_trailer']= $truck->due_trailer - $c;
                   $data['due_tyre']=$truck->due_tyre - ($a + $b + $c);
                      
                     $truck->update($data);

                  


                   if(!empty($diffArr)){
        for($i = 0; $i < count($diffArr); $i++){
            if(!empty( $diffArr[$i])){
                $items = array(
                     'position' =>   $dpArr[$i],
                    'added_by' => auth()->user()->id,
                     'tyre_id' => $diffArr[$i], 
                      'status' => '1' , 
                   'staff' =>   $request->staff,
                    'truck_id' =>  $request->id);

                     TyreAssignment::create($items);  ;
 


                   $name=Tyre::where('id',$diffArr[$i])->first();

                     $list['truck_id']=$request->id;
                     $list['position']='Diff';
                     $list['status']='1';
                     Tyre::where('id',$diffArr[$i])->update($list);


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
   $t=Truck::find($request->id);

  $codes= AccountCodes::where('account_name','Maintenance and Repair')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'tire';
  $journal->name = 'Assigning Tire ';
  $journal->income_id= $diffArr[$i];
  $journal->debit =$total;
    $journal->truck_id= $request->id;
 $journal->added_by=auth()->user()->id;
      $journal->notes="Tyre " . $name->reference. " Assigned to " . $t->truck_name. " - " . $t->reg_no. " in the Diff Position";
  $journal->save();

  $cr= AccountCodes::where('account_name','Tire')->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'tire';
  $journal->name = 'Assigning Tire ';
  $journal->income_id= $diffArr[$i];
    $journal->credit = $total;
  $journal->truck_id= $request->id;
 $journal->added_by=auth()->user()->id;
     $journal->notes="Tyre " . $name->reference. " Assigned to " . $t->truck_name. " - " . $t->reg_no. " in the Diff Position";
  $journal->save();


                     if(!empty($truck)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->id,
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



  if(!empty($rearArr)){
        for($i = 0; $i < count($rearArr); $i++){
            if(!empty( $diffArr[$i])){
                $items = array(
                     'position' =>   $rpArr[$i],
                    'added_by' => auth()->user()->id,
                     'tyre_id' => $rearArr[$i], 
                      'status' => '1' , 
                   'staff' =>   $request->staff,
                    'truck_id' =>  $request->id);

                     TyreAssignment::create($items);  ;
 
                 
   

                   $name=Tyre::where('id',$rearArr[$i])->first();

                     $list['truck_id']=$request->id;
                     $list['position']='Rear';
                     $list['status']='1';
                     Tyre::where('id',$rearArr[$i])->update($list);


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
   $t=Truck::find($request->id);

  $codes= AccountCodes::where('account_name','Maintenance and Repair')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'tire';
  $journal->name = 'Assigning Tire ';
  $journal->income_id= $rearArr[$i];
  $journal->debit =$total;
    $journal->truck_id= $request->id;
 $journal->added_by=auth()->user()->id;
      $journal->notes="Tyre " . $name->reference. " Assigned to " . $t->truck_name. " - " . $t->reg_no. " in the Rear Position";
  $journal->save();

  $cr= AccountCodes::where('account_name','Tire')->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'tire';
  $journal->name = 'Assigning Tire ';
  $journal->income_id= $rearArr[$i];
    $journal->credit = $total;
  $journal->truck_id= $request->id;
 $journal->added_by=auth()->user()->id;
     $journal->notes="Tyre " . $name->reference. " Assigned to " . $t->truck_name. " - " . $t->reg_no. " in the Rear Position";
  $journal->save();

                  
                     if(!empty($truck)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->id,
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

 

  if(!empty($trArr)){
        for($i = 0; $i < count($trArr); $i++){
            if(!empty( $trArr[$i])){
                $items = array(
                     'position' =>   $tpArr[$i],
                    'added_by' => auth()->user()->id,
                     'tyre_id' => $trArr[$i], 
                      'status' => '1' , 
                   'staff' =>   $request->staff,
                    'truck_id' =>  $request->id);

                     TyreAssignment::create($items);  ;
 
                 
                     


                   $name=Tyre::where('id',$trArr[$i])->first();

                     $list['truck_id']=$request->id;
                     $list['position']='Trailer';
                     $list['status']='1';
                     Tyre::where('id',$trArr[$i])->update($list);


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
   $t=Truck::find($request->id);

  $codes= AccountCodes::where('account_name','Maintenance and Repair')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'tire';
  $journal->name = 'Assigning Tire ';
  $journal->income_id= $trArr[$i];
  $journal->debit =$total;
    $journal->truck_id= $request->id;
 $journal->added_by=auth()->user()->id;
      $journal->notes="Tyre " . $name->reference. " Assigned to " . $t->truck_name. " - " . $t->reg_no. " in the Trailer Position";
  $journal->save();

  $cr= AccountCodes::where('account_name','Tire')->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'tire';
  $journal->name = 'Assigning Tire ';
  $journal->income_id= $trArr[$i];
    $journal->credit = $total;
  $journal->truck_id= $request->id;
 $journal->added_by=auth()->user()->id;
     $journal->notes="Tyre " . $name->reference. " Assigned to " . $t->truck_name. " - " . $t->reg_no. " in the Trailer Position";
  $journal->save();


                     if(!empty($truck)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>auth()->user()->id,
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
