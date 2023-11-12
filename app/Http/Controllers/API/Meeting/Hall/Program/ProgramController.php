<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Hall\Program\ProgramResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request, int $hall)
    {

        try{
            $programs = $request->user()->meeting->halls()->findOrFail($hall)->programs()->orderBy('sort_order', 'ASC')->orderBy('start_at', 'ASC')->get();
            $programs = ProgramResource::collection($programs)->groupBy(function($date) {
                App::setLocale('tr');
                return Carbon::parse($date->start_at)->translatedFormat('d F l');
            });
            $result = [];
            foreach(json_decode($programs, true) as $key => $val) {
                array_push($result, ['day' => $key, 'programs' => $val]);
            }
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
            return [
                'data' => new ProgramResource($request->user()->meeting->halls()->findOrFail($hall)->programs()->findOrFail($id)),
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
