<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Courier\CourierList;
use Illuminate\Http\Request;

class CourierListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $price =CourierList::all();
      
        return view('courier.list',compact('price'));
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
        $price = CourierList::create($data);
 
        return redirect(route('courier_list.index'))->with(['success'=>'Item Created Successfully']);
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
        $data =  CourierList::find($id);
        return view('courier.list',compact('data','id'));
 
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
        $price = CourierList::find($id);

        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $price->update($data);
 
        return redirect(route('courier_list.index'))->with(['success'=>'Item Updated Successfully']);
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
 
        $price = CourierList::find($id);
        $price->delete();
 
        return redirect(route('courier_list.index'))->with(['success'=>'Item Deleted Successfully']);
    }
}
