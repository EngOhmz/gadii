<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Farming_process;


class Farming_processController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $process = Farming_process::all();

        return view('farming_process.manage_farming_process',compact('process'));
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

        $process  = Farming_process::create($request->all());

        return redirect(route('farming_process.index'))->with(['success'=>"Created successfukky"]);
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
        $data = Farming_process::find($id);

        return view('farming_process.manage_farming_process',compact('id','data'));
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
        $process = Farming_process::find($id);
        $process->update($request->all());

        return redirect(route('farming_process.index'))->with(['success'=>"Updated successfully"]);
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
        $cost = Farming_process::find($id);
        $cost->delete();

        return redirect(route('farming_process.index'))->with(['success'=>"Deleted successfuly"]);
    }
}

