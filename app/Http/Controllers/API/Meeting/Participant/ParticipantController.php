<?php

namespace App\Http\Controllers\API\Meeting\Participant;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Participant\ParticipantResource;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        try{
            return [
                'data' => new ParticipantResource($request->user()),
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
