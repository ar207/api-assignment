<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'first_name' => 'Admin',
                'last_name' => 'user',
                'name' => 'Admin user',
                'user_type' => 0,
                'email' => 'admin@gmail.com',
                'phone' => 123456,
                'password' => Hash::make(123),
                'created_at' => currentDateTime(),
                'updated_at' => currentDateTime(),
            ],
            [
                'first_name' => 'Doctor',
                'last_name' => 'user',
                'name' => 'Doctor user',
                'user_type' => 1,
                'email' => 'doctor@gmail.com',
                'phone' => 123456,
                'password' => Hash::make(123),
                'created_at' => currentDateTime(),
                'updated_at' => currentDateTime(),
            ],
            [
                'first_name' => 'Local',
                'last_name' => 'user',
                'name' => 'Local user',
                'user_type' => 2,
                'email' => 'localuser@gmail.com',
                'phone' => 123456,
                'password' => Hash::make(123),
                'created_at' => currentDateTime(),
                'updated_at' => currentDateTime(),
            ],
        ];

        DB::table('users')->insert($user);
    }
}
