<?php

namespace Database\Seeders;

use App\Models\Customer\Setting\Variable\Variable;
use Illuminate\Database\Seeder;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timezone_variables = [
            'Europe/Istanbul', 'Europe/Minsk'
        ];
        $date_format_variables = [
            'd/m/Y', 'm/d/Y'
        ];
        $time_format_variables = [
            'H:i', 'H:i:s'
        ];
        Variable::insert([
            [
                'sort_id' => '10',
                'group' => 'localisation',
                'title' => 'date-format',
                'variable' => 'date_format',
                'type' => 'select',
                'type_variables' => json_encode($date_format_variables),
                'status' => '1',
            ],
            [
                'sort_id' => '20',
                'group' => 'localisation',
                'title' => 'time-format',
                'variable' => 'time_format',
                'type' => 'select',
                'type_variables' => json_encode($time_format_variables),
                'status' => '1',
            ],
            [
                'sort_id' => '30',
                'group' => 'localisation',
                'title' => 'timezone',
                'variable' => 'timezone',
                'type' => 'select',
                'type_variables' => json_encode($timezone_variables),
                'status' => '1',
            ],
            [
                'sort_id' => '10',
                'group' => 'localisation',
                'title' => 'address',
                'variable' => 'address',
                'type' => 'text',
                'type_variables' => null,
                'status' => '1',
            ],
        ]);

    }
}
