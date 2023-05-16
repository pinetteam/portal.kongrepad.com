<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Program\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Program::insert([
            [
                'meeting_hall_id' => '3',
                'sort_order' => '10',
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
                'sort_order' => '20',
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
                'sort_order' => '30',
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
                'sort_order' => '40',
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
                'sort_order' => '50',
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
                'sort_order' => '60',
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
                'sort_order' => '70',
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
                'sort_order' => '80',
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
                'sort_order' => '90',
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
                'sort_order' => '100',
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
                'sort_order' => '110',
                'code' => 'debate',
                'title' => 'Debate',
                'description' => null,
                'start_at' => '2022-10-22 17:10',
                'finish_at' => '2022-10-22 18:40',
                'type' => 'debate',
                'status' => 1,
            ],
        ]);
    }
}
