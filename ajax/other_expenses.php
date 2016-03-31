<?php
require_once("../lib/config.php");
require_once("inc/init.php");
require_once("userlogcheck_admin.php");
$_SESSION['last_screen'] = "other_expenses.php";
//require_once("../lib/config.php");
$paymentErr = $beneficiaryErr = "";

if(isset($_GET['paymentErr']) || isset($_GET['beneficiaryErr'])){
  $paymentErr = $_GET['paymentErr'];
  $beneficiaryErr = $_GET['beneficiaryErr'];
}


?>


  
  <script>
//	function noteRemarks() {
//	  var todayDate = new Date();
//	 var month= todayDate.getMonth()+1;
//	   todayDate= todayDate.getDate() + "-" + month + "-" + todayDate.getFullYear();
//    var payment = document.getElementById("payment"),
//	    beneficiary =document.getElementById("beneficiary");
//		var remarks = document.getElementById("remarks");
//	  
//			remarks.value =  payment.value + " " + " paid  for" + " " + beneficiary.value.toLowerCase() + " " + "on" + " "  + todayDate ;
//	 //document.getElementById("demo").innerHTML=remarks.value; 
//		
//	
//    }
  </script>

<body>
<!--
	The ID "widget-grid" will start to initialize all widgets below 
	You do not need to use widgets if you dont want to. Simply remove 
	the <section></section> and you can use wells or panels instead 
	-->
