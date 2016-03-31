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
    $category_id = $_POST['id'];

    $category_name = $_POST['category_name'];
    $cat_code = $_POST['cat_code'];



    if (substr($category_id,0, 3) == "jqg") {
        mysqli_query($conn, "INSERT INTO category (category_name,cat_code)VALUES ('$category_name','$cat_code')")
        or die(mysqli_error($conn));
    }
    else {
        mysqli_query($conn, "UPDATE category SET category_name='$category_name',cat_code='$cat_code' where category_id='$category_id'")
        or die(mysqli_error($conn));
    }
}

if ($_POST['oper']== "del") {
    $category_id = $_POST['id'];

    mysqli_query($conn, "DELETE from category where category_id='$category_id'")
    or die(mysqli_error($conn));
}

if ($_POST['oper']== "add") {

    $category_name = $_POST['category_name'];
    $cat_code = $_POST['cat_code'];


    mysqli_query($conn, "INSERT INTO category (category_name,cat_code)VALUES ('$category_name','$cat_code')")
    or die(mysqsli_error($conn));
}
mysqli_close($conn);


?>