@extends('layouts.authenticated')

@section('title', 'Dashboard - KongrePad')

@section('content')
<div class="dashboard-page">
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0">Dashboard</h1>
                        <p class="text-muted">Hoş geldiniz, {{ Auth::user()->display_name }}</p>
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

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <x-cards.base class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary text-white me-3">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Kongreler</h5>
                            <p class="card-text h4 mb-0">12</p>
                        </div>
                    </div>
                </x-cards.base>
            </div>
            <div class="col-md-3">
                <x-cards.base class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success text-white me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Katılımcılar</h5>
                            <p class="card-text h4 mb-0">1,248</p>
                        </div>
                    </div>
                </x-cards.base>
            </div>
            <div class="col-md-3">
                <x-cards.base class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info text-white me-3">
                            <i class="fas fa-microphone"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Oturumlar</h5>
                            <p class="card-text h4 mb-0">86</p>
                        </div>
                    </div>
                </x-cards.base>
            </div>
            <div class="col-md-3">
                <x-cards.base class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning text-white me-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Aktif Etkinlik</h5>
                            <p class="card-text h4 mb-0">3</p>
                        </div>
                    </div>
                </x-cards.base>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="row">
            <div class="col-lg-8">
                <x-cards.base title="Son Aktiviteler">
                    @include('partials.activity-list')
                </x-cards.base>
            </div>
            <div class="col-lg-4">
                <x-cards.base title="Hızlı Erişim">
                    <div class="d-grid gap-2">
                        <a href="{{ route('conferences.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-calendar-plus me-2"></i>
                            Konferans Oluştur
                        </a>
                        <a href="{{ route('conferences.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-list me-2"></i>
                            Konferans Listesi
                        </a>
                        <a href="#" class="btn btn-outline-info">
                            <i class="fas fa-chart-bar me-2"></i>
                            Raporlar
                        </a>
                        <a href="#" class="btn btn-outline-warning">
                            <i class="fas fa-cog me-2"></i>
                            Ayarlar
                        </a>
                    </div>
                </x-cards.base>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.dashboard-page {
    background: #f8fafc;
    min-height: calc(100vh - 70px);
}

.stat-card {
    border: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    padding: 1rem 0;
    border-bottom: 1px solid #e9ecef;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.activity-content h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.activity-content p {
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}
</style>
@endpush 