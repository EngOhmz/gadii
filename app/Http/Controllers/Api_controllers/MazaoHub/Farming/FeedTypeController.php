<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\Farming;


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
        
        $seeds =FeedType::all();


    //    $crop=Crops_type::all();

       if($seeds->isNotEmpty()){

        foreach($seeds as $row){

            $data['crop_name'] = $row->crop->crop_name;

            $data['crop_id'] = $row->crop_name;

            // $data['lastname'] = $row->lastname;
            $data['feed_name'] = $row->feed_name;

            $data['characteristics'] = $row->characteristics;

            $data['id'] = $row->id;

            $data['added_by'] = $row->added_by;



            // $data['lastname'] = $row->lastname;
            $farmers[] = $data; 
        }

        $response=['success'=>true,'error'=>false,'message'=>'Seed Type Found successful', 'seed_type' => $farmers];
        return response()->json($response,200);

        
  
      }
      else{

          $response=['success'=>false,'error'=>true,'message'=>'Seed Type Not Found'];
          return response()->json($response,200);
      }

    }

    public function indexOff(int $lastId)
    {
        //
        
        // $seeds =FeedType::all();
        $seeds=FeedType::where('id', '>' ,$lastId)->get();



    //    $crop=Crops_type::all();

       if($seeds->isNotEmpty()){

        foreach($seeds as $row){

            $data['crop_name'] = $row->crop->crop_name;

            $data['crop_id'] = $row->crop_name;

            // $data['lastname'] = $row->lastname;
            $data['feed_name'] = $row->feed_name;

            $data['characteristics'] = $row->characteristics;

            $data['id'] = $row->id;

            $data['added_by'] = $row->added_by;



            // $data['lastname'] = $row->lastname;
            $farmers[] = $data; 
        }

        $response=['success'=>true,'error'=>false,'message'=>'Seed Type Found successful', 'seed_type' => $farmers];
        return response()->json($response,200);

        
  
      }
      else{

          $response=['success'=>false,'error'=>true,'message'=>'Seed Type Not Found'];
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
            'feed_name'=>'required',
            'characteristics'=>'required',
            'id' => 'required'
        ]); 

        $data= new FeedType();
        $data->feed_name=$request->input('feed_name');
        $data->crop_name=$request->input('crop_name');
        $data->characteristics=$request->input('characteristics');
        $data['added_by']= $request->input('id');
        $data->save();
        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'New Crop Type registered', 'seed_type' => $data];
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
        

        $this->validate($request,[
            'crop_name'=>'required',
            'feed_name'=>'required',
            'characteristics'=>'required',
        ]); 

        $data = FeedType::find($id);
        $data->feed_name=$request->input('feed_name');
        $data->crop_name=$request->input('crop_name');
        $data->characteristics=$request->input('characteristics');
        $seed =  $data->update();
        if($seed)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'Seed Type Updated registered', 'seed_type' => $data];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Updated Seed type'];
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
 
        $data = FeedType::find($id);
        $crop = $data->delete();
 
        if($crop)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'Seed Type delete'];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to delete seed type'];
            return response()->json($response,200);
        }
    }
}
