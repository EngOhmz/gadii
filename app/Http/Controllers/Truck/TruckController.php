<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Sticker;
use App\Models\Truck;
use App\Models\Tyre\TruckTyre ;
use App\Models\TruckInsurance;
use App\Models\RoadPermit;
use App\Models\Comesa;
use App\Models\WMA;
use App\Models\Device;
use App\Models\TruckCarbon;
use Illuminate\Http\Request;
use App\Models\Fuel\Fuel;
use App\Models\orders\OrderMovement;
use App\Models\Region;
use App\Models\CargoLoading;
use App\Models\JournalEntry;
use App\Models\AccountCodes;
use App\Models\Supplier;
use App\Models\TruckEquipment;
use App\Models\TruckEquipmentItem;
use App\Models\Equipment;
use App\Models\EquipmentList;
use PDF;
use App\Models\User;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $truck = Truck::where('added_by', auth()->user()->added_by)->where('disabled','0')->get();
        $driver=Driver::where('added_by', auth()->user()->added_by)->get(); 
  $region = Region::all();          
        return view('truck.truck',compact('truck','driver','region'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
        $data['truck_name']= $request->truck_name ;
       $data['reg_no']= $request->reg_no ;
       $data['location']= $request->location;
       $data['truck_type']= $request->truck_type ;
       $data['type']= $request->type;
        $data['capacity']= $request->capacity ;
       $data['fuel']= $request->fuel;
        $data['added_by']=auth()->user()->added_by;
        $truck= Truck::create($data);

       $item['truck_id']=$truck->id;
       $item['total_tyre']=$request->total_1 +$request->total_2 + $request->total_3 + $request->total_4 +$request->total_5 + $request->total_6;
       $item['due_tyre']=$request->total_1 +$request->total_2 + $request->total_3 + $request->total_4 +$request->total_5 + $request->total_6;
       $item['total_1']=$request->total_1 ;
       $item['due_1']= $item['total_1']  ;
       $item['total_2']=$request->total_2 ;
       $item['due_2']= $item['total_2']  ;
       $item['total_3']=$request->total_3 ;
      $item['due_3']= $item['total_3']  ;
      $item['total_4']=$request->total_4 ;
      $item['due_4']= $item['total_4']  ;
      $item['total_5']=$request->total_5 ;
     $item['due_5']= $item['total_5']  ;
     $item['total_6']=$request->total_6 ;
      $item['due_6']= $item['total_6']  ;
    
       $item['added_by']=auth()->user()->added_by;
  TruckTyre ::create($item);

 return redirect(route('truck.index'))->with(['success'=>'Truck Created Successfully']);

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
        $data =  Truck::find($id);
        $driver=Driver::where('added_by', auth()->user()->added_by)->get();
  $region = Region::all();   
        $tyre= TruckTyre::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->first(); 
        return view('truck.truck',compact('data','id','driver','region','tyre'));
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
        $truck =  Truck::find($id);

        $data['truck_name']= $request->truck_name ;
       $data['reg_no']= $request->reg_no ;
       $data['location']= $request->location;
       $data['truck_type']= $request->truck_type ;
       $data['type']= $request->type;
        $data['capacity']= $request->capacity ;
       $data['fuel']= $request->fuel;
         $truck->update($data);

/*
      $tyre=TruckTyre ::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->first();
     if(!empty($tyre)){
      if($tyre->total_tyre != $request->total_diff +$request->total_rear + $request->total_trailer){

        if($tyre->total_tyre < $request->total_diff +$request->total_rear + $request->total_trailer){
         $diff=($request->total_diff +$request->total_rear + $request->total_trailer) - $tyre->total_tyre;
                  $item['due_tyre'] =  $tyre->due_tyre+$diff;
                }

        if($tyre->total_diff < $request->total_diff){
         $diff_due=$request->total_diff  - $tyre->total_diff;
                  $item['due_diff'] =  $tyre->due_diff +$diff_due;
                }
              if($tyre->total_rear < $request->total_rear){
         $diff_rear=$request->total_rear  - $tyre->total_rear;
                    $item['due_rear'] =  $tyre->due_rear +$diff_rear;
                }
               if($tyre->total_trailer < $request->total_trailer){
         $diff_trailer=$request->total_trailer  - $tyre->total_trailer;
                   $item['due_trailer'] =  $tyre->due_trailer +$diff_trailer;
                }

      $item['truck_id']=$id;
       $item['total_tyre']=$request->total_diff +$request->total_rear + $request->total_trailer ;
      $item['total_diff']=$request->total_diff ;
       $item['total_rear']=$request->total_rear  ;
       $item['total_trailer']= $request->total_trailer ;
       $tyre->update($item);
     }
     } 

else{
 $item['truck_id']=$id;
       $item['total_tyre']=$request->total_diff +$request->total_rear + $request->total_trailer ;
       $item['due_tyre']=$request->total_diff +$request->total_rear + $request->total_trailer ;
      $item['total_diff']=$request->total_diff ;
       $item['due_diff']=$request->total_diff  ;
     $item['total_rear']=$request->total_rear  ;
       $item['due_rear']=$request->total_rear ;
   $item['total_trailer']= $request->total_trailer ;
       $item['due_trailer']= $request->total_trailer ;
       $item['added_by']=auth()->user()->added_by;
  TruckTyre ::create($item);
 }

*/

        return redirect(route('truck.index'))->with(['success'=>'Truck Updated Successfully']);
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
        $truck = Truck::find($id);
        $truck->delete();
        return redirect(route('truck.index'))->with(['success'=>'Truck Deleted Successfully']);
    }

    public function insurance($id)
    {
        //
        $truck =  Truck::find($id);
           $client=Supplier::where('user_id', auth()->user()->added_by)->get();
        $insurance=TruckInsurance::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->get();
        $type = "insurance";
        return view('truck.insurance',compact('insurance','type','truck','client'));
    }
    public function sticker($id)
    {
        //
        $truck =  Truck::find($id);
         $client=Supplier::where('user_id', auth()->user()->added_by)->get();
        $sticker=Sticker::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->get();
        $type = "sticker";
        return view('truck.sticker',compact('sticker','type','truck','client'));
    }
  public function permit($id)
    {
        //
        $truck =  Truck::find($id);
         $client=Supplier::where('user_id', auth()->user()->added_by)->get();
        $sticker=RoadPermit::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->get();
        $type = "permit";
        return view('truck.road_permit',compact('sticker','type','truck','client'));
    }
  public function comesa($id)
    {
        //
        $truck =  Truck::find($id);
         $client=Supplier::where('user_id', auth()->user()->added_by)->get();
        $sticker=Comesa::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->get();
        $type = "comesa";
        return view('truck.comesa',compact('sticker','type','truck','client'));
    }
  public function carbon($id)
    {
        //
        $truck =  Truck::find($id);
         $client=Supplier::where('user_id', auth()->user()->added_by)->get();
        $sticker=TruckCarbon::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->get();
        $type = "carbon";
        return view('truck.carbon',compact('sticker','type','truck','client'));
    }
     public function wma($id)
    {
        //
        $truck =  Truck::find($id);
         $client=Supplier::where('user_id', auth()->user()->added_by)->get();
        $wma=WMA::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->get();
        $type = "wma";
        return view('truck.wma',compact('wma','type','truck','client'));
    }
      public function device($id)
    {
        //
        $truck =  Truck::find($id);
         $client=Supplier::where('user_id', auth()->user()->added_by)->get();
        $device=Device::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->get();
        $type = "device";
        return view('truck.device',compact('device','type','truck','client'));
    }
  public function fuel(Request $request, $id)
    {
        //
        $truck =  Truck::find($id);
      
        $type = "fuel";
         $start_date = $request->start_date;
        $end_date = $request->end_date;
  if(!empty($start_date) || !empty($end_date)){
  $fuel=Fuel::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->whereBetween('date',  [$start_date, $end_date])->get();                            
}

else{
  $fuel=Fuel::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->get();    
}


        return view('truck.fuel',compact('fuel','type','truck','start_date','end_date'));
    }
  public function route(Request $request, $id)
    {
        //
        $truck =  Truck::find($id);
        $route=CargoLoading::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->get();
        $type = "route";
         $start_date = $request->start_date;
        $end_date = $request->end_date;

        if(!empty($start_date) || !empty($end_date)){
 $route=CargoLoading::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->whereBetween('collection_date', [$start_date, $end_date])->get();                          
}

else{
 $route=CargoLoading::where('added_by', auth()->user()->added_by)->where('truck_id',$id)->get(); ;       
}
        return view('truck.route',compact('route','type','truck','start_date','end_date'));
    }

public function connect()
    {
        //
        $truck = Truck::where('added_by', auth()->user()->added_by)->where('truck_type','Horse')->where('disabled','0')->get();
       return view('truck.connect',compact('truck'));
    }

public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
                 if($type == 'connect'){
                    $truck = Truck::where('added_by', auth()->user()->added_by)->where('truck_type','Trailer')->where('connect_trailer','0')->get();
                    return view('truck.addconnect',compact('id','truck'));                
                 }elseif($type == 'assign'){
                    $data =  Truck::find($id);
                    //$staff=FieldStaff::where('added_by', auth()->user()->added_by)->get();
                      $staff=User::where('added_by', auth()->user()->added_by)->where('id','!=','1')->get();
                    $name=Tyre::where('added_by', auth()->user()->added_by)->where('status','0')->orwhere('status','2')->get();
                    return view('tyre.addtyre',compact('id','data','staff','name'));   
                 } elseif($type == 'driver'){
                    $driver = Driver::where('added_by', auth()->user()->added_by)->where('status','0')->get();
                    return view('truck.adddriver',compact('id','driver'));
                
                 } 
                  else if($type == 'assign_eq'){
                    $data=EquipmentList::find($id);
                    $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
                    $staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
                return view('truck.assign_equipment',compact('id','data','truck','staff'));
                  }
                   
              else if($type == 'issue'){
                $data=TruckEquipmentItem::where('issue_id',$id)->get();
                return view('truck.view_issue',compact('id','data'));
                  }
                  
                   else if($type == 'returned'){
                    $data=TruckEquipmentItem::where('issue_id',$id)->where('due_quantity', '0')->get();
                    return view('truck.view_returned',compact('id','data'));
                  }
                  
                       
              else if($type == 'update'){
               
                return view('truck.update',compact('id'));
                  }

                 }

 public function save_disable($id)
    {
        //
        $truck =  Truck::find($id);
       $horse=$truck->connect_trailer;

       $data['connect_trailer']='0';
        $data['connect_horse']='0';
         $data['disabled']='1';

      $trailer=  Truck::find($horse);

        $item['connect_horse']='0';
        $item['connect_trailer']='0';
        

     
        $truck->update($data);
        TruckTyre ::where('truck_id',$id)->update(['disabled' => '1']);

if(!empty($trailer)){
      $trailer->update($item);
}
        return redirect(route('truck.index'))->with(['success'=>'Truck Disabled Successfully']);
    }

   public function save_connect(Request $request)
    {
        //
        $truck =  Truck::find($request->id);
    $trailer=  Truck::find($request->connect_trailer);

     if($truck->location == $trailer->location){
        $data['connect_trailer']=$request->connect_trailer;
        $data['connect_horse']='1';
        $truck->update($data);
 
   
        $item['connect_horse']=$request->id;
        $item['connect_trailer']='1';
        $trailer->update($item);

        return redirect(route('truck.connect'))->with(['success'=>'Truck Updated Successfully']);
}


else{
  return redirect(route('truck.connect'))->with(['error'=>'Choose Trailer with the same location as Horse.']);
}


    }

   public function save_disconnect($id)
    {
        //
        $truck =  Truck::find($id);
       $horse=$truck->connect_trailer;

        $data['connect_trailer']='0';
        $data['connect_horse']='0';
        $truck->update($data);
 
   $trailer=  Truck::find($horse);
        $item['connect_horse']='0';
        $item['connect_trailer']='0';
        $trailer->update($item);

        return redirect(route('truck.connect'))->with(['success'=>'Truck Updated Successfully']);
    }

