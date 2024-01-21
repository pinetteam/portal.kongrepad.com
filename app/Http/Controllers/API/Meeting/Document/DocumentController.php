<?php

namespace App\Http\Controllers\API\Meeting\Document;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Document\DocumentResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    use ParticipantLog;
    public function index(Request $request)
    {
        try{
            $meeting = $request->user()->meeting;
            $this->logParticipantAction($request->user(), "get-documents", __('common.meeting') . ': ' . $meeting->title);
            return [
                'data' => DocumentResource::collection($meeting->documents()->get()),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){
            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}
