<?php

namespace App\Http\Controllers\API\Meeting\Participant;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Participant\ParticipantResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    use ParticipantLog;
    public function index(Request $request)
    {
        try{
            $participant = $request->user();
            $this->logParticipantAction($request->user()->id, "get-participant", $participant->full_name);
            return [
                'data' => new ParticipantResource($participant),
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
