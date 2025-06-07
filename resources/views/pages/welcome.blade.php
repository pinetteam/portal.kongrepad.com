@extends('layouts.guest')

@section('title', 'KongrePad - Hoş Geldiniz')

@section('content')
<div class="welcome-page" x-data="welcomePage()" x-init="init()">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row min-vh-100 align-items-center justify-content-center">
                <div class="col-lg-8 text-center">
                    <!-- Animated Logo -->
                    <div class="logo-container mb-4" 
                         x-show="logoVisible" 
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0 scale-75 -translate-y-12"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                        <div class="logo-glow">
                            <i class="fas fa-users-cog fa-6x text-white mb-3"></i>
                        </div>
                    </div>

                    <!-- Animated Title -->
                    <div x-show="titleVisible" 
                         x-transition:enter="transition ease-out duration-1000 delay-300"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h1 class="display-2 fw-bold mb-3 gradient-text">
                            KongrePad
                        </h1>
                    </div>

                    <!-- Typing Animation Subtitle -->
                    <div class="subtitle-container mb-5"
                         x-show="subtitleVisible"
                         x-transition:enter="transition ease-out duration-800 delay-600"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                        <p class="lead typing-text" x-text="currentText"></p>
                        <span class="typing-cursor" x-show="showCursor">|</span>
                    </div>

                    <!-- Animated Feature Cards -->
                    <div class="feature-cards row mb-5" 
                         x-show="cardsVisible"
                         x-transition:enter="transition ease-out duration-800 delay-900"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="col-md-4 mb-3">
                            <div class="feature-card glass-card" 
                                 @mouseenter="animateCard($event)" 
                                 @mouseleave="resetCard($event)">
                                <div class="feature-icon">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <h5>Hızlı & Güvenli</h5>
                                <p>Modern teknoloji ile güvenli konferans yönetimi</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="feature-card glass-card" 
                                 @mouseenter="animateCard($event)" 
                                 @mouseleave="resetCard($event)">
                                <div class="feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h5>Kolay Kullanım</h5>
                                <p>Sezgisel arayüz ile dakikalar içinde başlayın</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="feature-card glass-card" 
                                 @mouseenter="animateCard($event)" 
                                 @mouseleave="resetCard($event)">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h5>Analitik & Rapor</h5>
                                <p>Detaylı raporlar ve analiz araçları</p>
                            </div>
                        </div>
                    </div>

                    <!-- Animated Action Buttons -->
                    <div class="action-buttons"
                         x-show="buttonsVisible"
                         x-transition:enter="transition ease-out duration-800 delay-1200"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="button-group mb-4">
                            <a href="{{ route('login') }}" 
                               class="btn btn-primary btn-lg me-3 glow-button"
                               @mouseenter="pulseEffect($event)"
                               @mouseleave="resetPulse($event)">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                <span>Giriş Yap</span>
                                <div class="button-glow"></div>
                            </a>
                            <a href="{{ route('register') }}" 
                               class="btn btn-outline-light btn-lg"
                               @mouseenter="pulseEffect($event)"
                               @mouseleave="resetPulse($event)">
                                <i class="fas fa-user-plus me-2"></i>
                                <span>Kayıt Ol</span>
                                <div class="button-glow"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Particles -->
        <div class="floating-particles" x-show="particlesVisible">
            <template x-for="(particle, index) in particles" :key="`particle-${index}-${particle.x}-${particle.y}`">
                <div class="particle" 
                     :style="`left: ${particle.x}%; top: ${particle.y}%; animation-delay: ${particle.delay}s; animation-duration: ${particle.duration}s;`">
                </div>
            </template>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator" 
             x-show="scrollVisible"
             x-transition:enter="transition ease-out duration-500 delay-1500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="scrollToFeatures()">
            <div class="scroll-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
            <span>Keşfet</span>
        </div>
    </section>

    <!-- Features Section with integrated demo -->
    <section id="features" class="features-section py-5" 
             x-intersect.once="featuresVisible = true">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6"
                     x-show="featuresVisible"
                     x-transition:enter="transition ease-out duration-800"
                     x-transition:enter-start="opacity-0 -translate-x-8"
                     x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="features-content">
                        <h2 class="h1 mb-4">Profesyonel Konferans Yönetimi</h2>
                        <p class="lead mb-4">
                            Modern teknoloji ile konferanslarınızı organize edin, 
                            katılımcıları yönetin ve başarılı etkinlikler düzenleyin.
                        </p>
                        <div class="feature-list">
                            <div class="feature-item" x-intersect.once="$el.classList.add('animate-in')">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                Sınırsız konferans ve oturum yönetimi
                            </div>
                            <div class="feature-item" x-intersect.once="$el.classList.add('animate-in')">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                Gerçek zamanlı katılımcı takibi
                            </div>
                            <div class="feature-item" x-intersect.once="$el.classList.add('animate-in')">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                Detaylı analitik ve raporlama
                            </div>
                            <div class="feature-item" x-intersect.once="$el.classList.add('animate-in')">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                Çoklu dil ve mobil uyumluluk
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6"
                     x-show="featuresVisible"
                     x-transition:enter="transition ease-out duration-800 delay-300"
                     x-transition:enter-start="opacity-0 translate-x-8"
                     x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="demo-visual">
                        <div class="demo-mockup">
                            <div class="mockup-header">
                                <div class="mockup-dots">
                                    <span></span><span></span><span></span>
                                </div>
                            </div>
                            <div class="mockup-content">
                                <div class="dashboard-preview">
                                    <div class="preview-item" x-intersect.once="$el.classList.add('slide-in')">
                                        <i class="fas fa-calendar text-primary"></i>
                                        <span>12 Konferans</span>
                                    </div>
                                    <div class="preview-item" x-intersect.once="$el.classList.add('slide-in')">
                                        <i class="fas fa-users text-success"></i>
                                        <span>1,248 Katılımcı</span>
                                    </div>
                                    <div class="preview-item" x-intersect.once="$el.classList.add('slide-in')">
                                        <i class="fas fa-microphone text-info"></i>
                                        <span>86 Oturum</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Integrated CTA Section -->
            <div class="cta-section text-center"
                 x-show="featuresVisible"
                 x-transition:enter="transition ease-out duration-800 delay-600"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h3 class="h2 mb-3">Hemen Başlayın</h3>
                        <p class="lead text-muted mb-4">
                            Konferans yönetiminde yeni deneyimi keşfedin. 
                            Dakikalar içinde kurulum yapın ve organizasyonunuzu başlatın.
                        </p>
                        <div class="cta-buttons">
                            <a href="{{ route('register') }}" 
                               class="btn btn-primary btn-lg me-3"
                               @mouseenter="pulseEffect($event)"
                               @mouseleave="resetPulse($event)">
                                <i class="fas fa-rocket me-2"></i>
                                Ücretsiz Başla
                            </a>
                            <a href="{{ route('login') }}" 
                               class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Giriş Yap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Integrated Footer -->
    <footer class="integrated-footer py-4 mt-5" 
            x-intersect.once="footerVisible = true">
        <div class="container">
            <div class="row align-items-center"
                 x-show="footerVisible"
                 x-transition:enter="transition ease-out duration-800"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users-cog text-primary me-2"></i>
                        <span class="fw-bold">KongrePad</span>
                        <span class="text-muted ms-2">© {{ date('Y') }}</span>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-muted">
                        Profesyonel Konferans Yönetim Sistemi
                    </span>
                </div>
            </div>
        </div>
    </footer>
