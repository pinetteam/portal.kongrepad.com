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
                    'group' => 'general',
                    'sort_order' => '10',
                    'code' => 'portal-dashboard-index',
                    'route' => 'portal.dashboard.index',
                ],
                [
                    'group' => 'meeting',
                    'sort_order' => '10',
                    'code' => 'portal-meeting-index',
                    'route' => 'portal.meeting.index',
                ],
                [
                    'group' => 'reporting',
                    'sort_order' => '10',
                    'code' => 'portal.report.index',
                    'route' => 'portal.report.index',
                ],
                [
                    'group' => 'user-management',
                    'sort_order' => '10',
                    'code' => 'portal-user-index',
                    'route' => 'portal.user.index',
                ],
                [
                    'group' => 'system',
                    'sort_order' => '10',
                    'code' => 'portal-setting-index',
                    'route' => 'portal.setting.index',
                ],
            ]
        );
    }
}
