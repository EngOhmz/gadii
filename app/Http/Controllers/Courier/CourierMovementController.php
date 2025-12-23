<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Courier\CourierActivity;
use App\Models\Courier\CourierMovement;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\TruckInsurance;
use App\Models\Sticker;
use App\Models\Fuel\Fuel;
use App\Models\Mileage;
use App\Models\Route;
use App\Models\Courier\Courier;
use App\Models\Courier\CourierItem;
use App\Models\Courier\CourierInvoice;
use App\Models\Courier\CourierInvoiceItem;
use App\Models\Courier\PickupCosts;
use App\Models\Courier\PickupPayment;
use App\Models\JournalEntry;
use App\Models\AccountCodes;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\Payment_methodes;
use App\Models\Courier\CourierClient;
use App\Models\Courier\Storage;
use App\Models\Region;
use App\Models\Tariff;
use App\Models\User;
use App\Models\Courier\CourierLoading;
use App\Models\Courier\CourierCollection;
use App\Models\Courier\CourierFreight;
use App\Models\Courier\CourierFreightItems;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\SystemConfig;
use App\Models\System;

class CourierMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

 public function findTruck(Request $request)
    {

       $collect=CourierCollection::find($request->collection);
     $data['id']=$request->collection;
               $data['truck']= Truck::where('truck_status','Available')->where('location',$collect->start_location)->where('truck_type','!=','Trailer')->where('type',$request->id)->get(); 
                 $data['driver']=Driver::where('available','1')->where('type',$request->id)->where('disabled', '0')->get();   
                return response()->json(['html' => view('courier.addtruck', $data)->render()]);     

       

}

    public function show($id,Request $request)
    {
        //
         $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();

        switch ($request->type) {
            case 'collection':
           $collect=CourierCollection::find($id);
                    return view('courier.addcollection',compact('id','bank_accounts'));
                    break;
            case 'loading':
                        return view('courier.addLoading',compact('id','bank_accounts'));
                        break;
            case 'offloading':
                 $driver =Driver::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get(); 
                            return view('courier.addoffloading',compact('id','bank_accounts','driver'));
                            break;
            case 'delivering':
                                return view('courier.adddelivering',compact('id','bank_accounts'));
                                break;
              case 'fuel':
                        return view('courier.addfuel',compact('id'));
                        break;
               case 'freight':
                    $list=CourierFreightItems::where('freight_id',$id)->get();
                        return view('courier.view_freight_list',compact('id','list'));
                        break;
             default:
             return abort(404);
             
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
    }

    public function collection(){
        $user_id=auth()->user()->added_by;
       
         $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
            $supplier=Driver::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 
          $quotation = CourierCollection::where('status','2')->where('added_by', $user_id)->get();

        return view('courier.collection',compact('quotation','bank_accounts','supplier'));

    }

    public function loading(){
        $user_id=auth()->user()->added_by;

          $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $supplier=Driver::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 
        $quotation = CourierLoading::where('status','3')->where('added_by', $user_id)->get();
      
        return view('courier.loading',compact('quotation','bank_accounts','supplier'));

    }

    public function offloading(){
        $user_id=auth()->user()->added_by;
        
          $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $supplier=Driver::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 
        $quotation = CourierLoading::where('status','4')->where('added_by', $user_id)->get();
       
        return view('courier.offloading',compact('quotation','bank_accounts','supplier'));

    }

    public function delivering(){
        $user_id=auth()->user()->added_by;

         $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $supplier=Driver::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 
        $quotation = CourierLoading::where('status','5')->where('added_by', $user_id)->get();
             $storage=Storage::where('name','Weight')->first();
        return view('courier.delivering',compact('quotation','storage','bank_accounts','supplier'));

    }
  public function delivered(){
        $user_id=auth()->user()->added_by;
       
         $quotation = CourierLoading::where('status','6')->where('added_by', $user_id)->get();
        
        return view('courier.delivered',compact('quotation'));

    }


 public function wb(){
        $user_id=auth()->user()->added_by;
       
          $quotation =  CourierCollection::where('invoiced','0')->where('added_by', $user_id)->get();
        
        return view('courier.wb',compact('quotation'));

    }

 public function freight_list(){
        $user_id=auth()->user()->added_by;
        $quotation =CourierFreight::where('added_by', $user_id)->get();
       
        return view('courier.freight_list',compact('quotation'));

    }

   public function return(){
        $truck = Truck::all(); 
         $driver = Driver::all(); 
        $route=Route::all();    
      $region = Region::all();   
       $id=1;
        return view('courier.fuel',compact('region','route','driver','truck','id'));

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
        switch ($request->type) {
            case 'collection':


    $item_id=$request->checked_item_id;


  if(!empty($item_id)){
$item_count=count($item_id);
 
          $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
               

    for($i = 0; $i < count($item_id); $i++){
   if(!empty($item_id[$i])){

         $movement=CourierCollection::find($item_id[$i]);

                    $loading_cargo =CourierLoading::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,                           
                            'type'=>'non_owned',
                            'weight'=>$movement->weight,
                           'total_weight'=>$movement->weight,
                            'status'=>'3',
                              'fuel'=>'0',
                           'pacel_id'=>$movement->pacel_id,
                           'pacel_name'=>$movement->pacel_name,
                         'pacel_number'=>$movement->pacel_number,
                          'confirmation_number'=>$movement->confirmation_number,
                         'start_location'=> $movement->start_location,
                         'end_location'=>$movement->end_location,
                         'from'=> $movement->from,
                         'to'=>$movement->to,
                        'owner_id'=>$movement->owner_id,
                         'collection_id'=>$item_id[$i],
                       'collector_id' => $movement->collector_id,
                        'amount'=>$movement->amount,
                        'tariff_id'=>$movement->tariff_id,
                       'collection_date'=>$request->collection_date,
                       'collection'=> 'CT'.$random ,
                        ]
                        );                      
      

                    if(!empty($loading_cargo)){
                  $costs=($request->costs)/$item_count;                   
 
                    $activity = CourierActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                            'module_id'=>$movement->pacel_id,
                            'module'=>'Courier',
                            'activity'=>"Confirm Packaging",
                            'notes'=>$request->notes,
                             'costs'=>$costs,
                               'bank_id'=>$request->bank_id,
                             'collection_id'=>$item_id[$i],
                          'loading_id'=>$loading_cargo->id,
                           'date'=>$request->collection_date,
                        ]
                        );                      
       }
                      

            
             $data['status']='3';
           
          $result=$movement->update($data);    


          if($request->costs > 0){
 
           $receipt['pacel_id'] = $movement->pacel_id;
             $receipt['loading_id'] = $loading_cargo->id;
                 $receipt['collection_id'] =$item_id[$i];
            $receipt['route'] = $movement->tariff_id;
                $receipt['total_cost'] = $costs ;
               $receipt['due_cost'] =$costs;
               $receipt['status'] = '0' ;
                $receipt['supplier'] =  $movement->collector_id;
              $receipt['date'] = $request->collection_date;
             $receipt['account_id'] = $request->bank_id;
              $receipt['payment_type'] = $request->payment_type;
                 $receipt['type'] = 'Packaging Cost';
                $receipt['added_by'] = auth()->user()->added_by;
                
                $refill = PickupCosts::create($receipt);

          
   $codes= AccountCodes::where('account_name','Packaging Cost')->where('added_by', auth()->user()->added_by)->first();
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
                  $receipt['account_id'] =$request->bank_id;
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
              $journal->name = 'Courier Packaging Costs';
             $journal->income_id=    $refill->id;;
              $journal->notes= 'Courier Packaging Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
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
              $journal->name = 'Courier Packaging Cost';
             $journal->income_id=    $refill->id;;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Courier Packaging Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();
          

                $journal = new JournalEntry();
              $journal->account_id = $cred->id;;;
              $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
            $journal->transaction_type = 'courier';
              $journal->name = 'Courier Packaging Costs Payment';
              $journal->debit = $refill->total_cost ;
              $journal->payment_id= $payment->id;
        $journal->added_by=auth()->user()->added_by;
               $journal->notes= 'Payment for Courier Packaging Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
              $journal->save();
      
      

              $journal = new JournalEntry();
              $journal->account_id = $request->bank_id;
              $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
               $journal->transaction_type = 'courier';
              $journal->name = 'Courier Packaging Costs Payment';
              $journal->credit =$refill->total_cost ;
              $journal->payment_id= $payment->id;
               $journal->added_by=auth()->user()->added_by;
                 $journal->notes= 'Payment for Courier Packaging Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
              $journal->save();

$bank_account= Accounts::where('account_id',$request->bank_id)->first();
        if(!empty($bank_account)){
$balance=$bank_account->balance - $refill->total_cost ;
$item_to['balance']=$balance;
$bank_account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$refill->total_cost;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$refill->total_cost;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Courier Packaging Costs Payment',
                                 'module_id' => $refill->id,
                               'account_id' => $request->bank_id,
                                'code_id' => $cred->id,
                                'name' => 'Courier Packaging Costs Payment with reference no ' .$movement->confirmation_number. ' to ' .$t->driver_name,
                                'type' => 'Expense',
                                'amount' =>$refill->total_cost,
                                'debit' => $refill->total_cost,
                                 'total_balance' =>$balance,
                               'date' => date('Y-m-d', strtotime($request->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier packaging costs payment. The reference is  ' .$movement->confirmation_number.' to '.$t->driver_name ,
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
              $journal->name = 'Courier Packaging Costs';
             $journal->income_id=    $refill->id;;
              $journal->notes= 'Courier Packaging Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
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
              $journal->name = 'Courier Packaging Cost';
             $journal->income_id=    $refill->id;;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Courier Packaging Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();
          
}

}                                    

                  }
                  }

   

             $user_id=auth()->user()->added_by;
  $quotation = CourierLoading::where('status','2')->where('added_by', $user_id)->get();
                       
                        return redirect(route('courier.collection'))->with(['quotation'=> $quotation,'success'=>'Packaged Successfully']);
}

else{
$user_id=auth()->user()->added_by;
 $quotation =  CourierCollection::where('status','2')->where('added_by', $user_id)->get();
 return redirect(route('courier.collection'))->with(['quotation'=> $quotation,'error'=>'You have not chosen an entry']);
}             

                    break;



                   case 'fuel':
                        $movement=CourierLoading::find($id);
                        $result=$movement->update(['fuel'=>1]);
                         
                                                               
       $route = Route::find($movement->route_id); 
   $name=$movement->pacel_name;


       $data['route_id']=$movement->route_id;
    $data['fuel_rate']=$request->fuel;
        $data['fuel_used']=$route->distance/$request->fuel;
        $data['due_fuel']=$route->distance/$request->fuel;
        $data['added_by']=auth()->user()->added_by;
        $data['driver_id']=$movement->driver_id;
      $data['truck_id']=$movement->truck_id;
    $data['movement_id']=$movement->id;
 $data['status_approve']='0';
        $fuel= Fuel::create($data);


  $items['route_id']=$movement->route_id;
   $items['fuel_rate']=$request->mileage;
        $items['total_mileage']=$route->distance * $request->mileage;
       $items['due_mileage']=$route->distance * $request->mileage;
        $items['added_by']=auth()->user()->added_by;
        $items['driver_id']=$movement->driver_id;
      $items['truck_id']=$movement->truck_id;
    $items['movement_id']=$movement->id;
 $items['status_approve']='0';
$items['payment_status']='0';
        $mileage= Mileage ::create($items);

 $driver=Driver::find($movement->driver_id);
   $truck=Truck::find($movement->truck_id);
     
 $cr= AccountCodes::where('account_name','Mileage')->where('added_by', auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$mileage->created_at);
  $journal->date =   $mileage->created_at ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'mileage';
  $journal->name = 'Mileage';
  $journal->debit = $mileage->total_mileage ;
  $journal->income_id= $mileage->id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
     $journal->notes= "Mileage of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name ;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
  $date = explode('-',$mileage->created_at);
  $journal->date =   $mileage->created_at ;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'mileage';
  $journal->name = 'Mileage';
   $journal->income_id= $mileage->id;
  $journal->credit =$mileage->total_mileage ;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
     $journal->notes= "Mileage of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name ;
  $journal->save();


                        $user_id=auth()->user()->added_by;
                        $quotation = CourierLoading::where('status','3')->get();
                        $costs = Cost_function::all()->where('user_id',$user_id);
                       
                        return redirect(route('courier.loading'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Fuel and Mileage Assigned Successfully']);
                            break;




                    case 'loading':
                        $movement= CourierLoading::find($id);
                          $data['truck_id']=$request->truck_id;
                          $data['method']=$request->method;
                             $data['awb']=$request->awb;
                           $data['status']=4;
                        $result=$movement->update($data);


                         CourierCollection::where('id',$movement->collection_id)->update(['status' => '4']);; 
                         
                        if(!empty($result)){
                            $activity = CourierActivity::create(
                                [ 
                                    'added_by'=>auth()->user()->added_by,
                                    'module_id'=>$movement->pacel_id,
                                    'module'=>'Courier',
                                    'activity'=>"Confirm Freight",
                                    'notes'=>$request->notes,
                               'costs'=>$request->costs,
                               'bank_id'=>$request->bank_id,
                                'loading_id'=>$id,
                                  'collection_id'=>$movement->collection_id,
                                   'date'=>$request->collection_date,
                                ]
                                );                      
               }
        

           if($request->costs > 0){

        $codes= AccountCodes::where('account_name','Freight Cost')->where('added_by', auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name = 'Loading Cost';
        $journal->debit =$request->costs;
          $journal->payment_id=$movement->pacel_id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Freight Cost  with reference no " .$movement->pacel_number  ;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Loading Cost';
        $journal->credit = $request->costs;
        $journal->payment_id= $movement->pacel_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Freight Cost  with reference no " .$movement->pacel_number  ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $request->costs;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$request->costs;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$request->costs;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Freight Cost',
                                 'module_id' => $movement->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Freight Cost  with reference no ' .$movement->pacel_number,
                                'type' => 'Expense',
                                'amount' =>$request->costs,
                                'debit' => $request->costs,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier freight cost.The Reference is ' .$movement->pacel_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);       

}


                        $user_id=auth()->user()->added_by;
                        $quotation = CourierLoading::where('status','4')->get();
                       
                        return redirect(route('courier.offloading'))->with(['quotation'=> $quotation,'success'=>'Freighted Successfully']);
                            break;


                       case 'offloading':

 $item_id=$request->checked_item_id;

  if(!empty($item_id)){
$item_count=count($item_id);
 
          $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
               

    for($i = 0; $i < count($item_id); $i++){
   if(!empty($item_id[$i])){

                                $movement=CourierLoading::find($item_id[$i]);
                                    $it['status']=5;
                                     $it['destination_receiver']=$request->receiver_id;
                                   $it['destination']= 'CT'.$random ;
                                $result=$movement->update($it);

                                  CourierCollection::where('id',$movement->collection_id)->update(['status' => '5']);; 
                                 
                                if(!empty($result)){

                                     $costs=($request->costs)/$item_count;

                                    $activity = CourierActivity::create(
                                        [ 
                                            'added_by'=>auth()->user()->added_by,
                                            'module_id'=>$movement->pacel_id,
                                            'module'=>'Courier',
                                            'activity'=>"Confirm Commission",
                                            'notes'=>$request->notes,
                                            'loading_id'=>$item_id[$i],
                                          'costs'=>$costs,
                                        'bank_id'=>$request->bank_id,
                                           'collection_id'=>$movement->collection_id,
                                           'date'=>$request->collection_date,
                                        ]
                                        );                      
                       }

 
                                if($request->costs > 0){

       $receipt['pacel_id'] = $movement->pacel_id;
             $receipt['loading_id'] = $item_id[$i];
            $receipt['collection_id'] =$movement->collection_id;
            $receipt['route'] = $movement->tariff_id;
                $receipt['total_cost'] = $costs ;
               $receipt['due_cost'] =$costs;
               $receipt['status'] = '0' ;
                $receipt['supplier'] =  $request->receiver_id;
              $receipt['date'] = $request->collection_date;
             $receipt['account_id'] = $request->bank_id;
              $receipt['payment_type'] = $request->payment_type;
                 $receipt['type'] = 'Commission Cost';
                $receipt['added_by'] = auth()->user()->added_by;

     $refill = PickupCosts::create($receipt);

        $codes= AccountCodes::where('account_name','Commission Cost')->where('added_by', auth()->user()->added_by)->first();
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
                  $receipt['account_id'] =$request->bank_id;
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
              $journal->name = 'Courier Commission Costs';
             $journal->income_id=    $refill->id;;
              $journal->notes= 'Courier Commission Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
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
              $journal->name = 'Courier Commission Cost';
             $journal->income_id=    $refill->id;;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Courier Commission Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id = $cred->id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name = 'Courier Commission Costs Payment';
        $journal->debit =$refill->total_cost ;
          $journal->payment_id=$payment->id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= 'Payment for Courier Commission Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Courier Commission Costs Payment';
        $journal->credit = $refill->total_cost ;
        $journal->payment_id= $payment->id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= 'Payment for Courier Commission Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $refill->total_cost;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0- $refill->total_cost;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0- $refill->total_cost;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Commission Cost',
                                 'module_id' => $movement->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $cred->id,
                                'name' =>'Courier Commission Costs Payment with reference no ' .$movement->confirmation_number. ' to ' .$t->driver_name,
                                'type' => 'Expense',
                                'amount' => $refill->total_cost,
                                'debit' =>  $refill->total_cost,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->collection_date)),
                                   'status' => 'paid' ,
                                'notes' =>'This expense is from courier commission costs payment. The reference is  ' .$movement->confirmation_number.' to '.$t->driver_name ,
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
              $journal->name = 'Courier Commission Costs';
             $journal->income_id=    $refill->id;;
              $journal->notes= 'Courier Commission Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
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
              $journal->name = 'Courier Commission Cost';
             $journal->income_id=    $refill->id;;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Courier Commission Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();

}    

}


 }
                  }


                                $quotation =  CourierLoading::where('status','4')->where('added_by', auth()->user()->added_by)->get();
                               
                                return redirect(route('courier.offloading'))->with(['quotation'=> $quotation,'success'=>'Commissioned Successfully']);

}

else{

 $quotation =  CourierLoading::where('status','4')->where('added_by', auth()->user()->added_by)->get();
 return redirect(route('courier.offloading'))->with(['quotation'=> $quotation,'error'=>'You have not chosen an entry']);
}
                                    break;


                                    case 'delivering':

                                        $item_id=$request->checked_item_id;

  if(!empty($item_id)){
$item_count=count($item_id);

if($item_count > 1){
    for($i = 1, $j=0; $i < count($item_id); $i++){

     $client_one=CourierLoading::where('id',$item_id[$i])->first(); 
      $client=CourierLoading::where('id',$item_id[$j])->first(); 


   //$result = array_diff( $client_one->owner_id,$client->owner_id);


   if($client_one->owner_id !=$client->owner_id ){
return redirect()->back()->with(['error'=>'You have Chosen different Client']);
    }

}
}

 
          $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
               

    for($i = 0; $i < count($item_id); $i++){
   if(!empty($item_id[$i])){

                                        $movement=CourierLoading::find($item_id[$i]);
                                        $data['status']=6;

                                               $off=CourierActivity::where('loading_id',$id)->where('activity','Confirm Commission')->first();
                                            
                                           /*
                                               $storage=Storage::where('name','Weight')->first();
                                               $courier=Courier::where('id',$movement->pacel_id)->first();
                                              $s=$storage->days;
                                              $today = date('Y-m-d', strtotime($request->collection_date));
                                              $next= date('Y-m-d', strtotime("+$s days", strtotime($off->date))) ;

                                              if ($today >= $next) {
                                            $now = strtotime($today);; // or your date as well
                                           $your_date = strtotime($next);
                                           $datediff = $now - $your_date;

                                         $x= round($datediff / (60 * 60 * 24));
                                        $price=$x *($storage->price/$courier->exchange_rate) * $movement->weight;
                                         }

                                     else{
                                     $price=0;
                                                }

                                             $data['storage_costs']=$price;
                                           $items['storage_costs']=$price;
                                       */

                                            $data['receiver_name']=$request->receiver_name; 
                                           $data['receiver_phone']=$request->receiver_phone;                                            
                                            $data['delivery_receiver']=$request->receiver_id;
                                           $data['delivery']= 'CT'.$random ;
                                        $result=$movement->update($data);

                                         
                                           $items['status']=6;

                                        CourierCollection::where('id',$movement->collection_id)->update($items);; 
                                         
                                        if(!empty($result)){

                                       $costs=($request->costs)/$item_count;
                                            $activity = CourierActivity::create(
                                                [ 
                                                    'added_by'=>auth()->user()->added_by,
                                                    'module_id'=>$movement->pacel_id,
                                                    'module'=>'Courier',
                                                    'activity'=>"Confirm Delivery",
                                                 'loading_id'=>$item_id[$i],
                                                 'costs'=>$costs,
                                                'bank_id'=>$request->bank_id,
                                                   'collection_id'=>$movement->collection_id,
                                                    'notes'=>$request->notes,
                                                   'date'=>$request->collection_date,
                                                ]
                                                );                      
                               }


 
                                if($request->costs > 0){

        $receipt['pacel_id'] = $movement->pacel_id;
             $receipt['loading_id'] = $item_id[$i];
         $receipt['collection_id'] =$movement->collection_id;
            $receipt['route'] = $movement->tariff_id;
                $receipt['total_cost'] = $costs ;
               $receipt['due_cost'] =$costs;
               $receipt['status'] = '0' ;
                $receipt['supplier'] =  $request->receiver_id;
              $receipt['date'] = $request->collection_date;
             $receipt['account_id'] = $request->bank_id;
              $receipt['payment_type'] = $request->payment_type;
                 $receipt['type'] = 'Delivery Cost';
                $receipt['added_by'] = auth()->user()->added_by;

     $refill = PickupCosts::create($receipt);

        $codes= AccountCodes::where('account_name','Delivery Cost')->where('added_by', auth()->user()->added_by)->first();
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
                  $receipt['account_id'] =$request->bank_id;
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
              $journal->name = 'Courier Delivery Costs';
             $journal->income_id=    $refill->id;;
              $journal->notes= 'Courier Delivery Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
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
              $journal->name = 'Courier Delivery Cost';
             $journal->income_id=    $refill->id;;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Courier Delivery Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id = $cred->id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name =  'Courier Delivery Cost Payment';
        $journal->debit =$refill->total_cost ;
          $journal->payment_id=$payment->id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= 'Payment for Courier Delivery Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name  ;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name =  'Courier Delivery Cost Payment';
        $journal->credit = $refill->total_cost ;
        $journal->payment_id= $payment->id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= 'Payment for Courier Delivery Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name  ;  ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance - $refill->total_cost;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$refill->total_cost;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$refill->total_cost;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Delivery Cost',
                                 'module_id' => $movement->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Delivery Costs Payment with reference no ' .$movement->confirmation_number. ' to ' .$t->driver_name,
                                'type' => 'Expense',
                                'amount' =>$refill->total_cost,
                                'debit' => $refill->total_cost,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier commission costs payment. The reference is  ' .$movement->confirmation_number.' to '.$t->driver_name,
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
              $journal->name = 'Courier Delivery Costs';
             $journal->income_id=    $refill->id;;
              $journal->notes= 'Courier Delivery Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
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
              $journal->name = 'Courier Delivery Cost';
             $journal->income_id=    $refill->id;;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Courier Delivery Costs with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();
}    

}


 }
                  }


                                $quotation =  CourierLoading::where('status','5')->where('added_by', auth()->user()->added_by)->get();                               
                                return redirect(route('courier.delivering'))->with(['quotation'=> $quotation,'success'=>'Delivered Successfully']);

}

