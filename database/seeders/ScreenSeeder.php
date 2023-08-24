<?php

namespace Database\Seeders;

use App\Models\Meeting\Hall\Screen\Screen;
use Illuminate\Database\Seeder;

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
                'code' => null,
                'title' => 'Chair 1',
                'description' => 'Chair 1 Masa',
                'type' => 'chair',
                'status' => 1,
            ],
            [
                'hall_id' => '5',
                'code' => null,
                'title' => 'Chair 2',
                'description' => 'Chair 2 Masa',
                'type' => 'chair',
                'status' => 1,
            ],
            [
                'hall_id' => '5',
                'code' => null,
                'title' => 'Chair 3',
                'description' => 'Chair 3 Masa',
                'type' => 'chair',
                'status' => 1,
            ],
            [
                'hall_id' => '5',
                'code' => null,
                'title' => 'Presentation Screen',
                'description' => 'Presentation Screen',
                'type' => 'document',
                'status' => 1,
            ],
            [
                'hall_id' => '5',
                'code' => null,
                'title' => 'Participant 1',
                'description' => '',
                'type' => 'participant',
                'status' => 1,
            ],
            [
                'hall_id' => '5',
                'code' => null,
                'title' => 'Questions',
                'description' => '',
                'type' => 'questions',
                'status' => 1,
            ],
        ]);
    }
}
