<?php

namespace App\Http\Controllers\Portal\Meeting\ScoreGame\QrCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\ScoreGame\QrCode\QrCodeRequest;
use App\Http\Resources\Portal\Meeting\ScoreGame\QRCode\QRCodeResource;
use App\Models\Meeting\ScoreGame\QRCode\QRCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class QRCodeController extends Controller
{
    public function index(string $meeting, string $score_game)
    {
        $score_game = Auth::user()->customer->scoreGames()->findOrFail($score_game);
        $qr_codes = $score_game->qrCodes()->paginate(20);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.score-game.qr-code.index', compact(['qr_codes', 'score_game', 'statuses']));
    }
    public function store(QrCodeRequest $request)
    {
        if ($request->validated()) {
            $qr_code = new QRCode();
            $qr_code->score_game_id = $request->input('score_game_id');
            $qr_code->start_at = $request->input('start_at');
            $qr_code->finish_at = $request->input('finish_at');
            $qr_code->point = $request->input('point');
            $qr_code->code = Str::uuid()->toString();
            $qr_code->title = $request->input('title');
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
    public function show(string $meeting, string $score_game, string $id)
    {

    }
    public function edit(string $meeting, string $score_game, string $id)
    {
        $qr_code = Auth::user()->customer->qrCodes()->findOrFail($id);
        return new QRCodeResource($qr_code);
    }
    public function update(QrCodeRequest $request, string $meeting, string $score_game, string $id)
    {
        if ($request->validated()) {
            $qr_code = Auth::user()->customer->qrCodes()->findOrFail($id);
            $qr_code->score_game_id = $request->input('score_game_id');
            $qr_code->title = $request->input('title');
            $qr_code->start_at = $request->input('start_at');
            $qr_code->finish_at = $request->input('finish_at');
            $qr_code->point = $request->input('point');
            $qr_code->status = $request->input('status');
            if ($qr_code->save()) {
                $qr_code->updated_by = Auth::user()->id;
                $qr_code->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $meeting, string $score_game, string $id)
    {

        $qr_code = Auth::user()->customer->qrCodes()->findOrFail($id);;
        if ($qr_code->delete()) {
            $qr_code->deleted_by = Auth::user()->id;
            $qr_code->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }

    public function download(string $meeting, string $score_game, string $id){
        $qr_code = Auth::user()->customer->qrCodes()->where('score_game_id', $score_game)->findOrFail($id);
        \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($qr_code->code, storage_path('app/qrcodes/' . $qr_code->code . '.svg'));
        return response()->download(storage_path('app/qrcodes/' . $qr_code->code . '.svg'));
    }


    public function qr_code(int $meeting, string $score_game, int $id)
    {
        $qr_code = Auth::user()->customer->qrCodes()->where('score_game_id', $score_game)->findOrFail($id);
        return \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($qr_code->code);
    }
}
