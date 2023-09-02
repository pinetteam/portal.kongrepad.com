<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Hall\Program\ProgramResource;
use App\Http\Resources\API\Meeting\Hall\Program\Session\SessionResource;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        return [
            'data' => ProgramResource::collection($request->user()->meeting->programs()->get()),
            'status' => true,
            'errors' => null
        ];
    }
    public function show(Request $request, int $id)
    {
        return [
        'data' => new ProgramResource($request->user()->meeting->programs()->findOrFail($id)),
        'status' => true,
        'errors' => null
    ];
    }
}
