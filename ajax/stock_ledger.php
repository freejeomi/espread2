<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");
$_SESSION['last_screen'] = "stock_ledger.php";
?>
<?php
//script to retrieve store drop down select
include "../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$query1 = "SELECT stock_id, stock_name,stock_code FROM stock";
$result1 = mysqli_query($conn,$query1);
$response ='<option value="all_stock">---All Stock---</option>';
while($row = mysqli_fetch_array($result1)) {
    $response .= '<option value="'.$row[0].'">'.$row[1].' ('.$row[2].')</option>';
}
?>
<!-- row -->

<div class="row" xmlns="http://www.w3.org/1999/html">
<div class="col-md-12 col-sm-12 col-lg-12">
    <section id="widget-grid" class="">
        <!--row -->
        <div class="row" id="newinvoice-slide">

            <!--NEW WIDGET START-->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!--Widget ID(each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-deletebutton="false"
                     data-widget-editbutton="false">
       <header>
          <span class="widget-icon"> <i class=""></i> </span>

            <h2> Stock Ledger</h2>
      </header>

                    <!--widget div-->
      <div>
                        <!--widget edit box-->

                        <!--end widget edit box-->

                        <!--widget content-->
      <div class="widget-body">
      <form id="stockledger_form">
       <div class="row">
        <div class="form-group col-sm-3">
        <label class="control-label col-md-3" for="prepend"> Stock</label>
<div class="col-md-9">
       <div class="icon-addon addon-sm" id="stock-group">
          <select class="form-control" name="stock-select" id="stock-select">
           <?php echo $response; ?>

       </select>
      <label class="glyphicon glyphicon-search" title="" rel="tooltip" for="email" data-original-title="email"></label>
     </div>
      </div>
       </div>
        <div class="form-group col-sm-9">
        <label class="control-label col-md-1" for="prepend">Select Date</label>

        <div class="col-md-3" id="startdate-group">
         <div class="input-group">
          <input type="text" name="mydate1" id="startdate" placeholder="start date" class="form-control datepicker" data-dateformat="yy/mm/dd">
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>
       </div>
       <label class="control-label col-md-1" for="prepend">AND</label>

        <div class="col-md-3" id="finishdate-group">
         <div class="input-group">
          <input type="text" name="mydate2" id="finishdate" placeholder="end date" class="form-control datepicker" data-dateformat="yy/mm/dd">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
           </div>
            </div>
           <label class="control-label col-md-1" for="prepend"></label>
            <button class="btn btn-primary col-md-1" type="button" id="stockledger_update">
            <i class="fa fa-search"></i>
                Display
            </button>
            <label class="control-label col-md-1" for="prepend"></label>
            <button class="btn btn-danger col-md-1" id="cancelbutton" onclick="" type="button">
            <i class="fa fa-times"> </i>
                                            Clear
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
          <div id="#resize_grid" class="row" style="margin-right: 0;">
              <table id="jqgrid"></table>
              <div id="pjqgrid"></div>
          </div>
                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->
</article>
        </div>
        <!-- end widget -->

        <!-- WIDGET END -->

</section>
</div>
</div>

        <!-- end widget content -->


        <!-- end widget div -->




        <!-- end of table -->

        <!-- end col -->







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
     * TO LOAD A SCRIPT:
     * var pagefunction = function (){
     *  loadScript(".../plugin.js", run_after_loaded);
     * }
     *
     * OR you can load chain scripts by doing
     *
     * loadScript(".../plugin.js", function(){
     * 	 loadScript("../plugin.js", function(){
     * 	   ...
     *   })
     * });
     */

    // pagefunction

    var pagefunction = function() {
        loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);


        function run_jqgrid_function() {
            $('#startdate').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate:'0d',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                onSelect: function (selectedDate) {
                    $('#finishdate').datepicker('option', 'minDate', selectedDate);
                }
            });
            $('#finishdate').datepicker({
                dateFormat: 'yy-mm-dd',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                onSelect: function (selectedDate) {
                    $('#startdate').datepicker('option', 'maxDate', selectedDate);
                },
                maxDate:'0d'

            });
