<?php
require_once("ajax/inc/init.php");

 ?>

<?php
//$invoice_num= "";
$sql = "";
$result = "";
$cus_name = "";
$cus_type = "";
$debit ="";
$credit = "";
$closingbal = "";
$items_row = '';
$items_table = '<div id="items_table"  class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12" style="padding: 0;"><table class="table table-striped table-hover"><thead><tr ><th>S/N</th><th>Date</th><th>Time</th><th>Reference</th><th>Credit</th><th>Debit</th><th>Payment Type</th><th>Remark</th></tr></thead><tbody>';
$items_total = '';

if ($_GET['cus_Id']) {
    $cus_id = $_GET['cus_Id'];
    include "lib/util.php";

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $result = mysqli_query($conn, "SELECT * FROM customer WHERE customer_id= $cus_id") or die("Couldn't execute query." . mysqli_error($conn));
    while ($data = mysqli_fetch_assoc($result)) {
        $cus_name = $data ['customer_name'];
        $cus_type = $data ['customer_type'];
    }
    $cash = mysqli_query($conn, "SELECT sum(if(amount >0, amount, 0.00))AS credit, sum(if(amount <0, amount, 0.00))AS debit FROM customer_transaction WHERE customer_id= $cus_id");
    while ($data = mysqli_fetch_assoc($cash)) {
        $debit = $data['debit'];
        $credit = $data ['credit'];
        $closingbal = $debit + $credit;

    }

    $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id";
    $result= mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $s= 1;
        while ($row= mysqli_fetch_assoc($result)) {
            $items_row.= '<tr ><td>' . $s . '</td><td>' . $row['date'] . '</td><td>' . $row['time'] . '</td><td>' . $row['invoice_num'] . '</td><td>' . number_format($row['credit'], 2) . '</td><td>' . number_format($row['debit'], 2). '</td><td>' . $row['payment_type'] . '</td><td>' . $row['remark'] . '</td></tr>';
            $s++;
        }
        $items_table .= $items_row . '</tbody></table></div>';
    }

}
 else {
        $error = "sorry an error occured. please try again!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account Statement</title>
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
        <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-sm-offset-2"
                 style="padding-top: 20px; padding-bottom: 20px;">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget well jarviswidget-color-darken" id="wid-id-0" data-widget-sortable="false"
                 data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false">

                <div>
                    <!-- widget content -->
                    <div class="widget-body no-padding">

                        <div class="widget-body-toolbar">

                        </div>

                        <div class="padding-10 ">
                            <div class="row">
                                <br>

                                <div class="col-sm-6 col-xs-6 col-md-6 col-sm-offset-3 col-xs-offset-3 col-md-offset-3">
                                    <h1 class="font-400">Customer Statement of Account</h1>
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
                                            <span class=""> <?php echo $cus_name; ?> </span>
                                        </div>

                                    </div>
                                    <div>
                                        <div class="font-md">
                                            <strong>TYPE :</strong>
                                            <span class="">  <?php echo $cus_type; ?> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 pull-right">
                                    <br>

                                    <div>
                                        <div class="font-md">
                                            <strong>TOTAL DEBIT :</strong>
                                            <span class=""> <?php echo number_format($debit, 2); ?> </span>
                                        </div>

                                    </div>
                                    <div>
                                        <div class="font-md">
                                            <strong>TOTAL CREDIT :</strong>
                                            <span class="">  <?php echo number_format($credit, 2); ?> </span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-md">
                                            <strong>BALANCE :</strong>
                                            <span class="">  <?php echo number_format($closingbal, 2); ?> </span>
                                        </div>
                                    </div>
                                    <br>
                                    <!--									<div class="well well-sm  bg-color-darken txt-color-white no-border">-->
                                    <!--										<div class="fa-lg">-->
                                    <!--											Total Due :-->
                                    <!--											<span class="pull-right"> -->
                                    <?php //echo $totalamt;?><!-- </span>-->
                                    <!--										</div>-->
                                    <!--									</div>-->
                                    <br>
                                    <br>
                                </div>
                            </div>

                            <?php echo $items_table; ?>


                            <div class="invoice-footer">

                                <div class="row">


                                    </div>

                                </div>

                                <div class="row container hidden-print">
                                    <button type="button" class="btn btn-md btn-primary" onclick="window.print();">
                                        <i class="fa fa-print "></i>Print
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

    // PAGE RELATED SCRIPTS

    // pagefunction

    var pagefunction = function () {

    };

    // end pagefunction

    // run pagefunction on load

    pagefunction();

</script>
<script src="js/libs/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
</body>
</html>