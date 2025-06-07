<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConferenceParticipantController;
use App\Http\Controllers\Api\ConferenceController;
use App\Http\Controllers\Api\ConferenceSessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication Routes for Conference Participants
Route::prefix('participants')->group(function () {
    Route::post('register', [AuthController::class, 'participantRegister']);
    Route::post('login', [AuthController::class, 'participantLogin']);
    Route::post('forgot-password', [AuthController::class, 'participantForgotPassword']);
    Route::post('reset-password', [AuthController::class, 'participantResetPassword']);
});

// Protected routes for authenticated participants
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Participant profile routes
    Route::prefix('participant')->group(function () {
        Route::get('profile', [ConferenceParticipantController::class, 'profile']);
        Route::put('profile', [ConferenceParticipantController::class, 'updateProfile']);
        Route::post('logout', [AuthController::class, 'participantLogout']);
        Route::post('refresh-token', [AuthController::class, 'refreshToken']);
        Route::delete('delete-account', [ConferenceParticipantController::class, 'deleteAccount']);
    });

    // Conference routes for participants
    Route::prefix('conferences')->group(function () {
        Route::get('/', [ConferenceController::class, 'index']);
        Route::get('{conference}', [ConferenceController::class, 'show']);
        Route::get('{conference}/sessions', [ConferenceSessionController::class, 'conferenceIndex']);
        Route::get('{conference}/programs', [ConferenceController::class, 'programs']);
        Route::get('{conference}/venues', [ConferenceController::class, 'venues']);
        Route::get('{conference}/documents', [ConferenceController::class, 'documents']);
        
        // Join conference
        Route::post('{conference}/join', [ConferenceController::class, 'join']);
        Route::post('{conference}/leave', [ConferenceController::class, 'leave']);
    });

    // Session routes for participants
    Route::prefix('sessions')->group(function () {
        Route::get('{session}', [ConferenceSessionController::class, 'show']);
        Route::post('{session}/join', [ConferenceSessionController::class, 'join']);
        Route::post('{session}/leave', [ConferenceSessionController::class, 'leave']);
        
        // Questions in sessions
        Route::get('{session}/questions', [ConferenceSessionController::class, 'questions']);
        Route::post('{session}/questions', [ConferenceSessionController::class, 'askQuestion']);
        
        // Polls in sessions
        Route::get('{session}/polls', [ConferenceSessionController::class, 'polls']);
        Route::post('{session}/polls/{poll}/vote', [ConferenceSessionController::class, 'votePoll']);
        
        // Session feedback
        Route::post('{session}/feedback', [ConferenceSessionController::class, 'feedback']);
    });

    // Real-time activity tracking
    Route::post('heartbeat', [ConferenceParticipantController::class, 'heartbeat']);
    Route::get('notifications', [ConferenceParticipantController::class, 'notifications']);
    Route::post('notifications/{notification}/read', [ConferenceParticipantController::class, 'markNotificationRead']);
});

// Public routes (no authentication required)
Route::prefix('public')->group(function () {
    Route::get('conferences', [ConferenceController::class, 'publicIndex']);
    Route::get('conferences/{conference}', [ConferenceController::class, 'publicShow']);
    Route::get('conferences/{conference}/sessions', [ConferenceSessionController::class, 'publicIndex']);
    Route::get('conferences/{conference}/programs', [ConferenceController::class, 'publicPrograms']);
});

// Health check route
Route::get('health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now()->toISOString(),
        'version' => config('app.version', '1.0.0'),
    ]);
});

// User info route (for authenticated users)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 