<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Hall\Program\Session\SessionResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgramSessionController extends Controller
{
    use ParticipantLog;

    /**
     * Get the sessions for a specific program.
     *
     * @param Request $request
     * @param int $program
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, int $program)
    {
        try {
            // Fetch the program
            $programInstance = $request->user()->meeting->programs()->findOrFail($program);

            // Log participant action
            $this->logParticipantAction($request->user(), "get-sessions", __('common.program') . ': ' . $programInstance->title);

            // Return the sessions
            return response()->json([
                'data' => SessionResource::collection($programInstance->sessions),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            // Log the error
            Log::error('ProgramSessionController Error (index): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500); // Internal Server Error
        }
    }

    /**
     * Get a specific session for a program.
     *
     * @param Request $request
     * @param int $program
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, int $program, int $id)
    {
        try {
            // Fetch the session for the given program
            $session = $request->user()->meeting->programs()->findOrFail($program)->sessions()->findOrFail($id);

            // Log participant action
            $this->logParticipantAction($request->user(), "get-session", $session->title);

            // Return the session details
            return response()->json([
                'data' => new SessionResource($session),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            // Log the error
            Log::error('ProgramSessionController Error (show): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500); // Internal Server Error
        }
    }
}
