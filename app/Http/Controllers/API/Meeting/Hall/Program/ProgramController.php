<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Hall\Program\ProgramResource;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request, int $hall)
    {
        try{
            return [
                'data' => ProgramResource::collection($request->user()->meeting->halls()->findOrFail($hall)->programs()->get()),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){

            return [
                'data' => null,
                'status' => false,
                'errors' => $e
            ];
        }

    }
    public function show(Request $request, int $hall, int $id)
    {
        try{
            return [
                'data' => new ProgramResource($request->user()->meeting->halls()->findOrFail($hall)->programs()->findOrFail($id)),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){

            return [
                'data' => null,
                'status' => false,
                'errors' => [$e]
            ];
        }
    }
}
