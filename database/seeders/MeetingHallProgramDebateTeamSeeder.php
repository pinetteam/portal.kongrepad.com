<?php

namespace Database\Seeders;


use App\Models\Meeting\Hall\Program\Debate\Team\Team;
use Illuminate\Database\Seeder;

class MeetingHallProgramDebateTeamSeeder extends Seeder
{
    public function run(): void
    {
        Team::insert([
            [
                'debate_id' => '1',
                'title' => 'Neoadjuvan KT'
            ],
            [
                'debate_id' => '1',
                'title' => 'Adjuvan KT'
            ],
            [
                'debate_id' => '2',
                'title' => 'Gelecektir'
            ],
            [
                'debate_id' => '2',
                'title' => 'Tehdittir'
            ],
        ]);
    }
}
