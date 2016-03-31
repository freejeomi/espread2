<?php 
require_once("inc/init.php");
require_once("../lib/config.php");
require_once("userlogcheck_admin.php");
include "../lib/util.php";
$_SESSION['last_screen'] = "supplier_acct_detail.php";
 ?>
<!--
	The ID "widget-grid" will start to initialize all widgets below 
	You do not need to use widgets if you dont want to. Simply remove 
	the <section></section> and you can use wells or panels instead 
	-->


<?php
	if ($_GET['sup_Id']) {
		$sup_id = $_GET['sup_Id'];

		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		} 
		$result = mysqli_query( $conn, "SELECT * FROM supplier WHERE supplier_id= $sup_id") or die("Couldn't execute query.".mysqli_error($conn));
		while ($data = mysqli_fetch_assoc($result))
		{
			$sup_id= $data['supplier_id'];
			$sup_name= $data ['supplier_name'];
			//$cus_type= $data ['customer_type'];
		}
		$cash= mysqli_query($conn,"SELECT sum(if(amount >0, amount, 0.00))AS credit, sum(if(amount <0, amount, 0.00))AS debit FROM supplier_account WHERE supplier_id= $sup_id");
		while ($data = mysqli_fetch_assoc($cash))
		{
			$debit= $data['debit'];
			$credit= $data ['credit'];
			$closingbal= $debit+ $credit;			
		}		
	}
	else {
		$error= "sorry an error occured. please try again!";
	}
?>
<!-- widget grid -->
<section id="widget-grid" class="">
	<!-- row -->
	<div class="row">		
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">			
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false">
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
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Customer Details </h2>					
				</header>
				<!-- widget div-->
				<div>					
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->							
					</div>
					<!-- end widget edit box -->					
					<!-- widget content -->
					<div class="widget-body">						
						<div class="row container-fluid">
							<section class="col-md-4 col-sm-4 col-lg-4 col-xs-12 well">
								<div class="row">
									<span class="col-md-6">Name: <b><?php echo $sup_name;?></b></span>
									<!--<span class="col-md-6">Type: <b><?//php echo $cus_type;?></b></span>-->
								</div>						
							</section>
							<section class="col-md-3 col-sm-3 col-lg-3 col-xs-12"></section>
							<section class="col-md-5 col-sm-5 col-lg-5 col-xs-12 well">
								<div class="row"></div>
								<div class="row">
									
									<span class="col-md-4">Total Debit: <b><?php echo $debit;?></b></span>
									
									<span class="col-md-4">Total Credit: <b><?php echo $credit;?></b></span>