else{

 $quotation =  CourierLoading::where('status','5')->where('added_by', auth()->user()->added_by)->get(); 
 return redirect(route('courier.delivering'))->with(['quotation'=> $quotation,'error'=>'You have not chosen an entry']);
}
                        
                                     
                                            break;


                         case 'driver':
              
                                                               
       $route = Route::find($request->route_id); 
  
       $data['route_id']=$request->route_id;
    $data['fuel_rate']=$request->fuel;
        $data['fuel_used']=$route->distance/$request->fuel;
        $data['due_fuel']=$route->distance/$request->fuel;
        $data['added_by']=auth()->user()->added_by;
        $data['driver_id']=$request->driver_id;
      $data['truck_id']=$request->truck_id;
 $data['status_approve']='0';
        $fuel= Fuel::create($data);


  $items['route_id']=$request->route_id;
   $items['fuel_rate']=$request->mileage;
        $items['total_mileage']=$route->distance * $request->mileage;
       $items['due_mileage']=$route->distance * $request->mileage;
        $items['added_by']=auth()->user()->added_by;
        $items['driver_id']=$request->driver_id;
      $items['truck_id']=$request->truck_id;
 $items['status_approve']='0';
$items['payment_status']='0';
        $mileage= Mileage ::create($items);

 $driver=Driver::find($request->driver_id);
   $truck=Truck::find($request->truck_id);
     
 $cr= AccountCodes::where('account_name','Mileage')->where('added_by', auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$mileage->created_at);
  $journal->date =   $mileage->created_at ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'mileage';
  $journal->name = 'Mileage';
  $journal->debit = $mileage->total_mileage ;
  $journal->income_id= $mileage->id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
     $journal->notes= "Mileage to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name ;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
  $date = explode('-',$mileage->created_at);
  $journal->date =   $mileage->created_at ;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'mileage';
  $journal->name = 'Mileage';
   $journal->income_id= $mileage->id;
  $journal->credit =$mileage->total_mileage ;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
     $journal->notes= "Mileage  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name ;
  $journal->save();


