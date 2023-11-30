<?php

namespace App\Http\Controllers\Service\Screen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index(string $id)
    {
        $survey = Auth::user()->customer->surveys()->findOrFail($id);
        return view('service.screen.survey.index', compact(['survey']));
    }
}
