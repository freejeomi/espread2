<?php
require_once("ajax/inc/init.php");
$role = "admin";
if (strtolower($_SESSION['role_name']) != strtolower($role)) {
    $page = 'login.php';
    ///header("location: /espread/#ajax/logout.php?page=$page");
    header("location: /espread/login.php");
    exit();
}
$sql= "";
$result= "";
include "lib/util.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_POST['select_store']) && isset($_POST['select_buffer']))
{
    $store_select=$_POST['select_store'];
    $store_buffer=$_POST['select_buffer'];
    $store_name=$_POST['store_select'];
    $buffer_name=$_POST['store_buffer'];

    $total_table="";
    $thead="";
    $counter_store=0;
    $counter_stock=0;
    $tbody="";
    $stock_number=0;
    $stock_code=array();
    $stock_name=array();
    $stock_id=array();
    $trow_stock="";
    $serial=1;
    $number_store=0;
    $gap=array();
    $buffer=0;


//Get the Stock ID and Name And Stock Code
    $sql_store_select="SELECT reorder_level_store as reorder_level,stock.stock_id,stock.stock_code,stock.stock_name,stock_count FROM stockposition INNER JOIN stock ON stock.stock_id = stockposition.stock_id WHERE store_id='$store_select' AND stockposition.stock_count<=reorder_level_store";
    $result_store_select=mysqli_query($conn,$sql_store_select);

//IF THE QUERY RAN
    if($result_store_select){

// CHECK IF THERE IS A STOCK AT ALL
        if(mysqli_num_rows($result_store_select)>0){

            $thead="<thead><tr ><th class='text-center' colspan='8' style='font-size: 2em;'>Stock Refuel&nbsp;(".$store_name."&nbsp;from &nbsp;".$buffer_name.")</th></tr><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th><th>Stock Position</th><th>Reorder Level</th><th>Gap</th><th>Buffer</th><th>Refuel</th></tr></thead>";
// IF THERE IS START TBODY
            $tbody="<tbody>";

// GET THE NUMBER OF THE STOCK I.E THE COUNT
            $stock_number=mysqli_num_rows($result_store_select);

// FETCH EACH RESULT
   while($row_stock=mysqli_fetch_assoc($result_store_select)) {
// GET THE STOCK ID

                if ($row_stock['reorder_level'] != 0) {
   $stock_id[$counter_stock] = $row_stock['stock_id'];
   $gap[$counter_stock] = $row_stock['reorder_level'] - $row_stock['stock_count'];
                    // MAKE THE TBODY HAVE A SERIAL NUMBER

                    // LOOP THRU THE STORES in includeingeneral AND GET THE SUM FOR EACH STOCK
       $sql_buffer = "SELECT reorder_level_store as reorder_buffer,  stock_count as stockcount_buffer  FROM stockposition WHERE  stock_id=$stock_id[$counter_stock] AND store_id=$store_buffer AND stock_count > reorder_level_store";
      $result_buffer = mysqli_query($conn, $sql_buffer);
          if ($result_buffer) {

          $row_buffer = mysqli_fetch_array($result_buffer);
          $buffer = $row_buffer[1] - $row_buffer[0];
   if ($buffer >= 0) {
        $tbody .= "<tr><td>$serial</td><td>" . $row_stock['stock_name'] . "</td><td>" . $row_stock['stock_code'] . "</td><td>" . number_format($row_stock['stock_count']) . "</td><td>" . number_format($row_stock['reorder_level']) . "</td><td>" . number_format($gap[$counter_stock]) . "</td><td>" . number_format($buffer) . "</td>";
         if ($buffer && $buffer >= $gap[$counter_stock]) {
            $tbody .= "<td>" . number_format($gap[$counter_stock]) . "</td>";
                            }
         else {
               $tbody .= "<td>" . number_format($buffer) . "</td>";
                }

            $serial++;
          $tbody .= "<tr>";
         }
         else {

          $tbody .= "<tr><td>$serial</td><td>" . $row_stock['stock_name'] . "</td><td>" . $row_stock['stock_code'] . "</td><td>" . $row_stock['stock_count'] . "</td><td>" . $row_stock['reorder_level'] . "</td><td>" . number_format($gap[$counter_stock]) . "</td><td>" . number_format($buffer) . "</td><td>0</td></tr>";
                        }
                    }

                    //if there is a sum at all


                    $i = 0;


                    //$tbody.="</tr>";


                    $counter_stock++;
                }


                $tbody.="</tbody>";
            }


        }
        else{
            $thead="<thead><tr ><th class='text-center' colspan='8' style='font-size: 2em;'>Stock Refuel&nbsp;(".$store_name."&nbsp;from &nbsp;".$buffer_name.")</th></tr><tr class='info'><th colspan='8' class='text-danger'>Sorry no Stock needs refuel in &nbsp;".$store_name." . Update Stock Count</th></tr></thead>";
        }
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stock Refuel From Suppliers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="row "  xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-hover table-bordered hidden-print" id="table_update">
            <?php echo $thead; //print_r($store_id);?>
            <?php echo $tbody;?>
        </table>


    </div>
</div>
<table class="table table-striped table-hover table-bordered visible-print" style="width: 937px;" id="table_print">
    <?php echo $thead; //print_r($store_id);?>
    <?php echo $tbody;?>
</table>
<script src="js/libs/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/jquery.blockui.js"></script>

</body>
</html>
