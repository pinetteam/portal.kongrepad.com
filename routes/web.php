<?php

use Illuminate\Support\Facades\Log;
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
Route::get('/', function () {
    return view('home.index');
});
Route::get('/service/screen/speaker/{meeting_hall_screen_code}', [\App\Http\Controllers\Service\Screen\SpeakerController::class, 'index'])->name('service.screen.speaker.index');
Route::get('/service/screen/chair/{meeting_hall_screen_code}', [\App\Http\Controllers\Service\Screen\ChairController::class, 'index'])->name('service.screen.chair.index');
Route::get('/service/screen/speaker/event/{meeting_hall_screen_code}', [\App\Http\Controllers\Service\Screen\SpeakerController::class, 'start'])->name('service.screen.speaker.start');
Route::get('/service/screen/keypad/event/{meeting_hall_screen_code}', [\App\Http\Controllers\Service\Screen\KeypadController::class, 'index'])->name('service.screen.keypad.index');

Route::get('/service/screen/questions/{meeting_hall_screen_code}', [\App\Http\Controllers\Service\Screen\QuestionsController::class, 'index'])->name('service.screen.questions.index');
Route::get('/service/screen/questions/event/{meeting_hall_screen_code}', [\App\Http\Controllers\Service\Screen\QuestionsController::class, 'start'])->name('service.screen.questions.start');

Route::get('/service/question-board/{code}', [\App\Http\Controllers\Service\QuestionBoardController::class, 'index'])->name('service.question-board.start');
Route::get('/service/screen-board/{code}', [\App\Http\Controllers\Service\ScreenBoardController::class, 'index'])->name('service.screen-board.start');
Route::post('/service/screen-board/speaker-screen/{code}', [\App\Http\Controllers\Service\ScreenBoardController::class, 'speaker_screen'])->name('service.screen-board.speaker-screen');
Route::post('/service/screen-board/chair-screen/{code}', [\App\Http\Controllers\Service\ScreenBoardController::class, 'chair_screen'])->name('service.screen-board.chair-screen');
Route::post('/service/screen-board/keypad-screen/{code}', [\App\Http\Controllers\Service\ScreenBoardController::class, 'keypad_screen'])->name('service.screen-board.keypad-screen');
Route::get('/service/operator-board/{code}/{program_order}', [\App\Http\Controllers\Service\OperatorBoardController::class, 'index'])->name('service.operator-board.start');

