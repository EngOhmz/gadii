<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\Farming;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\farming\Seasson;
use App\Models\farming\Preparation_cost;
use App\Models\farming\PreparationDetails;
use App\Models\farming\Sowing;
use App\Models\Farmer;
use App\Models\Land_properties;
use App\Models\Crops_type;
use App\Models\FarmProgram;
use App\Models\farming\Fertilizer; 
use App\Models\farming\Weeding; 
use App\Models\farming\PreHarvest; 
use App\Models\farming\PostHarvest; 
use App\Models\farming\Pestiside;
use App\Models\Farming_process;
use App\Models\FeedType;
use App\Models\LimeBase;
use App\Models\PesticideType;
use App\Models\Storage;
use App\Models\Warehouse;
use App\Models\Warehouse2;
use Illuminate\Support\Facades\Date;

class SeassonController extends Controller
{
    

    public function index(int $id, String $date)
    {
        //
    // $farmer = Farmer::all();
    // $user_id = $id;
    // $crop=Crops_type::all();

    // $startDate = Seasson::where('farm_id', $id)->value('start_date');
    $seassonId = Seasson::where('farm_id', $id)->get();

    


    // $gap = Farming_process::all();
    // $seasson = Seasson::whereBetween($date , [$start_date, $harvest_date]);


    if ($seassonId->isNotEmpty()) {

        $seasson = Seasson::where('farm_id', $id)->whereDate('start_date', '<=', $date)
                    ->whereDate('harvest_date', '>=', $date)->get();

        if($seasson->isNotEmpty()){

            foreach($seasson as $row){

                $data = $row;

                $crop = Crops_type::where('id', $row->crop_name)->first();

                $data['crop_id'] = $row->crop_name;

                $data['crop_name'] = $crop->crop_name;

               
               
    
                $seassonDetails[] = $data;    
            }
    

            $response=['success'=>true,'error'=>false,'message'=>'Seasson  Founds successful', 'seassonId' => $seassonDetails];
            return response()->json($response, 200);
        }  
        
        else{
            $response=['success'=>false,'error'=>true, 'message' => 'Seasson Between Date Not Founds successful'];
            return response()->json($response, 200);
        }

        
    } 
    else {
        $response=['success'=>false,'error'=>true, 'message' => 'Farm Id Not Found'];
        return response()->json($response, 200);
    }

        // return view('farming_process.manage_seasson',compact('seasson','farmer','crop'));
    }

     
    
    public function indexOff(int $id, int $lastId, String $date)
    {
        //
    // $farmer = Farmer::all();
    // $user_id = $id;
    // $crop=Crops_type::all();

    // $startDate = Seasson::where('farm_id', $id)->value('start_date');
    $seassonId = Seasson::where('farm_id', $id)->where('id', '>' ,$lastId)->get();

    


    // $gap = Farming_process::all();
    // $seasson = Seasson::whereBetween($date , [$start_date, $harvest_date]);


    if ($seassonId->isNotEmpty()) {

        $seasson = Seasson::where('farm_id', $id)->whereDate('start_date', '<=', $date)
                    ->whereDate('harvest_date', '>=', $date)->get();

        if($seasson->isNotEmpty()){

            foreach($seasson as $row){

                $data = $row;

                $crop = Crops_type::where('id', $row->crop_name)->first();

                $data['crop_id'] = $row->crop_name;

                $data['crop_name'] = $crop->crop_name;

               
               
    
                $seassonDetails[] = $data;    
            }
    

            $response=['success'=>true,'error'=>false,'message'=>'Seasson  Founds successful', 'seassonId' => $seassonDetails];
            return response()->json($response, 200);
        }  
        
        else{
            $response=['success'=>false,'error'=>true, 'message' => 'Seasson Between Date Not Founds successful'];
            return response()->json($response, 200);
        }

        
    } 
    else {
        $response=['success'=>false,'error'=>true, 'message' => 'Farm Id Not Found'];
        return response()->json($response, 200);
    }

        // return view('farming_process.manage_seasson',compact('seasson','farmer','crop'));
    }

    public function land_preparation(int $id, int $landId){

    $preparationDetails = PreparationDetails::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_preparation_details.seasson_id')
                                            ->where('tbl_preparation_details.seasson_id',$id)
                                            ->where('tbl_seassons.farm_id', $landId)
                                            ->select('*','tbl_preparation_details.id as id')
                                            ->get();
    
    if($preparationDetails->isNotEmpty()){

        foreach($preparationDetails as $row){

            $data = $row;

            $data['seasson_id'] = $row->seasson_id;
            $data['land_id'] =  $row->farm_id;

            $data['picture'] = url('season_images/'.$row->picture);
             $limeId= $row->lime_control;
             $data['lime'] = $limeId;
             $data['lime_base'] = LimeBase::where('id', $limeId)->value('name');
            // $data['id'] = $row->id;

            $preparationDetails2[] = $data;    
        }

        $response=['success'=>true,'error'=>false,'message'=>'Land Preparations  Founds successful', 'land_preparation' => $preparationDetails2];
        return response()->json($response, 200);
        }  
    
    else{
        $response=['success'=>false,'error'=>true, 'message' => 'Land Preparations Not Founds'];
        return response()->json($response, 200);
    }


    }

    public function land_preparationOff(int $id, int $landId, int $lastId){

        $preparationDetails = PreparationDetails::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_preparation_details.seasson_id')
                                                ->where('tbl_preparation_details.seasson_id',$id)
                                                ->where('tbl_seassons.farm_id', $landId)
                                                ->where('tbl_preparation_details.id', '>' ,$lastId)
                                                ->select('*','tbl_preparation_details.id as id')
                                                ->get();
        
        if($preparationDetails->isNotEmpty()){
    
            foreach($preparationDetails as $row){
    
                $data = $row;

                $data['seasson_id'] = $row->seasson_id;
                $data['land_id'] =  $row->farm_id;

                $data['picture'] = url('season_images/'.$row->picture);
                 $limeId= $row->lime_control;
                 $data['lime'] = $limeId;
                 $data['lime_base'] = LimeBase::where('id', $limeId)->value('name');
                // $data['id'] = $row->id;
    
                $preparationDetails2[] = $data;    
            }
    
            $response=['success'=>true,'error'=>false,'message'=>'Land Preparations  Founds successful', 'land_preparation' => $preparationDetails2];
            return response()->json($response, 200);
            }  
        
        else{
            $response=['success'=>false,'error'=>true, 'message' => 'Land Preparations Not Founds'];
            return response()->json($response, 200);
        }
    
    
        }

