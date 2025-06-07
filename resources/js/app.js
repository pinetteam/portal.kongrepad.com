// KongrePad Conference Management System - JavaScript Entry Point
// ============================================================

import './bootstrap';

// Import Bootstrap 5 JavaScript
import 'bootstrap';

// Import custom SCSS
import '../css/app.scss';

// Import FontAwesome Pro - SVG Core
import { library, dom } from '@fortawesome/fontawesome-svg-core';

// Import FontAwesome Pro Icon Sets
import { 
    faUsers, faUsersCog, faCalendarAlt, faBuilding, faPlug, faChartLine, 
    faGlobeAmericas, faDatabase, faGlobe, faLanguage, faTachometerAlt,
    faRocket, faInfoCircle, faStar, faPlay, faEnvelope, faCheckCircle,
    faChevronDown, faChevronUp, faCopy, faCheck, faCog, faHome,
    faBell, faUser, faSignOutAlt, faSearch, faFilter, faEdit, 
    faTrash, faPlus, faMinus, faSave, faCancel, faUpload, faDownload,
    faEye, faEyeSlash, faLock, faUnlock, faPrint, faShare,
    faHeart, faComment, faThumbsUp, faThumbsDown, faPoll,
    faMicrophone, faMicrophoneSlash, faVideo, faVideoSlash,
    faScreenShare, faHandRaise, faQuestion, faExclamation,
    faClock, faMapMarkerAlt, faPhone, faEnvelopeOpen,
    faNewspaper, faFileAlt, faFilePdf, faFileExcel, faFileWord,
    faImage, faMusic, faFilm, faGamepad, faTrophy, faMedal,
    faFlag, faBullhorn, faSpeaker, faVolume, faVolumeUp, faVolumeOff,
    faSpinner
} from '@fortawesome/pro-solid-svg-icons';

import {
    faUser as farUser, faHeart as farHeart, faComment as farComment,
    faBookmark as farBookmark, faCalendar as farCalendar,
    faClock as farClock, faEnvelope as farEnvelope,
    faFile as farFile, faFolder as farFolder, faImage as farImage,
    faCopy as farCopy
} from '@fortawesome/pro-regular-svg-icons';

import {
    faFeather, faSun, faMoon, faCloud, faWind, faLeaf,
    faFlower, faBird, faCat, faDog, faTree, faSeedling,
    faStar as falStar, faPlay as falPlay, faEnvelope as falEnvelope,
    faInfoCircle as falInfoCircle, faTerminal
} from '@fortawesome/pro-light-svg-icons';

import {
    faSparkles, faStars, faWand, faMagic, faGem, faCrown,
    faShield, faSword, faWizard, faUnicorn, faRainbow, faButterfly,
    faUsersGear, faGlobe as fadGlobe, faDatabase as fadDatabase,
    faLanguage as fadLanguage, faTachometerAlt as fadTachometerAlt,
    faCalendarAlt as fadCalendarAlt, faUsers as fadUsers,
    faBuilding as fadBuilding, faPlug as fadPlug, faChartLine as fadChartLine,
    faGlobeAmericas as fadGlobeAmericas, faRocket as fadRocket,
    faInfoCircle as fadInfoCircle
} from '@fortawesome/pro-duotone-svg-icons';

import {
    faAtom, faCode, faBug, faTerminal as fatTerminal, faServer, faChip,
    faRobot, faLaptop, faDesktop, faMobile, faTablet, faHeadset
} from '@fortawesome/pro-thin-svg-icons';

// Configure FontAwesome
dom.autoReplaceSvg = 'nest';
dom.observeMutations = true;

