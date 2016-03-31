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

$store_id=array();
$store_name=array();
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

$stock_count_array=array();
//QUERY FOR STORE
$sql_store="SELECT store_id,store_name FROM store WHERE includeingeneral=1";
$result_store=mysqli_query($conn,$sql_store);

//QUERY WAS EXECUTED
if($result_store){

//THERE ARE STORES
    if(mysqli_num_rows($result_store) > 0)
    {
        $number_store=mysqli_num_rows($result_store);
        $thead="<thead id=".$number_store."><tr ><th class='text-center ' colspan='".($number_store + 5)."' style='font-size: 2em;'>Stock Refuel From Supplier(s)&nbsp;";
        while($row_store=mysqli_fetch_assoc($result_store)){
            $thead.="|<span style='font-size: 0.8em;'>".$row_store['store_name']."&nbsp;</span>";
            $store_id[$counter_store]=$row_store['store_id'];
            $counter_store++;

//END OF WHILE LOOP
        }
        $thead.="</th></tr><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th><th>Stockposition</th><th>Reorder level</th><th>GAP</th></tr></thead>";

        //DO FOR THE STOCK TABLE
        $sql_stock="SELECT stock_id,stock_code,stock_name,reorder_level FROM stock";
        $result_stock=mysqli_query($conn,$sql_stock);

//IF THE QUERY RAN
        if($result_stock){
// CHECK IF THERE IS A STOCK AT ALL
            if(mysqli_num_rows($result_stock)>0){

// IF THERE IS START TBODY
                $tbody="<tbody>";

// GET THE NUMBER OF THE STOCK I.E THE COUNT
                $stock_number=mysqli_num_rows($result_stock);

// FETCH EACH RESULT
                while($row_stock=mysqli_fetch_assoc($result_stock)){
// GET THE STOCK ID
                    $stock_id[$counter_stock]=$row_stock['stock_id'];

                    // MAKE THE TBODY HAVE A SERIAL NUMBER

                    // LOOP THRU THE STORES in includeingeneral AND GET THE SUM FOR EACH STOCK
                    $sql_general="SELECT SUM(stock_count) as general_count FROM stockposition INNER JOIN store ON store.store_id = stockposition.store_id  WHERE store.includeingeneral=1 AND stock_id=$stock_id[$counter_stock]";
                    $result_general=mysqli_query($conn,$sql_general);
                    $row_general=mysqli_fetch_array($result_general);
                    //if there is a sum at all

                    if($row_general[0]!==null){
                        //check if there is a reorder level and it is greater than that the total stock count
                        if( $row_stock['reorder_level']&&$row_stock['reorder_level']>=$row_general[0]){
//                 if it is, append a row to it
                            $tbody.="<tr><td>".$serial."</td><td><input type='hidden' value='".$row_stock['stock_id']."'>".$row_stock['stock_name']."</td><td>".$row_stock['stock_code']."</td>";
                            $tbody.="<td >".number_format($row_general[0]) ."</td>";
                            $tbody.="<td >".number_format($row_stock['reorder_level']) ."</td>";
                            $tbody.="<td >".number_format($row_stock['reorder_level'] - $row_general[0]) ."</td>";
                            $serial++;
                        }

                    }
                    else{
//            that means the there is no stock count for that stock yet
                        if( $row_stock['reorder_level']){
                            // if there is actually a reorder level do these
                            $tbody.="<tr><td>".$serial."</td><td><input type='hidden' value='".$row_stock['stock_id']."'>".$row_stock['stock_name']."</td><td>".$row_stock['stock_code']."</td>";
                            $tbody.="<td >0</td>";
                            $tbody.="<td >".number_format($row_stock['reorder_level']) ."</td><td>".number_format($row_stock['reorder_level']) ."</td>";
                            $serial++;
                        }

                    }
                    $i=0;





                    $tbody.="</tr>";



                    $counter_stock++;
                }

                $tbody.="</tbody>";
            }

        }
    }
else{
    $thead="<thead id='0'><tr ><th class='text-center' colspan='6' style='font-size: 2em;'>Stock Refuel From Supplier(s)&nbsp;<span class='text-danger' style='font-size: 0.8em; font-style: italic'>No store to include in general</span></th></tr><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th><th>Stockposition</th><th>Reorder level</th><th>GAP</th></tr></thead>";
}

}
//Get the Stock ID and Name And Stock Code


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reorder Gap</title>
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
