<?php

namespace App\Http\Controllers\API\Meeting\VirtualStand;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\VirtualStand\VirtualStandResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VirtualStandController extends Controller
{
    use ParticipantLog;

    /**
     * Get the list of virtual stands for the meeting.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Get the meeting and virtual stands
            $meeting = $request->user()->meeting;

            // Log participant action
            $this->logParticipantAction($request->user(), "get-virtual-stands", __('common.meeting') . ': ' . $meeting->title);

            // Return the active virtual stands shuffled
            return response()->json([
                'data' => VirtualStandResource::collection($meeting->virtualStands()->where('meeting_virtual_stands.status', 1)->get())->shuffle(),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('VirtualStandController Error (index): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    /**
     * Show a specific virtual stand by its ID.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $id)
    {
        try {
            // Fetch the virtual stand
            $stand = $request->user()->meeting->virtualStands()->where('meeting_virtual_stands.id', $id)->firstOrFail();

            // Log participant action
            $this->logParticipantAction($request->user(), "get-virtual-stand", $stand->title);

            // Return the virtual stand details
            return response()->json([
                'data' => new VirtualStandResource($stand),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('VirtualStandController Error (show): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}
