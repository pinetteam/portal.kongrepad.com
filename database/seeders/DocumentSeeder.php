<?php

namespace Database\Seeders;

use App\Models\Meeting\Document\Document;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::putFileAs('documents',\Illuminate\Http\UploadedFile::fake()->create('test.pdf'), 'test.pdf');
        Document::insert([
            [
                'meeting_id' => '3',
                'file_name' => 'test',
                'file_extension' => 'pdf',
                'title' => 'test',
                'sharing_via_email' => 0,
                'status' => 1,
            ],
        ]);
    }
}
