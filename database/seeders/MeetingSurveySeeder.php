<?php

namespace Database\Seeders;

use App\Models\Meeting\Survey\Survey;
use Illuminate\Database\Seeder;

class MeetingSurveySeeder extends Seeder
{
    public function run(): void
    {
        Survey::insert([
            [
                'meeting_id' => '4',
                'title' => 'Anket 1',
                'description' => 'Onkoloji Pratiğinde Prostat Kanserine Bağlı Androjen Deprivasyon Tedavisi(ADT) Alan Hastalarda Erkek Osteporozunun(OP) Önemi/ Farkındalık Anketi',
                'start_at' => '2023-11-01 10:30',
                'finish_at' => '2023-11-05 17:30',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'title' => 'Anket 2',
                'description' => 'Onkologların Klinik Uygulamalarında Farklılıklar',
                'start_at' => '2023-11-01 10:30',
                'finish_at' => '2023-11-05 17:30',
                'status' => 1
            ],
        ]);
    }
}
