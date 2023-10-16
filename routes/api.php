<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::post('/auth/login/participant', [\App\Http\Controllers\API\Auth\LoginController::class, 'participant'])->name('auth.login.participant');
    Route::group(["middleware" => ['auth:sanctum']], function () {
        Route::resource('/participant', \App\Http\Controllers\API\Meeting\Participant\ParticipantController::class)->only(['index']);
        Route::resource('/meeting', \App\Http\Controllers\API\Meeting\MeetingController::class)->only(['index']);
        Route::resource('/hall', \App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class)->only(['index', 'show']);
        Route::resource('/hall/{hall}/program', \App\Http\Controllers\API\Meeting\Hall\Program\ProgramController::class)->only(['index', 'show']);
        Route::resource('/program/{program}/session', \App\Http\Controllers\API\Meeting\Hall\Program\Session\ProgramSessionController::class)->only(['index', 'show']);
        Route::resource('/survey', \App\Http\Controllers\API\Meeting\Survey\SurveyController::class)->only(['index', 'show']);
        Route::resource('/score-game', \App\Http\Controllers\API\Meeting\ScoreGame\ScoreGameController::class)->only(['index', 'show']);
        Route::resource('/score-game/{score_game}/point', \App\Http\Controllers\API\Meeting\ScoreGame\Point\PointController::class)->only(['index', 'store']);
        Route::resource('/virtual-stand', \App\Http\Controllers\API\Meeting\VirtualStand\VirtualStandController::class)->only(['index', 'show']);
        Route::resource('/announcement', \App\Http\Controllers\API\Meeting\Announcement\AnnouncementController::class)->only(['index', 'show']);
        Route::resource('/document', \App\Http\Controllers\API\Meeting\Document\DocumentController::class)->only(['index', 'show']);
        Route::resource('/survey/{survey}/question', \App\Http\Controllers\API\Meeting\Survey\Question\QuestionController::class)->only(['index', 'show']);
        Route::resource('/survey/{survey}/vote', \App\Http\Controllers\API\Meeting\Survey\Vote\VoteController::class)->only(['store']);
        Route::resource('/mail', \App\Http\Controllers\API\Meeting\Document\Mail\MailController::class)->only(['store']);
        Route::post('/mail_send_all', [\App\Http\Controllers\API\Meeting\Document\Mail\MailController::class, 'send_all']);
        Route::resource('/keypad/{keypad}/keypad-vote', \App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\Vote\VoteController::class)->only(['store']);
        Route::resource('/debate/{debate}/debate-vote', \App\Http\Controllers\API\Meeting\Hall\Program\Debate\Vote\VoteController::class)->only(['store']);
        Route::get('/hall/{meeting_hall_id}/active-keypad', [\App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class, 'active_keypad']);
        Route::get('/hall/{meeting_hall_id}/active-debate', [\App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class, 'active_debate']);
        Route::get('/hall/{meeting_hall_id}/active-document', [\App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class, 'active_document']);
        Route::get('/hall/{meeting_hall_id}/active-session', [\App\Http\Controllers\API\Meeting\Hall\MeetingHallController::class, 'active_session']);
        Route::resource('/hall/{hall}/session-question', \App\Http\Controllers\API\Meeting\Hall\Program\Session\Question\QuestionController::class)->only(['store']);
        });
});
