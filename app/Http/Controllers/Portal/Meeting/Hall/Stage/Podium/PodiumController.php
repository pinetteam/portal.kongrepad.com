<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Stage\Podium;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Stage\Podium\PodiumRequest;
use App\Http\Resources\Portal\Meeting\Hall\Stage\Podium\PodiumResource;
use App\Models\Meeting\Hall\MeetingHall;
use App\Models\Meeting\Hall\Stage\Stage;
use Illuminate\Support\Facades\Auth;

class PodiumController extends Controller
{
    public function index()
    {

        $stages = Auth::user()->customer->stages()->where('stages.status', 1)->get();
        $podiums = Auth::user()->customer->podiums()->where('podiums.status', 1)->paginate(20);
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.podium.index', compact(['podiums', 'stages', 'statuses']));
    }
    public function store(PodiumRequest $request)
    {
        if ($request->validated()) {
            $podium = new Podium();
            $podium->meeting_hall_id = $request->input('meeting_hall_id');
            $podium->title = $request->input('title');
            $podium->status = $request->input('status');
            if ($podium->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        $podium = Auth::user()->customer->meetingHalls()->findOrFail($id);
        return new PodiumResource($podium);
    }
    public function update(PodiumRequest $request, string $id)
    {
        if ($request->validated()) {
            $podium = Auth::user()->customer->podiums()->findOrFail($id);
            $podium->meeting_hall_id = $request->input('meeting_hall_id');
            $podium->title = $request->input('title');
            $podium->status = $request->input('status');
            if ($podium->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
    {
        $podium = Auth::user()->customer->podiums()->findOrFail($id);
        if ($podium->delete()) {
            $podium->deleted_by = Auth::user()->id;
            $podium->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
