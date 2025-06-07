@extends('layouts.guest')

@section('title', 'Kayıt - KongrePad')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-lg-5 col-md-6">
                <div class="auth-card">
                    <!-- Header -->
                    <div class="auth-header text-center">
                        <div class="company-logo mb-3">
                            <i class="fas fa-users-cog fa-3x text-success"></i>
                        </div>
                        <h2 class="auth-title">Hesap Oluştur</h2>
                        <p class="auth-subtitle">Yeni hesap bilgilerinizi girin</p>
                    </div>

                    <!-- Form -->
                    <div class="auth-form">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <x-forms.input 
                                name="name" 
                                label="Ad Soyad" 
                                required 
                                autofocus 
                            />

                            <x-forms.input 
                                name="email" 
                                type="email" 
                                label="E-posta Adresi" 
                                required 
                            />

                            <div class="mb-3">
                                <label for="password" class="form-label">Şifre</label>
                                <div class="password-field">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">En az 8 karakter olmalıdır</div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Şifre Tekrar</label>
                                <div class="password-field">
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" 
                                       id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    <a href="#" class="terms-link">Kullanım şartlarını</a> kabul ediyorum
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>
                                Hesap Oluştur
                            </button>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="auth-footer text-center">
                        <p class="mb-0">
                            Zaten hesabınız var mı? 
                            <a href="{{ route('login') }}" class="login-link">Giriş yapın</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.auth-page {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    min-height: 100vh;
}

.auth-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    padding: 2rem;
}

.auth-header {
    margin-bottom: 2rem;
}

.auth-title {
    color: #374151;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.auth-subtitle {
    color: #6b7280;
    margin-bottom: 0;
}

.password-field {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 5px;
}

.password-toggle:hover {
    color: #374151;
}

.terms-link, .login-link {
    color: #10b981;
    text-decoration: none;
    font-weight: 500;
}

.terms-link:hover, .login-link:hover {
    color: #059669;
    text-decoration: underline;
}

.btn-success {
    background: #10b981;
    border-color: #10b981;
    font-weight: 600;
    padding: 0.75rem 1rem;
}

.btn-success:hover {
    background: #059669;
    border-color: #059669;
}
</style>
@endpush

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggle = field.nextElementSibling.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        toggle.classList.remove('fa-eye');
        toggle.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        toggle.classList.remove('fa-eye-slash');
        toggle.classList.add('fa-eye');
    }
}
</script>
@endpush 