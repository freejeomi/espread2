<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_operator.php");
$_SESSION['last_screen'] = "new_invoice.php";

if (isset($_SESSION['invoice_num_retrieved'])) {
	$session_invoice = $_SESSION['invoice_num_retrieved'];
}
else {
	$session_invoice = "";
}
if(isset($_SESSION['user_id'])){
	$user_id=$_SESSION['user_id'];
}


$customer= "";
$invoice_num= "";
$payment="";
//$store= "";
$status= "";
$store= "";

// php/javascript code when coming from the sales ledger
if (isset($_SESSION['invoice_num_retrieved']) && isset($_GET['src'])) {
	if ($_GET['src'] == "ledger") {
		$invoice_number = $_SESSION['invoice_num_retrieved'];
		?>
		<script>
			$("#newinvoice-slide").hide(200);
			$("#invoicedrop").show();
		</script>
		<?php
		//script for retrieving invoice number parameter when coming in from daily sales ledger
		include "../lib/util.php";

		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		} else {
			//retrieve total amount for that invoice
			$result_invoicesum = mysqli_query($conn, "SELECT sum(charge) as total_amount FROM invoiceitems_daily WHERE invoice_num='$invoice_number'");
			$returnedsum = mysqli_num_rows($result_invoicesum);
			if ($returnedsum > 0) {
				while ($row_invoicesum = mysqli_fetch_assoc($result_invoicesum)) {
					$totalamt = $row_invoicesum['total_amount'];
				}
			}
			//retrieve invoice details to display above the invoice form
			$sql = "SELECT invoice_num, customer.customer_name, store.store_name, payment_type, status FROM salesinvoice_daily INNER JOIN customer on customer.customer_id= salesinvoice_daily.customer_id INNER JOIN store on store.store_id= salesinvoice_daily.store where invoice_num= $invoice_number";
			$result = mysqli_query($conn, $sql);
			if (!$result) {
				$data['message'] = "Oops. something went wrong while retrieving from database. please try again";
			}
			else {
				//store the retrieved records into variables
				while ($row = mysqli_fetch_assoc($result)) {
					$customer = $row['customer_name'];
					$invoice_num = $row['invoice_num'];
					$store = $row['store_name'];
					$payment = $row['payment_type'];
					$status = $row['status'];
				}
				if ($status == "CLOSED") {
					//ststus is closed, hide some elements
					$status_what='0';

					?>
					<script>
						$('#invoice-form').hide();
						$('#status_select').show();
						$('#button_complete').hide();
						$('#cash_checkbox').hide();
						$('#pjqgrid').hide();

						//$('.delete_button').prop('disabled',true);
					</script>

					<?php
				} else {
					//status is OPENED, show some elements
					?>
					<script>

						$('#invoice-form').show();
						$('#status_select').hide();
						$('#button_complete').show();
						$('#cash_checkbox').show();
						$('#pjqgrid').show();
						$('#invoice-complete').prop('disabled', false);

					</script>
					<?php
					$status_what="1";
				}
			}
		}
	}
}

//script for retrieving customer drop down select options
include "../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
$result_2 = mysqli_query($conn, "SELECT customer_id, customer_name FROM customer WHERE customer_name = 'GENERAL'") or die("Couldn't execute query." . mysqli_error($conn));
if (mysqli_num_rows($result_2) > 0) {
	while($row= mysqli_fetch_assoc($result_2)) {
	$customer_general= $row['customer_name'];
	$customer_genral_id= $row['customer_id'];
	}
}
$result = mysqli_query( $conn, "SELECT customer_id, customer_name FROM customer") or die("Couldn't execute query.".mysqli_error($conn));
$datalist = "";

while ($data = mysqli_fetch_assoc($result))
{
	$customer_id= $data['customer_id'];
	$customer_name= $data['customer_name'];
	if ($customer_name == $customer_general) {
		$datalist .=  "<option selected='selected' value='$customer_id' >$customer_name</option>";
	}
	else {
		$datalist .=  "<option value='$customer_id'>$customer_name</option>";
	}

}

