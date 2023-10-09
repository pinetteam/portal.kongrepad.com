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
                'meeting_id' => '4',
                'code' => Str::uuid()->toString(),
                'title' => 'Kurs Salonu-1',
                'status' => 1,
            ],
            [
                'meeting_id' => '4',
                'code' => Str::uuid()->toString(),
                'title' => 'Kurs Salonu-2',
                'status' => 1,
            ],
            [
                'meeting_id' => '4',
                'code' => Str::uuid()->toString(),
                'title' => 'Ana Salon',
                'status' => 1,
            ],
            [
                'meeting_id' => '4',
                'code' => Str::uuid()->toString(),
                'title' => 'Sözel Bildiriler',
                'status' => 1,
            ],
        ]);
    }
}
