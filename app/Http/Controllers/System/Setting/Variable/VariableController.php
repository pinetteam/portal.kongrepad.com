<?php

namespace App\Http\Controllers\System\Setting\Variable;


use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\System\Setting\Variable\Variable;
use Illuminate\Support\Facades\Auth;

class VariableController extends Controller
{
    public function getDateFormat()
    {
        $date_format = Variable::where('variable', 'date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value;
        $date_format = str_replace("Y", "YYYY", $date_format);
        $date_format = str_replace("m", "MM", $date_format);
        $date_format = str_replace("d", "DD", $date_format);
        return response()->json(['date_format' => $date_format]);
    }
    public function getTimeFormat()
    {
        $time_format = Variable::where('variable', 'time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value;
        return response()->json(['time_format' => $time_format]);
    }
}