//script to retrieve store drop down select
$defaultstore = "";
$store_set= "";
$dataliststore = "<select name='store' class='form-control' id='store'><option value='none'>select store</option>";
//if the logged in user is admin, enter here
if (strtolower($_SESSION['role_name']) != "admin") {
	$result = mysqli_query($conn, "SELECT retail_store as store_id, store.store_name FROM settings INNER JOIN store on store.store_id= settings.retail_store") or die("Couldn't execute query." . mysqli_error($conn));
	while ($data = mysqli_fetch_assoc($result)) {
		$store_set= $data['store_id'];
		$defaultstore = "<input type = 'hidden' class='form-control' name = 'store' id = 'store'  value='$store_set'>";
		$dataliststore = $defaultstore . "<input type= 'text' class='form-control' name= 'storename' id= 'storename' readonly value='{$data['store_name']}'>";
	}

}
else {
	//if logged in user is not admin
	$result = mysqli_query($conn, "SELECT retail_store as store_id FROM settings") or die("Couldn't execute query." . mysqli_error($conn));
	while ($data = mysqli_fetch_assoc($result)) {
		$store_set = $data['store_id'];
	}
	$result = mysqli_query($conn, "SELECT store_id, store_name FROM store WHERE retailoutlet= 1") or die("Couldn't execute query." . mysqli_error($conn));

	while ($data = mysqli_fetch_assoc($result)) {
		$store_id= $data['store_id'];
		$store_name= $data['store_name'];
		if ($store_set == $store_id) {
			$dataliststore .= "<option selected='selected' value='$store_id'>$store_name</option>";
		} else {
			$dataliststore .= "<option value='$store_id'>$store_name</option>";
		}
	}

	$dataliststore .= "</select>";
}
?>

<script>
//script for date in initial invoice select form
	var newdate= new Date();
	var month= newdate.getMonth() + 1;
	var today= newdate.getDate() + "/" + month + "/" + newdate.getFullYear();
	document.getElementById("date").value= today;
</script>

<script>
//script to clear initial selection for invoice
	$(document).ready(function clearInvoiceselection(){
		$("#cancelinvoice").click(function(){
			$('#customer-group').removeClass('has-error');
			$('#payment-group').removeClass('has-error');
			$('#store-group').removeClass('has-error');
			$('.help-block').remove(); // remove the error text
			$('#customer').val('none').trigger('change');
			$('select[name= payment]').val('none').trigger('change');
			$('select[name= store]').val('none').trigger('change');
		});
	});
</script>

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
    					<div  class="" style="margin-left: 905px;">

						</div>

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
													<option value='none'>--please select customer--</option>
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
													<?php
													if (strtolower($_SESSION['role_name']) == "admin") {
													?>
                                					<select class="form-control" name="payment" id="payment">
<!--                                						<option value="none">--please select payment type--</option>-->
                                						<option value="CASH" selected>Cash</option>

                                						<option value="CREDIT">Credit</option>

                                					</select>
													<?php } else { ?>
													<input class="form-control" name="payment" id="payment" value="CASH" readonly>
													<?php } ?>
                                					<label class="glyphicon glyphicon-search" title="" rel="tooltip" for="email" data-original-title="email"></label>
                                				</div>
                                			</div>
                                		</div>
                                	<div class="col-sm-4">
                                		<button class="btn btn-primary col-md-4" type="submit" id="submitinvoice">
                                			<i class="fa fa-save"></i>
                                			Open new invoice
                                		</button>
                                		<div class="col-md-2"></div>
<!--										<a class="btn btn-success col-md-4" href="invoice.php" target="_blank" id="print_invoice_new"-->
<!--										   style="display: none;">-->
<!--											<i class="fa fa-print"></i>-->
<!--											Print last Invoice-->
<!--										</a>-->
                                	</div>

                                </div>
                                <div class="row">
                                	<div class="form-group col-sm-4">
                                				<label class="control-label col-md-3" for="prepend">Store</label>
                                				<div class="col-md-9" id="store-group">
                                					<div class="icon-addon addon-sm">
                                						<?php echo $dataliststore;?>
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
                                			<button class="btn btn-danger col-md-4" id="cancelinvoice" onclick="clearInvoiceSelection" type="button">
                                				<i class="fa fa-times"></i>
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
	<div class="col-sm-12"></div>
		<div class="row " style="background-color: lightgrey; " >
			<section class="col-md-7">
				<span class="col-sm-3">
					Invoice Number:  <b id="invoice-display"><?php if (isset($invoice_number)) { echo $invoice_num;} ?></b>
				</span>
				<span class="col-sm-4">
					Customer:  <b id="customer-display"><?php if (isset($invoice_number)) { echo $customer; }?></b>
				</span>
				<span class="col-sm-2">
					Store:  <b id="store-display"><?php if (isset($invoice_number)) { echo $store;} ?></b>
				</span>
				<span class="col-sm-3">
					Payment Type:  <b id="payment-display"><?php if (isset($invoice_number)) { echo $payment;} ?></b>
				</span>
			</section>
