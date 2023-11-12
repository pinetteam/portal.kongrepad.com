<?php

namespace App\Http\Controllers\Portal\Report\Question;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $participants = Auth::user()->customer->participants()->get();
        $sortedParticipants = $participants->sortByDesc(function ($participant) {
            return $participant->sessionQuestions()->where([['is_hidden_name', 0], ['selected_for_show', 1]])->count();
        });
        $page = request('page', 1);
        $perPage = 15;
        $currentPageItems = $sortedParticipants->slice(($page - 1) * $perPage, $perPage)->all();
        $participants = new LengthAwarePaginator($currentPageItems, count($sortedParticipants), $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
        return view('portal.report.question.index', compact(['participants']));
    }
}
