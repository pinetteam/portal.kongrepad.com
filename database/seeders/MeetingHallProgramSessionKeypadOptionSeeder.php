<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use Illuminate\Database\Seeder;

class MeetingHallProgramSessionKeypadOptionSeeder extends Seeder
{
    public function run(): void
    {
        Option::insert([
            [
                'keypad_id' => '1',
                'option' => 'Uptodate',
            ],
            [
                'keypad_id' => '1',
                'option' => 'Nccn',
            ],
            [
                'keypad_id' => '1',
                'option' => 'Esmo',
            ],
            [
                'keypad_id' => '1',
                'option' => 'Pubmed',
            ],
            [
                'keypad_id' => '2',
                'option' => 'BSA ne çıkarsa aynı dozda veririm',
            ],
            [
                'keypad_id' => '2',
                'option' => 'Yan etkileri yönetmesi daha kolay olduğunu düşündüğüm için dozları biraz modifiye ederim.',
            ],
            [
                'keypad_id' => '2',
                'option' => 'Her hastaya BSA 1,5 olacak şekilde veririm.',
            ],
            [
                'keypad_id' => '2',
                'option' => 'Uygulanacak ilaca göre yaklaşımım değişir.',
            ],


        ]);
    }
}
