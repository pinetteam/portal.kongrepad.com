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
                'banner_name' => 'a5ff7c71-7f00-4617-81b4-8554bb82da8e',
                'banner_extension' => 'jpeg',
                'start_at' => '2023-11-01',
                'finish_at' => '2023-11-05',
                'status' => 1,
            ],
            [
                'id' => '1',
                'customer_id' => '2',
                'code' => 'iok-2023',
                'title' => '12. Çocuk Nefroloji Kongresi',
                'banner_name' => 'null',
                'banner_extension' => null,
                'start_at' => '2023-10-26',
                'finish_at' => '2023-11-29',
                'status' => 1,
            ],
        ]);
    }
}