// Add icons to library
library.add(
    // Solid Icons
    faUsers, faUsersCog, faCalendarAlt, faBuilding, faPlug, faChartLine,
    faGlobeAmericas, faDatabase, faGlobe, faLanguage, faTachometerAlt,
    faRocket, faInfoCircle, faStar, faPlay, faEnvelope, faCheckCircle,
    faChevronDown, faChevronUp, faCopy, faCheck, faCog, faHome,
    faBell, faUser, faSignOutAlt, faSearch, faFilter, faEdit,
    faTrash, faPlus, faMinus, faSave, faCancel, faUpload, faDownload,
    faEye, faEyeSlash, faLock, faUnlock, faPrint, faShare,
    faHeart, faComment, faThumbsUp, faThumbsDown, faPoll,
    faMicrophone, faMicrophoneSlash, faVideo, faVideoSlash,
    faScreenShare, faHandRaise, faQuestion, faExclamation,
    faClock, faMapMarkerAlt, faPhone, faEnvelopeOpen,
    faNewspaper, faFileAlt, faFilePdf, faFileExcel, faFileWord,
    faImage, faMusic, faFilm, faGamepad, faTrophy, faMedal,
    faFlag, faBullhorn, faSpeaker, faVolume, faVolumeUp, faVolumeOff,
    faSpinner,
    
    // Regular Icons
    farUser, farHeart, farComment, farBookmark, farCalendar,
    farClock, farEnvelope, farFile, farFolder, farImage, farCopy,
    
    // Light Icons
    faFeather, faSun, faMoon, faCloud, faWind, faLeaf,
    faFlower, faBird, faCat, faDog, faTree, faSeedling,
    falStar, falPlay, falEnvelope, falInfoCircle, faTerminal,
    
    // Duotone Icons
    faSparkles, faStars, faWand, faMagic, faGem, faCrown,
    faShield, faSword, faWizard, faUnicorn, faRainbow, faButterfly,
    faUsersGear, fadGlobe, fadDatabase, fadLanguage, fadTachometerAlt,
    fadCalendarAlt, fadUsers, fadBuilding, fadPlug, fadChartLine,
    fadGlobeAmericas, fadRocket, fadInfoCircle,
    
    // Thin Icons
    faAtom, faCode, faBug, fatTerminal, faServer, faChip,
    faRobot, faLaptop, faDesktop, faMobile, faTablet, faHeadset
);

// Watch for DOM changes and replace icons
dom.watch();

// KongrePad Application Class
class KongrePadApp {
    constructor() {
        this.init();
    }

    init() {
        this.initBootstrapComponents();
        this.initEventListeners();
        this.initFormValidation();
        this.initTooltipsAndPopovers();
        this.initLanguageSupport();
        this.initFontAwesome();
        
        console.log('🚀 KongrePad Conference Management System Initialized');
        console.log('✨ FontAwesome Pro Icons Loaded');
    }

    // Initialize FontAwesome Pro Features
    initFontAwesome() {
        // Dynamic icon replacement based on context
        this.setupDynamicIcons();
        
        // Icon animation triggers
        this.setupIconAnimations();
        
        // Pro duotone color customization
        this.setupDuotoneColors();
    }

    // Setup Dynamic Icons
    setupDynamicIcons() {
        // Change icons based on system theme
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
        
        prefersDark.addEventListener('change', (e) => {
            const themeIcons = document.querySelectorAll('[data-theme-icon]');
            themeIcons.forEach(icon => {
                const lightIcon = icon.getAttribute('data-light-icon');
                const darkIcon = icon.getAttribute('data-dark-icon');
                
                if (e.matches && darkIcon) {
                    icon.classList.remove(lightIcon);
                    icon.classList.add(darkIcon);
                } else if (lightIcon) {
                    icon.classList.remove(darkIcon);
                    icon.classList.add(lightIcon);
                }
            });
        });

        // Status-based icon switching
        const statusElements = document.querySelectorAll('[data-status]');
        statusElements.forEach(element => {
            const status = element.getAttribute('data-status');
            const icon = element.querySelector('i');
            
            if (icon) {
                switch(status) {
                    case 'online':
                        icon.className = 'fas fa-circle text-success';
                        break;
                    case 'offline':
                        icon.className = 'fas fa-circle text-secondary';
                        break;
                    case 'busy':
                        icon.className = 'fas fa-circle text-warning';
                        break;
                    case 'away':
                        icon.className = 'far fa-circle text-info';
                        break;
                }
            }
        });
    }

