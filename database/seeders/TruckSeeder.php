<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Truck;
use Illuminate\Database\Seeder;

class TruckSeeder extends Seeder
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
                'truck_name' => 'DAF',
                'reg_no' => 'T 739 DWZ',
                'type' => 'owned',
                'truck_type' => 'Horse',
                'driver' => Driver::where('driver_name','MUSSA ABDALLAH')->first()->id,
                'connect_horse' => '1',
                'connect_trailer' => '11',
                'location'=>'15',
                'added_by' => '57',
                'reading'=>'506916',
    
              ],

              [
                'truck_name' => 'DAF',
                'reg_no' => 'T 738 DWZ',
                'type' => 'owned',
                'truck_type' => 'Horse',
                'driver' => Driver::where('driver_name','RIZIKI MMANDA')->first()->id,
                'connect_horse' => '1',
                'connect_trailer' => '12',
                'location'=>'15',
                'added_by' => '57',
                'reading'=>'541853',
              ],
              [
                
                'truck_name' => 'DAF',
                'reg_no' => 'T 737 DWZ',
                'type' => 'owned',
                'truck_type' => 'Horse',
                'driver' => Driver::where('driver_name','HASSAN KIGUMI')->first()->id,
                'connect_horse' => '1',
                'connect_trailer' => '13',
                'location'=>'15',
                'added_by' => '57',
                'reading'=>'553259',
              ],
              [
                'truck_name' => 'DAF',
                'reg_no' => 'T 352 DWW',
                'type' => 'owned',
                'truck_type' => 'Horse',
                'driver' => Driver::where('driver_name','ABDALLAH  SEMBOJA')->first()->id,
                'connect_horse' => '1',
                'connect_trailer' => '14',
                'location'=>'15',
                'added_by' => '57',
                
              ],
              [
                
                'truck_name' => 'DAF',
                'reg_no' => 'T 350 DWW',
                'type' => 'owned',
                'truck_type' => 'Horse',
                'driver' => Driver::where('driver_name','JUMA SEIF JUMA')->first()->id,
                'connect_horse' => '1',
                'connect_trailer' => '15',
                'location'=>'15',
                'added_by' => '57',
                'reading'=>'630923',
              ],
              [   
                'truck_name' => 'DAF',      
                'reg_no' => 'T 344 DWW',
                'type' => 'owned',
                'truck_type' => 'Horse',
                'driver' => Driver::where('driver_name','MSHANGAO JAMES NG`INGO')->first()->id,
                'connect_horse' => '1',
                'connect_trailer' => '16',
                'location'=>'15',
                'added_by' => '57',
                'reading'=>'744369',
              ],
              [
                'truck_name' => 'DAF',
                'reg_no' => 'T 187 DWW',
                'type' => 'owned',
                'truck_type' => 'Horse',
                'driver' => Driver::where('driver_name','COSMAS SAMWEL MFALAMAGOHA')->first()->id,
                'connect_horse' => '1',
                'connect_trailer' => '17',
                'location'=>'15',
                'added_by' => '57',
              ],
              [
                'truck_name' => 'DAF',
                'reg_no' => 'T 183 DWW',
                'type' => 'owned',
                'truck_type' => 'Horse',
                'driver' => Driver::where('driver_name','SAID KULANGA')->first()->id,
                'connect_horse' => '1',
                'connect_trailer' => '18',
                'location'=>'15',
                'added_by' => '57',
               
              ],
              [
                'truck_name' => 'DAF',
                'reg_no' => 'T 127 DWW',
                'type' => 'owned',
                'truck_type' => 'Horse',
                'driver' => Driver::where('driver_name','HUSSEIN BAKARI')->first()->id,
                'connect_horse' => '1',
                'connect_trailer' => '19',
                'location'=>'15',
                'added_by' => '57',
                'reading'=>'546559',
              ],
              [
                'truck_name' => 'DAF',
                'reg_no' => 'T 898 DYL',
                'type' => 'owned',
                'truck_type' => 'Horse',
                'driver' => Driver::where('driver_name','HASSAN MKELO MBWANA')->first()->id,
                'connect_horse' => '1',
                'connect_trailer' => '20',
                'location'=>'15',
                'added_by' => '57',
              ],

              [
                'truck_name' => 'TRAILER',
                'truck_type' => 'Trailer',
                'connect_horse' => '1',
                'connect_trailer' => '1',
                'reg_no' => 'T 483 DVR',
                'type' => 'owned', 
                'location'=>'15',               
                'driver' => Driver::where('driver_name','MUSSA ABDALLAH')->first()->id,               
                'added_by' => '57',
                'reading'=>'506916',
    
              ],

              [
                'truck_name' => 'TRAILER',
                'truck_type' => 'Trailer',
                'connect_horse' => '2',
                'connect_trailer' => '1',
                'reg_no' => 'T 481 DVR',
                'type' => 'owned', 
                'location'=>'15',             
                'driver' => Driver::where('driver_name','RIZIKI MMANDA')->first()->id,
                'added_by' => '57',
                'reading'=>'541853',
              ],
              [
                
                'truck_name' => 'TRAILER',
                'truck_type' => 'Trailer',
                'connect_horse' => '3',
                'connect_trailer' => '1',
                'reg_no' => 'T 176 DVH',
                'type' => 'owned',
                'location'=>'15',
                'driver' => Driver::where('driver_name','HASSAN KIGUMI')->first()->id,
                'added_by' => '57',
                'reading'=>'553259',
              ],
              [
                'truck_name' => 'TRAILER',
                'truck_type' => 'Trailer',
                'connect_horse' => '4',
                'connect_trailer' => '1',
                'reg_no' => 'T 484 DVR',
                'type' => 'owned',
                'location'=>'15',
                'driver' => Driver::where('driver_name','ABDALLAH  SEMBOJA')->first()->id,
                'added_by' => '57',
                'reading'=>'320202',
              ],
              [
                
                'truck_name' => 'TRAILER',
                'truck_type' => 'Trailer',
                'connect_horse' => '5',
                'connect_trailer' => '1',
                'reg_no' => 'T 723 DVK',
                'type' => 'owned',
                'location'=>'15',
                'driver' => Driver::where('driver_name','JUMA SEIF JUMA')->first()->id,
                'added_by' => '57',
                'reading'=>'630923',
              ],
              [  
                'truck_name' => 'TRAILER',
                'truck_type' => 'Trailer',
                'connect_horse' => '6',
                'connect_trailer' => '1',       
                'reg_no' => 'T 168 DVH',
                'type' => 'owned',
                'location'=>'15',
                'driver' => Driver::where('driver_name','MSHANGAO JAMES NG`INGO')->first()->id,
                'added_by' => '57',
                'reading'=>'744369',
              ],
              [
                'truck_name' => 'TRAILER',
                'truck_type' => 'Trailer',
                'connect_horse' => '7',
                'connect_trailer' => '1',
                'reg_no' => 'T 485 DVR',
                'type' => 'owned',
                'location'=>'15',
                'driver' => Driver::where('driver_name','COSMAS SAMWEL MFALAMAGOHA')->first()->id,
                'added_by' => '57',
              ],
              [
                'truck_name' => 'TRAILER',
                'truck_type' => 'Trailer',
                'connect_horse' => '8',
                'connect_trailer' => '1',
                'reg_no' => 'T 169 DVH',
                'type' => 'owned',
                'location'=>'15',
                'driver' => Driver::where('driver_name','SAID KULANGA')->first()->id,
                'added_by' => '57',
              ],
              [
                'truck_name' => 'TRAILER',
                'truck_type' => 'Trailer',
                'connect_horse' => '9',
                'connect_trailer' => '1',
                'reg_no' => 'T 174 DVH',
                'type' => 'owned',
                'location'=>'15',
                'driver' => Driver::where('driver_name','HUSSEIN BAKARI')->first()->id,
                'added_by' => '57',
                'reading'=>'546559',
              ],
              [
                'truck_name' => 'TRAILER',
                'truck_type' => 'Trailer',
                'connect_horse' => '10',
                'connect_trailer' => '1',
                'reg_no' => 'T 163 DVH',
                'type' => 'owned',
                'location'=>'15',
                'driver' => Driver::where('driver_name','HASSAN MKELO MBWANA')->first()->id,
                'added_by' => '57',
              ],
            ];
    
            foreach ($data as $row) {
                Truck::create($row);
            }
    }
}
