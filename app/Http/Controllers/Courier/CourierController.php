<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Courier\Courier;
use App\Models\Courier\CourierInvoiceItem;
use App\Models\Courier\CourierInvoice;
use App\Models\Courier\CourierItem;
use App\Models\Courier\CourierParent;
use App\Models\Courier\PickupCosts;
use App\Models\Courier\PickupPayment;
use App\Models\Courier\CourierList;
use App\Models\Courier\CourierPayment;
use App\Models\Payment_methodes;
use App\Models\Route;
use App\Models\Tariff;
use App\Models\Driver;
use App\Models\Courier\CourierClient;
use App\Models\Courier\CourierActivity;
use Illuminate\Http\Request;
use PDF;
use DB;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\orders\OrderMovement;
use App\Models\Region;
use App\Models\District;
use App\Models\Courier\CourierCollection;
use App\Models\Courier\CourierLoading;
use App\Models\SystemConfig;
use App\Models\System;



class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         if(auth()->user()->client_id != null){
            $courier = Courier::where('owner_id',auth()->user()->client_id)->where('pickup','2')->get();     
         }else{
          $courier = Courier::where('added_by',auth()->user()->added_by)->where('pickup','2')->get();
         }

        $route = Route::all();
        $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
          $name = CourierList::all();
          $currency = Currency::all();
       $region = Region::all();   
   
        return view('courier.quotation',compact('courier','route','users','name','currency','region'));
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
        $purchases = Courier::find($id);
        $purchase_items=CourierParent::where('pacel_id',$id)->where('child','0')->get();
      $child=CourierItem::where('pacel_id',$id)->where('child','1')->where('start','0')->get();
     $chk=CourierItem::where('pacel_id',$id)->where('child','1')->first(); 
          $close=CourierItem::where('pacel_id',$id)->where('child','1')->where('start','1')->first(); 
        $payments=CourierPayment::where('pacel_id',$id)->get();
        
        return view('courier.quotation_details',compact('purchases','purchase_items','payments','child','chk','close'));
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
        $items = CourierItem::find($id);
        $data =  Courier::find($items->pacel_id);
        $route = Route::all();
          $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
        $name = CourierList::all();       
         $currency = Currency::all();
         $tariff= Tariff::where('client_id',$data->owner_id)->get();
         $from_district= District::where('region_id', $data->from_region_id)->get(); 
         $to_district= District::where('region_id', $items->to_region_id)->get();   
         $region = Region::all();
            $value='1';
        return view('courier.quotation',compact('data','id','users','name','route','items','currency','tariff','from_district','to_district','region','value'));
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
        $purchases=CourierItem::find($id);
        $pacel= Courier::find($purchases->pacel_id);

            $t = array(
             'amount' =>  $pacel->amount - ($purchases->total_cost+ $purchases->total_tax) ,
              'due_amount' =>  $pacel->amount - ($purchases->total_cost+ $purchases->total_tax) ,
              'tax' =>    $pacel->tax - $purchases->total_tax);

                   $pacel->update($t);

            if($purchases->child == '1') {

$total_multiple=CourierParent::find($purchases->parent_id);
if(!empty($total_multiple)){
$price=CourierItem::where('parent_id',$purchases->parent_id)->sum('price');
$t_cost=CourierItem::where('parent_id',$purchases->parent_id)->sum('total_cost');
$tax=CourierItem::where('parent_id',$purchases->parent_id)->sum('total_tax');

$parent = array(
       'price' =>  $price - $purchases->total_cost,
        'total_cost' =>  $t_cost - $purchases->total_cost ,
        'total_tax' => $tax -  $purchases->total_tax);

$total_multiple->update($parent);

}

}

       
        $purchases->delete();
        return redirect(route('courier_quotation.index'))->with(['success'=>'Deleted Successfully']);
    }


