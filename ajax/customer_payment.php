<?php
require_once("inc/init.php");
require_once("userlogcheck_admin.php");
$_SESSION['last_screen'] = "customer_payment.php";
 ?>
<!--
	The ID "widget-grid" will start to initialize all widgets below 
	You do not need to use widgets if you dont want to. Simply remove 
	the <section></section> and you can use wells or panels instead 
	-->
<?php
include "../lib/util.php";

if(isset($_SESSION['user_id'])){
	$user_id=$_SESSION['user_id'];
}

// Create connection
	if ($_GET['cus_Id']) {
		$cus_id = $_GET['cus_Id'];

//		$servername = "localhost";
//		$username = "root";
//		$password = "";
//		$dbname = "espread";

		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$result = mysqli_query( $conn, "SELECT * FROM customer WHERE customer_id= $cus_id") or die("Couldn't execute query.".mysqli_error($conn));
		while ($data = mysqli_fetch_assoc($result))
		{
			$cus_id= $data['customer_id'];
			$cus_name= $data ['customer_name'];
		}
	}
	else {
		$error= "sorry an error occured. please try again!";
	}
?>

<?php
//	$servername = "localhost";
//	$username = "root";
//	$password = "";
//	$dbname = "espread";
//	
//	$conn = mysqli_connect($servername, $username, $password, $dbname);
//	if (!$conn) {
//		die("Connection failed: " . mysqli_connect_error());
//	}
//	
//	$result = mysqli_query($conn, "SELECT customer_id, customer_name FROM customer");
//	$datalist = "";
//	while ($data = mysqli_fetch_assoc($result))
//	{
//		if ($_GET['cus_Id'] == $data['customer_id'])
//		{
//		$datalist=  $datalist . "<option value='{$data['customer_id']}' selected>{$data['customer_name']}</option>";	
//		}
//		else {
//			$datalist=  $datalist . "<option value='{$data['customer_id']}'>{$data['customer_name']}</option>";
//		}	    
//	}
?>
<script>	
	var newdate= new Date();
	var month= newdate.getMonth() + 1;
	var today= newdate.getDate() + "/" + month + "/" + newdate.getFullYear();
	document.getElementById("date").innerHTML= "Date: " + today;

	var cusname = "";
	var transtype = "";
	var amount = "0.00";

	document.getElementById("amountRemark").innerHTML = "Amount: ";
	document.getElementById("transRemark").innerHTML = "is... ";
	cusname = document.getElementById("cusname").value;
	document.getElementById("nameRemark").innerHTML = "Customer Name: <b>" + cusname + "</b>";

	$('#payment').on("change", function () {
		transtype = getSelectedText('payment');
		if (transtype == 'Select payment type') {
			document.getElementById("transRemark").innerHTML = " is...";
		}
		else {
			document.getElementById("transRemark").innerHTML = "is receiving <b>" + transtype + "</b> payment from ";
		}
	});
	function getSelectedText(elementId) {
		var elt = document.getElementById(elementId);

		if (elt.selectedIndex == -1)
			return null;

		return elt.options[elt.selectedIndex].text;
	}
	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	function myFunction() {
		amount = document.getElementById("amount").value;
		document.getElementById("amountRemark").innerHTML = "Amount: " + numberWithCommas(amount);
	}
</script>