<section id="widget-grid" class="">
	<?php
	$message = "";
	if (isset($_GET['message'])) {
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
	$failure = '<div class="row">
					<div class="alert alert-danger fade in" style="margin-left: 13px; margin-right: 13px;">
						<buttton class="close" data-dismiss="alert">
							<i class="fa-fw fa fa-times"></i>
						</buttton>
						<i class="fa-fw fa fa-times"></i>
						<strong>Failed</strong> Error in accomplishing task. Ensure all required fields are filled
					</div>
				</div>';
	$account_low= '<div class="row">
					<div class="alert alert-danger fade in" style="margin-left: 13px; margin-right: 13px;">
						<buttton class="close" data-dismiss="alert">
							<i class="fa-fw fa fa-times"></i>
						</buttton>
						<i class="fa-fw fa fa-times"></i>
						<strong>Failed</strong> Sorry, you do not have enough in your account to perform this transaction
					</div>
				</div>';
	$locked= '<div class="row">
					<div class="alert alert-danger fade in" style="margin-left: 13px; margin-right: 13px;">
						<buttton class="close" data-dismiss="alert">
							<i class="fa-fw fa fa-times"></i>
						</buttton>
						<i class="fa-fw fa fa-times"></i>
						<strong>Failed</strong> Sorry, you are unable to carry out transaction until the next business day
					</div>
				</div>';
	if ($message == 'failure') {
		echo $failure;
	}

	if ($message == 'success') {
		echo $success;
	}
	if ($message == 'account low') {
		echo $account_low;
	}
	if ($message == 'locked') {
		echo $locked;
	}
	?>
	<!-- row -->
	<div class="row">
		
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		  
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget " id="wid-id-0" data-widget-custombutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false">
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
				<header >
				<h2>Other Expenses</h2>		
					
				</header>
				<!-- widget div-->
				<div>
					<!-- widget content -->
					<div class="widget-body">
					<form class="" role="form" action="<?php echo APP_URL; ?>/ajax/other_expenses_post.php" method="post" autocomplete="off">
			<div class="row">

			  <div class="col-xs-9 col-sm-5 col-md-5 col-lg-5 form-group">
				  <div class="input-group">
					  <div class="input-group-btn">
						  <button type="submit" class="btn btn-default" disabled="disabled" style="font-weight: bold;">Amount</button>
					  </div>
					  <!-- /btn-group -->
					  <input type="text" class="form-control" name="payment" id="payment" placeholder="Enter amount"><br>
				  </div>
				  <span class="text-danger" style="margin-left: 70px;">
				  <?php echo $paymentErr ?>
				  </span></br>
				  <div class="input-group">
					  <div class="input-group-btn">
						  <button type="submit" class="btn btn-default" disabled="disabled" style="font-weight: bold;">Beneficiary
						  </button>
					  </div>
					  <!-- /btn-group -->
					  <input type="text" class="form-control text-danger" name="beneficiary" id="beneficiary" placeholder="Enter beneficiary"><br>
				  </div>
				  <span class="text-danger" style="margin-left: 90px;"><?php echo $beneficiaryErr ?></span></br>
			  </div>
				<div class="col-xs-3 col-sm-7 col-md-7 col-lg-7 text-right">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-7 text-left">
							<textarea type="text" class="form-control" name="remarks" id="remarks" placeholder="Remark(Optional)" rows="3"></textarea>
						</div>
						<div class="col-md-4">
							<div class="input-group">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-primary "><i class="fa fa-save"></i> <span class="hidden-mobile">Make Payment</span>
									</button>
								</div>
							</div>
							<br/>

							<div class="input-group">
								<div class="input-group-btn">
									<button class="btn btn-danger" type="button" id="clear_"">
										<i class="fa fa-refresh"></i> <span class="hidden-mobile">Reset Fields &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
    	</div>
  
    <!-- this is what the user will see -->
             
					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				</form>

			<!-- end widget -->

		</article>
		<!-- WIDGET END -->
		
	</div>

	<!-- end row -->

	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<table id="jqgrid"></table>
			<div id="pjqgrid"></div>

		</article>
	</div>

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
	//
	pageSetUp();
	//
	///*
	// * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
	// * eg alert("my home function");
	// * 
	// * var pagefunction = function() {
	// *   ...
	// * }
	// * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
	// * 
	// * TO LOAD A SCRIPT:
	// * var pagefunction = function (){ 
	// *  loadScript(".../plugin.js", run_after_loaded);	
	// * }
	// * 
	// * OR you can load chain scripts by doing
	// * 
	// * loadScript(".../plugin.js", function(){
	// * 	 loadScript("../plugin.js", function(){
	// * 	   ...
	// *   })
	// * });
	// */
	//
	// pagefunction
	
	
var customer = document.getElementById("payment");
customer.addEventListener('blur', function(evt) {
	//customer.value = 0;
	if (isNaN(customer.value)) {
		customer.value = 0;
	}
	else {
		var n = parseInt(this.value.replace(/\D/g, ''), 10);
		customer.value = n.toLocaleString();
	}
}, false);
			 

				  
  
	
	var pagefunction = function() {
		loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);

		$('#clear_').click(function () {
			$('#payment').val('');
			$('#beneficiary').val('');
			$('#remarks').val('');
		});

		function run_jqgrid_function() {
			

						
				jQuery("#jqgrid").jqGrid({
				//data : jqgrid_data,					 
				url: "ajax/cash_stock/other_expenses_get.php",
				datatype: "json",
				mtype: "GET",
				height : 'auto',
				colNames : ['Cashstock Id', 'Beneficiary', 'Amount', 'Date','Remarks', 'Time', 'Transaction Type', 'User name' ],
				colModel : [
				{					
					name : 'cashstock_id',
					index : 'cashstock_id',
					sortable : true,
					editable:false
				}, {
					name : 'particulars',
					index : 'particulars',
					editable : false
				}, {
					name : 'amount',
					index : 'amount',
						formatter:'currency',
					editable : false
				},
				{					
					name : 'date',
					index : 'date',
					sortable : true,
					editable:false
				}, {
					name : 'remarks',
					index : 'remarks',
					editable : false
				}, {
					name : 'time',
					index : 'time',
					editable : false
				},
				{
					name : 'transaction_type',
					index : 'transaction_type',
					editable : false
				},
				{
					name : 'username',
					index : 'username',
					editable : false
				}
				
				],
				rowNum : 20,
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
				//editurl :"ajax/customer_account/customer_acct_bal_set.php",
				caption : 'Other Expenses',
				multiselect : false,
				autowidth : true,
	
			});
			jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
				edit : false,
				add : false,
				del : false,
				search: true,
				reloadGridOptions: { fromServer: true }
			});
			/*jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
			 Add tooltips 
			$('.navtable .ui-pg-button').tooltip({
				container : 'body'
			});*/
	
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
				
				//$('#post_result').html(jqgrid_data);
				//});
			//alert ($('#jsondata').val());
			//alert (jqgrid_data);			
	
		}// end function
	
	}
	loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);
	
</script>