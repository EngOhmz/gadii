<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\Farming;

use App\Http\Controllers\Controller;
use App\Models\Crops_type;
use Illuminate\Http\Request;

class CropTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $crops=Crops_type::all();

        // $user = Farmer::where('user_id', $id)->where('id', '>' ,$lastId)->get();


     //print_r($land);
        // return view('agrihub.manage-land')->with('farmer',$land)->with('owner',$farmer)->with('farmer2',$land)->with('farmer3',$land)->with('owneredit',$farmer);
   
        if($crops->isNotEmpty()){

            foreach($crops as $row){

                $data = $row;
    
                $farmers[] = $data; 
            }

            $response=['success'=>true,'error'=>false,'message'=>'Crops Found successful', 'crop_type' => $farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'Crops Not Found'];
            return response()->json($response,200);
        }
    
    }

    public function indexOff(int $lastId)
    {
        //

        $crops=Crops_type::where('id', '>' ,$lastId)->get();

        // $user = Farmer::where('user_id', $id)->where('id', '>' ,$lastId)->get();


     //print_r($land);
        // return view('agrihub.manage-land')->with('farmer',$land)->with('owner',$farmer)->with('farmer2',$land)->with('farmer3',$land)->with('owneredit',$farmer);
   
        if($crops->isNotEmpty()){

            foreach($crops as $row){

                $data = $row;
    
                $farmers[] = $data; 
            }

            $response=['success'=>true,'error'=>false,'message'=>'Crops Found successful', 'crop_type' => $farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'Crops Not Found'];
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
            'crop_name'=>'required',
            'storage_type'=>'required',
            'crop_category'=>'required',
            'id' => 'required'
        ]); 

        $data= new Crops_type();
        $data->crop_name=$request->input('crop_name');
        $data->storage_type=$request->input('storage_type');
        $data->crop_category=$request->input('crop_category');
        $data['added_by']= $request->input('id');
        $data->save();
        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'New Crop Type registered', 'crop_type' => $data];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new crop type'];
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
        $data =  Crops_type::find($id);
        return view('farming.crop_type',compact('data','id'));
 
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
            'crop_name'=>'required',
            'storage_type'=>'required',
            'crop_category'=>'required',
        ]); 

        $data = Crops_type::find($id);

        $data->crop_name=$request->input('crop_name');
        $data->storage_type=$request->input('storage_type');
        $data->crop_category=$request->input('crop_category');
        $crop = $data->update();
        if($crop)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'Crop Type updated','crop_type' => $crop];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to updated new crop type'];
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
 
        $data = Crops_type::find($id);
        $crop = $data->delete();
 
        if($crop)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'Crop Type delete'];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to delete crop type'];
            return response()->json($response,200);
        }
    }
}
