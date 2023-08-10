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
                'session_id' => '1',
                'keypad' => 'Nadir görülen bir hasta ile karşılaştığınızda ilk bakacağınız kaynak hangisi olur?',
            ],
            [
                'session_id' => '1',
                'keypad' => 'Hastalara kemoterapi dozunu planlarken uyguladığınız yöntem hangisidir?',
            ],
            [
                'session_id' => '1',
                'keypad' => 'Kemoterapi uygulama şeması ile karar veremediğin bir durum oldu. Mesela mesna uygulaması. Nasıl davranırsın?',
            ],


        ]);
    }
}