public function connect_driver()
    {
        //
        $truck = Truck::where('added_by', auth()->user()->added_by)->where('truck_type','Horse')->where('disabled','0')->get();
       return view('truck.driver',compact('truck'));
    }

public function save_driver(Request $request)
    {
        //
        $truck =  Truck::find($request->id);
        $data['driver']=$request->driver;
        $truck->update($data);

    if(!empty($truck->connect_horse=='1')){
$trailer=Truck::find($truck->connect_trailer);
$trailer->update(['driver'=>$request->driver]);
}
 
         $driver=  Driver::find($request->driver);
        $item['status']='1';
       $driver->update($item);

        return redirect(route('truck.driver'))->with(['success'=>'Truck Updated Successfully']);
    }

   public function remove_driver($id)
    {
        //
         $truck =  Truck::find($id);
        $data['driver']='';
       
       $driver=  Driver::find($truck->driver);
       $item['status']='0';
       $driver->update($item);

       if(!empty($truck->connect_horse=='1')){
$trailer=Truck::find($truck->connect_trailer);
$trailer->update(['driver'=>'']);
}

      $truck->update($data);

        return redirect(route('truck.driver'))->with(['success'=>'Truck Updated Successfully']);
    }
    
     public function expire_list(Request $request)
    {

              $date = today()->addMonths(2)->format('Y-m-d');

               $data=TruckInsurance::leftJoin('stickers', 'stickers.truck_id','truck_insurances.truck_id')
               ->where('truck_insurances.truck_id',$request->id)
               ->where('truck_insurances.expire_date', '<=', $date) 
                 ->orwhere('stickers.truck_id',$request->id)
               ->orwhere('stickers.expire_date', '<=', $date)      
            ->select('stickers.*','truck_insurances.*')
        ->get();
                             

    }



