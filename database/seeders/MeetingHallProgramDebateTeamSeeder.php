<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Debate\Team\Team;
use Illuminate\Database\Seeder;

class MeetingHallProgramDebateTeamSeeder extends Seeder
{
    public function run(){
        Team::insert([
            [
                'debate_id' => 1,
                'code' => 'panel-1-1',
                'title' => 'Team 1',
            ],
            [
                'debate_id' => 1,
                'code' => 'panel-1-1',
                'title' => 'Team 2',
            ],
        ]);
    }
}
