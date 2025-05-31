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
    public function store(DocumentRequest $request, Meeting $meeting)
    {
        if ($request->validated()) {
            $document = new Document;
            $document->meeting_id = $request->meeting_id;
            $document->title = $request->input('title');
            if ($request->hasFile('file')) {
                $file_name = $meeting->id . '-' . time() . '.' . $request->file('file')->extension();
                $file_path = $request->file('file')->storeAs('meetings/' . $meeting->id . '/documents', $file_name, 'public');
                $document->file_name = $file_name;
                $document->file_path = $file_path;
            }
            $document->sharing_via_email = $request->input('sharing_via_email');
            $document->allowed_to_review = $request->input('allowed_to_review');
            $document->status = $request->input('status');
            $document->created_by = Auth::user()->id;

            if ($document->save()) {
                // AJAX yanıtı
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => __('common.created-successfully'),
                        'document' => $document
                    ]);
                }
                
                // Normal yanıt
                return redirect()->back()->with('success', __('common.created-successfully'));
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => __('common.a-system-error-has-occurred')
                    ]);
                }
                
                return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
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
    public function update(DocumentRequest $request, Meeting $meeting, Document $document)
    {
        if ($request->validated()) {
            $document->title = $request->input('title');
            
            if ($request->hasFile('file')) {
                // Eski dosya varsa sil
                if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
                
                // Yeni dosyayı yükle
                $file_name = $meeting->id . '-' . time() . '.' . $request->file('file')->extension();
                $file_path = $request->file('file')->storeAs('meetings/' . $meeting->id . '/documents', $file_name, 'public');
                $document->file_name = $file_name;
                $document->file_path = $file_path;
            }
            
            $document->sharing_via_email = $request->input('sharing_via_email');
            $document->allowed_to_review = $request->input('allowed_to_review');
            $document->status = $request->input('status');
            $document->updated_by = Auth::user()->id;

            if ($document->save()) {
                // AJAX yanıtı
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => __('common.edited-successfully'),
                        'document' => $document
                    ]);
                }
                
                // Normal yanıt
                return redirect()->back()->with('success', __('common.edited-successfully'));
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => __('common.a-system-error-has-occurred')
                    ]);
                }
                
                return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(Meeting $meeting, Document $document)
    {
        if ($document->delete()) {
            $document->deleted_by = Auth::user()->id;
            $document->save();
            
            // AJAX yanıtı
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('common.deleted-successfully'),
                    'deletedItemId' => 'document-row-' . $document->id
                ]);
            }
            
            // Normal yanıt
            return redirect()->back()->with('success', __('common.deleted-successfully'));
        } else {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('common.a-system-error-has-occurred')
                ]);
            }
            
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
    public function download(int $meeting, string $document)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $file = $meeting->documents()->where('file_name', $document)->first();
        if ($file) {
            try {
                return Storage::download('public/documents/' . $file->file_name . '.' . $file->file_extension);
            } catch (\Exception $e) {
                return back()->with('error', __('common.file-not-found'))->withInput();
            }
        } else {
            return back()->with('error', __('common.there-is-no-such-file'))->withInput();
        }
    }
}
