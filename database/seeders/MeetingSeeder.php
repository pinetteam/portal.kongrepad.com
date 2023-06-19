<?php

namespace Database\Seeders;

use App\Models\Meeting\Meeting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meeting::insert([
            [
                'customer_id' => '1',
                'code' => 'iok-2020',
                'title' => 'IOK 2020',
                'start_at' => '2020-01-01',
                'finish_at' => '2020-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '1',
                'code' => 'iok-2021',
                'title' => 'IOK 2021',
                'start_at' => '2021-01-01',
                'finish_at' => '2021-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '1',
                'code' => 'iok-2022',
                'title' => 'IOK 2022',
                'start_at' => '2022-01-01',
                'finish_at' => '2022-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '2',
                'code' => 'iok-2020',
                'title' => 'IOK 2020',
                'start_at' => '2020-01-01',
                'finish_at' => '2020-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '2',
                'code' => 'iok-2021',
                'title' => 'IOK 2021',
                'start_at' => '2021-01-01',
                'finish_at' => '2021-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '2',
                'code' => 'iok-2022',
                'title' => 'IOK 2022',
                'start_at' => '2022-01-01',
                'finish_at' => '2022-12-31',
                'status' => 1,
            ],
        ]);
    }
}