<!--			<section class="col-md-1"></section>-->
			<section class="col-md-5">
				<span class="col-sm-4">
					Total Price:  <b id="price-display"><?php if (isset($invoice_number)) {
							echo $totalamt;
						} else {
							echo '0.00';
						} ?></b>
				</span>
				<span class="col-sm-4">
					Total charges:  <b id="charges-display"><?php if (isset($invoice_number)){echo $totalamt;} else {echo '0.00';} ?></b>
				</span>
				<span class="col-sm-4">
					Discount:  <b id="discount-display">0.00</b>
				</span>
			</section>
		</div>
		<div class="row" id="" >
			<div class="col-sm-6 col-sm-offset-3" id="errorappendrow" style="display: none"></div>
		</div>
		<br>
		<article class="col-md-4 col-sm-12 col-lg-4 col-xs-12" style="background-color: white;" id="form-section">
<!--			<select type="" class="form-control" name="status_select" id="status_select" style="display: none;">-->
<!--				<option value="CLOSED">CLOSED</option>-->
<!--				<option value="OPEN">OPEN</option>-->
<!--			</select>-->
<input type="text" value="INVOICE IS CLOSED" readonly class="form-control" style="display: none; background-color: white; border: none;" id="status_select">
            <form action="" id="invoice-form" class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label for="stock" class="col-sm-3 control-label">Stock</label>
						<div class="col-sm-9" id="stock-group">
							<select type="" class="form-control" name= "stock" id="stock">

							</select>
	   				    </div>
					</div>
					<div class="form-group">
						<label for="stock-count" class="col-sm-3 control-label">Stock Count</label>

						<div class="col-sm-3" id="">
							<input type="text" class="form-control" name="stock-count" id="stock-count" disabled>
						</div>
						<label for="sku" class="col-sm-3 control-label">SKU:</label>

						<div class="col-sm-3" id="">
							<input type="text" class="form-control" name="sku" id="sku" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="slab" class="col-sm-3 control-label">Slab</label>
						<div class="col-sm-9" id="">
							<input type="text" class="form-control" name= "slab" id="slab" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="lower-price" class="col-sm-3 control-label">High Volume Purchase:</label>
						<div class="col-sm-3" id="">
							<input type="text" class="form-control" name= "lower-price" id="lower-price" disabled>
						</div>
						<label for="higher-price" class="col-sm-3 control-label">Low Volume Purchase:</label>
						<div class="col-sm-3" id="">
							<input type="text" class="form-control" name= "higher-price" id="higher-price" disabled>
			 		    </div>
					</div>
					<div class="form-group" id="quantity-group">
						<label for="quantity" class="col-sm-3 control-label">Quantity:</label>
						<div class="col-sm-9" id="quantity-error">
							<input type="number" class="form-control" name= "quantity" id="quantity" >
						</div>
					</div>
					<div class="form-group">
						<label for="agreed-price" class="col-sm-3 control-label">Agreed Price:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name= "agreed-price" id="agreed-price" readonly value="0.00">
						</div>
					</div>
					<div class="form-group">
						<label for="total-price" class="col-sm-3 control-label">Total Price:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name= "total-price" id="total-price" disabled value="0.00">
						</div>
					</div>
					<div class="form-group">
						<label for="discount" class="col-sm-3 control-label">Discount:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name= "discount" id="discount" disabled value="0.00">
						</div>
					</div>
					<input type="hidden" name="check" id="check" value="0">
				</fieldset>
                <div class="box-footer">
<!--					cancel invoice-->
					<button class="btn btn-danger col-md-2" id="" data-toggle="modal" data-target="#cancelModal" type="button">Cancel</button>
					<div class="col-md-2"></div>
