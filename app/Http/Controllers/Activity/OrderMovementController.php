<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Models\orders\Activity;
use App\Models\orders\Cost_function;
use App\Models\orders\OrderMovement;
use App\Models\orders\Order;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\TruckInsurance;
use App\Models\Sticker;
use App\Models\Fuel\Fuel;
use App\Models\Fuel\Refill;
use App\Models\Mileage;
use App\Models\Route;
use App\Models\Permit\Permit;
use App\Models\Permit\PermitType;
use App\Models\Permit\PermitPayment;
use App\Models\Pacel\Pacel;
use App\Models\Pacel\PacelItem;
use App\Models\Pacel\PacelInvoice;
use App\Models\Pacel\PacelInvoiceItem;
use App\Models\JournalEntry;
use App\Models\AccountCodes;
use App\Models\Client;
use App\Models\Supplier;
use App\Models\Region;
use App\Models\Currency;
use App\Models\User;
use App\Models\CargoLoading;
use App\Models\CargoCollection;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use PDF;

class OrderMovementController extends Controller
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

       $collect=CargoCollection::find($request->collection);
     $data['id']=$request->collection;
               $data['truck']= Truck::where('truck_status','Available')->where('location',$collect->from_region_id)->where('truck_type','!=','Trailer')->where('type',$request->id)->where('disabled','0')->where('added_by',auth()->user()->added_by)->get(); 
                 $data['driver']=Driver::where('available','1')->where('type',$request->id)->where('added_by',auth()->user()->added_by)->get();   
                return response()->json(['html' => view('order_movement.addtruck', $data)->render()]);     

       

}

  public function findDriver(Request $request)
    {

               $truck=Truck::find($request->id);
                 if(!empty($truck->driver)){
               $driver=Driver::find($truck->driver);
               
                   
}      

else{
            $driver='Please Assign Driver to the Truck.';
}

   return response()->json($driver);     
    }

    public function show($id,Request $request)
    {
        //
        switch ($request->type) {
            case 'collection':
           $collect=CargoCollection::find($id);
               $truck = Truck::where('truck_status','Available')->where('location',$collect->from_region_id)->where('truck_type','!=','Trailer')->where('added_by',auth()->user()->added_by)->get(); 
                 $driver =Driver::where('available','1')->where('added_by',auth()->user()->added_by)->get(); 
                    return view('order_movement.addcollection',compact('id','truck','driver'));
                    break;
            case 'loading':
                        return view('order_movement.addloading',compact('id'));
                        break;
            case 'offloading':
                            return view('order_movement.addoffloading',compact('id'));
                            break;
            case 'delivering':
                                return view('order_movement.adddelivering',compact('id'));
                                break;
              case 'fuel':
                 
                  
                        return view('order_movement.addfuel',compact('id'));
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
       
          $quotation = CargoCollection::where('added_by', auth()->user()->added_by)->where('status','2')->get();
        $costs = Cost_function::all()->where('user_id',$user_id);

        return view('order_movement.collection',compact('quotation','costs'));

    }

    public function loading(){
        $user_id=auth()->user()->added_by;
        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','3')->get();
        $costs = Cost_function::all()->where('user_id',$user_id);

        return view('order_movement.loading',compact('quotation','costs'));

    }

    public function offloading(){
        $user_id=auth()->user()->added_by;
        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','4')->get();
        $costs = Cost_function::all()->where('user_id',$user_id);
       
        return view('order_movement.offloading',compact('quotation','costs'));

    }

    public function delivering(){
        $user_id=auth()->user()->added_by;
        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','5')->orwhere('status','6')->get();
        $costs = Cost_function::all()->where('user_id',$user_id);

        return view('order_movement.delivering',compact('quotation','costs'));

    }
    
    public function driver_checklist_report($id){
         
         $cargo = CargoLoading::find($id);

        return view('order_movement.driver_checklist_report',compact('cargo'));   
    }
    
    public function driver_checklist_report_pdf($id){
         
         $cargo = CargoLoading::find($id);
         
         $pdf = PDF::loadView('order_movement.driver_checklist_report_pdf',
            compact('cargo'))->setPaper('a4', 'potrait');
        
        return $pdf->download("DRIVER CHECK LIST.pdf");
    }
    
   public function return(){
        $truck = Truck::where('truck_status','Available')->where('truck_type','!=','Trailer')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();  
         $driver = Driver::where('disabled','0')->where('added_by',auth()->user()->added_by)->get(); 
        $route=Route::all();    
      $region = Region::all();   
       $id=1;
        return view('order_movement.fuel',compact('region','route','driver','truck','id'));

    }

      public function wb(){
        $user_id=auth()->user()->added_by;
       
          $quotation = CargoCollection::where('added_by', auth()->user()->added_by)->where('status','4')->get();
        $costs = Cost_function::all()->where('user_id',$user_id);

        return view('order_movement.wb',compact('quotation','costs'));

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

                $movement=CargoCollection::find($id);
                $truck=Truck::where('id',$request->truck_id)->first();
             $driver=Driver::find($request->driver_id);

//$loading=CargoLoading::where('status','!=', 6)->where('truck_id', $request->truck_id)->sum('weight');

$truck->update(['truck_status'=>'Unavailable']);

if(!empty($truck->connect_horse=='1')){
$trailer=Truck::find($truck->connect_trailer);
$trailer->update(['truck_status'=>'Unavailable']);
}

    
$driver->update(['available'=>'0']);

                    $loading_cargo =CargoLoading::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                            'truck_id'=>$request->truck_id,
                            'driver_id'=>$request->driver_id,
                            'type'=>$request->owner_type,
                            'weight'=>$movement->weight,
                          'quantity'=>$movement->quantity,
                           'total_weight'=>$movement->weight,
                            'status'=>'3',
                        'fuel'=>'0',
                           'pacel_id'=>$movement->pacel_id,
                           'pacel_name'=>$movement->pacel_name,
                         'pacel_number'=>$movement->pacel_number,
                          'confirmation_number'=>$movement->confirmation_number,
                         'start_location'=> $movement->start_location,
                         'end_location'=>$movement->end_location,
                         'from_region_id'=> $movement->from_region_id,
                         'to_region_id'=>$movement->to_region_id,
                             'end'=>$request->end,
                         'item_id'=>$movement->item_id,
                        'owner_id'=>$movement->owner_id,
                       'collection_id'=>$id,
                       'receiver_name'=>$movement->receiver_name,
                        'amount'=>$movement->amount,
                        'route_id'=>$movement->route_id,
                       'collection_date'=>$request->collection_date,
                       'receipt'=>$request->receipt,
                        ]
                        );                      
      



                 
                if(!empty($loading_cargo)){
                    $activity = Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$movement->pacel_id,
                            'module'=>'Cargo',
                            'activity'=>"Confirm Collection",
                            'notes'=>$request->notes,
                          'loading_id'=>$loading_cargo->id,
                           'date'=>$request->collection_date,
                        ]
                        );                      
       }

              
   $data['status']='3';
    $data['end']=$request->end;
    $data['truck_id']=$request->truck_id;
     $data['driver_id']=$request->driver_id;

 $user_id=auth()->user()->added_by;
  $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','3')->get();
   $costs = Cost_function::all()->where('user_id',$user_id);

