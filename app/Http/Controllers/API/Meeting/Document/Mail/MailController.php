<?php

namespace App\Http\Controllers\API\Meeting\Document\Mail;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Document\Mail\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function store(Request $request){
        $documents = explode(',', str_replace(['[',"]"],"",$request->input('documents')));
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
                    'errors' => $e
                ];
            }
        }
        return [
            'data' => null,
            'status' => true,
            'errors' => null
        ];
    }
}

