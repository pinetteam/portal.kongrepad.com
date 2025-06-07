@extends('layouts.authenticated')

@section('title', 'Kongreler - KongrePad')

@section('content')
<div class="conferences-page">
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0">Kongreler</h1>
                        <p class="text-muted">Tüm konferanslarınızı yönetin</p>
                    </div>
                    <div>
                        <a href="{{ route('conferences.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Yeni Konferans
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <x-cards.base>
                    <form class="row g-3">
                        <div class="col-md-4">
                            <x-forms.input 
                                name="search" 
                                label="Arama" 
                                placeholder="Konferans adı ara..." 
                            />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Durum</label>
                            <select class="form-select" name="status">
                                <option value="">Tümü</option>
                                <option value="active">Aktif</option>
                                <option value="upcoming">Yaklaşan</option>
                                <option value="completed">Tamamlanan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <x-forms.input 
                                name="date" 
                                type="date" 
                                label="Tarih" 
                            />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-search me-1"></i>
                                Filtrele
                            </button>
                        </div>
                    </form>
                </x-cards.base>
            </div>
        </div>

        <!-- Conferences List -->
        <div class="row">
            @include('partials.conference-cards')
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                @include('partials.pagination')
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.conferences-page {
    background: #f8fafc;
    min-height: calc(100vh - 70px);
}

.conference-card {
    border: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.conference-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.conference-meta {
    margin-top: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.meta-item:last-child {
    margin-bottom: 0;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}
</style>
@endpush 