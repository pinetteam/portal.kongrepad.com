<?php

namespace Database\Seeders;

use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usernames = [
            Str::uuid()->toString(),
            Str::uuid()->toString(),
            Str::uuid()->toString(),
            Str::uuid()->toString(),
            Str::uuid()->toString(),
        ];
        Participant::insert([
            [
                'meeting_id' => '3',
                'username' => $usernames[0],
                'qr_code' => \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($usernames[0]),
                'title' => '',
                'first_name' => 'Ali Erdem',
                'last_name' => 'Sunar',
                'organisation' => 'Pfizer',
                'identification_number' => '12345678901',
                'email' => 'alierdemsunar@kongrepad.com',
                'phone_country_id' => '223',
                'phone' => '5308266897',
                'password' => '123456',
                'type' => 'agent',
                'gdpr_consent' => 1,
                'status' => 1,
            ],
            [
                'meeting_id' => '3',
                'username' => $usernames[1],
                'qr_code' => \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($usernames[1]),
                'title' => '',
                'first_name' => 'Erkan',
                'last_name' => 'Özkan',
                'organisation' => 'Kocaeli Üniversitesi',
                'identification_number' => '12345678902',
                'email' => 'erkanozkan@kongrepad.com',
                'phone_country_id' => '223',
                'phone' => '5326359203',
                'password' => '123456',
                'type' => 'attendee',
                'gdpr_consent' => 1,
                'status' => 1,
            ],
            [
                'meeting_id' => '3',
                'username' => $usernames[2],
                'qr_code' => \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($usernames[2]),
                'title' => 'Prof. Dr.',
                'first_name' => 'İsmail',
                'last_name' => 'Çelik',
                'organisation' => 'Hacettepe Üniversitesi',
                'identification_number' => '12345678903',
                'email' => 'ismailcelik@kongrepad.com',
                'phone_country_id' => '223',
                'phone' => '5323563185',
                'password' => '123456',
                'type' => 'attendee',
                'gdpr_consent' => 1,
                'status' => 1,
            ],
            [
                'meeting_id' => '3',
                'username' => $usernames[3],
                'qr_code' => \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($usernames[3]),
                'title' => '',
                'first_name' => 'Uğur',
                'last_name' => 'Erdoğan',
                'organisation' => 'Karadeniz Teknik Üniversitesi',
                'identification_number' => '12345678904',
                'email' => 'ugurerdogan@kongrepad.com',
                'phone_country_id' => '223',
                'phone' => '5353258705',
                'password' => '123456',
                'type' => 'attendee',
                'gdpr_consent' => 1,
                'status' => 1,
            ],
            [
                'meeting_id' => '3',
                'username' => $usernames[4],
                'qr_code' => \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($usernames[4]),
                'title' => '',
                'first_name' => 'Mert',
                'last_name' => 'Demirbağ',
                'organisation' => 'Ankara Üniversitesi',
                'identification_number' => '12345678905',
                'email' => 'mertdemirbag@kongrepad.com',
                'phone_country_id' => '223',
                'phone' => '5531304177',
                'password' => '123456',
                'type' => 'team',
                'gdpr_consent' => 1,
                'status' => 1,
            ],
        ]);
    }
}
