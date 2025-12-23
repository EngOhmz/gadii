<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Courier\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $price =Storage::all();
      
        return view('courier.storage',compact('price'));
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
        $price = Storage::create($data);
 
        return redirect(route('storage_settings.index'))->with(['success'=>'Settings Created Successfully']);
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
        $data =  Storage::find($id);
        return view('courier.storage',compact('data','id'));
 
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
        $price = Storage::find($id);

        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $price->update($data);
 
        return redirect(route('storage_settings.index'))->with(['success'=>'Settings Updated Successfully']);
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
 
        $price = Storage::find($id);
        $price->delete();
 
        return redirect(route('storage_settings.index'))->with(['success'=>'Settings Deleted Successfully']);
    }
}
