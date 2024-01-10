<?php

namespace App\Http\Controllers\API\Meeting\Document;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Document\DocumentResource;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        try{
            $log = new \App\Models\Log\Meeting\Participant\Participant();
            $log->participant_id = $request->user()->id;
            $log->action = "get-documents";
            $log->save();
            return [
                'data' => DocumentResource::collection($request->user()->meeting->documents()->get()),
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
