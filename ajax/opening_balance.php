<?php
require_once("../lib/config.php");
require_once("inc/init.php");
require_once("userlogcheck_admin.php");
$_SESSION['last_screen'] = "opening_balance.php";
?>
<!-- row -->
<div class="row">

	<!-- col -->
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
	</div>
	<!-- end col -->

	<!-- right side of the page with the sparkline graphs -->
	<!-- col -->
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

	</div>
	<!-- end col -->

</div>
<!-- end row -->

<!--
	The ID "widget-grid" will start to initialize all widgets below
	You do not need to use widgets if you dont want to. Simply remove
	the <section></section> and you can use wells or panels instead
	-->

<!-- widget grid -->
<section id="widget-grid" class="">

	<?php
	$message = "";
	if(isset($_GET['message'])){
		$message = $_GET['message'];
	}

	$success = '<div class="row">
					<div class="alert alert-success fade in" style="margin-left: 13px; margin-right: 13px;">
						<buttton class="close" data-dismiss="alert">
							<i class="fa-fw fa fa-times"></i>
						</buttton>
						<i class="fa-fw fa fa-check"></i>
						<strong>Success</strong> Opening Balance reset successfully.
					</div>
				</div>';
	$failure =	'<div class="row">
					<div class="alert alert-danger fade in" style="margin-left: 13px; margin-right: 13px;">
						<buttton class="close" data-dismiss="alert">
							<i class="fa-fw fa fa-times"></i>
						</buttton>
						<i class="fa-fw fa fa-times"></i>
						<strong>Failed</strong> Error in accomplishing task.
					</div>
				</div>';
	$locked = '<div class="row">
					<div class="alert alert-danger fade in" style="margin-left: 13px; margin-right: 13px;">
						<buttton class="close" data-dismiss="alert">
							<i class="fa-fw fa fa-times"></i>
						</buttton>
						<i class="fa-fw fa fa-times"></i>
						<strong>Failed</strong> Sorry, you are unable to carry out transaction until the next business day
					</div>
				</div>';

	if($message == 'update_failure' || $message == 'insert_failure'){
		echo $failure;
	}

	if($message == 'update_success' || $message == 'insert_success'){
		echo $success;
        ?>

        <script>$('#closing_bal').hide();</script>

    <?php
	}
	if ($message == 'locked') {
		echo $locked;
	}
	include "../lib/util.php";
	$date = date("Y/m/d");
	//$last_date = date('Y-m-d', strtotime( $date . ' -1 day'));
	//echo $last_date;
	$today_opening_balance = "0.00";
    $balance= "0.00";
    $display= "0.00";

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


    $sql_date= mysqli_query($conn, "SELECT max(date) as date from cashstock where transaction_type= 'opening balance'");
    if (mysqli_num_rows($sql_date) > 0) {
        $row = mysqli_fetch_assoc($sql_date);
        $last_date = $row['date'];

        $result_bal = mysqli_query($conn, "SELECT amount from cashstock where transaction_type='opening balance' and date='$last_date'");
        if (mysqli_num_rows($result_bal) > 0) {
            $row = mysqli_fetch_assoc($result_bal);
            $opbal_ = $row['amount'];
        } else {
            $opbal_ = 0.00;
        }
        $result_cashin = mysqli_query($conn, "SELECT sum(amount) as cashin from cashstock where amount > 0 and transaction_type !='opening balance' and date= '$last_date'");
        if (mysqli_num_rows($result_cashin) > 0) {
            $row = mysqli_fetch_assoc($result_cashin);
            if ($row['cashin']) {
                $cashin = $row['cashin'];
            } else {
                $cashin = 0.00;
            }
        } else {
            $cashin = 0.00;
        }
        $result_cashout = mysqli_query($conn, "SELECT sum(amount) as cashout from cashstock where amount < 0 and transaction_type != 'customer payment' and date= '$last_date' ");
        if (mysqli_num_rows($result_cashout) > 0) {
            $row = mysqli_fetch_assoc($result_cashout);
            if ($row['cashout']) {
                $cashout = $row['cashout'];
            } else {
                $cashout = 0.00;
            }
        } else {
            $cashout = 0.00;
        }
        $balance = $opbal_ + $cashin + $cashout;
        //echo $balance;
    }

    $sql = "SELECT amount FROM openingbalance WHERE date = '$date' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $today_opening_balance = $row["amount"];
        }
    }
    if ($today_opening_balance == "0.00") {
       // echo 'cl' .$balance;
        $display= $balance;
    }
    else {
        //echo 'to'.$today_opening_balance;
        $display= $today_opening_balance;
    }

	mysqli_close($conn);
	?>

	<!-- row -->
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-3" data-widget-custombutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false"">
				<header>
					<h2><strong>Reset</strong> <i>Opening Balance</i></h2>
				</header>
				<!-- widget div-->
				<div>
					<form action="<?php echo APP_URL; ?>/ajax/opening_balance_post.php" method="POST" autocomplete="off">
					<div class="row" style="padding-top: 10px;">

						<div class="col-xs-9 col-sm-5 col-md-5 col-lg-5">
							<div class="input-group">

								<input id="amount" name="amount" onkeyup="processRemark()" onblur="processRemark()" class="form-control" type="text"  value="<?php echo number_format($display,2);?>">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-primary" name="reset_opening_balance">Update</button>
								</div><!-- /btn-group -->

							</div>
						</div>
						<div class="col-xs-3 col-sm-7 col-md-7 col-lg-7 text-right">
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-7 text-left">
									<div class="alert well fade in"  style="font-size: 11px;">
										<strong>Opening Balance</strong> on <span id="span-date"></span> is <span id="span-amount"></span><br>
                                        <span id="closing_bal">
                                            <strong>Closing Balance</strong> for last business day is <span
                                            id="span-amount_close"></span>
                                        </span>
									</div>
								</div>
								<div class="col-md-4">
									<button class="btn btn-danger" type="button" onclick="processReset()">
										<i class="fa fa-refresh"></i> <span class="hidden-mobile">Reset</span>
									</button>
								</div>
							</div>
						</div>

					</div>
					</form>

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

			</div>
			<!-- end widget div -->
			<!-- end widget -->
		</article>
	</div>
	<!-- end row -->

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<table id="jqgrid"></table>
			<div id="pjqgrid"></div>

			<!--<br>
			<a href="javascript:void(0)" id="m1">Get Selected id's</a>
			<br>
			<a href="javascript:void(0)" id="m1s">Select(Unselect) row 13</a>
			-->
		</article>
		<!-- WIDGET END -->

	</div>
	<!-- end row -->

