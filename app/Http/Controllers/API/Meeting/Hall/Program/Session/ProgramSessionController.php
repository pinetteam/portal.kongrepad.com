<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Hall\Program\Session\SessionResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;

class ProgramSessionController extends Controller
{
    use ParticipantLog;
    public function index(Request $request, int $program){
        try{
            $program = $request->user()->meeting->programs()->findOrFail($program);
            $this->logParticipantAction($request->user(), "get-sessions", __('common.program') . ': ' . $program->title);
            return [
                'data' => SessionResource::collection($program->sessions),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e) {

            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }


    }
    public function show(Request $request, int $program, int $id)
    {
        try{
            $session = $request->user()->meeting->programs()->findOrFail($program)->sessions->findOrFail($id);
            $this->logParticipantAction($request->user(), "get-session", $session->title);
            return [
                'data' => new SessionResource($session),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e) {

            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }


    }
}
