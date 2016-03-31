<?php require_once("ajax/inc/init.php"); ?>
<?php
//$invoice_num= "";
$sql= "";
$result= "";
$sales_date = "";
$totalamt = 0.00;
$payment_type = "";
$username = "";
$customer_name = "";
$customer_type = "";
$customer_phone = "";
$customer_email = "";
$store_name = "";
$item_id = array();
$item_quantity = array();
$item_charge = array();
$item_stockname = array();
$item_sellingprice= array();
$phone="";
$company_name="";
$email="";
$address="";
$items_row = '';
$invoice_num= "";
$i = 0;
$p = 1;
$promo_table = '';
$items_table = '<div id="items_table"  class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12" style="padding: 0;"><table class="table table-hover"><thead><tr ><th>S/N</th><th>Item</th><th>Unit Price</th><th>Quantity</th><th>Subtotal</th></tr></thead><tbody>';
$items_total = '';

if (isset($_SESSION['print_invoice']) && $_SESSION['print_invoice'] !== "" && $_SESSION['role_name'] == "operator") {
	$invoice_num = $_SESSION['print_invoice'];
}
elseif ($_SESSION['invoice_num_retrieved'] !== "" && ($_SESSION['role_name'] == "admin" || $_SESSION['role_name'] == "superadmin") ) {
	$invoice_num = $_SESSION['invoice_num_retrieved'];
}
elseif ($_SESSION['invoice_num_retrieved'] != "" &&(isset($_SESSION['task']) && $_SESSION['task'] == "print") ) {
	$invoice_num= $_SESSION['invoice_num_retrieved'];
}
	//$invoice_num= $_GET['invoice_num'];
	include "lib/util.php";
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$result_company= mysqli_query($conn, "SELECT company_name, company_address, company_phone, company_email FROM settings LIMIT 1");
	if (mysqli_num_rows($result_company) > 0) {
	$row_company=mysqli_fetch_array($result_company);
	$company_name=$row_company[0];
	$address=$row_company[1];
	$phone=$row_company[2];
	$email=$row_company[3];
	}

	$sql= "SELECT sales_date, purchase_amount, payment_type, users.username, customer.customer_name, customer.customer_type, customer.phone, customer.email, store.store_name FROM salesinvoice_daily INNER JOIN users on users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id INNER JOIN store ON store.store_id= salesinvoice_daily.store WHERE salesinvoice_daily.invoice_num= $invoice_num";
	$result= mysqli_query($conn, $sql);
	if (!$result){
		//echo "an error occured while retrieving from salesinvoice_daily table";
	}
	else {
		if(mysqli_num_rows($result)>0){
			while ($row= mysqli_fetch_array($result)) {
				$sales_date = $row[0];
				$totalamt = $row[1];
				$payment_type = $row[2];
				$username = $row[3];
				$customer_name = $row[4];
				$customer_type = $row[5];
				$customer_phone = $row[6];
				$customer_email = $row[7];
				$store_name = $row[8];

				$sql_invoiceitem = "SELECT item_id, selling_price, quantity,charge, stock.stock_name FROM invoiceitems_daily INNER JOIN stock ON stock.stock_id = invoiceitems_daily.stock_id WHERE invoice_num=$invoice_num";

				$result_invoiceitem = mysqli_query($conn, $sql_invoiceitem);

				$s = 1;
				while ($row_invoiceitem = mysqli_fetch_assoc($result_invoiceitem)) {
					$items_row .= '<tr ><td>' . $s . '</td><td>' . $row_invoiceitem['stock_name'] . '</td><td>' . number_format($row_invoiceitem['selling_price'],2) . '</td><td>' . number_format($row_invoiceitem['quantity']) . '</td><td>' . number_format($row_invoiceitem['charge'],2) . '</td></tr>';
					$s++;

					$item_id[$i] = $row_invoiceitem['item_id'];

					$sql_promo = mysqli_query($conn, "SELECT stock.stock_name,quantity FROM promoaccount INNER JOIN stock ON stock.stock_code=promoaccount.stock_code WHERE item_id='$item_id[$i]'");

					if (mysqli_num_rows($sql_promo) > 0) {

						while ($row_promo = mysqli_fetch_assoc($sql_promo)) {
							$promo_table .= '<tr><td>' . $p . '</td ><td >' . $row_promo['stock_name'] . '</td><td> 0.00 </td><td>' . number_format($row_promo['quantity']) . '</td><td>0.00</td></tr>';
							$p++;
						}
					}
					//invoice exists so search the items daily table

					$item_quantity[$i] = $row_invoiceitem['quantity'];
					$item_charge[$i] = $row_invoiceitem['charge'];
					$item_stockname[$i] = $row_invoiceitem['stock_name'];
					$item_sellingprice[$i] = $row_invoiceitem['selling_price'];
					$i++;
					//$p++;
				}
				$promoheader= '<tr style = "" ><td colspan = "5" class="text-center" style="text-align: center;" ><b > Promo Items </b ></td ></tr >';
				$items_row .= $promoheader. $promo_table . '<tr class=""><td colspan="4" class="text-center"><b>TOTAL</b></td><td><b>' . number_format($totalamt,2) . '</b></td></tr>';
				$items_table .= $items_row . '</tbody></table></div>';

			}
		}//end of if
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Print Invoice</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/invoice.min.css" rel="stylesheet">
</head>
<body>


<!-- widget grid -->
<section id="widget-grid" class="">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-sm-offset-3" style="padding-top: 20px; padding-bottom: 20px;">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget well jarviswidget-color-darken" style="background-color: white;" id="wid-id-0" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false">
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
<!--				<header>-->
<!--					<span class="widget-icon"> <i class="fa fa-barcode"></i> </span>-->
<!--					<h2>Item #44761 </h2>-->
<!---->
<!--				</header>-->

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">

						<div class="widget-body-toolbar">

						</div>

						<div class="padding-10 ">
						<div class="row">
							<br>
							<div class= col-sm-4">
								<div class=" pull-left"style="margin-left: 10px;">
									<img src="img/logo-blacknwhite.png" width="150" height="32" alt="invoice icon">

									<h1 class="font-400">Invoice</h1>
								</div>
							</div>
							<div class="col-sm-4">

							</div>
							<div class=" col-sm-4">
								<div class="pull-right">
									<address>
										<strong><?php echo $company_name; ?></strong>
										<br>
										<?php echo $address;?>
										<br>
										<abbr title="Phone">P:</abbr> <?php echo $phone; ?>
										<br>
										<abbr title="Email">E:</abbr> <?php echo $email; ?>
									</address>
								</div>
							</div>
						</div>

<!--							<div class="clearfix"></div>-->
<!--							<br>-->
							<br>
							<div class="row">
								<div class="col-sm-8 pull-left">
								<br>
									<div>
										<div class="font-md">
											<strong>NAME :</strong>
											<span class=""> <?php echo $customer_name; ?> </span>
										</div>

									</div>
									<div>
										<div class="font-md">
											<strong>ADDRESS :</strong>
											<span class="">  <?php  ?> </span>
										</div>
									</div>
									<div>
										<div class="font-md">
											<strong>TYPE :</strong>
											<span class="">  <?php echo $customer_type; ?> </span>
										</div>
									</div>
									<div>
										<div class="font-md">
											<strong>PHONE:</strong>
											<span class=""> <?php echo $customer_phone; ?> </span>
										</div>
									</div>
									<div>
										<div class="font-md">
											<strong>EMAIL :</strong>
											<span class=""> <?php echo $customer_email; ?> </span>
										</div>
									</div>
								</div>
								<div class="col-sm-4 pull-right">
								<br>
									<div>
										<div class="font-md" >
											<strong>INVOICE NO :</strong>
											<span class=""> <?php echo $invoice_num;?> </span>
										</div>

									</div>
									<div>
										<div class="font-md">
											<strong>INVOICE DATE :</strong>
											<span class="">  <?php echo $sales_date;?> </span>
										</div>
									</div>
									<div>
										<div class="font-md">
											<strong>STORE :</strong>
											<span class="">  <?php echo $store_name;?> </span>
										</div>
									</div>
									<div>
										<div class="font-md">
											<strong>OPERATOR :</strong>
											<span class=""> <?php echo $username;?> </span>
										</div>
									</div>
									<div>
										<div class="font-md">
											<strong>PAYMENT TYPE :</strong>
											<span class=""> <?php echo $payment_type;?> </span>
										</div>
									</div>
									<br>
<!--									<div class="well well-sm  bg-color-darken txt-color-white no-border">-->
<!--										<div class="fa-lg">-->
<!--											Total Due :-->
<!--											<span class="pull-right"> --><?php //echo $totalamt;?><!-- </span>-->
<!--										</div>-->
<!--									</div>-->
									<br>
									<br>
								</div>
							</div>

								<?php echo $items_table; ?>



							<div class="invoice-footer">

								<div class="row">

									<div class="col-sm-7">
										<div class="payment-methods">
										<br><br><p>.....................................</p>
											<h5>Cashier Sign</h5>

										</div>
									</div>
									<div class="col-sm-5">
										<div class="invoice-sum-total pull-right">
											<h3><strong>Total: <span class=""><?php echo number_format($totalamt,2);?> NGN</span></strong></h3>
										</div>
									</div>

								</div>
								
								<div class="row container hidden-print">
									<button type= "button" class="btn btn-md btn-primary" onclick="window.print();">
										<i class="fa fa-print " ></i>Print
									</button>
								</div>

							</div>
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

</section>
<!-- end widget grid -->
<?php
//$_SESSION['invoice_num_retrieved'] = $_SESSION['print_invoice'];
$_SESSION['print_invoice'] = "";
$_SESSION['invoice_num_retrieved']="";
?>
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

	//pageSetUp();

	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var pagefunction = function() {
		
	};
	
	// end pagefunction
	
	// run pagefunction on load

	pagefunction();

</script>
<script src="js/libs/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
</body>
</html>