$region=Region::where('name',$route->to)->first();
   $truck->update(['location'=>$region->id]);             
                   
                       
                        return redirect(route('courier.return'))->with(['success'=>'Fuel and Mileage Assigned Successfully']);
                            break;


             default:
             return abort(404);
             
            }




    }

public function save_freight(Request $request)
    {


$item_id=$request->checked_item_id;
//dd($item_id);
 if(!empty($item_id)){

$item_count=count($item_id);

$random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);

  if(!empty($item_id)){
    for($i = 0; $i < 1; $i++){
   if(!empty($item_id[$i])){

$count=CourierFreight::count();
        $pro=$count+1;

  $invoice= array(
   'freight_number' => 'CF0'.$pro ,
   'collection_date' => $request->collection_date ,
     'status' => '4'  ,
    'truck_id'=>$request->truck_id,
    'method'=>$request->method,
     'awb'=>$request->awb,
       'total_freight'=>$request->costs,
     'added_by'=>auth()->user()->added_by,
           );

$pacel=CourierFreight::create($invoice);  ;

}
}
}


     $total = 0;
        $cost['amount'] = 0;
     $cost['weight'] = 0;
      $storage=0;
  if(!empty($item_id)){
    for($i = 0; $i < count($item_id); $i++){
   if(!empty($item_id[$i])){
         
         $movement=CourierLoading::where('id',$item_id[$i])->first(); 
             
           $cost['amount'] += $movement->amount;
              //$cost['weight'] += $movement->total_weight;

                 $freight=($request->costs)/$item_count;
    
                  $items = array(                    
                            'type'=>'non_owned',
                            'weight'=>$movement->weight,
                           'total_weight'=>$movement->weight,
                            'status'=>'4',
                              'fuel'=>'0',
                           'pacel_id'=>$movement->pacel_id,
                           'pacel_name'=>$movement->pacel_name,
                         'pacel_number'=>$movement->pacel_number,
                          'confirmation_number'=>$movement->confirmation_number,
                         'start_location'=> $movement->start_location,
                         'end_location'=>$movement->end_location,
                        'owner_id'=>$movement->owner_id,
                         'loading_id'=>$item_id[$i],
                       'collector_id' => $request->receiver_id ,
                        'amount'=>$movement->amount,
                        'collection_date' => $request->collection_date ,
                         'truck_id'=>$request->truck_id,
                        'method'=>$request->method,
                         'awb'=>$request->awb,
                         'freight_costs'=> $freight,
                        'tariff_id'=>$movement->tariff_id,
                       'collection_date'=>$request->collection_date,
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'freight_id' =>$pacel->id);

                 CourierFreightItems::create($items);  ;                   

                  }
                  }

                $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                $cost['confirmation_number'] = "CF".$random.$pacel->id;
                //$cost['total_weight'] =  $cost['weight'] ;
               CourierFreight::where('id',$pacel->id)->update($cost);

                }


if(!empty($item_id)){
    for($i = 0; $i < count($item_id); $i++){
   if(!empty($item_id[$i])){

 $freight=($request->costs)/$item_count;
 
                  $loading= CourierLoading::find($item_id[$i]);
                          $list['truck_id']=$request->truck_id;
                          $list['method']=$request->method;
                             $list['awb']=$request->awb;
                           $list['status']=4;
                              $list['freight_receiver']=$request->receiver_id;;
                            $list['freight']= 'CT'.$random ;

                        $result=$loading->update($list);

                          CourierCollection::where('id',$loading->collection_id)->update(['status' => '4']);; 
                         
                        if(!empty($result)){
                            $activity = CourierActivity::create(
                                [ 
                                    'added_by'=>auth()->user()->added_by,
                                    'module_id'=>$loading->pacel_id,
                                    'module'=>'Courier',
                                    'activity'=>"Confirm Freight",
                                    'notes'=>$request->notes,
                               'costs'=> $freight,
                               'bank_id'=>$request->bank_id,
                              'collection_id'=>$loading->collection_id,
                                'loading_id'=>$item_id[$i],
                                   'date'=>$request->collection_date,
                                ]
                                );                      
               }
        

           if($request->costs > 0){

         
                  $receipt['pacel_id'] = $loading->pacel_id;
             $receipt['loading_id'] = $item_id[$i];
               $receipt['collection_id'] =$loading->collection_id;
            $receipt['route'] = $loading->tariff_id;
                $receipt['total_cost'] =  $freight ;
               $receipt['due_cost'] = $freight;
               $receipt['status'] = '0' ;
                $receipt['supplier'] =  $request->receiver_id;
              $receipt['date'] = $request->collection_date;
             $receipt['account_id'] = $request->bank_id;
              $receipt['payment_type'] = $request->payment_type;
                 $receipt['type'] = 'Freight Cost';
                $receipt['added_by'] = auth()->user()->added_by;
                
                $refill = PickupCosts::create($receipt);

      $t=Driver::find($refill->supplier);

        $codes= AccountCodes::where('account_name','Freight Cost')->where('added_by', auth()->user()->added_by)->first();
          $cr= AccountCodes::where('added_by',auth()->user()->added_by)->where('account_name','Payables')->first();

                   if($refill->payment_type == 'cash'){  

                       $method= Payment_methodes::where('name','Cash')->first();

               $receipt['trans_id'] = "TRANS_CPC-".$refill->id.'-'. substr(str_shuffle(1234567890), 0, 1);
                $receipt['added_by'] = auth()->user()->added_by;
                 $receipt['pacel_id'] =$refill->pacel_id;
            $receipt['pickup_id'] =$refill->id;
               $receipt['amount'] = $refill->total_cost;
                $receipt['date'] = $refill->date;
                 $receipt['payment_method'] = $method->id;
                  $receipt['account_id'] =$request->bank_id;
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
              $journal->name = 'Courier Freight Costs';
             $journal->income_id=    $refill->id;;
              $journal->notes= 'Courier Freight Costs with reference no ' .$loading->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->added_by= auth()->user()->added_by;;
        $journal->debit =   $refill->total_cost ;
        $journal->save();

         $journal = new JournalEntry();
        $journal->account_id = $cr->id;;
        $date = explode('-',  $refill->date);
         $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
       $journal->transaction_type = 'courier';
              $journal->name = 'Courier Freight Cost';
             $journal->income_id=    $refill->id;;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Courier Freight Costs with reference no ' .$loading->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();


 
        $journal = new JournalEntry();
        $journal->account_id = $cr->id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier';
        $journal->name = 'Courier Freight Costs Payment';
        $journal->debit =$refill->total_cost ;;
          $journal->payment_id=$payment->id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= 'Payment for Courier Freight Costs with reference no ' .$loading->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();


          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Courier Freight Costs Payment';
        $journal->credit = $refill->total_cost ;;
        $journal->payment_id= $loading->pacel_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= 'Payment for Courier Freight Costs with reference no ' .$loading->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $freight;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$freight;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$freight;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Courier Freight Cost Payment',
                                 'module_id' => $loading->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Freight Costs Payment with reference no ' .$movement->confirmation_number. ' to ' .$t->driver_name,
                                'type' => 'Expense',
                                'amount' =>$freight,
                                'debit' => $freight,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier freight costs payment. The reference is  ' .$loading->confirmation_number.' to '.$t->driver_name ,
                                'added_by' =>auth()->user()->added_by,
                            ]);       

}

}

    else if($refill->payment_type == 'credit'){

  $journal = new JournalEntry();
               $journal->account_id =     $codes->id ;;
              $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
             $journal->transaction_type = 'courier';
              $journal->name = 'Courier Freight Costs';
             $journal->income_id=    $refill->id;;
              $journal->notes= 'Courier Freight Costs with reference no ' .$loading->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->added_by= auth()->user()->added_by;;
        $journal->debit =   $refill->total_cost ;
        $journal->save();

         $journal = new JournalEntry();
        $journal->account_id = $cr->id;;
        $date = explode('-',  $refill->date);
         $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
       $journal->transaction_type = 'courier';
              $journal->name = 'Courier Freight Cost';
             $journal->income_id=    $refill->id;;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Courier Freight Costs with reference no ' .$loading->confirmation_number.' on Cash Payment to  '.$t->driver_name;
        $journal->save();
          
}


}
}
}


               $quotation = CourierLoading::where('status','3')->where('added_by', auth()->user()->added_by)->get();
                       
                        return redirect(route('courier.loading'))->with(['quotation'=> $quotation,'success'=>'Freighted Successfully']);
}

