<?php

namespace App\Http\Controllers\License;

use App\Http\Controllers\Controller;
use App\Http\Requests\License\LicenseRequest;
use App\Models\Customer\Customer;
use App\Models\Customer\Setting\Setting;
use App\Models\Meeting\Hall\Hall;
use App\Models\Meeting\Meeting;
use App\Models\System\Country\Country;
use App\Models\User\User;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class LicenseController extends Controller
{
    public function index()
    {
        $phone_countries = Country::get();
        $timezones = [
            'Europe/Amsterdam' => ['value' => 'Europe/Amsterdam', 'title' => 'Europe/Amsterdam'],
            'Europe/Andorra' => ['value' => 'Europe/Andorra', 'title' => 'Europe/Andorra'],
            'Europe/Astrakhan' => ['value' => 'Europe/Astrakhan', 'title' => 'Europe/Astrakhan'],
            'Europe/Athens' => ['value' => 'Europe/Athens', 'title' => 'Europe/Athens'],
            'Europe/Belgrade' => ['value' => 'Europe/Belgrade', 'title' => 'Europe/Belgrade'],
            'Europe/Berlin' => ['value' => 'Europe/Berlin', 'title' => 'Europe/Berlin'],
            'Europe/Bratislava' => ['value' => 'Europe/Bratislava', 'title' => 'Europe/Bratislava'],
            'Europe/Brussels' => ['value' => 'Europe/Brussels', 'title' => 'Europe/Brussels'],
            'Europe/Bucharest' => ['value' => 'Europe/Bucharest', 'title' => 'Europe/Bucharest'],
            'Europe/Budapest' => ['value' => 'Europe/Budapest', 'title' => 'Europe/Budapest'],
            'Europe/Busingen' => ['value' => 'Europe/Busingen', 'title' => 'Europe/Busingen'],
            'Europe/Chisinau' => ['value' => 'Europe/Chisinau', 'title' => 'Europe/Chisinau'],
            'Europe/Copenhagen' => ['value' => 'Europe/Copenhagen', 'title' => 'Europe/Copenhagen'],
            'Europe/Dublin' => ['value' => 'Europe/Copenhagen', 'title' => 'Europe/Dublin'],
            'Europe/Gibraltar' => ['value' => 'Europe/Gibraltar', 'title' => 'Europe/Gibraltar'],
            'Europe/Guernsey' => ['value' => 'Europe/Guernsey', 'title' => 'Europe/Guernsey'],
            'Europe/Helsinki' => ['value' => 'Europe/Helsinki', 'title' => 'Europe/Helsinki'],
            'Europe/Isle_of_Man' => ['value' => 'Europe/Isle_of_Man', 'title' => 'Europe/Isle_of_Man'],
            'Europe/Istanbul' => ['value' => 'Europe/Istanbul', 'title' => 'Europe/Istanbul'],
            'Europe/Jersey' => ['value' => 'Europe/Jersey', 'title' => 'Europe/Jersey'],
            'Europe/Kaliningrad' => ['value' => 'Europe/Kaliningrad', 'title' => 'Europe/Kaliningrad'],
            'Europe/Kirov' => ['value' => 'Europe/Kirov', 'title' => 'Europe/Kirov'],
            'Europe/Kyiv' => ['value' => 'Europe/Kyiv', 'title' => 'Europe/Kyiv'],
            'Europe/Lisbon' => ['value' => 'Europe/Lisbon', 'title' => 'Europe/Lisbon'],
            'Europe/Ljubljana' => ['value' => 'Europe/Ljubljana', 'title' => 'Europe/Ljubljana'],
            'Europe/London' => ['value' => 'Europe/London', 'title' => 'Europe/London'],
            'Europe/Luxembourg' => ['value' => 'Europe/Luxembourg', 'title' => 'Europe/Luxembourg'],
            'Europe/Madrid' => ['value' => 'Europe/Madrid', 'title' => 'Europe/Madrid'],
            'Europe/Malta' => ['value' => 'Europe/Malta', 'title' => 'Europe/Malta'],
            'Europe/Mariehamn' => ['value' => 'Europe/Mariehamn', 'title' => 'Europe/Mariehamn'],
            'Europe/Minsk' => ['value' => 'Europe/Minsk', 'title' => 'Europe/Minsk'],
            'Europe/Monaco' => ['value' => 'Europe/Monaco', 'title' => 'Europe/Monaco'],
            'Europe/Moscow' => ['value' => 'Europe/Moscow', 'title' => 'Europe/Moscow'],
            'Europe/Oslo' => ['value' => 'Europe/Oslo', 'title' => 'Europe/Oslo'],
            'Europe/Paris' => ['value' => 'Europe/Paris', 'title' => 'Europe/Paris'],
            'Europe/Podgorica' => ['value' => 'Europe/Podgorica', 'title' => 'Europe/Podgorica'],
            'Europe/Prague' => ['value' => 'Europe/Prague', 'title' => 'Europe/Prague'],
            'Europe/Riga' => ['value' => 'Europe/Riga', 'title' => 'Europe/Riga'],
            'Europe/Rome' => ['value' => 'Europe/Rome', 'title' => 'Europe/Rome'],
            'Europe/Samara' => ['value' => 'Europe/Samara', 'title' => 'Europe/Samara'],
            'Europe/San_Marino' => ['value' => 'Europe/San_Marino', 'title' => 'Europe/San_Marino'],
            'Europe/Sarajevo' => ['value' => 'Europe/Sarajevo', 'title' => 'Europe/Sarajevo'],
            'Europe/Saratov' => ['value' => 'Europe/Saratov', 'title' => 'Europe/Saratov'],
            'Europe/Simferopol' => ['value' => 'Europe/Simferopol', 'title' => 'Europe/Simferopol'],
            'Europe/Skopje' => ['value' => 'Europe/Skopje', 'title' => 'Europe/Skopje'],
            'Europe/Sofia' => ['value' => 'Europe/Sofia', 'title' => 'Europe/Sofia'],
            'Europe/Stockholm' => ['value' => 'Europe/Stockholm', 'title' => 'Europe/Stockholm'],
            'Europe/Tallinn' => ['value' => 'Europe/Tallinn', 'title' => 'Europe/Tallinn'],
            'Europe/Tirane' => ['value' => 'Europe/Tirane', 'title' => 'Europe/Tirane'],
            'Europe/Ulyanovsk' => ['value' => 'Europe/Ulyanovsk', 'title' => 'Europe/Ulyanovsk'],
            'Europe/Vaduz' => ['value' => 'Europe/Vaduz', 'title' => 'Europe/Vaduz'],
            'Europe/Vatican' => ['value' => 'Europe/Vatican', 'title' => 'Europe/Vatican'],
            'Europe/Vienna' => ['value' => 'Europe/Vienna', 'title' => 'Europe/Vienna'],
            'Europe/Vilnius' => ['value' => 'Europe/Vilnius', 'title' => 'Europe/Vilnius'],
            'Europe/Volgograd' => ['value' => 'Europe/Volgograd', 'title' => 'Europe/Volgograd'],
            'Europe/Warsaw' => ['value' => 'Europe/Warsaw', 'title' => 'Europe/Warsaw'],
            'Europe/Zagreb' => ['value' => 'Europe/Zagreb', 'title' => 'Europe/Zagreb'],
            'Europe/Zurich' => ['value' => 'Europe/Zurich', 'title' => 'Europe/Zurich'],
        ];
        $date_formats = [
            'Y/m/d' => ['value' => 'Y/m/d', 'title' => 'Y/m/d'],
            'd/m/Y' => ['value' => 'd/m/Y', 'title' => 'd/m/Y'],
            'Y-m-d' => ['value' => 'Y-m-d', 'title' => 'Y-m-d'],
            'd-m-Y' => ['value' => 'd-m-Y', 'title' => 'd-m-Y'],
        ];
        $time_formats = [
            '24H' => ['value' => '24H', 'title' => '24-h'],
            '12H' => ['value' => '12H', 'title' => '12-h'],
        ];
        return view('portal.register.index', compact(['phone_countries', 'time_formats', 'date_formats', 'timezones']));
    }
    public function store(LicenseRequest $request)
    {
        if ($request->validated()) {
            $customer = new Customer();
            $customer->title = $request->input('title');
            $customer->code = Str::slug($request->input('title'));
            $customer->credit = 100;
            if ($request->has('logo')) {
                $logo = Image::make($request->file('logo'))->encode('data-url');
                $customer->logo = $logo;
            }
            if ($customer->save()) {
                Setting::insert([
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '1',
                        'value' => $request->input('web_address'),
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '2',
                        'value' => $request->input('email'),
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '3',
                        'value' => $request->input('phone_country') . ' ' . $request->input('phone'),
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '4',
                        'value' => $request->input('address'),
                    ],

                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '5',
                        'value' => $request->input('timezone') ?? 'Europe/Istanbul',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '6',
                        'value' => $request->input('date_format') ?? 'Y-m-d',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '7',
                        'value' => $request->input('time_format') ?? '24-h',
                    ],

                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '8',
                        'value' => 'https://www.facebook.com/',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '9',
                        'value' => 'https://www.instagram.com/',
                    ],
                    [
                        'customer_id' => $customer->id,
                        'variable_id' => '10',
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
                        'phone_country_id' => Country::where('phone_code', $request->input('phone_country'))->first()->id,
                        'phone' => $request->input('phone'),
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

                $meeting = new Meeting();
                $meeting->title = "test-meeting";
                $meeting->code = "test-meeting";
                $meeting->customer_id = $customer->id;
                $meeting->banner_name = null;
                $meeting->banner_extension = null;
                $meeting->type = "standard";
                $meeting->start_at = '2024-01-01';
                $meeting->finish_at = '2024-12-31';
                $meeting->status = 1;
                $meeting->save();
                $hall = new Hall();
                $hall->meeting_id = $meeting->id;
                $hall->code = Str::uuid()->toString();
                $hall->title = "test-hall";
                $hall->show_on_session = 1;
                $hall->show_on_view_program = 1;
                $hall->show_on_ask_question = 1;
                $hall->show_on_send_mail = 1;
                $hall->status = 1;
                $hall->save();
                $credentials = $request->only('username', 'password');
                if(Auth::attempt($credentials)){
                    $user = Auth::user();
                    $user->last_login_ip = $_SERVER['REMOTE_ADDR'];
                    $user->last_login_agent = $_SERVER['HTTP_USER_AGENT'];
                    $user->last_login_datetime = date("Y-m-d H:i:s");
                    $user->save();
                    return redirect()->route('portal.dashboard.index')->with('success', __('common.demo-account-created-successfully'));
                }
            } else {
                return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
}
