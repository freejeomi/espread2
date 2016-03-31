<?php

require_once("../inc/init.php");
require_once("../../oneapi/client.php");

include "../../lib/util.php";
include "../../rest_function_sms.php";


$company_name= "";
$company_email= "";
$sms_username= "";
$sms_password= "";
$upload_url= "";

$cus_id = "";
$cus_name = "";
$cus_phone = "";
$amount_owed = "";

$cus_id_array = array();
$cus_name_array = array();
$cus_email_array = array();
$amount_owed_array = array();

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function add_http($url)
{
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }

    return $url;
}
//query the settings table to get the necessary details for sms sending
$result_sql = mysqli_query($conn, "SELECT company_name,company_email, upload_url, sms_username, sms_password from settings");
if (mysqli_num_rows($result_sql) > 0) {
    $row= mysqli_fetch_assoc($result_sql);
    $company_name = $row['company_name'];
    $company_email = $row['company_email'];
    $upload_url= $row['upload_url'];
    $upload_url = add_http($upload_url);
    //echo $upload_url;
    $sms_username= $row['sms_username'];
    $sms_password= $row['sms_password'];

    if (isset($_POST['cus_id'])) {

        $cus_id = $_POST['cus_id'];
        $cus_name = $_POST['name'];
        $cus_phone = $_POST['phone'];
        $amount_owed= str_replace(',', '', $_POST['amount']);
        $amount_owed = 0 - $amount_owed;


        if (!empty($cus_phone) && $cus_phone != "") {   //customer phone number is present
            //send paramenters to the sms server processing page online via rest
//            echo $sms_password;
//            echo $sms_username;
//            echo $company_name;
//            echo $cus_name;
//            echo $cus_phone;
//            echo $amount_owed;
            $rest_result= rest_func_sms($upload_url, $sms_username, $sms_password, $amount_owed, $cus_phone, $cus_name, $company_name);

            if($rest_result == "success") {  //sms sending was successful
                echo "sms successful";
            }
            elseif ($rest_result == "failed") {                          //sms sending failed
                echo "sms failed";
            }
            elseif ($rest_result == "no settings") {
                echo "no settings";
            }
            else {
                echo $rest_result;
            }
        }
        else {                              //customer phone number is absent
            echo 'no number';
        }
    }
}
else {
    echo 'no settings';
}