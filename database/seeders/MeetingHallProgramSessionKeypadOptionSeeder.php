<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use Illuminate\Database\Seeder;

class MeetingHallProgramSessionKeypadOptionSeeder extends Seeder
{
    public function run(): void
    {
        Option::insert([
            [
                'keypad_id' => '1',
                'option' => 'Evet',
            ],
            [
                'keypad_id' => '1',
                'option' => 'Hayır',
            ],
            [
                'keypad_id' => '2',
                'option' => 'Evet',
            ],
            [
                'keypad_id' => '2',
                'option' => 'Hayır',
            ],
        ]);
    }
}
