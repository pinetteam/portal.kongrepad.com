<?php

namespace App\Http\Controllers\API\Meeting\Survey\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Survey\Question\QuestionResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use ParticipantLog;
    public function index(Request $request, int $survey){
        try{
            $survey = $request->user()->meeting->surveys()->findOrFail($survey);
            $this->logParticipantAction($request->user(), "get-survey-questions", __('common.survey') . ': ' . $survey->title);
            return [
                'data' => QuestionResource::collection($survey->questions()->get()),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){
            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
    public function show(Request $request, int $survey, int $id){
        try{
            $question = $request->user()->meeting->surveys()->findOrFail($survey)->questions()->findOrFail($id);
            $this->logParticipantAction($request->user(), "get-survey-question", $question->title);
            return [
                'data' => new QuestionResource($question),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){
            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}
