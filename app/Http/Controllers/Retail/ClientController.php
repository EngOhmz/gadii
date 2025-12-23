<?php

namespace App\Http\Controllers\Retail;

use App\Http\Controllers\Controller;
use App\Models\Retail\Client;
use App\Models\Retail\Activity;
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
       $client = Client::where('owner_id',auth()->user()->added_by)->orderBy('created_at', 'desc')->get();  
       return view('retail.client.client',compact('client'));
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
      $data['user_id']=auth()->user()->id;
      $data['owner_id'] = auth()->user()->added_by;
      $client = Client::create($data);

     if(!empty($client)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$client->id,
                             'module'=>'Client',
                            'activity'=>"Client " .  $client->name. "  Created",
                        ]
                        );                      
       }

      return redirect(route('retail_client.index'))->with(['success'=>'Client Created Successfully']);
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
       return view('retail.client.client',compact('data','id'));

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
       $data['user_id']=auth()->user()->id;
      $data['owner_id'] = auth()->user()->added_by;
       $client->update($data);

          if(!empty($client)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Client',
                            'activity'=>"Client " .  $client->name. "  Updated",
                        ]
                        );                      
       }

       return redirect(route('retail_client.index'))->with(['success'=>'Client Updated Successfully']);
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
       if(!empty($client)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Client',
                            'activity'=>"Client " .  $client->name. "  Deleted",
                        ]
                        );                      
       }
       $client->delete();

       return redirect(route('retail_client.index'))->with(['success'=>'Client Deleted Successfully']);
   }
}