public function delete_parent($id)
    {
        //
        $purchases=CourierParent::find($id);
        $pacel= Courier::find($purchases->pacel_id);

            $t = array(
             'amount' =>  $pacel->amount - ($purchases->total_cost+ $purchases->total_tax) ,
              'due_amount' =>  $pacel->amount - ($purchases->total_cost+ $purchases->total_tax) ,
              'tax' =>    $pacel->tax - $purchases->total_tax);

                   $pacel->update($t);

 
Courier::find($purchases->pacel_id)->update(['wbn' => $pacel->wbn - 1]);

       
        $purchases->delete();
        return redirect(route('courier_quotation.index'))->with(['success'=>'Deleted Successfully']);
    }

  public function findTariff(Request $request)
    {
               //$price= CourierList::where('id',$request->id)->get();
              $price= Tariff::where('client_id',$request->id)->where('type',$request->type)->get();
                return response()->json($price);                      

    }

 public function findTariff2(Request $request)
    {
               //$price= CourierList::where('id',$request->id)->get();
              $price= Tariff::where('client_id',$request->id)->where('type','Formula')->get();
                return response()->json($price);                      

    }

    public function findPrice(Request $request)
    {
               //$price= CourierList::where('id',$request->id)->get();
              $price= Tariff::where('id',$request->id)->get();
                return response()->json($price);                      

    }


   public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
                if($type == 'supplier'){
               return view('courier.addClient');
               
                }elseif($type == 'route'){
                    $old = Courier::find($id);
               $region = Region::all();   
                return view('courier.addRoute',compact('id','old','region'));   
                }
              elseif($type == 'assign'){
                    $old = Courier::find($id);
               $driver =Driver::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();   
                return view('courier.assign',compact('id','old','driver'));   
                }
              elseif($type == 'wbn'){
                    $old = Courier::find($id);
                return view('courier.wbn',compact('id','old'));   
                }
           elseif($type == 'assign-wbn'){
                    $old = CourierParent::find($id);
                      $region = Region::all();
                     $to_district= District::where('region_id', $old->to_region_id)->get();   
                return view('courier.assign_wbn',compact('id','old','region','to_district'));   
                }
                elseif($type == 'view-details'){
                    $old = Courier::find($id);
               $items =CourierParent::where('pacel_id',$id)->where('child','0')->get();   
                return view('courier.view-details',compact('id','old','items'));   
                }
            elseif($type == 'view-child'){
              $old = CourierParent::find($id);
               $items =CourierItem::where('parent_id',$id)->where('child','1')->get();   
                return view('courier.view-child',compact('id','items','old'));   
                }
            elseif($type == 'reverse'){
                    $old = CourierInvoice::find($id);
               $items =CourierInvoiceItem::where('pacel_id',$id)->get();   
                return view('courier.reverse_cargo',compact('id','old','items'));   
                }
               
                  elseif($type == 'barcode'){
                    $data = Courier::find($id);
                return view('courier.print',compact('id','data'));   
                }
                
                 elseif($type == 'departure' || $type == 'arrival'){
                    return view('route.addlocation',compact('id','type')); 
                }
 

       
   }
 public function receive($id)
    {
        //
         $it =  CourierParent::find($id);
        $data =  Courier::find($it->pacel_id);
        $route = Route::all();
          $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
        $name = CourierList::all();
         $currency = Currency::all();
            $tariff= Tariff::where('client_id',$data->owner_id)->get();
    $from_district= District::where('region_id', $data->from_region_id)->get(); 
  $to_district= District::where('region_id', $data->to_region_id)->get();   
    $region = Region::all();
        return view('courier.quotation',compact('data','id','users','name','route','currency','tariff','from_district','to_district','region'));
    }

  public function save_receive(Request $request)
    {
        //

if($request->update == '1'){

  $pacel= Courier::find($request->pacel_id);
 $old =CourierItem::find($request->id);
 
  $amountArr = str_replace(",","",$request->amount);
 $totalArr =  str_replace(",","",$request->tax);
  $typeArr =$request->tariff_type ;
  $nameArr =$request->item_name ;
 $qtyArr = $request->quantity  ;
 $priceArr = $request->price;
 $rateArr = $request->tax_rate ;
 $unitArr = $request->unit  ;
 $costArr = str_replace(",","",$request->total_cost)  ;
 $taxArr =  str_replace(",","",$request->total_tax );

  if(!empty($typeArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                   'date' => $request->date ,
                    'location' => $request->from_location ,
                     'from_region_id' =>$request->from_region_id,
                      'from_district_id' =>$request->from_district_id,
                     'currency_code' => 'TZS',
                    'exchange_rate' => '1',
                    'amount' =>  $pacel->amount - ($old->total_cost+ $old->total_tax) ,
                    'due_amount' =>  $pacel->amount - ($old->total_cost+ $old->total_tax) ,
                    'tax' =>    $pacel->tax - $old->total_tax);

                      Courier::where('id',$pacel->id)->update($t);  


            }
        }
    }    



  
    $total_amount = 0;
    $tax = 0;


    if(!empty($typeArr)){
        for($i = 0; $i < count($typeArr); $i++){
            if(!empty($typeArr[$i])){
                 $total_amount += $costArr[$i];
                  $tax += $taxArr[$i];

            

                $items = array(
                    'item_name' =>$nameArr[$i],
                    'quantity' =>   $qtyArr[$i],
                    'tax_rate' =>  $rateArr [$i],
                     'unit' => $unitArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                     'items_id' =>  $nameArr[$i],
                       'added_by'=>auth()->user()->added_by,
                    'instructions' => $request->instructions  ,
                     'tariff_type' => $typeArr[$i]  ,
                    'weight' => $request->weight ,
                  'receiver_name' => $request->receiver_name ,
                'receiver_phone' => $request->receiver_phone ,
             
                    'pacel_id' =>$pacel->id);

                CourierItem::find($request->id)->update($items); 

                  $it= CourierItem::find($request->id);  
                  $p=CourierParent::find($it->parent_id);

                   $loc = array(
                  'to_region_id' => $p->to_region_id ,
                    'to_district_id' => $p->to_district_id ,
                  'location' => $p->to_location ,
                 'wbn_no' =>$p->wbn_no);

                  CourierItem::find($request->id)->update($loc);  

        $total_multiple=CourierParent::find($it->parent_id);
if(!empty($total_multiple)){
$price=CourierItem::where('parent_id',$it->parent_id)->sum('price');
$t_cost=CourierItem::where('parent_id',$it->parent_id)->sum('total_cost');
$tax=CourierItem::where('parent_id',$it->parent_id)->sum('total_tax');

$parent = array(
               'price' =>  $price,
                'total_cost' =>  $t_cost,
                'total_tax' => $tax);

$total_multiple->update($parent);
}


            }
        }

        

        $cr=Courier::where('id',$pacel->id)->first();
         $cost['amount'] =  $cr->amount +  $total_amount + $tax;
        $cost['due_amount'] =  $cr->due_amount +  $total_amount + $tax;
       $cost['tax'] =  $cr->tax + $tax;

          Courier::where('id',$pacel->id)->update($cost);
    }    
       

  return redirect(route('courier_quotation.show',$pacel->id))->with(['success'=>'Updated Successfully']);
}



