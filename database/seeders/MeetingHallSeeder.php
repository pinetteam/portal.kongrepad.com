<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\MeetingHall;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeetingHallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeetingHall::insert([
            [
                'meeting_id' => '1',
                'title' => 'IOK 2020 Main Hall',
                'status' => 1,
            ],
            [
                'meeting_id' => '2',
                'title' => 'IOK 2021 Main Hall',
                'status' => 1,
            ],
            [
                'meeting_id' => '3',
                'title' => 'IOK 2022 Main Hall',
                'status' => 1,
            ],
        ]);
    }
}
