<?php

namespace App\Http\Controllers\Api_controllers\Pms\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel\Client;
use App\Models\Restaurant\POS\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use App\Imports\ImportClient ;
use Response;
use App\Models\User;

class ClientController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
            
        $invoices=Client::where('owner_id', $added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;
             
                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','client'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No client found'];
            return response()->json($response,200);
        } 
        
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       } 
    }
    

    public function indexOff(int $id, int $lastId)
    {
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
        
        
        $invoices= Client::where('owner_id', $added_by)->where('id', '>' ,$lastId)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;
                
                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','client'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No client found'];
            return response()->json($response,200);
        } 
        
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       } 
       
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
      $this->validate($request,[
        'name'=>'required',
        
    ]);
    
    $usr = User::find($request->input('id'));
    
    if($usr){
        
         
    $added_by =  $usr->added_by;
    
    
    $data= new Client();
    $data->name=$request->input('name');
    $data->address=$request->input('address');
    $data->phone=$request->input('phone');
    $data->nationality=$request->input('nationality');
    $data->email=$request->input('email');
    
    $data->place_of_birth=$request->input('place_of_birth');
    $data->occupation=$request->input('occupation');
    $data->identity_type=$request->input('identity_type');
    $data->identity_no=$request->input('identity_no');
    $data->dob=$request->input('dob');
    $data->tribe=$request->input('tribe');
    
    $data->user_id=$request->input('id');
    $data->owner_id = $added_by;

    $data->save();

    // $dt = $data->id;

    if(!empty($data)){
        $activity =Activity::create(
            [ 
                'added_by'=> $data->user_id,
                'user_id'=> $data->owner_id,
                'module_id'=> $data->id,
                'module'=> 'Property Client',
                 'activity'=> "Client " .  $data->name. "  Created",
            ]
            );                      
        }

    


    if($data)
    {
       
    
        $response=['success'=>true,'error'=>false, 'message' => 'Client Created successful', 'client' => $data];
        return response()->json($response, 200);
    }
    else
    {
        
        $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Client Successfully'];
        return response()->json($response,200);
    }
    
    }
    else{
        
        $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Client Cause user ID not found on users table Successfully'];
        return response()->json($response,200);
    }
   
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
       return view('hotel.client.client',compact('data','id'));

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
