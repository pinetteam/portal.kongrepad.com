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
                'file_name' => '25e4fee7-dcc0-4c29-bac9-d3c68d4c9bab',
                'file_extension' => 'png',
                'pdf_name' => 'cc951880-16be-4d8c-bb1f-52a8940bcecf',
                'title' => 'Astellas',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'file_name' => 'd851b4b9-4bf5-418e-ae1e-aae6bc8ef773',
                'file_extension' => 'png',
                'pdf_name' => '14517459-c76a-4909-9bb7-244e38d6c302',
                'title' => 'Novartis',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'file_name' => '663175f5-66a4-45da-b101-e377ab4807d7',
                'file_extension' => 'png',
                'pdf_name' => null,
                'title' => 'MSD',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'file_name' => '0d91c272-6c5b-4a4e-b599-9ad7afeb3360',
                'file_extension' => 'png',
                'pdf_name' => '0ccf2f70-6998-4dfe-9511-8ce979a3a5b7',
                'title' => 'Roche',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'file_name' => 'aa3d9dfe-8406-480a-b174-aea885873a64',
                'file_extension' => 'png',
                'pdf_name' => '483102f5-2b85-495d-ae2b-a0a16c8d41dc',
                'title' => 'Merck',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'file_name' => '1d35b00b-1493-45a9-ae50-49cd3be13af1',
                'file_extension' => 'png',
                'pdf_name' => '9a7d7406-46be-49e0-a860-341e958e925a',
                'title' => 'Eczacıbaşı',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'file_name' => 'c04a3ccc-2278-4fd5-b654-aabf532c800d',
                'file_extension' => 'png',
                'pdf_name' => '539e8f9b-e64c-4bb5-a439-094f3626d851',
                'title' => 'BMS',
                'status' => 1
            ],
            [
                'meeting_id' => '4',
                'file_name' => 'a433cd5d-ef5d-405f-bf81-4728fb4562e4',
                'file_extension' => 'png',
                'pdf_name' => '9599d2fa-8640-4eb9-a541-4b2df1a3f743',
                'title' => 'GSK',
                'status' => 1
            ],
        ]);
    }
}
