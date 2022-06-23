<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;
use App\Models\FarmProgram;
use App\Models\Crops_type;
use App\Models\Farming_process;
use Illuminate\Http\Request;

class FarmProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $price =FarmProgram::all();
      $gap =Farming_process::all();
        return view('farming.program',compact('price','gap'));
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
        $price = FarmProgram::create($data);
 
        return redirect(route('farm_program.index'))->with(['success'=>'Farm Program Created Successfully']);
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
        $data =  FarmProgram::find($id);
 $gap =Farming_process::all();
        return view('farming.program',compact('data','id','gap'));
 
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
        $price = FarmProgram::find($id);

        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $price->update($data);
 
        return redirect(route('farm_program.index'))->with(['success'=>'Farm Program Updated Successfully']);
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
 
        $price = FarmProgram::find($id);
        $price->delete();
 
        return redirect(route('farm_program.index'))->with(['success'=>'Farm Program Deleted Successfully']);
    }
}