else{
  $pacel= Courier::find($request->pacel_id);
  $amountArr = str_replace(",","",$request->amount);
 $totalArr =  str_replace(",","",$request->tax);
  $typeArr =$request->tariff_type ;
  $nameArr =$request->item_name ;
 $qtyArr = $request->quantity  ;
 $priceArr = $request->price;
 $rateArr = $request->tax_rate ;
 $unitArr = $request->unit  ;
 $costArr = str_replace(",","",$request->total_cost)  ;
 $taxArr =  str_replace(",","",$request->total_tax );

  if(!empty($typeArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                   'date' => $request->date ,
                    'location' => $request->from_location ,
                        'from_region_id' =>$request->from_region_id,
                          'from_district_id' =>$request->from_district_id,
                     'currency_code' => 'TZS',
                    'exchange_rate' => '1',
                    'amount' =>  $pacel->amount + $amountArr[$i],
                    'due_amount' =>  $pacel->amount + $amountArr[$i] ,
                    'tax' =>    $pacel->tax +$totalArr[$i]);

                      Courier::where('id',$pacel->id)->update($t);  


            }
        }
    }    



    $cost['weight'] = 0;

    if(!empty($typeArr)){
        for($i = 0; $i < count($typeArr); $i++){
            if(!empty($typeArr[$i])){
                 

            $before=CourierItem::where('parent_id',$request->id)->where('child','1')->latest('id')->first();
               if(!empty($before)){
      $pro=$before->order_no + 1  ;           
}
            else{
         $pro=1;
}



            
            $it=CourierParent::find($request->id);


                $items = array(
                    'item_name' =>$nameArr[$i],
                    'quantity' =>   $qtyArr[$i],
                    'tax_rate' =>  $rateArr [$i],
                     'unit' => $unitArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                     'items_id' =>  $nameArr[$i],
                       'order_no' => $pro ,
                       'child' => 1,
                     'parent_id' => $request->id,
                      'to_region_id' => $it->to_region_id ,
                    'to_district_id' => $it->to_district_id ,
                  'location' => $it->to_location ,
                        'wbn_no' =>$it->wbn_no,
                       'added_by'=>auth()->user()->added_by,
                    'instructions' => $request->instructions  ,
                      'weight' => $request->weight ,
                     'tariff_type' => $typeArr[$i]  ,
                     'receiver_name' => $request->receiver_name ,
                'receiver_phone' => $request->receiver_phone ,
                    'pacel_id' =>$pacel->id);

                CourierItem::create($items);  ;


                  $parent = array(
                   'price' =>  $it->price +$priceArr[$i],
                    'total_cost' => $it->total_cost + $costArr[$i],
                    'total_tax' => $it->total_tax +  $taxArr[$i]);

                   $it->update($parent);


            }
        }
       
          //Courier::where('id',$pacel->id)->update($cost);
    }    
       

  return redirect(route('courier_quotation.show',$pacel->id))->with(['success'=>'Saved Successfully']);
}


    

    }


  public function start($id)
    {
        //
        $data =  Courier::find($id);
        $route = Route::all();
          $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
        $name = CourierList::all();
        $items = CourierItem::where('pacel_id',$id)->where('child','1')->where('start','0')->get(); 
         $currency = Currency::all();
    $from_district= District::where('region_id', $data->from_region_id)->get(); 
  $to_district= District::where('region_id', $data->to_region_id)->get();   
    $region = Region::all();
    $supplier=Driver::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 
     $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        return view('courier.start_quotation',compact('data','id','users','name','route','items','currency','from_district','to_district','region','bank_accounts','supplier'));
    }


  public function save_start(Request $request)
    {
        //

  $pacel= Courier::find($request->id);

  $amountArr = str_replace(",","",$request->amount);
 $totalArr =  str_replace(",","",$request->tax);
  $nameArr =$request->item_name ;
   $typeArr =$request->tariff_type ;
 $qtyArr = $request->quantity  ;
 $priceArr = $request->price;
 $rateArr = $request->tax_rate ;
 $unitArr = $request->unit  ;
 $costArr = str_replace(",","",$request->total_cost)  ;
 $taxArr =  str_replace(",","",$request->total_tax );
$remArr = $request->removed_id ;
 $expArr = $request->saved_items_id ;

  if(!empty($typeArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                   'date' => $request->date ,
                    'location' => $request->from_location ,
              'from_region_id' =>$request->from_region_id,
                'from_district_id' =>$request->from_district_id,               
                  'collector_id' => $request->supplier,
                      'sender_name' => $request->sender_name ,
                      'sender_phone' => $request->sender_phone );

                      Courier::where('id',$pacel->id)->update($t);  


            }
        }
    }    



 if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                   CourierItem::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
