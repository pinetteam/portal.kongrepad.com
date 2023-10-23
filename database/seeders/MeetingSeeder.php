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
                'id' => '4',
                'customer_id' => '1',
                'code' => 'iok-2023',
                'title' => '7. Ulusal İmmunoterapi ve Onkoloji Kongresi',
                'banner_name' => 'a108f94f-9b47-4f21-b214-e79e0b9bcc37',
                'banner_extension' => 'jpeg',
                'start_at' => '2023-11-01',
                'finish_at' => '2023-11-05',
                'status' => 1,
            ],
        ]);
    }
}
