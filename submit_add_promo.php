<?php
include "lib/util.php";
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 14/01/2016
 * Time: 4:02 PM
 */
//ini_set("display_errors","1");
//$servername = "localhost";
//$username = "root";
//$password = "Heaven192";
//$dbname = "espread";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$quantity1 = $_POST['quantity1'];
$quantity2 = $_POST['quantity2'];
$quantity_get = $_POST['quantity_get'];
$select1=$_POST['select1'];
$select2=$_POST['select2'];
$select_get=$_POST['select_get'];
$activate_promo=$_POST['activate_promo'];
$block='active';
$empty='';

//FIRST CHECK IF THE TWO SELECTS ARE THE SAME
if($select2 == $select1){
echo 'select';
}
else{
// Check if the quantity 2 was added
    $querycheck="SELECT stock_code,stock_code2 FROM promo WHERE stock_code IN ('$select1','$select2') OR stock_code2 IN ('$select2','$select1')";
    $result2=mysqli_query( $conn, $querycheck);
    if (mysqli_num_rows($result2) > 0){
        echo 'error';
    }
    else{
// Check for the select 2
        if($select2 == 'blank'){
            $quantity2 =0;
            $queryinsert="INSERT INTO promo(stock_code,purchase_qty,stock_code2,purchase_qty2,giveaway_stock,giveaway_qty,promo_status) VALUES ( '$select1', '$quantity1','$empty',$quantity2,'$select_get','$quantity_get','$activate_promo')";
            if(mysqli_query($conn,$queryinsert) ){
                echo  "1";
            }
            else{
                echo "0";
            }
        }
        else{

            $queryinsert="INSERT INTO promo(stock_code,purchase_qty,giveaway_stock,giveaway_qty,stock_code2,purchase_qty2,promo_status,tracker) VALUES ( '$select1', '$quantity1','$select_get','$quantity_get','$select2','$quantity2','$activate_promo',2)";

            if(mysqli_query($conn,$queryinsert) ){
                echo  "1";
            }
            else{
                echo "0";
            }

        }




//To insert  data into stock ledger table




    }
}



