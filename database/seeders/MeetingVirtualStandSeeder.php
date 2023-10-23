<?php

namespace Database\Seeders;

use App\Models\Meeting\VirtualStand\VirtualStand;
use Illuminate\Database\Seeder;

class MeetingVirtualStandSeeder extends Seeder
{
    public function run(): void
    {
        VirtualStand::insert([
            [
                'meeting_id' => '4',
                'file_name' => 'd8023571-bb58-4694-b6b3-35530b6c48a8',
                'file_extension' => 'png',
                'title' => 'vs-1',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'file_name' => 'a44d3e0e-ed42-4f19-b04d-e3eb0d06102e',
                'file_extension' => 'png',
                'title' => 'vs-2',
                'status' => 1
            ],
        ]);
    }
}
