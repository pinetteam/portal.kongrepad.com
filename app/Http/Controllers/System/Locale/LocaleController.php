<?php

namespace App\Http\Controllers\System\Locale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocaleController extends Controller
{
    public function changeLocale(Request $request)
    {
        $locale = $request->input('locale');

        if (in_array($locale, ['tr', 'en'])) {
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }
}
