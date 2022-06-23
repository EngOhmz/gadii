<?php

namespace App\Services;
use App\Services\CropsLifeCycleInterface;
use App\Services\CropSowing;
use App\Models\farming\PreparationDetails;
use App\Models\farming\Sowing;
use App\Models\farming\Fertilizer;
use App\Models\farming\PreHarvest;
use App\Models\farming\PostHarvest;
use App\Models\farming\Pestiside;
use App\Models\farming\PreparationCostLists;
use App\Models\LimeBase;
use App\Models\FeedType;
use App\Models\farming\Weeding; 
use App\Models\FarmProgram;
use App\Models\PesticideType;

class LandPreparation  implements CropsLifeCycleInterface
{   
   
    public function landPreparation($data,$type,$function){
        if($function == "preparation"){
            return $this->preparation($data,$type);
        }elseif($function == "sowing"){
            return $this->cropSowing($data,$type);
        }elseif($function == "fertilizer"){
            return $this->fertilizer($data,$type);
        }elseif($function == "pestiside"){
            return $this->pestiside($data,$type);
        }
        elseif($function == "pre_harvest"){
            return $this->preHarvest($data,$type);
        }
        elseif($function == "post_harvest"){
            return $this->postHarvest($data,$type);
        }
       elseif($function == "weeding"){
            return $this->weeding($data,$type);
        }  elseif($function == "program"){
            return $this->program($data,$type);
        }
    }

//program functions
public function Program($data,$type){
        if($type =="store")
        return $this->saveProgram($data);
        elseif($type == "update")
        return $this->updateProgram($data);
        elseif($type == "edit")
        return $this->getByIdProgram($data);
        elseif($type == "delete")
        return $this->deleteProgram($data);
}
private function getByIdProgram($id){

    $result['result'] =FarmProgram::find($id);
   $result['costs'] = null;
$result['lime'] = null; 
        $result['seeds_type'] = null; 
   return $result;
}

public function saveProgram($request){
      $details['name'] =  $request['name'];
    $details['gap'] =  $request['gap'];
    $details['distributor'] =  $request['distributor'];
    $details['cost'] =  $request['cost'];
    $details['acre'] =  $request['acre'];
  $details['total_cost'] =  $request['total_cost'];
    $details['added_by'] =  auth()->user()->id;
    $details['season_id'] =  $request['seasson_id'];

    $pre_harvest = FarmProgram::create($details);

   


    return true;


}
public function updateProgram($request){
     $details['name'] =  $request['name'];
    $details['gap'] =  $request['gap'];
    $details['distributor'] =  $request['distributor'];
    $details['cost'] =  $request['cost'];
    $details['acre'] =  $request['acre'];
  $details['total_cost'] =  $request['total_cost'];
    $details['added_by'] =  auth()->user()->id;
    $details['season_id'] =  $request['seasson_id'];
    $preparationDetails = FarmProgram::where('id',$request['id'])->update($details);

    return true;
   
} 
public function deleteProgram($id){
    $result = FarmProgram::find($id)->delete();
    

    return true;

}


//postHarvest functions
public function postHarvest($data,$type){
        if($type =="store")
        return $this->savePostHarvest($data);
        elseif($type == "update")
        return $this->updatePostHarvest($data);
        elseif($type == "edit")
        return $this->getByIdPostHarvest($data);
        elseif($type == "delete")
        return $this->deletePostHarvest($data);
}
private function getByIdPostHarvest($id){

    $result['result'] = PostHarvest::find($id);
   $result['costs'] = null;
$result['lime'] = null; 
        $result['seeds_type'] = null; 
   return $result;
}

public function savePostHarvest($request){
      $details['category'] =  $request['category'];
    $details['harvest_method'] =  $request['harvest_method'];
    $details['maturity_index'] =  $request['maturity_index'];
    $details['maturity_level'] =  $request['maturity_level'];
    $details['harvest_date'] =  $request['harvest_date'];
      $details['packing_type'] =  $request['packing_type'];
   $details['drying_method'] =  $request['drying_method'];
$details['warehouse_id'] =  $request['warehouse_id'];
    $details['market'] =  $request['market'];
      $details['water'] =  $request['water'];
    $details['cost'] =  $request['cost'];
    $details['acre'] =  $request['acre'];
  $details['total_cost'] =  $request['total_cost'];
   $details['harvest_amount'] =  $request['harvest_amount'];
  $details['total_harvest'] =   $request['harvest_amount'] * $request['acre'];
    $details['user_id'] =  auth()->user()->added_by;
    $details['seasson_id'] =  $request['seasson_id'];

    $pre_harvest = PostHarvest::create($details);

   


    return true;


}
public function updatePostHarvest($request){
      $details['category'] =  $request['category'];
    $details['harvest_method'] =  $request['harvest_method'];
    $details['maturity_index'] =  $request['maturity_index'];
    $details['maturity_level'] =  $request['maturity_level'];
    $details['harvest_date'] =  $request['harvest_date'];
      $details['packing_type'] =  $request['packing_type'];
   $details['drying_method'] =  $request['drying_method'];
$details['warehouse_id'] =  $request['warehouse_id'];
    $details['market'] =  $request['market'];
      $details['water'] =  $request['water'];
    $details['cost'] =  $request['cost'];
    $details['acre'] =  $request['acre'];
  $details['total_cost'] =  $request['total_cost'];
   $details['harvest_amount'] =  $request['harvest_amount'];
   $details['total_harvest'] =   $request['harvest_amount'] * $request['acre'];
    $details['user_id'] =  auth()->user()->added_by;
    $details['seasson_id'] =  $request['seasson_id'];

    $preparationDetails = PostHarvest::where('id',$request['id'])->update($details);

    return true;
   
} 
public function deletePostHarvest($id){
    $result = PreHarvest::find($id)->delete();
    

    return true;

}



public function preHarvest($data,$type){
        if($type =="store")
        return $this->savePreHarvest($data);
        elseif($type == "update")
        return $this->updatePreHarvest($data);
        elseif($type == "edit")
        return $this->getByIdPreHarvest($data);
        elseif($type == "delete")
        return $this->deletePreHarvest($data);
}

private function getByIdPreHarvest($id){

    $result['result'] = PreHarvest::find($id);
   $result['costs'] = null;
$result['lime'] = null; 
        $result['seeds_type'] = null; 
   return $result;
}

public function savePreHarvest($request){   
    $details['category'] =  $request['category'];
    $details['harvest_method'] =  $request['harvest_method'];
    $details['maturity_index'] =  $request['maturity_index'];
    $details['maturity_level'] =  $request['maturity_level'];
    $details['harvest_date'] =  $request['harvest_date'];
      $details['packing_type'] =  $request['packing_type'];
   $details['drying_method'] =  $request['drying_method'];
$details['warehouse_id'] =  $request['warehouse_id'];
    $details['market'] =  $request['market'];
      $details['water'] =  $request['water'];
    $details['cost'] =  $request['cost'];
    $details['acre'] =  $request['acre'];
  $details['total_cost'] =  $request['total_cost'];
   $details['harvest_amount'] =  $request['harvest_amount'];
  $details['total_harvest'] =  $request['total_harvest'];
    $details['user_id'] =  auth()->user()->added_by;
    $details['seasson_id'] =  $request['seasson_id'];

    $pre_harvest = PreHarvest::create($details);

   


    return true;


}

public function updatePreHarvest($request){
    $details['category'] =  $request['category'];
    $details['harvest_method'] =  $request['harvest_method'];
    $details['maturity_index'] =  $request['maturity_index'];
    $details['maturity_level'] =  $request['maturity_level'];
    $details['harvest_date'] =  $request['harvest_date'];
      $details['packing_type'] =  $request['packing_type'];
   $details['drying_method'] =  $request['drying_method'];
$details['warehouse_id'] =  $request['warehouse_id'];
    $details['market'] =  $request['market'];
      $details['water'] =  $request['water'];
    $details['cost'] =  $request['cost'];
    $details['acre'] =  $request['acre'];
  $details['total_cost'] =  $request['total_cost'];
   $details['harvest_amount'] =  $request['harvest_amount'];
  $details['total_harvest'] =  $request['total_harvest'];
    $details['user_id'] =  auth()->user()->added_by;
    $details['seasson_id'] =  $request['seasson_id'];

    $preparationDetails = PreHarvest::where('id',$request['id'])->update($details);

    return true;
   
} 
public function deletePreHarvest($id){
    $result = PreHarvest::find($id)->delete();
    

    return true;

}


