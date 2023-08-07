<?php

namespace App\Http\Controllers\API\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\MeetingRequest;
use App\Http\Resources\Portal\Meeting\MeetingResource;
use App\Models\Customer\Customer;
use App\Models\Meeting\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->meetings()->get();
    }
}
