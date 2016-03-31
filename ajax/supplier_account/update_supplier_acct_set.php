<?php
    $errors         = array();  	// array to hold validation errors
    $data 			= array(); 		// array to pass back data
   
    
    include "../../lib/util.php";
    require_once( "../inc/init.php");



// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }   
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if ($_POST['supplier']=="none"){
            $errors['supplier']= "select a supplier";
        }
        else {
            $supplier= $_POST['supplier'];
        }
        
        if (empty($_POST['amount'])) {
            $errors['amount'] = 'Amount is required.';
        }
        else if (!is_numeric($_POST['amount'])){
            $errors['amount'] = 'Enter a valid amount.';
        }
        else {
            $amount = $_POST['amount'];
            $amt_calc= $_POST['amount'];
        }
        
        if ($_POST['transaction']== "none") {
            $errors['transaction'] = 'Select a payment type.'; 
        }
        else{
            $payment= $_POST['transaction'];            
        }
        
        if (empty($_POST['ref'])) {
            $errors['ref'] = 'type in the ref.'; 
        }
        else{
            $ref= $_POST['ref'];            
        }
        if (empty($_POST['user_id'])) {
            $errors['user_id'] = 'User cannot be verified. Try login in again';
        }
        else{
            $userid= $_POST['user_id'];
        }
    //$name= $_POST['name'];                
            //$sup_id = $_GET['sup_Id'];              
            $remark= $_POST['remark'];
            $transaction= "supplier payment";
            
            
            $debitcash= $_POST['debit_cash'];
            //date_default_timezone_set("Africa/Lagos");
            $date = date("Y/m/d");
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
                    $result_bal = mysqli_query($conn, "SELECT amount from cashstock where transaction_type='opening balance' and date='$date'");
                    if (mysqli_num_rows($result_bal) > 0) {
                        $row = mysqli_fetch_assoc($result_bal);
                        $opbal_ = $row['amount'];
                    } else {
                        $opbal_ = 0.00;
                    }
                    $result_cashin = mysqli_query($conn, "SELECT sum(amount) as cashin from cashstock where amount > 0 and transaction_type !='opening balance' and date= '$date'");
                    if (mysqli_num_rows($result_cashin) > 0) {
                        $row = mysqli_fetch_assoc($result_cashin);
                        if ($row['cashin']) {
                            $cashin = $row['cashin'];
                        } else {
                            $cashin = 0.00;
                        }
                    } else {
                        $cashin = 0.00;
                    }
                    $result_cashout = mysqli_query($conn, "SELECT sum(amount) as cashout from cashstock where amount < 0 and transaction_type != 'customer payment' and date= '$date' ");
                    if (mysqli_num_rows($result_cashout) > 0) {
                        $row = mysqli_fetch_assoc($result_cashout);
                        if ($row['cashout']) {
                            $cashout = $row['cashout'];
                        } else {
                            $cashout = 0.00;
                        }
                    } else {
                        $cashout = 0.00;
                    }
                    $balance = $opbal_ + $cashin + $cashout;


                    if ($payment == "delivery") {
                        $sql = "INSERT INTO supplier_account (amount, payment_date, payment_time, payment_type, transaction_type, ref, remark, supplier_id, user_id) VALUES('$amount', '$date', '$time', '$payment', '$transaction', '$ref', '$remark', '$supplier', '$userid')";

                        if (!mysqli_query($conn, $sql)) {
                            $data['message'] = "Oops. something went wrong. please try again";
                        }
                        $data['success'] = true;
                    } //enter here if debit my cash stock is unchecked and payment type is payment
                    elseif ($payment == "payment" && $debitcash == "off") {
                        $amount = 0 - $amount;
                        $sql = "INSERT INTO supplier_account (amount, payment_date, payment_time, payment_type, transaction_type, ref, remark, supplier_id, user_id) VALUES('$amount', '$date', '$time', '$payment', '$transaction', '$ref', '$remark', '$supplier', '$userid')";

                        if (!mysqli_query($conn, $sql)) {
                            $data['message'] = "Oops. something went wrong. please try again";
                        }
                        $data['success'] = true;
                    } else {
                        $amount = 0 - $amount;
                        if ($amt_calc > $balance) {
                            $data['success'] = true;
                            $data['error_message'] = "Sorry, you do not have enough in your account to perform this transaction";
                        } else {
                            $sql = "INSERT INTO supplier_account (amount, payment_date, payment_time, payment_type, transaction_type, ref, remark, supplier_id, user_id) VALUES('$amount', '$date', '$time', '$payment', '$transaction', '$ref', '$remark', '$supplier', '$userid')";
                            if (!mysqli_query($conn, $sql)) {
                                $data['message'] = "Oops. something went wrong. please try again";
                            } else {
                                $data['message'] = "successful inserting into supplier account table";

                                $result_name = mysqli_query($conn, "SELECT supplier_name FROM supplier where supplier_id= $supplier");
                                if (mysqli_num_rows($result_name) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_name)) {
                                        $supplier_name = $row['supplier_name'];
                                    }
                                }
                                //$amount= 0 - $amount;
                                $sql = "INSERT INTO cashstock (date, particulars, ref_code, amount, remark, time, payment_type, transaction_type, user_Id) VALUES('$date', '$supplier_name', '$ref', '$amount', '$remark', '$time','$payment', '$transaction', '$userid')";
                                if (!mysqli_query($conn, $sql)) {
                                    $data['message'] = "Oops. something went wrong. please try again";
                                } else {
                                    $data['message'] = "successful inserting into cash stock table";
                                    $data['time'] = $time;
                                }

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
                $result_bal = mysqli_query($conn, "SELECT amount from cashstock where transaction_type='opening balance' and date='$date'");
                if (mysqli_num_rows($result_bal) > 0) {
                    $row = mysqli_fetch_assoc($result_bal);
                    $opbal_ = $row['amount'];
                } else {
                    $opbal_ = 0.00;
                }
                $result_cashin = mysqli_query($conn, "SELECT sum(amount) as cashin from cashstock where amount > 0 and transaction_type !='opening balance' and date= '$date'");
                if (mysqli_num_rows($result_cashin) > 0) {
                    $row = mysqli_fetch_assoc($result_cashin);
                    if ($row['cashin']) {
                        $cashin = $row['cashin'];
                    } else {
                        $cashin = 0.00;
                    }
                } else {
                    $cashin = 0.00;
                }
                $result_cashout = mysqli_query($conn, "SELECT sum(amount) as cashout from cashstock where amount < 0 and transaction_type != 'customer payment' and date= '$date' ");
                if (mysqli_num_rows($result_cashout) > 0) {
                    $row = mysqli_fetch_assoc($result_cashout);
                    if ($row['cashout']) {
                        $cashout = $row['cashout'];
                    } else {
                        $cashout = 0.00;
                    }
                } else {
                    $cashout = 0.00;
                }
                $balance = $opbal_ + $cashin + $cashout;


                if ($payment == "delivery") {
                    $sql = "INSERT INTO supplier_account (amount, payment_date, payment_time, payment_type, transaction_type, ref, remark, supplier_id, user_id) VALUES('$amount', '$date', '$time', '$payment', '$transaction', '$ref', '$remark', '$supplier', '$userid')";

                    if (!mysqli_query($conn, $sql)) {
                        $data['message'] = "Oops. something went wrong. please try again";
                    }
                    $data['success'] = true;
                } //enter here if debit my cash stock is unchecked and payment type is payment
                elseif ($payment == "payment" && $debitcash == "off") {
                    $amount = 0 - $amount;
                    $sql = "INSERT INTO supplier_account (amount, payment_date, payment_time, payment_type, transaction_type, ref, remark, supplier_id, user_id) VALUES('$amount', '$date', '$time', '$payment', '$transaction', '$ref', '$remark', '$supplier', '$userid')";

                    if (!mysqli_query($conn, $sql)) {
                        $data['message'] = "Oops. something went wrong. please try again";
                    }
                    $data['success'] = true;
                } else {
                    $amount = 0 - $amount;
                    if ($amt_calc > $balance) {
                        $data['success'] = true;
                        $data['error_message'] = "Sorry, you do not have enough in your account to perform this transaction";
                    } else {
                        $sql = "INSERT INTO supplier_account (amount, payment_date, payment_time, payment_type, transaction_type, ref, remark, supplier_id, user_id) VALUES('$amount', '$date', '$time', '$payment', '$transaction', '$ref', '$remark', '$supplier', '$userid')";
                        if (!mysqli_query($conn, $sql)) {
                            $data['message'] = "Oops. something went wrong. please try again";
                        } else {
                            $data['message'] = "successful inserting into supplier account table";

                            $result_name = mysqli_query($conn, "SELECT supplier_name FROM supplier where supplier_id= $supplier");
                            if (mysqli_num_rows($result_name) > 0) {
                                while ($row = mysqli_fetch_assoc($result_name)) {
                                    $supplier_name = $row['supplier_name'];
                                }
                            }
                            //$amount= 0 - $amount;
                            $sql = "INSERT INTO cashstock (date, particulars, ref_code, amount, remark, time, payment_type, transaction_type, user_Id) VALUES('$date', '$supplier_name', '$ref', '$amount', '$remark', '$time','$payment', '$transaction', '$userid')";
                            if (!mysqli_query($conn, $sql)) {
                                $data['message'] = "Oops. something went wrong. please try again";
                            } else {
                                $data['message'] = "successful inserting into cash stock table";
                            }

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