     //preparation functions
    public function preparation($data,$type){
            if($type =="store")
            return $this->saveLandPreparation($data);
            elseif($type == "update")
            return $this->updateLandPreparation($data);
            elseif($type == "edit")
            return $this->getByIdLandPreparation($data);
            elseif($type == "delete")
            return $this->deleteLandPreparation($data);
    }

    private function getByIdLandPreparation($id){

        $result['result'] = PreparationDetails::find($id);
        $p= PreparationDetails::find($id);
       $result['costs'] = PreparationCostLists::all()->where('preparation_id',$id);
       $result['lime'] = LimeBase::where('type',$p->soil_salt)->get(); 
$result['seeds_type'] = null; 
       return $result;
    }

    public function saveLandPreparation($request){

        $details['preparation_type'] =  $request['preparation_type'];
        $details['seasson_id'] =  $request['seasson_id'];
        $details['soil_salt'] =  $request['soil_salt'];
        $details['acid_level'] =  $request['acid_level'];
        $details['moisture_level'] =  $request['moisture_level'];
        $details['lime_control'] =  $request['lime_control'];
        $details['cost'] =  $request['cost'];
        $details['acre'] =  $request['acre'];
        $details['total_cost'] =  $request['total_cost'];
        $details['user_id'] =  auth()->user()->id;
        $preparationDetails = PreparationDetails::create($details);

  /**
        $amountArr = str_replace(",","",$request['amount']);
        $totalArr =  str_replace(",","",$request['tax']);

        $nameArr =$request['item_name'] ;
        $qtyArr = $request['quantity'] ;
        $priceArr = $request['price'];
        $recommendation = $request['recommendation'];
        $rateArr = $request['tax_rate'] ;
        
        $costArr = str_replace(",","",$request['total_cost']);
        
        $savedArr =$request['item_name'] ;
        
        $cost['preparation_cost'] = 0;
        
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['preparation_cost'] +=$costArr[$i];
                    

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                        'recommendation'=>$recommendation[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                        'preparation_id' =>$preparationDetails->id);
                       
                        PreparationCostLists::create($items);  ;
    
    
                }
            }
            
            $cost['preparation_cost'] =  $cost['preparation_cost'];
            PreparationDetails::where('id',$preparationDetails->id)->update($cost);
        }    
*/

        return true;


    } 