<!--									<span class="col-md-1"></span>-->
									
									<span class="col-md-4">Balance: <b><?php echo $closingbal;?></b></span>
									
								</div>								
							</section>
						</div>
			
					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->
		
	</div>

	<!-- end row -->
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
<div class-='pull_right'>
		<a class='btn btn-sm btn-primary' href="<?php echo APP_URL; ?>/supplier_acct_detail_print.php?sup_Id=<?php echo $sup_id; ?>" target="_blank">Print Account Statement</a>
	</div>	
	<!-- end row -->

	<!-- row -->

	<div class="row">

		<!-- a blank row to get started -->
		<div class="col-sm-12">
			<!-- your contents here -->
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
	
	var pagefunction = function() {
		loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);
		

		function run_jqgrid_function() {
			
			//var url= "ajax/ajaxgrid.php";
			//var email = 'email';
			//var jqgrid_data;			
			//$.post(url, {email:email}, function(data) {
			//	//jqgrid_data = data;
			//	//$('#jsondata').val(data);
			//	var jqgrid_data = JSON.parse(data);		
								
						
						
				jQuery("#jqgrid").jqGrid({
				//data : jqgrid_data,					 
				url: "ajax/supplier_account/supplier_acct_detail_get.php?sup_Id=<?php echo $_GET['sup_Id'];?>",
				datatype: "json",
				mtype: "GET",
				height : 'auto',
				colNames : ['ID', 'Date of Transaction', 'Time of Transaction', 'Reference', 'Credit', 'Debit', 'Payment Type', 'Transaction Type', 'Remark', 'User Name'],
				colModel : [
				{					
					name : 'suppliertrans_id',
					index : 'suppliertrans_id',
					sortable : true,
					editable:false					
				}, {
					name : 'date',
					index : 'date',
					editable : false
				},
				{
					name : 'time',
					index : 'time',
					editable : false
				},
				{
					name : 'invoice_num',
					index : 'date',
					editable : false
				},
				{
					name : 'Delivery',
					index : 'credit',
					formatter:'currency',
					editable : false					
				},{				
					name : 'Payment',
					index : 'debit',
						formatter:'currency',
					editable : false					
				},
				{				
					name : 'payment_type',
					index : 'payment_type',
					editable : false					
				},
                {				
					name : 'transaction_type',
					index : 'transaction_type',
					editable : false					
				},
				{				
					name : 'remark',
					index : 'remark',
					editable : false					
				},
				{
					name : 'username',
					index : 'username',
					editable : false
				}
				
				],
				rowNum : 10,
				rowList : [10, 20, 30],
				pager : '#pjqgrid',
				sortname : 'suppliertrans_Id',
				toolbarfilter : true,
				viewrecords : true,
				sortorder : "desc",
				
				//beforeSelectRow: function (rowid, e) {
				//	var $td = $(e.target).closest("td"),
				//    iCol = $.jgrid.getCellIndex($td[0]);
				//	if (this.p.colModel[iCol].name === 'note') {
				//	    window.location = "/ajax/customer_account/customer_acct_detail.php/" + encodeURIComponent(rowid);
				//    return false;
				//	}
				//},
				gridComplete : function() {
					var ids = jQuery("#jqgrid").jqGrid('getDataIDs');					
						//alert(rolenames);
						
					for (var i = 0; i < ids.length; i++) {
						var cl = ids[i];
						
						vs= "<p class='btn btn-sm btn-primary'>View Account Statement</p>"
						mp= "<p class='btn btn-sm btn-success'>Make payment</p>"
						v = "<a class='btn btn-sm btn-primary' data-original-title='View Account Statement'  href= \" ajax/customer_account/customer_acct_detail.php?id=" + cl + "\" style= \" margin-right: 20px; \"><i class='fa fa-history'>View statement</i></a>";
						
						m = "<a class='btn btn-sm btn-success' data-original-title='Make Payment' href= \" ajax/customer_account/customer_payment.php?id=" + cl + "\"><i class='fa fa-credit-card'>Make Payment</i></button>";
						
						//be = "<button class='btn btn-xs btn-default' data-original-title='Edit Row' onclick=\"jQuery('#jqgrid').editRow('" + cl + "');\"><i class='fa fa-pencil'></i></button>";
						//se = "<button class='btn btn-xs btn-default' data-original-title='Save Row' onclick=\"jQuery('#jqgrid').saveRow('" + cl + "');\"><i class='fa fa-save'></i></button>";
						//ca = "<button class='btn btn-xs btn-default' data-original-title='Cancel' onclick=\"jQuery('#jqgrid').restoreRow('" + cl + "');\"><i class='fa fa-times'></i></button>";
						//ce = "<button class='btn btn-xs btn-default' onclick=\"jQuery('#jqgrid').restoreRow('"+cl+"');\"><i class='fa fa-times'></i></button>";
						//jQuery("#jqgrid").jqGrid('setRowData',ids[i],{act:be+se+ce});
						jQuery("#jqgrid").jqGrid('setRowData', ids[i], {
							act : vs,
							act2: mp
						});
					}
				},
				editurl : "ajax/customer_account/customer_acct_bal_set.php",
				caption : "Customer Transaction Details",
				multiselect : false,
				autowidth : true,

			});
			jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
				edit : false,
				add : false,
				del : false,
				search: true,
				view: false
			});
			//jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
			///* Add tooltips */
			//$('.navtable .ui-pg-button').tooltip({
			//	container : 'body'
			//});

			//jQuery("#m1").click(function() {
			//	var s;
			//	s = jQuery("#jqgrid").jqGrid('getGridParam', 'selarrrow');
			//	alert(s);
			//});
			//jQuery("#m1s").click(function() {
			//	jQuery("#jqgrid").jqGrid('setSelection', "13");
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


