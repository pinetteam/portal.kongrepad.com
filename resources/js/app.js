import './bootstrap';

// Tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// Loading bar
window.onload = function() {
    document.getElementById("kp-loading").style.visibility = "hidden";
}

// Moment & TempusDominus timing packages
import moment from'moment';
import { TempusDominus } from '@eonasdan/tempus-dominus';
function initializeDatePicker(element) {
    const datePicker = new TempusDominus(element, {
        localization: {
            locale: 'tr-TR',
            format: 'DD/MM/YYYY'
        },
        display: {
            viewMode: 'calendar',
            components: {
                calendar: true,
                date: true,
                month: true,
                year: true,
                decades: true,
                clock: false,
                hours: false,
                minutes: false,
                seconds: false
            },
            buttons: {
                today: false,
                clear: false
            }
        }
    });
    datePicker.dates.formatInput = date => moment(date).format('YYYY-MM-DD');
}
function initializeTimePicker(element) {
    const timePicker = new TempusDominus(element, {
        localization: {
            locale: 'tr-TR',
            format: 'HH:mm'
        },
        display: {
            viewMode: 'clock',
            components: {
                calendar: false,
                date: false,
                month: false,
                year: false,
                decades: false,
                clock: true,
                hours: true,
                minutes: true,
                seconds: false,
                useTwentyfourHour: true
            },
            buttons: {
                today: false,
                clear: false
            }
        }
    });
    timePicker.dates.formatInput = date => moment(date).format('HH:mm');
}
function initializeDateTimePicker(element) {
    const dateTimePicker = new TempusDominus(element, {
        localization: {
            locale: 'tr-TR',
            format: 'DD/MM/YYYY HH:mm'
        },
        display: {
            viewMode: 'calendar',
            components: {
                calendar: true,
                date: true,
                month: true,
                year: true,
                decades: true,
                clock: true,
                hours: true,
                minutes: true,
                seconds: false,
                useTwentyfourHour: true
            },
            buttons: {
                today: false,
                clear: false
            }
        }
    });
    dateTimePicker.dates.formatInput = date => moment(date).format('YYYY-MM-DD HH:mm');
}
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
