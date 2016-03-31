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
    $cashier_id = $_POST['id'];
    $cashier_name = $_POST['cashier_name'];


    if (substr($cashier_id,0, 3) == "jqg") {
        mysqli_query($conn, "INSERT INTO cashier (cashier_name)VALUES ('$cashier_name')")
        or die(mysqli_error($conn));
    }
    else {
        mysqli_query($conn, "UPDATE cashier SET cashier_name='$cashier_name' where cashier_id='$cashier_id'")
        or die(mysqli_error($conn));
    }
}

if ($_POST['oper']== "del") {
    $cashier_id = $_POST['id'];

    mysqli_query($conn, "DELETE from cashier where cashier_id='$cashier_id'")
    or die(mysqli_error($conn));
}

if ($_POST['oper']== "add") {
    $cashier_name = $_POST['cashier_name'];


    mysqli_query($conn, "INSERT INTO cashier (cashier_name)VALUES ('$cashier_name')")
    or die(mysqli_error($conn));
}
mysqli_close($conn);


?>