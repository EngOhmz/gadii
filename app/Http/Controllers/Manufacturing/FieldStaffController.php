<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use Fiber;
use Illuminate\Http\Request;

class FieldStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $fieldstaff= FieldStaff::all();
      
        return view('inventory.fieldstaff',compact('fieldstaff'));
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
        $fieldstaff = FieldStaff::create($data);
 
        return redirect(route('fieldstaff.index'))->with(['success'=>'Field Staff Created Successfully']);
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
        $data =  FieldStaff::find($id);
        return view('inventory.fieldstaff',compact('data','id'));
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
        $fieldstaff=FieldStaff::find($id);

        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $fieldstaff->update($data);
 
        return redirect(route('fieldstaff.index'))->with(['success'=>'Field Staff Updated Successfully']);
        
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
        $fieldstaff=FieldStaff::find($id);
        $fieldstaff->delete();
 
        return redirect(route('fieldstaff.index'))->with(['success'=>'Field Staff Deleted Successfully']);
    }
}
