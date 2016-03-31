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
    $customer_id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $customer_type = $_POST['customer_type'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];



    if (substr($customer_id,0, 3) == "jqg") {
        mysqli_query($conn, "INSERT INTO customer (customer_name, customer_type, phone, email)VALUES ('$customer_name', '$customer_type', '$phone', '$email')")
        or die(mysqli_error($conn));
    }
    else {
        mysqli_query($conn, "UPDATE customer SET customer_name='$customer_name',customer_type='$customer_type',phone='$phone',email='$email'where customer_id='$customer_id'")
        or die(mysqli_error($conn));
    }
}

if ($_POST['oper']== "del") {
    $customer_id = $_POST['id'];
    if ($customer_id != 1) {
        mysqli_query($conn, "DELETE from customer where customer_id='$customer_id'")
        or die(mysqli_error($conn));
    }
}

if ($_POST['oper']== "add") {
    $customer_id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $customer_type = $_POST['customer_type'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    mysqli_query($conn, "INSERT INTO customer (customer_name, customer_type,phone,email)VALUES ('$customer_name', '$customer_type','$phone','$email')")
    or die(mysqli_error($conn));
}
mysqli_close($conn);


?>