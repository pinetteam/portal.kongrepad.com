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
        Route::resource('/meeting', \App\Http\Controllers\API\Meeting\MeetingController::class)->except(['create']);
        Route::resource('/hall', \App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class)->except(['create']);
        Route::resource('/program', \App\Http\Controllers\API\Meeting\Hall\Program\ProgramController::class)->except(['create']);
        Route::resource('/survey', \App\Http\Controllers\API\Meeting\Survey\SurveyController::class)->except(['create']);
        Route::resource('/virtual-stand', \App\Http\Controllers\API\Meeting\VirtualStand\VirtualStandController::class)->except(['create']);
        Route::resource('/announcement', \App\Http\Controllers\API\Meeting\Announcement\AnnouncementController::class)->except(['create']);
        Route::resource('/survey/{survey_id}/question', \App\Http\Controllers\API\Meeting\Survey\Question\QuestionController::class)->except(['create']);
        Route::resource('/survey/{survey_id}/question/{question_id}/survey-option', \App\Http\Controllers\API\Meeting\Survey\Question\Option\OptionController::class)->except(['create']);
        Route::get('/meeting/{meeting_id}/hall/{meeting_hall_id}/active-document', [\App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class, 'active_document'])->name('active-document.show');
        Route::get('/hall/{meeting_hall_id}/active-keypad', [\App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class, 'active_keypad']);
        Route::resource('/keypad', \App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\KeypadController::class)->except(['create']);
        /*Route::resource('/keypad/{keypad_id}/option', \App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\Option\OptionController::class)->except(['create']);
        Route::resource('/keypad/{keypad_id}/vote', \App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\Vote\VoteController::class)->except(['create']);
        Route::resource('/program/{program_id}/session', \App\Http\Controllers\API\Meeting\Hall\Program\Session\ProgramSessionController::class)->except(['create']);
        Route::resource('/program/{program_id}/debate', \App\Http\Controllers\API\Meeting\Hall\Program\Debate\DebateController::class)->except(['create']);
        Route::resource('/hall/{meeting_hall_id}/session-question', \App\Http\Controllers\API\Meeting\Hall\Program\Session\Question\QuestionController::class)->except(['create']);*/
        Route::get('participant', [\App\Http\Controllers\API\Participant\ParticipantController::class, 'index'])->name('participant.index');
    });
});
