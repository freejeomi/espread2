<!DOCTYPE html>

<?php
require_once("ajax/inc/init.php");
$role = "admin";
if (strtolower($_SESSION['role_name']) != strtolower($role)) {
    $page = 'login.php';
    ///header("location: /espread/#ajax/logout.php?page=$page");
    header("location: /espread/login.php");
    exit();
}
$sql = "";
$result = "";
$table_list = "";
$table_items = "";
$start_date = "";
$end_date = "";
$s = 1;
$table_stock="";
$total= "";
$table_start = '<div id="items_table" class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12"><table class="table table-hover table-bordered table-striped"><thead><tr style=" background-color:darkgrey;"><th>S/N</th><th>Invoice Number</th><th>Customer</th><th>Quantity</th><th>Amount</th></tr></thead><tbody>';
$table_end = '</tbody></table></div>';

include "lib/util.php";
include "functions/myfunction.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $table_choice = $_GET['tab'];

    if ($table_choice == "main") {
        $sql = "SELECT promoaccount.quantity, customer.customer_name, stock.stock_name, invoiceitems_daily.invoice_num, stock.costprice FROM promoaccount INNER JOIN stock ON stock.stock_code= promoaccount.stock_code INNER JOIN invoiceitems_daily ON invoiceitems_daily.item_id= promoaccount.item_id INNER JOIN salesinvoice ON salesinvoice.invoice_num= invoiceitems_daily.invoice_num INNER JOIN customer on customer.customer_id= salesinvoice.customer_id WHERE promoaccount.trans_date BETWEEN '$start_date' AND '$end_date' order by stock.stock_name ASC";

        $result = mysqli_query($conn, $sql);

//    if (mysqli_num_rows($result) > 0) {
//        $current_stock = null;
//        while ($row = mysqli_fetch_assoc($result)) {
//            if ($row["stock_name"] != $current_stock) {
//                $current_stock = $row["stock_name"];
//
//                $table_stock.= '<tr><td colspan="5">' . $current_stock . '</td></tr>';
//                $table_items .= '<tr><td style="width: 60px;">' . $s . '</td><td style="width: 150px;">' . $row['invoice_num'] . '</td><td>' . $row['customer_name'] . '</td><td>' . $row['quantity'] . '</td><td>' . refined_number($row['costprice']) . '</td></tr>';
//                $s++;
//            }
//        }
//        $table_list = $table_start . $table_stock.$table_items . $table_end;
//    } else {
//        $table_list = $table_start . $table_end;
//    }

        if (mysqli_num_rows($result) > 0) {
            $current_stock = "";
            $sum_amount = 0;
            $sum_qty = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                if ($current_stock == "") {
                    $current_stock = $row["stock_name"];
                    //$table_stock= ;
                    $table_items .= '<tr style="font-weight: bold;"><td colspan="5" >' . $current_stock . '</td></tr>' . '<tr><td style="width: 60px;">' . $s . '</td><td style="width: 150px;">' . $row['invoice_num'] . '</td><td>' . $row['customer_name'] . '</td><td>' . number_format($row['quantity']) . '</td><td>' . refined_number($row['costprice']) . '</td></tr>';
                    $sum_amount = $sum_amount + $row['costprice'];
                    $sum_qty = $sum_qty + $row['quantity'];
                    $s++;

                } else if ($current_stock == $row["stock_name"]) {
                    $table_items .= '<tr><td style="width: 60px;">' . $s . '</td><td style="width: 150px;">' . $row['invoice_num'] . '</td><td>' . $row['customer_name'] . '</td><td>' . number_format($row['quantity']) . '</td><td>' . refined_number($row['costprice']) . '</td></tr>';
                    $sum_amount = $sum_amount + $row['costprice'];
                    $sum_qty = $sum_qty + $row['quantity'];
                    $s++;

                } else {
                    $current_stock = $row["stock_name"];
                    $s = 1;
                    //$table_stock.= '<tr><td colspan="3"> TOTAL </td><td style="width: 150px;">' . $sum_qty . '</td><td>' . $sum_amount . '</td></tr>';
                    $table_items .= '<tr style="font-weight: bold;"><td colspan="3"> TOTAL </td><td style="width: 150px;">' . number_format($sum_qty) . '</td><td>' . refined_number($sum_amount) . '</td></tr>' . '<tr style="font-weight: bold;"><td colspan="5">' . $current_stock . '</td></tr>' . '<tr><td style="width: 60px;">' . $s . '</td><td style="width: 150px;">' . $row['invoice_num'] . '</td><td>' . $row['customer_name'] . '</td><td>' . number_format($row['quantity']) . '</td><td>' . refined_number($row['costprice']) . '</td></tr>';
                    $sum_amount = 0;
                    $sum_qty = 0;
                    $s++;
                    $sum_amount = $sum_amount + $row['costprice'];
                    $sum_qty = $sum_qty + $row['quantity'];
                }

            }
            $total = '<tr style="font-weight: bold;"><td colspan="3"> TOTAL </td><td style="width: 150px;">' . number_format($sum_qty) . '</td><td>' . refined_number($sum_amount) . '</td></tr>';
            $table_list = $table_start . $table_items . $total . $table_end;
        } else {
            $table_list = $table_start . $table_end;
        }
    }
    else if ($table_choice == "temp") {
        $sql = "SELECT promoaccount.quantity, customer.customer_name, stock.stock_name, invoiceitems_daily.invoice_num, stock.costprice FROM promoaccount INNER JOIN stock ON stock.stock_code= promoaccount.stock_code INNER JOIN invoiceitems_daily ON invoiceitems_daily.item_id= promoaccount.item_id INNER JOIN salesinvoice_daily ON salesinvoice_daily.invoice_num= invoiceitems_daily.invoice_num INNER JOIN customer on customer.customer_id= salesinvoice_daily.customer_id WHERE promoaccount.trans_date BETWEEN '$start_date' AND '$end_date' order by stock.stock_name ASC";
        $result = mysqli_query($conn, $sql);
//    if (mysqli_num_rows($result) > 0) {
//        $current_stock = null;
//        while ($row = mysqli_fetch_assoc($result)) {
//            if ($row["stock_name"] != $current_stock) {
//                $current_stock = $row["stock_name"];
//
//                $table_stock.= '<tr><td colspan="5">' . $current_stock . '</td></tr>';
//                $table_items .= '<tr><td style="width: 60px;">' . $s . '</td><td style="width: 150px;">' . $row['invoice_num'] . '</td><td>' . $row['customer_name'] . '</td><td>' . $row['quantity'] . '</td><td>' . refined_number($row['costprice']) . '</td></tr>';
//                $s++;
//            }
//        }
//        $table_list = $table_start . $table_stock.$table_items . $table_end;
//    } else {
//        $table_list = $table_start . $table_end;
//    }
        if (mysqli_num_rows($result) > 0) {
            $current_stock = "";
            $sum_amount = 0;
            $sum_qty = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                if ($current_stock == "") {
                    $current_stock = $row["stock_name"];
                    //$table_stock= ;
                    $table_items .= '<tr style="font-weight: bold;"><td colspan="5" >' . $current_stock . '</td></tr>' . '<tr><td style="width: 60px;">' . $s . '</td><td style="width: 150px;">' . $row['invoice_num'] . '</td><td>' . $row['customer_name'] . '</td><td>' . number_format($row['quantity']) . '</td><td>' . refined_number($row['costprice']) . '</td></tr>';
                    $sum_amount = $sum_amount + $row['costprice'];
                    $sum_qty = $sum_qty + $row['quantity'];
                    $s++;

                } else if ($current_stock == $row["stock_name"]) {
                    $table_items .= '<tr><td style="width: 60px;">' . $s . '</td><td style="width: 150px;">' . $row['invoice_num'] . '</td><td>' . $row['customer_name'] . '</td><td>' . number_format($row['quantity']) . '</td><td>' . refined_number($row['costprice']) . '</td></tr>';
                    $sum_amount = $sum_amount + $row['costprice'];
                    $sum_qty = $sum_qty + $row['quantity'];
                    $s++;

                } else {
                    $current_stock = $row["stock_name"];
                    $s = 1;
                    //$table_stock.= '<tr><td colspan="3"> TOTAL </td><td style="width: 150px;">' . $sum_qty . '</td><td>' . $sum_amount . '</td></tr>';
                    $table_items .= '<tr style="font-weight: bold;"><td colspan="3"> TOTAL </td><td style="width: 150px;">' . number_format($sum_qty) . '</td><td>' . refined_number($sum_amount) . '</td></tr>' . '<tr style="font-weight: bold;"><td colspan="5">' . $current_stock . '</td></tr>' . '<tr><td style="width: 60px;">' . $s . '</td><td style="width: 150px;">' . $row['invoice_num'] . '</td><td>' . $row['customer_name'] . '</td><td>' . number_format($row['quantity']) . '</td><td>' . refined_number($row['costprice']) . '</td></tr>';
                    $sum_amount = 0;
                    $sum_qty = 0;
                    $s++;
                    $sum_amount = $sum_amount + $row['costprice'];
                    $sum_qty = $sum_qty + $row['quantity'];
                }

            }
            $total = '<tr style="font-weight: bold;"><td colspan="3"> TOTAL </td><td style="width: 150px;">' . number_format($sum_qty) . '</td><td>' . refined_number($sum_amount) . '</td></tr>';
            $table_list = $table_start . $table_items . $total . $table_end;
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
    <title>FOC summary List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="">
    <div class="col-sm-12" style="text-align: center; background-color:  ">
        <h2>FOC Summary</h2>

        <p>Between <b><?php echo date("l, F d, Y", strtotime($_GET['start_date'])) ; ?></b> and <b><?php echo date("l, F d, Y", strtotime($_GET['end_date'])); ?></b></p>
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