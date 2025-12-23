<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel\Asset;
use App\Models\Restaurant\POS\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Response;

class AssetController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
       $client = Asset::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();   
       return view('hotel.asset.data',compact('client'));
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
      $data['value'] = str_replace(",","",$request->value);
      $data['added_by'] = auth()->user()->added_by;
      $client = Asset::create($data);


      return redirect(route('asset.index'))->with(['success'=>'Asset Created Successfully']);
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
       $data =  Asset::find($id);
       return view('hotel.asset.data',compact('data','id'));

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
       $client = Asset::find($id);
       $data=$request->post();
       $data['value'] = str_replace(",","",$request->value);
      $data['added_by'] = auth()->user()->added_by;
       $client->update($data);


       return redirect(route('asset.index'))->with(['success'=>'Asset Updated Successfully']);
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

       $client = Asset::find($id);

       $client->update(['disabled'=> '1']);;

       return redirect(route('asset.index'))->with(['success'=>'Asset Deleted Successfully']);
   }
   
    
   
}
