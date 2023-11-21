<?php

namespace App\Http\Controllers\Service\Screen;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Document\Document;
use App\Models\Meeting\Hall\Screen\Screen;

class DocumentController extends Controller
{
    public function index(string $meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        try {
            if($meeting_hall_screen->current_object_id){
                $document = Document::findOrFail($meeting_hall_screen->current_object_id);
            } else {
                $document = null;
            }
        } catch (\Exception $e) {
            $document = null;
        }
        return view('service.screen.document.index', compact(['meeting_hall_screen', 'document']));
    }
}
