<?php

namespace App\Http\Controllers\Pages\Conferences;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.conferences.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.conferences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'city' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'registration_deadline' => 'nullable|date',
            'is_public' => 'boolean',
        ]);

        // TODO: Conference model'i oluşturup veritabanına kaydet
        
        return redirect()->route('conferences.index')
            ->with('success', 'Konferans başarıyla oluşturuldu!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pages.conferences.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.conferences.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
} 