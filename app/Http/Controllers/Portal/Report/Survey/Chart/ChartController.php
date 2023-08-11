<?php

namespace App\Http\Controllers\Portal\Report\Survey\Chart;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function index(string $survey, string $question_id)
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
