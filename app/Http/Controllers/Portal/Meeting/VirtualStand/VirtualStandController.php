<?php

namespace App\Http\Controllers\Portal\Meeting\VirtualStand;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\VirtualStand\VirtualStandRequest;
use App\Http\Resources\Portal\Meeting\VirtualStand\VirtualStandResource;
use App\Models\Meeting\VirtualStand\VirtualStand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VirtualStandController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $virtual_stands = $meeting->virtualStands()->paginate(20);
        $statuses = [
            'passive' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'active' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.virtual-stand.index', compact(['virtual_stands', 'meeting', 'statuses']));
    }
    public function store(VirtualStandRequest $request, int $meeting)
    {
        if ($request->validated()) {
            $virtual_stand = new VirtualStand();
            $virtual_stand->meeting_id = $meeting;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file_name = Str::uuid()->toString();
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('virtual-stands', $request->file('file'), $file_name.'.'.$file_extension)) {
                    $virtual_stand->file_name = $file_name;
                    $virtual_stand->file_extension = $file_extension;
                    $virtual_stand->file_size = $request->file('file')->getSize();
                } else {
                    return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
            }
            $virtual_stand->title = $request->input('title');
            $virtual_stand->status = $request->input('status');
            if ($virtual_stand->save()) {
                $virtual_stand->created_by = Auth::user()->id;
                $virtual_stand->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $id)
    {
        $virtual_stand = Auth::user()->customer->virtualStands()->where('meeting_id', $meeting)->findOrFail($id);
        return response()->file(storage_path('app/virtual-stands/'.$virtual_stand->file_name.'.'.$virtual_stand->file_extension));
    }
    public function edit(int $meeting, int $id)
    {
        $virtual_stand = Auth::user()->customer->virtualStands()->where('meeting_id', $meeting)->findOrFail($id);
        return new VirtualStandResource($virtual_stand);
    }
    public function update(VirtualStandRequest $request, int $meeting, int $id)
    {
        if ($request->validated()) {
            $virtual_stand = Auth::user()->customer->virtualStands()->where('meeting_id', $meeting)->findOrFail($id);
            $virtual_stand->meeting_id = $meeting;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file_name = $virtual_stand->file_name;
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('virtual-stands', $request->file('file'), $file_name.'.'.$file_extension)) {
                    $virtual_stand->file_name = $file_name;
                    $virtual_stand->file_extension = $file_extension;
                    $virtual_stand->file_size = $request->file('file')->getSize();
                } else {
                    return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
            }
            $virtual_stand->title = $request->input('title');
            $virtual_stand->status = $request->input('status');
            if ($virtual_stand->save()) {
                $virtual_stand->updated_by = Auth::user()->id;
                $virtual_stand->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $id)
    {
        $virtual_stand = Auth::user()->customer->virtualStands()->where('meeting_id', $meeting)->findOrFail($id);
        if ($virtual_stand->delete()) {
            $virtual_stand->deleted_by = Auth::user()->id;
            $virtual_stand->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
    public function download(int $meeting, string $virtual_stand)
    {
        $file = VirtualStand::where('meeting_id', $meeting)->where('file_name', $virtual_stand)->first();
        if ($file) {
            try {
                return Storage::download('virtual-stands/' . $file->file_name . '.' . $file->file_extension);
            } catch (\Exception $e) {
                return back()->with('error', __('common.file-not-found'))->withInput();
            }
        } else {
            return back()->with('error', __('common.there-is-no-such-file'))->withInput();
        }
    }
}
