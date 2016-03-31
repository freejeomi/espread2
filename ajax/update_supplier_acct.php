<?php
require_once("inc/init.php");
require_once("userlogcheck_admin.php");
$_SESSION['last_screen'] = "update_supplier_acct.php";
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

<?php

include "../lib/util.php";


$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT supplier_id, supplier_name FROM supplier") or die("Couldn't execute query." . mysqli_error($conn));
$datalist = "";
while ($data = mysqli_fetch_assoc($result)) {
    if (isset($_GET['sup_Id']) && $_GET['sup_Id'] == $data['supplier_id']) {
        $datalist = $datalist . "<option value='{$data['supplier_id']}' selected>{$data['supplier_name']}</option>";
    } else {
        $default = "<option value='none'>--Select supplier--</option>";
        $datalist = $datalist . "<option value='{$data['supplier_id']}'>{$data['supplier_name']}</option>";
    }
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 2;
}


?>
<script>
    var newdate = new Date();
    var month = newdate.getMonth() + 1;
    var today = newdate.getDate() + "/" + month + "/" + newdate.getFullYear();
    document.getElementById("date").innerHTML = "Date: <b>" + today + "</b>";

    var supname = "";
    var transtype = "";
    var amount= "0.00";
    var ref= "";
    document.getElementById("supplierRemark").innerHTML = "Supplier name: ";

    document.getElementById("amountRemark").innerHTML = "Amount: " + ref;
    document.getElementById("refRemark").innerHTML = "Ref Number: ";


    $('#supplier-select').on("change", function () {
        supname = getSelectedText('supplier-select');
        if (supname == '--Select supplier--') {
            document.getElementById("supplierRemark").innerHTML = "Supplier name: ";
        }
        else {
            document.getElementById("supplierRemark").innerHTML = "Supplier name: <b>" + supname + "</b>";
        }
    });

    $('#select_type').on("change", function() {
        transtype = getSelectedText('select_type');
        if (transtype == 'Delivery') {
            document.getElementById("transRemark").innerHTML = "is receiving <b>" + transtype + "</b> from ";
        }
        else if (transtype == 'Select transaction type') {
            document.getElementById("transRemark").innerHTML = "is ...";
        }
        else {
            document.getElementById("transRemark").innerHTML = "is making <b>" + transtype + " to </b>";
        }
    });

    function getSelectedText(elementId) {
        var elt = document.getElementById(elementId);

        if (elt.selectedIndex == -1)
            return null;

        return elt.options[elt.selectedIndex].text;
    }

    function myFunction() {
        amount = document.getElementById("amount").value;
        document.getElementById("amountRemark").innerHTML = "Amount: <b>" + numberWithCommas(amount) + "</b>";
    }
    function myFunction2() {
        ref = document.getElementById("ref").value;
        document.getElementById("refRemark").innerHTML = "Ref Number: <b>" + ref + "</b>";
    }
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- START ROW -->
    <div class="row">

        <!-- NEW COL START -->
        <article class="col-sm-12 col-md-12 col-lg-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-3" data-widget-custombutton="false" data-widget-colorbutton="false"
                 data-widget-editbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>

                    <h2>Update Supplier Account</h2>

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
                        <article class="col-sm-8 col-md-8 col-lg-8">

                            <form action="" id="order-form" class="smart-form" novalidate="novalidate">
                                <fieldset>
                                    <div id="message_div"></div>
                                </fieldset>
                                <fieldset>
                                    <div id="message-group"></div>
                                    <div class="row">

                                        <section class="col col-6" id="supplier-group">
                                            <label class="select"> <i class="icon-append fa fa-user"></i>
                                                <!--<input type="text" disabled value="<?php //echo $sup_name;?>" name="name" style="background-color: #F0F0F0;" id="cusname">-->
                                                <select id="supplier-select" name="supplier">
                                                    <?php echo $default; ?>
                                                    <?php echo $datalist; ?>
                                                </select>
                                            </label>
                                        </section>

                                        <section class="col col-6" id="transaction-group">
                                            <label class="select">
                                                <select name="transaction" id="select_type" onchange="myFunction2()">
                                                    <option value="none">Select transaction type</option>
                                                    <option value="delivery">Delivery</option>
                                                    <option value="payment">Payment</option>
                                                </select> <i></i> </label>
                                        </section>
                                    </div>

                                    <div class="row">

                                        <section class="col col-6" id="amount-group">
                                            <label class="input">
                                                <input type="text" placeholder="Amount" name="amount" id="amount"
                                                       onkeyup="myFunction()" onblur="myFunction()">
                                            </label>
                                        </section>

                                        <section class="col col-6" id="ref-group">
                                            <label class="input">
                                                <input type="text" placeholder="Ref" name="ref" id="ref" onkeyup="myFunction2()" onblur="myFunction2()">
                                            </label>
                                        </section>
                                    </div>
                                    <div class="row">

                                        <section class="col col-6">
                                            <label class="input">
											<input class="" placeholder="Remark(optional)" name="remark" id="remark">
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                            <label> <i>&nbsp</i></label>
                                            <label class="checkbox" id="cashstock_box" style="display: none;">
                                                <input type="checkbox" checked="checked" name="checkbox-inline" value="off" id="cash-check">
                                                <i></i>
                                                Debit my cash stock
                                            </label>
                                        </section>
                                        <section class="col col-2">
                                            <!--<label> <i>&nbsp</i></label>-->
                                            <label class="button">
                                                <button type="submit" class="btn btn-primary">
                                                    Update
                                                </button>
                                            </label>
                                        </section>
                                    </div>
                                    <!--<input type="hidden" value="<?php // echo $sup_id;?>" name= "sup_Id">-->
                                </fieldset>
                            </form>
                        </article>

                        <article class="col-sm-12 col-md-4 col-lg-4" style="margin-top: 20px;">
                            <section class="col col-6">
                                <div class="alert alert fade in" style="background-color: #F0F0F0;" id="remarks">
                                    <i class="fa-fw fa fa-info"></i>
                                    <strong>Payment Info</strong><br>
                                    <span id=""><b><?php if (isset($_SESSION['username'])) {echo $_SESSION['username'];} ?></b>
                                    <span id="transRemark"> is ...</span></span><br>
                                    <span id="supplierRemark">Supplier name:</span><br>
                                    <span id="date"> </span><br>
                                    <span id="amountRemark"></span><br>
                                    <span id="refRemark"></span><br>
                                </div>
                                <p id="date_today"></p>
                            </section>
                        </article>

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


        function run_jqgrid_function() {

            jQuery("#jqgrid").jqGrid({
                //data : jqgrid_data,
                url: "ajax/supplier_account/update_supplier_acct_get.php<?php if (isset($_GET['sup_Id'])){echo '?sup_Id='.$_GET['sup_Id'];}?>",
                datatype: "json",
                mtype: "GET",
                height: 'auto',
                colNames: ['ID', 'Date of Transaction', 'Time of Transaction', 'Reference', 'Delivery', 'Payment', 'Payment Type', 'Transaction Type', 'Remark', 'User Name'],
                colModel: [
                    {
                        name: 'suppliertrans_Id',
                        index: 'suppliertrans_Id',
                        sortable: true,
                        editable: false
                    }, {
                        name: 'date',
                        index: 'date',
                        editable: false
                    },
                    {
                        name: 'time',
                        index: 'time',
                        editable: false
                    },
                    {
                        name: 'ref',
                        index: 'ref',
                        editable: false
                    },
                    {
                        name: 'delivery',
                        index: 'delivery',
                        editable: false,
                        formatter: 'number'
                    }, {
                        name: 'payment',
                        index: 'payment',
                        editable: false,
                        formatter: 'number'
                    },
                    {
                        name: 'payment_type',
                        index: 'payment_type',
                        editable: false
                    },
                    {
                        name: 'transaction_type',
                        index: 'transaction_type',
                        editable: false
                    },
                    {
                        name: 'remark',
                        index: 'remark',
                        editable: false
                    },
                    {
                        name: 'username',
                        index: 'username',
                        editable: false
                    }
                ],
                rowNum: 10,
                rowList: [10, 20, 30],
                pager: '#pjqgrid',
                sortname: 'suppliertrans_Id',
                toolbarfilter: true,
                viewrecords: true,
                sortorder: "desc",

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

                        vs = "<p class='btn btn-sm btn-primary'>View Account Statement</p>"
                        mp = "<p class='btn btn-sm btn-success'>Make payment</p>"

                        jQuery("#jqgrid").jqGrid('setRowData', ids[i], {
                            act: vs,
                            act2: mp
                        });
                    }
                },
                //editurl : "ajax/customer_account/customer_acct_bal_set.php",
                caption: "Supplier Account Balance",
                multiselect: false,
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

    }
    loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);
