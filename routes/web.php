<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/screen/test', [\App\Http\Controllers\Service\Screen\TestController::class, 'index'])->name('screen.test.index');
Route::get('/screen/start/{id}', [\App\Http\Controllers\Service\Screen\TestController::class, 'start'])->name('screen.test.start');

Route::group(["middleware" => ['guest']], function () {
    Route::get('/auth/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('auth.login.index');
    Route::post('/auth/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->name('auth.login.store');
});

Route::group(["middleware" => ['auth']], function () {
    Route::post('/auth/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'store'])->name('auth.logout.store');
});

Route::prefix('portal')->name('portal.')->group(function () {
    //Route::group(["middleware" => ['auth','user.role.control']], function () {
    Route::group(["middleware" => ['auth']], function () {
        /* Main routes */
        Route::get('/', [\App\Http\Controllers\Portal\DashboardController::class, 'index'])->name('dashboard.index');

        /* Meeting routes */
        Route::resource('/meeting', \App\Http\Controllers\Portal\Meeting\MeetingController::class)->except(['create']);
        Route::prefix('meeting')->name('meeting.')->group(function () {
            /* Document routes */
            Route::resource('/{meeting}/document', \App\Http\Controllers\Portal\Meeting\Document\DocumentController::class)->except(['create']);
            Route::get('/{meeting}/document/download/{document}', [\App\Http\Controllers\Portal\Meeting\Document\DocumentController::class, 'download'])->name('document.download');

            /* Hall routes */
            Route::resource('/{meeting}/hall', \App\Http\Controllers\Portal\Meeting\Hall\HallController::class)->except(['create']);

            Route::name('hall.')->group(function () {
                Route::resource('/{meeting}/hall/{hall}/program', \App\Http\Controllers\Portal\Meeting\Hall\Program\ProgramController::class)->except(['create']);
                Route::name('program.')->group(function () {
                    Route::resource('/{meeting}/hall/{hall}/program/{program}/session', \App\Http\Controllers\Portal\Meeting\Hall\Program\Session\SessionController::class)->except(['index', 'create']);
                    Route::get('/program/{program_id}/start-stop-session/{session}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Session\SessionController::class,'start_stop'])->name('session.start-stop');
                    Route::get('/program/{program_id}/start-stop-session-questions/{session}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Session\SessionController::class,'start_stop_questions'])->name('session.start-stop-questions');
                    Route::get('/program/{program_id}/start-stop-session-questions/{session}/{increment}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Session\SessionController::class,'edit_question_limit'])->name('session.edit-question-limit');
                    Route::resource('/{meeting}/hall/{hall}/program/{program}/chair', \App\Http\Controllers\Portal\Meeting\Hall\Program\Chair\ChairController::class)->except(['create']);
                });
            });

            Route::resource('/{meeting}/survey', \App\Http\Controllers\Portal\Meeting\Survey\SurveyController::class)->except(['create']);

            Route::resource('/{meeting}/participant', \App\Http\Controllers\Portal\Meeting\Participant\ParticipantController::class)->except(['create']);
            Route::get('/{meeting}/participant/{participant}/qr-code', [\App\Http\Controllers\Portal\Meeting\Participant\ParticipantController::class, 'qr_code'])->name('participant.qr-code');

            /* Score Game Routes */
            Route::resource('/{meeting}/score-game', \App\Http\Controllers\Portal\Meeting\ScoreGame\ScoreGameController::class)->except(['create']);
            Route::prefix('/{meeting}/score-game/{score_game}')->name('score-game.')->group(function () {
                Route::get('/qr-code/{qr_code}/download', [\App\Http\Controllers\Portal\Meeting\ScoreGame\QrCode\QRCodeController::class,'download'])->name('qr-code-download');
                Route::get('/qr-code/{qr_code}/qr-code', [\App\Http\Controllers\Portal\Meeting\ScoreGame\QrCode\QRCodeController::class, 'qr_code'])->name('qr-code.qr-code');
                Route::resource('/qr-code', \App\Http\Controllers\Portal\Meeting\ScoreGame\QrCode\QRCodeController::class)->except(['create', 'show']);
            });

        });


        Route::resource('/meeting/{meeting}/survey/{survey_id}/question', \App\Http\Controllers\Portal\Meeting\Survey\Question\QuestionController::class)->except(['create']);
        Route::resource('/meeting/{meeting}/survey/{survey_id}/question/{question_id}/survey-option', \App\Http\Controllers\Portal\Meeting\Survey\Question\Option\OptionController::class)->except(['create']);
        /*Route::get('/hall/{meeting_hall_id}/operator-board/{program_order}', [\App\Http\Controllers\Portal\OperatorBoardController::class, 'index'])->name('operator-board.index');
        Route::resource('/hall', \App\Http\Controllers\Portal\Meeting\Hall\MeetingHallController::class)->except(['create']);
        Route::get('/hall/{meeting_hall_id}/current_speaker', [\App\Http\Controllers\Portal\Meeting\Hall\MeetingHallController::class, 'current_speaker'])->name('current-speaker.show');
        Route::get('/hall/{meeting_hall_id}/chair_board', [\App\Http\Controllers\Portal\Meeting\Hall\MeetingHallController::class, 'chair_board'])->name('chair-board.index');
        Route::get('/hall/{meeting_hall_id}/current_chair/{chair_index}', [\App\Http\Controllers\Portal\Meeting\Hall\MeetingHallController::class, 'current_chair'])->name('current-chair.show');
*/

        /* Program routes */
        Route::resource('/program/{program_id}/session/{session_id}/keypad', \App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\KeypadController::class)->except(['index', 'create']);
        Route::get('/program/{program_id}/session/{session_id}/start-stop-keypad-voting/{keypad}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\KeypadController::class,'start_stop_voting'])->name('keypad.start-stop-voting');
        Route::resource('/program/{program_id}/debate', \App\Http\Controllers\Portal\Meeting\Hall\Program\Debate\DebateController::class)->except(['index', 'create']);
        Route::get('/program/{program_id}/start-stop-debate-voting/{debate}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Debate\DebateController::class,'start_stop_voting'])->name('debate.start-stop-voting');


        /* Survey routes */
        Route::resource('/user', \App\Http\Controllers\Portal\User\UserController::class)->except(['create']);
        Route::resource('/user-role', \App\Http\Controllers\Portal\User\Role\UserRoleController::class)->except(['create']);
        Route::resource('/setting', \App\Http\Controllers\Portal\Setting\SettingController::class)->only(['index', 'update']);
        Route::resource('/team', \App\Http\Controllers\Portal\Meeting\Hall\Program\Debate\Team\TeamController::class)->except(['create']);
        Route::resource('/debate-vote', \App\Http\Controllers\Portal\Meeting\Hall\Program\Debate\Team\TeamController::class)->except(['create']);
        Route::resource('/option', \App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\Option\OptionController::class)->except(['create']);
        Route::resource('/session-question', \App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Question\QuestionController::class)->except(['create']);
        Route::get('/session-question-on-screen/{id}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Question\QuestionController::class,'on_screen'])->name('session-question.on-screen');
    });
});
