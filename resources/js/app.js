import './bootstrap';

import Moment from 'moment/moment';
window.moment = Moment;

import * as TempusDominus from '@eonasdan/tempus-dominus';
window.tempusDominus = TempusDominus;

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
