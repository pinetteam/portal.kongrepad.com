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
                $file = $request->file('file');
                $file_name = $meeting->id . '-' . time() . '.' . $file->extension();
                $file_path = $file->storeAs('meetings/' . $meeting->id . '/documents', $file_name, 'public');
                $document->file_name = $file_name;
                $document->file_extension = $file->extension();
                $document->file_size = round($file->getSize() / 1024); // KB cinsinden
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
                if ($document->file_name && Storage::disk('public')->exists('meetings/' . $meeting->id . '/documents/' . $document->file_name)) {
                    Storage::disk('public')->delete('meetings/' . $meeting->id . '/documents/' . $document->file_name);
                }
                
                // Yeni dosyayı yükle
                $file = $request->file('file');
                $file_name = $meeting->id . '-' . time() . '.' . $file->extension();
                $file_path = $file->storeAs('meetings/' . $meeting->id . '/documents', $file_name, 'public');
                $document->file_name = $file_name;
                $document->file_extension = $file->extension();
                $document->file_size = round($file->getSize() / 1024); // KB cinsinden
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
        $meetingObj = Auth::user()->customer->meetings()->findOrFail($meeting);
        $file = $meetingObj->documents()->where('file_name', $document)->first();
        
        if ($file) {
            try {
                $file_path = 'meetings/' . $meeting . '/documents/' . $file->file_name;
                
                // Debug: Dosya yolunu ve var olup olmadığını kontrol et
                \Log::info('Download attempt', [
                    'file_path' => $file_path,
                    'file_exists' => Storage::disk('public')->exists($file_path),
                    'full_path' => storage_path('app/public/' . $file_path)
                ]);
                
                if (!Storage::disk('public')->exists($file_path)) {
                    return back()->with('error', 'File not found at: ' . $file_path)->withInput();
                }
                
                return Storage::disk('public')->download($file_path, $file->title . '.' . $file->file_extension);
            } catch (\Exception $e) {
                \Log::error('Download error', ['error' => $e->getMessage()]);
                return back()->with('error', __('common.file-not-found') . ' - ' . $e->getMessage())->withInput();
            }
        } else {
            return back()->with('error', __('common.there-is-no-such-file'))->withInput();
        }
    }
}
