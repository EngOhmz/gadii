<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\Maintainance;
use App\Models\Truck;
use Illuminate\Http\Request;

class MaintainanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
  
        $maintain=Maintainance::all();
        $truck = Truck::all();
        $staff = FieldStaff::all();
       return view('inventory.maintainance',compact('maintain','truck','staff'));
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
        $data = $request->all();
        $driver=Truck::where('id',$request->truck)->first();
        $data['driver']=$driver->driver;
        $data['status']='0';
        $data['added_by']=auth()->user()->id;
        $data['truck_name']=$driver->truck_name;
        $maintain= Maintainance::create($data);
 
        return redirect(route('maintainance.index'))->with(['success'=>'Maintainance Created Successfully']);
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

        $data=Maintainance::find($id);
        $truck = Truck::all();
        $staff = FieldStaff::all();
       return view('inventory.maintainance',compact('data','truck','staff','id'));
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
        $maintain =  Maintainance::find($id);

        $data = $request->all();
        $driver=Truck::where('id',$request->truck)->first();
        $data['driver']=$driver->driver;
        $data['truck_name']=$driver->truck_name;
        $data['added_by']=auth()->user()->id;
        $maintain->update($data);
 
        return redirect(route('maintainance.index'))->with(['success'=>'Maintainance Updated Successfully']);
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

        $maintain =  Maintainance::find($id);
        $maintain->delete();
 
        return redirect(route('maintainance.index'))->with(['success'=>'Maintainance Deleted Successfully']);
    }

    public function approve($id)
    {
        //
        $maintain = Maintainance::find($id);
        $data['status'] = 1;
        $maintain->update($data);
        return redirect(route('maintainance.index'))->with(['success'=>'Maintainance Completed Successfully']);
    }

}
