<?php

namespace Database\Seeders;

use App\Models\Meeting\ScoreGame\ScoreGame;
use Illuminate\Database\Seeder;

class ScoreGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScoreGame::insert([
            [
                'meeting_id' => '4',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:15',
                'title' => 'Pfizer',
                'status' => 1,
            ],
        ]);
    }
}
