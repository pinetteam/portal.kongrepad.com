<?php

namespace Database\Seeders;

use App\Models\Meeting\Survey\Question\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        Question::insert([
            [
                'survey_id' => '1',
                'title' => 'Nadir görülen bir hasta ile karşılaştığınızda ilk bakacağınız kaynak hangisi olur?',
                'status' => 1
            ],
            [
                'survey_id' => '1',
                'title' => 'Hastalara kemoterapi dozunu planlarken uyguladığınız yöntem hangisidir?',
                'status' => 1
            ],
            [
                'survey_id' => '1',
                'title' => 'Kemoterapi uygulama şeması ile karar veremediğin bir durum oldu. Mesela mesna uygulaması. Nasıl davranırsın?',
                'status' => 1
            ],
            [
                'survey_id' => '4',
                'title' => 'Nadir görülen bir hasta ile karşılaştığınızda ilk bakacağınız kaynak hangisi olur?',
                'status' => 1
            ],
            [
                'survey_id' => '4',
                'title' => 'Hastalara kemoterapi dozunu planlarken uyguladığınız yöntem hangisidir?',
                'status' => 1
            ],
            [
                'survey_id' => '4',
                'title' => 'Kemoterapi uygulama şeması ile karar veremediğin bir durum oldu. Mesela mesna uygulaması. Nasıl davranırsın?',
                'status' => 1
            ],

            ])
        ;}
}
