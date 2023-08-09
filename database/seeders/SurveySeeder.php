<?php

namespace Database\Seeders;

use App\Models\Meeting\Survey\Survey;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    public function run(): void
    {
        Survey::insert([
            [
                'sort_order'=>'10',
                'meeting_id'=>'3',
                'title'=>'Anket 1',
                'description'=>'Burcu Yapar',
                'status'=>1
            ],

            ['sort_order'=>'20',
                'meeting_id'=>'3',
                'title'=>'Anket 2',
                'description'=>'Çiğdem Dinçkal',
                'status'=>1
            ],
            ['sort_order'=>'30',
                'meeting_id'=>'3',
                'title'=>'Anket 3',
                'description'=>'Mehmet Uzun',
                'status'=>1
            ],
            ['sort_order'=>'10',
                'meeting_id'=>'1',
                'title'=>'Anket 1',
                'description'=>'Burcu Yapar',
                'status'=>1
            ],

            ['sort_order'=>'20',
                'meeting_id'=>'1',
                'title'=>'Anket 2',
                'description'=>'Çiğdem Dinçkal',
                'status'=>1
            ],
            ['sort_order'=>'30',
                'meeting_id'=>'1',
                'title'=>'Anket 3',
                'description'=>'Mehmet Uzun',
                'status'=>1
            ]


        ]);
    }
}
