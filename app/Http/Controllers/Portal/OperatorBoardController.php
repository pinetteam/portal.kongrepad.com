<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;

class OperatorBoardController extends Controller
{
    public function index()
    {
        return view('portal.operator-board.index');
    }
}
