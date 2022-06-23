<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Cost_centre;

class Cost_CentreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cost = Cost_centre::all();

        return view('cost_centre.manage_cost_centre',compact('cost'));
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

        $cost  = Cost_centre::create($request->all());

        return redirect(route('cost_centre.index'))->with(['success'=>"Cost created successfukky"]);
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
        $data = Cost_centre::find($id);

        return view('cost_centre.manage_cost_centre',compact('id','data'));
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
        $cost = Cost_centre::find($id);
        $cost->update($request->all());

        return redirect(route('cost_centre.index'))->with(['success'=>"cost updated successfully"]);
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
        $cost = Cost_centre::find($id);
        $cost->delete();

        return redirect(route('cost_centre.index'))->with(['success'=>"cost deleted successfuly"]);
    }
}
