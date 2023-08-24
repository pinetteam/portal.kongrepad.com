<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Hall;
use Illuminate\Http\Request;

class QuestionBoardController extends Controller
{
    public function index(string $code)
    {
        $hall = Hall::where('code', $code)->first();
        $session = $hall->programSessions()->where('meeting_hall_program_sessions.on_air',1)->first();
        $questions = $session ? $session->questions()->where('meeting_hall_program_session_questions.selected_for_show', 0)->get() : null;
        $selected_questions = $session ? $session->questions()->where('meeting_hall_program_session_questions.selected_for_show', 1)->get() : null;
        return view('service.question-board.index', compact(['session', 'questions', 'selected_questions']));
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
