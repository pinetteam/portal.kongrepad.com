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
        Route::resource('/meeting/{meeting_id}/meeting-hall', \App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class)->except(['create']);
        Route::resource('/meeting/{meeting_id}/program', \App\Http\Controllers\API\Meeting\Hall\Program\ProgramController::class)->except(['create']);
        Route::resource('/meeting/{meeting_id}/survey', \App\Http\Controllers\API\Meeting\Survey\SurveyController::class)->except(['create']);
        Route::get('/meeting/{meeting_id}/meeting-hall/{meeting_hall_id}/active-document', [\App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class, 'active_document'])->name('active_document.show');
        Route::resource('/keypad', \App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\KeypadController::class)->except(['create']);
        Route::resource('/program/{program_id}/session', \App\Http\Controllers\API\Meeting\Hall\Program\Session\ProgramSessionController::class)->except(['create']);
        Route::resource('/program/{program_id}/debate', \App\Http\Controllers\API\Meeting\Hall\Program\Debate\DebateController::class)->except(['create']);
        Route::get('participant', [\App\Http\Controllers\API\Participant\ParticipantController::class, 'index'])->name('participant.index');
    });
});
