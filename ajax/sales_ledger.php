<?php
require_once("inc/init.php");
require_once("userlogcheck_admin.php");
$_SESSION['last_screen'] = "sales_ledger.php";
?>


<!--
The ID "widget-grid" will start to initialize all widgets below
You do not need to use widgets if you dont want to. Simply remove
the <section></section> and you can use wells or panels instead
-->

<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <table id="jqgrid"></table>
            <div id="pjqgrid"></div>
            <!-- Dynamic Modal -->
            <div class="modal fade" id="cashierModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                <!--<h4 class="modal-title">Modal Header</h4>-->
                            </div>
                            <div class="modal-body">
                                <p class="alert alert-danger" id="alert_fail">Are you sure you want to remove cashier
                                    assigned to this invoice?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <button type="button" class="btn btn-primary" id="cashier_remove">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

        </article>
        <!-- WIDGET END -->

    </div>

    <!-- end row -->

</section>
<!-- end widget grid -->

<script type="text/javascript">

    /* DO NOT REMOVE : GLOBAL FUNCTIONS!
     *
     * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
     *
     * // activate tooltips
     * $("[rel=tooltip]").tooltip();
     *
     * // activate popovers
     * $("[rel=popover]").popover();
     *
     * // activate popovers with hover states
     * $("[rel=popover-hover]").popover({ trigger: "hover" });
     *
     * // activate inline charts
     * runAllCharts();
     *
     * // setup widgets
     * setup_widgets_desktop();
     *
     * // run form elements
     * runAllForms();
     *
     ********************************
     *
     * pageSetUp() is needed whenever you load a page.
     * It initializes and checks for all basic elements of the page
     * and makes rendering easier.
     *
     */

    pageSetUp();

    /*
     * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
     * eg alert("my home function");
     *
     * var pagefunction = function() {
     *   ...
     * }
     * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
     *
     */
    function printItem(click_id) {
        //alert($(click_id).children('.printid').val());
        $.ajax({
            type: "POST",
            data: {
                ledger_invoice_number: $(click_id).children('.printid').val(),
                task: "print"
            },
            url: "ajax/invoice_session.php",
            success: function (response) {
                //alert('here');
                window.open("invoice.php");

            }
        });
    }
    function redirect_invoice(val) {
        var invoice_num = $(val).children('.invoice_click').val();
        //alert(invoice_num);

        $.ajax({
            url: 'ajax/invoice_session.php',
            type: 'POST',
            async: false,
            data: {invoice_num: invoice_num},
        }).done(function (data) {
            //alert(data);

        });

    }


    var pagefunction = function () {
        loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);


        function run_jqgrid_function() {

            $('#cashier_remove').click(function (event) {
                event.preventDefault();
                //alert($('#invoice_num_hidden').val());
                var formData = {
                    'invoice_num_grid': $('#cashier_un').val()
                };
                $.ajax({
                    type: 'POST',
                    url: 'ajax/invoice/invoice_tracker_search.php',
                    data: formData,
                    dataType: 'json',
                    encode: true
                })
                    .done(function (data) {
                        if (!data.success) {
                            $('#alert_fail').text(data.error);
                        }
                        else {
                            $('#cashierModal').modal('hide');
                            $('#jqgrid').jqGrid('setGridParam', {
                                url: "ajax/invoice/daily_sales_ledger_get.php"
                            }).trigger("reloadGrid");
                        }
                    })
            });
            function showlink(cellValue, options, rowObject) {
                //alert (cellValue);
                var url = "<a  href='#ajax/new_invoice.php?src=ledger'  onclick='redirect_invoice(this)'>" + cellValue + "<input type='hidden' class= 'invoice_click' value='" + cellValue + "'></a>";
                return url;
            }

            jQuery("#jqgrid").jqGrid({
                //data : jqgrid_data,

                url: "ajax/invoice/sales_ledger_get.php",
                datatype: "json",

                mtype: "GET",
                height: 'auto',
                page: 1,
                colNames: ['Actions', 'Invoice Number', 'Date', 'Time', 'Customer', 'Cashier', 'Store', 'Purchase Amount', 'Payment Type', 'Status', 'Operator', 'Store Confirmation'],
                colModel: [
                    {
                        name: 'act',
                        index: 'act',
                        sortable: false,
                        //width: 70
                    },
                    {

                        name: 'invoice_num',
                        index: 'invoice_num',
                        sortable: true,
                        formatter: showlink
                        //formatoptions: {baseLinkUrl: "#ajax/", showAction: "new_invoice.php", idName: "invoice_num"}
                    }, {
                        name: 'date',
                        index: 'date',
                        editable: false
                    },
                    {
                        name: 'time',
                        index: 'time',
                        sortable: false

                    },
                    {
                        name: 'customer',
                        index: 'customer',
                        sortable: false

                    },
                    {
                        name: 'cashier',
                        index: 'cashier',
                        editable: false
                    },
                    {
                        name: 'store',
                        index: 'store',
                        editable: false
                    },
                    {
                        name: 'purchase_amount',
                        index: 'purchase_amount',
                        formatter: 'currency',
                        editable: false
                    },
                    {
                        name: 'payment_type',
                        index: 'payment_type',
                        editable: false
                    },
                    {
                        name: 'status',
                        index: 'status',
                        editable: false,
                    },
                    {
                        name: 'username',
                        index: 'username',
                        editable: false
                    },
                    {
                        name: 'store_confirmation',
                        index: 'store_confirmation',
                        editable: false
                    }
                ],
                rowNum: 10,
                rowList: [10, 20, 30],
                pager: '#pjqgrid',
                sortname: 'invoice_num',
                toolbarfilter: true,
                //rowTotal:-1,
                // loadonce:true,
                viewrecords: true,
                sortorder: "desc",
                gridComplete: function () {
                    var ids = jQuery("#jqgrid").jqGrid('getDataIDs');

                    for (var i = 0; i < ids.length; i++) {
                        var cl = ids[i];
                        var status_name = jQuery("#jqgrid").jqGrid('getCell', cl, 'status');
                        //alert(status_name);
                        if (status_name == "CLOSED") {
                            ca = "<button class='btn btn-sm btn-primary'  data-toggle='tooltip' title='Print Invoice' data-original-title='Print Invoice' onclick='printItem(this)' id='print_button'><i class='fa fa-print'></i><input type='hidden' id='print_id' class='printid' value='" + cl + "'></button>";
                        }
                        //onclick = "window.location.href='smssignup.html'"
                        else {
                            ca = "";
                        }

                        var cashier_name = jQuery("#jqgrid").jqGrid('getCell', cl, 'cashier');

//cashier_name= cashier_name.trim().length;


                        if (cashier_name.trim().length > 0) {
                            //alert(cashier_name);
                            be = "<button class='btn btn-sm btn-danger' type='button'  title='Unassign Cashier'  data-toggle='modal' data-target='#cashierModal' style='margin-right:5px;' data-original-title='Print Invoice'><i class='fa fa-user'></i><input type='hidden' id='cashier_un' value='" + cl + "'></button>";
                        }
                        else {
                            be = "";
                        }
                        // onclick =\"" + cashierUnassign + "('" + cl + "')\"
                        se = "<button class='btn btn-xs btn-default' data-original-title='Save Row' onclick=\"jQuery('#jqgrid').saveRow('" + cl + "');\"><i class='fa fa-times'></i></button>";

                        //jQuery("#jqgrid").jqGrid('setRowData',ids[i],{act:be+se+ce});
                        jQuery("#jqgrid").jqGrid('setRowData', ids[i], {
                            //act : be + se + ca
                            act: be + ca
                        });
                    }
                },
//                loadComplete: function(){
//                    var ids = jQuery("#jqgrid").jqGrid('getDataIDs');
//                    //alert(rolenames);
//                    for (var i = 0; i < ids.length; i++) {
//                        var cl = ids[i];
//                        var rowData = jQuery('#list').jqGrid('getRowData', cl);
//
//                        console.log(rowData.status);
//                        console.log(cl);
//                    }
//                },

                //editurl : "ajax/setup/category_grid_set.php",
                caption: "Sales Ledger",
                //multiselect : true,
                autowidth: true

            });
            jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
                edit: false,
                add: false,
                del: true,
                search: true
            });
