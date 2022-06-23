<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\User;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        //
        $user = User::where('email','admin@gmail.com')->first();

        

        $permission = Permission::all();

        $permission = $permission->toArray();
        //dd($permission);
       
        $role = new Role;
        $role->slug  = 'superAdmin';
        $role->save();
        
        
         $role->refreshPermissions($permission);

       
        $user->roles()->attach($role->id);



    }
}
