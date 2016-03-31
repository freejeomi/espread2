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
    $stock_id = $_POST['id'];
    $stock_name = $_POST['stock_name'];
    $costprice = $_POST['costprice'];

    //$sales_person_price = $_POST['sales_person_price'];
    $high_purchase = $_POST['high_purchase'];
    $low_purchase = $_POST['low_purchase'];
    $slab = $_POST['slab'];
    $block = $_POST['block'];
    $reorder_level = $_POST['reorder_level'];
    $supplier_name = $_POST['supplier_name'];
    $category_name = $_POST['category'];
    $stock_number = $_POST['stock_number'];
    //$cat_code = $_POST['cat_code'];
    $stock_code = $category_name.'-'.$stock_number;

//    To obtain the Supplier Id
    $supplier =  mysqli_query($conn,"SELECT supplier.supplier_id FROM supplier WHERE supplier.supplier_name='$supplier_name'");

    if (mysqli_num_rows($supplier) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($supplier)) {
            $supplier_id = $row['supplier_id'];
        }}
//    To obtain category id from cat code
    $category =  mysqli_query($conn,"SELECT category.category_id FROM category WHERE category.cat_code='$category_name'");

    if (mysqli_num_rows($category) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($category)) {
            $category_id = $row['category_id'];
        }}

    if (substr($stock_id,0, 3) == "jqg") {
        mysqli_query($conn, "INSERT INTO stock (stock_name,stock_code,costprice,high_purchase,low_purchase,slab,block,reorder_level,supplier_id,category_id)VALUES ('$stock_name','$stock_code','$costprice','$high_purchase','$low_purchase','$slab','$block','$reorder_level','$supplier_id','$category_id')")
        or die(mysqli_error($conn));
    }
    else {
        mysqli_query($conn, "UPDATE stock SET stock_name='$stock_name',stock_code='$stock_code',costprice='$costprice',high_purchase='$high_purchase',low_purchase='$low_purchase',slab='$slab',block='$block',reorder_level='$reorder_level',supplier_id='$supplier_id',category_id='$category_id' where stock_id='$stock_id'")
        or die(mysqli_error($conn));
    }
}

if ($_POST['oper']== "del") {
    $stock_id = $_POST['id'];

    mysqli_query($conn, "DELETE from stock where stock_id='$stock_id'")
    or die(mysqli_error($conn));
}

if ($_POST['oper']== "add") {
    $stock_id = $_POST['id'];
    $stock_name = $_POST['stock_name'];
    //  $description=$_POST['stock_description'];
    $costprice = $_POST['costprice'];
    //$sales_person_price = $_POST['sales_person_price'];
    $high_purchase = $_POST['high_purchase'];
    $low_purchase = $_POST['low_purchase'];
    $slab = $_POST['slab'];
    $block = $_POST['block'];
    $reorder_level = $_POST['reorder_level'];
    $supplier_name = $_POST['supplier_name'];
    $category_name = $_POST['category'];
    $stock_number = $_POST['stock_number'];
    //$cat_code = $_POST['cat_code'];
    $stock_code = $category_name.'-'.$stock_number;

    //    To obtain the Supplier Id
    $supplier =  mysqli_query($conn,"SELECT supplier.supplier_id FROM supplier WHERE supplier.supplier_name='$supplier_name'");

    if (mysqli_num_rows($supplier) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($supplier)) {
            $supplier_id = $row['supplier_id'];
        }}
//    To obtain category name
    $category =  mysqli_query($conn,"SELECT category.category_id FROM category WHERE category.cat_code='$category_name'");

    if (mysqli_num_rows($category) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($category)) {
            $category_id = $row['category_id'];
        }}

    mysqli_query($conn, "INSERT INTO stock (stock_name,stock_code,costprice,high_purchase,low_purchase,slab,block,reorder_level,supplier_id,category_id)VALUES ('$stock_name','$stock_code','$costprice','$high_purchase','$low_purchase','$slab','$block','$reorder_level','$supplier_id','$category_id')")
    or die(mysqli_error($conn));
}
mysqli_close($conn);


?>