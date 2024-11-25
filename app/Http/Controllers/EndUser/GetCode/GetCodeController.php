<?php

namespace App\Http\Controllers\EndUser\GetCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\EndUser\GetCode\GetCodeRequest;

class GetCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('end-user.get-code.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(GetCodeRequest $request)
    {
        if ($request->validated()) {
            $type = $request->input('type');
            if ($type == 'email') {
                return 'eposta gönderildi';

            } elseif ($type == 'sms') {
                return 'telefon gönderildi';

            } else {
                abort(503);
            }
        }
    }
}
