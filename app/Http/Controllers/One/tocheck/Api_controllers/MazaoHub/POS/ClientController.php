<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\POS;

use App\Http\Controllers\Controller;
// use App\Models\Retail\Client;
use App\Models\User;

use App\Models\Client;
use App\Models\POS\Activity;

// use App\Models\Retail\Activity;
use Illuminate\Http\Request;

class ClientController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
   {
       //
       $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
            
               $client = Client::where('owner_id', $added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get(); 
        
               if($client->isNotEmpty()){
        
                foreach($client as $row){
        
                    $data = $row;
        
                    $farmers[] = $data;
         
                }
        
                $response=['success'=>true,'error'=>false,'message'=>'successfully','client'=>$farmers];
                return response()->json($response,200);
            }
            else{
        
                $response=['success'=>false,'error'=>true,'message'=>'No Client found'];
                return response()->json($response,200);
            }
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
       
       
      
   }
   
   
   public function cron_test()
   {
       //
    //   $usr = User::find($id);
       
    //   if(!empty($usr)){
           
           
    //         $added_by = $usr->added_by;
            
               $client = User::find(202); 
        
            //   if(!empty($client)){
                   
                  $clnt = $client->update(['added_by' => 1]);
                  
                //   if($clnt){
                //       $response=['success'=>true,'error'=>false,'message'=>'updated successfully'];
                //         return response()->json($response,200);
                //   }
                //   else{
                //         $response=['success'=>false,'error'=>true,'message'=>'No Client found'];
                //         return response()->json($response,200);
                //   }
        
        
                // $response=['success'=>true,'error'=>false,'message'=>'successfully','client'=>$farmers];
                // return response()->json($response,200);
            // }
            // else{
        
            //     $response=['success'=>false,'error'=>true,'message'=>'No Client found'];
            //     return response()->json($response,200);
            // }
    //   }
    //   else{
    //             $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
    //             return response()->json($response,200);
    //   }
       
       
      
   }

   public function indexOff(int $id, int $lastId)
   {
       //
       $usr = User::find($id);
       
       if(!empty($usr)){
           
            $added_by = $usr->added_by;
                   
               $client = Client::where('owner_id', $added_by)->where('disabled','0')->where('id', '>', $lastId)->orderBy('created_at', 'desc')->get(); 
                
               if($client->isNotEmpty()){
        
                foreach($client as $row){
        
                    $data = $row;
        
                    $farmers[] = $data;
         
                }
        
                $response=['success'=>true,'error'=>false,'message'=>'successfully','client'=>$farmers];
                return response()->json($response,200);
            }
            else{
        
                $response=['success'=>false,'error'=>true,'message'=>'No Client found'];
                return response()->json($response,200);
            }
    
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
       
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
    $data->TIN=$request->input('TIN');
    $data->email=$request->input('email');
    $data->user_id=$request->input('id');
    $data->owner_id = $added_by;

    $data->save();

    // $dt = $data->id;

    if(!empty($data)){
        $activity =Activity::create(
            [ 
                'added_by'=> $data->user_id,
                'module_id'=>$data->id,
                'module'=>'Client',
                'activity'=>"Client " .  $data->name. "  Created",
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
        
        $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Client Cause Shopkeeper ID not found on users table Successfully'];
        return response()->json($response,200);
    }
   
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

       $this->validate($request,[
        'name'=>'required',
       
    ]); 
    
    $data=Client::find($id);
    $data->name=$request->input('name');
    $data->address=$request->input('address');
    $data->phone=$request->input('phone');
    $data->TIN=$request->input('TIN');
    $data->email=$request->input('email');
    $data->user_id=$request->input('id');
    $data->owner_id=$request->input('owner_id');

    $seed =  $data->update();


    if(!empty($data)){
        $activity =Activity::create(
            [ 
                'added_by'=> $data->user_id,
                'module_id'=>$data->id,
                 'module'=>'Client',
                'activity'=>"Client " .  $data->name. "  Updated",
            ]
            );                      
        }

    


    if($seed)
    {
       
    
        $response=['success'=>true,'error'=>false, 'message' => 'Client Updated successful', 'client' => $data];
        return response()->json($response, 200);
    }
    else
    {
        
        $response=['success'=>false,'error'=>true,'message'=>'Failed to Update Client Successfully'];
        return response()->json($response,200);
    }
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
       $data = Client::find($id);

       if(!empty($data)){
                  $activity =Activity::create(
                      [ 
                          'added_by'=>   $data->user_id,
                          'module_id'=>$id,
                           'module'=>'Client',
                          'activity'=>"Client " .  $data->name. "  Deleted",
                      ]
                      );                      
     }

      $crop = $data->delete();

      if($crop)
      {
         
      
          $response=['success'=>true,'error'=>false,'message'=>'Client deleted'];
          return response()->json($response,200);
      }
      else
      {
          
          $response=['success'=>false,'error'=>true,'message'=>'Failed to delete Client'];
          return response()->json($response,200);
      }
   }
}
