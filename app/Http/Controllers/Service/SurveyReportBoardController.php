<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SurveyReportBoardController extends Controller
{
    public function index(string $survey_id)
    {
        $survey = Auth::user()->customer->surveys()->findOrFail($survey_id);
        return view('service.screen.survey.index', compact(['survey']));
    }
}