$item_count=count($nameArr);
 $pickup=($request->pickup_costs)/$item_count;

    if(!empty($typeArr)){
        for($i = 0; $i < count($typeArr); $i++){
            if(!empty($typeArr[$i])){         
            
                $items = array(
                    'item_name' =>$nameArr[$i],
                    'quantity' =>   $qtyArr[$i],
                    'tax_rate' =>  $rateArr [$i],
                     'unit' => $unitArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                    'pickup_costs' =>  $pickup,
                      'start' =>  '1',
                     'items_id' =>  $nameArr[$i],
                       'added_by'=>auth()->user()->added_by,
                     'tariff_type' =>  $typeArr[$i], 
                    'pacel_id' =>$pacel->id);

                  CourierItem::where('id',$expArr[$i])->update($items);  

           $it= CourierItem::find($expArr[$i]);  

           $p=CourierParent::find($it->parent_id);

                   $loc = array(
                  'to_region_id' => $p->to_region_id ,
                    'to_district_id' => $p->to_district_id ,
                  'location' => $p->to_location ,
                 'wbn_no' =>$p->wbn_no);

                  CourierItem::find($expArr[$i])->update($loc);  


        $total_multiple=CourierParent::find($it->parent_id);
if(!empty($total_multiple)){
$price=CourierItem::where('parent_id',$it->parent_id)->sum('price');
$t_cost=CourierItem::where('parent_id',$it->parent_id)->sum('total_cost');
$tax=CourierItem::where('parent_id',$it->parent_id)->sum('total_tax');

$parent = array(
               'price' =>  $price,
                'total_cost' =>  $t_cost,
                'total_tax' => $tax);

$total_multiple->update($parent);
}


$p_cost=CourierParent::where('pacel_id',$it->pacel_id)->sum('total_cost');
$p_tax=CourierParent::where('pacel_id',$it->pacel_id)->sum('total_tax');

        
        $new_cr=Courier::where('id',$it->pacel_id)->first();
         $cost['amount'] =  $p_cost + $p_tax;
        $cost['due_amount'] =  $p_cost + $p_tax;
       $cost['tax'] =  $p_tax;

          $new_cr->update($cost);

 
$l= CourierItem::find($expArr[$i]);  
$quot=Courier::find($l->pacel_id);  

                //$route = Tariff::find($quot->tariff_id); 
               //$region_from= Region::where('name',$route->from_region_id)->first(); 
             //$region_to= Region::where('name',$route->to_region_id)->first(); 
        
                $result['pacel_id']=$quot->id;
                $result['pacel_number']=$quot->pacel_number;
                 $result['confirmation_number']=$quot->confirmation_number;
                $result['wbn_no'] =$l->wbn_no;
                $result['weight']=$l->weight;
               $result['due_weight']=$l->weight;
                $result['start_location']= $quot->from_region_id;
                $result['end_location']=$l->to_region_id;
                $result['from']= $quot->location;
                $result['to']=$l->location;
                $result['owner_id']=$quot->owner_id;
                $result['amount']=$l->total_cost + $l->total_tax;
               $result['pickup_costs']=$l->pickup_costs;
                $result['tariff_id']=$l->item_name;
                $result['tariff_type']=$l->tariff_type;
                  $result['item_id']=$l->id;
                $result['status']='2';
                 $result['collector_id'] = $quot->collector_id;
                  $result['sender_name'] = $quot->sender_name ;
                 $result['sender_phone'] = $quot->sender_phone ;
                $result['added_by'] = auth()->user()->added_by;
              $result['collection_date']=$quot->date;
                $movement=CourierCollection::create($result);


               if(!empty($movement)){
              
 
                    $activity = CourierActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                            'module_id'=>$movement->pacel_id,
                            'module'=>'Courier',
                            'activity'=>"Confirm Pickup",
                             'costs'=>$l->pickup_costs,
                               'bank_id'=>$request->account_id,
                           'collection_id'=>$movement->id,
                           'date'=>$quot->date,
                        ]
                        );                      
       }



       
if($request->pickup_costs > 0){

            $receipt['pacel_id'] = $pacel->id;
                $receipt['total_cost'] = $l->pickup_costs ;
               $receipt['due_cost'] =$l->pickup_costs;
               $receipt['status'] = '0' ;
                $receipt['supplier'] = $request->supplier;
              $receipt['date'] = $request->date;
             $receipt['account_id'] = $request->account_id;
              $receipt['payment_type'] = $request->payment_type;
                 $receipt['type'] = 'Pickup Cost';
                $receipt['collection_id']=$movement->id;
                $receipt['route'] = $movement->tariff_id;
                $receipt['added_by'] = auth()->user()->added_by;
                
                $refill = PickupCosts::create($receipt);

          
   $codes= AccountCodes::where('account_name','Pickup Cost')->where('added_by', auth()->user()->added_by)->first();
    $cred= AccountCodes::where('added_by',auth()->user()->added_by)->where('account_name','Payables')->first();
  $t=Driver::find($refill->supplier);

             if($refill->payment_type == 'cash'){  

            
            $method= Payment_methodes::where('name','Cash')->first();

               $receipt['trans_id'] = "TRANS_CPC-".$refill->id.'-'. substr(str_shuffle(1234567890), 0, 1);
                $receipt['added_by'] = auth()->user()->added_by;
                 $receipt['pacel_id'] =$refill->pacel_id;
                $receipt['pickup_id'] =$refill->id;
               $receipt['amount'] = $refill->total_cost;
                $receipt['date'] = $refill->date;
                 $receipt['payment_method'] = $method->id;
                  $receipt['account_id'] =$request->account_id;
               $receipt['supplier_id'] =  $refill->supplier;

                //update due amount from invoice table
                 $b['due_cost'] =  0;
               $b['status'] = 2;   
      
                PickupCosts::find($refill->id)->update($b);
                 
                $payment = PickupPayment::create($receipt);

          
                $journal = new JournalEntry();
        $journal->account_id =     $codes->id ;;
    $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
         $journal->transaction_type = 'courier';
              $journal->name = 'Courier Pickup Costs';
             $journal->income_id=    $refill->id;;
              $journal->notes= 'Courier Pickup Costs On Cash Payment to  '.$t->driver_name;
        $journal->added_by= auth()->user()->added_by;;
        $journal->debit =   $refill->total_cost ;
        $journal->save();

         $journal = new JournalEntry();
        $journal->account_id = $cred->id;;
        $date = explode('-',  $refill->date);
         $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
       $journal->transaction_type = 'courier';
              $journal->name = 'Courier Pickup Costs';
             $journal->income_id=    $refill->id;;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Courier Pickup Costs On Cash Payment to  '.$t->driver_name;
        $journal->save();
          

                $journal = new JournalEntry();
              $journal->account_id = $cred->id;;;
              $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
            $journal->transaction_type = 'courier';
              $journal->name = 'Courier Pickup Costs Payment';
              $journal->debit = $refill->total_cost ;
              $journal->payment_id= $payment->id;
        $journal->added_by=auth()->user()->added_by;
               $journal->notes= 'Payment for Courier Pickup Costs  to  '.$t->driver_name;
              $journal->save();
      
      

              $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
               $journal->transaction_type = 'courier';
              $journal->name = 'Courier Pickup Costs Payment';
              $journal->credit =$refill->total_cost ;
              $journal->payment_id= $payment->id;
               $journal->added_by=auth()->user()->added_by;
                 $journal->notes= 'Payment for Courier Pickup Costs  to  '.$t->driver_name;
              $journal->save();

$bank_account= Accounts::where('account_id',$request->account_id)->first();
        if(!empty($bank_account)){
$balance=$bank_account->balance - $refill->total_cost ;
$item_to['balance']=$balance;
$bank_account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->account_id)->first();

     $new['account_id']= $request->account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$refill->total_cost;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$refill->total_cost;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Courier Pickup Costs Payment',
                                 'module_id' => $refill->id,
                               'account_id' => $request->account_id,
                                'code_id' => $cred->id,
                                'name' => 'Courier Pickup Costs Payment  ' .$t->driver_name,
                                'type' => 'Expense',
                                'amount' =>$refill->total_cost,
                                'debit' => $refill->total_cost,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d'),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier pickup costs payment. Payment to '.$t->driver_name ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
                              

}

    else if($refill->payment_type == 'credit'){

  $journal = new JournalEntry();
        $journal->account_id =     $codes->id ;;
    $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
         $journal->transaction_type = 'courier';
              $journal->name = 'Courier Pickup Costs';
             $journal->income_id=    $refill->id;;
              $journal->notes= 'Courier Pickup Costs On Cash Payment to  '.$t->driver_name;
        $journal->added_by= auth()->user()->added_by;;
        $journal->debit =   $refill->total_cost ;
        $journal->save();

         $journal = new JournalEntry();
        $journal->account_id = $cred->id;;
        $date = explode('-',  $refill->date);
         $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
       $journal->transaction_type = 'courier';
              $journal->name = 'Courier Pickup Costs';
             $journal->income_id=    $refill->id;;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Courier Pickup Costs On Cash Payment to  '.$t->driver_name;
        $journal->save();
          
}

}


          

            }
        }
       
        
    }    
       


       return redirect(route('courier_quotation.index'))->with(['success'=>'Package Collected Successfully']);
    }

 public function assign(Request $request)
   {
       //
      $id=$request->id;
       $purchase = Courier::find($id);
        $data['pickup'] = 1;
        $data['collector_id'] = $request->collector_id;
       $purchase->update($data);
           
      
       return redirect(route('courier_pickup.index'))->with(['success'=>'Package Collected Successfully']);
   }

   public function save_wbn(Request $request)
   {
       //
      $id=$request->id;
       $purchase = Courier::find($id);
        $data['pickup'] = 2;
         $data['wbn'] = $request->wbn;
       $purchase->update($data);


$nameArr =$request->wbn ;


    if(!empty($nameArr)){
        for($i = 0; $i < $nameArr; $i++){
               $pro=$i+1;
              $reference=$purchase->confirmation_number.'/'.$pro;
               
                $items = array(
                 'wbn_no' =>$reference,
                  'added_by' => auth()->user()->added_by,
                   'order_no' =>$i,
                    'pacel_id' =>$id);

                $it= CourierParent::create($items);  ;

            }
        }
       
      
       
           
      
       return redirect(route('courier_quotation.index'))->with(['success'=>'Created Successfully']);
   }


 public function assign_wbn(Request $request)
   {
       //
      $id=$request->id;
       $purchase = CourierParent::find($id);
               
                $items = array(
                  'to_region_id' => $request->to_region_id ,
                    'to_district_id' => $request->to_district_id ,
                  'location' => $request->to_location ,
                 'wbn_no' =>$request->wbn_no );

                 $purchase->update($items);  ;

           CourierItem::where('parent_id',$id)->update($items); 

           
      return redirect(route('courier_quotation.show',$purchase->pacel_id))->with(['success'=>'Assigned Successfully']);


   }


   public function add_trip($id)
   {
       //
       $purchase = Courier::find($id);
         $data['wbn'] = $purchase->wbn + 1;
       $purchase->update($data);


$before=CourierParent::where('pacel_id',$id)->latest('id')->first();
           if(!empty($before)){
  $count=$before->order_no + 1  ;       
 $pro=$count + 1  ;           
}
        else{
     $count=0;
    $pro=1;
}

              $reference=$purchase->confirmation_number.'/'.$pro;
               
                $items = array(
                 'wbn_no' =>$reference,
                   'order_no' =>$count,
                    'added_by' => auth()->user()->added_by,
                    'pacel_id' =>$id);

                $it= CourierParent::create($items);  ;

       
      
       return redirect(route('courier_quotation.index'))->with(['success'=>'Added Successfully']);
   }


