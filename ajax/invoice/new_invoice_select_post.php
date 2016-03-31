<?php
    $errors         = array();  	// array to hold validation errors
    $data 			= array();      // array to pass back data
    $invoiceitems   = array();
    $promo = array();
    include "../../lib/util.php";
require_once "../inc/init.php";
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }   
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if ($_POST['customer']=="none"){
            $errors['customer']= "select a customer";
        }
        else {
            $customer= $_POST['customer'];
        }
        
        if ($_POST['payment']=="none") {
            $errors['payment'] = 'select a payment type';
        }        
        else {
            $payment = $_POST['payment'];
        }
        
        if ($_POST['store']== "none") {
            $errors['store'] = 'Select a store.'; 
        }
        else{
            $store= $_POST['store'];            
        }
        if (empty($_POST['user_id'])) {
            $errors['user_id'] = 'Cannot decipher the user';
        }
        else{
            $userid= $_POST['user_id'];
        }

        $date= date("y/m/d");         
        $time= date("h:i:s");
        
        $empty= "";
        //$userid= 26;
            
        if ( ! empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        }
        else {
            if ($_SESSION['role_name'] != "superadmin") {
                $result_log = mysqli_query($conn, "SELECT upload_date FROM upload_log where upload_date= '$date' AND status = 0");
                if (mysqli_num_rows($result_log) == 0) {
                    $sql = "INSERT INTO salesinvoice_daily (sales_date, sales_time, store, payment_type, cashier, user_id, customer_id) VALUES ('$date', '$time', '$store', '$payment', '$empty', '$userid', '$customer')";
                    if (!mysqli_query($conn, $sql)) {
                        $data['message'] = "Oops. something went wrong while inserting into database. please try again";
                    } else {
                        $last_id = mysqli_insert_id($conn);

                        $sql = "SELECT invoice_num, customer.customer_name, store.store_name, payment_type FROM salesinvoice_daily INNER JOIN customer on customer.customer_id= salesinvoice_daily.customer_id INNER JOIN store on store.store_id= salesinvoice_daily.store where invoice_num= $last_id";
                        $result = mysqli_query($conn, $sql);
                        if (!$result) {
                            $data['message'] = "Oops. something went wrong while retrieving from database. please try again";
                        } else {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $data['customer'] = $row['customer_name'];
                                $data['invoice_num'] = $row['invoice_num'];
                                $data['store'] = $row['store_name'];
                                $data['payment'] = $row['payment_type'];

                                $data['success'] = true;
                            }
                        }
                    }

                }
                else {
                    $data['locked'] = "Sorry, you are unable to carry out transaction until the next business day";
                    $data['success'] = true;
                }
            }
            else {
                $sql = "INSERT INTO salesinvoice_daily (sales_date, sales_time, store, payment_type, cashier, user_id, customer_id) VALUES ('$date', '$time', '$store', '$payment', '$empty', '$userid', '$customer')";
                if (!mysqli_query($conn, $sql)) {
                    $data['message'] = "Oops. something went wrong while inserting into database. please try again";
                } else {
                    $last_id = mysqli_insert_id($conn);

                    $sql = "SELECT invoice_num, customer.customer_name, store.store_name, payment_type FROM salesinvoice_daily INNER JOIN customer on customer.customer_id= salesinvoice_daily.customer_id INNER JOIN store on store.store_id= salesinvoice_daily.store where invoice_num= $last_id";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        $data['message'] = "Oops. something went wrong while retrieving from database. please try again";
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $data['customer'] = $row['customer_name'];
                            $data['invoice_num'] = $row['invoice_num'];
                            $data['store'] = $row['store_name'];
                            $data['payment'] = $row['payment_type'];

                            $data['success'] = true;
                        }
                    }
                }
            }
        }      
        echo json_encode($data);
    }    
    mysqli_close($conn);        
?>