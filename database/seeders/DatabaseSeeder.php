<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(ModuleSeeder::class);
        $this->call(PermisionSeeder::class);
       // $this->call(RolePermisionSeeder::class);
      //  $this->call(UserRoleSeeder::class);
        // $this->call(DriverSeeder::class);
        // $this->call(TruckSeeder::class);
        // $this->call(TruckInsuranceSeeder::class);
        // $this->call(TruckStickerSeeder::class);
        // $this->call(TruckTyreSeeder::class);
        // $this->call(TyreBrandSeeder::class);
        // $this->call(TyreDiffSeeder::class);
        // $this->call(TyreRearSeeder::class);
        // $this->call(TyreTrailerSeeder::class);

      //  $this->call(RegionSeeder::class);
       //$this->call(DistrictSeeder::class);
    }
}
