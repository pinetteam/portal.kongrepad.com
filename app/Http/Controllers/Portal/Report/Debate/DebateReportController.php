<?php

namespace App\Http\Controllers\Portal\Report\Debate;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DebateReportController extends Controller
{
    public function index()
    {
        $debates = Auth::user()->customer->debates()->paginate(20);
        $on_vote = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        $data = [];
        foreach ($debates as $debate) {
            $data_temp = [];
            foreach ($debate->teams as $team) {
                $data_temp['label'][] = $team->title;
                $data_temp['data'][] = (int)$team->votes->count();
            }
            $data['chart_data'][$debate->id] = json_encode($data_temp);
        }
        return view('portal.report.debate-report.index', $data, compact(['debates', 'on_vote']));
    }
    public function show(string $debate){
        $title = Auth::user()->customer->debates()->findOrFail($debate);
        $teams = $debate->teams()->where('debate_id', $debate)->paginate(20);
        $data = [];
        foreach($teams as $team) {
            $data['label'][] = $team->title;
            $data['data'][] = (int) $team->votes->count();
        }
        $data['chart_data'] = json_encode($data);
        return view('portal.report.debate-report.show', $data ,compact(['teams','title']));
    }
    public function showChart(string $debate)
    {
        $title = Auth::user()->customer->debates()->findOrFail($debate);
        $teams = $debate->teams()->paginate(20);
        $data = [];
        foreach($teams as $team) {
            $data['label'][] = $team->title;
            $data['data'][] = (int) $team->votes->count();
        }
        $data['chart_data'] = json_encode($data);
        return view('portal.report.debate-report.chart.index', $data ,compact(['teams','title']));
    }
    public function showParticipants(string $debate)
    {
        $title = Auth::user()->customer->debates()->findOrFail($debate);
        $votes = Auth::user()->customer->debateVotes()->where('debate_id', $debate)->paginate(20);
        return view('portal.report.debate-report.participant.index', compact(['votes','title']));
    }
}
