<?php

namespace App\Http\Controllers\API\Meeting\VirtualStand;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\VirtualStand\VirtualStandResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;

class VirtualStandController extends Controller
{
    use ParticipantLog;
    public function index(Request $request)
    {
        try{
            $meeting = $request->user()->meeting;
            $this->logParticipantAction($request->user(), "get-virtual-stands", __('common.meeting') . ': ' . $meeting->title);
            return [
                'data' => VirtualStandResource::collection($meeting->virtualStands()->where('meeting_virtual_stands.status', 1)->get())->shuffle(),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){
            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
    public function show(Request $request, string $id)
    {
        try{
            $stand = $request->user()->meeting->virtualStands()->where('meeting_virtual_stands.id',$id)->first();
            $this->logParticipantAction($request->user()->id, "get-virtual-stand", $stand->title);
            return [
                'data' => new VirtualStandResource($stand),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){
            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}
