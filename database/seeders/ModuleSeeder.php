<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\SystemModule;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ['slug' => 'manage-dashboard','name'=>'Dashboard'],
            ['slug' => 'manage-farmer','name'=>'Farmer'],
            ['slug' => 'manage-farming','name'=>'Farming'],
            ['slug' => 'manage-orders','name'=>'Cargo management & Cargo Tracking'],
            ['slug' => 'manage-warehouse','name'=>'Warehouse'],
            ['slug' => 'manage-shop','name'=>'Sales & Purchase'],
            ['slug' => 'manage-fuel','name'=>'Fuel'],
            ['slug' => 'manage-access-control','name'=>'Access Control'], 
            ['slug' => 'manage-accounting','name'=>'Accounting'], 
            ['slug' => 'manage-gl-setup','name'=>'GL Setup'], 
            ['slug' => 'manage-transaction','name'=>'Transaction'], 
            ['slug' => 'manage-leave','name'=>'Leave'],
            ['slug' => 'manage-training','name'=>'Training'],  
            ['slug' => 'manage-inventory','name'=>'Inventory'], 
            ['slug' => 'manage-logistic','name'=>'Truck & Driver'],  
            ['slug' => 'manage-payroll','name'=>'Payroll'],
            ['slug' => 'manage-courier','name'=>'Courier'],
            
        ];
foreach ($data as $row) {
    SystemModule::updateOrCreate($row);
}
    }
}
