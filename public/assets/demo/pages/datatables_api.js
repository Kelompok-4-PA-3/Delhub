/* ------------------------------------------------------------------------------
 *
 *  # Datatables API
 *
 *  Demo JS code for datatable_api.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const DatatableAPI = function() {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableAPI = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            columnDefs: [{ 
                orderable: false,
                width: 100,
            }],
            dom: '<"datatable-header justify-content-start"f<"ms-sm-auto"l><"ms-sm-3"B>><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });


        // Single row selection
        const singleSelect = $('.datatable-selection-single').DataTable();
        $('.datatable-selection-single tbody').on('click', 'tr', function() {
            if ($(this).hasClass('table-success')) {
                $(this).removeClass('table-success');
            }
            else {
                singleSelect.$('tr.table-success').removeClass('table-success');
                $(this).addClass('table-success');
            }
        });


        // Multiple rows selection
        $('.datatable-selection-multiple').DataTable();
        $('.datatable-selection-multiple tbody').on('click', 'tr', function() {
            $(this).toggleClass('table-success');
        });


        // Individual column searching with text inputs
        $('.datatable-users thead tr:eq(1) th').not(':last-child').not(':first-child').each(function () {
            const title = $(this).text();
            $(this).html('<input type="text" class="form-control column-search" placeholder="Search ' + title + '" />');
        });
        $('.datatable-users').DataTable({
            orderCellsTop: true,
            paging: true,
            scrollY: true,
            "columns td:first-child": [
                { "width": "5%" },
              ],
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel <i class="ph-file-xls ms-2"></i>',
                        autoFilter: true,
                        sheetName: 'Sheet 1',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                         }
                    },
                    {
                        extend: 'print',
                        text: '<i class="ph-printer me-2"></i> Print table',
                        className: 'btn btn-light',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="ph-list"></i>',
                        className: 'btn btn-light btn-icon dropdown-toggle'
                    }
                ]
            },
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function (index) {
                        const that = this;
     
                        $('.column-search').on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that.column($(this).parent().index() + ':visible').search(this.value).draw();
                            }
                        });
                    });
            }
        });

        $('.datatable-penilaian thead tr:eq(1) th').not(':last-child').not(':first-child').each(function () {
            const title = $(this).text();
            $(this).html('<input type="text" class="form-control column-search" placeholder="Search ' + title + '" />');
        });


        $('.datatable-penilaian').DataTable({
            orderCellsTop: true,
            editable: true,
            paging: true,
            scrollY: true,
            scrollX: true,
            // columnDefs: [
            //     { targets: 1, width: '100px' }
            // ],
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel <i class="ph-file-xls ms-2"></i>',
                        autoFilter: true,
                        sheetName: 'Sheet 1',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                         }
                    },
                    {
                        extend: 'print',
                        text: '<i class="ph-printer me-2"></i> Print table',
                        className: 'btn btn-light',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="ph-list"></i>',
                        className: 'btn btn-light btn-icon dropdown-toggle'
                    }
                ]
            },
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function (index) {
                        const that = this;
     
                        $('.column-search').on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that.column($(this).parent().index() + ':visible').search(this.value).draw();
                            }
                        });

                      
                    });
            }
        });
        $('.datatable-feedback thead tr:eq(1) th').not(':last-child').each(function () {
            const title = $(this).text();
            $(this).html('<input type="text" class="form-control column-search" placeholder="Search ' + title + '" />');
        });


        $('.datatable-feedback').DataTable({
            orderCellsTop: true,
            editable: true,
            paging: true,
            scrollY: true,
            scrollX: true,
            // columnDefs: [
            //     { targets: 1, width: '100px' }
            // ],
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel <i class="ph-file-xls ms-2"></i>',
                        autoFilter: true,
                        sheetName: 'Sheet 1',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                         }
                    },
                    {
                        extend: 'print',
                        text: '<i class="ph-printer me-2"></i> Print table',
                        className: 'btn btn-light',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="ph-list"></i>',
                        className: 'btn btn-light btn-icon dropdown-toggle'
                    }
                ]
            },
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function (index) {
                        const that = this;
     
                        $('.column-search').on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that.column($(this).parent().index() + ':visible').search(this.value).draw();
                            }
                        });

                      
                    });
            }
        });

        $('.datatable-hasil-nilai thead tr:eq(1) th').not(':last-child').each(function () {
            const title = $(this).text();
            $(this).html('<input type="text" class="form-control column-search" placeholder="Search ' + title + '" />');
        });
        
        $('.datatable-hasil-nilai').DataTable({
            orderCellsTop: true,
            editable: true,
            paging: true,
            scrollY: true,
            scrollX: true,
            "columns td:first-child": [
                { "width": "5%" },
              ],
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel <i class="ph-file-xls ms-2"></i>',
                        autoFilter: true,
                        sheetName: 'Sheet 1',
                        // exportOptions: {
                        //     columns: 'th:not(:last-child)'
                        //  }
                    },
                    {
                        extend: 'print',
                        text: '<i class="ph-printer me-2"></i> Print table',
                        className: 'btn btn-light',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="ph-list"></i>',
                        className: 'btn btn-light btn-icon dropdown-toggle'
                    }
                ]
            },
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function (index) {
                        const that = this;
     
                        $('.column-search').on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that.column($(this).parent().index() + ':visible').search(this.value).draw();
                            }
                        });

                      
                    });
            }
        });

       

          // Individual column searching with text inputs
        $('.datatable-mahasiswa thead tr:eq(1) th').each(function () {
            const title = $(this).text();
            $(this).html('<input type="text" class="form-control column-search" placeholder="Search ' + title + '" />');
        });
        $('.datatable-mahasiswa').DataTable({
            orderCellsTop: true,
            paging: false,
            scrollY: false,
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
            },
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function (index) {
                        const that = this;
     
                        $('.column-search').on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that.column($(this).parent().index() + ':visible').search(this.value).draw();
                            }
                        });
                    });
            }
        });

        $('.datatable-regulasi thead tr:eq(1) th:not(:first-child).regulasi-column').each(function () {
            const title = $(this).text();
            $(this).html('<select class="column-check form-control"><option value=""> <button class="btn bg-white shadow-sm"> Semua </button></option><option value="Success"> <button class="btn bg-check-success shadow-sm"> Terpenuhi </button></option></select>');
        });
        // .pembimbing-column
        $('.datatable-regulasi thead tr:eq(1) th:not(:first-child):not(.regulasi-column)').each(function () {
            const title = $(this).text();
            $(this).html('<input type="text" class="form-control column-search" placeholder="Search ' + title + '" />');
        });

        $('.datatable-regulasi').DataTable({
            orderCellsTop: true,
            paging: true,
            scrollY: true,
            scrollX: true,
            "order": [[ 1, "asc" ]],
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
            },
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function (index) {
                        const that = this;
     
                        $('.column-check').on('keyup change clear', function () {
                            if (!that.checked) {
                                if (that.search() !== this.value) {
                                    that.column($(this).parent().index() + ':visible').search(this.value).draw();
                                }
                            }
                        });

                        $('.column-search').on('keyup change clear', function () {
                            if (!that.checked) {
                                if (that.search() !== this.value) {
                                    that.column($(this).parent().index() + ':visible').search(this.value).draw();
                                }
                            }
                        });

                    });
            }
        });

         // Individual column searching with text inputs
        $('.datatable-people').DataTable({
            orderCellsTop: false,
            ordering: false,
            paging: false,
            scrollY: false,
            scrollX: false,
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "55%", "targets": 1 },
                { "width": "25%", "targets": 2 }
            ],
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-light'
                    }
                },
            },
        });

        $('.datatable-people .dataTables_scrollBody').removeClass('dataTables_scrollBody');
        $('.datatable-people .dataTables_scrollBody').removeClass('dataTables_scrollBody');


        // Individual column searching with selects
        $('.datatable-column-search-selects').DataTable({
            orderCellsTop: true,
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        const column = this;
                        const select = $('<select class="form-select"><option value="0" selected disabled>Filter</option></select>')
                            .appendTo($('.datatable-column-search-selects thead tr:eq(1) th').not(':last-child').eq(column.index()).empty())
                            .on('change', function () {
                                const val = $.fn.dataTable.util.escapeRegex($(this).val());
     
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });
     
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="'+d.replace(/<(?:.|\n)*?>/gm, '')+'">'+d.replace(/<(?:.|\n)*?>/gm, '')+'</option>')
                            });
                    });
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableAPI();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableAPI.init();
});
