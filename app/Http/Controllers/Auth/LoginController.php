<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login.index');
    }
    public function store(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->last_login_ip = $_SERVER['REMOTE_ADDR'];
            $user->last_login_agent = $_SERVER['HTTP_USER_AGENT'];
            $user->last_login_datetime = date("Y-m-d H:i:s");
            $user->save();
            if (Auth::user()->status === 1) {
                return redirect()->route('portal.dashboard.index')->with('success', __('common.you-have-successfully-logged-in'));
            } else {
                Auth::logout();
                return redirect()->route('auth.login.index');
            }
        } else {
            return back()->with('error', __('common.your-credentials-do-not-match'));
        }
    }
}
