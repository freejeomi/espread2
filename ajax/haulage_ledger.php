<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");
$_SESSION['last_screen'] = "haulage_ledger.php";
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


    var pagefunction = function () {
        loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);


        function run_jqgrid_function() {

            jQuery("#jqgrid").jqGrid({
                //data : jqgrid_data,
                url: "ajax/haulage/haulage_ledger_get.php",
                datatype: "json",
                mtype: "GET",
                height: 'auto',
                colNames: ['ID', 'Date', 'Time', 'Waybill', 'Note', 'Expenditure', 'Bbfwd', 'Balance', 'Vehicle'],
                colModel: [
//                    {
//                        name: 'act',
//                        index: 'act',
//                        sortable: false
//                    },
                    {
                        name: 'haulage_id',
                        index: 'haulage_id',
                        sortable: true,
                        editable: false
                    }, {
                        name: 'trans_date',
                        index: 'trans_date',
                        editable: false
                    }, {
                        name: 'trans_time',
                        index: 'trans_time',
                        editable: false
                    },
                    {
                        name: 'waybill',
                        index: 'waybill',
                        editable: false
                    },
                    {
                        name: 'note',
                        index: 'note',
                        editable: false
                    },
                    {
                        name: 'expenditure',
                        index: 'expenditure',
                        formatter:'currency',
                        editable: false
                    },
                    {
                        name: 'bbfwd',
                        index: 'bbfwd',
                        formatter:'currency',
                        editable: false
                    },
                    {
                        name: 'balance',
                        index: 'balance',
                        formatter:'currency',
                        editable: false
                    },
                    {
                        name: 'vehicle',
                        index: 'vehicle',
                        editable: false
                    }
                ],
                rowNum: 10,
                rowList: [10, 20, 30],
                pager: '#pjqgrid',
                sortname: 'haulage_id',
                toolbarfilter: true,
                viewrecords: true,
                sortorder: "asc",
                gridComplete: function () {
                    var ids = jQuery("#jqgrid").jqGrid('getDataIDs');
                    //alert(rolenames);

                    for (var i = 0; i < ids.length; i++) {
                        var cl = ids[i];


                        be = "<button class='btn btn-xs btn-default' data-original-title='Edit Row' onclick=\"jQuery('#jqgrid').editRow('" + cl + "');\"><i class='fa fa-pencil'></i></button>";
                        se = "<button class='btn btn-xs btn-default' data-original-title='Save Row' onclick=\"jQuery('#jqgrid').saveRow('" + cl + "');\"><i class='fa fa-save'></i></button>";
                        ca = "<button class='btn btn-xs btn-default' data-original-title='Cancel' onclick=\"jQuery('#jqgrid').restoreRow('" + cl + "');\"><i class='fa fa-times'></i></button>";
                        //ce = "<button class='btn btn-xs btn-default' onclick=\"jQuery('#jqgrid').restoreRow('"+cl+"');\"><i class='fa fa-times'></i></button>";
                        //jQuery("#jqgrid").jqGrid('setRowData',ids[i],{act:be+se+ce});
                        jQuery("#jqgrid").jqGrid('setRowData', ids[i], {
                            //act: be + se + ca
                        });
                    }
                },
                //editurl: "ajax/setup/vehicle_grid_set.php",
                caption: "Haulage Ledger",
                //multiselect: true,
                autowidth: true

            });
            jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
                edit: false,
                add: false,
                del: false,
                search: true
            });
            //jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
            /* Add tooltips */
            $('.navtable .ui-pg-button').tooltip({
                container: 'body'
            });

//            jQuery("#m1").click(function () {
//                var s;
//                s = jQuery("#jqgrid").jqGrid('getGridParam', 'selarrrow');
//                alert(s);
//            });
//            jQuery("#m1s").click(function () {
//                jQuery("#jqgrid").jqGrid('setSelection', "13");
//            });

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

