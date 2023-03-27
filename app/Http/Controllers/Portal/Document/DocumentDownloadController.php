<?php

namespace App\Http\Controllers\Portal\Document;

use App\Http\Controllers\Controller;
use App\Models\Document\Document;
use Illuminate\Support\Facades\Storage;

class DocumentDownloadController extends Controller
{
    public function index(string $file)
    {
        $document = Document::where('file_name', $file)->first();
        return Storage::download('documents/'.$document->file_name.'.'.$document->file_extension);
    }
}
