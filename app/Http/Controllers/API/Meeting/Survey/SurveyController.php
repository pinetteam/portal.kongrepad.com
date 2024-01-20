<?php

namespace App\Http\Controllers\API\Meeting\Survey;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Survey\SurveyResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    use ParticipantLog;
    public function index(Request $request)
    {
        try{
            $meeting = $request->user()->meeting;
            $this->logParticipantAction($request->user()->id, "get-surveys", __('common.meeting') . ': ' . $meeting->title);
            return [
                'data' => SurveyResource::collection( $meeting->surveys()->get())->additional(['some_id => 1']),
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
    public function show(Request $request, string $id)
    {
        try{
            $survey = $request->user()->meeting->surveys()->findOrFail($id);
            $this->logParticipantAction($request->user()->id, "get-survey", $survey->title);
            return [
                'data' => new SurveyResource($survey),
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
