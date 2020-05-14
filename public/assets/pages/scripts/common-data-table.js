
var CommonDataTable = function () {
    var $table_id   = $(".data-table-setter").attr('id');
    var $table_url  = $(".data-table-setter").attr('data-url');
    var $table_order_column_no  = $(".data-table-setter").attr('data-order-column-no');
    var $table_order_column_dir  = $(".data-table-setter").attr('data-order-column-dir');
    var initPickers = function () {
        if($().datepicker) {
            //init date pickers
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });
        }
    }

    var intTooltips = function () {
        if($().tooltip){
            // global tooltips
            $('.tooltips').tooltip();
        }
    }

    var handleOrders = function () {

        var grid = new Datatable();
        grid.init({
            src: $("#"+ $table_id),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error
            },

            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
                // So when dropdowns used the scrollable div should be removed.
                "dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'f>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
                "language": {
                    "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول",
                    "sLoadingRecords": "جارٍ التحميل...",
                    "sProcessing":   "جارٍ التحميل...",
                    "sLengthMenu":   "أظهر _MENU_ مدخلات",
                    "sZeroRecords":  "لم يعثر على أية سجلات",
                    "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
                    "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                    "sInfoPostFix":  "",
                    "sSearch":       "ابحث:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "الأول",
                        "sPrevious": "السابق",
                        "sNext":     "التالي",
                        "sLast":     "الأخير",
                        "page":      "الصفحة",
                        "pageOf":    "من"
                    },
                    "oAria": {
                        "sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً",
                        "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                    }
                },
                "lengthMenu": [
                    [20, 30, 50, 100, 150, -1],
                    [20, 30, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 20, // default record count per page
               /*"bFilter":true,*/
                "searching": false,
                "ajax": {
                    "url": $table_url,//"demo/ecommerce_orders.php", // ajax source
                    "method":"GET",
                },
                "order": [
                    [parseInt($table_order_column_no), $table_order_column_dir]
                ], // set first column as a default sort by asc
                "columnDefs": [ {
                    "targets": [-1], // column or columns numbers
                    "orderable": false,  // set orderable for selected columns
                }],
                "fnDrawCallback" : function(settings) {
                    /*handleUniform();
                     handleSwitch();*/
                    intTooltips();
                    //debugger;

                    //($table_id.hasClass('.advance-filter'))?((settings.json.recordsFilteredCount != undefined && parseInt(settings.json.recordsFilteredCount) > 0)?$('#advance-filter-baget').find('.badge').text(settings):$('#advance-filter-baget').text('')):$('#advance-filter-baget').text('');
                }
            }
        });

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == "") {
                alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });

    }

    return {

        //main function to initiate the module
        init: function () {

            initPickers();
            handleOrders();
        }

    };

}();

jQuery(document).ready(function() {
    CommonDataTable.init();

});
