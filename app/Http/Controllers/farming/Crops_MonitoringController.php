<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Crops_Monitoring;
use App\Models\Land_properties;
use App\Models\Monitoring_type;
use App\Models\Monitoring_Solutions;

class Crops_MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $monitoring = Crops_Monitoring::all();
        $farm = Land_properties::all();
        $type = Monitoring_type::all();

        return view('crops_monitoring.manage_crops_monitoring',compact('monitoring','farm','type'));
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
         $data = $request->all();
        
        if ($request->hasFile('attachment')) {
					$file=$request->file('attachment');
					$fileType=$file->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$name=$fileName;
					$path = public_path(). "/assets/files/";
					$file->move($path, $fileName );
					
					$data['attachment'] = $name;
            	}else{
            	    	$data['attachment'] = null;
            	}

        $cost  = Crops_Monitoring::create($data);

        return redirect(route('crops_monitoring.index'))->with(['success'=>"Crop Monnitoring created successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        //
             //
       switch ($request->type) {
        case 'add':
                return view('crops_monitoring.addSolution',compact('id'));
                break;
        case 'show':
                $data = Monitoring_Solutions::all()->find($id);
                return view('crops_monitoring.viewSolution',compact('id','data'));
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
        $data = Crops_Monitoring::find($id);
         $type = Monitoring_type::all();
          $farm = Land_properties::all();

        return view('crops_monitoring.manage_crops_monitoring',compact('id','data','type','farm'));
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
        if($request->type == "solution"){
            $data  = $request->except('type');
            $data['monitoring_id'] = $id;
            $solution = Monitoring_Solutions::create($data);
                      $status['status'] = 1;
                      $monitoring = Crops_Monitoring::find($id);
                      $monitoring->update($status);
            return redirect(route('crops_monitoring.index'))->with(['success'=>"monitoring solution created successfully"]);
        }else{
            
        $data = $request->all();
        if ($request->hasFile('attachment')) {
					$file=$request->file('attachment');
					$fileType=$file->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$name=$fileName;
					$path = public_path(). "/assets/files/";
					$file->move($path, $fileName );
					
					$data['attachment'] = $name;
            	}else{
            	    	$data['attachment'] = null;
            	}
            	
            
          $monitoring = Crops_Monitoring::find($id);
          $monitoring->update($data);


        return redirect(route('crops_monitoring.index'))->with(['success'=>"crop monitoring updated successfully"]);
        
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     public function download(Request $request)
{
    $monitoring = Crops_Monitoring::find($request->id);
    $file = public_path(). "/assets/files/".$monitoring->attachment;

    $headers = ['Content-Type: file/pdf'];

    return \Response::download($file, 'crop_monitoring.jpg', $headers);
}

    public function destroy($id)
    {
        //
        $cost = Crops_Monitoring::find($id);
        $cost->delete();

        return redirect(route('crops_monitoring.index'))->with(['success'=>"crop monitoring  deleted successfuly"]);
    }
}