<!--					<a class="btn btn-success col-md-4" href="invoice.php" target="_blank" id="print_invoice_form" style="display: none;">-->
<!--						<i class="fa fa-print"></i>-->
<!--						Print last Invoice-->
<!--					</a>-->
					<div class="col-md-2"></div>
<!--					modal for cancelling invoice-->
					<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<form>
													 <div class="modal-header">
													<!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
													<!--<h4 class="modal-title">Modal Header</h4>-->
												  </div>
												  <div class="modal-body">
													<p class= "alert alert-danger">Are you sure you want to cancel this invoice?</p>
												  </div>
												  <div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
													<button type="button" class="btn btn-primary" id="cancel_invoice">Yes</button>
												  </div>
												  </form>
												</div>
											</div>
										</div>
					<button type="submit" class="btn btn-primary col-md-2 pull-right" id="item-submit">Add item</button>
				</div>  
            </form>
        </article>

        <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="" id="resize-grid">
                <table id="jqgrid" ></table>
                <div id="pjqgrid"></div><br>
            </div><br>

			<div class="row">
				
					<section class="col-md-6"></section>
					<section class="col-md-3" id="cash_checkbox" style="display: none;">
						<label class="checkbox" id="checkbox_label">
							<input type="checkbox" checked="checked" name="cash-stock" value="off" id="cash-stock">
							Credit my cash stock
						</label>

					</section>
					<section class="col-md-3" id="button_complete" style="display: none;">
						<button class= "btn btn-primary btn-lg pull-right" disabled data-toggle="modal" data-target="#remoteModal" id="invoice-complete" > Invoice Completed</button>
					</section>
						<!-- Dynamic Modal -->  
					<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">  
						<div class="modal-dialog">  
							<div class="modal-content">
								<form>
								 <div class="modal-header">
								<!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
								<!--<h4 class="modal-title">Modal Header</h4>-->
							  </div>
							  <div class="modal-body">
								<p class= "alert alert-danger">Are you sure you want to close this invoice?</p>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
								<button type="button" class="btn btn-primary" id="invoice-close">Yes</button>
							  </div>
							  </form>
							</div>  
						</div>  
					</div>  
						<!-- /.modal -->

<!--				<button class='btn btn-sm btn-primary' data-toggle='tooltip' title='Delete' data-original-title='Delete' id='delet_button' type='button' onclick='deleteItem()'>-->
<!--					<i class='fa fa-trash-o'></i>-->
<!--				</button>-->

			</div>
			
        </article>
	</div>
	
	<div class= "row">
			
	</div>
	<!-- end row -->
	
</section>
<!-- end widget grid -->


