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
$count_general=0;
$count_reorder=0;

$stock_count_array=array();
//QUERY FOR STORE
$sql_store="SELECT store_id,store_name FROM store WHERE useinreorder=1";
$result_store=mysqli_query($conn,$sql_store);

//QUERY WAS EXECUTED
if($result_store){

//THERE ARE STORES
    if(mysqli_num_rows($result_store) > 0)
    {

        $number_store=mysqli_num_rows($result_store);
        $thead="<thead id=".$number_store."><tr ><th class='text-center' colspan='".($number_store + 5)."' style='font-size: 2em;'>Reorder Level [Stock Position]</th></tr><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th><th>General</th>";
        while($row_store=mysqli_fetch_assoc($result_store)){
            $thead.="<th>".$row_store['store_name']."</th>";
            $store_id[$counter_store]=$row_store['store_id'];
            $counter_store++;

//END OF WHILE LOOP
        }
        $thead.="</tr></thead>";

    }
    else{
        $thead="<thead id=".$number_store."><tr ><th class='text-center' colspan='".($number_store + 5)."' style='font-size: 2em;'>Reorder Level [Stock Position]<span class='text-danger' style='font-size: 0.8em;font-style:italic'>&nbsp;(No store is included in general)</span></th></tr><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th><th>General</th></tr></thead>";
    }

}
//Get the Stock ID and Name And Stock Code
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
            $tbody.="<tr><td>".$serial."</td><td><input type='hidden' value='".$row_stock['stock_id']."'>".$row_stock['stock_name']."</td><td>".$row_stock['stock_code']."</td>";
            // LOOP THRU THE STORES AND GET THE COUNT FOR EACH STOCK
            $sql_general="SELECT SUM(stock_count) as general_count FROM stockposition INNER JOIN store ON store.store_id = stockposition.store_id  WHERE store.includeingeneral=1 AND stock_id=$stock_id[$counter_stock]";
            $result_general=mysqli_query($conn,$sql_general);
            $row_general=mysqli_fetch_array($result_general);
            if($row_general[0]!==null){
         if($row_general[0] && $row_stock['reorder_level']>=$row_general[0]){
            $tbody.="<td style='color: red;font-weight: bold'>".number_format($row_stock['reorder_level'])."[".number_format($row_general[0]) ."]</td>";
            $count_general++;

            }
            else{
                $tbody.="<td >".$row_stock['reorder_level']."[".number_format($row_general[0]) ."]</td>";
            }
            }
            else{
                if($row_stock['reorder_level']){
                    $tbody.="<td style='color: red;font-weight: bold'>".number_format($row_stock['reorder_level'])."[0]</td>";
                }
                else{
                    $tbody.="<td >".$row_stock['reorder_level']."[0]</td>";
                }

            }
            $i=0;
            foreach($store_id as $store){

//GET THE STOCK COUNT
                $sql_position="SELECT reorder_level_store as reorder_level,stock_count FROM stockposition WHERE stock_id='$stock_id[$counter_stock]' AND store_id='$store'";
                $result_position=mysqli_query($conn,$sql_position);

                // IF THE QUERY RAN....
                if($result_position){
                    // CHECK IF THERE IS A ROW
                    if(mysqli_num_rows($result_position)>0){
                        // GET THE STOCK COUNT AND RUN THROUGH IT AGAIN
                        while($row_position=mysqli_fetch_assoc($result_position)){
                        if($row_position['reorder_level']>0 && $row_position['reorder_level']>=$row_position['stock_count']){

                            $tbody.="<td style='color: red;font-weight: bold'>".$row_position['reorder_level']."[".number_format($row_position['stock_count'])."]</td>";
                            $count_reorder++;
                            $count_general++;
                        }
                        else{$tbody.="<td>".$row_position['reorder_level']."[".number_format($row_position['stock_count'])."]</td>";}

                            //$stock_count_array[$i]=$row_position['stock_count2'];
                        }
                    }

                    // IF THERE IS NO ROW, GIVE THE COUNT AS A ZERO
                    else{
                        $tbody.="<td>0[]</td>";
                        $stock_count_array[$i]=0;
                    }

                }
                $i++;
            }


            $tbody.="</tr>";
            $serial++;


            $counter_stock++;
        }

        $tbody.="</tbody>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Reorder Level</title>
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