public function close_trip($id)
   {
       //
       $purchase = Courier::find($id);
         $data['good_receive'] = 1;
       $purchase->update($data);


$before=CourierParent::where('pacel_id',$id)->update(['start' => '1']);;
           
      
       return redirect(route('courier_quotation.index'))->with(['success'=>'Closed Successfully']);
   }

 public function edit_invoice($id)
    {
        //
        $data =  CourierInvoice::find($id);
        $route = Route::all();
          $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
        $name = CourierList::all();
        $items = CourierInvoiceItem::where('pacel_id',$id)->get(); 
        $tariff=Tariff::where('client_id',$data->owner_id)->get();
         $currency = Currency::all();
    $from_district= District::where('region_id', $data->from_region_id)->get(); 
  $to_district= District::where('region_id', $data->to_region_id)->get();   
    $region = Region::all();
    $supplier=Driver::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 
     $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        return view('courier.invoice',compact('data','id','users','name','route','items','currency','from_district','to_district','region','bank_accounts','supplier','tariff'));
    }


 public function approve($id)
   {
       //
      
       $data =  CourierInvoice::find($id);
        $route = Route::all();
          $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
        $name = CourierList::all();
        $items = CourierInvoiceItem::where('pacel_id',$id)->get(); 
        $tariff=Tariff::where('client_id',$data->owner_id)->get();
         $currency = Currency::all();
     $from_district= District::where('region_id', $data->from_region_id)->get(); 
     $to_district= District::where('region_id', $data->to_region_id)->get();   
    $region = Region::all();
    $supplier=Driver::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 
     $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
      $receive='1';
        return view('courier.invoice',compact('data','id','users','name','route','items','currency','from_district','to_district','region','bank_accounts','supplier','tariff','receive'));
   }

public function save_invoice(Request $request)
    {
        //

if($request->receive == '1'){
  $pacel= CourierInvoice::find($request->id);

  $amountArr = str_replace(",","",$request->amount);
 $totalArr =  str_replace(",","",$request->tax);
  $nameArr =$request->item_name ;
    $typeArr =$request->tariff_type ;
 $priceArr = $request->price;
 $rateArr = $request->tax_rate ;
 $unitArr = $request->unit  ;
$expArr = $request->saved_items_id  ;
 $costArr = str_replace(",","",$request->total_cost)  ;
 $taxArr =  str_replace(",","",$request->total_tax );

  if(!empty($priceArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                   'date' => $request->date ,
                   'description' => $request->description ,
                    'approve' => '1' ,
                    'amount' =>   $amountArr[$i],
                    'due_amount' =>  $amountArr[$i] ,
                    'tax' =>    $totalArr[$i]);

                      $pacel->update($t);  


            }
        }
    }    



   
    if(!empty($priceArr)){
        for($i = 0; $i < count($priceArr); $i++){
            if(!empty($priceArr[$i])){
   
                $items = array(
                 'item_name' =>$nameArr[$i],
                   'items_id' =>$nameArr[$i],
                     'tariff_type' => $typeArr[$i]  ,
                    'tax_rate' =>  $rateArr [$i],
                     'unit' => $unitArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                       'added_by'=>auth()->user()->added_by);

                $it=  CourierInvoiceItem::find($expArr[$i])->update($items);  ;

                  $list=  CourierInvoiceItem::find($expArr[$i]) ;

           CourierCollection::where('id',$list->collection_id)->update(['tariff_type' =>$typeArr[$i],'tariff_id' =>$nameArr[$i] , 'amount' => $costArr[$i] + $taxArr[$i] ]);

          $loading=CourierLoading::where('collection_id',$list->collection_id)->first();
         if(!empty($loading)){
         CourierLoading::where('collection_id',$list->collection_id)->update(['tariff_id' =>$nameArr[$i] , 'amount' => $costArr[$i] + $taxArr[$i] ]);

}

         $collect=CourierCollection::where('id',$list->collection_id)->first();

          $old_c=CourierItem::find($collect->item_id)  ;
          $old_pacel= Courier::find($old_c->pacel_id)  ;

         $old_t = array(
                    'amount' =>  $old_pacel->amount - ($old_c->total_cost+ $old_c->total_tax) ,
                    'due_amount' =>  $old_pacel->amount - ($old_c->total_cost+ $old_c->total_tax) ,
                    'tax' =>    $old_pacel->tax - $old_c->total_tax);

                      Courier::where('id',$old_c->pacel_id)->update($old_t); 

         $old_items = array(
                 'item_name' =>$nameArr[$i],
                    'items_id' =>$nameArr[$i],
                     'tariff_type' => $typeArr[$i]  ,
                    'tax_rate' =>  $rateArr [$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i]);

          CourierItem::find($collect->item_id)->update($old_items);  ;


        $cr=Courier::where('id',$old_c->pacel_id)->first();
         $cost['amount'] =  $cr->amount +  $costArr[$i] + $taxArr[$i];
        $cost['due_amount'] =  $cr->due_amount + $costArr[$i] + $taxArr[$i];
       $cost['tax'] =  $cr->tax + $taxArr[$i];

          $cr->update($cost);



 $total_multiple=CourierParent::find($old_c->parent_id);
if(!empty($total_multiple)){
$price=CourierItem::where('parent_id',$old_c->parent_id)->sum('price');
$t_cost=CourierItem::where('parent_id',$old_c->parent_id)->sum('total_cost');
$tax=CourierItem::where('parent_id',$old_c->parent_id)->sum('total_tax');

$parent = array(
               'price' =>  $price,
                'total_cost' =>  $t_cost,
                'total_tax' => $tax);

$total_multiple->update($parent);
}


            }
        }
       
    }    


 $quot=  CourierInvoice::find($pacel->id);
   $client=CourierClient::find($quot->owner_id);

