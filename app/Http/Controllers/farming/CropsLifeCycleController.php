<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CropsLifeCycleInterface;
use App\Models\farming\Preparation_cost;
use App\Models\farming\PreparationDetails;
use App\Models\farming\Sowing;
use App\Models\farming\Pestiside;
use App\Models\farming\Fertilizer; 
use App\Models\farming\Weeding; 
use App\Models\farming\PreHarvest; 
use App\Models\farming\PostHarvest; 
use App\Models\LimeBase;
use App\Models\FeedType;
use App\Models\Farming_process;
use App\Models\FarmProgram;
use App\Models\Crops_Monitoring;
use App\Models\Land_properties;
use App\Models\Monitoring_type;
use Session;
use App\Models\PesticideType;

class CropsLifeCycleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $type = Session::get('success');
        $seasson_id = Session::get('seasson_id');
         if(empty($type))
         $type = "preparation";

        $name = Preparation_cost::all();
        $preparationDetails = PreparationDetails::where('seasson_id',$seasson_id)->get();  
        $sowing = Sowing::where('seasson_id',$seasson_id)->get(); 
        $fertilizer = Fertilizer::where('seasson_id',$seasson_id)->get(); 
        $pestiside = Pestiside::where('seasson_id',$seasson_id)->get(); 
     $weeding = Weeding::where('seasson_id',$seasson_id)->get(); 
$program=FarmProgram::where('season_id',$seasson_id)->get(); 
        $pre_harvest = PreHarvest::where('seasson_id',$seasson_id)->get(); 
        $post_harvest = PostHarvest::where('seasson_id',$seasson_id)->get(); 
        return view('farming_process.crop_life_cycle',compact('name','seasson_id','preparationDetails','type','sowing','fertilizer','pestiside','pre_harvest','post_harvest','weeding','program'));
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
    public function store(Request $request,CropsLifeCycleInterface $cropsLifeCycleInterface)
    {
        //
        $function = $request->type;
        
        $result =   $cropsLifeCycleInterface->landPreparation($request->all(),"store",$function);

        if($result){
            return redirect()->route('cropslifecycle.index', $function)->with(['success'=>$function,'seasson_id'=>$request->seasson_id]);
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
    public function edit($id,Request $request)
    {
        //
//
    }
    public function editLifeCycle(Request $request,CropsLifeCycleInterface $cropsLifeCycleInterface){
        $function = $request->type;
        
            $result =   $cropsLifeCycleInterface->landPreparation($request->id,"edit",$function);
            if(!empty($result)){
                $name = Preparation_cost::all();
                $id = $request->id;
                $data = $result['result'];
                $costs = $result['costs'];
                 $lime = $result['lime'];
                $seeds_type = $result['seeds_type'];
                $type = "edit-".$function;
                $seasson_id = $request->seasson_id;
                
                return view('farming_process.crop_life_cycle',compact('name','id','seasson_id','data','costs','type','lime','seeds_type'));
            }else{
                echo  "jau"; 
            }
        
    }

    public function deleteLifeCycle(Request $request,CropsLifeCycleInterface $cropsLifeCycleInterface){
        $function = $request->type;
        
        $result =   $cropsLifeCycleInterface->landPreparation($request->id,"delete",$function);
        if($result){
            return redirect()->route('cropslifecycle.index', $function)->with(['success'=>$function,'seasson_id'=>$request->seasson_id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,CropsLifeCycleInterface $cropsLifeCycleInterface)
    {
        //
        $function = $request->type;
        $data = $request->all();
        $data['id'] = $id;
             
        $result =   $cropsLifeCycleInterface->landPreparation($data,"update",$function);
        if($result){
             return redirect()->route('cropslifecycle.index', ['type' => $function,'id'=>$id])->with(['success'=>$function]);
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
    }

public function findLime(Request $request)
    {
  if(empty($type)){
         $type = "preparation";
        $farm=LimeBase::where('type',$request->id)->get();                                                                                    
               return response()->json($farm);
}
}

public function findSeed(Request $request)
    {
  if(empty($type)){
         $type = "preparation";
        $farm=FeedType::where('crop_name',$request->id)->get();                                                                                    
               return response()->json($farm);
}

}
public function findPesticide(Request $request)
    {
        $farm=PesticideType::where('type',$request->id)->get();                                                                                    
               return response()->json($farm);


}

public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
              $season_id = $request->seasson_id;
          $farm = Land_properties::all();
        $mtype = Monitoring_type::all();
                    return view('farming_process.life_cycle_tabs.addMonitor',compact('id','type','season_id','farm','mtype'));   
                 }

              public function save_monitor(Request $request){
                     //
                  $data = $request->all();
                $data['added_by'] =  auth()->user()->id;

        if ($request->hasFile('attachment')) {
					$file=$request->file('attachment');
					$fileType=$file->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$name=$fileName;
					$path = public_path(). "/assets/files/";
					$file->move($path, $fileName );
					
					$data['attachment'] = $name;
            	}else{
            	    	$data['attachment'] = null;
            	}

        $cost  = Crops_Monitoring::create($data);
        
                 if($cost)
        {

            return redirect()->back()->with(['success'=>"Crop Monitoring created successfully"]);
        }
              

                 }


}
