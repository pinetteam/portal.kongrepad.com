<?php

namespace Database\Seeders;

use App\Models\Meeting\Survey\Survey;
use Illuminate\Database\Seeder;

class MeetingSurveySeeder extends Seeder
{
    public function run(): void
    {
        Survey::insert([
            [
                'meeting_id' => '4',
                'title' => 'Anket 1',
                'description' => '2023 Medikal Onkoloji İş İlişkili Rölatif Değerler Anketi',
                'start_at' => '2023-11-01 10:30',
                'finish_at' => '2023-11-05 17:30',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'title' => 'Anket 2',
                'description' => 'Tıbbi Onkologların Duktal Karsinoma İn Situ Yönetimini Etkileyen Faktörler',
                'start_at' => '2023-11-01 10:30',
                'finish_at' => '2023-11-05 17:30',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'title' => 'Anket 3',
                'description' => 'Tümör Board Katılım Anketi',
                'start_at' => '2023-11-01 10:30',
                'finish_at' => '2023-11-05 17:30',
                'status' => 1
            ],
        ]);
    }
}