$result=$movement->update($data);

  return redirect(route('order.loading'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Collected Successfully']);



                    break;


                   case 'fuel':
                        $movement=CargoLoading::find($id);
                         $toll['fuel']='1';
                        $toll['road_toll']=$request->road_toll;
                         $toll['toll_gate']=$request->toll_gate;
                         $toll['council']=$request->council;
                        $toll['consultant']=$request->consultant;
                        $result=$movement->update($toll);
                         
                                                               
       $route = Route::find($movement->route_id); 
   $name=$movement->pacel_name;
   
   if($request->returnFuel == 1){
       
       if(!is_null($route->loaded_fuel) && !is_null($route->empty_fuel)){
       $return_fuel = $route->loaded_fuel  + $route->empty_fuel;
       }
       elseif(!is_null($route->loaded_fuel) && is_null($route->empty_fuel)){
           $return_fuel = $route->loaded_fuel;
       }
       elseif(is_null($route->loaded_fuel) && !is_null($route->empty_fuel)){
           $return_fuel = $route->empty_fuel;
       }
       elseif(is_null($route->loaded_fuel) && is_null($route->empty_fuel)){
           $return_fuel = 0.00;
       }
       else{
           $return_fuel = 0.00;
       }
       
      CargoLoading::where('id', $id)->update(['return_fuel' => $return_fuel]);
   }
   
   else{
       $return_fuel = $route->loaded_fuel;
      CargoLoading::where('id', $id)->update(['return_fuel' => $return_fuel]);  
   }


       $data['route_id']=$movement->route_id;
        $data['fuel_used']=$request->fuel;
        $data['due_fuel']=$request->fuel;
       $data['date']=$request->date;
        $data['added_by']=auth()->user()->added_by;
        $data['driver_id']=$movement->driver_id;
      $data['truck_id']=$movement->truck_id;
    $data['movement_id']=$movement->id;
 $data['status_approve']='0';
        $fuel= Fuel::create($data);


  $items['route_id']=$movement->route_id;
   $items['fuel_rate']=$request->mileage;
    $items['date']=$request->date;
      $items['total_mileage']= $request->mileage;
       $items['due_mileage']=$request->mileage;
        $items['added_by']=auth()->user()->added_by;
        $items['driver_id']=$movement->driver_id;
      $items['truck_id']=$movement->truck_id;
    $items['movement_id']=$movement->id;
 $items['status_approve']='0';
$items['payment_status']='0';
        $mileage= Mileage ::create($items);
        
        //dd($request->date);

 $driver=Driver::find($movement->driver_id);
   $truck=Truck::find($movement->truck_id);
     
 $crm= AccountCodes::where('account_name','Mileage')->where('added_by',auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $crm->id;
 $date = explode('-',$mileage->date);
  $journal->date =   $mileage->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'mileage';
  $journal->name = 'Mileage';
  $journal->debit = $mileage->total_mileage ;
  $journal->income_id= $mileage->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Mileage of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$mileage->date);
  $journal->date =   $mileage->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'mileage';
  $journal->name = 'Mileage';
   $journal->income_id= $mileage->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$mileage->total_mileage ;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
     $journal->notes= "Mileage of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


 $pmt['route_id']=$movement->route_id;
   $pmt['fuel_rate']=$request->road_toll + $request->toll_gate + $request->council + $request->consultant;
    $pmt['date']=$request->date;
      $pmt['total_permit']= $request->road_toll + $request->toll_gate + $request->council + $request->consultant;;
       $pmt['due_permit']=$request->road_toll + $request->toll_gate + $request->council + $request->consultant;;
        $pmt['added_by']=auth()->user()->added_by;
        $pmt['driver_id']=$movement->driver_id;
      $pmt['truck_id']=$movement->truck_id;
    $pmt['movement_id']=$movement->id;
 $pmt['status_approve']='0';
$pmt['payment_status']='0';
        $permit= Permit ::create($pmt);

if($request->road_toll > 0){ 
                     $rpmt['route_id']=$movement->route_id;
                        $rpmt['added_by']=auth()->user()->added_by;
                        $rpmt['driver_id']=$movement->driver_id;
                        $rpmt['truck_id']=$movement->truck_id;
                       $rpmt['movement_id']=$movement->id;
                         $rpmt['value']=$request->road_toll;
                         $rpmt['type']='Road Toll';
                         $rpmt['permit_id']=$permit->id;
 $road= PermitType ::create(  $rpmt);

 $crb= AccountCodes::where('account_name','Road Toll')->where('added_by',auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
$journal->reference = 'Road Toll';
  $journal->debit = $request->road_toll ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Road Toll of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
$journal->reference = 'Road Toll';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->road_toll ;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Road Toll of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}



if($request->toll_gate > 0){ 
                     $tpmt['route_id']=$movement->route_id;
                        $tpmt['added_by']=auth()->user()->added_by;
                        $tpmt['driver_id']=$movement->driver_id;
                        $tpmt['truck_id']=$movement->truck_id;
                       $tpmt['movement_id']=$movement->id;
                         $tpmt['value']=$request->toll_gate;
                         $tpmt['type']='Toll Gate';
                         $tpmt['permit_id']=$permit->id;
 $toll= PermitType ::create($tpmt);

 $crb= AccountCodes::where('account_name','Toll Gate')->where('added_by',auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
$journal->reference = 'Toll Gate';
  $journal->name = 'Border Permit';
  $journal->debit = $request->toll_gate ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Toll Gate of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->reference = 'Toll Gate';
  $journal->name = 'Border Permit';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->toll_gate;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Toll Gate of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}


if($request->council > 0){ 
                     $cpmt['route_id']=$movement->route_id;
                        $cpmt['added_by']=auth()->user()->added_by;
                        $cpmt['driver_id']=$movement->driver_id;
                        $cpmt['truck_id']=$movement->truck_id;
                       $cpmt['movement_id']=$movement->id;
                         $cpmt['value']=$request->council;
                         $cpmt['type']='Council';
                         $cpmt['permit_id']=$permit->id;
 $council= PermitType ::create($cpmt);

 $crb= AccountCodes::where('account_name','Council')->where('added_by',auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
  $journal->reference = 'Council';
  $journal->debit = $request->council ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Council of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
    $journal->reference = 'Council';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->council;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Council of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}

if($request->consultant > 0){ 
                     $ctpmt['route_id']=$movement->route_id;
                        $ctpmt['added_by']=auth()->user()->added_by;
                        $ctpmt['driver_id']=$movement->driver_id;
                        $ctpmt['truck_id']=$movement->truck_id;
                       $ctpmt['movement_id']=$movement->id;
                         $ctpmt['value']=$request->consultant;
                         $ctpmt['type']='Consultant';
                         $ctpmt['permit_id']=$permit->id;
 $consul= PermitType ::create($ctpmt);

 $crb= AccountCodes::where('account_name','Consultant')->where('added_by',auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
$journal->reference = 'Consultant';
  $journal->debit = $request->consultant ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Consultant of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
   $journal->reference = 'Consultant';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->consultant;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Consultant of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}





                        $user_id=auth()->user()->added_by;
                        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','3')->get();
                        $costs = Cost_function::all()->where('user_id',$user_id);
                       
                        return redirect(route('order.loading'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Fuel and Mileage Assigned Successfully']);
                            break;




                    case 'loading':
                        $movement= CargoLoading::find($id);
                            if(!empty($request->receipt)){
                              $data['receipt']=$request->receipt;
                           }
                             $data['status']=4;
                        $result=$movement->update($data);
                         
                    CargoCollection::where('id',$movement->collection_id)->update(['status'=>4]);;   

                        if(!empty($result)){
                            $activity = Activity::create(
                                [ 
                                    'added_by'=>auth()->user()->added_by,
                                    'user_id'=>auth()->user()->id,
                                    'module_id'=>$movement->pacel_id,
                                    'module'=>'Cargo',
                                    'activity'=>"Confirm Loading",
                                    'notes'=>$request->notes,
                                'loading_id'=>$id,
                                   'date'=>$request->collection_date,
                                ]
                                );                      
               }
        
                        $user_id=auth()->user()->added_by;
                        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','4')->get();
                        $costs = Cost_function::all()->where('user_id',$user_id);
                       
                        return redirect(route('order.offloading'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Loaded Successfully']);
                            break;

                            case 'offloading':
                                $movement=CargoLoading::find($id);
                                  if(!empty($request->receipt)){
                              $data['receipt']=$request->receipt;
                               $data['damaged']=$request->damaged;
                           }
                             $data['status']=5;
                        $result=$movement->update($data);

                                      $truck=Truck::find($movement->truck_id);
                                         $driver=Driver::find($movement->driver_id);
                                           if(!empty($result)){
                                     $item['truck_status']='Available';
                                      $item['location']=$movement->to_region_id;
                                         $truck->update($item);

                                         if(!empty($truck->connect_horse=='1')){
                                           $trailer=Truck::find($truck->connect_trailer);
                                             $trailer->update($item);
                                               }

                                            $driver->update(['available'=>'1']);                             
                                          }
                                 
                                if(!empty($result)){
                                    $activity = Activity::create(
                                        [ 
                                            'added_by'=>auth()->user()->added_by,
                                            'user_id'=>auth()->user()->id,
                                            'module_id'=>$movement->pacel_id,
                                            'module'=>'Cargo',
                                            'activity'=>"Confirm Offloading",
                                            'notes'=>$request->notes,
                                            'loading_id'=>$id,
                                           'date'=>$request->collection_date,
                                        ]
                                        );                      
                       }

 
    

                
                                $user_id=auth()->user()->added_by;
                                $quotation =  CargoLoading::where('added_by', auth()->user()->added_by)->where('status','5')->get();
                                $costs = Cost_function::all()->where('user_id',$user_id);
                               
                                return redirect(route('order.delivering'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Offloaded Successfully']);
                                    break;

                                    case 'delivering':
                                        $movement= CargoLoading::find($id);
                                          if(!empty($request->receipt)){
                              $data['receipt']=$request->receipt;
                           }
                             $data['status']=6;
                        $result=$movement->update($data);

                                       

         //CargoCollection::where('id',$movement->collection_id)->update(['status'=>4]);;   
           //Pacel::where('id',$movement->pacel_id)->update(['good_receive'=>1]);;   

  
                                         
                                        if(!empty($result)){
                                            $activity = Activity::create(
                                                [ 
                                                    'added_by'=>auth()->user()->added_by,
                                                    'user_id'=>auth()->user()->id,
                                                    'module_id'=>$movement->pacel_id,
                                                    'module'=>'Cargo',
                                                    'activity'=>"Confirm Delivery",
                                                 'loading_id'=>$id,
                                                    'notes'=>$request->notes,
                                                   'date'=>$request->collection_date,
                                                ]
                                                );                      
                               }
                        
                                        $user_id=auth()->user()->added_by;
                                        $quotation = CargoLoading::where('added_by', auth()->user()->added_by)->where('status','5')->orwhere('status','6')->get();
                                        $costs = Cost_function::all()->where('user_id',$user_id);
                                       
                                        return redirect(route('order.delivering'))->with(['quotation'=> $quotation,'costs'=>$costs,'success'=>'Delivered Successfully']);
                                            break;


                         case 'driver':
              
                                                               
       $route = Route::find($request->route_id); 
  
       $data['route_id']=$request->route_id;
    $data['fuel_rate']=$request->fuel;
        $data['fuel_used']=$request->fuel;
          $data['date']=$request->date;
        $data['due_fuel']=$request->fuel;
        $data['added_by']=auth()->user()->added_by;
        $data['driver_id']=$request->driver_id;
      $data['truck_id']=$request->truck_id;
 $data['status_approve']='0';
        $fuel= Fuel::create($data);


  $items['route_id']=$request->route_id;
   $items['fuel_rate']=$request->mileage;
    $items['date']=$request->date;
        $items['total_mileage']= $request->mileage;
       $items['due_mileage']= $request->mileage;
        $items['added_by']=auth()->user()->added_by;
        $items['driver_id']=$request->driver_id;
      $items['truck_id']=$request->truck_id;
 $items['status_approve']='0';
$items['payment_status']='0';
        $mileage= Mileage ::create($items);

 $driver=Driver::find($request->driver_id);
   $truck=Truck::find($request->truck_id);
     
 $cr= AccountCodes::where('account_name','Mileage')->where('added_by',auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$mileage->date);
  $journal->date =   $mileage->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'return_mileage';
  $journal->name = 'Mileage';
  $journal->debit = $mileage->total_mileage ;
  $journal->income_id= $mileage->id;
 $journal->truck_id= $request->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
     $journal->notes= "Return Mileage  to Driver  ". $driver->driver_name ." with Truck  ".$truck->truck_name. " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
 $date = explode('-',$mileage->date);
  $journal->date =   $mileage->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
    $journal->transaction_type = 'return_mileage';
  $journal->name = 'Mileage';
   $journal->income_id= $mileage->id;
   $journal->truck_id= $request->truck_id;
  $journal->credit =$mileage->total_mileage ;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
     $journal->notes= "Return Mileage  to Driver  ". $driver->driver_name ." with Truck  ".$truck->truck_name. " - " .$truck->reg_no;
  $journal->save();



   $truck->update(['location'=>$route->to_region_id]);             
   
  if(!empty($truck->connect_horse=='1')){
                                           $trailer=Truck::find($truck->connect_trailer);
                                             $trailer->update(['location'=>$route->to_region_id]); 
                                               }              
                       
                        return redirect(route('order.return'))->with(['success'=>'Fuel and Mileage Assigned Successfully']);
                            break;


             default:
             return abort(404);
             
            }




    }

public function save_wb(Request $request)
    {


$item_id=$request->checked_item_id;

//dd($item_id);
  if(!empty($item_id)){
      
      
    for($i = 0; $i < count($item_id); $i++){

      $client=CargoCollection::where('added_by', auth()->user()->added_by)->where('item_id',$item_id[$i])->first(); 
       $exchange=Pacel::find($client->pacel_id);
       
       $range[]=[
            'client'=>$client->owner_id,
            'exchange'=>$exchange->currency_code,
        ];


   //$result = array_diff( $client_one->owner_id,$client->owner_id);

/*
   if($client_one->owner_id != $client->owner_id ){
return redirect()->back()->with(['error'=>'You have Chosen different Client']);
    }
   if($exchange_one->currency_code !=$exchange->currency_code ){
return redirect()->back()->with(['error'=>'You have Chosen invoice with different Currency']);
    }

*/


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

   $collection=CargoCollection::where('added_by', auth()->user()->added_by)->where('item_id',$item_id[$i])->first(); 
   $good=Pacel::find($collection->pacel_id);

  $invoice= array(
   'pacel_number' => '12AB' ,
   'date' => date('Y-m-d') ,
     'owner_id' => $collection->owner_id ,
     'discount' => '0'  ,
     'status' => '0'  ,
     'currency_code' =>  $good->currency_code,
     'exchange_rate' =>  $good->exchange_rate,
     'added_by'=>auth()->user()->added_by,
           );

$pacel=PacelInvoice::create($invoice);  ;
   $pacel_number = "PINV-".$pacel->id;
   
   

}
}
}


 $total = 0;
        $cost['tax'] = 0;
  if(!empty($item_id)){
    for($i = 0; $i < count($item_id); $i++){
   if(!empty($item_id[$i])){
          $acc = PacelItem::find($item_id[$i]); 
         $collect=CargoCollection::where('added_by', auth()->user()->added_by)->where('item_id',$item_id[$i])->first(); 

          $total += $acc->total_cost;
            $cost['tax'] +=$acc->total_tax;
                
                  $items = array(
                     'item_name' => $acc->item_name,
                    'quantity' =>    $acc->quantity,
                    'tax_rate' =>   $acc->tax_rate,
                     'unit' =>  $acc->unit,
                     'charge_type' =>   $acc->charge_type,
                    'distance' =>  $acc->distance,
                     'price' =>   $acc->price,
                    'total_cost' =>   $acc->total_cost,
                    'total_tax' =>   $acc->total_tax,
                     'items_id' =>  $item_id[$i],
                     'end' =>  $collect->end,
                      'truck_id'=>$collect->truck_id,
                       'driver_id'=>$collect->driver_id,
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'pacel_id' =>$pacel->id);

                  $list=PacelInvoiceItem::create($items);  ;

                   CargoCollection::where('added_by', auth()->user()->added_by)->where('item_id',$item_id[$i])->update(['status' => '5']);

          $client=Client::find($collect->owner_id);
          
           $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXY', ceil(4/strlen($x)) )),1,4);
                $confirmation_number = "PINV".$random.$pacel->id;

$cr= AccountCodes::where('account_name','Sales')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-',$pacel->date);
        $journal->date =   $pacel->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'cargo';
        $journal->name = 'Cargo Invoice';
        $journal->credit = $acc->total_cost *  $pacel->exchange_rate;
        $journal->income_id= $pacel->id;
       $journal->reference= $list->id;
         $journal->truck_id= $collect->truck_id;
         $journal->currency_code =  $pacel->currency_code;
        $journal->exchange_rate= $pacel->exchange_rate;
 $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Invoice with reference no " .$confirmation_number. "  by Client ".  $client->name ;
        $journal->save();

if($acc->total_tax > 0){
       $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
        $journal->account_id = $tax->id;
        $date = explode('-',$pacel->date);
        $journal->date =   $pacel->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'cargo';
        $journal->name = 'Cargo Invoice';
        $journal->credit = $acc->total_tax *  $pacel->exchange_rate;
       $journal->income_id= $pacel->id;
      $journal->reference= $list->id;
         $journal->truck_id= $collect->truck_id;
         $journal->currency_code =  $pacel->currency_code;
        $journal->exchange_rate= $pacel->exchange_rate;
         $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Invoice Tax with reference no " . $confirmation_number. "  by Client ".  $client->name ;
        $journal->save();
}

        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
         $date = explode('-',$pacel->date);
        $journal->date =  $pacel->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'cargo';
       $journal->name = 'Cargo Invoice';
       $journal->debit =($acc->total_cost +$acc->total_tax ) *  $pacel->exchange_rate;
           $journal->income_id= $pacel->id;
          $journal->reference= $list->id;
         $journal->truck_id= $collect->truck_id;
         $journal->currency_code =  $pacel->currency_code;
        $journal->exchange_rate= $pacel->exchange_rate;
       $journal->notes= "Debit Receivables for Invoice with reference no " . $confirmation_number. "  by Client ".  $client->name ;      
         $journal->added_by=auth()->user()->added_by;
        $journal->save();

                  }
                  }

                $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                $cost['pacel_number'] = "PCLINV-".$pacel->id;
                $cost['confirmation_number'] =  $confirmation_number;
                $cost['due_amount'] =  $cost['tax'] +  $total;
                $cost['amount'] =  $cost['tax'] +  $total;
                PacelInvoice::where('id',$pacel->id)->update($cost);
                }


                return redirect(route('pacel.invoice'))->with(['success'=>'Created Successfully']);
}


else{
  return redirect(route('order.wb'))->with(['error'=>'You have not chosen an entry']);
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

if ($request->ajax()) {
            $data =CargoLoading::query();
            $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
            $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');
            $status = (!empty($_GET["status"])) ? ($_GET["status"]) : ('');
            $from = (!empty($_GET["from"])) ? ($_GET["from"]) : ('');
            $to = (!empty($_GET["to"])) ? ($_GET["to"]) : ('');


     //filter selected columns
            if($start_date && $end_date){
             $start_date = date('Y-m-d', strtotime($start_date));
             $end_date = date('Y-m-d', strtotime($end_date));
             $data->whereRaw("date(cargo_loading.collection_date) >= '" . $start_date . "' AND date(cargo_loading.collection_date) <= '" . $end_date . "'");
            }
            if($from && $from!="all")
            $data->whereRaw("cargo_loading.from_region_id = '" . $from . "'");
            if($to && $to!="all")
            $data->whereRaw("cargo_loading.to_region_id= '" . $to . "'");
            if($status && $status!="all")
            $data->whereRaw("cargo_loading.status = '" . $status . "'");

          $data->where('added_by',auth()->user()->added_by);

            $data2 = $data->select('*')->where('added_by',auth()->user()->added_by);


            return Datatables::of($data2)
                    ->addIndexColumn()
                    ->editColumn('date', function ($row) {
                        $newDate = date("d/m/Y", strtotime($row->collection_date));
                        return $newDate;
                   })
                   ->editColumn('pacel_number', function ($row) {
                    return $row->confirmation_number  ;
               })
                  
               ->editColumn('receiver', function ($row) {
                $user = Client::find($row->owner_id);
                   return $user->name;
           })
                  
                    ->editColumn('from_to', function ($row) {
                       $from = Region::find($row->from_region_id);
                        $end= Region::find($row->to_region_id);
                        return 'From '.$from->name. ' to ' .$end->name;
                   })

                  
                    ->editColumn('truck', function ($row) {
                        $truck = Truck::find($row->truck_id);
                       return $truck->reg_no;

                    })

                      ->editColumn('driver', function ($row) {
                        $driver= Driver::find($row->driver_id);
                       return $driver->driver_name;

                    })
                     ->editColumn('weight', function ($row) {
                         return $row->quantity;
                    })

                    ->editColumn('status', function ($row) {
                        if($row->status == 3)
                         return '<div class="badge badge-dark badge-shadow">Collected</div>';
                        elseif($row->status == 4)
                        return '<div class="badge badge-info badge-shadow">On Transit</div>';
                        elseif($row->status == 5)
                        return '<div class="badge badge-primary badge-shadow">Off Loaded</div>';
                        elseif($row->status == 6)
                        return '<div class="badge badge-success  badge-shadow">Delivered</div>';
                        
                    })
                    ->rawColumns(['status','date','pacel_number','from_to'])
                   
                    
                    ->make(true);
        }

       return view('order_movement.report',compact('region'));

    }

 public function findReport (Request $request)
    {

         $data['report'] = CargoLoading::where('added_by', auth()->user()->added_by)->query();

          if(!empty($request->from)){
              $data['report'] = $data['report']->where('from_region_id',$request->from);
}
 if(!empty($request->to)){
              $data['report'] =$data['report']->where('to_region_id',$request->to);
}
 if(!empty($request->status)){
              $data['report'] = $data['report']->where('status',$request->status);
}
 if(!empty($request->start_date) && !empty($request->end_date)){
              $data['report'] =$data['report']->whereBetween('collection_date',  [$request->start_date, $request->end_date]);
}

$data['report']=$data['report']->get();
            
               $data['region'] = Region::all();

               // return response()->json($report);;
                   return response()->json(['html' => view('order_movement.addreport', $data)->render()]);           

    }
    
    
     public function edit_cargo($id)
    {
        //

      $collection =CargoCollection::where('id',$id)->first();  
      $loading =CargoLoading::where('collection_id',$id)->first();
      $fuel=Fuel::where('movement_id',$loading->id)->first();
      $mileage=Mileage::where('movement_id',$loading->id)->first();
      $items=PacelItem::where('id',$collection->item_id)->first(); 
       $data=Pacel::find($items->pacel_id);
      $truck=Truck::find($loading->truck_id);
      $driver=Driver::find($loading->driver_id);
      $route = Route::where('disabled','0')->get();

        return view('order_movement.edit_cargo',compact('collection','loading','fuel','mileage','items','data','truck','driver','route','id'));
    }



public function update_cargo(Request $request)
    {
               
 
     $itemArr =$request->item_id ;
         $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
      $chargeArr =$request->charge;
     $distanceArr = $request->distance  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );     
   
$pacel = Pacel::find($request->pacel_id);    
$it=PacelItem::where('id',$itemArr)->first(); 



          if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){

                //update due amount from pacel table
                if($it->total_cost + $it->total_tax <= $costArr[$i] + $taxArr[$i]){
                 $diff=($costArr[$i] + $taxArr[$i])- ($it->total_cost + $it->total_tax);
                $data['due_amount'] =  $pacel->due_amount+$diff;
                $data['amount'] =  $pacel->due_amount+$diff;
                }

                if($it->total_cost + $it->total_tax > $costArr[$i] + $taxArr[$i]){
                $diff= ($it->total_cost + $it->total_tax) - ($costArr[$i] + $taxArr[$i]) ;
                $data['due_amount'] =  $pacel->due_amount - $diff;
                $data['amount'] =  $pacel->due_amount - $diff;
                }



                  if($it->total_tax <= $taxArr[$i]){
                 $diff_tax= $taxArr[$i] -  $it->total_tax;
                $data['tax'] =  $pacel->tax+$diff_tax;
                }

                if($it->total_tax > $taxArr[$i]){
                $diff_tax=  $it->total_tax - $taxArr[$i] ;
                $data['tax'] =  $pacel->tax - $diff_tax;
                }

              $pacel->update($data);  



              if($chargeArr[$i]=='1'){
                      $type[$i]='Flat';
                        }
                     else if($chargeArr[$i]== $distanceArr[$i]){
                    $type[$i]='Distance';
                        }
                     else{
                      $type[$i]='Rate';
                        }

                $items = array(
                    'item_name' => $nameArr[$i],
                    'quantity' =>   $qtyArr[$i],
                    'tax_rate' =>  $rateArr[$i],
                     'charge_type' =>  $type[$i],
                    'distance' => $distanceArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i]);
                        
                   
                     PacelItem::where('id',$itemArr)->update($items);  

  $route = Route::find($nameArr[$i]); 
                $result['start_location']= $route->from;
                $result['end_location']=$route->to;
                $result['from_region_id']= $route->from_region_id;
                $result['to_region_id']=$route->to_region_id;
                $result['amount']=$costArr[$i];
               $result['quantity']=$qtyArr[$i];
                $result['route_id']=$nameArr[$i];
                $result['item_id']=$itemArr;

               CargoCollection::where('id',$request->collection_id)->update($result); 
      
}    
}
}




$collection=CargoCollection::find($request->collection_id);

             
                $loading_cargo =CargoLoading::where('collection_id',$request->collection_id)->update(
                        [ 


                         'start_location'=> $collection->start_location,
                         'end_location'=>$collection->end_location,
                         'from_region_id'=> $collection->from_region_id,
                         'to_region_id'=>$collection->to_region_id,
                           'end'=>$request->end,
                         'item_id'=>$collection->item_id,
                        'amount'=>$collection->amount,
                       'quantity'=>$collection->quantity,
                        'route_id'=>$collection->route_id,
                       'receipt'=>$request->receipt,
                        'road_toll' =>$request->road_toll,
                        'toll_gate' =>$request->toll_gate,
                        'council' =>$request->council,
                       'consultant' =>$request->consultant,
                        'damaged'=>$request->damaged,

                        ]
                        );  


$movement =CargoLoading::where('collection_id',$request->collection_id)->first();

$driver=Driver::find($movement->driver_id);
   $truck=Truck::find($movement->truck_id);
   $name=$movement->pacel_name;

       $fuel_data['route_id']=$collection->route_id;
        $fuel_data['fuel_used']=$request->fuel;
        $fuel_data['due_fuel']=$request->fuel;
         Fuel::where('movement_id',$movement->id)->update($fuel_data);
      $fuel= Fuel::where('movement_id',$movement->id)->first();

      $mil_items['route_id']=$collection->route_id;
      $mil_items['fuel_rate']=$request->mileage;
      $mil_items['total_mileage']= $request->mileage;
      $mil_items['due_mileage']=$request->mileage;
      Mileage::where('movement_id',$movement->id)->update($mil_items);
      $mileage= Mileage::where('movement_id',$movement->id)->first();


         
 $crm= AccountCodes::where('account_name','Mileage')->where('added_by',auth()->user()->added_by)->first();
$journal = JournalEntry::where('income_id',$mileage->id)->where('transaction_type','mileage')->whereNotNull('debit')->where('added_by',auth()->user()->added_by)->first();
  $journal->account_id = $crm->id;
  $journal->debit = $mileage->total_mileage ;
  $journal->income_id= $mileage->id;
  $journal->update();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = JournalEntry::where('income_id',$mileage->id)->where('transaction_type','mileage')->whereNotNull('credit')->where('added_by',auth()->user()->added_by)->first();
  $journal->account_id = $codes->id;
   $journal->income_id= $mileage->id;
  $journal->credit =$mileage->total_mileage ;
  $journal->update();



      $pmt['route_id']=$collection->route_id;
      $pmt['fuel_rate']=$request->road_toll + $request->toll_gate + $request->council + $request->consultant;
      $pmt['total_permit']= $request->road_toll + $request->toll_gate + $request->council + $request->consultant;;
       $pmt['due_permit']=$request->road_toll + $request->toll_gate + $request->council + $request->consultant;;
        Permit::where('movement_id',$movement->id)->update($pmt);
        $permit= Permit::where('movement_id',$movement->id)->first();


        if($request->road_toll > 0){ 
                        $rpmt['route_id']=$collection->route_id;
                         $rpmt['value']=$request->road_toll;
                         $rpmt['type']='Road Toll';
                         $rpmt['permit_id']=$permit->id;
                        $rpmt['driver_id']=$movement->driver_id;
                        $rpmt['truck_id']=$movement->truck_id;
                       $rpmt['movement_id']=$movement->id;
                       $rpmt['added_by']=auth()->user()->added_by;


            $road=PermitType::where('permit_id',$permit->id)->where('movement_id',$movement->id)->where('type','Road Toll')->first();
            if(!empty($road)){

        $road->update($rpmt);

  $crb= AccountCodes::where('account_name','Road Toll')->where('added_by',auth()->user()->added_by)->first();
 $journal =JournalEntry::where('income_id',$permit->id)->where('transaction_type','permit')->where('reference','Road Toll')->whereNotNull('debit')->where('added_by',auth()->user()->added_by)->first();
  $journal->account_id = $crb->id;
$journal->reference = 'Road Toll';
  $journal->debit = $request->road_toll ;
  $journal->income_id= $permit->id;
  $journal->update();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
 $journal =JournalEntry::where('income_id',$permit->id)->where('transaction_type','permit')->where('reference','Road Toll')->whereNotNull('credit')->where('added_by',auth()->user()->added_by)->first();
  $journal->account_id = $codes->id;
  $journal->reference = 'Road Toll';
   $journal->income_id= $permit->id;
  $journal->credit =$request->road_toll ;
  $journal->update();

            }

            else{

 PermitType::create($rpmt);

 $crb= AccountCodes::where('account_name','Road Toll')->where('added_by',auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
$journal->reference = 'Road Toll';
  $journal->debit = $request->road_toll ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Road Toll of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
$journal->reference = 'Road Toll';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->road_toll ;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Road Toll of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();

}

}



if($request->toll_gate > 0){ 

                        $tpmt['route_id']=$collection->route_id;
                         $tpmt['value']=$request->toll_gate;
                         $tpmt['type']='Toll Gate';
                          $tpmt['permit_id']=$permit->id;
                         $tpmt['driver_id']=$movement->driver_id;
                        $tpmt['truck_id']=$movement->truck_id;
                       $tpmt['movement_id']=$movement->id;
                       $tpmt['added_by']=auth()->user()->added_by;

            $toll=PermitType::where('permit_id',$permit->id)->where('movement_id',$movement->id)->where('type','Toll Gate')->where('added_by',auth()->user()->added_by)->first();
            if(!empty($toll)){

        $toll->update($tpmt);

  $crb= AccountCodes::where('account_name','Toll Gate')->where('added_by',auth()->user()->added_by)->first();
 $journal =JournalEntry::where('income_id',$permit->id)->where('transaction_type','permit')->where('reference','Toll Gate')->whereNotNull('debit')->where('added_by',auth()->user()->added_by)->first();
  $journal->account_id = $crb->id;
$journal->reference = 'Toll Gate';
  $journal->debit = $request->toll_gate ;
  $journal->income_id= $permit->id;
  $journal->update();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
 $journal =JournalEntry::where('income_id',$permit->id)->where('transaction_type','permit')->where('reference','Toll Gate')->whereNotNull('credit')->where('added_by',auth()->user()->added_by)->first();
  $journal->account_id = $codes->id;
  $journal->reference = 'Toll Gate';
   $journal->income_id= $permit->id;
  $journal->credit =$request->toll_gate ;
  $journal->update();

            }

            else{

 PermitType ::create($tpmt);

 $crb= AccountCodes::where('account_name','Toll Gate')->where('added_by',auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
$journal->reference = 'Toll Gate';
  $journal->name = 'Border Permit';
  $journal->debit = $request->toll_gate ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Toll Gate of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->reference = 'Toll Gate';
  $journal->name = 'Border Permit';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->toll_gate;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Toll Gate of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}

}



if($request->council > 0){ 

                         $cpmt['route_id']=$collection->route_id;
                         $cpmt['value']=$request->council;
                         $cpmt['type']='Council';
                         $cpmt['permit_id']=$permit->id;
                         $cpmt['driver_id']=$movement->driver_id;
                        $cpmt['truck_id']=$movement->truck_id;
                       $cpmt['movement_id']=$movement->id;
                      $cpmt['added_by']=auth()->user()->added_by;

            $council=PermitType::where('permit_id',$permit->id)->where('movement_id',$movement->id)->where('type','Council')->first();
            if(!empty($council)){

        $council->update($cpmt);

  $crb= AccountCodes::where('account_name','Council')->where('added_by',auth()->user()->added_by)->first();
 $journal =JournalEntry::where('income_id',$permit->id)->where('transaction_type','permit')->where('reference','Council')->whereNotNull('debit')->where('added_by',auth()->user()->added_by)->first();
  $journal->account_id = $crb->id;
$journal->reference = 'Council';
  $journal->debit = $request->council ;
  $journal->income_id= $permit->id;
  $journal->update();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
 $journal =JournalEntry::where('income_id',$permit->id)->where('transaction_type','permit')->where('reference','Council')->whereNotNull('credit')->where('added_by',auth()->user()->added_by)->first();
  $journal->account_id = $codes->id;
  $journal->reference = 'Council';
   $journal->income_id= $permit->id;
  $journal->credit =$request->council ;
  $journal->update();

            }

            else{

 PermitType ::create($cpmt);

 $crb= AccountCodes::where('account_name','Council')->where('added_by',auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
  $journal->reference = 'Council';
  $journal->debit = $request->council ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Council of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
    $journal->reference = 'Council';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->council;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Council of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}

}



if($request->consultant > 0){

                       $ctpmt['route_id']=$collection->route_id;
                         $ctpmt['value']=$request->consultant;
                         $ctpmt['type']='Consultant';
                         $ctpmt['permit_id']=$permit->id;
                      $ctpmt['driver_id']=$movement->driver_id;
                        $ctpmt['truck_id']=$movement->truck_id;
                       $ctpmt['movement_id']=$movement->id;
                       $ctpmt['added_by']=auth()->user()->added_by;

            $ct=PermitType::where('permit_id',$permit->id)->where('movement_id',$movement->id)->where('type','Consultant')->first();
            if(!empty($ct)){

        $ct->update($ctpmt);

  $crb= AccountCodes::where('account_name','Consultant')->where('added_by',auth()->user()->added_by)->first();
 $journal =JournalEntry::where('income_id',$permit->id)->where('transaction_type','permit')->where('reference','Consultant')->whereNotNull('debit')->where('added_by',auth()->user()->added_by)->first();
  $journal->account_id = $crb->id;
$journal->reference = 'Consultant';
  $journal->debit = $request->consultant ;
  $journal->income_id= $permit->id;
  $journal->update();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
 $journal=JournalEntry::where('income_id',$permit->id)->where('transaction_type','permit')->where('reference','Consultant')->whereNotNull('credit')->where('added_by',auth()->user()->added_by)->first();
  $journal->account_id = $codes->id;
  $journal->reference = 'Consultant';
   $journal->income_id= $permit->id;
  $journal->credit =$request->consultant ;
  $journal->update();

            }

            else{

 PermitType ::create($ctpmt);

$crb= AccountCodes::where('account_name','Consultant')->where('added_by',auth()->user()->added_by)->first();
    $journal = new JournalEntry();
  $journal->account_id = $crb->id;
 $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
$journal->reference = 'Consultant';
  $journal->debit = $request->consultant ;
  $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
   $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;
 $journal->notes= "Consultant of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();


  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$permit->date);
  $journal->date =   $permit->date;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'permit';
  $journal->name = 'Border Permit';
   $journal->reference = 'Consultant';
   $journal->income_id= $permit->id;
 $journal->truck_id= $movement->truck_id;
  $journal->credit =$request->consultant;
  $journal->currency_code =  'TZS';
  $journal->exchange_rate= '1';
$journal->added_by=auth()->user()->added_by;;
   $journal->notes= "Consultant of Shipment " .$name ."  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name . " - " .$truck->reg_no;
  $journal->save();
}

}




return redirect(route('order.wb'))->with(['success'=>'Updated Successfully']);
    }



public function debtors_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $currency=$request->currency;

        $chart_of_accounts = [];
        foreach (Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }

         $accounts = [];
        foreach (Currency::all() as $key) {
            $accounts[$key->code] = $key->name;
        }

        if($request->isMethod('post')){
            $data=PacelInvoice::where('added_by',auth()->user()->added_by)->where('owner_id', $request->account_id)->where('currency_code', $request->currency)->whereBetween('date',[$start_date,$end_date])->get();
      
        }else{
            $data=[];
        }


             return view('order_movement.report.debtors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id','currency','accounts'));
        
       
    }
    
    
    public function debtors_summary_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (Currency::all() as $key) {
            $chart_of_accounts[$key->code] = $key->name;
        }
        if($request->isMethod('post')){
            $data=PacelInvoice::where('added_by',auth()->user()->added_by)->where('currency_code', $request->account_id)->whereBetween('date',[$start_date,$end_date])->groupBy('owner_id')->get();
        }else{
            $data=[];
        }

           

        return view('order_movement.report.debtors_summary_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));

    }
    
    public function client_summary(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
      

        foreach (Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name ;
        }
    
            $data=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
     


        return view('order_movement.report.client_summary',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    

}
  
public function creditors_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name ;
        }
        if($request->isMethod('post')){
            $data=JournalEntry::where('added_by',auth()->user()->added_by)->where('supplier_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
        }else{
            $data=[];
        }


        return view('order_movement.report.creditors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    

}









public function creditors_refill_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;


        $chart_of_accounts = [];
        foreach (Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }

      

        if($request->isMethod('post')){
            $data=Refill::where('added_by',auth()->user()->added_by)->where('supplier', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
      
        }else{
            $data=[];
        }

       
        
             return view('order_movement.report.refill_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
        
       
    }



}