else{
 $quotation = CourierLoading::where('status','3')->where('added_by', auth()->user()->added_by)->get();
 return redirect(route('courier.loading'))->with(['quotation'=> $quotation,'error'=>'You have not chosen an entry']);
}


}


    

public function save_wb(Request $request)
    {


$item_id=$request->checked_item_id;

 if(!empty($item_id)){

   for($i = 0; $i < count($item_id); $i++){

      $client=CourierCollection::where('id',$item_id[$i])->first(); 
       $exchange=Courier::find($client->pacel_id);
       
       $range[]=[
            'client'=>$client->owner_id,
            'exchange'=>$exchange->currency_code,
        ];


}



$diff=count($item_id);

if($diff > 1){
          
  //dd($range);           
        $result=(count(array_unique($range, SORT_REGULAR)) === 1);
//dd($result); 

 if($result != true)  {
  return redirect()->back()->with(['error'=>'You have Chosen cargo with different Client/Currency']);   
 }             
        
}


  if(!empty($item_id)){
    for($i = 0; $i < 1; $i++){
   if(!empty($item_id[$i])){

   $collection=CourierCollection::where('id',$item_id[$i])->first(); 
   $good=Courier::find($collection->pacel_id);




 $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
  $sys = System::where('added_by',auth()->user()->added_by)->first();
       $config=SystemConfig::where('system_id',$sys->id)->where('type','courier')->first();


            $client = CourierClient::find($collection->owner_id);

        if(!empty($client->code)){

        if(!empty($config)){
          $count =CourierInvoice::where('added_by',auth()->user()->added_by)->count();  
        if($count > 0){
        $pro=$count+1;
       }

        else{
           $pro=$config->start_no;
           }

         $reference=$config->prefix.'/'.$client->code.'/00'.$pro;
         }

     else{
 $count=CourierInvoice::where('added_by',auth()->user()->added_by)->count();
        $pro=$count+1;
       $reference=$client->code.'/00'.$pro;
}


         }

else{

        if(!empty($config)){
          $count = CourierInvoice::where('added_by',auth()->user()->added_by)->count();  
        if($count > 0){
        $pro=$count+1;
       }

        else{
           $pro=$config->start_no;
           }

         $reference=$config->prefix.'/00'.$pro;
         }

     else{
 $count=CourierInvoice::where('added_by',auth()->user()->added_by)->count();
        $pro=$count+1;
       $reference='CINV00'.$pro;
}


         }





  $invoice= array(
  'confirmation_number' =>$reference ,
   'date' => date('Y-m-d') ,
     'owner_id' => $collection->owner_id ,
     'discount' => '0'  ,
     'status' => '0'  ,
     'currency_code' =>  $good->currency_code,
     'exchange_rate' =>  $good->exchange_rate,
     'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,

           );

$pacel=CourierInvoice::create($invoice);  ;

}
}
}


     $total = 0;
        $cost['tax'] = 0;
     //$cost['weight'] = 0;
      $storage=0;
  if(!empty($item_id)){
    for($i = 0; $i < count($item_id); $i++){
   if(!empty($item_id[$i])){
         
         $collect=CourierCollection::where('id',$item_id[$i])->first(); 
              $acc =CourierItem::where('id',$collect->item_id)->first(); ;
                $sales =Courier::where('id',$collect->pacel_id)->first(); ;

          $total += $acc->total_cost;
           $storage+= $collect->storage_costs;
            $cost['tax'] +=$acc->total_tax;
              //$cost['weight'] += $acc->quantity;
    
                  $items = array(
                     'item_name' => $acc->item_name,
                    'tariff_type' => $acc->tariff_type,
                    'quantity' =>    $acc->quantity,
                    'tax_rate' =>   $acc->tax_rate,
                     'unit' =>  $acc->unit,
                     'price' =>   $acc->price,
                    'total_cost' =>   $acc->total_cost,
                  'storage_costs' =>   $collect->storage_costs,
                    'total_tax' =>   $acc->total_tax,
                     'items_id' =>  $acc->items_id,
                      'from_region_id' =>$sales->from_region_id,
                        'to_region_id' => $acc->to_region_id ,
                         'from_district_id' =>$sales->from_district_id,
                        'to_district_id' => $acc->to_district_id ,  
                      'collection_id' => $item_id[$i] ,
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'pacel_id' =>$pacel->id);

                 CourierInvoiceItem::create($items);  ;

                   CourierCollection::where('id',$item_id[$i])->update(['invoiced' => '1']);

                  }
                  }

               
                $cost['pacel_number'] = "CINV".$random.$pro;
                $cost['due_amount'] =  $cost['tax'] +  $total + $storage;
                $cost['amount'] =  $cost['tax'] +  $total + $storage;
                CourierInvoice::where('id',$pacel->id)->update($cost);


               /*
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
           $journal->notes= "Courier Invoice with reference no " .$quot->pacel_number. "  by Client ".  $client->name ;
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
           $journal->notes= "Courier Invoice Tax with reference no " .$quot->pacel_number. "  by Client ".  $client->name ;
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
           $journal->notes= "Courier Debit Receivables for Invoice with reference no " .$quot->pacel_number. "  by Client ".  $client->name ;
        $journal->save();

*/

                }

                return redirect(route('wb.courier'))->with(['success'=>'Created Successfully']);
}

else{
  return redirect(route('wb.courier'))->with(['error'=>'You have not chosen an entry']);
}


}

  public function findPrice(Request $request)
    {

              $date = today()->addDays(10)->format('Y-m-d');

               $data=TruckInsurance::leftJoin('stickers', 'stickers.truck_id','truck_insurances.truck_id')
               ->where('truck_insurances.truck_id',$request->id)
               ->where('truck_insurances.expire_date', '<=', $date) 
                 ->orwhere('stickers.truck_id',$request->id)
               ->orwhere('stickers.expire_date', '<=', $date)      
            ->select('stickers.*','truck_insurances.*')
        ->get();
               $id= $request->id;
              if(!empty($data[0])){
                 return response()->json($data);;
                 }                 

    }



