<?php

namespace Database\Seeders;

use App\Models\Meeting\Survey\Vote\Vote;
use Illuminate\Database\Seeder;

class MeetingSurveyVoteSeeder extends Seeder
{
    public function run(): void
    {
        Vote::insert([
            [
                'survey_id' => '1',
                'question_id' => '1',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '1',
                'option_id' => '1',
                'participant_id' => '2',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '1',
                'option_id' => '2',
                'participant_id' => '3',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '1',
                'option_id' => '3',
                'participant_id' => '4',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '1',
                'option_id' => '4',
                'participant_id' => '5',
                'created_at' => '2023-11-03 13:30:00'
            ],
        ]);
    }
}