$cr= AccountCodes::where('account_name','Courier')->where('added_by', auth()->user()->added_by)->first();
          $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-',$quot->date);
        $journal->date =   $quot->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier';
        $journal->name = 'Courier Invoice';
        $journal->credit = ($quot->amount - $quot->tax) *  $quot->exchange_rate;
        $journal->income_id= $pacel->id;
         $journal->currency_code =   $quot->currency_code;
        $journal->exchange_rate=  $quot->exchange_rate;
 $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Invoice with reference no " .$quot->confirmation_number. "  by Client ".  $client->name ;
        $journal->save();

if($quot->tax > 0){
       $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by', auth()->user()->added_by)->first();
          $journal = new JournalEntry();
        $journal->account_id = $tax->id;
           $date = explode('-',$quot->date);
        $journal->date =   $quot->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier';
        $journal->name = 'Courier Invoice';
        $journal->credit = $quot->tax *  $quot->exchange_rate;
        $journal->income_id= $pacel->id;
         $journal->currency_code =   $quot->currency_code;
        $journal->exchange_rate=  $quot->exchange_rate;
 $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Invoice Tax with reference no " .$quot->confirmation_number. "  by Client ".  $client->name ;
        $journal->save();
}

        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
           $date = explode('-',$quot->date);
        $journal->date =   $quot->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier';
        $journal->name = 'Courier Invoice';
       $journal->debit =$quot->amount  *  $quot->exchange_rate;
            $journal->income_id= $pacel->id;
         $journal->currency_code =   $quot->currency_code;
        $journal->exchange_rate=  $quot->exchange_rate;
 $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Debit Receivables for Invoice with reference no " .$quot->confirmation_number. "  by Client ".  $client->name ;
        $journal->save();

       

  return redirect(route('courier.details',$pacel->id))->with(['success'=>'Approved Successfully']);
}



else{
  $pacel= CourierInvoice::find($request->id);

  $amountArr = str_replace(",","",$request->amount);
 $totalArr =  str_replace(",","",$request->tax);
  $nameArr =$request->item_name ;
 $typeArr =$request->tariff_type ;
 $priceArr = $request->price;
 $rateArr = $request->tax_rate ;
 $unitArr = $request->unit  ;
$expArr = $request->saved_items_id  ;
 $costArr = str_replace(",","",$request->total_cost)  ;
 $taxArr =  str_replace(",","",$request->total_tax );

  if(!empty($priceArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                   'date' => $request->date ,
                    'description' => $request->description ,
                    'amount' =>   $amountArr[$i],
                    'due_amount' =>  $amountArr[$i] ,
                    'tax' =>    $totalArr[$i]);

                      $pacel->update($t);  


            }
        }
    }    



   
    if(!empty($priceArr)){
        for($i = 0; $i < count($priceArr); $i++){
            if(!empty($priceArr[$i])){
   
                $items = array(
                 'item_name' =>$nameArr[$i],
                   'items_id' =>$nameArr[$i],
                     'tariff_type' => $typeArr[$i]  ,
                    'tax_rate' =>  $rateArr [$i],
                     'unit' => $unitArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                       'added_by'=>auth()->user()->added_by);

                $it=  CourierInvoiceItem::find($expArr[$i])->update($items);  ;

                  $list=  CourierInvoiceItem::find($expArr[$i]) ;

           CourierCollection::where('id',$list->collection_id)->update(['tariff_type' =>$typeArr[$i],'tariff_id' =>$nameArr[$i] , 'amount' => $costArr[$i] + $taxArr[$i] ]);

          $loading=CourierLoading::where('collection_id',$list->collection_id)->first();
         if(!empty($loading)){
         CourierLoading::where('collection_id',$list->collection_id)->update(['tariff_id' =>$nameArr[$i] , 'amount' => $costArr[$i] + $taxArr[$i] ]);

}

         $collect=CourierCollection::where('id',$list->collection_id)->first();

          $old_c=CourierItem::find($collect->item_id)  ;
          $old_pacel= Courier::find($old_c->pacel_id)  ;

         $old_t = array(
                    'amount' =>  $old_pacel->amount - ($old_c->total_cost+ $old_c->total_tax) ,
                    'due_amount' =>  $old_pacel->amount - ($old_c->total_cost+ $old_c->total_tax) ,
                    'tax' =>    $old_pacel->tax - $old_c->total_tax);

                      Courier::where('id',$old_c->pacel_id)->update($old_t); 

         $old_items = array(
                 'item_name' =>$nameArr[$i],
                    'items_id' =>$nameArr[$i],
                     'tariff_type' => $typeArr[$i]  ,
                    'tax_rate' =>  $rateArr [$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i]);

          CourierItem::find($collect->item_id)->update($old_items);  ;


        $cr=Courier::where('id',$old_c->pacel_id)->first();
         $cost['amount'] =  $cr->amount +  $costArr[$i] + $taxArr[$i];
        $cost['due_amount'] =  $cr->due_amount + $costArr[$i] + $taxArr[$i];
       $cost['tax'] =  $cr->tax + $taxArr[$i];

          $cr->update($cost);

$total_multiple=CourierParent::find($old_c->parent_id);
if(!empty($total_multiple)){
$price=CourierItem::where('parent_id',$old_c->parent_id)->sum('price');
$t_cost=CourierItem::where('parent_id',$old_c->parent_id)->sum('total_cost');
$tax=CourierItem::where('parent_id',$old_c->parent_id)->sum('total_tax');

$parent = array(
               'price' =>  $price,
                'total_cost' =>  $t_cost,
                'total_tax' => $tax);

$total_multiple->update($parent);
}


            }
        }
       
    }    
       

  return redirect(route('courier.details',$pacel->id))->with(['success'=>'Updated Successfully']);
}

}

  public function reverse(Request $request)
   {
       //
      
     $item_id=$request->checked_trans_id;

     if(!empty($item_id)){
    for($i = 0; $i < count($item_id); $i++){
   if(!empty($item_id[$i])){

 $items = CourierInvoiceItem::where('id',$item_id[$i])->first();

 $data =  CourierInvoice::find($items->pacel_id);
  $cost['amount'] = $data->amount - ($items->total_cost + $items->total_tax) ;
 $cost['due_amount'] = $data->due_amount - ($items->total_cost + $items->total_tax) ;
   $cost['tax'] = $data->tax -  $items->total_tax ;
$data->update($cost);

 $collect=CourierCollection::where('id',$items->collection_id)->update(['invoiced' => '0']);
  $items->delete();
}

}

 $pacel =  CourierInvoice::find($request->id);

if($pacel->amount == '0'){
  $pacel->delete();

 return redirect(route('wb.courier'))->with(['success'=>'Reversed Successfully']);

}

else if($pacel->amount > 0){

 return redirect(route('courier.invoice'))->with(['success'=>'Reversed Successfully']);
}


}


  else{
 return redirect(route('courier.invoice'))->with(['error'=>'You have not chosen an entry']);

}    
      

   
    }

   public function invoice()
   {
       //
       $courier =  CourierInvoice::all()->where('added_by',auth()->user()->added_by);
       $route = Route::all();
       $users = CourierClient::all();
         $name = CourierList::all();
         $currency = Currency::all();
       return view('courier.invoice',compact('courier','route','users','name','currency'));
   }
    public function details($id)
    {
        //
        $purchases =CourierInvoice::find($id);
        $purchase_items=CourierInvoiceItem::where('pacel_id',$id)->get();
        $payments=CourierPayment::where('pacel_id',$id)->get();
        
        return view('courier.invoice_details',compact('purchases','purchase_items','payments'));
    }

   public function cancel($id)
   {
       //
       $purchase = Courier::find($id);
       $data['status'] = 7;
       $purchase->update($data);
       return redirect(route('courier_quotation.index'))->with(['success'=>'Cancelled Successfully']);
   }

  

   public function make_payment($id)
   {
       //
       $invoice = CourierInvoice::find($id);
       $payment_method = Payment_methodes::all();
  $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('courier.pacel_payment',compact('invoice','payment_method','bank_accounts'));
   }
   
   public function courier_pdfview(Request $request)
   {
       //
       $purchases = Courier::find($request->id);
       $purchase_items=CourierItem::where('pacel_id',$request->id)->get();

       view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

       if($request->has('download')){
       $pdf = PDF::loadView('courier.quotation_pdf')->setPaper('a4', 'potrait');
      return $pdf->download('COURIER NO # ' .  $purchases->confirmation_number . ".pdf");
       }
       return view('courier_pdfview');
   }

