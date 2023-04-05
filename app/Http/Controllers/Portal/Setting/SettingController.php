<?php

namespace App\Http\Controllers\Portal\Setting;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        return view('portal.setting.index', compact(['customer']));
    }
    public function update(Request $request, $system_config)
    {
        $customer = Auth::user()->customer;
        $settings = Auth::user()->customer->settings;
        if ($request->has('logo')) {
            $logo = Image::make($request->file('logo'))->encode('data-url');
            $customer->logo = $logo;
        } else if ($request->has('value')) {
            $settings[$system_config] = $request->input('value');
            $customer->settings = $settings;
        }
        if ($customer->save()) {
            return back()->with('success', __('common.edited-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
