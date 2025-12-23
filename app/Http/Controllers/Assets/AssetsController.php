<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assets;
use Illuminate\Support\Facades\Storage;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $assets = Assets::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();    
        return view('asset.asset.index',compact('assets'));
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
            $path = public_path('/assets/img/assets/assets');
             $request->file('profile')->move($path, $fileNameToStore);
           
        }
        
        else{
          $fileNameToStore=null;   
        }

        $data=$request->post();
        $data['profile']=$fileNameToStore;
        $data['added_by']=auth()->user()->added_by;
        $assets= Assets::create($data);
 
        return redirect(route('assets.index'))->with(['success'=>'Asset Created Successfully']);
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
        $data =  Assets::find($id);
        return view('asset.asset.index',compact('data','id'));
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

        $assets =  Assets::find($id);
        
        
         //handle file upload
         if($request->hasFile('profile')){
            $filenameWithExt=$request->file('profile')->getClientOriginalName();
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension=$request->file('profile')->getClientOriginalExtension();
            $fileNameToStore=$filename.'_'.time().'.'.$extension;
           
             $path = public_path('/assets/img/assets/assets');
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
            unlink('public/assets/img/assets/assets'.$driver->profile);  
           
        }
    }
    
  
        $driver->update($data);

        return redirect(route('assets.index'))->with(['success'=>'Asset Updated Successfully']);
    }

  
    public function destroy($id)
    {
        //
        $driver = Driver::find($id);
        if(!empty($driver->attachment)){
        unlink('public/assets/img/assets/assets'.$driver->profile);
        }
        $driver->update(['disabled' => '1']);
        return redirect(route('assets.index'))->with(['success'=>'Asset Deleted Successfully']);
    }

}