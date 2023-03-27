<?php

namespace App\Http\Controllers\Portal\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Document\DocumentRequest;
use App\Http\Resources\Portal\Document\DocumentResource;
use App\Models\Document\Document;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Auth::user()->customer->documents()->paginate(20);
        $meetings = Auth::user()->customer->meetings;
        $participants = Auth::user()->customer->participants;
        $types = [
            'presentation' => ["value" => "presentation", "title" => __('common.presentation')],
            'publication' => ["value" => "publication", "title" => __('common.publication')],
            'other' => ["value" => "other", "title" => __('common.other')],
        ];
        $status_options = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.document.index', compact(['documents', 'meetings', 'participants', 'types', 'status_options']));
    }
    public function store(DocumentRequest $request)
    {
        if ($request->validated()) {
            $document = new Document();
            $document->meeting_id = $request->input('meeting_id');
            $document->participant_id = $request->input('participant_id');
            $document->title = $request->input('title');
            $document->type = $request->input('type');
            $document->status = $request->input('status');
            if ($document->save()) {
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        $document = Auth::user()->customer->documents()->findOrFail($id);
        return new DocumentResource($document);
    }
    public function update(DocumentRequest $request, string $id)
    {
        if ($request->validated()) {
            $document = Auth::user()->customer->documents()->findOrFail($id);
            $document->meeting_id = $request->input('meeting_id');
            $document->participant_id = $request->input('participant_id');
            $document->title = $request->input('title');
            $document->type = $request->input('type');
            $document->status = $request->input('status');
            if ($document->save()) {
                return back()->with('success',__('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(string $id)
    {
        $document = Auth::user()->customer->documents()->findOrFail($id);
        if ($document->delete()) {
            $document->deleted_by = Auth::user()->id;
            $document->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
}