//            jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
            /* Add tooltips */
            $('.navtable .ui-pg-button').tooltip({
                container: 'body'
            });

            // remove classes
            $(".ui-jqgrid").removeClass("ui-widget ui-widget-content");
            $(".ui-jqgrid-view").children().removeClass("ui-widget-header ui-state-default");
            $(".ui-jqgrid-labels, .ui-search-toolbar").children().removeClass("ui-state-default ui-th-column ui-th-ltr");
            $(".ui-jqgrid-pager").removeClass("ui-state-default");
            $(".ui-jqgrid").removeClass("ui-widget-content");

            // add classes
            $(".ui-jqgrid-htable").addClass("table table-bordered table-hover");
            $(".ui-jqgrid-btable").addClass("table table-bordered table-striped");

            $(".ui-pg-div").removeClass().addClass("btn btn-sm btn-primary");
            $(".ui-icon.ui-icon-plus").removeClass().addClass("fa fa-plus");
            $(".ui-icon.ui-icon-pencil").removeClass().addClass("fa fa-pencil");
            $(".ui-icon.ui-icon-trash").removeClass().addClass("fa fa-trash-o");
            $(".ui-icon.ui-icon-search").removeClass().addClass("fa fa-search");
            $(".ui-icon.ui-icon-refresh").removeClass().addClass("fa fa-refresh");
            $(".ui-icon.ui-icon-disk").removeClass().addClass("fa fa-save").parent(".btn-primary").removeClass("btn-primary").addClass("btn-success");
            $(".ui-icon.ui-icon-cancel").removeClass().addClass("fa fa-times").parent(".btn-primary").removeClass("btn-primary").addClass("btn-danger");

            $(".ui-icon.ui-icon-seek-prev").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-prev").removeClass().addClass("fa fa-backward");

            $(".ui-icon.ui-icon-seek-first").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-first").removeClass().addClass("fa fa-fast-backward");

            $(".ui-icon.ui-icon-seek-next").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-next").removeClass().addClass("fa fa-forward");

            $(".ui-icon.ui-icon-seek-end").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-end").removeClass().addClass("fa fa-fast-forward");

            // update buttons

            $(window).on('resize.jqGrid', function () {
                $("#jqgrid").jqGrid('setGridWidth', $("#content").width());
            });

            //$('#post_result').html(jqgrid_data);
            //});
            //alert ($('#jsondata').val());
            //alert (jqgrid_data);

        }// end function

    }
    loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);


</script>