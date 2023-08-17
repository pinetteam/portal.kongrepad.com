<?php

namespace App\Http\Controllers\Portal\Meeting\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Document\DocumentRequest;
use App\Http\Resources\Portal\Meeting\Document\DocumentResource;
use App\Models\Meeting\Document\Document;
use App\Models\Meeting\Meeting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $documents = $meeting->documents()->paginate(20);
        $sharing_via_emails = [
            'not-allowed' => ['value' => 0, 'title' => __('common.not-allowed'), 'color' => 'danger'],
            'allowed' => ['value' => 1, 'title' => __('common.allowed'), 'color' => 'success'],
        ];
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.document.index', compact(['meeting', 'documents', 'sharing_via_emails', 'statuses']));
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
                if(Storage::putFileAs('public/documents', $request->file('file'), $file_name.'.'.$file_extension)) {
                    $document->file_name = $file_name;
                    $document->file_extension = $file_extension;
                    $document->file_size = $request->file('file')->getSize();
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
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $document = $meeting->documents()->findOrFail($id);
        return view('portal.meeting.document.show', compact(['meeting', 'document']));
    }
    public function edit(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $document = $meeting->documents()->findOrFail($id);
        return new DocumentResource($document);
    }
    public function update(DocumentRequest $request, int $meeting, int $id)
    {
        if ($request->validated()) {
            $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
            $document = $meeting->documents()->findOrFail($id);
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file_name = $document->file_name;
                $file_extension = $file->getClientOriginalExtension();
                if (Storage::putFileAs('public/documents', $request->file('file'), $file_name.'.'.$file_extension)) {
                    $document->file_name = $file_name;
                    $document->file_extension = $file_extension;
                    $document->file_size = $request->file('file')->getSize();
                } else {
                    return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
                }
            }
            $document->title = $request->input('title');
            $document->sharing_via_email = $request->input('sharing_via_email');
            $document->status = $request->input('status');
            if ($document->save()) {
                $document->updated_by = Auth::user()->id;
                $document->save();
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $document = $meeting->documents()->findOrFail($id);
        if ($document->delete()) {
            $document->deleted_by = Auth::user()->id;
            $document->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
    public function download(int $meeting, string $document)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $file = $meeting->documents()->where('file_name', $document)->first();
        if ($file) {
            try {
                return Storage::download('documents/' . $file->file_name . '.' . $file->file_extension);
            } catch (\Exception $e) {
                return back()->with('error', __('common.file-not-found'))->withInput();
            }
        } else {
            return back()->with('error', __('common.there-is-no-such-file'))->withInput();
        }
    }
}
