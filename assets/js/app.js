const $ = require('jquery');

import '../scss/app.scss';
import '../bootstrap';
import './lib/utils';
import './lib/datatable';

require('@fortawesome/fontawesome-free/js/all.js');
require('bootstrap');
require('bootstrap-select');
require('sticky-table-headers');
require('flatpickr');

$(document).ready(function () {
    console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

    $('table').stickyTableHeaders({fixedOffset: 58});

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        $('.selectpicker').selectpicker('mobile');
    }

    // Initialize tooltip component
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'left',
            html: true,
            trigger: 'hover'
        });
    });

    $(document).popover({ selector: '[data-toggle="popover"]' });
});