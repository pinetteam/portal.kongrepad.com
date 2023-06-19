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
                'question_id' => '1',
                'title' => 'Uptodate',
                'status' => 1
            ],
            [
                'question_id' => '1',
                'title' => 'Nccn',
                'status' => 1
            ],
            [
                'question_id' => '1',
                'title' => 'Esmo',
                'status' => 1
            ],
            [
                'question_id' => '1',
                'title' => 'Pubmed',
                'status' => 1
            ],
            [
                'question_id' => '2',
                'title' => 'BSA ne çıkarsa aynı dozda veririm',
                'status' => 1
            ],
            [
                'question_id' => '2',
                'title' => 'Yan etkileri yönetmesi daha kolay olduğunu düşündüğüm için dozları biraz modifiye ederim.',
                'status' => 1
            ],
            [
                'question_id' => '2',
                'title' => 'Her hastaya BSA 1,5 olacak şekilde veririm.',
                'status' => 1
            ],
            [
                'question_id' => '2',
                'title' => 'Uygulanacak ilaca göre yaklaşımım değişir.',
                'status' => 1
            ],

            ]);
    }
}
