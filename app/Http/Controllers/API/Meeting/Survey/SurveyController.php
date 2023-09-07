<?php

namespace App\Http\Controllers\API\Meeting\Survey;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Survey\SurveyResource;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        return [
            'data' => SurveyResource::collection( $request->user()->meeting->surveys()->get())->additional(['some_id => 1']),
            'status' => true,
            'errors' => null
        ];
    }
    public function show(Request $request, string $id)
    {
        return [
            'data' => new SurveyResource( $request->user()->meeting->surveys()->findOrFail($id)),
            'status' => true,
            'errors' => null
        ];
    }
}