// Customize the grid

            jQuery("#jqgrid").jqGrid({
                //data : jqgrid_data,
                url: "ajax/stock_inventory/stockledger_get.php",
                datatype: "json",
                mtype: "GET",
                height : 'auto',
                page: 1,
                colNames : [  'Update Date','Update Time', 'Stock Name','Store Name','Task','Opening Balance','Quantity','Closing Balance','Remarks','UserName'],
                colModel : [
                    {
                        name : 'update_date',
                        index : 'update_date',
                        editable : true,
                        search:false


                    },{
                        name : 'update_time',
                        index : 'update_time',
                        editable : true,
                        search:false

                    }, {
                        name : 'stock_name',
                        index : 'stock_name',
                        editable : true,



                    },{
                        name : 'store_name',
                        index : 'store_name',
                        editable : true


                    },{
                        name : 'task',
                        index : 'task',
                        editable : true,
                        search:true


                    },{
                        name : 'opening_bal',
                        index : 'opening_bal',
                        editable : false,
                        search:false,
                        //sorttype:'float',
                        formatter:'integer',
                        summaryType:'sum'


                    },  {
                        name : 'quantity',
                        index : 'quantity',
                        editable : false,
                        search:false,
                        //sorttype:'float',
                        formatter:'integer',

                        summaryType:'sum'


                    },{
                        name : 'closing_bal',
                        index : 'closing_bal',
                        editable : false,
                        search:false,
                       // sorttype:'float',
                        formatter:'integer',
                        summaryType:'sum'


                    },
                    {
                        name : 'remarks',
                        index : 'remarks',
                        editable : false,
                        search:false


                    },


                    {
                        name: 'username',
                        index: 'username',
                        editable: false,
                        search:true,
                        //searchoptions:{sopt:['cn','in']}

                    }
                ],
                rowNum : 10,
                rowList : [10, 20, 30],
                //rowTotal:-1,
                pager : '#pjqgrid',
                sortname : 'stock_ledger_id',
              toolbarfilter : true,

                viewrecords : true,
                sortorder : "asc",
               //loadonce:true,
                ignoreCase: true,
                grouping:true,
                groupingView : {
                    groupField : ['stock_name'],
                    groupSummary : [true],
                    groupColumnShow : [true],
                    groupText : ['<b>{0}</b>'],
                    groupCollapse : false,
                    groupOrder: ['asc'],
                    showSummaryOnHide: true,
                    groupDataSorted : true
                },



               // editurl : "ajax/setup/stock_grid_set.php",
                //caption : "Stock ledger",


                autowidth : true,
                loadComplete: function (data) {
                    if(data.records == 0){

                        jQuery("#jqgrid").jqGrid("clearGridData");
                        }
                }


            });

            //I'm submitting the form now


//            Show tool Tip
            $('.navtable .ui-pg-button').tooltip({
                container : 'body'
            });


//            jQuery("#mysearch").jqGrid('filterGrid','#jqgrid',{filterModel:[{label:'Stock Name',name:'store_name'}],gridNames:true});


//            How the Left column starts showing initially

//            For the collapsible menu


//This is the function needed for the table and left side display



            //for the radio button check



            // activate the toolbar searching

//            jQuery("#jqgrid").jqGrid('filterToolbar',{  searchOnEnter: false});
            $('#jqgrid').jqGrid('navGrid',"#pjqgrid", {
                search: false, // show search button on the toolbar
                add: false,
                edit: false,
                del: false,
                refresh: true
            },
            {},//default settings edit
            {},//default settings add
            {},//default settings delete
            {closeAfterSearch:true,caption: "Search Stock Ledger..."
            },//default settings search
            {}//default settings view
            );



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
                $("#jqgrid").jqGrid('setGridWidth', $("#resize-grid").width());
            });


            //$('#post_result').html(jqgrid_data);
            //});
            //alert ($('#jsondata').val());
            //alert (jqgrid_data);




        }// end function

    }
    loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);

</script>
<script>
    $('document').ready(function () {
    var startdate;
    var finishdate;
    var stock_name;
    var postdata;
         if($('#startdate').val()==""){
        $('#stockledger_update').prop('disabled',true);
         }
         else{
             $('#stockledger_update').prop('disabled',false);
         }
//         Check if the user changed the start date
            $('#startdate').on('change', function () {
                if($('#startdate').val()==""){
                    $('#stockledger_update').prop('disabled',true);
                }
                else{
                    $('#stockledger_update').prop('disabled',false);
                }
            });

//check if the user has clicked the button
            $('#stockledger_update').click(
                function () {
                    stock_name=$('#stock-select').val();
                    startdate=$('#startdate').val();
                    finishdate=$('#finishdate').val();
                    jQuery('#jqgrid').jqGrid('setGridParam',{url: "ajax/stock_inventory/stockledger_get.php?stock_name="+stock_name+"&startdate="+startdate+"&finishdate="+finishdate}).trigger("reloadGrid");
                }


            );
            $('#cancelbutton').on("click", function () {
                $('#stock-group').removeClass('has-error');
                $('#startdate-group').removeClass('has-error');
                $('#finishdate-group').removeClass('has-error');
                $('.help-block').remove();
                $('#startdate').val('');
                $('#finishdate').val('');
                $('#stock-select').val('all_stock').trigger('change');
                jQuery('#jqgrid').jqGrid('setGridParam',{url: "ajax/stock_inventory/stockledger_get.php"}).trigger("reloadGrid");
            });
//       End of document.ready
        }
    );
</script>