<?php

namespace App\Services;
use App\Services\CropsLifeCycleInterface;
use App\Services\LandPreparation;
use App\Models\farming\Sowing;
use App\Models\farming\PreparationCostLists;
   
class CropSowing  implements CropsLifeCycleInterface 
{   

   
    public function cropSowing($data,$type){
        if($type =="store")
        return $this->saveCropSowing($data);
        elseif($type == "update")
        return $this->updateCropSowing($data);
        elseif($type == "edit")
        return $this->getByIdCropSowing($data);
       

        

    }

    private function getByIdCropSowing($id){

        $result['sowing'] = Sowing::find($id);
     

       return $result;
    }

    public function saveCropSowing($request){
        $details['crops_type'] =  $request['crops_type'];
        $details['seed_type'] =  $request['seed_type'];
        $details['qheck'] =  $request['qheck'];
        $details['cost'] =  $request['cost'];
        $details['nh'] =  $request['nh'];
        $details['qn'] =  $request['qn'];
        $details['user_id'] =  auth()->user()->id;

        $sowing = Sowing::create($details);

       
   

        return true;


    } 

    public function updateLandPreparation($request){
        $details['crops_type'] =  $request['crops_type'];
        $details['seed_type'] =  $request['seed_type'];
        $details['qheck'] =  $request['qheck'];
        $details['cost'] =  $request['cost'];
        $details['nh'] =  $request['nh'];
        $details['qn'] =  $request['qn'];
        $details['user_id'] =  auth()->user()->id;

        $preparationDetails = Sowing::where('id',$request['id'])->update($details);

       
    } 
  
}