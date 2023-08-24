<?php

namespace App\Http\Controllers\API\Meeting\VirtualStand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VirtualStandController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->meeting->virtualStands()->get();
    }
    public function show(Request $request, string $id)
    {
        return $request->user()->meeting->virtualStands()->where('meeting_virtual_stands.id',$id)->first();
    }
}
