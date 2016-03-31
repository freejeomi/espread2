<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");
$_SESSION['last_screen'] = "ajax_manage_reorder.php";

//script to retrieve store drop down select
include "../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$query1 = "SELECT store_id,store_name FROM store WHERE useinreorder=1";
$result1 = mysqli_query($conn,$query1);

$i=0;
if(mysqli_num_rows($result1)>0){
    $stores=array();
    $stores_id=array();
    $stores_name=array();
    while($row = mysqli_fetch_array($result1)) {
        $stores[$i]=$row[1]."-".$row[0];
        $stores_name[$i]=$row[1];
        $stores_id[$i]=$row[0];
        $i++;
    }
}

?>

<!-- row -->

<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
<!--        VIEW PRINTABLE VERSION-->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a class="pull-right text-primary" href="manage_reorder.php" target="_blank">view printable version</a>
            </article>
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


    var pagefunction = function() {
        loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);


        function run_jqgrid_function() {
            //var php_res ="<?php //echo $string_echo;?>//";
            jQuery("#jqgrid").jqGrid({
                //data : jqgrid_data,
                url: "ajax/reorder_manage/manage_reorder_get.php",
                datatype: "json",
                mtype: "GET",
                height : 'auto',

                colModel : [

                    {

                        name : 'stock_name',
                        index : 'stock_name',
                        sortable : true,
                        label:"Product Name",
                        editable : false,
                        // edittype:"number",
                        editrules:{required:true,
                            edithidden:true}


                    },{

                        name : 'stock_code',
                        index : 'stock_code',
                        sortable : true,
                        editable : false,
                        label:"SKU"


                    },
                    {

                        name : 'general',
                        index : 'general',
                        sortable : true,
                        editable : true,
                        label:"General"


                    },
                    <?php
    $string_echo="";
    if(isset($stores_id) && isset($stores) && isset($stores_name)) {


        foreach ($stores as $eachstore) {
            $arraystore = explode("-", $eachstore);
            $string_echo .= "{

                        name : '" . $arraystore[1] . "',
                        index : '" . $arraystore[1] . "',
                        sortable : true,
                        editable : true,

                        label:'".$arraystore[0]."'

                    },";
        }
        echo $string_echo;
    }?>

                ],
                rowNum : 10,
                //rowList : [10, 20, 30],
                rowTotal:-1,

                loadonce:true,
                ignoreCase: true,


                //rowList : [10, 20, 30],
                pager : '#pjqgrid',
                sortname : 'stock_id',
                toolbarfilter : true,
                viewrecords : true,
                rownumbers:true,
               rownumWidth:40,

                sortorder : "asc",
                loadComplete: function () {
                    $('a.hoverover').hover(function () {
                        $(this).css('text-decoration','underline');

                    }, function () {
                        $(this).css('text-decoration','none');
                    });
                    $('#refresh_jqgrid').click(function () {
                        jQuery('#jqgrid').jqGrid('setGridParam',{url:"ajax/reorder_manage/manage_reorder_get.php", page: 1,datatype: "json"}).trigger("reloadGrid");
                    });

                },


                caption : "Reorder Level[Stock Position]",
                // multiselect : true,
                autowidth : true

            });
            jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
                edit : false,
                add : false,
                del : false,
                search: true
            });

            /* Add tooltips */
            $('.navtable .ui-pg-button').tooltip({
                container : 'body'
            });


            jQuery("#m1s").click(function() {
                jQuery("#jqgrid").jqGrid('setSelection', "13");
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

            $(window).on('resize.jqGrid', function() {
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