public function truck_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get() as $key) {
            $chart_of_accounts[$key->id] = $key->truck_name. " - " . $key->reg_no ;
        }
        if($request->isMethod('post')){
            $data=JournalEntry::where('added_by', auth()->user()->added_by)->where('truck_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
        }else{
            $data=[];
        }

       
if($request->type == 'print_pdf'){
                        $data=JournalEntry::where('added_by', auth()->user()->added_by)->where('truck_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
             $pdf = PDF::loadView('truck.truck_report_pdf',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'))->setPaper('a4', 'potrait');

         $truck=Truck::where('added_by', auth()->user()->added_by)->where('id',$account_id)->first();
        return $pdf->download($truck->reg_no  .' TRUCK REPORT ' . ' - ' . $request->end_date . ".pdf");
        
         
        }else{

        return view('truck.truck_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }
}

public function truck_summary(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
      $repair= AccountCodes::where('added_by', auth()->user()->added_by)->where('account_name','Truck Maintenance and Service')->first();

        foreach (Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get() as $key) {
            $chart_of_accounts[$key->id] = $key->truck_name. " - " . $key->reg_no ;
        }
    
            $data=Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get();
     
        if($request->type == 'print_pdf'){
                $data=Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get();
             $pdf = PDF::loadView('truck.truck_summary_pdf',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id','repair'))->setPaper('a4', 'landscape');
           
            if(!empty($end_date)){
        return $pdf->download('TRUCK SUMMARY REPORT ' . ' - ' . $request->end_date . ".pdf");
       }

       else{
         return $pdf->download("TRUCK SUMMARY REPORT.pdf");
} 
         
        }else{
       

        return view('truck.truck_summary',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id','repair'));
    }
}


}