<!-- widget grid -->
<section id="widget-grid" class="">
	
	<!-- START ROW -->
	<div class="row">

		<!-- NEW COL START -->
		<article class="col-sm-12 col-md-12 col-lg-12">
			
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
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Accept Customer Payment</h2>				
					
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

						<form action="" id="order-form" class="smart-form" novalidate="novalidate" autocomplete="off">
                            <fieldset>
                                <div id="message_div"></div>
                            </fieldset>

							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="input"> <i class="icon-append fa fa-user"></i><input type="text" disabled value="<?php echo $cus_name;?>" name="name" style="background-color: #F0F0F0;" id="cusname">
                                        	<!--<select id= "customer-select">
												<?php //echo $datalist;?>                                        		
                                        	</select>-->
										</label>
									</section>
									<section class="col col-6" id="payment-group">
										<label class="select">
											<select name="payment" id="payment">
												<option value="none">Select payment type</option>
                                        		<option value="CASH">Cash</option>
                                        		<option value="POS">POS</option>
                                                <option value="ONLINE">Online Transaction</option>
											</select> <i></i> </label>
									</section>
								</div>

								<div class="row">
									<section class="col col-6" id="amount-group">
										<label class="input">
											<input type="text" placeholder="Amount"  name="amount" id="amount" onkeyup="myFunction()" onblur="myFunction()">
										</label>
									</section>
									<section class="col col-6">
										<label class="input">
											<input type="text" class="" name="remark" id="remark" placeholder="Remark(optional)">
										</label>
									</section>
								</div>
								<input type="hidden" value="<?php echo $cus_id;?>" name= "cus_Id">
							</fieldset>
							<footer>
								<section class="col-md-3">
										<label class="checkbox">
											<input type="checkbox" checked="checked" name="checkbox-inline" value="off" id="cash-check">
											<i></i>
											Credit my cash stock
										</label>
									</section>
								<button type="submit" class="btn btn-primary">
									Update
								</button>
							</footer>
						</form>
						</article>
						
						<article class="col-sm-12 col-md-4 col-lg-4" style="margin-top: 20px;">
							<section class="col col-6">
								<div class="alert alert fade in" style="background-color: #F0F0F0;" id="remarks">
									<i class="fa-fw fa fa-info"></i>
									<strong>Payment Info</strong><br>
									<span id=""><b><?php if(isset($_SESSION['username'])){echo $_SESSION['username'];}?></b>
									<span id="transRemark"> </span> </span><br>
									<span id="nameRemark">Customer name:</span><br>
									<span id="date"> </span><br>
									<span id="amountRemark"></span><br>
									<span id="cashtype" ></span><br>								
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
		</article>
		<!-- WIDGET END -->
		
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
			
			//$("#customer-select").on("change", function(){
			//	var url= "ajax/customer_account/customer_payment_get.php";
			//	var selected = $(this).val();
			//	var jqgrid_data;			
			//	$.post(url, {selected:selected}, function(data) {
			//		jqgrid_data = data;
			//		$('#jsondata').val(data);
			//		var jqgrid_data = JSON.parse(data);
			//		alert ($('#jsondata').val());
			//		//alert (jqgrid_data);		
			//		//alert (jqgrid_data);
			//	});
			//});
			
												
				jQuery("#jqgrid").jqGrid({
				//data : jqgrid_data,					 
				url: "ajax/customer_account/customer_payment_get.php?cus_Id=<?php echo $_GET['cus_Id'];?>",
				datatype: "json",
				mtype: "GET",
				height : 'auto',
				colNames : ['Transaction ID','Date of Transaction', 'Time', 'Reference', 'Credit', 'Debit', 'Payment Type', 'Remark', 'Transaction Type', 'User Name'],
				colModel : [
				{					
					name : 'transaction_id',
					index : 'transaction_id',
					sortable : true,
					editable:false					
				},
				
				{
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
					name : 'credit',
					index : 'credit',
					formatter:'currency',
					editable : false
				},
				{
					name : 'debit',
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
					name : 'remark',
					index : 'remark',
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
				},
				//{
				//	name : 'customer_id',
				//	index : 'customer_id',
				//	editable : false
				//}
				],
				rowNum : 10,
				rowList : [10, 20, 30],
				pager : '#pjqgrid',
				sortname : 'transaction_Id',
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
						
						jQuery("#jqgrid").jqGrid('setRowData', ids[i], {
							act : vs,
							act2: mp
						});
					}
				},
				//editurl : "ajax/customer_account/customer_acct_bal_set.php",
				caption : "Customer Account Balance",
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
			
			//alert ($('#jsondata').val());
			//alert (jqgrid_data);			

		}// end function

	}
	loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);	
