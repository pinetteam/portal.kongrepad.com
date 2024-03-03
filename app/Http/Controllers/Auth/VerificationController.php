<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\SMS\NetGSM\SendSMS;
use App\Http\Requests\Portal\User\PhoneRequest;
use App\Models\System\Country\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index()
    {
        $phone_countries = Country::get();
        return view('auth.sms-verification.index', compact(['phone_countries']));
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        if($request->input('code') == $user->verification_code){
            $user->phone_verified_at = now();
            $user->save();
            return redirect()->route('portal.dashboard.index')->with('success', __('common.you-have-verified-your-account'));
        } else {
            return back()->with('error', __('common.your-codes-do-not-match'));
        }
    }
    public function edit_phone(PhoneRequest $request)
    {
        $user = Auth::user();
        if($request->validated()){
            $user->phone_country_id = $request->input('phone_country_id');
            $user->phone = $request->input('phone');
            $user->save();
            return back()->with('success', __('common.edited-successfully'));
        } else {
            return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
    public function resend_code()
    {
        $user = Auth::user();
        try{
            $country = Country::findOrFail($user->phone_country_id);
            $auth_code = strval(mt_rand(100000, 999999));
            $user->verification_code = $auth_code;
            $user->save();
            SendSMS::toMany($country->phone_code, $user->phone, $auth_code . __('common.is-your-kongrepad-verification-code'));
            return back()->with('success', __('common.sms-send-successfully'));
        } catch(\Exception $e) {
            return back()->with('error', __('common.a-system-error-has-occurred'));
        }
    }
}
