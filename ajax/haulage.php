<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");
$_SESSION['last_screen'] = "haulage.php";
?>
<!--
	The ID "widget-grid" will start to initialize all widgets below
	You do not need to use widgets if you dont want to. Simply remove
	the <section></section> and you can use wells or panels instead
	-->
<?php
//if ($_GET['sup_Id']) {
//	$sup_id = $_GET['sup_Id'];
//	$servername = "localhost";
//	$username = "root";
//	$password = "";
//	$dbname = "espread";
//
//	$conn = mysqli_connect($servername, $username, $password, $dbname);
//	if (!$conn) {
//		die("Connection failed: " . mysqli_connect_error());
//	}
//	$result = mysqli_query( $conn, "SELECT * FROM supplier WHERE supplier_id= $sup_id") or die("Couldn't execute query.".mysqli_error($conn));
//	while ($data = mysqli_fetch_assoc($result))
//	{
//		$sup_id= $data['supplier_id'];
//		$sup_name= $data ['supplier_name'];
//	}
//}
//else {
//	$error= "sorry an error occured. please try again!";
//}
?>

<!--<script>-->
<!--    var newdate = new Date();-->
<!--    var month = newdate.getMonth() + 1;-->
<!--    var today = newdate.getDate() + "/" + month + "/" + newdate.getFullYear();-->
<!--    document.getElementById("date").innerHTML = "Date: " + today;-->
<!--    var supname = document.getElementById("supplier-select").value;-->
<!--    document.getElementById("nameRemark").innerHTML = "Supplier name: " + supname;-->
<!---->
<!--    function myFunction() {-->
<!--        var x = document.getElementById("amount").value;-->
<!--        document.getElementById("amountRemark").innerHTML = "Amount: " + x;-->
<!--    }-->
<!--    function myFunction2() {-->
<!--        var cash = document.getElementById("ref").value;-->
<!--        document.getElementById("cashtype").innerHTML = "Payment Type: " + cash;-->
<!--    }-->
<!--</script>-->
<script>
    var newdate = new Date();
    var month = newdate.getMonth() + 1;
    var today = newdate.getDate() + "/" + month + "/" + newdate.getFullYear();
    document.getElementById("date").value =  today;
</script>
<!-- widget grid -->
<section id="widget-grid" class="">
<div class="row" style="display: none;" id="success_message">

</div>
    <!-- START ROW -->
    <div class="row" id="form_dropdown" style="display: none;">

        <!-- NEW COL START -->
        <article class="col-sm-12 col-md-12 col-lg-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-3" data-widget-custombutton="false" data-widget-colorbutton="false"
                 data-widget-editbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>

                    <h2>Haulage</h2>

                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">

                        <form action="" id="haulage-form" class="form-horizontal">

                            <br>
                                <fieldset>
                                <article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    <div class="form-group" id="vehicle-group">
                                        <label for="vehicle" class="col-sm-3 control-label">Vehicle</label>

                                        <div class="col-sm-9" id="">
                                            <input type="text" class="form-control" name="vehicle" id="vehicle" disabled>
                                            <input type='hidden' id='vehicle_id' value=''>
                                        </div>
                                    </div>
                                    <div class="form-group" id="date-group">
                                        <label for="date" class="col-sm-3 control-label">Date:</label>

                                        <div class="col-sm-9" id="">
                                            <input type="text" class="form-control" name="date" id="date" disabled>
                                        </div>
                                    </div>

                        </article>
                        <article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    <div class="form-group" id="">
                                        <label for="waybill" class="col-sm-3 control-label">Waybill:</label>

                                        <div class="col-sm-9" id="waybill-group">
                                            <input type="number" class="form-control" name="waybill" id="waybill">
                                        </div>
                                    </div>
                                    <div class="form-group" id="">
                                        <label for="expenditure" class="col-sm-3 control-label">Expenditure:</label>

                                        <div class="col-sm-9" id="expenditure-group">
                                            <input type="number" class="form-control" name="expenditure" id="expenditure">
                                        </div>
                                    </div>

                        </article>
                        <article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="note" class="col-sm-3 control-label">Note:</label>

                                        <div class="col-sm-9">
                                            <textarea rows="4" class="form-control" name="note"
                                                   id="note"></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="check" id="check" value="0">

                        </article>
                        <article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class=" checkbox">
                                        <label>
                                            <input type="checkbox" name="cashstock"
                                                   id="cashstock" checked>
                                            Debit my cash stock
                                        </label>
                                    </div>
                                </div><br><br><br>
                                <div>
                                    <button class="btn btn-danger" id="cancel" type="button">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary " id="haulage-submit" style="margin-left: 30px;">
                                        Update
                                    </button>
                                </div>
                        </article>
                                </fieldset>
                            </form>


                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->
        </article>

    </div>

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <table id="jqgrid"></table>
            <div id="pjqgrid"></div>

            <br>

            <div id="post_result"></div>
            <input type="hidden" value="" id="jsondata">
        </article>
        <!-- WIDGET END -->

    </div>

    <!-- end row -->

    <!-- row -->

    <div class="row">

        <!-- a blank row to get started -->
        <div class="col-sm-12">
            <!-- your contents here -->
            <div id="results">

            </div>
        </div>

    </div>

    <!-- end row -->

