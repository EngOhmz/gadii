<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $package= Package::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
      
       return view('manufacturing.package',compact('package'));
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
        
        $data['description']=$request->description;
        
        
         $data['name']=$request->name;
         
        $data['added_by']=auth()->user()->added_by;
         $data['created_by']=auth()->user()->id;
        
        $package = Package::create($data);
 
        return redirect(route('manufacturing_package.index'))->with(['success'=>'package Created Successfully']);
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
        $data =  Package::find($id);
        $package= Package::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
        return view('manufacturing.package',compact('data','id', 'package'));
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
        $package=  Package::find($id);

        $data['description']=$request->description;
        
        
         $data['name']=$request->name;
         
        $data['added_by']=auth()->user()->added_by;
         $data['created_by']=auth()->user()->id;
        $package->update($data);
 
        return redirect(route('manufacturing_package.index'))->with(['success'=>'package Updated Successfully']);
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
        $package=  Package::find($id);
        $package->update(['disabled'=> '1']);
 
        return redirect(route('manufacturing_package.index'))->with(['success'=>'package Deleted Successfully']);
    }
}
