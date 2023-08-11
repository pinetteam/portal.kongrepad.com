<?php

namespace Database\Seeders;

use App\Models\Meeting\Survey\Survey;
use App\Models\Meeting\Survey\Vote\Vote;
use Illuminate\Database\Seeder;

class SurveyVoteSeeder extends Seeder
{
    public function run(): void
    {
        Vote::insert([
            [
                'survey_id'=>'1',
                'question_id'=>'1',
                'option_id'=>'1',
                'participant_id'=>'1'
            ],
            [
                'survey_id'=>'1',
                'question_id'=>'1',
                'option_id'=>'1',
                'participant_id'=>'2'
            ],
            [
                'survey_id'=>'1',
                'question_id'=>'1',
                'option_id'=>'1',
                'participant_id'=>'3'
            ],
            [
                'survey_id'=>'1',
                'question_id'=>'1',
                'option_id'=>'1',
                'participant_id'=>'4'
            ],
            [
                'survey_id'=>'1',
                'question_id'=>'1',
                'option_id'=>'2',
                'participant_id'=>'5'
            ],
            [
                'survey_id'=>'1',
                'question_id'=>'1',
                'option_id'=>'2',
                'participant_id'=>'6'
            ],
            [
                'survey_id'=>'1',
                'question_id'=>'1',
                'option_id'=>'3',
                'participant_id'=>'7'
            ]
        ]);
    }
}
