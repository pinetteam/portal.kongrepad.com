<?php

namespace App\Http\Controllers\Portal\Meeting\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Document\DocumentRequest;
use App\Http\Resources\Portal\Meeting\Document\DocumentResource;
use App\Models\Meeting\Document\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(int $meeting)
    {
        $documents = Auth::user()->customer->documents()->paginate(20);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $sharing_via_emails = [
            'not-allowed' => ["value" => 0, "title" => __('common.not-allowed'), 'color' => 'danger'],
            'allowed' => ["value" => 1, "title" => __('common.allowed'), 'color' => 'success'],
        ];
        $statuses = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.document.index', compact(['documents', 'meeting', 'sharing_via_emails', 'statuses']));
    }
    public function store(DocumentRequest $request, int $meeting)
    {
        if ($request->validated()) {
            $document = new Document();
            $document->meeting_id = $meeting;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file_name = Str::uuid()->toString();
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('documents', $request->file('file'), $file_name.'.'.$file_extension)) {
                    $document->file_name = $file_name;
                    $document->file_extension = $file_extension;
                } else {
                    return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
            }
            $document->title = $request->input('title');
            $document->sharing_via_email = $request->input('sharing_via_email');
            $document->status = $request->input('status');
            if ($document->save()) {
                $document->created_by = Auth::user()->id;
                $document->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $id)
    {
        $document = Auth::user()->customer->documents()->where('meeting_id', $meeting)->findOrFail($id);
        return response()->file(storage_path('app/documents/'.$document->file_name.'.'.$document->file_extension));
    }
    public function edit(int $meeting, int $id)
    {
        $document = Auth::user()->customer->documents()->where('meeting_id', $meeting)->findOrFail($id);
        return new DocumentResource($document);
    }
    public function update(DocumentRequest $request, int $meeting, int $id)
    {
        if ($request->validated()) {
            $document = Auth::user()->customer->documents()->where('meeting_id', $meeting)->findOrFail($id);
            $document->meeting_id = $meeting;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file_name = $document->file_name;
                $file_extension = $file->getClientOriginalExtension();
                if(Storage::putFileAs('documents', $request->file('file'), $file_name.'.'.$file_extension)) {
                    $document->file_name = $file_name;
                    $document->file_extension = $file_extension;
                } else {
                    return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
            }
            $document->title = $request->input('title');
            $document->sharing_via_email = $request->input('sharing_via_email');
            $document->status = $request->input('status');
            if ($document->save()) {
                $document->edited_by = Auth::user()->id;
                $document->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $id)
    {
        $document = Auth::user()->customer->documents()->where('meeting_id', $meeting)->findOrFail($id);
        if ($document->delete()) {
            $document->deleted_by = Auth::user()->id;
            $document->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
