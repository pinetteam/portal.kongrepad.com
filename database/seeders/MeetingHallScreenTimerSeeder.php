<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Screen\Screen;
use App\Models\Meeting\Hall\Screen\Timer\Timer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MeetingHallScreenTimerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Timer::insert([
            [
                'screen_id' => '17',
            ],
            [
                'screen_id' => '18',
            ],
        ]);
    }
}
