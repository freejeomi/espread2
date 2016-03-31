<?php require_once("inc/init.php"); ?>
<!-- row -->

<?php
    include "../lib/util.php";
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$result = mysqli_query( $conn, "SELECT customer_id, customer_name FROM customer") or die("Couldn't execute query.".mysqli_error($conn));
		$datalist = "";
		while ($data = mysqli_fetch_assoc($result))
		{
			$default= "<option value='none'>--please select customer--</option>";
				$datalist= $datalist . "<option value='{$data['customer_id']}'>{$data['customer_name']}</option>";
		}
?>

<?php
    include "../lib/util.php";
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$result = mysqli_query( $conn, "SELECT store_id, store_name FROM store") or die("Couldn't execute query.".mysqli_error($conn));
		$dataliststore = "";
		while ($data = mysqli_fetch_assoc($result))
		{
			$defaultstore= "<option value='none'>--please select store--</option>";
				$dataliststore= $dataliststore . "<option value='{$data['store_id']}'>{$data['store_name']}</option>";
		}
?>

<?php
    include "../lib/util.php";
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$result = mysqli_query( $conn, "SELECT stock_id, stock_name FROM stock") or die("Couldn't execute query.".mysqli_error($conn));
		$dataliststock = "";
		while ($data = mysqli_fetch_assoc($result))
		{
			$defaultstock= "<option value='none'>--please select stock--</option>";
				$dataliststock= $dataliststock . "<option value='{$data['stock_id']}'>{$data['stock_name']}</option>";
		}
?>
<script>
	var newdate= new Date();
	var month= newdate.getMonth() + 1;
	var today= newdate.getDate() + "/" + month + "/" + newdate.getFullYear();
	document.getElementById("date").value= today;
</script>
<script>
//$(document).ready(function invoice_drop(){
//    $("#submitinvoice").click(function(){
//        $("#invoicedrop").show("3000");
//    });
//});
</script>
<script>
	$(document).ready(function clearInvoiceselection(){
		$("#cancelinvoice").click(function(){
			$('#customer').val('none').trigger('change');
			$('select[name= payment]').val('none').trigger('change');
			$('select[name= store]').val('none').trigger('change');
			});
		});
</script>
<!-- end row -->

<!--
	The ID "widget-grid" will start to initialize all widgets below 
	You do not need to use widgets if you dont want to. Simply remove 
	the <section></section> and you can use wells or panels instead 
	-->

