<?php

namespace App\Http\Controllers\API\Meeting\Document;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Document\DocumentResource;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
            return [
                'data' => DocumentResource::collection($request->user()->meeting->documents()->get()),
                'status' => true,
                'errors' => null
            ];
    }
    public function show(Request $request, string $id)
    {
        return $request->user()->meeting->documents()->where('meeting_documents.id',$id)->first()->mails()->count();
    }
}
