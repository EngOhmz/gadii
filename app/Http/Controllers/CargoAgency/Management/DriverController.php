<?php

namespace App\Http\Controllers\CargoAgency\Management;


use App\Http\Controllers\Controller;

use App\Models\Management\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $drivers = Driver::all();

        return view('management.add_driver', compact('drivers'));
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
        $this->validate($request,[
            'name'=>'required',

        ]); 

        $driver= new Driver();

        $driver->name=$request->input('name');
        $driver->phone=$request->input('phone');
        $driver->status = 1;



        $driver->save();

        return redirect()->route('driver.index')->with('success', 'Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Management\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Management\Driver  $driver
      * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $driver = Driver::find($id);

        return view('management.edit_driver', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Management\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        //
        $this->validate($request,[
            'name'=>'required',

        ]); 
        
      
        $driver->update($request->all());

        return redirect()->route('driver.index')->with('success', 'Updated Successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Management\Driver  $driver
      * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data=Driver::find($id);
        $data->delete();

        return redirect()->route('driver.index')->with('success', 'Deleted Successfully');
    }
}
