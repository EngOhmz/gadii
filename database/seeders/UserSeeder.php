<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(\App\User::class, 100)->create();
        $data = [
            [
            'name' => 'superadmin',
            'address' => 'dar es salaam',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '0765454334',
            'remember_token' => Str::random(10),
            'status' => '1'
            ]
        ];
foreach ($data as $row) {
    User::updateOrCreate($row);
}
    }


}
