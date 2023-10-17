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
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        $on_vote = [
            'passive' => ['value' => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.report.survey-report.index', compact(['surveys', 'on_vote', 'statuses']));
    }
    public function show(string $survey)
    {
        $survey = Auth::user()->customer->surveys()->findOrFail($survey);
        $on_vote = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        $data = [];
        foreach ($survey->questions as $question) {
            $data_temp = [];
            foreach ($question->options as $option) {
                $data_temp['label'][] = $option->option;
                $data_temp['data'][] = (int)$option->votes->count();
            }
            $data['chart_data'][$question->id] = json_encode($data_temp);
        }
        return view('portal.report.survey-report.show', $data, compact(['survey', 'on_vote']));
    }
    public function showChart(string $survey, string $question_id)
    {
        $question= Auth::user()->customer->surveyQuestions()->findOrFail($question_id);
        $options = Auth::user()->customer->surveyOptions()->where('question_id', $question_id)->paginate(20);
        $data = [];
        foreach($options as $option) {
            $data['label'][] = $option->option;
            $data['data'][] = (int) $option->votes->count();
        }
        $data['chart_data'] = json_encode($data);
        return view('portal.report.survey-report.chart.index', $data ,compact(['options', 'question']));
    }
    public function showParticipants(string $survey, string $question_id)
    {
        $question= Auth::user()->customer->surveyQuestions()->findOrFail($question_id);
        $votes = Auth::user()->customer->surveyVotes()->where('question_id', $question_id)->paginate(20);
        return view('portal.report.survey-report.participant.index', compact(['votes','question']));
    }
    public function showScreen(string $survey){
        $survey = Auth::user()->customer->surveys()->findOrFail($survey);
        $on_vote = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.report.survey-report.show-screen', compact(['survey', 'on_vote']));
    }
}
