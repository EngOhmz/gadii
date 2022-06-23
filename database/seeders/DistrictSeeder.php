<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path() . "/json/districts.json";
        foreach (json_decode(file_get_contents($path), true) as $key => $value) {
            \App\Models\District::updateOrCreate(['id' => $value['id'], 'region_id' => $value['region_id'], 'name' => $value['name']]);
        }
    }
}
