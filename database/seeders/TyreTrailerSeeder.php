<?php

namespace Database\Seeders;

use App\Models\Truck;
use App\Models\Tyre\TruckTyre;
use App\Models\Tyre\Tyre;
use App\Models\Tyre\TyreActivity;
use App\Models\Tyre\TyreAssignment;
use App\Models\Tyre\TyreBrand;
use Illuminate\Database\Seeder;

class TyreTrailerSeeder extends Seeder
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
                'reference' =>'1008016258',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ],                                      
            [
                'reference' =>'1008054863',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ], 
            [
                'reference' =>'1008017792',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ], 
            [
                'reference' =>'1007830670',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ], 
            [
                'reference' =>'1008016247',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ], 
            [
                'reference' =>'1008054866',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ], 
            [
                'reference' =>'1008017758',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ], 
            [
                'reference' =>'1007912225',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ], 
            [
                'reference' =>'1007912229',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ], 
            [
                'reference' =>'1008017793',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ], 
            [
                'reference' =>'1008016270',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ],  

            [
                'reference' =>'1008017796',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],  
            [
                'reference' =>'1008013998',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],
            [
                'reference' =>'1008016254',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],
            [
                'reference' =>'1007830668',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],

            [
                'reference' =>'1007923881',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],

            [
                'reference' =>'1008016249',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 723 DVK')->first()->id,
            ],

            [
                'reference' =>'1006707097',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 723 DVK')->first()->id,
            ],

            [
                'reference' =>'1007917708',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],

        
            [
                'reference' =>'1008017751',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],
            
            [
                'reference' =>'1008017784',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],
            
            [
                'reference' =>'1008017791',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],

            [
                'reference' =>'1007923882',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 723 DVK')->first()->id,
            ],

            [
                'reference' =>'1007917682',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],

            [
                'reference' =>'1008017782',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
            ],

            [
                'reference' =>'1008054856',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],

            [
                'reference' =>'1007830681',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],
            [
                'reference' =>'1008016264',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],
            [
                'reference' =>'1007922741',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],
            [
                'reference' =>'1006707110',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],
           
            [
                'reference' =>'1008016268',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],

            [
                'reference' =>'1007922748',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],

            [
                'reference' =>'1008016269',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],

            [
                'reference' =>'1008054855',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],

            [
                'reference' =>'1007917706',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 723 DVK')->first()->id,
            ],

            [
                'reference' =>'1008017787',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 723 DVK')->first()->id,
            ],
            [
                'reference' =>'1007912223',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],

            [
                'reference' =>'1008017759',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],
            [
                'reference' =>'1007923876',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],
            [
                'reference' =>'1008016262',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],

            [
                'reference' =>'1007912230',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],

            [
                'reference' =>'1007912226',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],

            [
                'reference' =>'11007917704',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],

            [
                'reference' =>'1008016256',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 723 DVK')->first()->id,
            ],
            [
                'reference' =>'1008016257',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],
            [
                'reference' =>'1008017781',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],

            [
                'reference' =>'1008016253',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
            ],

            [
                'reference' =>'1008017757',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],

            [
                'reference' =>'1008016263',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],


            [
                'reference' =>'1008016265',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
            ],

            [
                'reference' =>'1007889134',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],
            [
                'reference' =>'1007456830',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],
            [
                'reference' =>'1007456832',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],
           
            [
                'reference' =>'1007922717',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1008055270',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1007456827',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
            ],
            [
                'reference' =>'1007947606',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1007595827',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1007888890',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1007456823',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1006073367',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1007888887',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1008055310',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1008055266',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1007922734',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],
            [
                'reference' =>'1007595834',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','CHENGSHAN')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
            ],

            [
                'reference' =>'YA10077F611',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],

            [
                'reference' =>'YA10027H708',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],
            [
                'reference' =>'YA09307H703',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],

            [
                'reference' =>'YA10056F604',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],

            [
                'reference' =>'YA10046F614',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],

            [
                'reference' =>'YA09295H703',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],
            [
                'reference' =>'YA10115H716',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],

            [
                'reference' =>'YA09306F607',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],

            [
                'reference' =>'YA10026F605',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],

            [
                'reference' =>'YA09296H707',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],
            [
                'reference' =>'YA10126H710',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],
            [
                'reference' =>'YA10027F610',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],
            [
                'reference' =>'YA10035F604',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],

            [
                'reference' =>'YA10075F614',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],

          
            [
                'reference' =>'YA10017F609',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],

            [
                'reference' =>'YA09306F611',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],

            [
                'reference' =>'YA10075H703',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],

            [
                'reference' =>'YA10067H705',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],

          
            [
                'reference' =>'YA10027F603',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],
            [
                'reference' =>'B210107008575',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],

          
            [
                'reference' =>'K92149028',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
            ],
            [
                'reference' =>'JCZ60297',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'0',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                
            ],

            [
                'reference' =>'YA09285H712',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'0',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                
            ],

            [
                'reference' =>'YA09306H713',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],

            [
                'reference' =>'YA09295F604',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'0',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                
            ],

            [
                'reference' =>'A210116008520',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],

            [
                'reference' =>'C210105008506',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],

            [
                'reference' =>'YA10046F609',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],
            [
                'reference' =>'TT8305281917',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'0',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                
            ],

            [
                'reference' =>'YA10045F704',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
            ],

            [
                'reference' =>'YA09306F602',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'0',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                
            ],
            [
                'reference' =>'F02203909',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],
            [
                'reference' =>'YA10017H713',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],
            [
                'reference' =>'YA10026H706',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],
            [
                'reference' =>'YA09295F615',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],
            [
                'reference' =>'YA10056F611',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],
            [
                'reference' =>'YA09297F607',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],
            [
                'reference' =>'YA09297F601',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],
            [
                'reference' =>'YA09297F614',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],
            [
                'reference' =>'YA10046F606',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'0',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                
            ],

            [
                'reference' =>'YA10076H715',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
            ],

            [
                'reference' =>'YA10056H702',
                'position' =>'Trailer',
                'location' =>'1',
                'assign_reference' =>'1',
                'status' =>'1',
                'brand_id' => TyreBrand::where('brand','SUPERDOLL')->first()->id,
                'added_by' => '57',
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
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
                
                 'due_trailer'=>$truck->due_trailer - 1,
                 'due_tyre'=>$truck->due_tyre - 1,
                 'status'=>$status,
                 'staff'=>'1',
                ];
                TruckTyre::where('truck_id',$tyre->truck_id)->update($items);
                
                
                $lists=[
                    'position'=>'Trailer',
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