</div>

<script>
function welcomePage() {
    return {
        // Animation states
        logoVisible: false,
        titleVisible: false,
        subtitleVisible: false,
        cardsVisible: false,
        buttonsVisible: false,
        scrollVisible: false,
        featuresVisible: false,
        footerVisible: false,
        particlesVisible: false,
        
        // Typing animation
        currentText: '',
        fullText: 'Profesyonel konferans yönetim sistemine hoş geldiniz',
        typeIndex: 0,
        showCursor: true,
        
        // Particles - initialize as empty array
        particles: [],
        
        init() {
            this.startAnimationSequence();
            this.generateParticles();
            this.startCursorBlink();
        },
        
        startAnimationSequence() {
            // Logo animation
            setTimeout(() => this.logoVisible = true, 200);
            
            // Title animation
            setTimeout(() => this.titleVisible = true, 800);
            
            // Subtitle and typing animation
            setTimeout(() => {
                this.subtitleVisible = true;
                this.startTyping();
            }, 1400);
            
            // Cards animation
            setTimeout(() => this.cardsVisible = true, 2200);
            
            // Buttons animation
            setTimeout(() => this.buttonsVisible = true, 2800);
            
            // Scroll indicator
            setTimeout(() => this.scrollVisible = true, 3400);
            
            // Particles animation
            setTimeout(() => this.particlesVisible = true, 1000);
        },
        
        startTyping() {
            const typing = setInterval(() => {
                if (this.typeIndex < this.fullText.length) {
                    this.currentText += this.fullText.charAt(this.typeIndex);
                    this.typeIndex++;
                } else {
                    clearInterval(typing);
                }
            }, 50);
        },
        
        startCursorBlink() {
            setInterval(() => {
                this.showCursor = !this.showCursor;
            }, 500);
        },
        
        generateParticles() {
            // Clear existing particles first
            this.particles = [];
            
            // Generate unique particles with timestamp for uniqueness
            const timestamp = Date.now();
            for (let i = 0; i < 50; i++) {
                this.particles.push({
                    id: `${timestamp}-${i}`,
                    x: Math.random() * 100,
                    y: Math.random() * 100,
                    delay: Math.random() * 10,
                    duration: 15 + Math.random() * 10
                });
            }
        },
        
        animateCard(event) {
            const card = event.currentTarget;
            card.style.transform = 'translateY(-10px) scale(1.02)';
            card.style.boxShadow = '0 20px 40px rgba(255, 255, 255, 0.1)';
        },
        
        resetCard(event) {
            const card = event.currentTarget;
            card.style.transform = 'translateY(0) scale(1)';
            card.style.boxShadow = '0 8px 32px rgba(0, 0, 0, 0.1)';
        },
        
        pulseEffect(event) {
            const button = event.currentTarget;
            button.classList.add('pulse-active');
        },
        
        resetPulse(event) {
            const button = event.currentTarget;
            button.classList.remove('pulse-active');
        },
        
        scrollToFeatures() {
            document.getElementById('features').scrollIntoView({
                behavior: 'smooth'
            });
        }
    }
}
</script>
@endsection