public function report(Request $request)
    {
 //
        $region = Region::all();
         $client = CourierClient::where('user_id',auth()->user()->added_by)->get();
     


if ($request->ajax()) {
            $data =CourierCollection::query();
            $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
            $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');
            $status = (!empty($_GET["status"])) ? ($_GET["status"]) : ('');
            $from = (!empty($_GET["from"])) ? ($_GET["from"]) : ('');
            $to = (!empty($_GET["to"])) ? ($_GET["to"]) : ('');
             $client= (!empty($_GET["client_id "])) ? ($_GET["client_id "]) : ('');

     //filter selected columns
            if($start_date && $end_date){
             $start_date = date('Y-m-d', strtotime($start_date));
             $end_date = date('Y-m-d', strtotime($end_date));
             $data->whereRaw("date(courier_collection.collection_date) >= '" . $start_date . "' AND date(courier_collection.collection_date) <= '" . $end_date . "'");
            }
            if($from && $from!="all")
            $data->whereRaw("courier_collection.start_location = '" . $from . "'");
            if($to && $to!="all")
            $data->whereRaw("courier_collection.end_location = '" . $to . "'");
            if($client && $client!="all")
            $data->whereRaw("courier_collection.owner_id = '" . $client . "'");
            if($status && $status!="all")
            $data->whereRaw("courier_collection.status = '" . $status . "'");

            if(auth()->user()->client_id != null){
$data->where('owner_id',auth()->user()->client_id);
}
else{
$data->where('added_by',auth()->user()->added_by);
}
          

            

                  
           if(auth()->user()->client_id != null){
$data2 = $data->select('*')->where('owner_id',auth()->user()->client_id);
}
else{
$data2 = $data->select('*')->where('added_by',auth()->user()->added_by);
}

            return Datatables::of($data2)
                    ->addIndexColumn()
                    ->editColumn('date', function ($row) {
                        $newDate = date("d/m/Y", strtotime($row->collection_date));
                        return $newDate;
                   })
                   ->editColumn('pacel_number', function ($row) {
                    return $row->pacel_number;
               })
                    ->editColumn('wb', function ($row) {
                    return $row->wbn_no;
               })
               ->editColumn('client', function ($row) {
                $user = CourierClient::find($row->owner_id);
                    return  $user->name;
           })
                  
                    ->editColumn('from_to', function ($row) {
                       $from = Region::find($row->start_location);
                        $end= Region::find($row->end_location);
                        return $from->name. ' - ' .$end->name;
                   })

                     ->editColumn('zone', function ($row) {
                       $t = Tariff::find($row->tariff_id);
                        if(!empty($t)){
                        return $t->zone_name. ' - ' .$t->weight;
                        }
                        else{
                        return $row->tariff_id;
                        }
                   })

                  
                    
                    ->editColumn('status', function ($row) {
                        if($row->status == 2)
                         return '<div class="badge badge-warning badge-shadow">Picked</div>';
                         elseif($row->status == 3)
                         return '<div class="badge badge-primary badge-shadow">Packaged</div>';
                        elseif($row->status == 4)
                        return '<div class="badge badge-info badge-shadow">Freighted</div>';
                        elseif($row->status == 5)
                        return '<div class="badge badge-primary badge-shadow">Commissioned</div>';
                        elseif($row->status == 6)
                        return '<div class="badge badge-success  badge-shadow">Delivered</div>';
                        
                    })
                    ->rawColumns(['status','date','pacel_number','from_to'])
                   
                    
                    ->make(true);
        }

      
        return view('courier.report',compact('region','client'));
    

    }

 public function findReport (Request $request)
    {

         $data['report'] = CourierLoading::query();

          if(!empty($request->from)){
              $data['report'] = $data['report']->where('start_location',$request->from);
}
 if(!empty($request->to)){
              $data['report'] =$data['report']->where('end_location',$request->to);
}
 if(!empty($request->status)){
              $data['report'] = $data['report']->where('status',$request->status);
}
 if(!empty($request->client_id)){
              $data['report'] = $data['report']->where('owner_id',$request->client_id);
}
 if(!empty($request->start_date) && !empty($request->end_date)){
              $data['report'] =$data['report']->whereBetween('collection_date',  [$request->start_date, $request->end_date]);
}

$data['report']=$data['report']->where('activity',0)->get();
            
               $data['region'] = Region::all();
                 $data['client'] = CourierClient::where('user_id',auth()->user()->added_by)->get();
               // return response()->json($report);;
                   return response()->json(['html' => view('courier.addreport', $data)->render()]);           

    }

