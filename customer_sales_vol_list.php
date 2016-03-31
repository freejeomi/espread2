<!DOCTYPE html>
<?php
require_once("ajax/inc/init.php");
require_once("lib/config.php");
$role = "admin";
if (strtolower($_SESSION['role_name']) != strtolower($role)) {
    $page = 'login.php';
    ///header("location: /espread/#ajax/logout.php?page=$page");
    header("location:" .APP_URL."/login.php");
    exit();
}
?>
<?php
$sql = "";
$result = "";
$table_list= "";
$table_items= "";
$start_date= "";
$end_date= "";
$s = 1;
$table_start = '<div id="items_table" class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12"><table class="table table-hover table-bordered table-striped"><thead><tr style=" background-color:darkgrey;"><th>S/N</th><th>Customer</th><th>Amount</th></tr></thead><tbody>';
$table_end = '</tbody></table></div>';

include "lib/util.php";
include "functions/myfunction.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ( isset( $_GET['start_date'] ) && isset( $_GET['end_date'] ) ) {
    $start_date= $_GET['start_date'];
    $end_date= $_GET['end_date'];
    //UNION(SELECT customer . customer_name, SUM(salesinvoice_daily . purchase_amount) as total FROM salesinvoice_daily, customer WHERE customer . customer_id = salesinvoice_daily . customer_id AND salesinvoice_daily . sales_date BETWEEN '2016-02-12' AND '2016-02-19' GROUP by salesinvoice_daily . customer_id)
    $table_choice = $_GET['tab'];

    if ($table_choice == "main") {
        $sql = "(SELECT customer.customer_name, SUM(salesinvoice.purchase_amount) as total FROM salesinvoice, customer WHERE customer.customer_id= salesinvoice.customer_id AND salesinvoice.sales_date BETWEEN '$start_date' AND '$end_date' GROUP by salesinvoice.customer_id) ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                $table_items .= '<tr><td style="width: 60px;">' . $s . '</td><td>' . $row['customer_name'] . '</td><td>' . refined_number($row['total']) . '</td></tr>';
                $s++;
            }
            $table_list = $table_start . $table_items . $table_end;
        } else {
            $table_list = $table_start . $table_end;
        }
    } else if ($table_choice == "temp") {
        $sql = "(SELECT customer.customer_name, SUM(salesinvoice_daily.purchase_amount) as total FROM salesinvoice_daily, customer WHERE customer.customer_id= salesinvoice_daily.customer_id AND salesinvoice_daily.sales_date BETWEEN '$start_date' AND '$end_date' GROUP by salesinvoice_daily.customer_id) ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                $table_items .= '<tr><td style="width: 60px;">' . $s . '</td><td>' . $row['customer_name'] . '</td><td>' . refined_number($row['total']) . '</td></tr>';
                $s++;
            }
            $table_list = $table_start . $table_items . $table_end;
        } else {
            $table_list = $table_start . $table_end;
        }
    }
    else {
        $table_list = $table_start . $table_end;
    }

}
?>



<html lang="en">
    <head>
        <title>Customer Sales Volume List</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="" >
            <div class="col-sm-12" style="text-align: center; background-color:  ">
            <h2>Customer Sales Volume</h2>
                <p>Between <b><?php echo date("l, F d, Y", strtotime($_GET['start_date'])); ?></b> and
                    <b><?php echo date("l, F d, Y", strtotime($_GET['end_date'])); ?></b></p>
        </div>
        <div class="">
        <div class="col-sm-12">
            <?php echo $table_list; ?>
        </div>

        </div>
            <script src="js/libs/jquery-2.1.1.min.js"></script>
            <script src="js/bootstrap/bootstrap.min.js"></script>
    </body>
</html>