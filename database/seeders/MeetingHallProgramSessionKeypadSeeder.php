<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use Illuminate\Database\Seeder;

class MeetingHallProgramSessionKeypadSeeder extends Seeder
{
    public function run(): void
    {
        Keypad::insert([
            [
                'session_id' => '32',
                'keypad' => 'Evre II  adjuvan KHDAK olan hastalarınızda immünoterapi tedavisi uyguluyor musunuz?',
            ],
            [
                'session_id' => '32',
                'keypad' => 'Evre IIIa adjuvan KHDAK olan hastalarınızda immünoterapi tedavisi uyguluyor musunuz?',
            ],
            [
                'session_id' => '1',
                'keypad' => 'Kemoterapi uygulama şeması ile karar veremediğin bir durum oldu. Mesela mesna uygulaması. Nasıl davranırsın?',
            ],
        ]);
    }
}