<script type="text/javascript">
	$(document).ready(function() {

		<?php if (!($_SESSION['role_name'] == "admin" || $_SESSION['role_name'] == "superadmin")) {?>
		$('#checkbox_label').hide();
		<?php } ?>

		var invoice_num_print= "<?php if (isset($_SESSION['invoice_num_retrieved']) ){echo $session_invoice;} else {echo "none";} ?>";
		//variable used to fetch stock list based on store
		var store_name_now = "<?php if (isset($session_invoice) ){echo $store;} ?>";
		var user_id ="<?php if(isset($user_id)){echo $user_id;} ?>";
		//alert (invoice_num_print);
		$('#quantity').prop('disabled', true);		//disable quantity input on page load
		$('#item-submit').prop('disabled', true);	//disable add item button on page load


		//retrieve list of stock based on the store selected
		$.ajax({
			type: 'POST',
			url: 'ajax/invoice/invoice_form_select_post.php',
			data: {store_name_stock: store_name_now},
			dataType: 'json',
			encode: true,
			success: function (response) {
				//alert (response);
				$('#stock').empty().append('<option value="none" id="default_stock" selected>Please select stock</option>' + response.stock_list);
			}
		});

		//script to handle quantity enable when stock is selected
		$("#stock").on("change", function(){
			var stock= document.getElementById("stock").value;
			if (stock != "none") {
				$('#quantity').prop('disabled', false);
			}		
		});



		//script to handle initial invoice selection form post
		$('#new-invoice').submit(function (event) {

			$('#customer-group').removeClass('has-error');
			$('#payment-group').removeClass('has-error');
			$('#store-group').removeClass('has-error');
			$('.help-block').remove(); // remove the error text
			// get the form data
			var formData = {
				'customer': $('#customer').val(),
				'payment': $('#payment').val(),
				'store': $('#store').val(),
				'user_id':user_id
				//'date'			: $('input[name= date]').val()
			};
			// process the form
			$.ajax({
				type: 'POST',
				url: 'ajax/invoice/new_invoice_select_post.php',
				data: formData,
				dataType: 'json',
				encode: true
			})
				.done(function (data) {
					if (!data.success) {
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
						if (data.errors.user_id) {
							$('#store-group').addClass('has-error'); // add the error class to show red input
							$('#store-group').append('<div class="help-block">' + data.errors.user_id + '</div>'); // add the actual error message under our input
						}
					}
					else {
						if (data.locked) {
                            $('#new-invoice').append('<div class="help-block alert alert-danger" style="text-align: center;"><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton>' + data.locked + '</div>')
                        }
                        else {
                            $('input[name= amount]').val('');
                            $('select[name= transaction]').val('none').trigger('change');
                            $('input[name= ref]').val('');
                            $('textarea[name= remark]').val('');
                            //alert ('success');
                            $("#newinvoice-slide").hide('5000');
                            $("#invoicedrop").show();
                            $('#invoice-display').text(data.invoice_num);
                            $('#customer-display').text(data.customer);
                            $('#store-display').text(data.store);
//					store_name_now= data.store;
//					alert (store_name_now);
                            $('#payment-display').text(data.payment);

                            //retrieve list of stock based on the store selected
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/invoice/invoice_form_select_post.php',
                                data: {store_name_stock: data.store},
                                dataType: 'json',
                                encode: true,
                                success: function (response) {
//alert (response);
                                    $('#stock').empty().append('<option value="none" id="default_stock" selected>Please select stock</option>' + response.stock_list);
                                }
                            });
                        }
					}
				});
			event.preventDefault();
		});

