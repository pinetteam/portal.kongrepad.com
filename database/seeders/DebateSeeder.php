<?php

namespace Database\Seeders;

use App\Models\Customer\Customer;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DebateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Debate::insert([
            [
                'program_id' => '11',
                'title' => 'KHDAK’NDE İMMÜNOTERAPİ NEOADJUVANDA MI ADJUVANDA MI?',
                'code'=>'KHDAK',
                'status' => 1,
            ],


            [
                'program_id' => '22',
                'title' => 'KHDAK’NDE İMMÜNOTERAPİ NEOADJUVANDA MI ADJUVANDA MI?',
                'code'=>'KHDAK',
                'status' => 1,
            ],

        ]);

    }
}
