<?php

namespace App\Http\Controllers\Portal\Meeting\ScoreGame\QrCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\ScoreGame\QrCode\QrCodeRequest;
use App\Http\Resources\Portal\Meeting\ScoreGame\QrCode\QrCodeResource;
use App\Models\Meeting\ScoreGame\QrCode\QrCode;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class QrCodeController extends Controller
{
    public function index()
    {
        $qr_codes = Auth::user()->customer->qrCodes()->paginate(20);
        $score_games = Auth::user()->customer->scoreGames()->where('status', 1)->get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.qr-code.index', compact(['qr_codes', 'score_games', 'statuses']));
    }
    public function store(QrCodeRequest $request)
    {
        if ($request->validated()) {
            $qr_code = new QrCode();
            $qr_code->score_game_id = $request->input('score_game_id');
            $qr_code->start_at = $request->input('start_at');
            $qr_code->finish_at = $request->input('finish_at');
            $qr_code->point = $request->input('point');
            if ($request->has('logo')) {
                $logo = Image::make($request->file('logo'))->encode('data-url');
                $qr_code->logo = $logo;
            }
            $qr_code->code = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate('http://kongrepad.com/qr/'.$qr_code->id);
            $qr_code->title = $request->input('title');
            $qr_code->status = $request->input('status');
            if ($qr_code->save()) {
                $qr_code->code = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate('http://kongrepad.com/qr/'.$qr_code->id, storage_path('app/qrcodes/qrcode-'.$qr_code->id.'.svg'));
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $id)
    {
        $qr_code = Auth::user()->customer->qrCodes()->findOrFail($id);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.qr-code.show', compact(['qr_code', 'statuses']));

    }
    public function edit(string $id)
    {
        $qr_code = Auth::user()->customer->qrCodes()->findOrFail($id);
        return new QrCodeResource($qr_code);
    }
    public function update(QrCodeRequest $request, string $id)
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
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
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

    public function download(string $id){
        return response()->download(storage_path('app/qrcodes/qrcode-'.$id.'.svg'));
    }
}
