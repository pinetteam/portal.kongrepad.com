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
                'description' => 'Jüri: Abdurrahman Işıkdoğan, Ahmet Sezer, Evren Fidan, Tülay Akman, Erdinç Nayır',
                'on_vote' => 0,
                'status' => 1,
            ],[
                'sort_order' => '10',
                'program_id' => 30,
                'code' => 'debate',
                'title' => 'Yapay Zeka Gelecektir vs. Tehdittir',
                'description' => 'Jüri: Bülent Akıncı, Emel Sezer Yaman, İbrahim Vedat Bayoğlu, Şeyda Gündüz',
                'on_vote' => 0,
                'status' => 1,
            ],
        ]);
    }
}