</script>

<!--<script>-->
<!--	-->
<!--	function makeAjaxRequest(opts){-->
<!--		var jqgrid_data;-->
<!--        $.ajax({-->
<!--          type: "POST",-->
<!--          data: { opts: opts },-->
<!--          url: "process_ajax.php",-->
<!--          success: function(data) {-->
<!--            jqgrid_data = data;-->
<!--			$('#jsondata').val(data);-->
<!--			var jqgrid_data = JSON.parse(data);-->
<!--          }-->
<!--        });-->
<!--      }-->
<!--	-->
<!--	$("#customer-select").on("change", function(){-->
<!--		var selected = $(this).val();-->
<!--		makeAjaxRequest(selected);-->
<!--		-->
<!--	})-->
<!--</script>-->
<script>
	$(document).ready(function() {
		var user_id ="<?php if(isset($user_id)){echo $user_id;} ?>";
		$('form').submit(function(event) {
			
			$('.form-group').removeClass('has-error'); // remove the error class
			$('.help-block').remove(); // remove the error text
			$('#message_div').empty();
			var cash_check= "";
			if(document.getElementById("cash-check").checked) {
				cash_check= "on";
			}
			else {
				cash_check= "off";
			}
			
			// get the form data
			var formData = {
				'name' 			: $('input[name= name]').val(),
				'amount' 		: $('input[name= amount]').val(),
				'payment' 		: $('select[name= payment]').val(),
				'cus_Id'		: $('input[name= cus_Id]').val(),
				'remark'		: $('#remark').val(),
				'credit_cash'	: cash_check,
				'user_id':user_id
			};
			// process the form
			$.ajax({
				type 		: 'POST', 
				url 		: 'ajax/customer_account/customer_payment_set.php',
				data 		: formData, 
				dataType 	: 'json', 
				encode 		: true
			})
				// using the done promise callback
			.done(function(data) {
				if ( ! data.success) {					
					if (data.errors.amount) {
						$('#amount-group').addClass('has-error'); // add the error class to show red input
						$('#amount-group').append('<div class="help-block">' + data.errors.amount + '</div>'); // add the actual error message under our input
					}
					if (data.errors.payment) {
						$('#payment-group').addClass('has-error'); // add the error class to show red input
						$('#payment-group').append('<div class="help-block">' + data.errors.payment + '</div>'); // add the actual error message under our input
					}
					if (data.errors.userid) {
						$('#message-group').addClass('has-error'); // add the error class to show red input
						$('#message-group').append('<div class="help-block">' + data.errors.userid + '</div>'); // add the actual
					}
					if (data.message) {
                        $('#message-group').addClass('has-error'); // add the error class to show red input
					    $('#message-group').append('<div class="help-block">' + data.message + '</div>'); // add the actual 
                    }
				}
				else {
					if (data.locked) {
						$('#message_div').append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i>' + data.locked + '</div>');
					}
					else {
						$('#message_div').append('<div class="alert alert-success" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Payment Successful!!!</div>');
						//alert ("success");
						//location.reload(true);
						jQuery('#jqgrid').jqGrid('setGridParam', {url: "ajax/customer_account/customer_payment_get.php?cus_Id=<?php echo $_GET['cus_Id'];?>"}).trigger("reloadGrid");
						$('#amount').val('');
						$('#select_type').val('none').trigger('change');
						$('textarea').val('');
						//window.location = 'emconfirmation.php'; // redirect a user to another page

					}
				}
			});
			// using the fail promise callback
			//.fail(function(data) {
			//	// show any errors
			//	// best to remove for production
			//	console.log(data);
			//});
			// stop the form from submitting the normal way and refreshing the page
			event.preventDefault();
		});
	});	
</script>
