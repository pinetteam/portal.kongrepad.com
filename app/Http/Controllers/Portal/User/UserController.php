<?php

namespace App\Http\Controllers\Portal\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\User\UserRequest;
use App\Http\Resources\Portal\User\UserResource;
use App\Models\System\Country\SystemCountry;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = Auth::user()->customer->users()->paginate(20);
        $user_roles = Auth::user()->customer->userRoles;
        $phone_countries = SystemCountry::get();
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.user.index', compact(['users', 'user_roles', 'phone_countries', 'statuses']));
    }
    public function store(UserRequest $request)
    {
        if ($request->validated()) {
            $user = new User();
            $user->customer_id = Auth::user()->customer->id;
            $user->user_role_id = $request->input('user_role_id');
            $user->username = $request->input('username');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->phone_country_id = $request->input('phone_country_id');
            $user->phone = $request->input('phone');
            $user->password = bcrypt($request->input('password'));
            $user->status = $request->input('status');
            if ($user->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $user = Auth::user()->customer->users()->findOrFail($id);
        return new UserResource($user);
    }
    public function update(UserRequest $request, $id)
    {
        if ($request->validated()) {
            $user = Auth::user()->customer->users()->findOrFail($id);
            $user->user_role_id = $request->input('user_role_id');
            $user->username = $request->input('username');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->phone_country_id = $request->input('phone_country_id');
            $user->phone = $request->input('phone');
            if ($request->has('password')) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->status = $request->input('status');
            if ($user->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy($id)
    {
        $user = Auth::user()->customer->users()->findOrFail($id);
        if(Auth::user()->id == $id){
            return back()->with('warning',__('common.you-can-not-delete-your-own-record'));
        }
        else if ($user->delete()) {
            $user->deleted_by = Auth::user()->id;
            $user->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
