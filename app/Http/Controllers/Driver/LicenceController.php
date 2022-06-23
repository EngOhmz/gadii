<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Licence;
use Illuminate\Http\Request;

class LicenceController extends Controller
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
            $path = public_path(). "/assets/files/licence/";
            $file->move($path, $fileName );
            $data['attachment']=$name;        
        }
        else{
            $data['attachment'] = null;
    }

        $data['class']=$request->class;
        $data['year']=$request->year;
        $data['expire']=$request->expire;
        $data['driver_id']=$request->driver_id;
        $data['attachment']=$name;
        $data['added_by']=auth()->user()->id;
        $licence= Licence::create($data);
 
        return redirect(route('driver.licence', $request->driver_id))->with(['success'=>"Licence Created Successfully",'type'=>"licence"]);
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
        $data =  Licence::find($id);      
        $driver =  Driver::where('id',$data->driver_id)->first();
        $type = "edit-licence";
        return view('driver.licence',compact('data','id','type','driver'));
        
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
        $licence =Licence::find($id);

        if ($request->hasFile('attachment')) {
            $file=$request->file('attachment');
            $fileType=$file->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $name=$fileName;
            $path = public_path(). "/assets/files/licence/";
            $file->move($path, $fileName );
            $data['attachment']=$name;        
        }
        else{
            $data['attachment'] = null;
    }  
        

        $data['class']=$request->class;
        $data['year']=$request->year;
        $data['expire']=$request->expire;
        $data['driver_id']=$request->driver_id;        
        $data['added_by']=auth()->user()->id;

        if(!empty($licence->attachment)){
        if($request->hasFile('attachment')){
            $path = public_path(). "/assets/files/licence/" .$licence->attachment;            
            unlink($path);  
           
        }
    }

        $licence->update($data);
 
        return redirect(route('driver.licence'))->with(['success'=>"Licence Updated Successfully",'type'=>"licence"]);
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
        $licence= Licence::find($id);
        if(!empty($licence->attachment)){
        $path = public_path(). "/assets/files/licence/" .$licence->attachment;            
        unlink($path);  
        }
        $licence->delete();
        return redirect(route('driver.licence', $request->driver_id))->with(['success'=>"Licence Deleted Successfully",'type'=>"licence"]);
    }

    public function ldownload(Request $request)
{
    $licence = Licence::find($request->id);
    $file = public_path(). "/assets/files/licence/".$licence->attachment;

    $headers = ['Content-Type: file/pdf'];

    return \Response::download($file, 'filename.pdf', $headers);
}
}