@push('styles')
<style>
/* Modern Welcome Page Styles */
.welcome-page {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.welcome-page::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
    backdrop-filter: blur(1px);
}

/* Hero Section */
.hero-section {
    position: relative;
    z-index: 2;
    min-height: 100vh;
}

/* Logo Animation */
.logo-container {
    perspective: 1000px;
}

.logo-glow {
    position: relative;
    display: inline-block;
}

.logo-glow::before {
    content: '';
    position: absolute;
    top: -20px;
    left: -20px;
    right: -20px;
    bottom: -20px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
    border-radius: 50%;
    filter: blur(20px);
    animation: logoGlow 3s ease-in-out infinite alternate;
}

@keyframes logoGlow {
    from { opacity: 0.5; transform: scale(0.8); }
    to { opacity: 1; transform: scale(1.2); }
}

/* Gradient Text */
.gradient-text {
    background: linear-gradient(45deg, #fff, #e0e7ff, #fff, #fce7f3);
    background-size: 300% 300%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradientShift 4s ease-in-out infinite;
    text-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
}

@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

/* Typing Animation */
.subtitle-container {
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.typing-text {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.25rem;
    font-weight: 400;
}

.typing-cursor {
    color: white;
    font-weight: bold;
    font-size: 1.25rem;
    margin-left: 2px;
}

/* Glass Morphism Cards */
.feature-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    height: 100%;
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
}

.feature-card h5 {
    color: white;
    font-weight: 600;
    margin-bottom: 1rem;
}

.feature-card p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    margin: 0;
}