public function courier_invoice_pdfview(Request $request)
 {
       //
       $purchases =CourierInvoice::find($request->id);
       $purchase_items=CourierInvoiceItem::where('pacel_id',$request->id)->get();

       view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

       if($request->has('download')){
       $pdf = PDF::loadView('courier.invoice_pdf')->setPaper('a4', 'potrait');
      return $pdf->download('COURIER INVOICE NO # ' .  $purchases->confirmation_number . ".pdf");
       }
       return view('courier_invoice_pdfview');
   }


public function reverse2($id)
   {
       //
      
       $data =  CourierInvoice::find($id);
        $items = CourierInvoiceItem::where('pacel_id',$id)->get(); 

             foreach($items as $i){
            
            $collect=CourierCollection::where('id',$i->collection_id)->update(['status' => '4']);
          
         }

       CourierInvoiceItem::where('pacel_id',$id)->delete();
      $data->delete();

 
         return redirect(route('wb.courier'))->with(['success'=>'Reversed Successfully']);
      

    }


public function payment_list()
    {
        //
        $fuel =PickupCosts::where('added_by',auth()->user()->added_by)->orderBy('date', 'desc')->get();    
        return view('courier.payment_list',compact('fuel'));
    }

 public function cost_payment($id)
   {
       //
       $invoice = PickupCosts::find($id);
       $payment_method = Payment_methodes::all();
  $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('courier.make_payment',compact('invoice','payment_method','bank_accounts'));
   }