</section>
<!-- end widget grid -->
<script>
    function updateAccount (grid_params) {
       var veh_id= $(grid_params).children('.grid_id').val();
       var veh_name=  $(grid_params).children('.grid_name').val();
       $('#vehicle').val(veh_name);
       $('#vehicle_id').val(veh_id);
       $('#form_dropdown').slideDown(200);
    }


    $(document).ready(function () {
        $('#cancel').click(function () {
            $('#expenditure-group').removeClass('has-error');
            $('#waybill-group').removeClass('has-error');
            $('.help-block').remove();
            $('#waybill').val('');
            $('#expenditure').val('');
            $('#form_dropdown').slideUp(200);
        });
        $('#haulage-form').submit(function (event) {

            $('#expenditure-group').removeClass('has-error');
            $('#waybill-group').removeClass('has-error'); // remove the error class
            $('.help-block').remove(); // remove the error text
            var cash_check = "";
            if (document.getElementById("cashstock").checked) {
                cash_check = "on";
            }
            else {
                cash_check = "off";
            }

            // get the form data
            var formData = {
                'vehicle_name': $('#vehicle').val(),
                'vehicle_id': $('#vehicle_id').val(),
                'waybill': $('input[name= waybill]').val(),
                'expenditure': $('input[name= expenditure]').val(),
                'note': $('textarea[name= note]').val(),
                'cashstock': cash_check
            };
            // process the form
            $.ajax({
                type: 'POST',
                url: 'ajax/haulage/haulage_post.php',
                data: formData,
                dataType: 'json',
                encode: true
            })
                // using the done promise callback
                .done(function (data) {
                    if (!data.success) {
                        if (data.errors.waybill) {
                            $('#waybill-group').addClass('has-error'); // add the error class to show red input
                            $('#waybill-group').append('<div class="help-block">' + data.errors.waybill + '</div>'); // add the actual error message under our input
                        }
                        if (data.errors.expenditure) {
                            $('#expenditure-group').addClass('has-error'); // add the error class to show red input
                            $('#expenditure-group').append('<div class="help-block">' + data.errors.expenditure + '</div>'); // add the actual error message under our input
                        }
                    }
                    else {
                        if (data.error_message) {
                            //alert(data.error_message);
                            $('#success_message').empty().html('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i>' + data.error_message + '</div>').fadeIn('fast');
                        }
                        else if (data.locked) {
                            $('#success_message').empty().append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i>' + data.locked + '</div>').fadeIn('fast');
                        }
                        else {
                            $('#form_dropdown').slideUp(200);
                            $('#jqgrid').jqGrid('setGridParam', {url: "ajax/haulage/haulage_get.php"}).trigger("reloadGrid");
                            $('input[name= expenditure]').val('');
                            $('input[name= vehicle]').val('');
                            $('input[name= waybill]').val('');
                            $('textarea[name= note]').val('');
                            $('#success_message').empty().html('<p class="alert alert-success col-md-offset-3 col-md-6" style="text-align: center;"> update Successful </p>').fadeIn('fast').fadeOut(1000);
                        }
                    }
                });
            event.preventDefault();
        });
    });
</script>
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

    var pagefunction = function () {
        loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);
        var vehicle_name;

        function run_jqgrid_function() {

            jQuery("#jqgrid").jqGrid({
                //data : jqgrid_data,
                url: "ajax/haulage/haulage_get.php",
                datatype: "json",
                mtype: "GET",
                height: 'auto',
                colNames: ['ID', 'Vehicle', 'Balance', 'Action'],
                colModel: [
                    {
                        name: 'vehicle_Id',
                        index: 'vehicle_Id',
                        sortable: true,
                        editable: false
                    }, {
                        name: 'vehicle',
                        index: 'vehicle',
                        editable: false
                    },
                    {
                        name: 'balance',
                        index: 'balance',
                        formatter:'currency',
                        editable: false
                    },
                    {
                        name: 'act',
                        index: 'act',
                        editable: false
                    }
                ],
                rowNum: 10,
                rowList: [10, 20, 30],
                pager: '#pjqgrid',
                sortname: 'vehicle_Id',
                toolbarfilter: true,
                viewrecords: true,
                sortorder: "asc",

                //beforeSelectRow: function (rowid, e) {
                //	var $td = $(e.target).closest("td"),
                //    iCol = $.jgrid.getCellIndex($td[0]);
                //	if (this.p.colModel[iCol].name === 'note') {
                //	    window.location = "/ajax/customer_account/customer_acct_detail.php/" + encodeURIComponent(rowid);
                //    return false;
                //	}
                //},
                gridComplete: function () {
                    var ids = jQuery("#jqgrid").jqGrid('getDataIDs');
                    //alert(rolenames);

                    for (var i = 0; i < ids.length; i++) {
                        var cl = ids[i];
                        vehicle_name = jQuery("#jqgrid").jqGrid('getCell', cl, 'vehicle');
//console.log(vehicle_name);
                        mp = "<button class='btn btn-sm btn-success' id='update_acct' onclick='updateAccount(this)'> Update Account <input type='hidden' class='grid_id' value='" + cl + "'><input type='hidden' class='grid_name' value='" + vehicle_name + "'></button>";   //update button


                        jQuery("#jqgrid").jqGrid('setRowData', ids[i], {
                            act: mp
                        });
                    }
                },
                //editurl : "ajax/customer_account/customer_acct_bal_set.php",
                caption: "Haulage",
                //multiselect: true,
                autowidth: true,

            });
            jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
                edit: false,
                add: false,
                del: false,
                search: true,
                view: false
            });
            //jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
            ///* Add tooltips */
            //$('.navtable .ui-pg-button').tooltip({
            //	container : 'body'
            //});

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
            $(".ui-icon.ui-icon-document").removeClass().addClass("fa fa-file");
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

            //alert ($('#jsondata').val());
            //alert (jqgrid_data);

        }// end function

    };
    loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);
</script>
