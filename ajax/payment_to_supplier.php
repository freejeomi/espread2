<?php
require_once("../lib/config.php");
require_once("inc/init.php");
require_once("userlogcheck_admin.php");
$_SESSION['last_screen'] = "payment_to_supplier.php";
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
						<strong>Success</strong> Payment made successfully.
					</div>
				</div>';
	$failure =	'<div class="row">
					<div class="alert alert-danger fade in" style="margin-left: 13px; margin-right: 13px;">
						<buttton class="close" data-dismiss="alert">
							<i class="fa-fw fa fa-times"></i>
						</buttton>
						<i class="fa-fw fa fa-times"></i>
						<strong>Failed</strong> Error in accomplishing task. Ensure all required fields are filled
					</div>
				</div>';
	$account_low = '<div class="row">
					<div class="alert alert-danger fade in" style="margin-left: 13px; margin-right: 13px;">
						<buttton class="close" data-dismiss="alert">
							<i class="fa-fw fa fa-times"></i>
						</buttton>
						<i class="fa-fw fa fa-times"></i>
						<strong>Failed</strong> Sorry, you do not have enough in your account to perform this transaction
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

	if($message == 'failure'){
		echo $failure;
	}

	if($message == 'success'){
		echo $success;
	}
	if ($message == 'account low') {
		echo $account_low;
	}
	if ($message == 'locked') {
		echo $locked;
	}

	$date = date("Y/m/d");
	$today_opening_balance = "0.00";

	include "../lib/util.php";
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$sql = "SELECT * FROM supplier";
	$result = mysqli_query($conn, $sql);
	$options = '';
	if($result){
		while ($row = mysqli_fetch_array($result)) {
			$options = $options . '<option value="'.$row["supplier_id"].'">' .$row["supplier_name"] . '</option>';
		}
	}

	mysqli_close($conn);
	?>

	<!-- row -->
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-3" data-widget-custombutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false">
				<!-- widget options:
					usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

					data-widget-colorbutton="false"
					data-widget-editbutton="false"
					data-widget-togglebutton="false"
					data-widget-deletebutton="false"
					data-widget-fullscreenbutton="false"
					data-widget-custombutton="false"
					data-widget-collapsed="true"
					data-widget-sortable="false"

				-->
				<header>
					<h2>Payment To Supplier</h2>
				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<!--<div class="jarviswidget-editbox">
						<input class="form-control" type="text">
						<span class="note"><i class="fa fa-check text-success"></i> Change title to update and save instantly!</span>

					</div>-->
					<!-- end widget edit box -->

					<form action="<?php echo APP_URL; ?>/ajax/payment_to_supplier_post.php" method="POST" autocomplete="off">
					<div class="row" style="padding-top: 5px;">

						<div class="col-xs-9 col-sm-5 col-md-5 col-lg-5">
							<div class="input-group">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-default" disabled = "disabled" style="font-weight: bold;">Amount</button>
								</div><!-- /btn-group -->
								<input class="form-control" style="color: #8b91a0;" onblur="processRemark()" onkeypress="processRemark()" name="amount" type="text" placeholder="Enter Amount" id="amount" />
							</div>
							<br/>
							<div class="input-group">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-default" disabled = "disabled" style="font-weight: bold;">Supplier</button>
								</div><!-- /btn-group -->

								<select class="form-control" style="color: #8b91a0;" id="supplier" name="supplier" onchange="processRemark()">
									<option value="">Choose Supplier</option>
									<?php echo $options;?>
								</select>
							</div><br>
						</div>

						<div class="col-xs-3 col-sm-7 col-md-7 col-lg-7 text-right">
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-7 text-left">
									<textarea type="text" class="form-control"  name="remarks" id="remarks" placeholder="Remark(Optional)" rows=3></textarea>
									
									<!--<div class="alert alert-info fade in" style="font-size: 11px;">-->
									<!--	<strong>Remarks!</strong> <i>Enenim Bassey</i> about to make a payment.<br/>-->
									<!--	<strong>Beneficiary: </strong> <span id="span-beneficiary"></span> <br/>-->
									<!--	<strong>Amount: </strong> <span id="span-amount"></span> <br/>-->
									<!--	<strong>Date: </strong> <span id="span-date"></span>-->
									<!--</div>-->
								</div>
								<div class="col-md-4">
									<div class="input-group">
										<div class="input-group-btn">
											<button class="btn btn-primary" type="submit" id="make-payment" name="submit_payment">
												<i class="fa fa-save"></i> <span class="hidden-mobile">Make Payment</span>
											</button>
										</div>
									</div>
									<br/>
									<div class="input-group">
										<div class="input-group-btn">
											<button class="btn btn-danger" type="button" onclick="processReset()">
												<i class="fa fa-refresh"></i> <span class="hidden-mobile">Reset Fields &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
											</button>
										</div>
									</div>
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
		$('#span-date').text(today);
	});
	function processRemark() {
		var amount = document.getElementById("amount");
		var supplier = document.getElementById("supplier");
		var date = new Date();
		var month = date.getMonth() + 1;
		var today = date.getDate() + "/" + month  + "/" + date.getFullYear();

		var decimalpoint = 0;
		var valid_value = '';
		if(isNaN(amount.value)){
			//document.write(str1 + " is not a number <br/>");
			//amount.value = amount.value.substring(0, amount.value.length - 1);
			var str = '';
			for (i = 0; i < amount.value.length; i++) {
				str = amount.value.charAt(i) + '';
				if(str == '.'){
					decimalpoint = decimalpoint + 1;
				}
				if(isNaN(str) &&  str != '.'){

				}else{
					if(str == '.' && decimalpoint > 1){
						//do notthing
					}else{
						valid_value = valid_value + str;
					}
				}
			}
		}else{
			valid_value = amount.value;
		}

		amount.value = valid_value;
		
		var supplier = document.getElementById("amount");
supplier.addEventListener('blur', function(evt){
    var n = parseInt(this.value.replace(/\D/g,''),10);
    supplier.value = n.toLocaleString();
}, false);

		$('#span-amount').text(amount.value);
		if($("#supplier :selected").val() == ''){
			$('#span-beneficiary').text("");
		}else{
			$('#span-beneficiary').text($("#supplier :selected").text());
		}

		$('#span-date').text(today);
	}
	function processReset(){
		var amount = document.getElementById("amount");
		var supplier = document.getElementById("supplier");
		amount.value = "";
		supplier.value = "";
		var date = new Date();
		var month = date.getMonth() + 1;
		var today = date.getDate() + "/" + month  + "/" + date.getFullYear();

		$('#span-amount').text(amount.value);
		$('#span-beneficiary').text(supplier.value);
		$('#span-date').text(today);
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
				url: "ajax/cash_stock/expenses_grid_get.php",
				datatype: "json",
				mtype: "GET",
				height : 'auto',
				colNames : [ 'S/No', 'Beneficiary', 'Amount', 'Date','Remark', 'Time', 'Transaction Type'],
				colModel : [
					 {
						name : 'cashstock_id',
						index : 'cashstock_id',
						sortable : true,
						editable: false
					}, {
						name : 'beneficiary',
						index : 'beneficiary',
						editable : false
					}, {
						name : 'amount',
						index : 'amount',
						editable : false,
						formatter:'currency'
						//align : "left"
					},{
						name : 'date',
						index : 'date',
						editable : false,
						sortable : true
					},{
						name : 'remark',
						index : 'remark',
						editable :false
					},
					{
						name : 'time',
						index : 'time',
						sortable : true,
						editable : false
						//align : "right"
					},
					{
						name : 'transaction_type',
						index : 'transaction_type',
						editable :false
					}
					],
				rowNum : 10,
				rowList : [10, 20, 30],
				pager : '#pjqgrid',
				sortname : 'cashstock_id',
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
				editurl : "ajax/cash_stock/expenses_grid_set.php",
				caption : "Supplier Expenses",
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
