<?php

namespace Database\Seeders;

use App\Models\Truck;
use App\Models\Tyre\TruckTyre;
use App\Models\Tyre\Tyre;
use App\Models\Tyre\TyreActivity;
use App\Models\Tyre\TyreAssignment;
use App\Models\Tyre\TyreBrand;
use Illuminate\Database\Seeder;

class TyreDiffSeeder extends Seeder
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
                'reference' =>'1007647213',
                'position' =>'Diff',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 350 DWW')->first()->id,
            ],                                      
                [
                'reference' => '1007996781',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 350 DWW')->first()->id,
    
              ],
              [
                'reference' => 'C210115008577',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 127 DWW')->first()->id,
    
              ],
              [
                'reference' => 'B210113008539',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 127 DWW')->first()->id,
    
              ],
              [
                'reference' => 'A210111008516',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 127 DWW')->first()->id,
    
              ],
              [
                'reference' => 'C210115016670',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 127 DWW')->first()->id,
    
              ],

              [
                'reference' => 'C210128011902',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 183 DWW')->first()->id,
    
              ],
             
              [
                'reference' => 'B210125011963',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 187 DWW')->first()->id,
    
              ],
              [
                'reference' => 'C210105008510',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 344 DWW')->first()->id,
    
              ],
              [
                'reference' => 'B210113008532',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 344 DWW')->first()->id,
    
              ],
              [
                'reference' => 'B210125011974',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 739 DWZ')->first()->id,
    
              ],
              [
                'reference' => 'B210113008536',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 737 DWZ')->first()->id,
    
              ],
              [
                'reference' => 'A210123011962',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 187 DWW')->first()->id,
    
              ],
              [
                'reference' => 'C210126011920',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 738 DWZ')->first()->id,
    
              ],
              [
                'reference' => 'B210126011966',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 737 DWZ')->first()->id,
    
              ],
              [
                'reference' => 'B210123011919',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 344 DWW')->first()->id,
    
              ],
              [
                'reference' => 'B210107008577',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 183 DWW')->first()->id,
    
              ],
              [
                'reference' => 'A210105008536',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 183 DWW')->first()->id,
    
              ],

              [
                'reference' => 'B210127011980',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 187 DWW')->first()->id,
    
              ],
              [
                'reference' => 'B210125011969',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 738 DWZ')->first()->id,
    
              ],

              [
                'reference' => 'A210113008520',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 739 DWZ')->first()->id,
    
              ],
              
              [
                'reference' => 'A210126011942',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 737 DWZ')->first()->id,
    
              ],


              [
                'reference' => 'B210104008577',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 739 DWZ')->first()->id,
    
              ],
              [
                'reference' => 'A210107016744',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 738 DWZ')->first()->id,
    
              ],

              [
                'reference' => 'B210105008567',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 737 DWZ')->first()->id,
    
              ],

              [
                'reference' => 'A210125011947',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 344 DWW')->first()->id,
    
              ],

              [
                'reference' => 'B210108008569',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 187 DWW')->first()->id,
    
              ],

              [
                'reference' => 'B210104008563',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 738 DWZ')->first()->id,
    
              ],

              [
                'reference' => 'B210114016731',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 739 DWZ')->first()->id,
    
              ],

              [
                'reference' => 'B210110016778',
                'position' => 'Diff',
                'location' => '1',
                'assign_reference' => '1',
                'status' => '1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 183 DWW')->first()->id,
    
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
                
                 'due_diff'=>$truck->due_diff - 1,
                 'due_tyre'=>$truck->due_tyre - 1,
                 'status'=>$status,
                 'staff'=>'1',
                ];
                TruckTyre::where('truck_id',$tyre->truck_id)->update($items);
                
                
                $lists=[
                    'position'=>'Diff',
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
