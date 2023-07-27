<?php

namespace App\Http\Controllers\Portal\Meeting\Document;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Document\Document;
use Illuminate\Support\Facades\Storage;

class DocumentDownloadController extends Controller
{
    public function index(string $file)
    {
        $document = Document::where('file_name', $file)->where('status', 1)->first();
        return Storage::download('documents/'.$document->file_name.'.'.$document->file_extension);
    }
}
