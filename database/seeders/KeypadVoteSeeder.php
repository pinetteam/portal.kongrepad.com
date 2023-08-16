<?php

namespace Database\Seeders;


use App\Models\Meeting\Hall\Program\Session\Keypad\Vote\Vote;
use Illuminate\Database\Seeder;

class KeypadVoteSeeder extends Seeder
{
    public function run(): void
    {
        Vote::insert([
            [
                'keypad_id' => '1',
                'option_id' => '1',
                'participant_id' => '1'
            ],
            [
                'keypad_id' => '1',
                'option_id' => '1',
                'participant_id' => '2'
            ],
            [
                'keypad_id' => '1',
                'option_id' => '1',
                'participant_id' => '3'
            ],
            [
                'keypad_id' => '1',
                'option_id' => '1',
                'participant_id' => '4'
            ],
            [
                'keypad_id' => '1',
                'option_id' => '2',
                'participant_id' => '5'
            ],
            [
                'keypad_id' => '1',
                'option_id' => '2',
                'participant_id' => '6'
            ],
            [
                'keypad_id' => '1',
                'option_id' => '3',
                'participant_id' => '7'
            ],
            [
                'keypad_id' => '2',
                'option_id' => '1',
                'participant_id' => '1'
            ],
            [
                'keypad_id' => '2',
                'option_id' => '1',
                'participant_id' => '2'
            ],
            [
                'keypad_id' => '2',
                'option_id' => '1',
                'participant_id' => '3'
            ],
            [
                'keypad_id' => '2',
                'option_id' => '1',
                'participant_id' => '4'
            ],
            [
                'keypad_id' => '2',
                'option_id' => '2',
                'participant_id' => '5'
            ],
            [
                'keypad_id' => '2',
                'option_id' => '2',
                'participant_id' => '6'
            ],
            [
                'keypad_id' => '2',
                'option_id' => '3',
                'participant_id' => '7'
            ]
        ]);
    }
}
