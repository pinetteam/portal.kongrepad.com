import './bootstrap';
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

import moment from'moment';
//window.moment = Moment;
import { TempusDominus } from '@eonasdan/tempus-dominus';

function initializeDatePicker(element) {
    const datePicker = new TempusDominus(element, {
        localization: {
            locale: 'tr-TR',
            format: 'YYYY-MM-DD',
        },
        display: {
            buttons: {
                today: true,
            },
        },
    });
    datePicker.dates.formatInput = date => moment(date).format('YYYY-MM-DD');
}

// Saat seçiciyi başlatan fonksiyon
function initializeTimePicker(element) {
    const timePicker = new TempusDominus(element, {
        localization: {
            locale: 'tr-TR',
            format: 'HH:mm',
        },
        display: {
            viewMode: 'clock',
            components: {
                decades: false,
                year: false,
                month: false,
                date: false,
                hours: true,
                minutes: true,
                seconds: false
            }
        },
    });
    timePicker.dates.formatInput = date => moment(date).format('HH:mm');
}

// Tarih ve saat seçiciyi başlatan fonksiyon
function initializeDateTimePicker(element) {
    const dateTimePicker = new TempusDominus(element, {
        localization: {
            locale: 'tr-TR',
            format: 'YYYY-MM-DD HH:mm',
        },
        display: {
            buttons: {
                today: true,
                clear: true,
            },
        },
    });
    dateTimePicker.dates.formatInput = date => moment(date).format('YYYY-MM-DD HH:mm');
}

// Tüm datetime picker alanlarını seçip ilgili başlatma fonksiyonunu çağıran fonksiyon
function initializeDateTimePickers() {
    document.querySelectorAll('.date-picker').forEach((element) => {
        initializeDatePicker(element);
    });

    document.querySelectorAll('.time-picker').forEach((element) => {
        initializeTimePicker(element);
    });

    document.querySelectorAll('.date-time-picker').forEach((element) => {
        initializeDateTimePicker(element);
    });
}
initializeDateTimePickers();
