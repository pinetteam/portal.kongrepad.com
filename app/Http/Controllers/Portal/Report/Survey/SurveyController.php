<?php

namespace App\Http\Controllers\Portal\Report\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index(string $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $surveys = $meeting->surveys()->paginate(20);
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        $on_vote = [
            'passive' => ['value' => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.report.survey.index', compact(['meeting', 'surveys', 'on_vote', 'statuses']));
    }
    public function show(string $meeting, string $survey)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $survey = $meeting->surveys()->findOrFail($survey);
        $on_vote = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.report.survey.show', compact(['survey', 'on_vote']));
    }
    public function showParticipants(string $meeting, string $survey)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $survey = $meeting->surveys()->findOrFail($survey);
        $votes = \App\Models\Meeting\Survey\Vote\Vote::where('survey_id', $survey->id)->groupBy('participant_id')->get();
        return view('portal.meeting.report.survey.participant.index', compact(['survey', 'votes']));
    }
    public function showReport(string $meeting, string $survey){
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $survey = $meeting->surveys()->findOrFail($survey);
        return view('portal.meeting.report.survey.report', compact(['survey']));
    }
    public function showScreen(string $survey){
        $survey = Auth::user()->customer->surveys()->findOrFail($survey);
        return view('service.survey-board.index', compact(['survey']));
    }
}
