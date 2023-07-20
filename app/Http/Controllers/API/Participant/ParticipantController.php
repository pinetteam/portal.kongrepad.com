<?php

namespace App\Http\Controllers\API\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        return $request->user();
    }
}
