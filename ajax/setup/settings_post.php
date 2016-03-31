<?php
include "../../lib/util.php";
//include "../../rest_function.php";

$email='';
$phone='';
$address='';
$company='';
$start_date='';
$end_date='';
$store='';
$upload='';
$ftp_servername='';
$ftp_serveruser='';
$ftp_serverpassword='';
$sms_username='';
$sms_userpass='';
$company_id=0;
$store_name2="";

 $errors= array();  	// array to hold validation errors
    $data= array();     // array to pass back data

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    if (isset($_POST['email']) && isset($_POST['phone'])) {
        //echo "validate";
         if (empty($_POST['email'])){
            $errors['email']= "email is required";
        }
        elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Please enter a valid email";
        }
        else {
            $email= $_POST['email'];
        }
        if (empty($_POST['phone'])){
            $errors['phone']= "phone number is required";
        }
        else {
            $phone= $_POST['phone'];
       }
        if (empty($_POST['company'])){
            $errors['company']= "company details is required";
        }
        else {
            $company= $_POST['company'];
        }
        // for the EMAIL SMTP VALIDATION
        if (empty($_POST['email_smtp'])){
            $errors['email_smtp']= "Email SMTP is required";
        }
        else {
            $email_smtp= $_POST['email_smtp'];
        }
        if (empty($_POST['email_user'])){
            $errors['email_user']= "SMTP username is required";
        }
        else {
            $email_user= $_POST['email_user'];
        }
        if (empty($_POST['email_pass'])){
            $errors['email_pass']= "SMTP password is required";
        }
        else {
            $email_pass= $_POST['email_pass'];
        }
        // FOR THE FTP VALIDATION
        if (empty($_POST['ftp_servername'])){
            $errors['ftp_servername']= "Ftp server name is required";
        }
        else {
            $ftp_servername= $_POST['ftp_servername'];
        }
        if (empty($_POST['ftp_serveruser'])){
            $errors['ftp_serveruser']= "Server username is required";
        }
        else {
            $ftp_serveruser= $_POST['ftp_serveruser'];
        }
        if (empty($_POST['ftp_serverpassword'])){
            $errors['ftp_serverpassword']= "server password is required";
        }
        else {
            $ftp_serverpassword= $_POST['ftp_serverpassword'];
        }

        // FOR THE SMS  USERNAME AND PASSWORD
        if (empty($_POST['sms_username'])){
            $errors['sms_username']= "Sms Username is required";
        }
        else {
            $sms_username= $_POST['sms_username'];
        }
        if (empty($_POST['sms_userpass'])){
            $errors['sms_userpass']= "Sms Password is required";
        }
        else {
            $sms_userpass= $_POST['sms_userpass'];
        }
        if (empty($_POST['upload'])){
            $errors['upload']= "upload url is required";
        }
        elseif (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['upload'])) {
            $errors['upload'] = "enter url in this format: 'www.mywebsite.com'";
        }
        else {
            $upload= $_POST['upload'];
        
       }
       if (empty($_POST['address'])){
            $errors['address']= "address details is required";
        }
        else {
            $address= $_POST['address'];
        }
        if (empty($_POST['store'])){
            $errors['store']= "specify the required store";
        }
        else if ($_POST['store'] == "none"){
            $errors['store']= "specify the required store";
        }
        else {
            $store= $_POST['store'];
       } 
        if (empty($_POST['start_date'])){
            $errors['startdate']= "specify the start date ";
        }
        else {
            $start_date= $_POST['start_date'];
        }

        if (empty($_POST['end_date'])){
            $errors['finishdate']= "specify the end date";
        }
        else {
            $end_date= $_POST['end_date'];
        }
         if ( ! empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        }
         //there is no error in the input
         //record does not exist so update
         else {
             $result_settings= mysqli_query($conn, "select * from settings");
             if (mysqli_num_rows($result_settings) < 1) {

                 if (is_numeric($store)) {
                     //insert into settings table
                     $result_settings = mysqli_query($conn, "INSERT INTO settings(company_name, company_address, company_email, company_phone, accounting_year_start, accounting_year_end, retail_store,upload_url,ftp_server_name,ftp_server_user,ftp_server_password,sms_username,sms_password,company_id) VALUES('$company', '$address', '$email', '$phone', '$start_date','$end_date','$store_id','$upload','$ftp_servername','$ftp_serveruser','$ftp_serverpassword','$sms_username','$sms_userpass','$company_id')");
                     if (!$result_settings) {
                         $data['message'] = "Oops. something went wrong while inserting settings ";
                         $data['success'] = false;
                     } else {
                         $data['success'] = true;
                     }
                 } else {
                     //store coming in is a string, insert into store table, retrieve id of last inserted and insert into settings
                     $empty = '';
                     $retail = 1;
                     $result_store = mysqli_query($conn, "INSERT into store (store_name, location, retailoutlet) values ('$store', '$empty', '$retail') ");
                     if (!$result_store) {
                         $data['message'] = "could not insert into store";
                         $data['success'] = false;
                     } else {
                         $store_id = mysqli_insert_id($conn);
                         //echo $store_id;
                         //insert into settings table
                         $result_settings = mysqli_query($conn, "INSERT INTO settings(company_name, company_address, company_email, company_phone, accounting_year_start, accounting_year_end, retail_store,upload_url,ftp_server_name,ftp_server_user,ftp_server_password,sms_username,sms_password,company_id,email_smtp,email_user,email_pass) VALUES ('$company', '$address', '$email', '$phone', '$start_date','$end_date','$store_id','$upload','$ftp_servername','$ftp_serveruser','$ftp_serverpassword','$sms_username','$sms_userpass','$company_id','$email_smtp','$email_user','$email_pass')");
                         if (!$result_settings) {
                             $data['message'] = "Oops. something went wrong while inserting settings";
                             $data['success'] = false;
                         } else {
                             $data['success'] = true;
                         }
                     }
                 }
            }
            else {
                $result_settings= mysqli_query($conn, "update settings set company_name= '$company', company_address= '$address', company_email= '$email', company_phone= '$phone', accounting_year_start= '$start_date', accounting_year_end='$end_date', retail_store= '$store', ftp_server_user= '$ftp_serveruser', upload_url= '$upload', ftp_server_name='$ftp_servername', ftp_server_password= '$ftp_serverpassword', sms_username='$sms_username', sms_password= '$sms_userpass',email_smtp='$email_smtp',email_user='$email_user',email_pass='$email_pass' WHERE check_= 1");
                if (!$result_settings) {
                    $data['message'] = "Oops. something went wrong while updating settings ";
                    $data['success'] = false;
                }
                else {
                    $data['success'] = true;
                }
            }
         }
         echo json_encode($data);  
    }
    mysqli_close($conn);
?>