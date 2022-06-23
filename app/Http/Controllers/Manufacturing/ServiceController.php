<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\Truck;
use Illuminate\Http\Request;

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
        $service=Service::all();
        $truck = Truck::all();
        $staff = FieldStaff::all();
       return view('inventory.service',compact('service','truck','staff'));
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
        $data['added_by']= auth()->user()->id;
        $data['truck_name']=$driver->truck_name;
        $service = Service::create($data);
        
       

        $nameArr =$request->minor ;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'minor' => $nameArr[$i],
                        'truck' =>    $data['truck'],
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'service_id' =>$service->id);
                       
                    ServiceItem::create($items);  ;
    
    
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
        $truck = Truck::all();
        $staff = FieldStaff::all();
       return view('inventory.service',compact('data','truck','staff','id','items'));
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
        $data['added_by']= auth()->user()->id;
        $data['truck_name']=$driver->truck_name;
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
                           'added_by' => auth()->user()->id,
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
        return redirect(route('service.index'))->with(['success'=>'Service Completed Successfully']);
    }
}
