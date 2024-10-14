<?php

namespace Database\Seeders;

use App\Models\Meeting\Meeting;
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
                'id' => '1',
                'customer_id' => '1',
                'code' => 'iok-2024',
                'title' => '8. Ulusal İmmunoterapi ve Onkoloji Kongresi',
                'type' => 'standard',
                'banner_name' => null,
                'banner_extension' => null,
                'start_at' => '2024-10-30',
                'finish_at' => '2024-11-03',
                'status' => 1,
            ],
        ]);
    }
}
