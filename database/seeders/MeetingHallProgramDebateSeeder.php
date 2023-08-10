<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Debate\Debate;
use Illuminate\Database\Seeder;

class MeetingHallProgramDebateSeeder extends Seeder
{
    public function run(){
        Debate::insert([
            [
                'sort_order' => '10',
                'program_id' => 11,
                'code' => 'panel-1-1',
                'title' => 'EGFR Mutasyonu Olan Küçük Hücreli Dışı Akciğer Kanserinde Tedavi Yaklaşımı',
                'on_vote' => 0,
                'status' => 1,
            ],
            [
                'sort_order' => '10',
                'program_id' => 11,
                'code' => 'panel-1-1',
                'title' => 'KCHG Mutasyonu Olan Küçük Hücreli Dışı Akciğer Kanserinde Tedavi Yaklaşımı',
                'on_vote' => 0,
                'status' => 1,
            ],
            [
                'sort_order' => '10',
                'program_id' => 11,
                'code' => 'panel-1-1',
                'title' => 'PTTT Mutasyonu Olan Küçük Hücreli Dışı Akciğer Kanserinde Tedavi Yaklaşımı',
                'on_vote' => 0,
                'status' => 1,
            ],
        ]);
    }
}
