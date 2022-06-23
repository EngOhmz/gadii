<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;
use App\Models\PesticideType;
use App\Models\Crops_type;
use Illuminate\Http\Request;

class PesticideTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $price =PesticideType::all();
       $crop=Crops_type::all();
        return view('farming.pesticide_type',compact('price','crop'));
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
        $data['user_id']=auth()->user()->id;
        $price =PesticideType::create($data);
 
        return redirect(route('pesticide_type.index'))->with(['success'=>' Created Successfully']);
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
        $data =  PesticideType::find($id);
      $crop=Crops_type::all();
        return view('farming.pesticide_type',compact('data','id','crop'));
 
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
        $price = PesticideType::find($id);

        $data=$request->post();
         $data['user_id']=auth()->user()->id;
        $price->update($data);
 
        return redirect(route('pesticide_type.index'))->with(['success'=>'Updated Successfully']);
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
 
        $price = PesticideType::find($id);
        $price->delete();
 
        return redirect(route('pesticide_type.index'))->with(['success'=>' Deleted Successfully']);
    }
}
