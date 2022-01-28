<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctor = [
            [
                'first_name' => 'Doctor',
                'last_name' => '1',
                'name' => 'Doctor 1',
                'speciality_id' => 1,
                'email' => 'doctor1@gmail.com',
                'password' => Hash::make(123),
                'phone' => 123456,
                'user_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Doctor',
                'last_name' => '2',
                'name' => 'Doctor 2',
                'speciality_id' => 1,
                'email' => 'doctor2@gmail.com',
                'password' => Hash::make(123),
                'phone' => 123456,
                'user_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Doctor',
                'last_name' => '3',
                'name' => 'Doctor 3',
                'speciality_id' => 2,
                'email' => 'doctor3@gmail.com',
                'password' => Hash::make(123),
                'phone' => 123456,
                'user_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Doctor',
                'last_name' => '4',
                'name' => 'Doctor 4',
                'speciality_id' => 2,
                'email' => 'doctor4@gmail.com',
                'password' => Hash::make(123),
                'phone' => 123456,
                'user_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Doctor',
                'last_name' => '5',
                'name' => 'Doctor 5',
                'speciality_id' => 3,
                'email' => 'doctor5@gmail.com',
                'password' => Hash::make(123),
                'phone' => 123456,
                'user_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Doctor',
                'last_name' => '6',
                'name' => 'Doctor 6',
                'speciality_id' => 3,
                'email' => 'doctor6@gmail.com',
                'password' => Hash::make(123),
                'phone' => 123456,
                'user_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Doctor',
                'last_name' => '7',
                'name' => 'Doctor 7',
                'speciality_id' => 4,
                'email' => 'doctor7@gmail.com',
                'password' => Hash::make(123),
                'phone' => 123456,
                'user_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Doctor',
                'last_name' => '8',
                'name' => 'Doctor 8',
                'speciality_id' => 4,
                'email' => 'doctor8@gmail.com',
                'password' => Hash::make(123),
                'phone' => 123456,
                'user_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        User::insert($doctor);
    }
}
