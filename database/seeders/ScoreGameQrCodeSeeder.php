<?php

namespace Database\Seeders;

use App\Models\Meeting\ScoreGame\QRCode\QRCode;
use App\Models\Meeting\ScoreGame\ScoreGame;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ScoreGameQrCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QRCode::insert([
            [
                'score_game_id' => '1',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:15',
                'title' => 'Pfizer',
                'point' => 10,
                'code' => Str::uuid()->toString(),
                'status' => 1,
            ],
            [
                'score_game_id' => '1',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:15',
                'title' => 'Gladio',
                'point' => 15,
                'code' => Str::uuid()->toString(),
                'status' => 1,
            ],
        ]);
    }
}
