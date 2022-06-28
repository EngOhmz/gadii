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
        $driver = Driver::all();     
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

        $this->validate($request,[
            'profile' => 'image|required|max:1999',
        ]);

         //handle file upload
         if($request->hasFile('profile')){
            $filenameWithExt=$request->file('profile')->getClientOriginalName();
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension=$request->file('profile')->getClientOriginalExtension();
            $fileNameToStore=$filename.'_'.time().'.'.$extension;
            $path=$request->file('profile')->storeAs('public/assets/img/driver',$fileNameToStore);
        }

        $data['driver_name']=$request->driver_name;
        $data['address']=$request->address;
        $data['referee']=$request->referee;
        $data['experience']=$request->experience;
         $data['type']=$request->type;
        $data['driver_status']=$request->driver_status;
        $data['profile']=$fileNameToStore;
        $data['added_by']=auth()->user()->id;
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
            $path=$request->file('profile')->storeAs('public/assets/img/driver',$fileNameToStore);
            $data['profile']=$fileNameToStore;
        }
        else{
            $data['profile'] = null;
    }

        $data['driver_name']=$request->driver_name;
        $data['address']=$request->address;
        $data['referee']=$request->referee;
        $data['experience']=$request->experience;
        $data['driver_status']=$request->driver_status;  
     $data['type']=$request->type;     
        $data['added_by']=auth()->user()->id;

        if(!empty($driver->attachment)){
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
        $driver->delete();
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
  $fuel=Fuel::where('driver_id',$id)->whereBetween('created_at',  [$start_date, $end_date])->paginate(10);                             
}

else{
  $fuel=Fuel::where('driver_id',$id)->paginate(10);    

}
        return view('driver.fuel',compact('fuel','type','driver','start_date','end_date'));
    }
  public function route(Request $request, $id)
    {
        //
        $driver =  Driver::find($id);
        $route=CargoLoading::where('driver_id',$id)->paginate(10);    
        $type = "route";
         $start_date = $request->start_date;
        $end_date = $request->end_date;

        if(!empty($start_date) || !empty($end_date)){
 $route=CargoLoading::where('driver_id',$id)->whereBetween('collection_date', [$start_date, $end_date])->paginate(10);                            
}

else{
 $route=CargoLoading::where('driver_id',$id)->paginate(10);    
}
        return view('driver.route',compact('route','type','driver','start_date','end_date'));
    }

}
