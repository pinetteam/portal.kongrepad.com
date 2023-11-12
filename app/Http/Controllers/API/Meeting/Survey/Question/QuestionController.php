<?php

namespace App\Http\Controllers\API\Meeting\Survey\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Survey\Question\QuestionResource;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request, int $survey){
        try{
            return [
                'data' => QuestionResource::collection($request->user()->meeting->surveys()->findOrFail($survey)->questions()->get()),
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
            return [
                'data' => new QuestionResource($request->user()->meeting->surveys()->findOrFail($survey)->questions()->findOrFail($id)),
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
