<?php

namespace Database\Seeders;

use App\Models\Tyre\TyreBrand;
use Illuminate\Database\Seeder;

class TyreBrandSeeder extends Seeder
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
                'manufacturer' => 'CHENGSHAN',
                'brand' => 'CHENGSHAN',
                'unit' => 'pc',
                'quantity' => '80',
                'added_by' => '57',
    
              ],

              [
                'manufacturer' => 'SUPERDOLL',
                'brand' => 'SUPERDOLL',
                'unit' => 'pc',
                'quantity' => '70',
                'added_by' => '57',
              ],
             
            ];
    
            foreach ($data as $row) {
                TyreBrand::create($row);
            }
    }
}