<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- row -->
    	<div class="row" id="newinvoice-slide">

    		<!-- NEW WIDGET START -->
    		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    			<!-- Widget ID (each widget will need unique ID)-->
    			<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false">
    				<header>
    					<span class="widget-icon"> <i class=""></i> </span>
    					<h2>Open an invoice sheet  </h2>

    				</header>

    				<!-- widget div-->
    				<div>

    					<!-- widget edit box -->
    					<div class="jarviswidget-editbox">
    						<!-- This area used as dropdown edit box -->
    						<input class="form-control" type="text">
    					</div>
    					<!-- end widget edit box -->

    					<!-- widget content -->
    					<div class="widget-body">
                            <form id="new-invoice" method="POST">
                                <div class="row">

                                	<div class="form-group col-sm-4" >
                                		<label class="control-label col-md-3" for="prepend">Customer</label>
                                		<div class="col-md-9">
                                			<div class="icon-addon addon-sm" id="customer-group">
                                				<select class="form-control" name="customer" id="customer">
                                					<?php echo $default;?>
                                                    <?php echo $datalist;?>
                                				</select>
                                				<label class="glyphicon glyphicon-search" title="" rel="tooltip" for="email" data-original-title="email"></label>
                                			</div>
                                		</div>
                                	</div>
                                	<div class="form-group col-sm-4">
                                			<label class="control-label col-md-3" for="prepend">Payment Type</label>
                                			<div class="col-md-9" id="payment-group">
                                				<div class="icon-addon addon-sm" >
                                					<select class="form-control" name="payment" id="payment">
                                						<option value="none">--please select payment type--</option>
                                						<option value="CASH">Cash</option>
                                						<option value="CREDIT">Credit</option>
                                					</select>
                                					<label class="glyphicon glyphicon-search" title="" rel="tooltip" for="email" data-original-title="email"></label>
                                				</div>
                                			</div>
                                		</div>
                                	<div class="col-sm-4">
                                		<button class="btn btn-primary col-md-4" type="submit" id="submitinvoice">
                                			<i class="fa fa-save"></i>
                                			Open new invoice
                                		</button>
                                	</div>

                                </div>
                                <div class="row">
                                	<div class="form-group col-sm-4">
                                				<label class="control-label col-md-3" for="prepend">Store</label>
                                				<div class="col-md-9" id="store-group">
                                					<div class="icon-addon addon-sm">
                                						<select class="form-control" name="store" id="store">
                                                            <?php echo $defaultstore;?>

                                                            <?php echo $dataliststore;?>
                                						</select>
                                						<label class="glyphicon glyphicon-search" title="" rel="tooltip" for="email" data-original-title="email"></label>
                                					</div>
                                				</div>
                                			</div>
                                		<div class="col-sm-4">
                                			<label class="control-label col-md-3" for="prepend">Date</label>
                                			<div class="col-md-9">
                                				<input class="form-control" type="text" id="date" name="date" readonly>
                                				</div>
                                			</div>
                                	<div class="col-sm-4">
                                			<button class="btn btn-danger col-md-4" id="cancelinvoice" onclick="clearInvoiceSelection">
                                				<i class="fa fa times"></i>
                                				Cancel
                                			</button>
                                		</div>
                                </div>
                            </form>
					
    						<!-- this is what the user will see -->

    					</div>
    					<!-- end widget content -->

    				</div>
    				<!-- end widget div -->

    			</div>
    			<!-- end widget -->

    		</article>
    		<!-- WIDGET END -->

    	</div>


	<!-- row -->
	<div class="row" style="display: none;" id="invoicedrop">
		
		<article class="col-md-4 col-sm-12 col-lg-4 col-xs-12" style="background-color: white;">
            <form action="" id="review-form" class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label for="stock" class="col-sm-3 control-label">Stock</label>
						<div class="col-sm-9">
							<select type="" class="form-control" name= "stock" id="stock">
								<?php echo $defaultstock;?>
								<?php echo $dataliststock;?>
							</select>
	   				    </div>
					</div>									
					<div class="form-group">
						<label for="stock-count" class="col-sm-3 control-label">Stock Count</label>
					    <div class="col-sm-9" id="stock-count">
							<!--<input type="text" class="form-control" name= "stock-count" id="stock-count" disabled>-->
						</div>
					</div>
					<div class="form-group">
						<label for="slab" class="col-sm-3 control-label">Slab</label>
						<div class="col-sm-9" id="slab">
							<!--<input type="text" class="form-control" name= "slab" id="slab" disabled>-->
						</div>
					</div>
					<div class="form-group">
						<label for="lower-price" class="col-sm-3 control-label">Lower Price</label>
						<div class="col-sm-3" id="lower-price">
							<!--<input type="text" class="form-control" name= "lower-price" id="lower-price" disabled>-->
						</div>
						<label for="higher-price" class="col-sm-3 control-label">Higher Price</label>
						<div class="col-sm-3" id="higher-price">
							<!--<input type="text" class="form-control" name= "higher-price" id="higher-price" disabled>-->
			 		    </div>
					</div>
					<div class="form-group">
						<label for="quantity" class="col-sm-3 control-label">Quantity</label>
						<div class="col-sm-9">
							<input type="number" class="form-control" name= "quantity" id="quantity">
						</div>
					</div>
					<div class="form-group">
						<label for="agreed-price" class="col-sm-3 control-label">Agreed Price</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name= "agreed-price" id="agreed-price" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="total-price" class="col-sm-3 control-label">Total Price</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name= "total-price" id="total-price" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="discount" class="col-sm-3 control-label">Discount</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name= "discount" id="discount" disabled>
						</div>
					</div>								               
				</fieldset>
                <div class="box-footer">
					<button type="submit" class="btn btn-danger">Cancel</button>
					<button type="submit" class="btn btn-primary pull-right">Add item</button>
				</div>  
            </form>
        </article>

        <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="" id="resize-grid">
                <table id="jqgrid" ></table>
                <div id="pjqgrid"></div><br>

                <div id="post_result"></div>
                <input type="hidden" value="" id="jsondata">
            </div>
        </article>
	</div>
	
	<div class= "row">
			
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
    				url: "ajax/supplier_account/supplier_acct_bal_get.php",
    				datatype: "json",
    				mtype: "GET",
    				height : 'auto',
    				colNames : ['Stock', 'Unit Price', 'Quantity', 'Purchase Amount',  'Discount'],
    				colModel : [
    				{
    					name : 'stock',
    					index : 'stock',
    					sortable : true,
    					editable:false

    				}, {
    					name : 'unit_price',
    					index : 'unit_price',
    					editable : false
    				}, {
    					name : 'quantity',
    					index : 'quantity',
    					editable : false
    				},{
					
    					name : 'purchase_amount',
    					index : 'purchase_amount',
    					editable : false
    				},
					{					
    					name : 'discount',
    					index : 'discount',
    					editable : false
    				}
    				],
    				rowNum : 10,
    				rowList : [10, 20, 30],
    				pager : '#pjqgrid',
    				sortname : 'supplier_Id',
    				toolbarfilter : true,
    				viewrecords : true,
    				sortorder : "asc",

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

    						vs= "<p class='btn btn-sm btn-primary'>View Account Statement</p>";
    						mp= "<p class='btn btn-sm btn-success'>Make payment</p>";
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
    				//editurl : "ajax/customer_account/supplier_acct_bal_set.php",
    				caption : "Supplier Account Balance",
    				multiselect : true,
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
	$(document).ready(function() {
		$('#new-invoice').submit(function(event) {
			
			$('.form-group').removeClass('has-error'); // remove the error class
			$('.help-block').remove(); // remove the error text			
			// get the form data
			var formData = {
				'customer'		: $('select[name= customer]').val(),
				'payment' 		: $('select[name= payment]').val(),
				'store' 		: $('select[name= store]').val(),
				//'date'			: $('input[name= date]').val()				
			};
			// process the form
			$.ajax({
				type 		: 'POST', 
				url 		: 'ajax/invoice/new_invoice_select_post.php',
				data 		: formData, 
				dataType 	: 'json', 
				encode 		: true
			})
				// using the done promise callback
			.done(function(data) {
				if ( ! data.success) {
					if (data.errors.customer) {
						$('#customer-group').addClass('has-error'); // add the error class to show red input
						$('#customer-group').append('<div class="help-block">' + data.errors.customer + '</div>'); // add the actual error message under our input
					}
					if (data.errors.payment) {
						$('#payment-group').addClass('has-error'); // add the error class to show red input
						$('#payment-group').append('<div class="help-block">' + data.errors.payment + '</div>'); // add the actual error message under our input
					}
					if (data.errors.store) {
						$('#store-group').addClass('has-error'); // add the error class to show red input
						$('#store-group').append('<div class="help-block">' + data.errors.store + '</div>'); // add the actual error message under our input
					}					
				}
				else {					
							//alert ('success');
							//location.reload(true);
					//data.errors.customer;
					//data.errors.invoice_num;
					//data.errors.store;
					//data.errors.payment;
					$('input[name= amount]').val('');
					$('select[name= transaction]').val('none').trigger('change');
					$('input[name= ref]').val('');
					$('textarea[name= remark]').val('');
					//alert ('success');		
					$("#newinvoice-slide").hide('5000');
						$("#invoicedrop").show();
						
						//window.location = 'emconfirmation.php'; // redirect a user to another page				
				}
			})
			event.preventDefault();
		});
	});	
</script>


<script>

	function makeAjaxRequest(opts){
		var response;
       $.ajax({
         type: "POST",
        data: { opts: opts },
          url: "ajax/invoice/invoice_form_select_post.php",
         success: function(response) {
           
			alert (response);
			$('#slab').append(response.slab);
			$('#stock-count').append(response.count);
			$('#higher-price').append(response.higher_price);
			$('#lower-price').append(response.lower_price);
         }
        });
    }
	$("#stock").on("change", function(){
		var selected = $(this).val();
		makeAjaxRequest(selected);
	})
</script>
