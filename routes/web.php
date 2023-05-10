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
        Route::get('/', [\App\Http\Controllers\Portal\DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('/document', \App\Http\Controllers\Portal\Document\DocumentController::class)->except(['create']);
        Route::get('/document-download/{file}', [\App\Http\Controllers\Portal\Document\DocumentDownloadController::class, 'index'])->name('document-download.index');
        Route::resource('/meeting', \App\Http\Controllers\Portal\Meeting\MeetingController::class)->except(['create']);
        Route::resource('/meeting-hall', \App\Http\Controllers\Portal\Meeting\Hall\MeetingHallController::class)->except(['create']);
        Route::resource('/participant', \App\Http\Controllers\Portal\Participant\ParticipantController::class)->except(['create']);
        Route::resource('/program', \App\Http\Controllers\Portal\Program\ProgramController::class)->except(['create']);
        Route::resource('/program-moderator', \App\Http\Controllers\Portal\Program\Moderator\ProgramModeratorController::class)->only(['store', 'destroy']);
        Route::resource('/program-session', \App\Http\Controllers\Portal\Program\Session\ProgramSessionController::class)->except(['index', 'create']);
        Route::resource('/score-game', \App\Http\Controllers\Portal\ScoreGame\ScoreGameController::class)->except(['create']);
        Route::resource('/user', \App\Http\Controllers\Portal\User\UserController::class)->except(['create']);
        Route::resource('/user-role', \App\Http\Controllers\Portal\User\Role\UserRoleController::class)->except(['create']);
        Route::resource('/setting', \App\Http\Controllers\Portal\Setting\SettingController::class)->only(['index', 'update']);
        Route::resource('/screen', \App\Http\Controllers\Portal\Meeting\Hall\Screen\ScreenController::class)->except(['create']);
        Route::resource('/qr-code', \App\Http\Controllers\Portal\ScoreGame\QrCode\QrCodeController::class)->except(['create']);
        Route::get('/qr-code-download/{id}', [\App\Http\Controllers\Portal\ScoreGame\QrCode\QrCodeController::class,'download'])->name('qr-code-download');
    });
});
