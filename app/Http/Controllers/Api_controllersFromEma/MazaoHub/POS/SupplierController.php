<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\POS;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Retail\Supplier;
use App\Models\Retail\Activity;
//use App\Models\FarmLand;

class SupplierController extends Controller
{
    
    public function index(int $id)
    {
        
        $supply = Supplier::where('user_id', $id)->get();

        if($supply->isNotEmpty()){

            foreach($supply as $row){

                $data = $row;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','supplier'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Supplier found'];
            return response()->json($response,200);
        }

    }

    public function indexOff(int $id, int $lastId)
    {
        
        $supply = Supplier::where('user_id', $id)->where('id', '>', $lastId)->get();

        if($supply->isNotEmpty()){

            foreach($supply as $row){

                $data = $row;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','supplier'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Supplier found'];
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
        // $data= new Supply();
        $this->validate($request,[
            'name'=>'required',
            
        ]);
        
        
        $data= new Supplier();
        $data->name=$request->input('name');
        $data->address=$request->input('address');
        $data->phone=$request->input('phone');
        $data->TIN=$request->input('TIN');
        $data->email=$request->input('email');
        $data->user_id=$request->input('id');

        $data->save();

        // $dt = $data->id;

        if(!empty($data)){
            $activity =Activity::create(
                [ 
                    'added_by'=> $data->user_id,
                    'module_id'=>$data->id,
                     'module'=>'Supplier',
                    'activity'=>"Supplier " .  $data->name. "  Created",
                ]
                );                      
            }

        


        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Supplier Created successful', 'supplier' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Supplier Successfully'];
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
        
        $this->validate($request,[
            'name'=>'required',
           
        ]); 
        
        $data=Supplier::find($id);
        $data->name=$request->input('name');
        $data->address=$request->input('address');
        $data->phone=$request->input('phone');
        $data->TIN=$request->input('TIN');
        $data->email=$request->input('email');
        $data->user_id=$request->input('id');

        $seed =  $data->update();


        if(!empty($data)){
            $activity =Activity::create(
                [ 
                    'added_by'=> $data->user_id,
                    'module_id'=>$data->id,
                     'module'=>'Supplier',
                    'activity'=>"Supplier " .  $data->name. "  Updated",
                ]
                );                      
            }

        


        if($seed)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Supplier Updated successful', 'supplier' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Update Supplier Successfully'];
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
        $data = Supplier::find($id);

         if(!empty($data)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>   $data->user_id,
                            'module_id'=>$id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $data->name. "  Deleted",
                        ]
                        );                      
       }

        $crop = $data->delete();

        if($crop)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'Supplier deleted'];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to delete Supplier'];
            return response()->json($response,200);
        }
    }
}