Route::group(["middleware" => ['auth']], function () {
    Route::get('/service/survey-report/{survey}', [\App\Http\Controllers\Service\SurveyReportBoardController::class, 'index'])->name('service.survey-report.start');
    Route::get('/service/keypad-report/{keypad}', [\App\Http\Controllers\Service\Screen\KeypadController::class, 'index'])->name('service.keypad-report.start');
    Route::get('/service/debate-report/{debate}', [\App\Http\Controllers\Service\Screen\DebateController::class, 'index'])->name('service.debate-report.start');

});
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
        // Main routes
        Route::get('/', [\App\Http\Controllers\Portal\DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/meeting/{meeting}/program', [\App\Http\Controllers\Portal\DashboardController::class, 'programIndex'])->name('dashboard.meeting.program.index');
        Route::get('/meeting/{meeting}/chair', [\App\Http\Controllers\Portal\DashboardController::class, 'chairIndex'])->name('dashboard.meeting.chair.index');
        // Meeting routes
        Route::resource('/meeting', \App\Http\Controllers\Portal\Meeting\MeetingController::class)->except(['create']);
        Route::prefix('meeting')->name('meeting.')->group(function () {
            // Document routes
            Route::resource('/{meeting}/document', \App\Http\Controllers\Portal\Meeting\Document\DocumentController::class)->except(['create']);
            Route::resource('/{meeting}/virtual-stand', \App\Http\Controllers\Portal\Meeting\VirtualStand\VirtualStandController::class)->except(['create']);
            Route::resource('/{meeting}/announcement', \App\Http\Controllers\Portal\Meeting\Announcement\AnnouncementController::class)->except(['create']);
            Route::get('/{meeting}/document/download/{document}', [\App\Http\Controllers\Portal\Meeting\Document\DocumentController::class, 'download'])->name('document.download');
            // Report routes
            Route::prefix('{meeting}/report')->name('report.')->group(function () {
                Route::resource('/score-game', \App\Http\Controllers\Portal\Report\ScoreGame\ScoreGameController::class)->only(['index', 'show']);
                Route::resource('/question', \App\Http\Controllers\Portal\Report\Question\QuestionController::class)->only(['index', 'show']);
                Route::resource('/survey', \App\Http\Controllers\Portal\Report\Survey\SurveyController::class)->only(['index', 'show']);
                Route::get('/survey/{survey}/report',[\App\Http\Controllers\Portal\Report\Survey\SurveyController::class, 'showReport'])->name('survey');
                Route::get('/survey/{survey}/participants',[\App\Http\Controllers\Portal\Report\Survey\SurveyController::class, 'showParticipants'])->name('survey.participants');
                Route::resource('/keypad', \App\Http\Controllers\Portal\Report\Keypad\KeypadController::class)->only(['index', 'show']);
                Route::get('/keypad/{keypad}/participants',[\App\Http\Controllers\Portal\Report\Keypad\KeypadController::class, 'showParticipants'])->name('keypad.participants');
                Route::get('/keypad/{keypad}/report',[\App\Http\Controllers\Portal\Report\Keypad\KeypadController::class, 'showReport'])->name('keypad.question');
                Route::resource('/debate', \App\Http\Controllers\Portal\Report\Debate\DebateController::class)->only(['index', 'show']);
                Route::get('/debate/{debate}/participants',[\App\Http\Controllers\Portal\Report\Debate\DebateController::class, 'showParticipants'])->name('debate.participants');
                Route::get('/debate/{debate}/report',[\App\Http\Controllers\Portal\Report\Debate\DebateController::class, 'showReport'])->name('debate');
            });
            // Hall routes
            Route::resource('/{meeting}/hall', \App\Http\Controllers\Portal\Meeting\Hall\HallController::class)->except(['create']);
            Route::prefix('/{meeting}/hall/{hall}')->name('hall.')->group(function () {
                Route::resource('/screen', \App\Http\Controllers\Portal\Meeting\Hall\Screen\ScreenController::class)->except(['create']);
                Route::resource('/program', \App\Http\Controllers\Portal\Meeting\Hall\Program\ProgramController::class)->except(['create']);
                Route::prefix('/program/{program}')->name('program.')->group(function () {
                    //Debate
                    Route::resource('/debate', \App\Http\Controllers\Portal\Meeting\Hall\Program\Debate\DebateController::class)->except(['index', 'create']);
                    Route::get('/start-stop-debate-voting/{debate}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Debate\DebateController::class,'start_stop_voting'])->name('debate.start-stop-voting');
                    Route::prefix('/debate/{debate}')->name('debate.')->group(function () {
                        Route::resource('/team', \App\Http\Controllers\Portal\Meeting\Hall\Program\Debate\Team\TeamController::class)->except(['create']);
                    });
                    //Chair
                    Route::resource('/chair', \App\Http\Controllers\Portal\Meeting\Hall\Program\Chair\ChairController::class)->except(['create']);
                    //Session
                    Route::resource('/session', \App\Http\Controllers\Portal\Meeting\Hall\Program\Session\SessionController::class)->except(['index', 'create']);
                    Route::get('/start-stop-session/{session}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Session\SessionController::class,'start_stop'])->name('session.start-stop');
                    Route::get('/start-stop-session-questions/{session}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Session\SessionController::class,'start_stop_questions'])->name('session.start-stop-questions');
                    Route::get('/start-stop-session-questions/{session}/{increment}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Session\SessionController::class,'edit_question_limit'])->name('session.edit-question-limit');
                    Route::prefix('/session/{session}')->name('session.')->group(function () {
                        //Keypad
                        Route::resource('/keypad', \App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\KeypadController::class)->except(['index', 'create']);
                        Route::resource('/question', \App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Question\QuestionController::class)->only(['destroy']);
                        Route::get('/start-stop-keypad-voting/{keypad}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\KeypadController::class,'start_stop_voting'])->name('keypad.start-stop-voting');
                        Route::prefix('/keypad/{keypad}')->name('keypad.')->group(function () {
                            Route::resource('/option', \App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad\Option\OptionController::class)->except(['create']);
                        });
                    });
                });
            });
            Route::resource('/{meeting}/participant', \App\Http\Controllers\Portal\Meeting\Participant\ParticipantController::class)->except(['create']);
            Route::get('/{meeting}/participant/{participant}/qr-code', [\App\Http\Controllers\Portal\Meeting\Participant\ParticipantController::class, 'qrCode'])->name('participant.qr-code');
            Route::get('/{meeting}/participant/{participant}/survey/{survey}', [\App\Http\Controllers\Portal\Meeting\Participant\ParticipantController::class, 'showSurvey'])->name('participant.survey');
            // Score Game Routes
            Route::resource('/{meeting}/score-game', \App\Http\Controllers\Portal\Meeting\ScoreGame\ScoreGameController::class)->except(['create']);
            Route::prefix('/{meeting}/score-game/{score_game}')->name('score-game.')->group(function () {
                Route::get('/qr-code/{qr_code}/download', [\App\Http\Controllers\Portal\Meeting\ScoreGame\QRCode\QRCodeController::class,'download'])->name('qr-code-download');
                Route::get('/qr-code/{qr_code}/qr-code', [\App\Http\Controllers\Portal\Meeting\ScoreGame\QRCode\QRCodeController::class, 'qrCode'])->name('qr-code.qr-code');
                Route::resource('/qr-code', \App\Http\Controllers\Portal\Meeting\ScoreGame\QRCode\QRCodeController::class)->except(['create', 'show']);
            });
            // Survey routes
            Route::resource('/{meeting}/survey', \App\Http\Controllers\Portal\Meeting\Survey\SurveyController::class)->except(['create']);
            Route::prefix('/{meeting}/survey/{survey}')->name('survey.')->group(function () {
                Route::resource('/question', \App\Http\Controllers\Portal\Meeting\Survey\Question\QuestionController::class)->except(['create']);
                Route::resource('/question/{question}/option', \App\Http\Controllers\Portal\Meeting\Survey\Question\Option\OptionController::class)->except(['create']);
            });
        });
        /*Route::resource('/hall', \App\Http\Controllers\Portal\Meeting\Hall\MeetingHallController::class)->except(['create']);
        Route::get('/hall/{meeting_hall_id}/current_speaker', [\App\Http\Controllers\Portal\Meeting\Hall\MeetingHallController::class, 'current_speaker'])->name('current-speaker.show');
        Route::get('/hall/{meeting_hall_id}/chair_board', [\App\Http\Controllers\Portal\Meeting\Hall\MeetingHallController::class, 'chair_board'])->name('chair-board.index');
        Route::get('/hall/{meeting_hall_id}/current_chair/{chair_index}', [\App\Http\Controllers\Portal\Meeting\Hall\MeetingHallController::class, 'current_chair'])->name('current-chair.show');*/
        // Program routes
        Route::resource('/user', \App\Http\Controllers\Portal\User\UserController::class)->except(['create']);
        Route::resource('/user-role', \App\Http\Controllers\Portal\User\Role\UserRoleController::class)->except(['create']);
        Route::resource('/setting', \App\Http\Controllers\Portal\Setting\SettingController::class)->only(['index', 'update']);
        Route::get('/session-question-on-screen/{id}', [\App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Question\QuestionController::class,'on_screen'])->name('session-question.on-screen');
    });
});
