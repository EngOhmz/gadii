<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path() . "/json/countries.json";
        foreach (json_decode(file_get_contents($path), true) as $key => $value) {
            \App\Models\Country::updateOrCreate([
                'name' => $value['en_short_name'],
                'nationality' => $value['nationality']
            ]);
        }
    }
}
