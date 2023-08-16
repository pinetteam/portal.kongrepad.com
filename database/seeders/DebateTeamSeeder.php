<?php

namespace Database\Seeders;


use App\Models\Meeting\Hall\Program\Debate\Team\Team;
use Illuminate\Database\Seeder;

class DebateTeamSeeder extends Seeder
{
    public function run(): void
    {
        Team::insert([
            [
                'debate_id' => '1',
                'title' => 'Team 1'
            ],
            [
                'debate_id' => '1',
                'title' => 'Team 2'
            ],
            [
                'debate_id' => '2',
                'title' => 'Team A'
            ],
            [
                'debate_id' => '2',
                'title' => 'Team B'
            ],
            [
                'debate_id' => '3',
                'title' => 'Team Red'
            ],
            [
                'debate_id' => '3',
                'title' => 'Team Blue'
            ],
        ]);
    }
}
