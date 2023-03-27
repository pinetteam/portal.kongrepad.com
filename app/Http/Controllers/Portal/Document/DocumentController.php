<?php

namespace App\Http\Controllers\Portal\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Document\DocumentRequest;
use App\Http\Resources\Portal\Document\DocumentResource;
use App\Models\Document\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Auth::user()->customer->documents()->paginate(20);
        $participants = Auth::user()->customer->participants()->get();
        $types = [
            'presentation' => ["value" => "presentation", "title" => __('common.presentation')],
            'publication' => ["value" => "publication", "title" => __('common.publication')],
            'other' => ["value" => "other", "title" => __('common.other')],
        ];
        $sharing_via_email_options = [
            'not-allowed' => ["value" => 0, "title" => __('common.not-allowed'), 'color' => 'danger'],
            'allowed' => ["value" => 1, "title" => __('common.allowed'), 'color' => 'success'],
        ];
        $status_options = [
            'active' => ["value" => 0, "title" => __('common.passive'), 'color' => 'danger'],
            'passive' => ["value" => 1, "title" => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.document.index', compact(['documents', 'participants', 'types', 'sharing_via_email_options', 'status_options']));
    }
    public function store(DocumentRequest $request)
    {
        if ($request->validated()) {
            $document = new Document();
            $document->participant_id = $request->input('participant_id');
            $document->title = $request->input('title');
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
            $document->participant_id = $request->input('participant_id');
            $document->title = $request->input('title');
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
            $document->type = $request->input('type');
            $document->sharing_via_email = $request->input('sharing_via_email');
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
