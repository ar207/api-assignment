<?php

namespace Database\Seeders;

use App\Models\DoctorTimeSlot;
use Illuminate\Database\Seeder;

class DoctorTimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeSlot = [
            [
                "user_id" => 4,
                "from" => '10:00',
                "to" => '12:00',
                "date" => "2022-01-28",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
            [
                "user_id" => 4,
                "from" => '14:00',
                "to" => '18:00',
                "date" => "2022-01-28",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
            [
                "user_id" => 6,
                "from" => '09:00',
                "to" => '12:00',
                "date" => "2022-01-28",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
            [
                "user_id" => 6,
                "from" => '14:00',
                "to" => '20:00',
                "date" => "2022-01-28",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
            [
                "user_id" => 8,
                "from" => '11:00',
                "to" => '13:00',
                "date" => "2022-01-28",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
            [
                "user_id" => 8,
                "from" => '15:00',
                "to" => '19:00',
                "date" => "2022-01-28",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],[
                "user_id" => 4,
                "from" => '10:00',
                "to" => '12:00',
                "date" => "2022-01-29",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
            [
                "user_id" => 4,
                "from" => '14:00',
                "to" => '18:00',
                "date" => "2022-01-29",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
            [
                "user_id" => 6,
                "from" => '09:00',
                "to" => '12:00',
                "date" => "2022-01-29",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
            [
                "user_id" => 6,
                "from" => '14:00',
                "to" => '20:00',
                "date" => "2022-01-29",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
            [
                "user_id" => 8,
                "from" => '11:00',
                "to" => '13:00',
                "date" => "2022-01-29",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
            [
                "user_id" => 8,
                "from" => '15:00',
                "to" => '19:00',
                "date" => "2022-01-29",
                "created_at" => currentDateTime(),
                "updated_at" => currentDateTime(),
            ],
        ];

        DoctorTimeSlot::insert($timeSlot);
    }
}
