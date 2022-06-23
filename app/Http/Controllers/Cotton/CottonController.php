<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\Cotton\Cotton;
use Illuminate\Http\Request;

class CottonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $inventory= Cotton::all();
      
        return view('cotton.cotton',compact('inventory'));
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
        $inventory = Cotton::create($data);
 
        return redirect(route('cotton_list.index'))->with(['success'=>'Item Created Successfully']);
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
        $data =  Cotton::find($id);
        return view('cotton.cotton',compact('data','id'));
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
        $inventory =  Cotton::find($id);
        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $inventory->update($data);
 
        return redirect(route('cotton_list.index'))->with(['success'=>'Item Updated Successfully']);
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
        $inventory =  Cotton::find($id);
        $inventory->delete();
 
        return redirect(route('cotton_list.index'))->with(['success'=>'Item Deleted Successfully']);
    }
}
