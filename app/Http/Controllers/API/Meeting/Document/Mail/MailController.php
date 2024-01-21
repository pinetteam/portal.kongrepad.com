<?php

namespace App\Http\Controllers\API\Meeting\Document\Mail;

use App\Http\Controllers\Controller;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\Document\Mail\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    use ParticipantLog;
    public function store(Request $request){
        $documents = explode(',', str_replace(['[', "]"], "", $request->input('documents')));
        foreach ($documents as $document){
            $mail = new Mail();
            $mail->document_id = intval($document);
            $mail->participant_id = $request->user()->id;
            try{
                $mail->save();
            } catch (\Throwable $e){
                return [
                    'data' => null,
                    'status' => false,
                    'errors' => [$e->getMessage()]
                ];
            }
        }
        $this->logParticipantAction($request->user(), "send-mail", $request->input('documents'));
        return [
            'data' => null,
            'status' => true,
            'errors' => null
        ];
    }
    public function send_all(Request $request){

        /*$documents = $request->user()->meeting->documents()->get();
        foreach ($documents as $document){
            if(!$document->sharing_via_email)
                continue;
            elseif (Mail::where([['participant_id', $request->user()->id], ['document_id', $document->id]])->count() > 0)
                continue;
            $mail = new Mail();
            $mail->document_id = $document->id;
            $mail->participant_id = $request->user()->id;
            try{
                $mail->save();
            } catch (\Throwable $e){
                return [
                    'data' => null,
                    'status' => false,
                    'errors' => [$e->getMessage()]
                ];
            }
        }
        */
        $participant = $request->user();
        try{
            $participant->requested_all_documents = 1;
            $participant->save();
            $this->logParticipantAction($request->user(), "send-all-mail", __('common.meeting') . ': ' . $participant->meeting->title);
        } catch (\Throwable $e){
            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }
        return [
            'data' => null,
            'status' => true,
            'errors' => null
        ];
    }
}

