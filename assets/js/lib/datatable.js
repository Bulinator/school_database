import $ from 'jquery';
import JSZip from "jszip";
window.JSZip = JSZip; // required to make Buttons extension work for Excel button

require('datatables.net-bs4/js/dataTables.bootstrap4.min');
require('datatables.net-buttons-bs4/js/buttons.bootstrap4.min');
require('datatables.net-buttons/js/buttons.html5');
require('datatables.net-buttons/js/buttons.print.min');
require('datatables.net-buttons/js/buttons.colVis.min');

$(document).ready(function(){
    const className = 'btn btn-primary mr-1 rounded';
    const dtButtons = [
        {
            className: className,
            extend: 'print',
            text: '<i class="fas fa-print">',
            init: function(api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        {
            className: className,
            extend: 'excel',
            text: '<i class="fas fa-file-excel fa-fw">',
            init: function(api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        {
            className: className,
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf fa-fw">',
            init: function(api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        {
            className: className,
            extend: 'csv',
            text: '<i class="fas fa-file-code fa-fw">',
            init: function(api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        }
    ];

    $('#dtBasic').DataTable({
        bLengthChange: false,
        bInfo: false,
        bFilter: true,
        bPaginate: false,
        buttons: dtButtons,
        responsive: true,
        language: {
            search: '',
            searchPlaceholder: "<Search information>",
        }
    }).buttons().container().appendTo('#dtBasic_wrapper .col-md-6:eq(0)');

    $('#dtBasicCrud').DataTable({
        bLengthChange: false,
        bInfo: false,
        bFilter: true,
        bPaginate: true,
        displayLength: 25,
        buttons: dtButtons,
        language: {
            search: '',
            searchPlaceholder: "<Search information>",
        }
    }).buttons().container().appendTo('#dtBasicCrud_wrapper .col-md-6:eq(0)');
});




