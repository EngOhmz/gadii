<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;
use App\Models\FeedType;
use App\Models\Crops_type;
use Illuminate\Http\Request;

class FeedTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $price =FeedType::all();
       $crop=Crops_type::all();
        return view('farming.feed_type',compact('price','crop'));
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
        $price = FeedType::create($data);
 
        return redirect(route('seed_type.index'))->with(['success'=>'Feed Type Created Successfully']);
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
        $data =  FeedType::find($id);
      $crop=Crops_type::all();
        return view('farming.feed_type',compact('data','id','crop'));
 
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
        $price = FeedType::find($id);

        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $price->update($data);
 
        return redirect(route('seed_type.index'))->with(['success'=>'Feed Type Updated Successfully']);
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
 
        $price = FeedType::find($id);
        $price->delete();
 
        return redirect(route('seed_type.index'))->with(['success'=>'Feed Type Deleted Successfully']);
    }
}
