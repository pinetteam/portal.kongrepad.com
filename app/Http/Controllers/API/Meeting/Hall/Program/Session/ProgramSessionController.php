<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Hall\Program\Session\SessionResource;
use Illuminate\Http\Request;

class ProgramSessionController extends Controller
{
    public function index(Request $request, int $program){
        try{
            return [
                'data' => SessionResource::collection($request->user()->meeting->programs()->findOrFail($program)->sessions),
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
            return [
                'data' => new SessionResource($request->user()->meeting->programs()->findOrFail($program)->sessions->findOrFail($id)),
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
