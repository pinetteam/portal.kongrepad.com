@extends('layouts.authenticated')

@section('title', 'Yeni Konferans - KongrePad')

@section('content')
<div class="create-conference-page">
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0">Yeni Konferans</h1>
                        <p class="text-muted">Yeni bir konferans oluşturun</p>
                    </div>
                    <div>
                        <a href="{{ route('conferences.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Geri Dön
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conference Form -->
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('conferences.store') }}" method="POST">
                    @csrf
                    
                    <!-- Basic Information -->
                    <x-cards.base title="Temel Bilgiler" icon="fas fa-info-circle text-primary" class="mb-4">
                        <div class="row">
                            <div class="col-12">
                                <x-forms.input 
                                    name="title" 
                                    label="Konferans Adı" 
                                    required 
                                />
                            </div>
                            <div class="col-12">
                                <x-forms.textarea 
                                    name="description" 
                                    label="Açıklama" 
                                    rows="4" 
                                    required 
                                />
                            </div>
                            <div class="col-md-6">
                                <x-forms.input 
                                    name="start_date" 
                                    type="datetime-local" 
                                    label="Başlangıç Tarihi" 
                                    required 
                                />
                            </div>
                            <div class="col-md-6">
                                <x-forms.input 
                                    name="end_date" 
                                    type="datetime-local" 
                                    label="Bitiş Tarihi" 
                                    required 
                                />
                            </div>
                        </div>
                    </x-cards.base>

                    <!-- Location Information -->
                    <x-cards.base title="Konum Bilgileri" icon="fas fa-map-marker-alt text-success" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.input 
                                    name="city" 
                                    label="Şehir" 
                                />
                            </div>
                            <div class="col-md-6">
                                <x-forms.input 
                                    name="venue" 
                                    label="Mekan" 
                                />
                            </div>
                            <div class="col-12">
                                <x-forms.textarea 
                                    name="address" 
                                    label="Adres" 
                                    rows="3" 
                                />
                            </div>
                        </div>
                    </x-cards.base>

                    <!-- Settings -->
                    <x-cards.base title="Ayarlar" icon="fas fa-cog text-info" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.input 
                                    name="max_participants" 
                                    type="number" 
                                    label="Maksimum Katılımcı" 
                                    min="1"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-forms.input 
                                    name="registration_deadline" 
                                    type="datetime-local" 
                                    label="Kayıt Bitiş Tarihi" 
                                />
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_public" id="is_public" 
                                           {{ old('is_public') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_public">
                                        Herkese açık konferans
                                    </label>
                                </div>
                            </div>
                        </div>
                    </x-cards.base>

                    <!-- Form Actions -->
                    <x-cards.base>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Konferansı Oluştur
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>
                                Önizleme
                            </button>
                            <a href="{{ route('conferences.index') }}" class="btn btn-outline-secondary ms-auto">
                                <i class="fas fa-times me-2"></i>
                                İptal
                            </a>
                        </div>
                    </x-cards.base>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <x-cards.base title="İpuçları" icon="fas fa-lightbulb text-warning">
                    <div class="alert alert-info">
                        <small>
                            <strong>Konferans Adı:</strong> Açıklayıcı ve kısa bir başlık seçin.
                        </small>
                    </div>
                    <div class="alert alert-success">
                        <small>
                            <strong>Açıklama:</strong> Konferansın amacını ve içeriğini detaylandırın.
                        </small>
                    </div>
                    <div class="alert alert-warning">
                        <small>
                            <strong>Tarihler:</strong> Başlangıç tarihi bitiş tarihinden önce olmalıdır.
                        </small>
                    </div>
                </x-cards.base>

                <x-cards.base title="Son Aktiviteler" icon="fas fa-clock text-primary" class="mt-4">
                    @include('partials.activity-list')
                </x-cards.base>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.create-conference-page {
    background: #f8fafc;
    min-height: calc(100vh - 70px);
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: #fff;
    border-bottom: 1px solid #e9ecef;
}

.activity-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.activity-item:last-child {
    border-bottom: none;
}

.form-label {
    font-weight: 600;
    color: #374151;
}

.text-danger {
    color: #dc3545 !important;
}
</style>
@endpush 