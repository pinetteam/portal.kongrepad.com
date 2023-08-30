<?php

namespace App\Http\Controllers\API\Meeting\Document;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Document\DocumentResource;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $program_session = $request->user()->meeting->programSessions()->where('on_air', 1)->first();
        $result = [];
        if(isset($program_session)) {
            if(isset($program_session->document)) {
                $result['data'] = new DocumentResource($program_session->document);
                $result['status'] = true;
                $result['errors'] = null;
            }
            else{
                $result['data'] = null;
                $result['status'] = false;
                $result['errors'] = [__('common.there-is-not-any-document')];
            }
        } else{
            $result['data'] = null;
            $result['status'] = false;
            $result['errors'] = [__('common.there-is-not-active-session')];
        }

        return $result;
    }
    public function show(Request $request, string $id)
    {
        return $request->user()->meeting->virtualStands()->where('meeting_virtual_stands.id',$id)->first();
    }
}
