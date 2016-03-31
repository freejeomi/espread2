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
$table_complete="";
$stock_name= "";
$table_value="";
//$store_id= "";
$total_sales_stock= "";
$sql= "";
$result= "";
$j=1;

$items_table = '<div id="items_table" class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12"><table class="table table-striped table-hover table-bordered"><thead style="background-color:grey;"><tr><th>S/N</th><th>Sku</th><th>Stock</th><th>Qauntity</th><th>Sales amount</th></tr></thead><tbody>';
$items_end_table= '</tbody></table></div>';
include "lib/util.php";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}else{
    if(isset($_GET['start_date']) && isset($_GET['end_date'])){
          
        $store_id=$_GET['store_id'];
        $startdate=$_GET['start_date'];
        $finishdate=$_GET['end_date'];
        $table_choice= $_GET['tab'];

        if ($table_choice == "main") {
            if ($store_id == "all") {
                $sql = "SELECT SUM(charge) AS sales_amount,SUM(quantity) AS product_qty, stock.stock_code AS sku, stock.stock_name AS product FROM invoiceitems_daily,stock, salesinvoice WHERE (salesinvoice.invoice_num= invoiceitems_daily.invoice_num) AND stock.stock_id= invoiceitems_daily.stock_id AND (trans_date BETWEEN '$startdate'AND '$finishdate') GROUP BY invoiceitems_daily.stock_id";
                $sum_total = 0;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $table_value .= '<tr><td>' . $j . '</td><td>' . $row['sku'] . '</td><td>' . $row['product'] . '</td><td>' . $row['product_qty'] . '</td><td>' . number_format($row['sales_amount'], 2) . '</td></tr>';
                        $j++;
                        $sum_total = $sum_total + $row['sales_amount'];

                    }
                    $table_total = '<tr style="font-weight:bold;"><td colspan="4">TOTAL</td><td>' . number_format($sum_total, 2) . '</td></tr>';

                    $table_complete = $items_table . $table_value . $table_total . $items_end_table;
                    //echo $table_complete;
                } else {

                    $table_complete = $items_table . $items_end_table;
                }
            }
            else {

                $sql = "SELECT SUM(charge) AS sales_amount,SUM(quantity) AS product_qty, stock.stock_code AS sku, stock.stock_name AS product FROM invoiceitems_daily,stock, salesinvoice WHERE (salesinvoice.invoice_num= invoiceitems_daily.invoice_num) AND salesinvoice.store= '$store_id' AND stock.stock_id= invoiceitems_daily.stock_id AND (trans_date BETWEEN '$startdate'AND '$finishdate') GROUP BY invoiceitems_daily.stock_id";
                $sum_total = 0;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $table_value .= '<tr><td>' . $j . '</td><td>' . $row['sku'] . '</td><td>' . $row['product'] . '</td><td>' . $row['product_qty'] . '</td><td>' . number_format($row['sales_amount'], 2) . '</td></tr>';
                        $j++;
                        $sum_total = $sum_total + $row['sales_amount'];

                    }
                    $table_total = '<tr style="font-weight:bold;"><td colspan="4">TOTAL</td><td>' . number_format($sum_total, 2) . '</td></tr>';

                    $table_complete = $items_table . $table_value . $table_total . $items_end_table;
                    //echo $table_complete;
                } else {

                    $table_complete = $items_table . $items_end_table;
                }
            }
        }
        else if ($table_choice == "temp"){
            if ($store_id == "all") {
                $sql = "SELECT SUM(charge) AS sales_amount,SUM(quantity) AS product_qty, stock.stock_code AS sku, stock.stock_name AS product FROM invoiceitems_daily,stock, salesinvoice_daily WHERE (salesinvoice_daily.invoice_num= invoiceitems_daily.invoice_num) AND stock.stock_id= invoiceitems_daily.stock_id AND (trans_date BETWEEN '$startdate'AND '$finishdate') GROUP BY invoiceitems_daily.stock_id";
                $sum_total = 0;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $table_value .= '<tr><td>' . $j . '</td><td>' . $row['sku'] . '</td><td>' . $row['product'] . '</td><td>' . $row['product_qty'] . '</td><td>' . number_format($row['sales_amount'], 2) . '</td></tr>';
                        $j++;
                        $sum_total = $sum_total + $row['sales_amount'];

                    }
                    $table_total = '<tr style="font-weight:bold;"><td colspan="4">TOTAL</td><td>' . number_format($sum_total, 2) . '</td></tr>';

                    $table_complete = $items_table . $table_value . $table_total . $items_end_table;
                    //echo $table_complete;
                } else {

                    $table_complete = $items_table . $items_end_table;
                }
            }
            else {

                $sql = "SELECT SUM(charge) AS sales_amount,SUM(quantity) AS product_qty, stock.stock_code AS sku, stock.stock_name AS product FROM invoiceitems_daily,stock, salesinvoice_daily WHERE (salesinvoice_daily.invoice_num= invoiceitems_daily.invoice_num) AND salesinvoice_daily.store= '$store_id' AND stock.stock_id= invoiceitems_daily.stock_id AND (trans_date BETWEEN '$startdate'AND '$finishdate') GROUP BY invoiceitems_daily.stock_id";
                $sum_total = 0;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $table_value .= '<tr><td>' . $j . '</td><td>' . $row['sku'] . '</td><td>' . $row['product'] . '</td><td>' . $row['product_qty'] . '</td><td>' . number_format($row['sales_amount'], 2) . '</td></tr>';
                        $j++;
                        $sum_total = $sum_total + $row['sales_amount'];

                    }
                    $table_total = '<tr style="font-weight:bold;"><td colspan="4">TOTAL</td><td>' . number_format($sum_total, 2) . '</td></tr>';

                    $table_complete = $items_table . $table_value . $table_total . $items_end_table;
                    //echo $table_complete;
                } else {

                    $table_complete = $items_table . $items_end_table;
                }
            }
        }
        else {
            $table_complete = $items_table . $items_end_table;
        }

    }
  
   
     }
?>


<html lang="en">
   
<head>
    <title>Sales summary </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    
</head>
<body>

<div class=" col-sm-12" ><div style=" color=black; text-align:center; padding-bottom:5px;padding-top:5px;" ><h1> Sales Summary</h1><h4>between <?php echo date(" l F d, Y", strtotime($_GET['start_date'])).' and '.date(" l F d, Y", strtotime($_GET['end_date']));    ?></h4></div><?php echo $table_complete; ?></div>
 <script src="js/libs/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script> 
    </body>
</html>
