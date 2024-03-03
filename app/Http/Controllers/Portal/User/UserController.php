<?php

namespace App\Http\Controllers\Portal\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\User\UserRequest;
use App\Http\Resources\Portal\User\UserPhoneResource;
use App\Http\Resources\Portal\User\UserResource;
use App\Models\System\Country\Country;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = Auth::user()->customer->users()->paginate(20);
        $user_roles = Auth::user()->customer->userRoles()->where('status', 1)->get();
        $phone_countries = Country::get();
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
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
    public function show(int $id)
    {
        $user = Auth::user()->customer->users()->findOrFail($id);
        return view('portal.user.show', compact(['user']));
    }
    public function edit(int $id)
    {
        $user = Auth::user()->customer->users()->findOrFail($id);
        return new UserResource($user);
    }
    public function get_phone(int $id)
    {
        $user = Auth::user()->customer->users()->findOrFail($id);
        return new UserPhoneResource($user);
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
    public function destroy(int $id)
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
