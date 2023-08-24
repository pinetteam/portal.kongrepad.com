<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Screen\Screen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Screen::insert([
            [
                'hall_id' => '5',
                'code' => Str::uuid()->toString(),
                'title' => 'Chair 1',
                'description' => 'Chair 1 Masa',
                'type' => 'chair',
                'status' => 1,
            ],
            [
                'hall_id' => '5',
                'code' => Str::uuid()->toString(),
                'title' => 'Chair 2',
                'description' => 'Chair 2 Masa',
                'type' => 'chair',
                'status' => 1,
            ],
            [
                'hall_id' => '5',
                'code' => Str::uuid()->toString(),
                'title' => 'Chair 3',
                'description' => 'Chair 3 Masa',
                'type' => 'chair',
                'status' => 1,
            ],
            [
                'hall_id' => '5',
                'code' => Str::uuid()->toString(),
                'title' => 'Presentation Screen',
                'description' => 'Presentation Screen',
                'type' => 'document',
                'status' => 1,
            ],
            [
                'hall_id' => '5',
                'code' => Str::uuid()->toString(),
                'title' => 'Participant 1',
                'description' => '',
                'type' => 'participant',
                'status' => 1,
            ],
            [
                'hall_id' => '5',
                'code' => Str::uuid()->toString(),
                'title' => 'Questions',
                'description' => '',
                'type' => 'questions',
                'status' => 1,
            ],
        ]);
    }
}
