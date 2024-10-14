<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program;

use App\Http\Traits\ParticipantLog;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Hall\Program\ProgramResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    use ParticipantLog;

    /**
     * Get the list of programs for a specific hall.
     *
     * @param Request $request
     * @param int $hall
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, int $hall)
    {
        try {
            // Fetch the hall and its programs
            $hallInstance = $request->user()->meeting->halls()->findOrFail($hall);
            $programs = $hallInstance->programs()
                ->orderBy('sort_order', 'ASC')
                ->orderBy('start_at', 'ASC')
                ->get();

            // Group programs by day
            $programs = ProgramResource::collection($programs)->groupBy(function ($date) {
                return Carbon::parse($date->start_at)->translatedFormat('d F l');
            });

            // Prepare result array
            $result = [];
            foreach (json_decode($programs, true) as $key => $val) {
                array_push($result, ['day' => $key, 'programs' => $val]);
            }

            // Log participant action
            $this->logParticipantAction($request->user(), "get-programs", __('common.hall') . ': ' . $hallInstance->title);

            // Return success response
            return response()->json([
                'data' => $result,
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            // Log the error
            Log::error('ProgramController Error (index): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500); // Internal Server Error
        }
    }

    /**
     * Show the details of a specific program.
     *
     * @param Request $request
     * @param int $hall
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, int $hall, int $id)
    {
        try {
            // Fetch the specific program
            $program = $request->user()->meeting->halls()->findOrFail($hall)->programs()->findOrFail($id);

            // Log participant action
            $this->logParticipantAction($request->user(), "get-program", $program->title);

            // Return success response
            return response()->json([
                'data' => new ProgramResource($program),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            // Log the error
            Log::error('ProgramController Error (show): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500); // Internal Server Error
        }
    }
}
