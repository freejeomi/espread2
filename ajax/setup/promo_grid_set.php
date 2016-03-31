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

// If the operation is edit operation
if ($_POST['oper']== "edit") {
    $promo_id = $_POST['id'];
    $giveaway_quantity = $_POST['giveaway_qty'];
    $giveaway_stock = $_POST['giveaway_stock'];
    $promo_status = $_POST['promo_status'];

    $purchase_qty = $_POST['purchase_qty'];
    $purchase_qty2 = $_POST['purchase_qty2'];
    $stock_name = $_POST['stock_code'];
    $stock_name2 = $_POST['stock_code2'];


    // check that the product has not been used in a promo before


        //check that the stock name is not blank
        if($stock_name2 == 'blank'){

                mysqli_query($conn, "UPDATE promo SET purchase_qty='$purchase_qty',giveaway_stock='$giveaway_stock',giveaway_qty='$giveaway_quantity',promo_status='$promo_status' where promo_id='$promo_id'")
                or die(mysqli_error($conn));

        }
        else{
            //perform normal edit operation
    if (substr($promo_id,0, 3) == "jqg") {
        mysqli_query($conn, "INSERT INTO promo(stock_code,purchase_qty,giveaway_stock,giveaway_qty,stock_code2,purchase_qty2,promo_status) VALUES ( '$stock_name', '$purchase_qty','$giveaway_stock','$giveaway_quantity','$stock_name2','$purchase_qty2','$promo_status')")
        or die(mysqli_error($conn));
    }
    else {
        mysqli_query($conn, "UPDATE promo SET purchase_qty='$purchase_qty',giveaway_stock='$giveaway_stock',giveaway_qty='$giveaway_quantity',purchase_qty2='$purchase_qty2',promo_status='$promo_status' where promo_id='$promo_id'")
        or die(mysqli_error($conn));
    }
        }

}

if ($_POST['oper']== "del") {
    $promo_id = $_POST['id'];

    mysqli_query($conn, "DELETE from promo where promo_id='$promo_id'")
    or die(mysqli_error($conn));
}

if ($_POST['oper']== "add") {
    $promo_id = $_POST['id'];
    $giveaway_quantity = $_POST['giveaway_qty'];
    $giveaway_stock = $_POST['giveaway_stock'];
    $promo_status = $_POST['promo_status'];

    $purchase_qty = $_POST['purchase_qty'];
    $purchase_qty2 = $_POST['purchase_qty2'];
    $stock_name = $_POST['stock_name'];
    $stock_name2 = $_POST['stock_name2'];



    mysqli_query($conn, "INSERT INTO promo(stock_code,purchase_qty,giveaway_stock,giveaway_qty,stock_code2,purchase_qty2,promo_status) VALUES ( '$stock_name', '$purchase_qty','$giveaway_stock','$giveaway_quantity','$stock_name2','$purchase_qty2','$promo_status')")
    or die(mysqli_error($conn));
}
mysqli_close($conn);


?>