<?php
include "lib/util.php";
include "inc/init.php";
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

if ($_SESSION['role_name'] != "superadmin") {
    $query1 = "SELECT role_id,role_name FROM roles WHERE role_name != 'superadmin'";
    $result1 = mysqli_query($conn, $query1);
    $response = '<select>';
    while ($row = mysqli_fetch_array($result1)) {
        $response .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
    }
    $response .= '</select>';
}
else {
    $query1 = "SELECT role_id,role_name FROM roles";
    $result1 = mysqli_query($conn, $query1);
    $response = '<select>';
    while ($row = mysqli_fetch_array($result1)) {
        $response .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
    }
    $response .= '</select>';
}

    echo $response;


