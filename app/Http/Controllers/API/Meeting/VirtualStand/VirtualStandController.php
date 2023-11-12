<?php

namespace App\Http\Controllers\API\Meeting\VirtualStand;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\VirtualStand\VirtualStandResource;
use Illuminate\Http\Request;

class VirtualStandController extends Controller
{
    public function index(Request $request)
    {
        try{
            return [
                'data' => VirtualStandResource::collection($request->user()->meeting->virtualStands()->where('meeting_virtual_stands.status', 1)->get())->shuffle(),
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
            return [
                'data' => new VirtualStandResource($request->user()->meeting->virtualStands()->where('meeting_virtual_stands.id',$id)->first()),
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
