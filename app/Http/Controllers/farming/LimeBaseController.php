<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;
use App\Models\LimeBase;
use Illuminate\Http\Request;

class LimeBaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $price =LimeBase::all();
      
        return view('farming.base',compact('price'));
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
        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $price = LimeBase::create($data);
 
        return redirect(route('lime_base.index'))->with(['success'=>' Created Successfully']);
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
        $data =  LimeBase::find($id);
        return view('farming.base',compact('data','id'));
 
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
        $price = LimeBase::find($id);

        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $price->update($data);
 
        return redirect(route('lime_base.index'))->with(['success'=>' Updated Successfully']);
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
 
        $price = LimeBase::find($id);
        $price->delete();
 
        return redirect(route('lime_base.index'))->with(['success'=>' Deleted Successfully']);
    }
}
