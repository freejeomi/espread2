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
//$store_id= "";
$total_sales_stock= "";
$table_value= "";
$sql= "";
$result= "";
$j=1;

$items_table = '<div id="items_table" class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12"><table class="table table-striped table-hover table-bordered"><thead style="background-color:grey;"><tr><th>S/N</th><th>Cashier</th><th>Sales</th></tr></thead><tbody>';
$items_end_table= '</tbody></table></div>';
include "lib/util.php";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}else{
    if(isset($_GET['start_date']) && isset($_GET['end_date'])){

        $startdate=$_GET['start_date'];
        $finishdate=$_GET['end_date'];
        $table_choice = $_GET['tab'];

        if ($table_choice == "main") {
            $sql = "SELECT SUM(purchase_amount) AS sales_amount, cashier  FROM  salesinvoice WHERE cashier !='' AND sales_date BETWEEN '$startdate'AND '$finishdate' GROUP BY cashier ";
            //$sql= "SELECT SUM(puchase_amount) AS sales_amount, cashier.stock_name AS cashier FROM  salesinvoice INNER JOIN cashier on cashier.cashier_id=salesinvoice.cashier_id WHERE trans_date BETWEEN '$startdate'AND '$finishdate' GROUP BY salesinvoice.cashier_id=cashier_id ";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $table_value .= '<tr><td>' . $j . '</td><td>' . $row['cashier'] . '</td><td>' . number_format($row['sales_amount'], 2) . '</td></tr>';
                    $j++;
                }
                $table_complete = $items_table . $table_value . $items_end_table;
                //echo $table_complete;
            } else {
                $table_complete = $items_table . $items_end_table;
            }

        }
        else if ($table_choice == "temp") {
            $sql = "SELECT SUM(purchase_amount) AS sales_amount, cashier  FROM  salesinvoice_daily WHERE cashier !='' AND sales_date BETWEEN '$startdate'AND '$finishdate' GROUP BY cashier ";
            //$sql= "SELECT SUM(puchase_amount) AS sales_amount, cashier.stock_name AS cashier FROM  salesinvoice INNER JOIN cashier on cashier.cashier_id=salesinvoice.cashier_id WHERE trans_date BETWEEN '$startdate'AND '$finishdate' GROUP BY salesinvoice.cashier_id=cashier_id ";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $table_value .= '<tr><td>' . $j . '</td><td>' . $row['cashier'] . '</td><td>' . number_format($row['sales_amount'], 2) . '</td></tr>';
                    $j++;
                }
                $table_complete = $items_table . $table_value . $items_end_table;
                //echo $table_complete;
            } else {
                $table_complete = $items_table . $items_end_table;
            }
        }
        else{
            $table_complete = $items_table . $items_end_table;
        }
    }
}
?>



<html lang="en">
   
<head>
    <title>Cashier sales summary </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    
</head>
<body>

<div class=" col-sm-12" ><div style=" color=black; text-align:center; padding-bottom:5px;padding-top:5px;" ><h1>Cashier Sales Summary</h1><h4>between <?php echo date(" l F d, Y", strtotime($_GET['start_date'])).' and '.date(" l F d, Y", strtotime($_GET['end_date'])); ?></h4></div><?php echo $table_complete; ?></div>
 <script src="js/libs/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script> 
    </body>
</html>
