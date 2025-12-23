<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Storage;
use App\Models\Licence;
use App\Models\Performance;
use App\Models\Fuel\Fuel;
use App\Models\orders\OrderMovement;
use App\Models\CargoLoading;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $driver = Driver::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();    
        return view('driver.driver',compact('driver'));
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

  

         //handle file upload
         if($request->hasFile('profile')){
            $filenameWithExt=$request->file('profile')->getClientOriginalName();
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension=$request->file('profile')->getClientOriginalExtension();
            $fileNameToStore=$filename.'_'.time().'.'.$extension;
            $path = public_path('/assets/img/driver');
             $request->file('profile')->move($path, $fileNameToStore);
           
        }
        
        else{
          $fileNameToStore=null;   
        }

        $data=$request->post();
        $data['profile']=$fileNameToStore;
        $data['added_by']=auth()->user()->added_by;
        $driver= Driver::create($data);
 
        return redirect(route('driver.index'))->with(['success'=>'Driver Created Successfully']);
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
        $data =  Driver::find($id);
        return view('driver.driver',compact('data','id'));
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

        $driver =  Driver::find($id);
        
        
         //handle file upload
         if($request->hasFile('profile')){
            $filenameWithExt=$request->file('profile')->getClientOriginalName();
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension=$request->file('profile')->getClientOriginalExtension();
            $fileNameToStore=$filename.'_'.time().'.'.$extension;
           
             $path = public_path('/assets/img/driver');
             $request->file('profile')->move($path, $fileNameToStore);
             
              
                
        }
        else{
            $fileNameToStore = null;
    }

        $data=$request->post();
         $data['profile']=$fileNameToStore;
        $data['added_by']=auth()->user()->added_by;

        if(!empty($driver->profile)){
        if($request->hasFile('profile')){
            unlink('public/assets/img/driver'.$driver->profile);  
           
        }
    }
    
  
        $driver->update($data);

        return redirect(route('driver.index'))->with(['success'=>'Driver Updated Successfully']);
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
        $driver = Driver::find($id);
        if(!empty($driver->attachment)){
        unlink('public/assets/img/driver'.$driver->profile);
        }
        $driver->update(['disabled' => '1']);
        return redirect(route('driver.index'))->with(['success'=>'Driver Deleted Successfully']);
    }

   
     public function licence($id)
    {
        //
        $driver =  Driver::find($id);
        $licence=Licence::where('driver_id',$id)->get();
        $type = "licence";
        return view('driver.licence',compact('licence','type','driver'));
    }
    public function performance($id)
    {
        //
        $driver =  Driver::find($id);
        $performance=Performance::where('driver_id',$id)->get();
        $type = "performance";
        return view('driver.performance',compact('performance','type','driver'));
    }

     public function fuel(Request $request, $id)
    {
        //
        $driver =  Driver::find($id);
      
        $type = "fuel";
         $start_date = $request->start_date;
        $end_date = $request->end_date;
  if(!empty($start_date) || !empty($end_date)){
  $fuel=Fuel::where('added_by', auth()->user()->added_by)->where('driver_id',$id)->whereBetween('date',  [$start_date, $end_date])->get();                              
}

else{
  $fuel=Fuel::where('added_by', auth()->user()->added_by)->where('driver_id',$id)->get();;    

}
        return view('driver.fuel',compact('fuel','type','driver','start_date','end_date'));
    }
  public function route(Request $request, $id)
    {
        //
        $driver =  Driver::find($id);
        $route=CargoLoading::where('added_by', auth()->user()->added_by)->where('driver_id',$id)->get();     
        $type = "route";
         $start_date = $request->start_date;
        $end_date = $request->end_date;

        if(!empty($start_date) || !empty($end_date)){
 $route=CargoLoading::where('added_by', auth()->user()->added_by)->where('driver_id',$id)->whereBetween('collection_date', [$start_date, $end_date])->get();                            
}

else{
 $route=CargoLoading::where('added_by', auth()->user()->added_by)->where('driver_id',$id)->get();   
}
        return view('driver.route',compact('route','type','driver','start_date','end_date'));
    }

}
