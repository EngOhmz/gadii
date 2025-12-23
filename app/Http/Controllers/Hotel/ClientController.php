<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel\Client;
use App\Models\Restaurant\POS\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use App\Imports\ImportClient ;
use App\Models\Nationality ;
use Response;

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
       $client = Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();   
       $nation=Nationality::all();
       return view('hotel.client.client',compact('client','nation'));
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
      $data['user_id'] = auth()->user()->id;
      $data['owner_id'] = auth()->user()->added_by;
      $client = Client::create($data);

if(!empty($client)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                              'user_id'=>auth()->user()->id,
                            'module_id'=>$client->id,
                             'module'=>'Property Client',
                            'activity'=>"Client " .  $client->name. "  Created",
                        ]
                        );                      
       }
      return redirect(route('visitor.index'))->with(['success'=>'Client Created Successfully']);
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
        $nation=Nationality::all();
       return view('hotel.client.client',compact('data','id','nation'));

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
       $data['user_id'] = auth()->user()->id;
      $data['owner_id'] = auth()->user()->added_by;
       $client->update($data);


          if(!empty($client)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                               'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Property Client',
                            'activity'=>"Client " .  $client->name. "  Updated",
                        ]
                        );                      
       }
       return redirect(route('visitor.index'))->with(['success'=>'Client Updated Successfully']);
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
                             'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Property Client',
                            'activity'=>"Client " .  $client->name. "  Deleted",
                        ]
                        );                      
       }
       $client->update(['disabled'=> '1']);;

       return redirect(route('visitor.index'))->with(['success'=>'Client Deleted Successfully']);
   }
   
     public function import(Request $request){
      
        
        $data = Excel::import(new ImportClient, $request->file('file')->store('files'));
        
        return redirect()->back()->with('success', 'File Imported Successfully');
    }
    
     public function sample(Request $request){

       $filepath = public_path('client_sample.xlsx');
       return Response::download($filepath);
    }
   
}
