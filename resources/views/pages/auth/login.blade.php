@extends('layouts.guest')

@section('title', 'Giriş - KongrePad')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-lg-5 col-md-6">
                <div class="auth-card">
                    <!-- Header -->
                    <div class="auth-header text-center">
                        <div class="company-logo mb-3">
                            <i class="fas fa-users-cog fa-3x text-primary"></i>
                        </div>
                        <h2 class="auth-title">Giriş Yap</h2>
                        <p class="auth-subtitle">Hesap bilgilerinizi girin</p>
                    </div>

                    <!-- Form -->
                    <div class="auth-form">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <x-forms.input 
                                name="email" 
                                type="email" 
                                label="E-posta Adresi" 
                                required 
                                autofocus 
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
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Beni hatırla
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Giriş Yap
                            </button>

                            <div class="auth-links text-center">
                                <a href="#" class="forgot-link">Şifremi unuttum</a>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="auth-footer text-center">
                        <p class="mb-0">
                            Hesabınız yok mu? 
                            <a href="{{ route('register') }}" class="register-link">Kayıt olun</a>
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

.forgot-link, .register-link {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
}

.forgot-link:hover, .register-link:hover {
    color: #2563eb;
    text-decoration: underline;
}

.btn-primary {
    background: #3b82f6;
    border-color: #3b82f6;
    font-weight: 600;
    padding: 0.75rem 1rem;
}

.btn-primary:hover {
    background: #2563eb;
    border-color: #2563eb;
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