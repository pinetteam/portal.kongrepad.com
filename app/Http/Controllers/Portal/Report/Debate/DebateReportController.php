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
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.report.debate-report.index', compact(['debates', 'on_vote']));
    }

    public function show(string $debate){
        $title = Auth::user()->customer->debates()->findOrFail($debate);
        $teams = Auth::user()->customer->teams()->where('debate_id', $debate)->paginate(20);
        $data = [];
        foreach($teams as $team) {
            $data['label'][] = $team->title;
            $data['data'][] = (int) $team->votes->count();
        }
        $data['chart_data'] = json_encode($data);
        return view('portal.report.debate-report.show', $data ,compact(['teams','title']) );
    }
}
