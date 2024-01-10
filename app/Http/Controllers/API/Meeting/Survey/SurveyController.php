<?php

namespace App\Http\Controllers\API\Meeting\Survey;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Survey\SurveyResource;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        try{
            $log = new \App\Models\Log\Meeting\Participant\Participant();
            $log->participant_id = $request->user()->id;
            $log->action = "get-surveys";
            $log->save();
            return [
                'data' => SurveyResource::collection( $request->user()->meeting->surveys()->get())->additional(['some_id => 1']),
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
            $log = new \App\Models\Log\Meeting\Participant\Participant();
            $log->participant_id = $request->user()->id;
            $log->action = "get-survey";
            $log->save();
            return [
                'data' => new SurveyResource( $request->user()->meeting->surveys()->findOrFail($id)),
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
