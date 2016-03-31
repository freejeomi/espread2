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
    $vehicle_id = $_POST['id'];
    $vehicle_number = $_POST['vehicle_number'];
    $vehicle_name = $_POST['vehicle_name'];
    $balance = $_POST['balance'];


    if (substr($vehicle_id,0, 3) == "jqg") {
        mysqli_query($conn, "INSERT INTO vehicle (vehicle_number, vehicle_name, balance)VALUES ('$vehicle_number', '$vehicle_name', '$balance')")
        or die(mysqli_error($conn));
    }
    else {
        mysqli_query($conn, "UPDATE vehicle SET vehicle_number='$vehicle_number',vehicle_name='$vehicle_name',balance='$balance' where vehicle_id='$vehicle_id'")
        or die(mysqli_error($conn));
    }
}

if ($_POST['oper']== "del") {
    $vehicle_id = $_POST['id'];

    mysqli_query($conn, "DELETE from vehicle where vehicle_id='$vehicle_id'")
    or die(mysqli_error($conn));
}

if ($_POST['oper']== "add") {
    $vehicle_number = $_POST['vehicle_number'];
    $vehicle_name = $_POST['vehicle_name'];
    $balance = $_POST['balance'];

    mysqli_query($conn, "INSERT INTO vehicle (vehicle_number, vehicle_name, balance)VALUES ('$vehicle_number', '$vehicle_name', '$balance')")
    or die(mysqli_error($conn));
}
mysqli_close($conn);


?>