public function save_payment(Request $request)
    {
        //

   $receipt = $request->all();
  $rfl=PickupCosts::find($request->pickup_id);

     if(($receipt['amount'] < $rfl->due_cost)){
            if( $receipt['amount'] >= 0){

    $data['due_cost'] = $rfl->due_cost  -$receipt['amount'];
    if($data['due_cost'] != 0 ){
                $data['status'] = 1;
                }else{
                    $data['status'] = 2;
                }
   
          $rfl->update($data);


          $receipt['trans_id'] = "TRANS_CPC-".$rfl->id.'-'. substr(str_shuffle(1234567890), 0, 1);
           $receipt['added_by'] = auth()->user()->added_by;
           $receipt['pacel_id'] =$rfl->pacel_id; 
           $receipt['supplier_id']=$rfl->supplier;
                 
          $payment = PickupPayment::create($receipt);

 
               $t=Driver::find($rfl->supplier);
                $movement=Courier::find($rfl->pacel_id);


               $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'courier';
              $journal->name = 'Courier '.$rfl->type.'  Payment';
                $journal->debit =$receipt['amount']   ;
                  $journal->payment_id= $payment->id;
                 $journal->supplier_id=$request->supplier;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
               $journal->added_by=auth()->user()->added_by;
                  $journal->notes= 'Courier '.$rfl->type.'  with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
                $journal->save();
            
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
                $journal->transaction_type = 'courier';
              $journal->name = 'Courier '.$rfl->type.'  Payment';
              $journal->credit = $receipt['amount'] ;
              $journal->payment_id= $payment->id;
               $journal->supplier_id=$request->supplier;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
                   $journal->added_by=auth()->user()->added_by;
                  $journal->notes=  'Courier '.$rfl->type.'   with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
              $journal->save();

                
$account= Accounts::where('account_id',$request->account_id)->first();

if(!empty($account)){
$account_balance=$account->balance - $payment->amount ;
$item_to['balance']=$account_balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->account_id)->first();

     $new['account_id']= $request->account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$payment->amount;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->id;
$account_balance=0-$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Courier '.$rfl->type.'  Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier '.$rfl->type.'  Payment with reference no ' .$movement->confirmation_number. ' to ' .$t->driver_name,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$account_balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$request->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from Courier '.$rfl->type.'  Payment . The reference is  ' .$movement->confirmation_number.' to '.$t->driver_name ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
                              


      
                return redirect(route('courier.payment_list'))->with(['success'=>'Payment Added successfully']);
}

else{
                return redirect(route('courier.payment_list'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('courier.payment_list'))->with(['error'=>'Amount should  be less than Total amount ']);

        }


            }
            
             public function findAmount(Request $request)
    {
               $cost=PickupCosts::where('supplier',$request->id)->where('status','!=','2')->where('added_by',auth()->user()->added_by)->sum('due_cost') ;
               $price="The Due Amount is  ".  number_format($cost,2)  ;
                return response()->json($price);	                  

    }

 public function multiple_payment()
    {
        //
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
           $supplier=Driver::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 

        return view('courier.multiple_payment',compact('supplier','payment_method','bank_accounts'));
    }       


 public function save_multiple_payment(Request $request)
    {
        //

  $refill=PickupCosts::where('supplier',$request->supplier)->where('status','!=','2')->orderBy('date', 'asc')->where('added_by',auth()->user()->added_by)->get() ;

if(!empty($refill[0])){

                 $balance= str_replace(",","",$request->amount);
                  $remaining = 0;
               foreach($refill as $rfl){

    // check to see if there is enough to satisfy order amount

    if ($rfl->due_cost >= $balance) {
        $data['due_cost'] = $rfl->due_cost  - $balance;
         $cost=$balance;
        $balance = 0;
       $rem_balance = $balance;
      if( $data['due_cost'] > 0){
        $data['status']='1';   
      }
      
      else{
        $data['status']='2';   
      }
        
    } else {
        // allocate everything available
        $balance = $balance - $rfl->due_cost;
        $rem_balance = $balance;
      $cost=$rfl->due_cost;
       $data['due_cost'] = 0;
      $data['status']='2';
    }
   
//dd($cost);

 $sql=PickupCosts::find($rfl->id)->update($data);


 $receipt['trans_id'] = "TRANS_CPC-".$rfl->id.'-'. substr(str_shuffle(1234567890), 0, 1);
                $receipt['added_by'] = auth()->user()->added_by;
                $receipt['pacel_id'] =$rfl->pacel_id;
            $receipt['pickup_id'] =$rfl->id;
                $receipt['amount']=$cost;
                  $receipt['date']=$request->date;
                 $receipt['payment_method']=$request->payment_method;
              $receipt['notes']=$request->notes;
            $receipt['account_id']=$request->account_id;
           $receipt['supplier_id']=$request->supplier;
                 
                $payment = PickupPayment::create($receipt);

 
               $t=Driver::find($rfl->supplier);
                $movement=Courier::find($rfl->pacel_id);


               $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'courier';
              $journal->name = 'Courier '.$rfl->type.'  Payment';
                $journal->debit =$receipt['amount']   ;
                  $journal->payment_id= $payment->id;
                 $journal->supplier_id=$request->supplier;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
               $journal->added_by=auth()->user()->added_by;
                  $journal->notes= 'Courier '.$rfl->type.'  with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
                $journal->save();
            
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
                $journal->transaction_type = 'courier';
              $journal->name = 'Courier '.$rfl->type.'  Payment';
              $journal->credit = $receipt['amount'] ;
              $journal->payment_id= $payment->id;
               $journal->supplier_id=$request->supplier;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
                   $journal->added_by=auth()->user()->added_by;
                  $journal->notes=  'Courier '.$rfl->type.'   with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
              $journal->save();

                
$account= Accounts::where('account_id',$request->account_id)->first();

if(!empty($account)){
$account_balance=$account->balance - $payment->amount ;
$item_to['balance']=$account_balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->account_id)->first();

     $new['account_id']= $request->account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$payment->amount;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->id;
$account_balance=0-$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Courier '.$rfl->type.'  Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier '.$rfl->type.'  Payment with reference no ' .$movement->confirmation_number. ' to ' .$t->driver_name,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$account_balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$request->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from Courier '.$rfl->type.'  Payment . The reference is  ' .$movement->confirmation_number.' to '.$t->driver_name ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
                              
                              
     if ($rem_balance != 0) {
        
        $remaining = $rem_balance;
    }                          

   // we have already allocated required stock so no need to continue
    if ($balance === 0) {
        break;
    }


}

$rmb = $remaining;

if($rmb > 0){

$codes= AccountCodes::where('account_name','Collector Balance')->where('added_by',auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'courier';
              $journal->name = 'Courier Collector Balance';
                $journal->debit =$rmb ;
                 $journal->supplier_id=$request->supplier;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
               $journal->added_by=auth()->user()->added_by;
                $journal->notes= 'Courier Collector Balance for '.$t->driver_name;
                $journal->save();
            
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
                $journal->transaction_type = 'courier';
              $journal->name = 'Courier Collector Balance';
              $journal->credit = $rmb ;
               $journal->supplier_id=$request->supplier;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
                   $journal->added_by=auth()->user()->added_by;
                 $journal->notes= 'Courier Collector Balance for '.$t->driver_name;
              $journal->save();

}

      
                return redirect(route('courier.payment_list'))->with(['success'=>'Payment Added successfully']);
}

else{

  return redirect(route('courier.multiple_payment_list'))->with(['error'=>'Entries Not Found']);
}


            }




public function settings()
    {
      
        $data = System::where('added_by',auth()->user()->added_by)->first();
       
       if(!empty($data)){
       $id=$data->id;
       $sett=SystemConfig::where('system_id',$data->id)->first();
      }
       else{
        $id='';
     $sett='';
      }    
        
        return view('courier.settings', compact('data','sett','id'));
    }



    public function add_settings(Request $request)
    {
             $system= System::find($request->id);
         
      $list['type']='courier';
        $list['start_no']=$request->start_no;
        $list['prefix']=$request->prefix;
        $list['format']=$request->format;
        $list['system_id'] =$system->id;
        $list['added_by']= auth()->user()->added_by;

        $config=SystemConfig::find($request->config_id);
       if(!empty($config)){
        $config->update($list);
      }

     else{
 SystemConfig::create($list);

 }
        
             return redirect(route('courier.settings'))->with(['success'=>'Settings Updated']);
  

        
            
 
    }

}
