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
            autoWidth: false,
            columnDefs: [{ 
                orderable: false,
                width: 100,
                // targets: [ 5 ]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });
    };

    $('.datatable-column-search-inputs thead tr:eq(1) th').not(':last-child').each(function () {
        const title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });
    
    $('.datatable-users').DataTable({
        orderCellsTop: true,
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
                    sheetName: 'Exported data'
                }
            ]
        },
        initComplete: function () {
            this.api()
                .columns()
                .every(function (index) {
                    const that = this;
 
                    $('input').on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.column($(this).parent().index() + ':visible').search(this.value).draw();
                        }
                    });
                });
        }
    });

        // Auto filter
        // $('.datatable-excel-filter').DataTable({
        //     buttons: {
        //         dom: {
        //             button: {
        //                 className: 'btn btn-light'
        //             }
        //         },
        //         buttons: [
        //             {
        //                 extend: 'excelHtml5',
        //                 text: 'Export to Excel <i class="ph-file-xls ms-2"></i>',
        //                 autoFilter: true,
        //                 sheetName: 'Exported data'
        //             }
        //         ]
        //     }
        // });

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
