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
                'session_id' => '121',
                'keypad' => 'Bu aşamada evreleme için hangi görüntüleme yöntemini tercih edersiniz?',
            ],
            [
                'session_id' => '121',
                'keypad' => 'Bu aşamada endoskopik USG yaptırmak gerekir mi?',
            ],
            [
                'session_id' => '121',
                'keypad' => 'Bu aşamada patoloji raporunda hangi ek verileri görmek istersiniz?',
            ],
            [
                'session_id' => '121',
                'keypad' => 'Bu aşamada laparoskopik sitoloji yapmak gerekir mi?',
            ],
            [
                'session_id' => '121',
                'keypad' => 'Bu aşamada tedavi seçeneğiniz ne olur?',
            ],
            [
                'session_id' => '121',
                'keypad' => 'Bu aşamada perioperatif tedavi seçiminiz hangisi olur?',
            ],
            [
                'session_id' => '121',
                'keypad' => 'Bu aşamada patoloji raporundaki verilere dayanarak D2 lenf nodu diseksiyonu için yeterli veri var mıdır?',
            ],
            [
                'session_id' => '121',
                'keypad' => 'Bu aşamada tedavi seçiminiz ne olur?',
            ],
            [
                'session_id' => '121',
                'keypad' => 'Vitamin B12, vitamin D ve demir parametre takibine ek olarak hastanın tedavi sonrası takibi nasıl olmalıdır?',
            ],
        ]);
    }
}
