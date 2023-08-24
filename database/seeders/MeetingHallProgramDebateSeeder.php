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
                'code' => 'debate',
                'title' => 'KHDAK’NDE İMMÜNOTERAPİ NEOADJUVANDA MI ADJUVANDA MI?',
                'on_vote' => 0,
                'status' => 1,
            ],[
                'sort_order' => '10',
                'program_id' => 22,
                'code' => 'debate',
                'title' => ' ÖZEFAGOGASTRİK BİLEŞKE TÜMÖRLERİNDE NEOADJUVAN KT VS. KRT?',
                'on_vote' => 0,
                'status' => 1,
            ],
        ]);
    }
}