    public function updateLandPreparation($request){
   $details['preparation_type'] =  $request['preparation_type'];
        $details['seasson_id'] =  $request['seasson_id'];
        $details['soil_salt'] =  $request['soil_salt'];
        $details['acid_level'] =  $request['acid_level'];
        $details['moisture_level'] =  $request['moisture_level'];
        $details['lime_control'] =  $request['lime_control'];
        $details['cost'] =  $request['cost'];
        $details['acre'] =  $request['acre'];
        $details['total_cost'] =  $request['total_cost'];
        $details['user_id'] =  auth()->user()->id;


        $preparationDetails = PreparationDetails::where('id',$request['id'])->update($details);

/**
        $amountArr = str_replace(",","",$request['amount']);
        $totalArr =  str_replace(",","",$request['tax']);

        $nameArr =$request['item_name'] ;
        $qtyArr = $request['quantity'] ;
        $priceArr = $request['price'];
        $rateArr = $request['tax_rate'] ;
        
        $costArr = str_replace(",","",$request['total_cost']);
        
        $recommendation = $request['recommendation'];

        $savedArr =$request['item_name'] ;
        
        $cost['preparation_cost'] = 0;
        
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['preparation_cost'] +=$costArr[$i];
                    

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                        
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'recommendation'=>$recommendation[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                        'preparation_id' =>$request['id']);
                       
                        PreparationCostLists::where('preparation_id',$request['id'])->update($items);  ;
    
    
                }
            }
            
            $cost['preparation_cost'] =  $cost['preparation_cost'];
            PreparationDetails::where('id',$request['id'])->update($cost);
        }    
*/

        return true;


    } 
    public function deleteLandPreparation($id){
        $result = PreparationDetails::find($id)->delete();
        PreparationCostLists::where('preparation_id',$id)->delete();

        return true;

    }

    //sowing functions
    public function cropSowing($data,$type){
        if($type =="store")
        return $this->saveCropSowing($data);
        elseif($type == "update")
        return $this->updateCropSowing($data);
        elseif($type == "edit")
        return $this->getByIdCropSowing($data);
        elseif($type == "delete")
        return $this->deleteCropSowing($data);
       

        

    }