/* Animated Buttons */
.glow-button {
    position: relative;
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    backdrop-filter: blur(20px);
    transition: all 0.3s ease;
    overflow: hidden;
}

.glow-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.glow-button:hover::before {
    left: 100%;
}

.glow-button:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
}

.pulse-active {
    animation: pulse 0.6s ease-in-out;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Floating Particles */
.floating-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    animation: float linear infinite;
}

@keyframes float {
    0% {
        transform: translateY(100vh) rotate(0deg);
        opacity: 0;
    }
    10% {
        opacity: 1;
    }
    90% {
        opacity: 1;
    }
    100% {
        transform: translateY(-100px) rotate(360deg);
        opacity: 0;
    }
}

/* Scroll Indicator */
.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    color: rgba(255, 255, 255, 0.8);
    cursor: pointer;
    transition: all 0.3s ease;
}

.scroll-indicator:hover {
    color: white;
    transform: translateX(-50%) translateY(-5px);
}

.scroll-arrow {
    width: 40px;
    height: 40px;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

/* Features Section */
.features-section {
    background: white;
    position: relative;
    z-index: 3;
}

.features-content {
    padding: 2rem 0;
}

.feature-list {
    list-style: none;
    padding: 0;
}

.feature-item {
    display: flex;
    align-items: center;
    padding: 1rem 0;
    font-size: 1.1rem;
    opacity: 0;
    transform: translateX(-20px);
    transition: all 0.6s ease;
}

.feature-item.animate-in {
    opacity: 1;
    transform: translateX(0);
}

/* Demo Mockup */
.demo-mockup {
    background: #1a1a1a;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    transform: perspective(1000px) rotateY(-15deg);
    transition: transform 0.3s ease;
}

.demo-mockup:hover {
    transform: perspective(1000px) rotateY(0deg);
}

.mockup-header {
    background: #2a2a2a;
    padding: 1rem;
    border-bottom: 1px solid #333;
}

.mockup-dots {
    display: flex;
    gap: 0.5rem;
}

.mockup-dots span {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #666;
}

.mockup-dots span:nth-child(1) { background: #ff5f56; }
.mockup-dots span:nth-child(2) { background: #ffbd2e; }
.mockup-dots span:nth-child(3) { background: #27ca3f; }

.mockup-content {
    padding: 2rem;
}

.dashboard-preview {
    display: grid;
    gap: 1rem;
}

.preview-item {
    background: #2a2a2a;
    padding: 1.5rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 1rem;
    color: white;
    opacity: 0;
    transform: translateX(-20px);
    transition: all 0.6s ease;
}

.preview-item.slide-in {
    opacity: 1;
    transform: translateX(0);
}

.preview-item i {
    font-size: 1.5rem;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 20px;
    padding: 3rem 2rem;
    margin-top: 4rem;
}

.cta-buttons .btn {
    margin: 0.5rem;
}

/* Integrated Footer */
.integrated-footer {
    background: rgba(255, 255, 255, 0.05);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.8);
    position: relative;
    z-index: 3;
}

.integrated-footer .text-muted {
    color: rgba(255, 255, 255, 0.6) !important;
}

.integrated-footer .text-primary {
    color: rgba(255, 255, 255, 0.9) !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .gradient-text {
        font-size: 2.5rem;
    }
    
    .feature-cards .col-md-4 {
        margin-bottom: 1rem;
    }
    
    .button-group {
        flex-direction: column;
        gap: 1rem;
    }
    
    .button-group .btn,
    .cta-buttons .btn {
        width: 100%;
        margin: 0.5rem 0 !important;
    }
    
    .demo-mockup {
        transform: none;
        margin-top: 2rem;
    }
    
    .cta-section {
        padding: 2rem 1rem;
        margin-top: 2rem;
    }
}
</style>
@endpush 