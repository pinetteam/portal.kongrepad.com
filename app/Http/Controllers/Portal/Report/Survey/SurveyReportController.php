<?php

namespace App\Http\Controllers\Portal\Report\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SurveyReportController extends Controller
{
    public function index()
    {
        $surveys = Auth::user()->customer->surveys()->paginate(20);
        $statuses = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        $on_vote = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.report.survey-report.index', compact(['surveys', 'on_vote', 'statuses']));
    }

    public function show(string $survey){
        $survey = Auth::user()->customer->surveys()->findOrFail($survey);
        //$questions = Auth::user()->customer->surveyQuestions()->where('survey_id', $survey)->paginate(20);
        $questions = $survey->questions;
        //dd($survey);
        return view('portal.report.survey-report.show', compact(['survey','questions']));
    }
}
