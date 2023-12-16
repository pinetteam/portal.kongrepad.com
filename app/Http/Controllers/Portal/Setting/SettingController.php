<?php

namespace App\Http\Controllers\Portal\Setting;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\Setting\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $setting_groups = Auth::user()->customer->settings()->get()->groupBy('group');
        return view('portal.setting.index', compact(['customer', 'setting_groups']));
    }
    public function update(Request $request, int $id)
    {
        $customer = Auth::user()->customer;
        $setting = Auth::user()->customer->settings()->findOrFail($id);
        if ($request->has('logo')) {
            $validated = $request->validate([
                'logo' => 'required|mimes:png',
            ]);
            if(!$validated){
                return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
            $logo = Image::make($request->file('logo'))->encode('data-url');
            $customer->logo = $logo;
        } else if ($request->has('value')) {
            $setting->value = $request->input('value');
        }
        if ($customer->save() && $setting->save()) {
            return back()->with('success', __('common.edited-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
