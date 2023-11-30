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
                'program_id' => 53,
                'chair_id' => 3,
                'type' => 'moderator',
            ],
            [
                'program_id' => 53,
                'chair_id' => 4,
                'type' => 'moderator',
            ],
            [
                'program_id' => 55,
                'chair_id' => 5,
                'type' => 'moderator',
            ],
            [
                'program_id' => 55,
                'chair_id' => 6,
                'type' => 'moderator',
            ],
            [
                'program_id' => 57,
                'chair_id' => 7,
                'type' => 'moderator',
            ],
            [
                'program_id' => 57,
                'chair_id' => 8,
                'type' => 'moderator',
            ],
            [
                'program_id' => 58,
                'chair_id' => 9,
                'type' => 'moderator',
            ],
            [
                'program_id' => 58,
                'chair_id' => 10,
                'type' => 'moderator',
            ],
            [
                'program_id' => 59,
                'chair_id' => 11,
                'type' => 'moderator',
            ],
        ]);
    }
}
