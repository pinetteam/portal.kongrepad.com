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
                'program_id' => 17,
                'code' => 'debate',
                'title' => 'Rezektable Küçük Hücreli Dışı Akciğer Kanserinde Neoadjuvan vs. Adjuvan Tedavi',
                'on_vote' => 0,
                'status' => 1,
            ],[
                'sort_order' => '10',
                'program_id' => 30,
                'code' => 'debate',
                'title' => 'Yapay Zeka Gelecektir vs. Tehdittir',
                'on_vote' => 0,
                'status' => 1,
            ],
        ]);
    }
}
