<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Session\Question\Question;
use Illuminate\Database\Seeder;

class MeetingHallProgramSessionQuestionSeeder extends Seeder
{
    public function run(): void
    {
        Question::insert([
            [
                'session_id' => '1',
                'questioner_id' => '1',
                'question' => 'Nadir görülen bir hasta ile karşılaştığınızda ilk bakacağınız kaynak hangisi olur?',
            ],
            [
                'session_id' => '1',
                'questioner_id' => '1',
                'question' => 'Hastalara kemoterapi dozunu planlarken uyguladığınız yöntem hangisidir?',
            ],
            [
                'survey_id' => '1',
                'questioner_id' => '1',
                'question' => 'Kemoterapi uygulama şeması ile karar veremediğin bir durum oldu. Mesela mesna uygulaması. Nasıl davranırsın?',
            ],
        ]);
    }
}
