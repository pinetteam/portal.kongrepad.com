<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Session\Session;
use Illuminate\Database\Seeder;

class MeetingHallProgramSessionSeeder extends Seeder
{
    public function run(): void
    {
        Session::insert([
            [
                'sort_order' => '10',
                'program_id' => 2,
                'speaker_id' => 3,
                'code' => 'panel-1-1',
                'title' => 'EGFR Mutasyonu Olan Küçük Hücreli Dışı Akciğer Kanserinde Tedavi Yaklaşımı',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:30',
                'on_air' => 0,
                'questions_limit' => 3,
                'questions_allowed' => 0,
                'questions_auto_start' => 0,
                'is_questions_started' => 0,
                'status' => 1,
            ],
            [
                'sort_order' => '20',
                'program_id' => 2,
                'speaker_id' => 4,
                'code' => 'panel-1-2',
                'title' => 'KRAS, MET, RET, HER2, BRAF Mutasyonu Olan Hastalarda Tedavi',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:30',
                'on_air' => 0,
                'questions_limit' => 3,
                'questions_allowed' => 0,
                'questions_auto_start' => 0,
                'is_questions_started' => 0,
                'status' => 1,
            ],
            [
                'sort_order' => '30',
                'program_id' => 2,
                'speaker_id' => 5,
                'code' => 'panel-1-3',
                'title' => 'Mutasyon Saptanmayan Küçük Hücreli Dışı Akciğer Kanserinde Tedavi',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:30',
                'on_air' => 0,
                'questions_limit' => 3,
                'questions_allowed' => 0,
                'questions_auto_start' => 0,
                'is_questions_started' => 0,
                'status' => 1,
            ],
            [
                'sort_order' => '40',
                'program_id' => 2,
                'speaker_id' => 6,
                'code' => 'panel-1-4',
                'title' => 'Beyin Metastazı Olan Küçük Hücreli Dışı Akciğer Kanseri Hastalarında Tedavi Yaklaşımı',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:30',
                'on_air' => 0,
                'questions_limit' => 3,
                'questions_allowed' => 0,
                'questions_auto_start' => 0,
                'is_questions_started' => 0,
                'status' => 1,
            ],
        ]);
    }
}