//$("#quantity").on("focus", function () {
//var defult= 0.00;
//	$('#total-price').val(defult);
//});
		//code handling the calculation processing on the invoice item form
		$("#quantity").bind("click keyup", function(){
			$('#quantity-error').removeClass('has-error'); // remove the error class
			$('.help-block').remove();
			$('#item-submit').prop('disabled', false);

		   	var stock_count= parseInt((document.getElementById("stock-count").value).replace(/,/g, ''));
		   	var slab= parseInt((document.getElementById("slab").value).replace(/,/g, ''));
		   	var low_price= parseFloat((document.getElementById("lower-price").value).replace(/,/g, ''));
		   	var high_price= parseFloat((document.getElementById("higher-price").value).replace(/,/g, ''));

			var quantity= parseInt((document.getElementById("quantity").value).replace(/,/g, ''));

		   	var agreed_price;
		   	var _total=document.getElementById("total-price");
		   
		   	if (isNaN(quantity) ) {
            	$('#item-submit').prop('disabled', true);
				document.getElementById("total-price").value ="0.00";
			}
			else if (quantity <= 0) {
				var error_message = "Quantity must be above 0";
				$('#quantity-error').addClass('has-error');
				$('#quantity-error').append('<div class="help-block">' + error_message + '</div>');
				$('#item-submit').prop('disabled', true);
				document.getElementById("total-price").value = "0.00";
			}
			else if (quantity > stock_count) {
				var error_message = "Quantity is above stock count";
				$('#quantity-error').addClass('has-error');
				$('#quantity-error').append('<div class="help-block">' + error_message + '</div>');
				$('#item-submit').prop('disabled', true);
				document.getElementById("total-price").value = "0.00";
			}
		   
		   	else if (quantity >= slab) {
				document.getElementById("agreed-price").value = low_price;
				agreed_price= parseFloat(document.getElementById("agreed-price").value);

				//.value = quantity * agreed_price;
				_total.value = quantity * agreed_price;
				_total.value=numberWithCommas(_total.value);
				document.getElementById("agreed-price").value = numberWithCommas(low_price);
		   	}
		   	else {
				document.getElementById("agreed-price").value = high_price;
				agreed_price= parseFloat(document.getElementById("agreed-price").value);
				document.getElementById("total-price").value= numberWithCommas(quantity * agreed_price);
				document.getElementById("agreed-price").value = numberWithCommas(high_price);
		   	}


		});

		//script to handle change of stock
		$("#stock").on("change", function () {
			var selected = $(this).val();
			makeAjaxRequest(selected);
		});

		//script for the add item button on invoice form
		$('#invoice-form').submit(function (event) {

			$('.form-group').removeClass('has-error'); // remove the error class
			$('.help-block').remove(); // remove the error text
			// get the form data
			var formData = {
				'quantity'		: removeCommas($('input[name= quantity]').val()),
				'stock'			: $('select[name= stock]').val(),
				'agreed-price'	: removeCommas($('input[name= agreed-price]').val()),
				'total-price'	: removeCommas($('input[name= total-price]').val()),
				'invoice_num'	: $('#invoice-display').text(),
				'store'			: $('#store-display').text(),
				'check'			: $('input[name= check]').val(),
				'user_id'		:user_id
				//'date': $('input[name= date]').val()
			};
			// process the form
			$.ajax({
				type: 'POST',
				url: 'ajax/invoice/invoice_form_post.php',
				data: formData,
				dataType: 'json',
				encode: true
			})
				.done(function (data) {
					if (!data.success) {
						if (data.errors.quantity) {
							$('#quantity-group').addClass('has-error'); // add the error class to show red input
							$('#quantity-group').append('<div class="help-block">' + data.errors.quantity + '</div>'); // add the actual error message under our input
						}
						if (data.errors.stock) {
							$('#stock-group').addClass('has-error'); // add the error class to show red input
							$('#stock-group').append('<div class="help-block">' + data.errors.stock + '</div>'); // add the actual error message under our input
						}
						if (data.errors.user_id) {
							$('#stock-group').addClass('has-error'); // add the error class to show red input
							$('#stock-group').append('<div class="help-block">' + data.errors.user_id + '</div>'); // add the actual error message under our input
						}
						if (data.errors.message) {
							$('#form-section').append('<div class="alert alert-danger help-block text-danger" style=""><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton>' + data.errors.message + '</div>'); // add the actual error message under our input
						}
					}
					else {
						$('#charges-display').text(data.total);
						$('#price-display').text(data.total);
						var invoice_id = $('#invoice-display').text();
						//alert (invoice_id);
						$('#jqgrid').jqGrid('setGridParam', {
							url: "ajax/invoice/invoice_add_item_get2.php?invoice_id=" + invoice_id,
							editurl: "ajax/invoice/invoice_item_list_set.php?store_name=" + $('#store-display').text()
						}).trigger("reloadGrid");

						$('select[name= stock]').val('none').trigger('change');
						$('input[name= quantity]').val('');
						$('input[name= agreed-price]').val('0.00');
						$('input[name= total-price]').val('0.00');
						$('input[name= discount').val('0.00');
						$('#item-submit').prop('disabled', true);
						$('input[name= quantity]').prop('disabled', true);
						$('#invoice-complete').prop('disabled', false);
						$('#button_complete').show();
						$('#cash_checkbox').show();
						//alert ('success');
					}
				});
			event.preventDefault();
		});

		//cancel an invoice order, don't submit
		$('#cancel_invoice').click(function (event) {
			event.preventDefault();
			var postData = {
				'invoice_num_cancel': $('#invoice-display').text(),
				'store'			: $('#store-display').text()};
			// process the form
			$.ajax({
				type: 'POST',
				url: 'ajax/invoice/invoice_form_select_post.php',
				data: postData,
				dataType: 'json',
				encode: true
			})
				// using the done promise callback
				.done(function (data) {
					if (!data.success) {
						alert(data.message);
					}
					else {
						//close modal and take the page back to what it was
						//$('#cancelModal').modal('hide');
						//				$('#invoicedrop').hide('fast');
						//				$('#newinvoice-slide').show('fast');
						//				$('#customer, #payment, #store').val('none').trigger('change');
						//				jQuery("#jqgrid").jqGrid("clearGridData").trigger('reload');

						var invoice_id = 0;
						$('#jqgrid').jqGrid('setGridParam', {
							url: "ajax/invoice/invoice_add_item_get2.php?invoice_id=" + invoice_id
						}).trigger("reloadGrid");
						//location.reload(true);
						<?php if (isset($_GET['src']) && $_GET['src'] == 'none') {?>
						location.reload(true);
						<?php } else {?>
						location.href = "#ajax/new_invoice.php?src=none";
						<?php } ?>
						$('body').removeClass('modal-open').css('padding-right', '0px');
						//$('body').removeClass('modal-open');
						//$('#payment').val('none').trigger('change');
						//alert ('success');
					}
				})
		});

		//script to handle the invoice complete button
		$('#invoice-close').click(function () {
			var cash_check = "";
			if (document.getElementById("cash-stock").checked) {
				cash_check = "on";
			}
			else {
				cash_check = "off";
			}
			var postData = {
				'invoice_num': $('#invoice-display').text(),
				'total_amount': $('#charges-display').text(),
				'customer': $('#customer-display').text(),
				'payment': $('#payment-display').text(),
				'cashstock': cash_check,
				'user_id':user_id
			};

			$.ajax({
				type: 'POST',
				url: 'ajax/invoice/invoice_complete_post.php',
				data: postData,
				dataType: 'json',
				encode: true
			}).done(function (data) {

				if (data.success) {

					$.post('ajax/invoice_session.php', {invoice_num: postData.invoice_num}, function (data) {
						//alert(data);
						invoice_num_print = postData.invoice_num;
						//alert(invoice_num_print);
						//location.reload(true);
						var invoice_id = 0;
						$('#jqgrid').jqGrid('setGridParam', {
							url: "ajax/invoice/invoice_add_item_get2.php?invoice_id=" + invoice_id
						}).trigger("reloadGrid");
						//location.href= "#ajax/new_invoice.php?src=none";

						window.open('invoice.php');
						location.reload(true);
//						localStorage.setItem('invoice_number', postData.invoice_num);
//						var invoice_num_retrieved = localStorage.getItem('invoice_number');
						//alert(invoice_num_retrieved);
						//location.href = "#ajax/new_invoice.php";
					});

				}
				else {
					//alert ('error in server code');
					$('#errorappendrow').show().empty().append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>"+data.message+"</div>");
				}
				//window.location = '#ajax/daily_sales_ledger.php';
				$('body').removeClass('modal-open').css('padding-right','0px');
			})
		});

		//script handling the status select change event when coming in from the sales ledger
		$("#status_select").on("change", function () {
			var status = $(this).val();
			$('#invoice-complete').prop('disabled', false);
			$('.delete_button').prop('disabled',false);
			$.ajax({
				type: "POST",
				data: {status: status, 'invoice_num_select': $('#invoice-display').text()},
				url: "ajax/invoice/invoice_form_select_post.php",
				dataType: 'json',
				success: function (response) {
					$('#invoice-form').show();
					$('#status_select').hide();
					$('#button_complete').show();
					$('#cash_checkbox').show();
					$('#pjqgrid').show();
				}
			});
		});

		if (!isNaN(invoice_num_print)) {
			$('#print_invoice_new').show();
			$('#print_invoice_form').show();
		}
		else {
			$('#print_invoice_new').hide();
			$('#print_invoice_form').hide();
		}
	});
	//document.ready function ends here

	//===============================FUNCTIONS CALLED FROM SCRIPTS===============================//
	//function called within jqgrid to delete an item i

	function deleteItem(click_id) {
		//alert($(click_id).children('.deleteid').val());
		$.ajax({
			type: "POST",
			data: {
				id: $(click_id).children('.deleteid').val(),
				operation: "delete",
				store_name: $('#store-display').text()
			},
			url: "ajax/invoice/invoice_item_list_set.php",
			dataType: 'json',
			success: function (response) {
				//alert(response);
				var invoice_id = $('#invoice-display').text();
				//alert (invoice_id);
				$('#jqgrid').jqGrid('setGridParam', {
					url: "ajax/invoice/invoice_add_item_get2.php?invoice_id=" + invoice_id
					//editurl: "ajax/invoice/invoice_item_list_set.php?store_name=" + $('#store-display').text()
				}).trigger("reloadGrid");
			}
		});
	}

	//function called by next script below to process the stock change event
	function makeAjaxRequest(opts) {
		$.ajax({
			type: "POST",
			data: {
				opts: opts,
				store_name: $('#store-display').text()
			},
			url: "ajax/invoice/invoice_form_select_post.php",
			dataType: 'json',
			success: function (response) {
				//alert (response);
				$('#slab').val(response.slab);
				$('#stock-count').val(response.count);
				$('#lower-price').val(response.higher_price);
				$('#higher-price').val(response.lower_price);
				$('#sku').val(response.stock_code);
			}
		});
	}

	function disableBtn(clicked){
		$(clicked).prop('disabled',true);
	}

