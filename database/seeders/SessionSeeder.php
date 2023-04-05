<?php

namespace Database\Seeders;

use App\Models\Session\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Session::insert([
            [
                'meeting_hall_id' => '3',
                'sort_id' => '10',
                'code' => null,
                'title' => 'Açılış Töreni',
                'description' => 'Başak Oyan Uluç',
                'start_at' => '2022-10-22 09:00',
                'finish_at' => '2022-10-22 09:15',
                'type' => 'other',
                'status' => 1,
            ],
            [
                'meeting_hall_id' => '3',
                'sort_id' => '20',
                'code' => 'panel-1',
                'title' => 'Panel 1',
                'description' => null,
                'start_at' => '2022-10-22 09:15',
                'finish_at' => '2022-10-22 11:00',
                'type' => 'session',
                'status' => 1,
            ],
            [
                'meeting_hall_id' => '3',
                'sort_id' => '30',
                'code' => null,
                'title' => 'Kahve Molası',
                'description' => null,
                'start_at' => '2022-10-22 11:00',
                'finish_at' => '2022-10-22 11:20',
                'type' => 'break',
                'status' => 1,
            ],
            [
                'meeting_hall_id' => '3',
                'sort_id' => '40',
                'code' => 'sozel-bildiriler-1',
                'title' => 'Sözel Bildiriler 1',
                'description' => null,
                'start_at' => '2022-10-22 11:20',
                'finish_at' => '2022-10-22 12:00',
                'type' => 'session',
                'status' => 1,
            ],
            [
                'meeting_hall_id' => '3',
                'sort_id' => '50',
                'code' => 'takeda-uydu-sempozyumu',
                'title' => 'Takeda Uydu Sempozyumu',
                'description' => null,
                'start_at' => '2022-10-22 12:00',
                'finish_at' => '2022-10-22 12:30',
                'type' => 'session',
                'status' => 1,
            ],
            [
                'meeting_hall_id' => '3',
                'sort_id' => '60',
                'code' => null,
                'title' => 'Öğle Yemeği',
                'description' => null,
                'start_at' => '2022-10-22 12:30',
                'finish_at' => '2022-10-22 14:00',
                'type' => 'break',
                'status' => 1,
            ],
            [
                'meeting_hall_id' => '3',
                'sort_id' => '70',
                'code' => 'panel-2',
                'title' => 'Panel 2',
                'description' => null,
                'start_at' => '2022-10-22 14:00',
                'finish_at' => '2022-10-22 15:40',
                'type' => 'session',
                'status' => 1,
            ],
            [
                'meeting_hall_id' => '3',
                'sort_id' => '80',
                'code' => null,
                'title' => 'Kahve Molası',
                'description' => null,
                'start_at' => '2022-10-22 15:40',
                'finish_at' => '2022-10-22 16:00',
                'type' => 'break',
                'status' => 1,
            ],
            [
                'meeting_hall_id' => '3',
                'sort_id' => '90',
                'code' => 'novartis-uydu-sempozyumu',
                'title' => 'Novartis Uydu Sempozyumu',
                'description' => null,
                'start_at' => '2022-10-22 16:00',
                'finish_at' => '2022-10-22 16:30',
                'type' => 'session',
                'status' => 1,
            ],
            [
                'meeting_hall_id' => '3',
                'sort_id' => '100',
                'code' => 'sozel-bildiriler-2',
                'title' => 'Sözel Bildiriler 2',
                'description' => null,
                'start_at' => '2022-10-22 16:30',
                'finish_at' => '2022-10-22 17:10',
                'type' => 'session',
                'status' => 1,
            ],
            [
                'meeting_hall_id' => '3',
                'sort_id' => '110',
                'code' => 'debate',
                'title' => 'Debate',
                'description' => null,
                'start_at' => '2022-10-22 17:10',
                'finish_at' => '2022-10-22 18:40',
                'type' => 'session',
                'status' => 1,
            ],
        ]);
    }
}
