<?php

namespace Database\Seeders;


use App\Models\Meeting\Hall\Program\Debate\Vote\Vote;
use Illuminate\Database\Seeder;

class DebateVoteSeeder extends Seeder
{
    public function run(): void
    {
        Vote::insert([
            [
                'debate_id' => '1',
                'team_id' => '1',
                'participant_id' => '1'
            ],
            [
                'debate_id' => '1',
                'team_id' => '1',
                'participant_id' => '2'
            ],
            [
                'debate_id' => '1',
                'team_id' => '1',
                'participant_id' => '3'
            ],
            [
                'debate_id' => '1',
                'team_id' => '1',
                'participant_id' => '4'
            ],
            [
                'debate_id' => '1',
                'team_id' => '2',
                'participant_id' => '5'
            ],
            [
                'debate_id' => '1',
                'team_id' => '2',
                'participant_id' => '6'
            ],
            [
                'debate_id' => '1',
                'team_id' => '2',
                'participant_id' => '7'
            ],

            [
                'debate_id' => '2',
                'team_id' => '5',
                'participant_id' => '1'
            ],
            [
                'debate_id' => '2',
                'team_id' => '5',
                'participant_id' => '2'
            ],
            [
                'debate_id' => '2',
                'team_id' => '6',
                'participant_id' => '3'
            ],
            [
                'debate_id' => '2',
                'team_id' => '6',
                'participant_id' => '4'
            ],
            [
                'debate_id' => '2',
                'team_id' => '5',
                'participant_id' => '5'
            ],
            [
                'debate_id' => '2',
                'team_id' => '6',
                'participant_id' => '6'
            ],
            [
                'debate_id' => '2',
                'team_id' => '6',
                'participant_id' => '7'
            ]
        ]);
    }
}