public function cost_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (CourierCollection::where('added_by',auth()->user()->added_by) as $key) {
          $chart_of_accounts[$key->id] = $key->pacel_number;
        }
        if($request->isMethod('post')){

          if(auth()->user()->client_id != null){
          $data=CourierCollection::whereBetween('collection_date',[$start_date,$end_date])->where('owner_id',auth()->user()->client_id)->get();
               }else{
            $data=CourierCollection::whereBetween('collection_date',[$start_date,$end_date])->where('added_by',auth()->user()->added_by)->get();
              }
        }else{
            $data=[];
        }

       

        return view('courier.cost_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }

public function courier_tracking (Request $request)
    {
       
       $reference = str_replace('"', '',$request->reference);;
       
       $rt = substr($reference, 0, 5);
      

        if($request->isMethod('post')){
        //dd($rt);
        
        if($rt == "00000"){
            $x= substr($reference, 5);
            $str= substr($x, 0,6);
           
        }
        else{
             $str = $reference;
        }
          
           //dd($str);
         $courier=CourierCollection::where('wbn_no', 'like', "%{$str}%")->where('added_by', auth()->user()->added_by)->orWhere('pacel_number', 'like', "%{$str}%")->where('added_by', auth()->user()->added_by)->first();
        //dd($courier);     
             
             if(!empty($courier)){
             $data=CourierActivity::leftJoin('courier_collection', 'courier_collection.id','courier_activities.collection_id')
               ->where('courier_collection.wbn_no', 'like', "%{$str}%")  
               ->where('courier_collection.added_by', auth()->user()->added_by)  
               ->orWhere('courier_collection.pacel_number', 'like', "%{$str}%")
               ->where('courier_collection.added_by', auth()->user()->added_by)
            ->select('courier_collection.*','courier_activities.*')
              ->orderBy('courier_activities.id', 'desc')  
               ->get();
            }
      else{
        $data=[];
}

        }else{
            $data=[];
           $courier=[];
        }

       

        return view('courier.tracking_report',
            compact('reference','data','courier'));
    }

public function tracking (Request $request)
    {
       
     $reference = $request->reference;

        if($request->isMethod('post')){

          
          
            $courier=CourierCollection::where('pacel_number', 'like', "%{$reference}%")->first();
             if(!empty($courier)){
             $data=CourierActivity::leftJoin('courier_collection', 'courier_collection.id','courier_activities.collection_id')
               ->where('courier_collection.pacel_number', 'like', "%{$reference}%")  
            ->select('courier_collection.*','courier_activities.*')
              ->orderBy('courier_activities.id', 'desc')  
               ->get();
            }
      else{
        $data=[];
}

        }else{
            $data=[];
           $courier=[];
        }


       

        return view('tracking',
            compact('reference','data','courier'));
    }
}
