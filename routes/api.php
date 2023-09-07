<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::post('/auth/login/participant', [\App\Http\Controllers\API\Auth\LoginController::class, 'participant'])->name('auth.login.participant');
    Route::group(["middleware" => ['auth:sanctum']], function () {
        Route::resource('/participant', \App\Http\Controllers\API\Meeting\Participant\ParticipantController::class)->only(['index']);
        Route::resource('/meeting', \App\Http\Controllers\API\Meeting\MeetingController::class)->except(['create']);
        Route::resource('/hall', \App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class)->except(['create']);
        Route::resource('/hall/{hall}/program', \App\Http\Controllers\API\Meeting\Hall\Program\ProgramController::class)->except(['create']);
        Route::resource('/program/{program}/session', \App\Http\Controllers\API\Meeting\Hall\Program\Session\ProgramSessionController::class)->except(['create']);
        Route::resource('/survey', \App\Http\Controllers\API\Meeting\Survey\SurveyController::class)->except(['create']);
        Route::resource('/score-game', \App\Http\Controllers\API\Meeting\ScoreGame\ScoreGameController::class)->except(['create']);
        Route::resource('/score-game/{score_game}/point', \App\Http\Controllers\API\Meeting\ScoreGame\Point\PointController::class)->except(['create']);
        Route::resource('/virtual-stand', \App\Http\Controllers\API\Meeting\VirtualStand\VirtualStandController::class)->except(['create']);
        Route::resource('/announcement', \App\Http\Controllers\API\Meeting\Announcement\AnnouncementController::class)->except(['create']);
        Route::resource('/document', \App\Http\Controllers\API\Meeting\Document\DocumentController::class)->except(['create']);
        Route::resource('/survey/{survey}/question', \App\Http\Controllers\API\Meeting\Survey\Question\QuestionController::class)->except(['create']);
        Route::resource('/survey/{survey}/vote', \App\Http\Controllers\API\Meeting\Survey\Vote\VoteController::class)->only(['store']);
        Route::resource('/keypad/{keypad}/keypad-vote', \App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\Vote\VoteController::class)->only(['store']);
        Route::resource('/debate/{debate}/debate-vote', \App\Http\Controllers\API\Meeting\Hall\Program\Debate\Vote\VoteController::class)->only(['store']);
        Route::get('/hall/{meeting_hall_id}/active-keypad', [\App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class, 'active_keypad']);
        Route::get('/hall/{meeting_hall_id}/active-debate', [\App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class, 'active_debate']);
        Route::get('/hall/{meeting_hall_id}/active-document', [\App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class, 'active_document']);
        Route::resource('/keypad', \App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\KeypadController::class)->except(['create']);
        Route::resource('/hall/{hall}/session-question', \App\Http\Controllers\API\Meeting\Hall\Program\Session\Question\QuestionController::class)->except(['create']);
        });
});
