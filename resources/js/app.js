import './bootstrap';
import TempusDominus from '@eonasdan/tempus-dominus';

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// Tarih seçiciyi başlatan fonksiyon
function initializeDatePicker(element) {
    const datepicker = new TempusDominus(element, {
        format: 'YYYY-MM-DD',
        buttons: {
            showToday: true,
        },
    });
}

// Saat seçiciyi başlatan fonksiyon
function initializeTimePicker(element) {
    const timepicker = new TempusDominus(element, {
        format: 'HH:mm',
        buttons: {
            showToday: false,
            showClear: true,
        },
    });
}

// Tarih ve saat seçiciyi başlatan fonksiyon
function initializeDateTimePicker(element) {
    const datetimepicker = new TempusDominus(element, {
        format: 'YYYY-MM-DD HH:mm',
        buttons: {
            showToday: true,
            showClear: true,
        },
    });
}

// Tüm datetime picker alanlarını seçip ilgili başlatma fonksiyonunu çağıran fonksiyon
function initializeDateTimePickers() {
    document.querySelectorAll('.datepicker').forEach((element) => {
        initializeDatePicker(element);
    });

    document.querySelectorAll('.timepicker').forEach((element) => {
        initializeTimePicker(element);
    });

    document.querySelectorAll('.datetimepicker').forEach((element) => {
        initializeDateTimePicker(element);
    });
}

// İlgili fonksiyonu çağırarak datetime picker alanlarını başlatın
initializeDateTimePickers();
