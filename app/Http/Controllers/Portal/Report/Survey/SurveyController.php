<?php

namespace App\Http\Controllers\Portal\Report\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index(int $meeting)
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
    public function show(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $survey = $meeting->surveys()->findOrFail($id);
        $on_vote = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.report.survey.show', compact(['survey', 'on_vote']));
    }
    public function showParticipants(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $survey = $meeting->surveys()->findOrFail($id);
        $votes = \App\Models\Meeting\Survey\Vote\Vote::where('survey_id', $survey->id)->paginate(20);
        return view('portal.meeting.report.survey.participant.index', compact(['survey', 'votes']));
    }
    public function showReport(int $meeting, int $id){
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $survey = $meeting->surveys()->findOrFail($id);
        return view('portal.meeting.report.survey.report', compact(['survey']));
    }
    public function showScreen(int $id){
        $survey = Auth::user()->customer->surveys()->findOrFail($id);
        return view('service.survey-board.index', compact(['survey']));
    }
}
