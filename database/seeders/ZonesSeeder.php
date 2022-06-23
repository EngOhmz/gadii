<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ZonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Central Zone'],
            ['name' => 'Eastern'],
            ['name' => 'Lake'],
            ['name' => 'Northern'],
            ['name' => 'Southern'],
            ['name' => 'Southern Highlands'],
            ['name' => 'Western'],
        ];

        foreach ($items as $item) {
            \App\Models\Zone::updateOrCreate($item);
        }
    }
}
