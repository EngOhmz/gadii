<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy\Client;
use Illuminate\Http\Request;

class ClientController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
       $client = Client::where('user_id',auth()->user()->added_by)->get();  
       return view('pharmacy.client.client',compact('client'));
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
      $data['user_id']=auth()->user()->added_by;
      $client = Client::create($data);

      return redirect(route('pharmacy_client.index'))->with(['success'=>'Client Created Successfully']);
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
       $data =  Client::find($id);
       return view('pharmacy.client.client',compact('data','id'));

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
       $client = Client::find($id);
       $data=$request->post();
       $data['user_id']=auth()->user()->added_by;
       $client->update($data);

       return redirect(route('pharmacy_client.index'))->with(['success'=>'Client Updated Successfully']);
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

       $client = Client::find($id);
       $client->delete();

       return redirect(route('pharmacy_client.index'))->with(['success'=>'Client Deleted Successfully']);
   }
}
