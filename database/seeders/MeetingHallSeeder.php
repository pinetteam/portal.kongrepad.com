<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Hall;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MeetingHallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hall::insert([
            [
                'meeting_id' => '1',
                'code' => Str::uuid()->toString(),
                'title' => 'Kurs Salonu-1',
                'show_on_session' => 0,
                'show_on_view_program' => 1,
                'show_on_ask_question' => 0,
                'show_on_send_mail' => 0,
                'status' => 1,
            ],
            [
                'meeting_id' => '1',
                'code' => Str::uuid()->toString(),
                'title' => 'Kurs Salonu-2',
                'show_on_session' => 0,
                'show_on_view_program' => 1,
                'show_on_ask_question' => 0,
                'show_on_send_mail' => 0,
                'status' => 1,
            ],
            [
                'meeting_id' => '1',
                'code' => Str::uuid()->toString(),
                'title' => 'Ana Salon',
                'show_on_session' => 1,
                'show_on_view_program' => 1,
                'show_on_ask_question' => 1,
                'show_on_send_mail' => 1,
                'status' => 1,
            ],
            [
                'meeting_id' => '1',
                'code' => Str::uuid()->toString(),
                'title' => 'Sözel Bildiriler',
                'show_on_session' => 0,
                'show_on_view_program' => 1,
                'show_on_ask_question' => 0,
                'show_on_send_mail' => 0,
                'status' => 1,
            ],
            [
                'meeting_id' => '1',
                'code' => Str::uuid()->toString(),
                'title' => 'Yan Salon',
                'show_on_session' => 0,
                'show_on_view_program' => 1,
                'show_on_ask_question' => 0,
                'show_on_send_mail' => 0,
                'status' => 1,
            ],
            [
                'meeting_id' => '1',
                'code' => Str::uuid()->toString(),
                'title' => 'Ana Salon',
                'show_on_session' => 0,
                'show_on_view_program' => 1,
                'show_on_ask_question' => 0,
                'show_on_send_mail' => 0,
                'status' => 1,
            ],
        ]);
    }
}
