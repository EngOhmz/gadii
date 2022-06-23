<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
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
            'driver_name' => 'MUSSA ABDALLAH',
            'mobile_no' => '255656006743',
            'type' => 'owned',
            'driver_status' => 'Permanent Driver',
            'status' => '1',
            'available' => '1',
            'licence' =>'4000061233',
            'added_by' => '57',

          ],
          [
            'driver_name' => 'RIZIKI MMANDA',
            'mobile_no' => '255784173700',
            'type' => 'owned',
            'driver_status' => 'Permanent Driver',
            'status' => '1',
            'available' => '1',
            'licence' =>'4000432493',
            'added_by' => '57',
          ],
          [
            'driver_name' => 'HASSAN KIGUMI',
            'mobile_no' => '255714113326',
            'type' => 'owned',
            'driver_status' => 'Permanent Driver',
            'status' => '1',
            'available' => '1',
            'licence' =>'4000256452',
            'added_by' => '57',
          ],
          [
            'driver_name' => 'ABDALLAH  SEMBOJA',
            'mobile_no' => '255156398633',
            'type' => 'owned',
            'driver_status' => 'Permanent Driver',
            'status' => '1',
            'available' => '1',
            'licence' =>'4000778692',
            'added_by' => '57',
          ],
          [
            'driver_name' => 'JUMA SEIF JUMA',
            'mobile_no' => '255717009376',
            'type' => 'owned',
            'driver_status' => 'Permanent Driver',
            'status' => '1',
            'available' => '1',
            'licence' =>'4002880463',
            'added_by' => '57',
          ],
          [
            'driver_name' => 'MSHANGAO JAMES NG`INGO',
            'mobile_no' => '255712791772',
            'type' => 'owned',
            'driver_status' => 'Permanent Driver',
            'status' => '1',
            'available' => '1',
            'licence' =>'4000485344',
            'added_by' => '57',
          ],
          [
            'driver_name' => 'COSMAS SAMWEL MFALAMAGOHA',
            'mobile_no' => '255788633303',
            'type' => 'owned',
            'driver_status' => 'Permanent Driver',
            'status' => '1',
            'available' => '1',
            'licence' =>'4000021076',
            'added_by' => '57',
          ],
          [
            'driver_name' => 'SAID KULANGA',
            'mobile_no' => '255692515170',
            'type' => 'owned',
            'driver_status' => 'Permanent Driver',
            'status' => '1',
            'available' => '1',
            'licence' =>'4000073569',
            'added_by' => '57',
          ],
          [
            'driver_name' => 'HUSSEIN BAKARI',
            'mobile_no' => '255766956180',
            'type' => 'owned',
            'driver_status' => 'Permanent Driver',
            'status' => '1',
            'available' => '1',
            'licence' =>'4000967447',
            'added_by' => '57',
          ],
          [
            'driver_name' => 'HASSAN MKELO MBWANA',
            'mobile_no' => '255765470808',
            'type' => 'owned',
            'driver_status' => 'Permanent Driver',
            'status' => '1',
            'available' => '1',
            'licence' =>'4000226959',
            'added_by' => '57',
          ]
        ];

        foreach ($data as $row) {
        Driver::create($row);
        }

    }
}
