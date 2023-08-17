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
}
