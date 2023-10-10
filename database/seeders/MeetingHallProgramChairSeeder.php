<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Chair\Chair;
use Illuminate\Database\Seeder;

class MeetingHallProgramChairSeeder extends Seeder
{
    public function run(): void
    {
        Chair::insert([
            [
                'program_id' => 8,
                'chair_id' => '108',
            ],
            [
                'program_id' => 8,
                'chair_id' => '109',
            ],
            [
                'program_id' => 8,
                'chair_id' => '110',
            ],
            [
                'program_id' => 9,
                'chair_id' => '111',
            ],
            [
                'program_id' => 11,
                'chair_id' => '112',
            ],
            [
                'program_id' => 11,
                'chair_id' => '113',
            ],
            [
                'program_id' => 13,
                'chair_id' => '114',
            ],
            [
                'program_id' => 14,
                'chair_id' => '115',
            ],
            [
                'program_id' => 14,
                'chair_id' => '116',
            ],
            [
                'program_id' => 15,
                'chair_id' => '117',
            ],
            [
                'program_id' => 17,
                'chair_id' => '118',
            ],
            [
                'program_id' => 18,
                'chair_id' => '119',
            ],
            [
                'program_id' => 18,
                'chair_id' => '120',
            ],
            [
                'program_id' => 18,
                'chair_id' => '121',
            ],
        ]);
    }
}
