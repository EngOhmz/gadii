<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Sticker;
use App\Models\Truck;
use App\Models\Tyre\TruckTyre ;
use App\Models\TruckInsurance;
use Illuminate\Http\Request;
use App\Models\Fuel\Fuel;
use App\Models\orders\OrderMovement;
use App\Models\Region;
use App\Models\CargoLoading;
use App\Models\JournalEntry;

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
        $truck = Truck::all(); 
        $driver=Driver::all(); 
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
        $data['added_by']=auth()->user()->id;
        $truck= Truck::create($data);

      $item['truck_id']=$truck->id;
       $item['total_tyre']=$request->total_diff +$request->total_rear + $request->total_trailer ;
       $item['due_tyre']=$request->total_diff +$request->total_rear + $request->total_trailer ;
      $item['total_diff']=$request->total_diff ;
       $item['due_diff']=$request->total_diff  ;
     $item['total_rear']=$request->total_rear  ;
       $item['due_rear']=$request->total_rear ;
   $item['total_trailer']= $request->total_trailer ;
       $item['due_trailer']= $request->total_trailer ;
       $item['added_by']=auth()->user()->id;
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
        $driver=Driver::all();  
  $region = Region::all();   
        $tyre= TruckTyre ::where('truck_id',$id)->first(); 
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

      $tyre=TruckTyre ::where('truck_id',$id)->first();
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
       $item['added_by']=auth()->user()->id;
  TruckTyre ::create($item);
 }

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
        $insurance=TruckInsurance::where('truck_id',$id)->get();
        $type = "insurance";
        return view('truck.insurance',compact('insurance','type','truck'));
    }
    public function sticker($id)
    {
        //
        $truck =  Truck::find($id);
        $sticker=Sticker::where('truck_id',$id)->get();
        $type = "sticker";
        return view('truck.sticker',compact('sticker','type','truck'));
    }
  public function fuel(Request $request, $id)
    {
        //
        $truck =  Truck::find($id);
      
        $type = "fuel";
         $start_date = $request->start_date;
        $end_date = $request->end_date;
  if(!empty($start_date) || !empty($end_date)){
  $fuel=Fuel::where('truck_id',$id)->whereBetween('created_at',  [$start_date, $end_date])->paginate(10);                            
}

else{
  $fuel=Fuel::where('truck_id',$id)->paginate(10);    
}


        return view('truck.fuel',compact('fuel','type','truck','start_date','end_date'));
    }
  public function route(Request $request, $id)
    {
        //
        $truck =  Truck::find($id);
        $route=CargoLoading::where('truck_id',$id)->get();
        $type = "route";
         $start_date = $request->start_date;
        $end_date = $request->end_date;

        if(!empty($start_date) || !empty($end_date)){
 $route=CargoLoading::where('truck_id',$id)->whereBetween('collection_date', [$start_date, $end_date])->paginate(10);                          
}

else{
 $route=CargoLoading::where('truck_id',$id)->paginate(1);       
}
        return view('truck.route',compact('route','type','truck','start_date','end_date'));
    }

public function connect()
    {
        //
        $truck = Truck::where('truck_type','Horse')->get();
       return view('truck.connect',compact('truck'));
    }

public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
                 if($type == 'connect'){
                    $truck = Truck::where('truck_type','Trailer')->where('connect_trailer','0')->get();
                    return view('truck.addconnect',compact('id','truck'));                
                 }elseif($type == 'assign'){
                    $data =  Truck::find($id);
                    //$staff=FieldStaff::all();
                      $staff=User::where('id','!=','1')->get();
                    $name=Tyre::where('status','0')->orwhere('status','2')->get();
                    return view('tyre.addtyre',compact('id','data','staff','name'));   
                 } elseif($type == 'driver'){
                    $driver = Driver::where('status','0')->get();
                    return view('truck.adddriver',compact('id','driver'));
                
                 }  

                 }

   public function save_connect(Request $request)
    {
        //
        $truck =  Truck::find($request->id);
        $data['connect_trailer']=$request->connect_trailer;
        $data['connect_horse']='1';
        $truck->update($data);
 
   $trailer=  Truck::find($request->connect_trailer);
        $item['connect_horse']=$request->id;
        $item['connect_trailer']='1';
        $trailer->update($item);

        return redirect(route('truck.connect'))->with(['success'=>'Truck Updated Successfully']);
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
        $truck = Truck::where('truck_type','Horse')->get();
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

public function truck_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (Truck::all() as $key) {
            $chart_of_accounts[$key->id] = $key->truck_name. " - " . $key->reg_no ;
        }
        if($request->isMethod('post')){
            $data=JournalEntry::where('truck_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
        }else{
            $data=[];
        }

       

        return view('truck.truck_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }

}
