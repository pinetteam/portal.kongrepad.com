<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Session\Question\Question;
use Illuminate\Database\Seeder;

class SessionQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::insert([
            [
                'session_id' => '1',
                'owner_id' => '1',
                'title' => 'Nadir görülen bir hasta ile karşılaştığınızda ilk bakacağınız kaynak hangisi olur?',
                'status' => 1
            ],
            [
                'session_id' => '1',
                'owner_id' => '1',
                'title' => 'Hastalara kemoterapi dozunu planlarken uyguladığınız yöntem hangisidir?',
                'status' => 1
            ],
        ]);

    }
}
