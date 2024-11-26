<?php

namespace App\Http\Controllers\EndUser\GetCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\EndUser\GetCode\GetCodeRequest;
use App\Jobs\EndUser\SendCodeByEmail;
use App\Jobs\EndUser\SendCodeViaSMS;
use App\Models\Meeting\Participant\Participant;

class GetCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('end-user.get-code.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(GetCodeRequest $request)
    {
        if ($request->validated()) {
            $type = $request->input('type');
            if ($type == 'email') {
                $participant = Participant::where('email', $request->input('email'))->orderBy('id', 'desc')->first();
                if($participant) {
                    dispatch(new SendCodeByEmail($participant));
                    return back()->with('success', __('common.you-will-be-informed-by-email-as-soon-as-possible'));
                } else {
                    return back()->with('error', __('common.no-such-user-found'));
                }
            } elseif ($type == 'sms') {
                $participant = Participant::where('phone', $request->input('phone'))->orderBy('id', 'desc')->first();
                if($participant) {
                    $recipient = ["$participant->phone"];
                    $message = 'Bu bir test mesajıdır.';
                    dispatch(new SendCodeViaSMS($recipient, $message));
                    return back()->with('success', __('common.you-will-be-informed-via-sms-as-soon-as-possible'));
                } else {
                    return back()->with('error', __('common.no-such-user-found'));
                }
            } else {
                abort(503);
            }
        }
    }
}