    // Setup Icon Animations
    setupIconAnimations() {
        // Hover animations
        const animatedIcons = document.querySelectorAll('[data-icon-animate]');
        animatedIcons.forEach(icon => {
            const animation = icon.getAttribute('data-icon-animate');
            
            icon.addEventListener('mouseenter', () => {
                icon.classList.add(`fa-${animation}`);
            });
            
            icon.addEventListener('mouseleave', () => {
                icon.classList.remove(`fa-${animation}`);
            });
        });

        // Loading state icons
        const loadingButtons = document.querySelectorAll('.btn[data-loading-text]');
        loadingButtons.forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                const originalText = this.innerHTML;
                const loadingText = this.getAttribute('data-loading-text');
                
                if (icon) {
                    icon.classList.add('fa-spin');
                }
                
                this.disabled = true;
                this.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i>${loadingText}`;
                
                // Simulate loading (remove this in real implementation)
                setTimeout(() => {
                    this.disabled = false;
                    this.innerHTML = originalText;
                    if (icon) {
                        icon.classList.remove('fa-spin');
                    }
                }, 2000);
            });
        });
    }

    // Setup Duotone Colors
    setupDuotoneColors() {
        const duotoneIcons = document.querySelectorAll('.fa-duotone');
        duotoneIcons.forEach(icon => {
            const primaryColor = icon.getAttribute('data-primary-color');
            const secondaryColor = icon.getAttribute('data-secondary-color');
            const secondaryOpacity = icon.getAttribute('data-secondary-opacity');
            
            if (primaryColor) {
                icon.style.setProperty('--fa-primary-color', primaryColor);
            }
            if (secondaryColor) {
                icon.style.setProperty('--fa-secondary-color', secondaryColor);
            }
            if (secondaryOpacity) {
                icon.style.setProperty('--fa-secondary-opacity', secondaryOpacity);
            }
        });
    }

    // Initialize Bootstrap Components
    initBootstrapComponents() {
        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert.classList.contains('alert-dismissible')) {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    if (bsAlert) {
                        bsAlert.close();
                    }
                }, 5000);
            }
        });

        // Initialize modals
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function() {
                // Focus first input when modal opens
                const firstInput = this.querySelector('input, textarea, select');
                if (firstInput) {
                    setTimeout(() => firstInput.focus(), 100);
                }
            });
        });

        // Initialize collapse components
        const collapseElements = document.querySelectorAll('.collapse');
        collapseElements.forEach(element => {
            element.addEventListener('show.bs.collapse', function() {
                const icon = document.querySelector(`[data-bs-target="#${this.id}"] i`);
                if (icon) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });

            element.addEventListener('hide.bs.collapse', function() {
                const icon = document.querySelector(`[data-bs-target="#${this.id}"] i`);
                if (icon) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });
    }

    // Initialize Event Listeners  
    initEventListeners() {
        // Conference card hover effects
        const conferenceCards = document.querySelectorAll('.conference-card');
        conferenceCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                
                // Animate card icons
                const icons = this.querySelectorAll('i');
                icons.forEach(icon => {
                    icon.classList.add('icon-bounce');
                });
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                
                // Remove icon animations
                const icons = this.querySelectorAll('i');
                icons.forEach(icon => {
                    icon.classList.remove('icon-bounce');
                });
            });
        });

        // Copy to clipboard functionality
        const copyButtons = document.querySelectorAll('[data-copy]');
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const textToCopy = this.getAttribute('data-copy');
                navigator.clipboard.writeText(textToCopy).then(() => {
                    const originalIcon = this.querySelector('i').className;
                    this.innerHTML = '<i class="fas fa-check text-success"></i> Copied!';
                    setTimeout(() => {
                        this.innerHTML = `<i class="${originalIcon}"></i> Copy`;
                    }, 2000);
                });
            });
        });

        // Real-time search functionality
        const searchInputs = document.querySelectorAll('[data-search]');
        searchInputs.forEach(input => {
            input.addEventListener('input', this.debounce(function() {
                const query = this.value.toLowerCase();
                const target = this.getAttribute('data-search');
                const items = document.querySelectorAll(target);
                
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }, 300));
        });

        // Auto-save forms
        const autoSaveForms = document.querySelectorAll('[data-autosave]');
        autoSaveForms.forEach(form => {
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('change', this.debounce(() => {
                    this.autoSaveForm(form);
                }, 1000));
            });
        });
    }

    // Initialize Form Validation
    initFormValidation() {
        const forms = document.querySelectorAll('.needs-validation');
        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });

        // Custom validation messages
        const inputs = document.querySelectorAll('input[required], textarea[required], select[required]');
        inputs.forEach(input => {
            input.addEventListener('invalid', function() {
                this.setCustomValidity('Bu alan zorunludur.');
            });
            
            input.addEventListener('input', function() {
                this.setCustomValidity('');
            });
        });
    }

    // Initialize Tooltips and Popovers
    initTooltipsAndPopovers() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize popovers
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }

    // Initialize Language Support
    initLanguageSupport() {
        const languageSwitcher = document.querySelector('#language-switcher');
        if (languageSwitcher) {
            languageSwitcher.addEventListener('change', function() {
                const selectedLang = this.value;
                
                // Set RTL for Arabic
                if (selectedLang === 'ar') {
                    document.documentElement.setAttribute('dir', 'rtl');
                    document.documentElement.setAttribute('lang', 'ar');
                } else {
                    document.documentElement.setAttribute('dir', 'ltr');
                    document.documentElement.setAttribute('lang', selectedLang);
                }
                
                // Save language preference
                localStorage.setItem('kongrepad_language', selectedLang);
                
                // Reload page with new language
                const url = new URL(window.location);
                url.searchParams.set('lang', selectedLang);
                window.location.href = url.toString();
            });
        }

        // Load saved language preference
        const savedLang = localStorage.getItem('kongrepad_language');
        if (savedLang && languageSwitcher) {
            languageSwitcher.value = savedLang;
        }
    }

    // Auto-save form functionality
    autoSaveForm(form) {
        const formData = new FormData(form);
        const autoSaveUrl = form.getAttribute('data-autosave');
        
        fetch(autoSaveUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.showNotification('Otomatik kaydedildi', 'success');
            }
        })
        .catch(error => {
            console.error('Auto-save error:', error);
        });
    }

    // Show notification with FontAwesome Pro icons
    showNotification(message, type = 'info') {
        const iconMap = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-triangle',
            warning: 'fas fa-exclamation-circle',
            info: 'fas fa-info-circle'
        };
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            <i class="${iconMap[type]} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 5000);
    }

    // Debounce function
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func.apply(this, args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize KongrePad App when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.KongrePad = new KongrePadApp();
});

// Conference-specific functions with Pro icons
window.ConferenceUtils = {
    // Join conference
    joinConference(conferenceId, participantData) {
        return fetch(`/api/conferences/${conferenceId}/join`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(participantData)
        });
    },

    // Submit question
    submitQuestion(conferenceId, questionData) {
        return fetch(`/api/conferences/${conferenceId}/questions`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(questionData)
        });
    },

    // Vote in poll
    votePoll(pollId, optionId) {
        return fetch(`/api/polls/${pollId}/vote`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ option_id: optionId })
        });
    }
};

// FontAwesome Pro Utilities
window.FontAwesomeUtils = {
    // Change icon dynamically
    changeIcon(element, newIcon) {
        const icon = element.querySelector('i') || element;
        icon.className = newIcon;
    },
    
    // Add icon animation
    animateIcon(element, animation, duration = 1000) {
        const icon = element.querySelector('i') || element;
        icon.classList.add(`fa-${animation}`);
        
        if (duration > 0) {
            setTimeout(() => {
                icon.classList.remove(`fa-${animation}`);
            }, duration);
        }
    },
    
    // Update duotone colors
    updateDuotoneColors(element, primaryColor, secondaryColor, opacity = 0.4) {
        const icon = element.querySelector('i') || element;
        icon.style.setProperty('--fa-primary-color', primaryColor);
        icon.style.setProperty('--fa-secondary-color', secondaryColor);
        icon.style.setProperty('--fa-secondary-opacity', opacity);
    }
};

// Export for module systems
export default KongrePadApp;
