<?php

namespace App\Http\Controllers\Portal\User\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\User\Role\UserRoleRequest;
use App\Http\Resources\Portal\User\Role\RoleResource;
use App\Models\System\Route\Route;
use App\Models\User\Role\Role;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    public function index()
    {
        $user_roles = Auth()->user()->customer->userRoles()->paginate(20);
        $routes = json_decode(Route::get(), true);
        $statuses = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.user-role.index', compact(['user_roles', 'routes','statuses']));
    }
    public function store(UserRoleRequest $request)
    {
        if ($request->validated()) {
            $user_role = new Role();
            $user_role->customer_id = Auth::user()->customer->id;
            $user_role->title = $request->input('title');
            if ($request->has('access_scopes')) {
                $user_role->access_scopes = $request->input('access_scopes');
            } else {
                $user_role->access_scopes = [];
            }
            $user_role->status = $request->input('status');
            if ($user_role->save()) {
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
        $user_role = Auth::user()->customer->userRoles()->findOrFail($id);
        return new RoleResource($user_role);
    }
    public function update(UserRoleRequest $request, $id)
    {
        if ($request->validated()) {
            $user_role = Auth::user()->customer->userRoles()->findOrFail($id);
            $user_role->title = $request->input('title');
            if ($request->has('access_scopes')) {
                $user_role->access_scopes = $request->input('access_scopes');
            } else {
                $user_role->access_scopes = [];
            }
            $user_role->status = $request->input('status');
            if ($user_role->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy($id)
    {
        $user_role = Auth::user()->customer->userRoles()->findOrFail($id);
        if ($user_role->delete()) {
            $user_role->deleted_by = Auth::user()->id;
            $user_role->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
