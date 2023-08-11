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
    public function show(string $survey)
    {
        $survey = Auth::user()->customer->surveys()->findOrFail($survey);
        $questions = $survey->questions;
        return view('portal.report.survey-report.show', compact(['survey','questions']));
    }
    public function chart(string $survey, string $question_id)
    {
        $question= Auth::user()->customer->surveyQuestions()->findOrFail($question_id);
        $options = Auth::user()->customer->surveyOptions()->where('question_id', $question_id)->paginate(20);
        $data = [];
        foreach($options as $option) {
            $data['label'][] = $option->option;
            $data['data'][] = (int) $option->votes->count();
        }
        $data['chart_data'] = json_encode($data);
        return view('portal.report.survey-report.chart.index', $data ,compact(['options','question']) );
    }
}
