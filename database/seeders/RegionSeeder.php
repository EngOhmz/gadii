<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path() . "/json/regions.json";
        foreach (json_decode(file_get_contents($path), true) as $value) {
            \App\Models\Region::updateOrCreate(['id' => $value['id'], 'zone_id' => $value['zone_id'], 'name' => $value['name']]);
        }
    }
}
