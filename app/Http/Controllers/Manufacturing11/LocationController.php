<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $location= Location::all()->whereNotIn('type', [6])->where('disabled','0')->where('added_by', auth()->user()->added_by);
      
       return view('manufacturing.location',compact('location'));
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

        // $data=$request->post();
        
        $data['type']=$request->store_type;
        
        if(!empty($request->quantity)){
            $data['quantity']=$request->quantity;
        }
        else{
            $data['quantity']= 0;
        }
        
        
         $data['name']=$request->name;
         
         
         $data['main']=$request->main;
         
        $data['added_by']=auth()->user()->added_by;
         $data['created_by']=auth()->user()->id;
         $data['assigned_to']=auth()->user()->id;
        
        $location = Location::create($data);
 
        return redirect(route('manufacturing_location.index'))->with(['success'=>'Location Created Successfully']);
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
        $data =  Location::find($id);
        return view('manufacturing.location',compact('data','id'));
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
        $location=  Location::find($id);

        $data['type']=$request->store_type;
        
        if(!empty($request->quantity)){
            $data['quantity']=$request->quantity;
        }
        else{
            $data['quantity']= 0;
        }
        
        
        
        
         $data['name']=$request->name;
         
         $data['assigned_to']=auth()->user()->id;
         
        $data['added_by']=auth()->user()->added_by;
         $data['created_by']=auth()->user()->id;
        $location->update($data);
 
        return redirect(route('manufacturing_location.index'))->with(['success'=>'Location Updated Successfully']);
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
        $location=  Location::find($id);
        $location->update(['disabled'=> '1']);
 
        return redirect(route('manufacturing_location.index'))->with(['success'=>'Location Deleted Successfully']);
    }
}
