<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $meetings = User::where('id',1)->first()->customer->meetings()->where('status','1')->paginate(20);

        return $meetings;
    }
}
