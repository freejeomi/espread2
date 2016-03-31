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

$stock_count_array=array();
//QUERY FOR STORE
$sql_store="SELECT store_id,store_name FROM store";
$result_store=mysqli_query($conn,$sql_store);

//QUERY WAS EXECUTED
if($result_store){

//THERE ARE STORES
    if(mysqli_num_rows($result_store) > 0)
    {
        $thead="<thead ><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th>";
        while($row_store=mysqli_fetch_assoc($result_store)){
            $thead.="<th>".$row_store['store_name']."</th>";
            $store_id[$counter_store]=$row_store['store_id'];
            $counter_store++;

//END OF WHILE LOOP
        }
        $thead.="<th>Total</th></tr></thead>";

    }


}
//Get the Stock ID and Name And Stock Code
$sql_stock="SELECT stock_id,stock_code,stock_name FROM stock";
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
            $tbody.="<tr><td>".$serial."</td><td>".$row_stock['stock_name']."</td><td>".$row_stock['stock_code']."</td>";
            // LOOP THRU THE STORES AND GET THE COUNT FOR EACH STOCK
            $i=0;
            foreach($store_id as $store){

//GET THE STOCK COUNT
                $sql_position="SELECT FORMAT(stock_count,0) as stock_count,stock_count as stock_count2 FROM stockposition WHERE stock_id='$stock_id[$counter_stock]' AND store_id='$store'";
                $result_position=mysqli_query($conn,$sql_position);

                // IF THE QUERY RAN....
                if($result_position){
                    // CHECK IF THERE IS A ROW
                    if(mysqli_num_rows($result_position)>0){
                        // GET THE STOCK COUNT AND RUN THROUGH IT AGAIN
                        while($row_position=mysqli_fetch_assoc($result_position)){
                            $tbody.="<td>".$row_position['stock_count']."</td>";
                            $stock_count_array[$i]=$row_position['stock_count2'];
                        }
                    }

                    // IF THERE IS NO ROW, GIVE THE COUNT AS A ZERO
                    else{
                        $tbody.="<td>0</td>";
                        $stock_count_array[$i]=0;
                    }



                }
                $i++;
            }


            $tbody.="<td>".number_format(array_sum($stock_count_array))."</td></tr>";
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
    <title>Stock Summary</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="row "  xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-hover table-bordered hidden-print">
            <?php echo $thead; //print_r($store_id);?>
            <?php echo $tbody;?>
        </table>


    </div>
</div>
<table class="table table-striped table-hover table-bordered visible-print" style="width: 937px;">
    <?php echo $thead; //print_r($store_id);?>
    <?php echo $tbody;?>
</table>
<script src="js/libs/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
</body>
</html>
