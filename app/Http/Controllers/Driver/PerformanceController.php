<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Performance;
use Illuminate\Http\Request;

class PerformanceController extends Controller
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
        if ($request->hasFile('attachment')) {
            $file=$request->file('attachment');
            $fileType=$file->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $name=$fileName;
            $path = public_path(). "/assets/files/performance/";
            $file->move($path, $fileName );
            $data['attachment']=$name;        
        }
        else{
            $data['attachment'] = null;
    }
        $data['issue']=$request->issue;
        $data['date']=$request->date;
        $data['reason']=$request->reason;
        $data['explanation']=$request->explanation;
        $data['effect']=$request->effect;
        $data['driver_id']=$request->driver_id;
       
        $data['added_by']=auth()->user()->id;
        $performance= Performance::create($data);
 
        return redirect(route('driver.performance', $request->driver_id))->with(['success'=>"Performance Created Successfully",'type'=>"performance"]);
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
        $data =  Performance::find($id);      
        $driver =  Driver::where('id',$data->driver_id)->first();
        $type = "edit-performance";
        return view('driver.performance',compact('data','id','type','driver'));
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
        $performance =Performance::find($id);

        if ($request->hasFile('attachment')) {
            $file=$request->file('attachment');
            $fileType=$file->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $name=$fileName;
            $path = public_path(). "/assets/files/performance/";
            $file->move($path, $fileName );
            $data['attachment']=$name;        
        }
        else{
            $data['attachment'] = null;
    }

        $data['issue']=$request->issue;
        $data['date']=date('Y-m-d', strtotime($request->date));
        $data['reason']=$request->reason;
        $data['explanation']=$request->explanation;
        $data['effect']=$request->effect;
        $data['driver_id']=$request->driver_id;
        $data['added_by']=auth()->user()->id;

        if(!empty($performance->attachment)){
        if($request->hasFile('attachment')){
            $path = public_path(). "/assets/files/performance/" .$performance->attachment;            
            unlink($path);  
           
        }
    }

        $performance->update($data);
 
        return redirect(route('driver.performance', $request->driver_id))->with(['success'=>"Performance Updated Successfully",'type'=>"performance"]);
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
        $performance= Performance::find($id);
        if(!empty($performance->attachment)){
        $path = public_path(). "/assets/files/performance/" .$performance->attachment;            
        unlink($path); 
        } 
        $licence->delete();
        return redirect(route('driver.performance'))->with(['success'=>"Performance Deleted Successfully",'type'=>"performance"]);
    }

    public function pdownload(Request $request)
{
    $performance = Performance::find($request->id);
    $file = public_path(). "/assets/files/performance/".$performance->attachment;

    $headers = ['Content-Type: file/pdf'];

    return \Response::download($file, 'filename.pdf', $headers);
}
}
