<?php

namespace Database\Seeders;

use App\Models\Meeting\Meeting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
                'code' => Str::uuid()->toString(),
                'title' => 'IOK 2020',
                'start_at' => '2020-01-01',
                'finish_at' => '2020-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '1',
                'code' => Str::uuid()->toString(),
                'title' => 'IOK 2021',
                'start_at' => '2021-01-01',
                'finish_at' => '2021-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '1',
                'code' => Str::uuid()->toString(),
                'title' => 'IOK 2022',
                'start_at' => '2022-01-01',
                'finish_at' => '2022-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '1',
                'code' => Str::uuid()->toString(),
                'title' => 'IOK 2023',
                'start_at' => '2023-01-01',
                'finish_at' => '2023-12-31',
                'status' => 1,
            ],
        ]);
        Meeting::insert([
            [
                'customer_id' => '2',
                'code' => Str::uuid()->toString(),
                'title' => 'PNK 2020',
                'start_at' => '2020-01-01',
                'finish_at' => '2020-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '2',
                'code' => Str::uuid()->toString(),
                'title' => 'PNK 2021',
                'start_at' => '2021-01-01',
                'finish_at' => '2021-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '2',
                'code' => Str::uuid()->toString(),
                'title' => 'PNK 2022',
                'start_at' => '2022-01-01',
                'finish_at' => '2022-12-31',
                'status' => 1,
            ],
            [
                'customer_id' => '2',
                'code' => Str::uuid()->toString(),
                'title' => 'PNK 2023',
                'start_at' => '2023-01-01',
                'finish_at' => '2023-12-31',
                'status' => 1,
            ],
        ]);
    }
}
