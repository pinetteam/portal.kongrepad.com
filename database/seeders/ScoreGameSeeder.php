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
                'meeting_id' => '1',
                'start_at' => '2023-11-01 00:00',
                'finish_at' => '2023-11-05 23:59',
                'title' => 'Doğaya Can Ver',
                'status' => 1,
            ],
        ]);
    }
}
