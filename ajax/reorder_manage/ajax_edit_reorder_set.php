<?php
include "../../lib/util.php";

//ini_set("display_errors","1");
//$servername = "localhost";
//$username = "root";
//$password = "Heaven192";
//$dbname = "espread";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//else {
//    echo "connected";
//}
if ($_POST['oper']== "edit") {

    if (isset($_POST['general'])) {
        $stock_id = $_POST['id'];
        $general = $_POST['general'];

         mysqli_query($conn, "UPDATE stock SET reorder_level='$general' WHERE stock_id=$stock_id")or die(mysqli_error($conn));

        $query1 = "SELECT store_id FROM store WHERE useinreorder=1";
        $result1 = mysqli_query($conn, $query1);

        $i = 0;

        if (mysqli_num_rows($result1) > 0) {
            $stores = array();
            $stores_id = array();
            $stores_name = array();

//            SAVE THE STORES
            while ($row = mysqli_fetch_array($result1)) {


                $stores_id[$i] = $row[0];
                $i++;
            }

            //LOOP THROUGH EACH STORE
            foreach ($stores_id as $storeid) {
                //  $_POST[$storeid];
                $result_select = mysqli_query($conn, "SELECT reorder_level_store FROM stockposition WHERE stock_id=$stock_id AND store_id=$storeid");
                if (mysqli_num_rows($result_select) > 0) {
                    mysqli_query($conn, "UPDATE  stockposition SET stockposition.reorder_level_store=$_POST[$storeid] WHERE store_id=$storeid and stockposition.stock_id =$stock_id")or die(mysqli_error($conn));
                } else {
                    mysqli_query($conn, "INSERT INTO stockposition(stock_id, store_id, stock_count, unit, reorder_level_store) VALUES ($stock_id,$storeid,0,0,$_POST[$storeid])")or die(mysqli_error($conn));
                }
            }

        }

    }
}




mysqli_close($conn);


?>