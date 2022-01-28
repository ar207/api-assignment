<?php

namespace Database\Seeders;

use App\Models\DoctorSpeciality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $speciality = [
            [
                'name' => 'Allergy and immunology',
                'created_at' => currentDateTime(),
                'updated_at' => currentDateTime()
            ],
            [
                'name' => 'Urology',
                'created_at' => currentDateTime(),
                'updated_at' => currentDateTime()
            ],
            [
                'name' => 'Dermatology',
                'created_at' => currentDateTime(),
                'updated_at' => currentDateTime()
            ],
            [
                'name' => 'Cardiology',
                'created_at' => currentDateTime(),
                'updated_at' => currentDateTime()
            ],
        ];

        DoctorSpeciality::insert($speciality);
    }
}
