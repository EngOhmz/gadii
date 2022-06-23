<?php

namespace App\Http\Controllers\farming;

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

class SeassonController extends Controller
{
    

    public function index()
    {
        //
        $farmer = Farmer::all();
        $user_id = auth()->user()->id;
        $seasson = Seasson::all()->where('user_id',$user_id);
$crop=Crops_type::all();
        return view('farming_process.manage_seasson',compact('seasson','farmer','crop'));
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
        $user_id = auth()->user()->id;
        $data = $request->all();
        $data['user_id'] = $user_id;
        $season = Seasson::create($data);

        return redirect(Route('seasson.index'))->with(['success'=>'Seasson Created Seccessfully']);
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
        $name = Preparation_cost::all();

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
