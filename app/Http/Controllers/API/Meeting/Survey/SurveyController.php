<?php

namespace App\Http\Controllers\API\Meeting\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->meeting->surveys()->get();
    }
    public function show(Request $request, string $id)
    {
        return $request->user()->meeting->surveys()->where('meeting_surveys.id',$id)->first();
    }
}
