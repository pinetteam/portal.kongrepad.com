<?php

namespace Database\Seeders;

use App\Models\System\Route\Route;
use Illuminate\Database\Seeder;

class SystemRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Route::insert(
            [
                [
                    'code' => 'show-dashboard',
                    'route' => 'portal.dashboard.index',
                ],
                [
                    'code' => 'show-meetings',
                    'route' => 'portal.meeting.index',
                ],
                [
                    'code' => 'show-participants',
                    'route' => 'portal.participant.index',
                ],
            ]
        );
    }
}
