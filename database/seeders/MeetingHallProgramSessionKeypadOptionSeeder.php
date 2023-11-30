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
                'option' => 'Toraks BT ve abdomino pelvik MR',
            ],
            [
                'keypad_id' => '1',
                'option' => 'Toraks-abdominopelvik BT',
            ],
            [
                'keypad_id' => '1',
                'option' => 'PET-BT',
            ],
            [
                'keypad_id' => '1',
                'option' => 'Yukarıdaki görüntüleme yöntemine ek olarak endoskopik USG',
            ],
            [
                'keypad_id' => '1',
                'option' => 'Endoskopik USG',
            ],
            [
                'keypad_id' => '2',
                'option' => 'Evet',
            ],
            [
                'keypad_id' => '2',
                'option' => 'Hayır',
            ],
            [
                'keypad_id' => '3',
                'option' => 'MSI',
            ],
            [
                'keypad_id' => '3',
                'option' => 'HER2',
            ],
            [
                'keypad_id' => '3',
                'option' => 'PD-L1',
            ],
            [
                'keypad_id' => '3',
                'option' => 'Hepsi',
            ],
            [
                'keypad_id' => '3',
                'option' => 'Hiçbiri',
            ],
            [
                'keypad_id' => '4',
                'option' => 'Evet',
            ],
            [
                'keypad_id' => '4',
                'option' => 'Hayır',
            ],
            [
                'keypad_id' => '5',
                'option' => 'Cerrahi',
            ],
            [
                'keypad_id' => '5',
                'option' => 'Preoperatif kemoradyoterapi',
            ],
            [
                'keypad_id' => '5',
                'option' => 'Kemoradyoterapi',
            ],
            [
                'keypad_id' => '5',
                'option' => 'Perioperatif kemoterapi',
            ],
            [
                'keypad_id' => '5',
                'option' => 'Palyatif tedavi',
            ],
            [
                'keypad_id' => '6',
                'option' => 'FLOT',
            ],
            [
                'keypad_id' => '6',
                'option' => 'FOLFOX',
            ],
            [
                'keypad_id' => '6',
                'option' => 'Fluorourasil-sisplatin',
            ],
            [
                'keypad_id' => '6',
                'option' => 'Kapesitabin-oksaliplatin',
            ],
            [
                'keypad_id' => '6',
                'option' => 'Paklitaksel-karboplatin',
            ],
            [
                'keypad_id' => '7',
                'option' => 'Evet',
            ],
            [
                'keypad_id' => '7',
                'option' => 'Hayır',
            ],
            [
                'keypad_id' => '8',
                'option' => 'FLOT',
            ],
            [
                'keypad_id' => '8',
                'option' => 'Kemoradyoterapi',
            ],
            [
                'keypad_id' => '8',
                'option' => 'Fluorourasil+sisplatin',
            ],
            [
                'keypad_id' => '8',
                'option' => 'FLOT->kemoradyoterapi',
            ],
            [
                'keypad_id' => '8',
                'option' => 'Fluorourasil+sisplatin->kemoradyoterapi',
            ],
            [
                'keypad_id' => '9',
                'option' => 'Yüksek riskli hasta olduğu için yıllık endoskopi ve 6 ayda bir görüntüleme',
            ],
            [
                'keypad_id' => '9',
                'option' => 'Risk faktöründen bağımsız tüm hastalara yıllık endoskopi ve 6 ayda bir görüntüleme',
            ],
            [
                'keypad_id' => '9',
                'option' => '5 yıla kadar 6 ayda bir görüntüleme ve yıllık endoskopi',
            ],
            [
                'keypad_id' => '9',
                'option' => 'İlk 2 yıl relaps oranı fazla olduğu için 3 ayda bir görüntüleme sonrasında 6 ayda bir görüntüleme ve yıllık endoskopi',
            ],
            [
                'keypad_id' => '9',
                'option' => 'İlk 2 yıl relaps oranı fazla olduğu için 3 ayda bir görüntüleme sonrasında 6 ayda bir görüntüleme ve yıllık endoskopi ve 5 yıldan sonra semptom varsa görüntüleme ve endoskopi',
            ],
        ]);
    }
}
