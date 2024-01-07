<?php

namespace App\Http\Controllers\License;

use App\Http\Controllers\Controller;
use App\Http\Requests\License\LicenseRequest;
use App\Models\Customer\Customer;
use App\Models\Customer\Setting\Setting;
use App\Models\User\User;
use Faker\Factory;
use Illuminate\Support\Str;

class LicenseController extends Controller
{
    public function index()
    {
        return view('portal.demo.index');
    }
    public function store(LicenseRequest $request)
    {
        if ($request->validated()) {
            $customer = new Customer();
            $customer->title = $request->input('title');
            $customer->code = Str::slug($request->input('title'));
            if ($customer->save()) {
                Setting::insert([
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '1',
                        'value' => '',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '2',
                        'value' => $request->input('email'),
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '3',
                        'value' => '',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '4',
                        'value' => '',
                    ],

                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '5',
                        'value' => 'Europe/Istanbul',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '6',
                        'value' => 'Y-m-d H:i',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '7',
                        'value' => 'Y-m-d',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '8',
                        'value' => 'H:i:s',
                    ],

                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '9',
                        'value' => 'https://www.facebook.com/',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '10',
                        'value' => 'https://www.instagram.com/',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '11',
                        'value' => 'https://twitter.com/',
                    ],
                ]);
                $faker1 = Factory::create();
                User::insert([
                    [
                        'customer_id' => $customer->id,
                        'user_role_id' => '1',
                        'username' => $request->input('username'),
                        'first_name' => 'Manager',
                        'last_name' => $request->input('username'),
                        'email' => $request->input('email'),
                        'email_verified_at' => now(),
                        'phone_country_id' => '223',
                        'phone' => '5555555555',
                        'phone_verified_at' => now(),
                        'password' => bcrypt($request->input('password')),
                        'register_ip' => $faker1->ipv4,
                        'register_user_agent' => $faker1->userAgent,
                        'last_login_ip' => $faker1->ipv4,
                        'last_login_agent' => $faker1->userAgent,
                        'last_login_datetime' => date('Y-m-d H:i:s'),
                        'status' => 1,
                    ],
                ]);
                $remember = [
                    'remember' => ['value' => 1, 'title' => 'always-login-on-this-device'],
                ];
                return view('auth.login.index', compact('remember'))->with('success', __('common.created-successfully'));
            } else {
                return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function edit(int $id)
    {
        //
    }
    public function update(LicenseRequest $request, int $id)
    {
        //
    }
}
