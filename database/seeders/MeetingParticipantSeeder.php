<?php

namespace Database\Seeders;

use App\Models\Meeting\Participant\Participant;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MeetingParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker1 = Factory::create();
        $username1 = Str::uuid()->toString();
        Participant::insert([
            [
                'meeting_id' => '1',
                'username' => '344c1051-b28a-4934-8159-b12983258f86',
                'title' => null,
                'first_name' => "KongrePad",
                'last_name' => "Developer",
                'identification_number' => null,
                'organisation' => "Pinet Bilişim A.Ş.",
                'email' => "info@pinet.com.tr",
                'phone_country_id' => '223',
                'phone' => "5308266897",
                'password' => '344c1051-b28a-4934-8159-b12983258f86',
                'last_login_ip' => $faker1->ipv4,
                'last_login_agent' => $faker1->userAgent,
                'last_login_datetime' => date('Y-m-d H:i:s'),
                'last_activity' => now(),
                'type' => 'attendee',
                'enrolled' => 0,
                'gdpr_consent' => 0,
                'status' => 1,
            ],
        ]);
    }
}