</section>
<!-- end widget grid -->

<script type="text/javascript">
	$( document ).ready(function() {
		var date = new Date();
		var month = date.getMonth() + 1;
		var today = date.getDate() + "/" + month  + "/" + date.getFullYear();
		var amount = document.getElementById("amount");
		$('#span-amount').text('<?php echo number_format($today_opening_balance, 2);?>');
        var today_op= $('#span-amount').text();
        if (today_op == '0.00') {
            $('#span-amount_close').text('<?php echo number_format($display, 2);?>');
        }
        else {
            $('#closing_bal').hide();
        }
		$('#span-date').text(today);
	});
	$('#amount').focus(function () {
		//$(this).val("");
		$('#span-amount').text("...");
	});
	function processRemark() {
		var amount = document.getElementById("amount");
		var date = new Date();
		var month = date.getMonth() + 1;
		var today = date.getDate() + "/" + month  + "/" + date.getFullYear();
//		var valid_value = '';
//		var decimalpoint = 0;
//
//		if(isNaN(amount.value)){
//			//document.write(str1 + " is not a number <br/>");
//			//amount.value = amount.value.substring(0, amount.value.length - 1);
////			var str = '';
//			for (i = 0; i < amount.value.length; i++) {
//				str = amount.value.charAt(i) + '';
//				if(str == '.'){
//					decimalpoint = decimalpoint + 1;
//				}
//				if(isNaN(str) &&  str != '.'){
//					//do nothing
//				}
//				else{
//					if(str == '.' && decimalpoint > 1){
//						//do nothing
//					}else{
//						valid_value = valid_value + str;
//					}
//				}
//			}
//		}
//		else{
//			valid_value = amount.value;
//		}
//
//		amount.value = valid_value;

		if(amount.value == ''){
			var zero_amount = '0.00';
			//amount.value = '00';
			$('#span-amount').text(zero_amount);
		}else{
			$('#span-amount').text(numberWithCommas(amount.value));
		}
		$('#span-date').text(today);
	}
	function processReset(){
		var amount = document.getElementById("amount");
		amount.value = "";
		var date = new Date();
		var month = date.getMonth() + 1;
		var today = date.getDate() + "/" + month  + "/" + date.getFullYear();

		if(amount.value == ''){
			amount.value= '0.00';
			var zero_amount = '<?php echo number_format($display, 2);?>';
			$('#span-amount').text(zero_amount);
		}else{
			$('#span-amount').text(amount.value);
		}
		$('#span-date').text(today);
	}

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
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
	 */

	var pagefunction = function() {
		loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);
		function run_jqgrid_function() {
			jQuery("#jqgrid").jqGrid({
				url: "ajax/cash_stock/opening_balance_grid_get.php",
				datatype: "json",
				mtype: "GET",
				height : 'auto',
				colNames : [ 'S/No', 'Amount', 'Date'],
				colModel : [
					 {
						name : 'openingbal_id',
						index : 'openingbal_id',
						sortable : true,
						editable: false
					}, {
						name : 'amount',
						index : 'amount',
						formatter:'number',
						editable : false
					}, {
						name : 'date',
						index : 'date',
						sortable : true,
						editable : false,
						align : "left"
					}
					],
				rowNum : 10,
				rowList : [10, 20, 30],
				pager : '#pjqgrid',
				sortname : 'openingbal_id',
				toolbarfilter : true,
				viewrecords : true,
				sortorder : "desc",
				gridComplete : function() {
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
							act : be + se + ca
						});
					}
				},
				editurl : "ajax/cash_stock/opening_balance_grid_set.php",
				caption : "<strong>Daily Opening Balance</strong>",
				multiselect : false,
				autowidth : true,

			});
			jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
				edit : false,
				add : false,
				del : false,
				search: true
			});
			//jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
			/* Add tooltips */
			$('.navtable .ui-pg-button').tooltip({
				container : 'body'
			});

			jQuery("#m1").click(function() {
				var s;
				s = jQuery("#jqgrid").jqGrid('getGridParam', 'selarrrow');
				alert(s);
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
		}// end function
	}
	loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);

</script>
