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
                'code' => 'panel-1-1',
                'title' => 'Team 1'
            ],
            [
                'debate_id' => '1',
                'code' => 'panel-1-1',
                'title' => 'Team 2'
            ],
        ]);
    }
}
