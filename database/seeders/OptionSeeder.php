<?php

namespace Database\Seeders;
use App\Models\Meeting\Survey\Question\Option\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run(): void
    {
        Option::insert([
            [
                'survey_id' => '1',
                'question_id' => '1',
                'option' => 'Uptodate',
                'status' => 1
            ],
            [
                'survey_id' => '1',
                'question_id' => '1',
                'option' => 'Nccn',
                'status' => 1
            ],
            [
                'survey_id' => '1',
                'question_id' => '1',
                'option' => 'Esmo',
                'status' => 1
            ],
            [
                'survey_id' => '1',
                'question_id' => '1',
                'option' => 'Pubmed',
                'status' => 1
            ],
            [
                'survey_id' => '1',
                'question_id' => '2',
                'option' => 'BSA ne çıkarsa aynı dozda veririm',
                'status' => 1
            ],
            [
                'survey_id' => '1',
                'question_id' => '2',
                'option' => 'Yan etkileri yönetmesi daha kolay olduğunu düşündüğüm için dozları biraz modifiye ederim.',
                'status' => 1
            ],
            [
                'survey_id' => '1',
                'question_id' => '2',
                'option' => 'Her hastaya BSA 1,5 olacak şekilde veririm.',
                'status' => 1
            ],
            [
                'survey_id' => '1',
                'question_id' => '2',
                'option' => 'Uygulanacak ilaca göre yaklaşımım değişir.',
                'status' => 1
            ],

        ]);
    }
}
