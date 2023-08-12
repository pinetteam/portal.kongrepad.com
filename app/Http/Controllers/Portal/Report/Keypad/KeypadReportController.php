<?php

namespace App\Http\Controllers\Portal\Report\Keypad;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KeypadReportController extends Controller
{
    public function index()
    {
        $keypads = Auth::user()->customer->keypads()->paginate(20);
        $on_vote = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        $data = [];
        foreach ($keypads as $keypad) {
            $data_temp = [];
            foreach ($keypad->options as $option) {
                $data_temp['label'][] = $option->option;
                $data_temp['data'][] = (int)$option->votes->count();
            }
            $data['chart_data'][$keypad->id] = json_encode($data_temp);
        }
        return view('portal.report.keypad-report.index', $data, compact(['keypads', 'on_vote']));
    }

    public function show(string $keypad){
        $question = Auth::user()->customer->keypads()->findOrFail($keypad);
        $options = Auth::user()->customer->options()->where('keypad_id', $keypad)->paginate(20);
        $data = [];
        foreach($options as $option) {
            $data['label'][] = $option->option;
            $data['data'][] = (int) $option->votes->count();
        }
        $data['chart_data'] = json_encode($data);
        return view('portal.report.keypad-report.show', $data ,compact(['options','question']) );
    }
}
