<?php

namespace App\Http\Controllers\API\Meeting\ScoreGame\Point;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\ScoreGame\Point\PointResource;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\ScoreGame\Point\Point;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PointController extends Controller
{
    use ParticipantLog;

    /**
     * Get the points for a specific score game.
     *
     * @param Request $request
     * @param int $score_game
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, int $score_game)
    {
        try {
            // Fetch the score game
            $score_game = $request->user()->meeting->scoreGames()->findOrFail($score_game);

            // Log participant action
            $this->logParticipantAction($request->user(), "get-score-game-points", __('common.score-game') . ': ' . $score_game->title);

            // Return participant's points
            return response()->json([
                'data' => PointResource::collection($score_game->points()->where('participant_id', $request->user()->id)->get()),
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('PointController Error (index): ' . $e->getMessage());

            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    /**
     * Store a new point based on QR code scanning.
     *
     * @param Request $request
     * @param int $score_game
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, int $score_game)
    {
        try {
            // Fetch the score game
            $score_game = $request->user()->meeting->scoreGames()->findOrFail($score_game);

            // Log participant action
            $this->logParticipantAction($request->user(), "scan-qr-code", __('common.score-game') . ': ' . $score_game->title);

            // Validate QR code
            $qr_code = $request->user()->meeting->qrCodes()->where('code', $request->input('code'))->first();
            if (!$qr_code) {
                return response()->json([
                    'data' => null,
                    'status' => false,
                    'errors' => ["Invalid QR code!"]
                ], 400);
            }

            // Check if the participant already scanned this QR code
            if ($score_game->points()->where('participant_id', $request->user()->id)->where('qr_code_id', $qr_code->id)->exists()) {
                return response()->json([
                    'data' => null,
                    'status' => false,
                    'errors' => ["You have already scanned this QR code!"]
                ], 400);
            }

            // Validate QR code time window
            if (!Carbon::parse($qr_code->start_at)->isPast() || Carbon::parse($qr_code->finish_at)->isPast()) {
                return response()->json([
                    'data' => null,
                    'status' => false,
                    'errors' => ["This QR code is not active at the moment!"]
                ], 400);
            }

            // Create a new point
            $point = new Point();
            $point->qr_code_id = $qr_code->id;
            $point->participant_id = $request->user()->id;
            $point->point = $qr_code->point;

            // Save the point and return success
            $point->save();

            return response()->json([
                'data' => $point,
                'status' => true,
                'errors' => null
            ], 200);

        } catch (\Throwable $e) {
            Log::error('PointController Error (store): ' . $e->getMessage());

            return response()->json([
                'data' => null,
                'status' => false,
                'errors' => ["An error occurred while saving the point."]
            ], 500);
        }
    }
}
