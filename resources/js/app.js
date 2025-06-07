// Import Bootstrap
import 'bootstrap';

// Import Alpine.js and plugins
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

// Register Alpine.js plugins
Alpine.plugin(intersect);

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// DOM Ready Function
function domReady(fn) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fn);
    } else {
        fn();
    }
}

// App Class for managing application functionality
class KongrePadApp {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeTooltips();
        this.setupFormValidation();
        this.initializeAnimations();
    }

    setupEventListeners() {
        // Password Toggle Functionality
        document.addEventListener('click', (e) => {
            if (e.target.closest('.password-toggle')) {
                e.preventDefault();
                const toggle = e.target.closest('.password-toggle');
                const input = toggle.previousElementSibling;
                const icon = toggle.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        });

        // Form Submit Loading States
        document.addEventListener('submit', (e) => {
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                // Re-enable button after 3 seconds as fallback
                setTimeout(() => {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }, 3000);
            }
        });

        // Dropdown Menu Handling
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-bs-toggle="dropdown"]')) {
                // Bootstrap will handle this automatically
            }
        });

        // Card Hover Effects
        const cards = document.querySelectorAll('.stat-card, .conference-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    }

    initializeTooltips() {
        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    setupFormValidation() {
        // Enhanced form validation
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            const inputs = form.querySelectorAll('input, textarea, select');
            
            inputs.forEach(input => {
                // Real-time validation
                input.addEventListener('blur', () => {
                    this.validateField(input);
                });
                
                input.addEventListener('input', () => {
                    // Clear errors on input
                    this.clearFieldError(input);
                });
            });
        });
    }

    validateField(field) {
        const value = field.value.trim();
        const type = field.type;
        const required = field.hasAttribute('required');
        
        // Clear previous errors
        this.clearFieldError(field);
        
        // Required validation
        if (required && !value) {
            this.showFieldError(field, 'Bu alan gereklidir.');
            return false;
        }
        
        // Email validation
        if (type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                this.showFieldError(field, 'Geçerli bir e-posta adresi girin.');
                return false;
            }
        }
        
        // Password validation
        if (type === 'password' && value) {
            if (value.length < 6) {
                this.showFieldError(field, 'Şifre en az 6 karakter olmalıdır.');
                return false;
            }
        }
        
        // Password confirmation validation
        if (field.name === 'password_confirmation' && value) {
            const passwordField = document.querySelector('input[name="password"]');
            if (passwordField && value !== passwordField.value) {
                this.showFieldError(field, 'Şifre tekrarı eşleşmiyor.');
                return false;
            }
        }
        
        return true;
    }

    showFieldError(field, message) {
        field.classList.add('is-invalid');
        
        let feedback = field.nextElementSibling;
        if (!feedback || !feedback.classList.contains('invalid-feedback')) {
            feedback = document.createElement('div');
            feedback.classList.add('invalid-feedback');
            field.parentNode.insertBefore(feedback, field.nextSibling);
        }
        feedback.textContent = message;
    }

    clearFieldError(field) {
        field.classList.remove('is-invalid');
        const feedback = field.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.remove();
        }
    }

    initializeAnimations() {
        // Fade in animations for page elements
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, {
            threshold: 0.1
        });

        // Observe cards and sections
        const animatedElements = document.querySelectorAll('.card, .auth-card, .welcome-content');
        animatedElements.forEach(el => {
            observer.observe(el);
        });
    }

    // Utility Methods
    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    confirmAction(message, callback) {
        if (confirm(message)) {
            callback();
        }
    }

    // Loading state management
    showLoading(element) {
        element.classList.add('loading');
        element.disabled = true;
    }

    hideLoading(element) {
        element.classList.remove('loading');
        element.disabled = false;
    }
}

// Initialize app when DOM is ready
domReady(() => {
    window.KongrePadApp = new KongrePadApp();
    
    // Global utility functions
    window.togglePassword = function(fieldId) {
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
    };
    
    window.confirmDelete = function(message = 'Bu işlemi gerçekleştirmek istediğinizden emin misiniz?') {
        return confirm(message);
    };
    
    window.showNotification = function(message, type = 'info') {
        window.KongrePadApp.showNotification(message, type);
    };
});

// Alpine.js Components
document.addEventListener('alpine:init', () => {
    // Dashboard Component
    Alpine.data('dashboard', () => ({
        stats: {
            conferences: 12,
            participants: 1248,
            sessions: 86,
            active: 3
        },
        
        activities: [
            { icon: 'calendar-plus', text: 'Yeni konferans oluşturuldu', time: '2 saat önce' },
            { icon: 'user-plus', text: 'Yeni katılımcı kaydı', time: '4 saat önce' },
            { icon: 'microphone', text: 'Oturum güncellendi', time: '6 saat önce' }
        ]
    }));
    
    // Conference List Component
    Alpine.data('conferenceList', () => ({
        conferences: [
            { id: 1, title: 'TechSummit 2024', status: 'active', participants: 245 },
            { id: 2, title: 'Web Summit 2024', status: 'upcoming', participants: 189 },
            { id: 3, title: 'AI Conference 2023', status: 'completed', participants: 356 }
        ],
        
        filters: {
            search: '',
            status: '',
            date: ''
        },
        
        filteredConferences() {
            return this.conferences.filter(conference => {
                const matchesSearch = !this.filters.search || 
                    conference.title.toLowerCase().includes(this.filters.search.toLowerCase());
                const matchesStatus = !this.filters.status || conference.status === this.filters.status;
                
                return matchesSearch && matchesStatus;
            });
        }
    }));
    
    // Form Component
    Alpine.data('conferenceForm', () => ({
        form: {
            title: '',
            description: '',
            start_date: '',
            end_date: '',
            city: '',
            venue: '',
            address: '',
            max_participants: '',
            registration_deadline: '',
            is_public: false
        },
        
        isSubmitting: false,
        
        submitForm() {
            this.isSubmitting = true;
            // Form submission logic here
            setTimeout(() => {
                this.isSubmitting = false;
            }, 2000);
        }
    }));
});

export default KongrePadApp; 