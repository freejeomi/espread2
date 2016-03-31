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
    $store_id = $_POST['id'];
    $store_name = $_POST['store_name'];
    $location = $_POST['location'];
    $includeingeneral = $_POST['includeingeneral'];
    $useinreorder = $_POST['useinreorder'];
    $indicatemainstore = $_POST['indicatemainstore'];

    $retailoutlet = $_POST['retailoutlet'];

    if (substr($store_id,0, 3) == "jqg") {
        mysqli_query($conn, "INSERT INTO store (store_name, location, includeingeneral,useinreorder,indicatemainstore,retailoutlet)VALUES ('$store_name', '$location', '$includeingeneral','$useinreorder','$indicatemainstore','$retailoutlet')")
        or die(mysqli_error($conn));
    }
    else {
        mysqli_query($conn, "UPDATE store SET store_name='$store_name',location='$location',includeingeneral='$includeingeneral',useinreorder='$useinreorder',indicatemainstore='$indicatemainstore',retailoutlet='$retailoutlet ' where store_id='$store_id'")
        or die(mysqli_error($conn));
    }
}

if ($_POST['oper']== "del") {
    $store_id = $_POST['id'];

    mysqli_query($conn, "DELETE from store where store_id='$store_id'")
    or die(mysqli_error($conn));
}

if ($_POST['oper']== "add") {
    $store_id = $_POST['id'];
    $store_name = $_POST['store_name'];
    $location = $_POST['location'];
    $includeingeneral = $_POST['includeingeneral'];
    $useinreorder = $_POST['useinreorder'];
    $indicatemainstore = $_POST['indicatemainstore'];
    $retailoutlet = $_POST['retailoutlet'];

    mysqli_query($conn, "INSERT INTO store (store_name, location, includeingeneral,useinreorder,indicatemainstore,retailoutlet)VALUES ('$store_name', '$location', '$includeingeneral','$useinreorder','$indicatemainstore','$retailoutlet')")
    or die(mysqli_error($conn));
}
mysqli_close($conn);


?>