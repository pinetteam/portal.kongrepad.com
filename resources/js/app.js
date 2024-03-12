import './bootstrap';

// SlimSelect.js
import SlimSelect from 'slim-select';

// Tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// Loading bar
window.onload = function() {
    document.getElementById("kp-loading").style.visibility = "hidden";
}


// Chart.js
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
Chart.register(ChartDataLabels);
window.Chart = Chart;

// Moment & TempusDominus timing packages
import moment from'moment';
import { TempusDominus } from '@eonasdan/tempus-dominus';
function initializeDatePicker(element) {
    var dateFormat = "YYYY-MM-DD"
    fetch('/get-date-format')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            dateFormat = data.date_format;
            const datePicker = new TempusDominus(element, {
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
                },
                useCurrent: false
            });
            datePicker.dates.formatInput = date => moment(date).format(dateFormat);
        })
        .catch(error => {
            console.error('Error fetching date format:', error);
        });
}
function initializeTimePicker(element) {
    var timeFormat = "HH:mm"
    fetch('/get-time-format')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            timeFormat = data.time_format;
            const timePicker = new TempusDominus(element, {
                localization: {
                    hourCycle: timeFormat === '24H' ? 'h23' : 'h12',
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
                    },
                    buttons: {
                        today: false,
                        clear: false
                    }
                },
                useCurrent: false
            });
            timePicker.dates.formatInput = date => moment(date).format('HH:mm' + (timeFormat === '24H' ? '' : ' A'));
        })
        .catch(error => {
            console.error('Error fetching date format:', error);
        });

}
function initializeDateTimePicker(element) {
    var dateFormat = "YYYY-MM-DD"
    var timeFormat = ""
    fetch('/get-time-format')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            timeFormat = data.time_format
            fetch('/get-date-format')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    dateFormat = data.date_format;
                    const dateTimePicker = new TempusDominus(element, {
                        localization: {
                            hourCycle: timeFormat === '24H' ? 'h23' : 'h12',
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
                            },
                            buttons: {
                                today: false,
                                clear: false
                            }
                        },
                        useCurrent: false
                    });
                    dateTimePicker.dates.formatInput = date => moment(date).format(dateFormat + ' HH:mm' + (timeFormat === '24H' ? '' : ' A'));
                })
                .catch(error => {
                    console.error('Error fetching date format:', error);
                });

        })
        .catch(error => {
            console.error('Error fetching date format:', error);
        });
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