    private function getByIdCropSowing($id){

        $result['result'] = Sowing::find($id);
        $result['costs'] = null;
       $result['lime'] = null; 
       $s= Sowing::find($id);
        $result['seeds_type'] =  FeedType::where('crop_name',$s->crop_type)->get(); 

       return $result;
    }

    public function saveCropSowing($request){
        $details['crop_type'] =  $request['crop_type'];
        $details['seasson_id'] =  $request['seasson_id'];
        $details['seed_type'] =  $request['seed_type'];
        $details['qheck'] =  $request['qheck'];
        $details['harvest_date'] =  $request['harvest_date'];
        $details['cost'] =  $request['cost'];
        $details['nh'] =  $request['nh'];
        $details['qn'] =  $request['qheck']*$request['nh'];
         $details['total_cost'] =  $request['total_cost'];
        $details['user_id'] =  auth()->user()->added_by;

        $sowing = Sowing::create($details);

       
   

        return true;


    } 

    public function updateCropSowing($request){
        $details['crop_type'] =  $request['crop_type'];
        $details['seasson_id'] =  $request['seasson_id'];
        $details['seed_type'] =  $request['seed_type'];
        $details['qheck'] =  $request['qheck'];
        $details['cost'] =  $request['cost'];
        $details['nh'] =  $request['nh'];
        $details['qn'] =  $request['qheck']*$request['nh'];
      $details['total_cost'] =  $request['total_cost'];
        $details['user_id'] =  auth()->user()->added_by;

        $preparationDetails = Sowing::where('id',$request['id'])->update($details);

        return true;
       
    } 
    private function deleteCropSowing($id){

        $result = Sowing::find($id)->delete();
       return true;
    }

        //fertilizers functions
        public function fertilizer($data,$type){
            if($type =="store")
            return $this->saveFertilizer($data);
            elseif($type == "update")
            return $this->updateFertilizer($data);
            elseif($type == "edit")
            return $this->getByIdFertilizer($data);
            elseif($type == "delete")
            return $this->deleteFertilizer($data);
           
    
            
    
        }
    
        private function getByIdFertilizer($id){
    
            $result['result'] = Fertilizer::find($id);
            $result['costs'] = null;
           $result['lime'] = null; 
    
           return $result;
        }
        
        public function saveFertilizer($request){
               $details['program'] =  $request['program'];
            $details['package'] =  $request['package'];
            $details['farming_process'] =  $request['farming_process'];
            $details['fertilizer_amount'] =  $request['fertilizer_amount'];
            $details['no_hector'] =  $request['no_hector'];
            $details['total_amount'] =  $request['fertilizer_amount']*$details['no_hector'];
            $details['fertilizer_price'] =  $request['fertilizer_price'];
            $details['total_cost'] =  $request['total_cost'];
           $details['total_amount'] =  $request['fertilizer_amount']*$details['no_hector'];
            $details['user_id'] =  auth()->user()->added_by;
            $details['seasson_id'] =  $request['seasson_id'];
    
            $sowing = Fertilizer::create($details);
    
           
       
    
            return true;
    
    
        } 
    
        public function updateFertilizer($request){
           $details['program'] =  $request['program'];
            $details['package'] =  $request['package'];
            $details['farming_process'] =  $request['farming_process'];
            $details['fertilizer_amount'] =  $request['fertilizer_amount'];
            $details['no_hector'] =  $request['no_hector'];
            $details['total_amount'] =  $request['fertilizer_amount']*$details['no_hector'];
            $details['fertilizer_price'] =  $request['fertilizer_price'];
            $details['total_cost'] =  $request['total_cost'];
           $details['total_amount'] =  $request['fertilizer_amount']*$details['no_hector'];
            $details['user_id'] =  auth()->user()->added_by;
            $details['seasson_id'] =  $request['seasson_id'];
    
            $preparationDetails = Fertilizer::where('id',$request['id'])->update($details);
    
            return true;
           
        } 
        private function deleteFertilizer($id){
    
            $result = Fertilizer::find($id)->delete();
           return true;
        }

        

          //pestisides functions
          public function pestiside($data,$type){
            if($type =="store")
            return $this->savePestiside($data);
            elseif($type == "update")
            return $this->updatePestiside($data);
            elseif($type == "edit")
            return $this->getByIdPestiside($data);
            elseif($type == "delete")
            return $this->deletePestiside($data);
        }

