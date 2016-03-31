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
 $supplier_id = $_POST['id'];
 $supplier_name = $_POST['supplier_name'];
 $supplier_email = $_POST['supplier_email'];
 $supplier_phone = $_POST['supplier_phone'];
 $supplier_address = $_POST['supplier_address'];
 $supplier_city = $_POST['supplier_city'];
 $supplier_state=$_POST['supplier_state'];
 $supplier_country = $_POST['supplier_country'];
 
 $username = $_POST['username'];
 $dateregistered = date('Y/m/d');

 if (substr($supplier_id,0, 3) == "jqg") {
    mysqli_query($conn, "INSERT INTO supplier(supplier_name,supplier_email,supplier_phone,supplier_address,supplier_city,supplier_state,supplier_country,dateregistered,user_id) VALUES ( '$supplier_name', '$supplier_email','$supplier_phone','$supplier_address','$supplier_city','$supplier_state','$supplier_country','$dateregistered','$username')")
    or die(mysqli_error($conn));
 }
else {
    mysqli_query($conn, "UPDATE supplier SET supplier_name='$supplier_name',supplier_email='$supplier_email',supplier_phone='$supplier_phone',supplier_address='$supplier_address',supplier_city='$supplier_city',supplier_state='$supplier_state',supplier_country='$supplier_country',dateregistered='$dateregistered',user_id='$username' where supplier_id='$supplier_id'")
 or die(mysqli_error($conn));  
}
}

if ($_POST['oper']== "del") {
 $supplier_id = $_POST['id'];

 mysqli_query($conn, "DELETE from supplier where supplier_id='$supplier_id'")
 or die(mysqli_error($conn));
}

if ($_POST['oper']== "add") {
 //$supplier_id = $_POST['supplier_id'];
 $supplier_name = $_POST['supplier_name'];
 $supplier_email = $_POST['supplier_email'];
 $supplier_phone = $_POST['supplier_phone'];
 $supplier_address = $_POST['supplier_address'];
 $supplier_city = $_POST['supplier_city'];
 $supplier_state=$_POST['supplier_state'];
 $supplier_country = $_POST['supplier_country'];
 
 $username = $_POST['username'];
 $dateregistered = date('Y/m/d');

 mysqli_query($conn, "INSERT INTO supplier(supplier_name,supplier_email,supplier_phone,supplier_address,supplier_city,supplier_state,supplier_country,dateregistered,user_id) VALUES ( '$supplier_name', '$supplier_email','$supplier_phone','$supplier_address','$supplier_city','$supplier_state','$supplier_country','$dateregistered','$username')")
 or die(mysqli_error($conn));
}
 mysqli_close($conn);


?>