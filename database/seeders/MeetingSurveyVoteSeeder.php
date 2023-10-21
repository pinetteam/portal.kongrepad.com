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
                'question_id' => '2',
                'option_id' => '2',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '3',
                'option_id' => '2',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '4',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '5',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '6',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '7',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '8',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '9',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '10',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '11',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '12',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '13',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
            [
                'survey_id' => '1',
                'question_id' => '14',
                'option_id' => '1',
                'participant_id' => '1',
                'created_at' => '2023-11-03 13:30:00'
            ],
        ]);
    }
}
