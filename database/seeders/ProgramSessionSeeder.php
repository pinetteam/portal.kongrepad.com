<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Session\Session;
use Illuminate\Database\Seeder;

class ProgramSessionSeeder extends Seeder
{
    public function run(){
        Session::insert([
            [
                'program_id' => '2',
                'speaker_id' => '2',
                'title' => 'EGFR Mutasyonu Olan Küçük Hücreli Dışı Akciğer Kanserinde Tedavi Yaklaşımı',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:30',
                'questions' => 1,
                'questions_auto_start' => 1,
                'question_limit' => '1',
                'status' => 1,
                ],
            [
                'program_id' => '2',
                'speaker_id' => '3',
                'title' => 'KRAS, MET, RET, HER2, BRAF Mutasyonu Olan Hastalarda Tedavi',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:30',
                'questions' => 1,
                'questions_auto_start' => 1,
                'question_limit' => '1',
                'status' => 1,
            ],
            [
                'program_id' => '2',
                'speaker_id' => '4',
                'title' => 'Mutasyon Saptanmayan Küçük Hücreli Dışı Akciğer Kanserinde Tedavi',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:30',
                'questions' => 1,
                'questions_auto_start' => 1,
                'question_limit' => '1',
                'status' => 1,
            ],
            [
                'program_id' => '2',
                'speaker_id' => '5',
                'title' => 'Beyin Metastazı Olan Küçük Hücreli Dışı Akciğer Kanseri Hastalarında Tedavi Yaklaşımı',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:30',
                'questions' => 1,
                'questions_auto_start' => 1,
                'question_limit' => '1',
                'status' => 1,
            ],

        ]);
    }
}