        private function getByIdPestiside($id){
    
            $result['result'] = Pestiside::find($id);
            $result['costs'] = null;
         $result['lime'] = null; 
         $p=  Pestiside::find($id);
        $result['seeds_type'] =  PesticideType::where('type',$p->pestiside_type)->get(); 

    
           return $result;
        }

        public function savePestiside($request){
            $details['pestiside_type'] =  $request['pestiside_type'];
                 $details['pesticide_name'] =  $request['pesticide_name'];
            $details['farming_process'] =  $request['farming_process'];
            $details['pestiside_amount'] =  $request['pestiside_amount'];
            $details['no_hector'] =  $request['no_hector'];
              $details['total_cost'] =  $request['total_cost'];
            $details['total_amount'] =  $request['pestiside_amount']*$details['no_hector'];
            $details['pestiside_price'] =  $request['pestiside_price'];
            $details['pestiside_cost'] =  $request['pestiside_price']*$details['total_amount'];
            $details['user_id'] =  auth()->user()->added_by;
            $details['seasson_id'] =  $request['seasson_id'];
    
            $sowing = Pestiside::create($details);
    
           
       
    
            return true;
    
    
        } 

        public function updatePestiside($request){
            $details['pestiside_type'] =  $request['pestiside_type'];
            $details['farming_process'] =  $request['farming_process'];
            $details['pestiside_amount'] =  $request['pestiside_amount'];
            $details['no_hector'] =  $request['no_hector'];
             $details['total_cost'] =  $request['total_cost'];
            $details['total_amount'] =  $request['pestiside_amount']*$details['no_hector'];
            $details['pestiside_price'] =  $request['pestiside_price'];
            $details['pestiside_cost'] =  $request['pestiside_price']*$details['total_amount'];
            $details['user_id'] =  auth()->user()->added_by;
            $details['seasson_id'] =  $request['seasson_id'];
    $details['pesticide_name'] =  $request['pesticide_name'];
            $preparationDetails = Pestiside::where('id',$request['id'])->update($details);
    
            return true;
           
        } 

        private function deletePestiside($id){
    
            $result = Pestiside::find($id)->delete();
           return true;
        }


// weeding functions
        public function weeding($data,$type){
            if($type =="store")
            return $this->saveWeeding($data);
            elseif($type == "update")
            return $this->updateWeeding($data);
            elseif($type == "edit")
            return $this->getByIdWeeding($data);
            elseif($type == "delete")
            return $this->deleteWeeding($data);
           
    
            
    
        }
    
        private function getByIdWeeding($id){
    
            $result['result'] = Weeding::find($id);
            $result['costs'] = null;
           $result['lime'] = null; 
        $result['seeds_type'] = null; 
           return $result;
        }
        
        public function saveWeeding($request){
               $details['name'] =  $request['name'];
            $details['method'] =  $request['method'];
            $details['process'] =  $request['process'];
           $details['effect'] =  $request['effect'];
            $details['chemical_status'] =  $request['chemical_status'];
            $details['chemical'] =  $request['chemical'];
            $details['cost'] =  $request['cost'];
            $details['weed_cost'] =  $request['weed_cost'];
            $details['acre'] =  $request['acre'];
            $details['total_cost'] =  $request['total_cost'];
            $details['added_by'] =  auth()->user()->id;
            $details['seasson_id'] =  $request['seasson_id'];
    
            $weeding = Weeding::create($details);
    
       
    
            return true;
    
    
        } 
    
        public function updateWeeding($request){
            $details['name'] =  $request['name'];
            $details['method'] =  $request['method'];
            $details['process'] =  $request['process'];
           $details['effect'] =  $request['effect'];
            $details['chemical_status'] =  $request['chemical_status'];
            $details['chemical'] =  $request['chemical'];
            $details['cost'] =  $request['cost'];
            $details['weed_cost'] =  $request['weed_cost'];
            $details['acre'] =  $request['acre'];
            $details['total_cost'] =  $request['total_cost'];
            $details['added_by'] =  auth()->user()->id;
            $details['seasson_id'] =  $request['seasson_id'];
    
            $preparationDetails = Weeding::where('id',$request['id'])->update($details);
    
            return true;
           
        } 
        private function deleteWeeding($id){
    
            $result = Weeding::find($id)->delete();
           return true;
        }





}