//PUT COMMAS INSIDE A NUMBER
	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	function removeCommas(x){
		return parseFloat(x.replace(/,/g, ''));
	}

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
		//JQGrid code starts here
		function run_jqgrid_function() {
			var countrow;

			jQuery("#jqgrid").jqGrid({
				url: "ajax/invoice/invoice_add_item_get2.php<?php if (isset($session_invoice) && isset($_GET['src']) && $_GET['src']== 'ledger' ){echo '?invoice_id='.$session_invoice;}?>",
				datatype: "json",
				mtype: "GET",
				//height : 'auto',
				colNames : ['S/N', 'Stock', 'Unit Price', 'Quantity', 'Purchase Amount',  'Discount', 'Actions'],
				colModel : [
					{
						name : 'serial',
						index : 'serial',
						width: 40,
						sortable : true,
						editable:false
					},
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
						editable : false,
						//formatter:'number'
						//formatter: 'number'
						/*summaryTpl: "Sum: {0}", // set the summary template to show the group summary
						  summaryType: "sum" */// set the formula to calculate the summary type
					},
					{
						name : 'discount',
						index : 'discount',
						editable : false
					},
					{
						name: 'act',
						index: 'act',
						sortable: false
					}
				],
				//rowNum : 10,
				//rowList : [10, 20, 30],
				pager : '#pjqgrid',
				sortname : 'item_id',
				toolbarfilter : true,
				height: 285,
				viewrecords : true,
				sortorder : "asc",
				footerrow : true,
				userDataOnFooter : true,
				scrollPopUp: true,
				scrollLeftOffset: "83%",
				scroll: true, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
				emptyrecords: 'Scroll to bottom to retrieve new page', // the message will be displayed at the bottom
				//altRows : true,
				//loadonce: true,
	//			jsonReader: {
	//			// instruct subgrid to get the data as name:value pair
	//				subgrid : { repeatitems: false}
	//			},

				gridComplete : function() {
					var total_price= document.getElementById("grid_total").innerHTML;
					document.getElementById("price-display").innerText= total_price;
					document.getElementById("charges-display").innerText = total_price;
					var ids = jQuery("#jqgrid").jqGrid('getDataIDs');
					//alert(rolenames);

					for (var i = 0; i < ids.length; i++) {
						var cl = ids[i];
						ca= "<button class='btn btn-sm btn-primary delete_button'  data-toggle='tooltip' title='Delete' data-original-title='Delete' id='delete_button' type='button' onclick='deleteItem(this)' ><i class='fa fa-trash-o'></i><input type='hidden' id='delete_id' class='deleteid' value='"+cl+"'></button>";
						var status_what="<?php if(isset($status_what)&&$status_what=="0"){echo "1";}else{echo "2";}?>";
						if(status_what=="1"){
							$('.delete_button').prop('disabled',true);
						}


						jQuery("#jqgrid").jqGrid('setRowData', ids[i], {
							act : ca
							//act2: mp
						});
						 countrow= jQuery("#jqgrid").jqGrid('getGridParam', 'reccount');
						//alert(countrow);
						if(countrow < 2) {
							$('#button_complete').hide();
							$('#cash_checkbox').hide();
						}
					}

				},

				editurl : "ajax/invoice/invoice_item_list_set.php",
				caption : "Invoice Items",
				//multiselect : true,
				autowidth : true,
			});



			jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
				edit : false,
				add : false,
				del : false,
				search: false,
				view: false
			});
	//    			jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
	//    			/* Add tooltips */
	//    			$('.navtable .ui-pg-button').tooltip({
	//    				container : 'body'
	//    			});

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
			//$("tr.ui-widget-content:nth-child(1)").css('width','30px');
			// update buttons

			$(window).on('resize.jqGrid', function() {
				$("#jqgrid").jqGrid('setGridWidth', $("#resize-grid").width());
			});

		}// end function

	};
	loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);

</script>