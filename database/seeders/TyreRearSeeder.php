<?php

namespace Database\Seeders;

use App\Models\Truck;
use App\Models\Tyre\TruckTyre;
use App\Models\Tyre\Tyre;
use App\Models\Tyre\TyreActivity;
use App\Models\Tyre\TyreAssignment;
use App\Models\Tyre\TyreBrand;
use Illuminate\Database\Seeder;

class TyreRearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data= [

            [
                'reference' =>'1007734833',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 344 DWW')->first()->id,
            ],                                      
                [
                'reference' => '1007948192',
                'position' => 'Rear',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 739 DWZ')->first()->id,
    
              ],
              [
                'reference' =>'1007458599',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 350 DWW')->first()->id,
            ], 

            [
                'reference' =>'1007734815',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 737 DWZ')->first()->id,
            ], 

            [
                'reference' =>'1007948175',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 738 DWZ')->first()->id,
            ], 

            [
                'reference' =>'1007458628',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 187 DWW')->first()->id,
            ], 

            [
                'reference' =>'1007468164',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 737 DWZ')->first()->id,
            ], 

            [
                'reference' =>'1007490924',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 738 DWZ')->first()->id,
            ], 

            [
                'reference' =>'1007734829',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 187 DWW')->first()->id,
            ], 

            [
                'reference' =>'1007490913',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 350 DWW')->first()->id,
            ], 
            [
                'reference' =>'1007490885',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 344 DWW')->first()->id,
            ], 

            [
                'reference' =>'1007490896',
                'position' =>'Rear',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 739 DWZ')->first()->id,
            ], 

            ];
    
            foreach ($data as $row) {
                $tyre=Tyre::create($row);

                if(!empty($tyre->truck_id)){  
                $truck=TruckTyre::where('truck_id',$tyre->truck_id)->first();
                  if(($truck->due_tyre - 1) == '0'){
                    $status='2';
                    }
                    else{
                    $status='1';
                    }

                $items=[
                
                 'due_rear'=>$truck->due_rear - 1,
                 'due_tyre'=>$truck->due_tyre - 1,
                 'status'=>$status,
                 'staff'=>'1',
                ];
                TruckTyre::where('truck_id',$tyre->truck_id)->update($items);
                
                
                $lists=[
                    'position'=>'Rear',
                    'tyre_id'=>$tyre->id,
                    'truck_id'=>$tyre->truck_id,
                    'status'=>'1',
                    'added_by' => '57',
                    'staff'=>'1',
                   ];
                    TyreAssignment::create($lists);

                   $inv=TyreBrand::where('id',$tyre->brand_id)->first();
                   $q=$inv->quantity - 1;
                   TyreBrand::where('id',$tyre->brand_id)->update(['quantity' => $q]);


                    $t=Truck::find($tyre->truck_id);
                     if(!empty($truck)){
                        $activity = TyreActivity::create(
                            [ 
                                'added_by'=>'57',
                                'module_id'=>$tyre->id,
                                'module'=>'Assign Tyre',
                                'activity'=>"Tyre " . $tyre->reference. " Assigned to " . $t->truck_name. " - " . $t->reg_no,
                                'date'=>date('Y-m-d'),

                            ]
                            );    
                                              
            }

          }


            }

    }
}