</script>

<script>

    //	function makeAjaxRequest(opts){
    //		var jqgrid_data;
    //       $.ajax({
    //         type: "POST",
    //        data: { opts: opts },
    //          url: "process_ajax.php",
    //         success: function(data) {
    //            jqgrid_data = data;
    //			$('#jsondata').val(data);
    //			var jqgrid_data = JSON.parse(data);
    //         }
    //        });
    //    }
    //	$("#customer-select").on("change", function(){
    //	var selected = $(this).val();
    //		makeAjaxRequest(selected);
    //	})
</script>


<script>

    //	var supplier_id= $('select[name= supplier]').val();
    //function makeAjaxRequest(opts){
    //	$.ajax({
    //		type: "POST",
    //		data: { opts: opts },
    //		url: "ajax/supplier_account/update_supplier_acct_get.php",
    //		success: function(res) {
    //
    //		}
    //	});
    //}
    var selected;
    var selected_type;


    $("#supplier-select").on("change", function () {
        selected = $(this).val();
        //alert(selected);
        if (selected != 'none') {
            $('#jqgrid').jqGrid('setGridParam', {url: "ajax/supplier_account/update_supplier_acct_get.php?supselect_id=" + selected}).trigger("reloadGrid");
        }
        else {
            $('#jqgrid').jqGrid('clearGridData');
        }
        //makeAjaxRequest(selected);
    });

    $("#select_type").on("change", function () {
        selected_type = $(this).val();
        //alert(selected);
        if (selected_type == 'payment') {
            $("#cashstock_box").show();
        }
        else {
            $("#cashstock_box").hide();
        }
    });


    $(document).ready(function () {
        $('#order-form').submit(function (event) {

            $('.form-group').removeClass('has-error'); // remove the error class
            $('.help-block').remove(); // remove the error text
            $('#message_div').empty();
            var cash_check = "";
            if (document.getElementById("cash-check").checked) {
                cash_check = "on";
            }
            else {
                cash_check = "off";
            }
            var user_id = "<?php echo $user_id;?>";
            // get the form data
            var formData = {
                'supplier': $('select[name= supplier]').val(),
                'amount': $('input[name= amount]').val(),
                'transaction': $('select[name= transaction]').val(),
                'ref': $('input[name= ref]').val(),
                'remark': $('#remark').val(),
                'debit_cash': cash_check,
                'user_id': user_id
            };
            // process the form
            $.ajax({
                type: 'POST',
                url: 'ajax/supplier_account/update_supplier_acct_set.php',
                data: formData,
                dataType: 'json',
                encode: true
            })
                // using the done promise callback
                .done(function (data) {
                    if (!data.success) {
                        if (data.errors.supplier) {
                            $('#supplier-group').addClass('has-error'); // add the error class to show red input
                            $('#supplier-group').append('<div class="help-block">' + data.errors.supplier + '</div>'); // add the actual error message under our input
                        }
                        if (data.errors.amount) {
                            $('#amount-group').addClass('has-error'); // add the error class to show red input
                            $('#amount-group').append('<div class="help-block">' + data.errors.amount + '</div>'); // add the actual error message under our input
                        }
                        if (data.errors.transaction) {
                            $('#transaction-group').addClass('has-error'); // add the error class to show red input
                            $('#transaction-group').append('<div class="help-block">' + data.errors.transaction + '</div>'); // add the actual error message under our input
                        }
                        if (data.errors.ref) {
                            $('#ref-group').addClass('has-error'); // add the error class to show red input
                            $('#ref-group').append('<div class="help-block">' + data.errors.ref + '</div>'); // add the actual error message under our input
                        }
                        if (data.errors.user_id) {
                            $('#ref-group').addClass('has-error'); // add the error class to show red input
                            $('#ref-group').append('<div class="help-block">' + data.errors.user_id + '</div>'); // add the actual error message under our input
                        }
                    }

                    else {
                        if (data.error_message) {
                            //alert(data.error_message);
                            $('#message_div').append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i>' + data.error_message + '</div>');
                        }
                        else if (data.locked) {
                            $('#message_div').append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i>' + data.locked + '</div>');
                        }
                        else {
                            <?php //if (isset($_GET['sup_Id'])){echo '?sup_Id='.$_GET['sup_Id'];}?>
                            selected = $("#supplier-select").val();
                            alert (selected);
                            $('#jqgrid').jqGrid('setGridParam', {url: "ajax/supplier_account/update_supplier_acct_get.php?supselect_id=" + selected}).trigger("reloadGrid");
                            $('input[name= amount]').val('');
                            $('select[name= transaction]').val('none').trigger('change');
                            $('input[name= ref]').val('');
                            $('#remark').val('');
                            $('#ref-group').removeClass('has-error'); // remove the error class
                            $('#amount-group').removeClass('has-error');
                            $('#transaction-group').removeClass('has-error');
                            $('.help-block').remove();
                            $('#message_div').append('<div class="alert alert-success" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Payment Successful!!!</div>');
                        }
                    }

                        //}

                        //window.location = 'emconfirmation.php'; // redirect a user to another page
                });
            event.preventDefault();
        });
    });
</script>