    public function land_preparation_store(Request $request){

        // $preparationDetails = PreparationDetails::where('seasson_id',$id)->get();
  
        $this->validate($request,[
            'preparation_type'=>'required',
            'soil_salt'=>'required',
            'acid_level'=>'required',
            'moisture_level'=>'required',
            'lime_control'=>'required',
            'cost'=>'required',
            'acre'=>'required',
            'total_cost'=>'required',
            'seasson_id'=>'required',
            'id' =>'required'


            
        ]); 

        if ($request->hasFile('picture')) {
            $photo=$request->file('picture');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $logo=$fileName;
            $photo->move('season_images', $fileName );
             $picture2 = $logo;

        }
        else{
        $picture2 = "";

        }

        $data= new PreparationDetails();
        $data->preparation_type=$request->input('preparation_type');
        $data->soil_salt=$request->input('soil_salt');
        $data->acid_level=$request->input('acid_level');
        $data->moisture_level=$request->input('moisture_level');
        $data->lime_control=$request->input('lime_control');
        $data->cost=$request->input('cost');
        $data->acre=$request->input('acre');
        $data->total_cost=$request->input('total_cost');
        $data->seasson_id=$request->input('seasson_id');

        $data->picture=$picture2;


        $data['user_id'] = $request->input('id');;

        $data->save();

        $data['picture'] = url('season_images/'.$picture2);

        if($data)
        {
        
            $response=['success'=>true,'error'=>false, 'message' => 'Land Preparations  Created successful', 'land_preparation' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Land Preparations Seccessfully'];
            return response()->json($response,200);
        }
    
    
        }

        public function farm_program(int $id, int $landId){

            $farmprogram = FarmProgram::join('tbl_seassons', 'tbl_seassons.id', '=', 'farm_program.season_id')
                            ->where('farm_program.season_id',$id)
                            ->where('tbl_seassons.farm_id', $landId)
                            ->select('*','farm_program.id as id')
                            ->get();
            
            if($farmprogram->isNotEmpty()){
        
                foreach($farmprogram as $row){
        
                    $data = $row;
                    $data['seasson_id'] = $row->season_id;
                    $data['land_id'] =  $row->farm_id;
                    $data['picture'] = url('season_images/'.$row->picture);

                     $gapId= $row->gap;
                     $data['gap_name'] = Farming_process::where('id', $gapId)->value('process_name');
                    // $data['id'] = $row->id;
        
                    $farm_program[] = $data;    
                }
        
                $response=['success'=>true,'error'=>false,'message'=>'Farm Program  Founds successful', 'farm_program' => $farm_program];
                return response()->json($response, 200);
               
            }  
            else{
                $response=['success' => false, 'error' => true, 'message'=>'Farm Program Not Founds'];
                return response()->json($response, 200);
            }
        
        
            }

            public function farm_programOff(int $id, int $landId, int $lastId){

                $farmprogram = FarmProgram::join('tbl_seassons', 'tbl_seassons.id', '=', 'farm_program.season_id')
                                ->where('farm_program.season_id',$id)
                                ->where('tbl_seassons.farm_id', $landId)
                                ->where('farm_program.id', '>' ,$lastId)
                                ->select('*','farm_program.id as id')
                                ->get();
                
                if($farmprogram->isNotEmpty()){
            
                    foreach($farmprogram as $row){
            
                        $data = $row;

                        $data['seasson_id'] = $row->season_id;
                        $data['land_id'] =  $row->farm_id;

                        $data['picture'] = url('season_images/'.$row->picture);
    
                         $gapId= $row->gap;
                         $data['gap_name'] = Farming_process::where('id', $gapId)->value('process_name');
                        // $data['id'] = $row->id;
            
                        $farm_program[] = $data;    
                    }
            
                    $response=['success'=>true,'error'=>false,'message'=>'Farm Program  Founds successful', 'farm_program' => $farm_program];
                    return response()->json($response, 200);
                   
                }  
                else{
                    $response=['success' => false, 'error' => true, 'message'=>'Farm Program Not Founds'];
                    return response()->json($response, 200);
                }
            
            
                }

            public function farm_program_store(Request $request){

                // $preparationDetails = PreparationDetails::where('seasson_id',$id)->get();
          
                $this->validate($request,[
                    'name'=>'required',
                    'gap'=>'required',
                    'distributor'=>'required',
                    'cost'=>'required',
                    'acre'=>'required',
                    'total_cost'=>'required',
                    'seasson_id'=>'required',
                    'id' =>'required'
        
        
                    
                ]); 

                if ($request->hasFile('picture')) {
                    $photo=$request->file('picture');
                    $fileType=$photo->getClientOriginalExtension();
                    $fileName=rand(1,1000).date('dmyhis').".".$fileType;
                    $logo=$fileName;
                    $photo->move('season_images', $fileName );
                     $picture2 = $logo;
        
                }
                else{
                    $picture2 = "";
                }
        
                $data= new FarmProgram();
                $data->name=$request->input('name');
                $data->gap=$request->input('gap');
                $data->distributor=$request->input('distributor');
                $data->cost=$request->input('cost');
                $data->acre=$request->input('acre');
                $data->total_cost=$request->input('total_cost');
                $data->season_id=$request->input('seasson_id');
                $data->picture=$picture2;

                $data['added_by'] = $request->input('id');;
        
                $data->save();

                $data['picture'] = url('season_images/'.$picture2);

                if($data)
                {
                   
                

                    $response=['success'=>true,'error'=>false, 'message' => 'Farm Program  Created successful', 'farm_program' => $data];
                    return response()->json($response, 200);
                }
                else
                {
                    
                    $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Farm Program Seccessfully'];
                    return response()->json($response,200);
                }
            
            
                }

                    public function sowing(int $id, int $landId){

                    $sowing = Sowing::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_sowings.seasson_id')
                                        ->where('tbl_sowings.seasson_id',$id)
                                        ->where('tbl_seassons.farm_id', $landId)
                                        ->select('*','tbl_sowings.id as id')
                                        ->get();
                    
                    if($sowing->isNotEmpty()){
                
                        foreach($sowing as $row){
                
                            $data = $row;

                            $data['seasson_id'] = $row->seasson_id;
                            $data['land_id'] =  $row->farm_id;

                            $data['picture'] = url('season_images/'.$row->picture);

                             $seedId= $row->seed_type;
                             $cropId= $row->crop_type;

                             $data['crop_name'] = Crops_type::where('id', $cropId)->value('crop_name');
                             $data['seed_name'] = FeedType::where('id', $seedId)->value('feed_name');

                             $data['quantity'] = $row->qheck;
                             $data['acre'] = $row->nh;
                            //  $data['seed_name'] = $row->seed_type;;
                             $data['created_at'] = $row->created_at;


                            // $data['id'] = $row->id;
                
                            $farm_program[] = $data;    
                        }
                
                        $response=['success'=>true,'error'=>false,'message'=>'sowing  Founds successful', 'sowing' => $farm_program];
                        return response()->json($response, 200);
                       
                    }  
                    else{
                        $response=['success' => false, 'error' => true, 'message'=>'sowing Not Founds'];
                        return response()->json($response, 200);
                    }
                
                
                    }

                    public function sowingOff(int $id, int $landId, int $lastId){

                        $sowing = Sowing::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_sowings.seasson_id')
                                            ->where('tbl_sowings.seasson_id',$id)
                                            ->where('tbl_seassons.farm_id', $landId)
                                            ->where('farm_program.id', '>' ,$lastId)
                                            ->select('*','tbl_sowings.id as id')
                                            ->get();
                        
                        if($sowing->isNotEmpty()){
                    
                            foreach($sowing as $row){
                    
                                $data = $row;

                                $data['seasson_id'] = $row->seasson_id;
                                $data['land_id'] =  $row->farm_id;

                                $data['picture'] = url('season_images/'.$row->picture);
    
                                 $seedId= $row->seed_type;
                                 $cropId= $row->crop_type;
    
                                 $data['crop_name'] = Crops_type::where('id', $cropId)->value('crop_name');
                                 $data['seed_name'] = FeedType::where('id', $seedId)->value('feed_name');
    
                                 $data['quantity'] = $row->qheck;
                                 $data['acre'] = $row->nh;
                                //  $data['seed_name'] = $row->seed_type;;
                                 $data['created_at'] = $row->created_at;
    
    
                                // $data['id'] = $row->id;
                    
                                $farm_program[] = $data;    
                            }
                    
                            $response=['success'=>true,'error'=>false,'message'=>'sowing  Founds successful', 'sowing' => $farm_program];
                            return response()->json($response, 200);
                           
                        }  
                        else{
                            $response=['success' => false, 'error' => true, 'message'=>'sowing Not Founds'];
                            return response()->json($response, 200);
                        }
                    
                    
                        }
        
                    public function sowing_store(Request $request){
        
                        // $preparationDetails = PreparationDetails::where('seasson_id',$id)->get();
                  
                        $this->validate($request,[
                            'quantity'=>'required',
                            'acre'=>'required',
                            'qn'=>'required',
                            'seed_type'=>'required',
                            'harvest_date'=>'required',
                            'cost'=>'required',
                            'crop_type'=>'required',
                            'total_cost'=>'required',
                            'seasson_id'=>'required',
                            'id' =>'required'
                
                
                            
                        ]); 

                        if ($request->hasFile('picture')) {
                            $photo=$request->file('picture');
                            $fileType=$photo->getClientOriginalExtension();
                            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
                            $logo=$fileName;
                            $photo->move('season_images', $fileName );
                             $picture2 = $logo;
                
                        }
                        else{
                            $picture2 = "";
                        }
                
                        $data= new Sowing();
                        $data->qheck=$request->input('quantity');
                        $data->nh=$request->input('acre');
                        $data->qn=$request->input('qn');
                        $data->seed_type=$request->input('seed_type');
                        $data->harvest_date=$request->input('harvest_date');
                        $data->cost=$request->input('cost');
                        $data->crop_type=$request->input('crop_type');
                        $data->total_cost=$request->input('total_cost');
                        $data->seasson_id=$request->input('seasson_id');
                        $data->picture=$picture2;

                        $data['user_id'] = $request->input('id');;
                
                        $data->save();

                        // $dt =$data->id;



                        $data['picture'] = url('season_images/'.$picture2);

                        if($data)
                        {
                           

                        
                            $response=['success'=>true,'error'=>false, 'message' => 'Sowing  Created successful', 'sowing' => $data];
                            return response()->json($response, 200);
                        }
                        else
                        {
                            
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Sowing Seccessfully'];
                            return response()->json($response,200);
                        }
                    
                    
                        }
    
                        public function fertilizer(int $id, int $landId){

                            $fertilizer = Fertilizer::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_fertilizers.seasson_id')
                                                        ->where('tbl_fertilizers.seasson_id',$id)
                                                        ->where('tbl_seassons.farm_id', $landId)
                                                        ->select('*','tbl_fertilizers.id as id')
                                                        ->get();
                            
                            if($fertilizer->isNotEmpty()){
                        
                                foreach($fertilizer as $row){
                        
                                    $data = $row;

                                    $data['seasson_id'] = $row->seasson_id;
                                    $data['land_id'] =  $row->farm_id;

                                    $data['picture'] = url('season_images/'.$row->picture);

                                     $gapId= $row->farming_process;

                                     $data['gap'] = $gapId;
                                     $data['gap_name'] = Farming_process::where('id', $gapId)->value('process_name');
                                    // $data['id'] = $row->id;
                        
                                    $farm_program[] = $data;    
                                }
                        
                                $response=['success'=>true,'error'=>false,'message'=>'fertilizer  Founds successful', 'fertilizer' => $farm_program];
                                return response()->json($response, 200);
                               
                            }  
                            else{
                                $response=['success' => false, 'error' => true, 'message'=>'fertilizer Not Founds'];
                                return response()->json($response, 200);
                            }
                        
                        
                            }

                            public function fertilizerOff(int $id, int $landId, int $lastId){

                                $fertilizer = Fertilizer::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_fertilizers.seasson_id')
                                                            ->where('tbl_fertilizers.seasson_id',$id)
                                                            ->where('tbl_seassons.farm_id', $landId)
                                                            ->where('tbl_fertilizers.id', '>' ,$lastId)
                                                            ->select('*','tbl_fertilizers.id as id')
                                                            ->get();
                                
                                if($fertilizer->isNotEmpty()){
                            
                                    foreach($fertilizer as $row){
                            
                                        $data = $row;

                                        $data['seasson_id'] = $row->seasson_id;
                                        $data['land_id'] =  $row->farm_id;


                                        $data['picture'] = url('season_images/'.$row->picture);
    
                                         $gapId= $row->farming_process;
                                         $data['gap_name'] = Farming_process::where('id', $gapId)->value('process_name');
                                          $data['gap'] = $gapId;
                                         
                                        // $data['id'] = $row->id;
                            
                                        $farm_program[] = $data;    
                                    }
                            
                                    $response=['success'=>true,'error'=>false,'message'=>'fertilizer  Founds successful', 'fertilizer' => $farm_program];
                                    return response()->json($response, 200);
                                   
                                }  
                                else{
                                    $response=['success' => false, 'error' => true, 'message'=>'fertilizer Not Founds'];
                                    return response()->json($response, 200);
                                }
                            
                            
                                }
                
                            public function fertilizer_store(Request $request){
                
                                // $preparationDetails = PreparationDetails::where('seasson_id',$id)->get();
                          
                                $this->validate($request,[
                                    'program'=>'required',
                                    'package'=>'required',
                                    'farming_process'=>'required',
                                    'fertilizer_amount'=>'required',
                                    'total_amount'=>'required',
                                    'fertilizer_cost'=>'required',
                                    'fertilizer_price'=>'required',
                                    'total_cost'=>'required',
                                    'no_hector'=>'required',
                                    'seasson_id'=>'required',
                                    'id' =>'required'
                        
                        
                                    
                                ]); 

                                if ($request->hasFile('picture')) {
                                    $photo=$request->file('picture');
                                    $fileType=$photo->getClientOriginalExtension();
                                    $fileName=rand(1,1000).date('dmyhis').".".$fileType;
                                    $logo=$fileName;
                                    $photo->move('season_images', $fileName );
                                     $picture2 = $logo;
                        
                                }
                                else{
                                    $picture2 = "";
                                }
                        
                                $data= new Fertilizer();
                                $data->program=$request->input('program');
                                $data->package=$request->input('package');
                                $data->farming_process=$request->input('farming_process');
                                $data->fertilizer_amount=$request->input('fertilizer_amount');
                                $data->total_amount=$request->input('total_amount');
                                $data->fertilizer_cost=$request->input('fertilizer_cost');
                                $data->fertilizer_price=$request->input('fertilizer_price');
                                $data->no_hector=$request->input('no_hector');
                                $data->total_cost=$request->input('total_cost');
                                $data->seasson_id=$request->input('seasson_id');
                                $data->picture=$picture2;

                                $data['user_id'] = $request->input('id');;
                        
                                $data->save();

                                $data['picture'] = url('season_images/'.$picture2);

                                if($data)
                                {
                                   
                                
                                    $response=['success'=>true,'error'=>false, 'message' => 'Fertilizer  Created successful', 'fertilizer' => $data];
                                    return response()->json($response, 200);
                                }
                                else
                                {
                                    
                                    $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Fertilizer Seccessfully'];
                                    return response()->json($response,200);
                                }
                            
                            
                                }
                                
                                public function weeding(int $id, int $landId){

                                    $weeding = Weeding::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_weedings.seasson_id')
                                                        ->where('tbl_weedings.seasson_id',$id)
                                                        ->where('tbl_seassons.farm_id', $landId)
                                                        ->select('*','tbl_weedings.id as id')
                                                        ->get();
                                    
                                    if($weeding->isNotEmpty()){
                                
                                        foreach($weeding as $row){
                                
                                            $data = $row;

                                            $data['seasson_id'] = $row->seasson_id;
                                            $data['land_id'] =  $row->farm_id;


                                            $data['picture'] = url('season_images/'.$row->picture);

                                             $gapId= $row->process;
                                             $data['gap'] = $gapId;
                                             $data['gap_name'] = Farming_process::where('id', $gapId)->value('process_name');
                                            // $data['id'] = $row->id;
                                
                                            $farm_program[] = $data;    
                                        }
                                
                                        $response=['success'=>true,'error'=>false,'message'=>'weeding  Founds successful', 'weeding' => $farm_program];
                                        return response()->json($response, 200);
                                       
                                    }  
                                    else{
                                        $response=['success' => false, 'error' => true, 'message'=>'weeding Not Founds'];
                                        return response()->json($response, 200);
                                    }
                                
                                
                                    }

                                    public function weedingOff(int $id, int $landId, int $lastId){

                                        $weeding = Weeding::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_weedings.seasson_id')
                                                            ->where('tbl_weedings.seasson_id',$id)
                                                            ->where('tbl_seassons.farm_id', $landId)
                                                            ->where('tbl_weedings.id', '>' ,$lastId)
                                                            ->select('*','tbl_weedings.id as id')
                                                            ->get();
                                        
                                        if($weeding->isNotEmpty()){
                                    
                                            foreach($weeding as $row){
                                    
                                                $data = $row;

                                                $data['seasson_id'] = $row->seasson_id;
                                                $data['land_id'] =  $row->farm_id;

                                                $data['picture'] = url('season_images/'.$row->picture);
    
                                                 $gapId= $row->process;
                                                 $data['gap'] = $gapId;
                                                 $data['gap_name'] = Farming_process::where('id', $gapId)->value('process_name');
                                                // $data['id'] = $row->id;
                                    
                                                $farm_program[] = $data;    
                                            }
                                    
                                            $response=['success'=>true,'error'=>false,'message'=>'weeding  Founds successful', 'weeding' => $farm_program];
                                            return response()->json($response, 200);
                                           
                                        }  
                                        else{
                                            $response=['success' => false, 'error' => true, 'message'=>'weeding Not Founds'];
                                            return response()->json($response, 200);
                                        }
                                    
                                    
                                        }
                        
                                    public function weeding_store(Request $request){
                        
                                        // $preparationDetails = PreparationDetails::where('seasson_id',$id)->get();
                                  
                                        $this->validate($request,[
                                            'gap'=>'required',
                                            'method'=>'required',
                                            'name'=>'required',
                                            'effect'=>'required',
                                            'chemical_status'=>'required',
                                            'acre'=>'required',
                                            'total_cost'=>'required',
                                            'seasson_id'=>'required',
                                            'id' =>'required'
                                
                                
                                            
                                        ]); 

                                        if ($request->hasFile('picture')) {
                                            $photo=$request->file('picture');
                                            $fileType=$photo->getClientOriginalExtension();
                                            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
                                            $logo=$fileName;
                                            $photo->move('season_images', $fileName );
                                             $picture2 = $logo;
                                
                                        }
                                        else{
                                            $picture2 = "";
                                        }
                                
                                        $data= new Weeding();
                                        $data->process=$request->input('gap');
                                        $data->method=$request->input('method');
                                        $data->name=$request->input('name');
                                        $data->effect=$request->input('effect');
                                        $data->chemical_status=$request->input('chemical_status');
                                        $data->weed_cost=$request->input('weed_cost');
                                        $data->acre=$request->input('acre');
                                        $data->cost=$request->input('cost');
                                        $data->chemical=$request->input('chemical');
                                        $data->total_cost=$request->input('total_cost');
                                        $data->seasson_id=$request->input('seasson_id');
                                        $data->picture=$picture2;

                                        $data['added_by'] = $request->input('id');;
                                
                                        $data->save();

                                        $data['picture'] = url('season_images/'.$picture2);

                                        if($data)
                                        {

                                           
                                        
                                            $response=['success'=>true,'error'=>false, 'message' => 'Weeding  Created successful', 'weeding' => $data];
                                            return response()->json($response, 200);
                                        }
                                        else
                                        {
                                            
                                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Weeding Successfully'];
                                            return response()->json($response,200);
                                        }
                                    
                                    
                                        }
                                        
                                    public function pesticide(int $id, int $landId){

                                            $weeding = Pestiside::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_pestisides.seasson_id')
                                                                    ->where('tbl_pestisides.seasson_id',$id)
                                                                    ->where('tbl_seassons.farm_id', $landId)
                                                                    ->select('*','tbl_pestisides.id as id')
                                                                    ->get();
                                            
                                            if($weeding->isNotEmpty()){
                                        
                                                foreach($weeding as $row){
                                        
                                                    $data = $row;

                                                    $data['seasson_id'] = $row->seasson_id;
                                                    $data['land_id'] =  $row->farm_id;


                                                    $data['picture'] = url('season_images/'.$row->picture);

                                                     $gapId= $row->pesticide_name;
                                                     $data['gap'] = $gapId;
                                                     $data['pesticide'] = PesticideType::where('id', $gapId)->value('name');
                                                    // $data['id'] = $row->id;
                                                    $gapId2= $row->farming_process;
                                                    $data['gap_name'] = Farming_process::where('id', $gapId2)->value('process_name');
                                                   
                                        
                                                    $farm_program[] = $data;    
                                                }
                                        
                                                $response=['success'=>true,'error'=>false,'message'=>'Pestiside  Founds successful', 'pesticide' => $farm_program];
                                                return response()->json($response, 200);
                                               
                                            }  
                                            else{
                                                $response=['success' => false, 'error' => true, 'message'=>'Pestiside Not Founds'];
                                                return response()->json($response, 200);
                                            }
                                        
                                        
                                            }


                                            public function pesticideOff(int $id, int $landId, int $lastId){

                                                $weeding = Pestiside::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_pestisides.seasson_id')
                                                                        ->where('tbl_pestisides.seasson_id',$id)
                                                                        ->where('tbl_seassons.farm_id', $landId)
                                                                        ->where('tbl_pestisides.id', '>' ,$lastId)
                                                                        ->select('*','tbl_pestisides.id as id')
                                                                        ->get();
                                                
                                                if($weeding->isNotEmpty()){
                                            
                                                    foreach($weeding as $row){
                                            
                                                        $data = $row;

                                                        $data['seasson_id'] = $row->seasson_id;
                                                        $data['land_id'] =  $row->farm_id;


                                                        $data['picture'] = url('season_images/'.$row->picture);
    
                                                         $gapId= $row->pesticide_name;
                                                         $data['gap'] = $gapId;
                                                         $data['pesticide'] = PesticideType::where('id', $gapId)->value('name');
                                                        // $data['id'] = $row->id;
                                                        $gapId2= $row->farming_process;
                                                        $data['gap_name'] = Farming_process::where('id', $gapId2)->value('process_name');
                                                       
                                            
                                                        $farm_program[] = $data;    
                                                    }
                                            
                                                    $response=['success'=>true,'error'=>false,'message'=>'Pestiside  Founds successful', 'pesticide' => $farm_program];
                                                    return response()->json($response, 200);
                                                   
                                                }  
                                                else{
                                                    $response=['success' => false, 'error' => true, 'message'=>'Pestiside Not Founds'];
                                                    return response()->json($response, 200);
                                                }
                                            
                                            
                                                }
                                
                                            public function pesticide_store(Request $request){
                                
                                                // $preparationDetails = PreparationDetails::where('seasson_id',$id)->get();
                                          
                                                $this->validate($request,[
                                                    'pesticide_type'=>'required',
                                                    'gap'=>'required',
                                                    'pesticide_amount'=>'required',
                                                    'total_amount'=>'required',
                                                    'pesticide_price'=>'required',
                                                    'pesticide_cost'=>'required',
                                                    'no_hector'=>'required',
                                                    'pesticide_name'=>'required',
                                                    'total_cost'=>'required',
                                                    'seasson_id'=>'required',
                                                    'id' =>'required'
                                        
                                        
                                                    
                                                ]); 

                                                if ($request->hasFile('picture')) {
                                                    $photo=$request->file('picture');
                                                    $fileType=$photo->getClientOriginalExtension();
                                                    $fileName=rand(1,1000).date('dmyhis').".".$fileType;
                                                    $logo=$fileName;
                                                    $photo->move('season_images', $fileName );
                                                     $picture2 = $logo;
                                        
                                                }
                                                else{
                                                    $picture2 = "";
                                                }
                                        
                                                $data= new Pestiside();
                                                $data->pestiside_type=$request->input('pesticide_type');
                                                $data->farming_process=$request->input('gap');
                                                $data->pestiside_amount=$request->input('pesticide_amount');
                                                $data->no_hector=$request->input('no_hector');
                                                $data->pestiside_price=$request->input('pesticide_price');
                                                $data->pesticide_name=$request->input('pesticide_name');
                                                $data->total_amount=$request->input('total_amount');
                                                $data->pestiside_cost=$request->input('pesticide_cost');
                                                $data->total_cost=$request->input('total_cost');
                                                $data->seasson_id=$request->input('seasson_id');
                                                $data->picture=$picture2;
                                               
                                                $data['user_id'] = $request->input('id');;
                                        
                                                $data->save();

                                                $data['picture'] = url('season_images/'.$picture2);

                                                if($data)
                                                {
                                                
                                                    $response=['success'=>true,'error'=>false, 'message' => 'Pesticide  Created successful', 'pesticide' => $data];
                                                    return response()->json($response, 200);
                                                }
                                                else
                                                {
                                                    
                                                    $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Pesticide Successfully'];
                                                    return response()->json($response,200);
                                                }
                                            
                                            
                                                }

                                                public function warehouses(){
                                                    $warehouse = Warehouse::all();

                                                    if($warehouse->isEmpty()){
                                                
                                                        $response=['success' => false, 'error' => true, 'message'=>'warehouse Not Founds'];
                                                        return response()->json($response, 200);
                                                       
                                                    }  
                                                    else{
                                                        $response=['success'=>true,'error'=>false,'message'=>'warehouse  Founds successful', 'warehouses' => $warehouse];
                                                        return response()->json($response, 200);
                                                        
                                                    }


                                                }

                                                public function warehouses2(int $id){
                                                    $warehouse = Warehouse2::where('owner_id', $id)->get();

                                                    if(!empty($warehouse)){

                                                        $response=['success'=>true,'error'=>false,'message'=>'warehouse  Founds successful', 'warehouses' => $warehouse];
                                                        return response()->json($response, 200);
                                                       
                                                    }  
                                                    else{
                                                        $response=['success' => false, 'error' => true, 'message'=>'warehouse Not Founds'];
                                                        return response()->json($response, 200);
                                                    }


                                                }

                                                public function warehouses2Off(int $id, int $lastId){
                                                    $warehouse = Warehouse2::where('owner_id', $id)->where('id', '>' ,$lastId)->get();

                                                    if(!empty($warehouse)){

                                                        $response=['success'=>true,'error'=>false,'message'=>'warehouse  Founds successful', 'warehouses' => $warehouse];
                                                        return response()->json($response, 200);
                                                       
                                                    }  
                                                    else{
                                                        $response=['success' => false, 'error' => true, 'message'=>'warehouse Not Founds'];
                                                        return response()->json($response, 200);
                                                    }


                                                }


                                                public function warehouses_store(Request $request){

                                                    $this->validate($request,[
                                                        'warehouse_name'=>'required',
                                                        'owner_id'=>'required',
                                                        'location'=>'required',
                                                        'capacity'=>'required', 
                                                    ]); 

                                                        $data= new Warehouse2();
                                                        $data->warehouse_name=$request->input('warehouse_name');
                                                        $data->owner_id=$request->input('owner_id');
                                                        $data->location=$request->input('location');
                                                        $data->capacity=$request->input('capacity');
                                                        $data->save();
                                                        if($data)
                                                        {
                                                           
                                                        
                                                            $response=['success'=>true,'error'=>false, 'message' => 'Warehouse  Created successful', 'warehouse' => $data];
                                                            return response()->json($response, 200);
                                                        }
                                                        else
                                                        {
                                                            
                                                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Warehouse Successfully'];
                                                            return response()->json($response,200);
                                                        }

                


                                                }
                                                
                                                public function storage(int $id, int $landId){
                                                    $storage = Storage::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_storage.seasson_id')
                                                                        ->where('tbl_storage.seasson_id',$id)
                                                                        ->where('tbl_seassons.farm_id', $landId)
                                                                        ->select('*','tbl_storage.id as id')
                                                                        ->get();

                                                    if($storage->isEmpty()){

                                                        
                                                
                                                        $response=['success' => false, 'error' => true, 'message'=>'warehouse Not Founds'];
                                                        return response()->json($response, 200); 
                                                       
                                                    }  
                                                    else{

                                                        foreach($storage as $row){
                                        
                                                            $data = $row;

                                                            $data['picture'] = url('season_images/'.$row->picture);


                                                            $warehouse = Warehouse2::find($row->warehouse_id)->warehouse_name;

                                                            $data['warehouse_name'] = $warehouse;
                                                
                                                            $farm_program[] = $data;    
                                                        }

                                                        $response=['success'=>true,'error'=>false,'message'=>'warehouse  Founds successful', 'storage' => $farm_program];
                                                        return response()->json($response, 200);

                                                        
                                                    }

                                                }

                                                public function storageOff(int $id, int $landId, int $lastId){
                                                    $storage = Storage::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_storage.seasson_id')
                                                                        ->where('tbl_storage.seasson_id',$id)
                                                                        ->where('tbl_seassons.farm_id', $landId)
                                                                        ->where('tbl_storage.id', '>' ,$lastId)
                                                                        ->select('*','tbl_storage.id as id')
                                                                        ->get();

                                                    if($storage->isEmpty()){

                                                        
                                                
                                                        $response=['success' => false, 'error' => true, 'message'=>'warehouse Not Founds'];
                                                        return response()->json($response, 200); 
                                                       
                                                    }  
                                                    else{

                                                        foreach($storage as $row){
                                        
                                                            $data = $row;

                                                            $data['picture'] = url('season_images/'.$row->picture);


                                                            $warehouse = Warehouse2::find($row->warehouse_id)->warehouse_name;

                                                            $data['warehouse_name'] = $warehouse;
                                                
                                                            $farm_program[] = $data;    
                                                        }

                                                        $response=['success'=>true,'error'=>false,'message'=>'warehouse  Founds successful', 'storage' => $farm_program];
                                                        return response()->json($response, 200);

                                                        
                                                    }

                                                }


                                                public function storage_store(Request $request){

                                                    $this->validate($request,[
                                                        'warehouse_id'=>'required',
                                                        'startDate'=>'required',
                                                        'quantity'=>'required',
                                                        'seasson_id'=>'required',
                                                        'id'=>'required', 

                                                    ]); 

                                                    if ($request->hasFile('picture')) {
                                                        $photo=$request->file('picture');
                                                        $fileType=$photo->getClientOriginalExtension();
                                                        $fileName=rand(1,1000).date('dmyhis').".".$fileType;
                                                        $logo=$fileName;
                                                        $photo->move('season_images', $fileName );
                                                         $picture2 = $logo;
                                            
                                                    }
                                                    else{
                                                        $picture2 = "";
                                                    }

                                                        $data= new Storage();
                                                        $data->warehouse_id=$request->input('warehouse_id');
                                                        $data->startDate=$request->input('startDate');
                                                        $data->quantity=$request->input('quantity');
                                                        $data->seasson_id=$request->input('seasson_id');
                                                        $data->picture=$picture2;
                                                        $data->agronomy_id=$request->input('id');

                                                        $data->save();

                                                        $data['picture'] = url('season_images/'.$picture2);

                                                        if($data)
                                                        {
                                                            $response=['success'=>true,'error'=>false, 'message' => 'Storage  Created successful', 'storage' => $data];
                                                            return response()->json($response, 200);
                                                        }
                                                        else
                                                        {
                                                            
                                                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Storage Successfully'];
                                                            return response()->json($response,200);
                                                        }

                


                                                }
                                                
                                                
                                                public function pre_harvests(int $id, int $landId){

                                                    $weeding = PreHarvest::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_pre_harvests.seasson_id')
                                                                            ->where('tbl_pre_harvests.seasson_id',$id)
                                                                            ->where('tbl_seassons.farm_id', $landId)
                                                                            ->select('*','tbl_pre_harvests.id as id')
                                                                            ->get();
                                                    
                                                    if($weeding->isNotEmpty()){
                                                
                                                        foreach($weeding as $row){
                                                
                                                            $data = $row;

                                                            $data['seasson_id'] = $row->seasson_id;
                                                            $data['land_id'] =  $row->farm_id;


                                                            $data['picture'] = url('season_images/'.$row->picture);

                                                             $gapId= $row->warehouse_id;
                                                             $data['warehouse'] = Warehouse2::where('id', $gapId)->value('warehouse_name');
                                                            // $data['id'] = $row->id;
                                                
                                                            $farm_program[] = $data;    
                                                        }
                                                
                                                        $response=['success'=>true,'error'=>false,'message'=>'weeding  Founds successful', 'pre_harvests' => $farm_program];
                                                        return response()->json($response, 200);
                                                       
                                                    }  
                                                    else{
                                                        $response=['success' => false, 'error' => true, 'message'=>'weeding Not Founds'];
                                                        return response()->json($response, 200);
                                                    }
                                                
                                                
                                                    }

                                                    public function pre_harvestsOff(int $id, int $landId, int $lastId){

                                                        $weeding = PreHarvest::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_pre_harvests.seasson_id')
                                                                                ->where('tbl_pre_harvests.seasson_id',$id)
                                                                                ->where('tbl_seassons.farm_id', $landId)
                                                                                ->where('tbl_pre_harvests.id', '>' ,$lastId)
                                                                                ->select('*','tbl_pre_harvests.id as id')
                                                                                ->get();
                                                        
                                                        if($weeding->isNotEmpty()){
                                                    
                                                            foreach($weeding as $row){
                                                    
                                                                $data = $row;

                                                                $data['seasson_id'] = $row->seasson_id;
                                                                $data['land_id'] =  $row->farm_id;


                                                                $data['picture'] = url('season_images/'.$row->picture);
    
                                                                 $gapId= $row->warehouse_id;
                                                                 $data['warehouse'] = Warehouse2::where('id', $gapId)->value('warehouse_name');
                                                                // $data['id'] = $row->id;
                                                    
                                                                $farm_program[] = $data;    
                                                            }
                                                    
                                                            $response=['success'=>true,'error'=>false,'message'=>'weeding  Founds successful', 'pre_harvests' => $farm_program];
                                                            return response()->json($response, 200);
                                                           
                                                        }  
                                                        else{
                                                            $response=['success' => false, 'error' => true, 'message'=>'weeding Not Founds'];
                                                            return response()->json($response, 200);
                                                        }
                                                    
                                                    
                                                        }
                                        
                                                    public function pre_harvests_store(Request $request){
                                        
                                                        // $preparationDetails = PreparationDetails::where('seasson_id',$id)->get();
                                                  
                                                        $this->validate($request,[
                                                            'category'=>'required',
                                                            'harvest_method'=>'required',
                                                            'maturity_index'=>'required',
                                                            'maturity_level'=>'required',
                                                            'harvest_date'=>'required',
                                                            'packing_type'=>'required',
                                                            // 'drying_method'=>'required',
                                                            // 'market'=>'required',
                                                            // 'water'=>'required',
                                                            'cost'=>'required',
                                                            'acre'=>'required',
                                                            // 'warehouse_id'=>'required',
                                                            'total_harvest'=>'required',
                                                            'harvest_amount'=>'required',
                                                            'total_cost'=>'required',
                                                            'seasson_id'=>'required',
                                                            'id' =>'required'
                                                
                                                
                                                            
                                                        ]); 

                                                        if ($request->hasFile('picture')) {
                                                            $photo=$request->file('picture');
                                                            $fileType=$photo->getClientOriginalExtension();
                                                            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
                                                            $logo=$fileName;
                                                            $photo->move('season_images', $fileName );
                                                             $picture2 = $logo;
                                                
                                                        }
                                                        else{
                                                            $picture2 = "";
                                                        }
                                                
                                                        $data= new PreHarvest();
                                                        $data->category=$request->input('category');
                                                        $data->harvest_method=$request->input('harvest_method');
                                                        $data->maturity_index=$request->input('maturity_index');
                                                        $data->maturity_level=$request->input('maturity_level');
                                                        $data->harvest_date=$request->input('harvest_date');
                                                        $data->packing_type=$request->input('packing_type');
                                                        $data->drying_method=$request->input('drying_method');
                                                        $data->market=$request->input('market');
                                                        $data->water=$request->input('water');
                                                        $data->cost=$request->input('cost');
                                                        $data->acre=$request->input('acre');
                                                        $data->warehouse_id=$request->input('warehouse_id');
                                                        $data->total_harvest=$request->input('total_harvest');
                                                        $data->harvest_amount=$request->input('harvest_amount');
                                                        $data->total_cost=$request->input('total_cost');
                                                        $data->seasson_id=$request->input('seasson_id');
                                                        $data->picture=$picture2;
                                                       
                                                        $data['user_id'] = $request->input('id');;
                                                
                                                        $data->save();

                                                        $data['picture'] = url('season_images/'.$picture2);

                                                        if($data)
                                                        {
                                                           
                                                        
                                                            $response=['success'=>true,'error'=>false, 'message' => 'PreHarvest  Created successful', 'pre-harvest' => $data];
                                                            return response()->json($response, 200);
                                                        }
                                                        else
                                                        {
                                                            
                                                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create PreHarvest Successfully'];
                                                            return response()->json($response,200);
                                                        }
                                                    
                                                    
                                                        }

                                                        public function get_seassons(int $id){
                                                            $seasson = Seasson::where('farm_id',$id)->get();

                                                            if($seasson->isNotEmpty()){
                                                        
                                                                foreach($seasson as $row){

                                                                    $data = $row;
                                                    
                                                                    $crop = Crops_type::where('id', $row->crop_name)->first();
                                                    
                                                                    $data['crop_id'] = $row->crop_name;
                                                    
                                                                    $data['crop_name'] = $crop->crop_name;

                                                                    $seassonDetails[] = $data;    
                                                                }
                                                        
                                                                $response=['success'=>true,'error'=>false,'message'=>'Seassons  Founds successful', 'seasson' => $seassonDetails];
                                                                return response()->json($response, 200);
                                                               
                                                            }  
                                                            else{
                                                                $response=['success' => false, 'error' => true, 'message'=>'Seassons Not Founds'];
                                                                return response()->json($response, 200);
                                                            }

                                                        }

                                                        public function get_seassonsOff(int $id, int $lastId){
                                                            $seasson = Seasson::where('farm_id',$id)->where('id', '>' ,$lastId)->get();

                                                            if($seasson->isNotEmpty()){
                                                        
                                                                foreach($seasson as $row){

                                                                    $data = $row;
                                                    
                                                                    $crop = Crops_type::where('id', $row->crop_name)->first();
                                                    
                                                                    $data['crop_id'] = $row->crop_name;
                                                    
                                                                    $data['crop_name'] = $crop->crop_name;

                                                                    $seassonDetails[] = $data;    
                                                                }
                                                        
                                                                $response=['success'=>true,'error'=>false,'message'=>'Seassons  Founds successful', 'seasson' => $seassonDetails];
                                                                return response()->json($response, 200);
                                                               
                                                            }  
                                                            else{
                                                                $response=['success' => false, 'error' => true, 'message'=>'Seassons Not Founds'];
                                                                return response()->json($response, 200);
                                                            }

                                                        }


                                                        public function post_harvests(int $id, int $landId){

                                                            $weeding = PostHarvest::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_post_harvests.seasson_id')
                                                                                    ->where('tbl_post_harvests.seasson_id',$id)
                                                                                    ->where('tbl_seassons.farm_id', $landId)
                                                                                    ->select('*','tbl_post_harvests.id as id')
                                                                                    ->get();
                                                            
                                                            if($weeding->isNotEmpty()){
                                                        
                                                                foreach($weeding as $row){
                                                        
                                                                    $data = $row;

                                                                    $data['seasson_id'] = $row->seasson_id;
                                                                    $data['land_id'] =  $row->farm_id;


                                                                    $data['picture'] = url('season_images/'.$row->picture);

                                                                    //  $gapId= $row->gap;
                                                                    //  $data['pesticide'] = Pestiside::where('id', $gapId)->value('process_name');
                                                                    
                                                                     // $data['id'] = $row->id;
                                                        
                                                                    $farm_program[] = $data;    
                                                                }
                                                        
                                                                $response=['success'=>true,'error'=>false,'message'=>'PostHarvest  Founds successful', 'post_harvests' => $weeding];
                                                                return response()->json($response, 200);
                                                               
                                                            }  
                                                            else{
                                                                $response=['success' => false, 'error' => true, 'message'=>'PostHarvest Not Founds'];
                                                                return response()->json($response, 200);
                                                            }
                                                        
                                                        
                                                            }


                                                            public function post_harvestsOff(int $id, int $landId, int $lastId){

                                                                $weeding = PostHarvest::join('tbl_seassons', 'tbl_seassons.id', '=', 'tbl_post_harvests.seasson_id')
                                                                                        ->where('tbl_post_harvests.seasson_id',$id)
                                                                                        ->where('tbl_seassons.farm_id', $landId)
                                                                                        ->where('tbl_post_harvests.id', '>' ,$lastId)
                                                                                        ->select('*','tbl_post_harvests.id as id')
                                                                                        ->get();
                                                                
                                                                if($weeding->isNotEmpty()){
                                                            
                                                                    foreach($weeding as $row){
                                                            
                                                                        $data = $row;

                                                                        $data['seasson_id'] = $row->seasson_id;
                                                                        $data['land_id'] =  $row->farm_id;


                                                                        $data['picture'] = url('season_images/'.$row->picture);
    
                                                                        //  $gapId= $row->gap;
                                                                        //  $data['pesticide'] = Pestiside::where('id', $gapId)->value('process_name');
                                                                        
                                                                         // $data['id'] = $row->id;
                                                            
                                                                        $farm_program[] = $data;    
                                                                    }
                                                            
                                                                    $response=['success'=>true,'error'=>false,'message'=>'PostHarvest  Founds successful', 'post_harvests' => $weeding];
                                                                    return response()->json($response, 200);
                                                                   
                                                                }  
                                                                else{
                                                                    $response=['success' => false, 'error' => true, 'message'=>'PostHarvest Not Founds'];
                                                                    return response()->json($response, 200);
                                                                }
                                                            
                                                            
                                                                }
                                                
                                                            public function post_harvests_store(Request $request){
                                                
                                                                // $preparationDetails = PreparationDetails::where('seasson_id',$id)->get();
                                                          
                                                                $this->validate($request,[
                                                                    'category'=>'required',
                                                                    'harvest_method'=>'required',
                                                                    'maturity_index'=>'required',
                                                                    'maturity_level'=>'required',
                                                                    'harvest_date'=>'required',
                                                                    'packing_type'=>'required',
                                                                    // 'drying_method'=>'required',
                                                                    // 'market'=>'required',
                                                                    // 'water'=>'required',
                                                                    'cost'=>'required',
                                                                    'acre'=>'required',
                                                                    // 'warehouse_id'=>'required',
                                                                    'total_harvest'=>'required',
                                                                    'harvest_amount'=>'required',
                                                                    'total_cost'=>'required',
                                                                    'seasson_id'=>'required',
                                                                    'id' =>'required'
                                                        
                                                        
                                                                    
                                                                ]); 

                                                                if ($request->hasFile('picture')) {
                                                                    $photo=$request->file('picture');
                                                                    $fileType=$photo->getClientOriginalExtension();
                                                                    $fileName=rand(1,1000).date('dmyhis').".".$fileType;
                                                                    $logo=$fileName;
                                                                    $photo->move('season_images', $fileName );
                                                                    $picture2 = $logo;
                                                        
                                                                }
                                                                else{
                                                                    $picture2 = "";
                                                                }
                                                        
                                                                $data= new PostHarvest();
                                                                $data->category=$request->input('category');
                                                                $data->harvest_method=$request->input('harvest_method');
                                                                $data->maturity_index=$request->input('maturity_index');
                                                                $data->maturity_level=$request->input('maturity_level');
                                                                $data->harvest_date=$request->input('harvest_date');
                                                                $data->packing_type=$request->input('packing_type');
                                                                $data->drying_method=$request->input('drying_method');
                                                                $data->market=$request->input('market');
                                                                $data->water=$request->input('water');
                                                                $data->cost=$request->input('cost');
                                                                $data->acre=$request->input('acre');
                                                                $data->warehouse_id=$request->input('warehouse_id');
                                                                $data->total_harvest=$request->input('total_harvest');
                                                                $data->harvest_amount=$request->input('harvest_amount');
                                                                $data->total_cost=$request->input('total_cost');
                                                                $data->picture=$picture2;
                                                               
                                                                $data->seasson_id=$request->input('seasson_id');
                                                                $data['user_id'] = $request->input('id');
                                                        
                                                                $data->save();

                                                                $data['picture'] = url('season_images/'.$picture2);

                                                                if($data)
                                                                {
                                                                   
                                                                
                                                                    $response=['success'=>true,'error'=>false, 'message' => 'PostHarvest  Created successful', 'post-harvest' => $data];
                                                                    return response()->json($response, 200);
                                                                }
                                                                else
                                                                {
                                                                    
                                                                    $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create PostHarvest Successfully'];
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
       

        $this->validate($request,[
            'seasson_name'=>'required',
            'farm_id'=>'required',
            'farmer_id'=>'required',
            'start_date'=>'required',
            'harvest_date'=>'required',
            'crop_name'=>'required',          
        ]); 

        $data= new Seasson();
        $data->seasson_name=$request->input('seasson_name');
        $data->farm_id=$request->input('farm_id');
        $data->farmer_id=$request->input('farmer_id');
        $data->start_date=$request->input('start_date');
        $data->harvest_date=$request->input('harvest_date');
        $data->crop_name=$request->input('crop_name');
        $data['user_id'] = $request->input('id');;

        $data->save();
        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Seasson Created Seccessfully'];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true, 'message' => 'Failed to  Create Seasson Seccessfully'];
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
        $seasson_id = $id;
        //
        // $name = Preparation_cost::all();

        $preparationDetails = PreparationDetails::where('seasson_id',$seasson_id)->get();  
        $name = Preparation_cost::all();
        $type = "preparation";
        $sowing = Sowing::where('seasson_id',$seasson_id)->get(); 
        $fertilizer = Fertilizer::where('seasson_id',$seasson_id)->get(); 
$program=FarmProgram::where('season_id',$seasson_id)->get(); 
 $pestiside = Pestiside::where('seasson_id',$seasson_id)->get(); 
     $weeding = Weeding::where('seasson_id',$seasson_id)->get(); 
    $pre_harvest = PreHarvest::where('seasson_id',$seasson_id)->get(); 
        $post_harvest = PostHarvest::where('seasson_id',$seasson_id)->get(); 
        return view('farming_process.crop_life_cycle',compact('name','seasson_id','preparationDetails','type','sowing','program','fertilizer','pestiside','pre_harvest','post_harvest','weeding'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Seasson::find($id);
  $farmer = Farmer::all();
$farm= Land_properties::where('owner_id',$data->farmer_id)->get();  
$crop=Crops_type::all(); 
        return view('farming_process.manage_seasson',compact('data','id','farmer','farm','crop'));    }

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
        $user_id = auth()->user()->id;
        $data = $request->all();
        $data['user_id'] = $user_id;
        $season = Seasson::find($id);
        $season->update($data);

        return redirect(Route('seasson.index'))->with(['success'=>'Seasson Updated Seccessfully']);
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
    }

public function findFarm(Request $request)
    {

        $farm= Land_properties::where('owner_id',$request->id)->get();                                                                                    
               return response()->json($farm);

}
}
