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
 $role_id = $_POST['id'];
 $role_name= $_POST['role_name'];
 $cashstock = $_POST['cashstock'];
 $customer = $_POST['customer'];
 $haulage = $_POST['haulage'];
 $supplier = $_POST['supplier'];
 $invoice = $_POST['invoice'];
 $report = $_POST['report'];
 $stockinventory = $_POST['stockinventory'];
 $acceptpayment = $_POST['accept_payment'];
 $raiseinvoice = $_POST['raise_invoice'];
 $setup = $_POST['setup'];
 if (substr($role_id,0, 3) == "jqg") {
    mysqli_query($conn, "INSERT INTO roles (role_name, menu_invoice, menu_supplier, menu_customer, menu_cashstock, menu_stock, menu_haulage, menu_setup, menu_report, acceptcustomerpayment, raisecreditinvoice)
                 VALUES ('$role_name', '$invoice', '$supplier', '$customer', '$cashstock', '$stockinventory', '$haulage', '$setup', '$report', '$acceptpayment', '$raiseinvoice')")or die(mysqli_error($conn));
 }
else {
    mysqli_query($conn, "UPDATE roles SET role_name='$role_name', menu_invoice='$invoice', menu_supplier= '$supplier', menu_customer= '$customer',
                 menu_cashstock= '$cashstock', menu_stock= '$stockinventory', menu_haulage='$haulage', menu_setup= '$setup', menu_report= '$report',
                 acceptcustomerpayment= '$acceptpayment', raisecreditinvoice= '$raiseinvoice' where role_id='$role_id'") or die(mysqli_error($conn));  
}
}

if ($_POST['oper']== "del") {
 $role_id = $_POST['id'];

 mysqli_query($conn, "DELETE from roles where role_id='$role_id'") or die(mysqli_error($conn));
}

if ($_POST['oper']== "add") {
$role_id = $_POST['id'];
 $role_name= $_POST['role_name'];
 $cashstock = $_POST['cashstock'];
 $customer = $_POST['customer'];
 $haulage = $_POST['haulage'];
 $supplier = $_POST['supplier'];
 $invoice = $_POST['invoice'];
 $report = $_POST['report'];
 $stockinventory = $_POST['stockinventory'];
 $acceptpayment = $_POST['accept_payment'];
 $raiseinvoice = $_POST['raise_invoice'];
 $setup = $_POST['setup'];

mysqli_query($conn, "INSERT INTO roles (role_name, menu_invoice, menu_supplier, menu_customer, menu_cashstock, menu_stock, menu_haulage, menu_setup, menu_report, acceptcustomerpayment, raisecreditinvoice)
                 VALUES ('$role_name', '$invoice', '$supplier', '$customer', '$cashstock', '$stockinventory', '$haulage', '$setup', '$report', '$acceptpayment', '$raiseinvoice')")or die(mysqli_error($conn));
}
 mysqli_close($conn);


?>