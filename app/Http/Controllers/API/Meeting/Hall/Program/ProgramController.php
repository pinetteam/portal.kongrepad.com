<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program;

use App\Http\Traits\ParticipantLog;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Hall\Program\ProgramResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    use ParticipantLog;
    public function index(Request $request, int $hall)
    {
        try{
            $hall = $request->user()->meeting->halls()->findOrFail($hall);
            $programs = $hall->programs()->orderBy('sort_order', 'ASC')->orderBy('start_at', 'ASC')->get();
            $programs = ProgramResource::collection($programs)->groupBy(function($date) {
                App::setLocale('tr');
                return Carbon::parse($date->start_at)->translatedFormat('d F l');
            });
            $result = [];
            foreach(json_decode($programs, true) as $key => $val) {
                array_push($result, ['day' => $key, 'programs' => $val]);
            }

            $this->logParticipantAction($request->user(), "get-programs", __('common.hall') . ': ' . $hall->title);
            return [
                'data' => $result,
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
    public function show(Request $request, int $hall, int $id)
    {
        try{
            $program = $request->user()->meeting->halls()->findOrFail($hall)->programs()->findOrFail($id);
            $this->logParticipantAction($request->user(), "get-program", $program->title);
            return [
                'data' => new ProgramResource($program),
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
