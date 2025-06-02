<?php

namespace App\Http\Controllers\Portal\Meeting\ScoreGame\QRCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\ScoreGame\QrCode\QrCodeRequest;
use App\Http\Resources\Portal\Meeting\ScoreGame\QRCode\QRCodeResource;
use App\Models\Meeting\ScoreGame\QRCode\QRCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QRCodeController extends Controller
{
    public function index(int $meeting, int $score_game)
    {
        $score_game = Auth::user()->customer->scoreGames()->findOrFail($score_game);
        $qr_codes = $score_game->qrCodes()->paginate(20);
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.score-game.qr-code.index', compact(['qr_codes', 'score_game', 'statuses']));
    }
    public function store(QrCodeRequest $request)
    {
        if ($request->validated()) {
            $qr_code = new QRCode();
            $qr_code->score_game_id = $request->input('score_game_id');
            $qr_code->title = $request->input('title');
            $qr_code->code = Str::uuid()->toString();
            $qr_code->point = $request->input('point');
            $qr_code->start_at = $request->input('start_at');
            $qr_code->finish_at = $request->input('finish_at');
            $qr_code->status = $request->input('status');
            if ($qr_code->save()) {
                $qr_code->created_by = Auth::user()->id;
                $qr_code->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function edit(int $meeting, int $score_game, int $id)
    {
        $score_game = Auth::user()->customer->scoreGames()->findOrFail($score_game);
        $qr_code = $score_game->qrCodes()->findOrFail($id);
        return new QRCodeResource($qr_code);
    }
    public function update(QrCodeRequest $request, int $meeting, int $score_game, int $id)
    {
        if ($request->validated()) {
            $score_game = Auth::user()->customer->scoreGames()->findOrFail($score_game);
            $qr_code = $score_game->qrCodes()->findOrFail($id);
            $qr_code->title = $request->input('title');
            $qr_code->point = $request->input('point');
            $qr_code->start_at = $request->input('start_at');
            $qr_code->finish_at = $request->input('finish_at');
            $qr_code->status = $request->input('status');
            if ($qr_code->save()) {
                $qr_code->updated_by = Auth::user()->id;
                $qr_code->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $score_game, int $id)
    {
        $score_game = Auth::user()->customer->scoreGames()->findOrFail($score_game);
        $qr_code = $score_game->qrCodes()->findOrFail($id);
        if ($qr_code->delete()) {
            $qr_code->deleted_by = Auth::user()->id;
            $qr_code->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
    public function download(int $meeting, int $score_game, int $id){
        $score_game = Auth::user()->customer->scoreGames()->findOrFail($score_game);
        $qr_code = $score_game->qrCodes()->findOrFail($id);
        
        // Ensure the qrcodes directory exists
        $directory = storage_path('app/qrcodes');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $path = $directory . '/' . $qr_code->code . '.svg';
        $contents = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($qr_code->code);
        
        file_put_contents($path, $contents);
        
        $filename = $qr_code->title . '_QRCode.svg';
        
        return response()->download($path, $filename)->deleteFileAfterSend();
    }
    public function qrCode(int $meeting, int $score_game, int $id)
    {
        $score_game = Auth::user()->customer->scoreGames()->findOrFail($score_game);
        $qr_code = $score_game->qrCodes()->findOrFail($id);
        return \SimpleSoftwareIO\QrCode\Facades\QrCode::size(256)->generate($qr_code->code);
    }
}
