@extends('layout.portal.meeting-detail')
@section('title', __('common.hall') . ' | ' . $hall->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $hall->meeting->id) }}">{{ $hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $hall->meeting->id]) }}">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $hall->title }}</li>
@endsection
@section('meeting_content')

<!-- Modern Hero Section -->
<div class="hero-section mb-4">
    <div class="hero-content p-4 text-white">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="hero-icon me-3">
                    <i class="fa-solid fa-door-open fa-2x"></i>
                </div>
                <div>
                    <h2 class="mb-1">{{ $hall->title }}</h2>
                    <p class="mb-0 opacity-75">{{ __('common.hall') }} Management</p>
                </div>
            </div>
            <div class="status-badge">
                @if($hall->status)
                    <span class="badge bg-success rounded-pill px-3 py-2">
                        <i class="fa-solid fa-toggle-on me-1"></i>Active
                    </span>
                @else
                    <span class="badge bg-danger rounded-pill px-3 py-2">
                        <i class="fa-solid fa-toggle-off me-1"></i>Inactive
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fa-solid fa-calendar-week text-white"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-number">{{ $hall->programs->count() }}</h3>
                <p class="stats-label">{{ __('common.programs') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(45deg, #e74c3c, #f39c12);">
                <i class="fa-solid fa-tv text-white"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-number">--</h3>
                <p class="stats-label">{{ __('common.screens') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(45deg, #9b59b6, #8e44ad);">
                <i class="fa-solid fa-users text-white"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-number">--</h3>
                <p class="stats-label">Sessions</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row g-4">
    <!-- Hall Information -->
    <div class="col-lg-8">
        <div class="modern-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fa-solid fa-info-circle me-2"></i>{{ __('common.hall') }} Information
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th scope="row" class="text-muted w-25 py-3">{{ __('common.meeting-title') }}:</th>
                            <td class="py-3">
                                @if($hall->status)
                                    <i class="fa-solid fa-toggle-on text-success me-2"></i>
                                @else
                                    <i class="fa-solid fa-toggle-off text-danger me-2"></i>
                                @endif
                                <strong>{{ $hall->title }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-muted py-3">{{ __('common.hall-program-count') }}:</th>
                            <td class="py-3">
                                <span class="badge bg-primary rounded-pill">{{ $hall->programs->count() }}</span>
                                {{ __('common.programs') }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-muted py-3">{{ __('common.created-by') }}:</th>
                            <td class="py-3">
                                <i class="fa-solid fa-user text-muted me-2"></i>{{ $hall->created_by_name }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-muted py-3">{{ __('common.created-at') }}:</th>
                            <td class="py-3">
                                <i class="fa-solid fa-calendar text-muted me-2"></i>{{ $hall->created_at }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="modern-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fa-solid fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <!-- Programs Section -->
                    <div class="action-group">
                        <h6 class="action-title">
                            <span class="badge bg-primary me-2">1</span>{{ __('common.programs') }}
                        </h6>
                        <a class="btn btn-primary w-100" href="{{ route('portal.meeting.hall.program.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}">
                            <i class="fa-solid fa-calendar-week me-2"></i>{{ __('common.programs') }}
                        </a>
                        <a class="btn btn-outline-secondary w-100 mt-2" href="{{ route('portal.meeting.hall.report.session.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}">
                            <i class="fa-solid fa-chart-bar me-2"></i>{{ __('common.session-reports') }}
                        </a>
                    </div>
                    
                    <!-- Screens Section -->
                    <div class="action-group">
                        <h6 class="action-title">
                            <span class="badge bg-warning me-2">2</span>{{ __('common.screens') }}
                        </h6>
                        <a class="btn btn-warning w-100" href="{{ route('portal.meeting.hall.screen.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}">
                            <i class="fa-solid fa-tv me-2"></i>{{ __('common.screens') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, var(--kongre-primary), var(--kongre-secondary));
    border-radius: 1rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.hero-icon {
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stats-card {
    background: var(--kongre-secondary);
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    transition: transform 0.2s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-icon {
    background: linear-gradient(45deg, #3498db, #2ecc71);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.stats-content {
    color: white;
}

.stats-number {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: white;
}

.stats-label {
    font-size: 0.9rem;
    opacity: 0.8;
    margin-bottom: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: none;
    overflow: hidden;
}

.modern-card .card-header {
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    border-bottom: 2px solid #ced4da;
    padding: 1.25rem;
    color: #212529;
    font-weight: 700;
    font-size: 1.1rem;
}

.modern-card .card-header h5 {
    color: #212529;
    font-weight: 700;
    margin-bottom: 0;
}

.modern-card .card-header i {
    color: #495057;
}

.action-group {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.75rem;
    border: 1px solid #e9ecef;
}

.action-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.btn {
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.table th {
    color: #6c757d !important;
    font-weight: 500;
}

.table td {
    color: #495057 !important;
    font-weight: 500;
}

.table strong {
    color: #2c3e50 !important;
}
</style>
@endsection
