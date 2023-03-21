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
        $status_options = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        $customer = Auth::user()->customer;
        return view('portal.setting.index', compact(['customer', 'status_options']));
    }
    public function update(Request $request, $system_config)
    {

            $customer = Auth::user()->customer;
            $settings = Auth::user()->customer->setting;
            if ($request->has('logo')) {
                $logo = Image::make($request->file('logo'))->encode('data-url');
                $customer->logo = $logo;
            } else if ($request->has('value')){
                $settings[$system_config] = $request->input('value');
                $customer->setting = $settings;
            }
            if ($customer->save()) {
                return back()->with('success', __('common.updated-successfully'));
            } else {
                return back()->with('error', __('common.an-unexpected-error-has-occurred'))->withInput();
            }
        }

}
