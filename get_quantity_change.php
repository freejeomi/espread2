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

$quantity = $_POST['quantity'];




$query1 = "SELECT stock_count FROM stockposition WHERE stock_id='$stock_id' AND store_id='$store_id'";
$result1 = mysqli_query($conn,$query1);
$response='';
while($row = mysqli_fetch_array($result1)) {
    $response.=$row[0];
}


echo $response;
