<?php
    $errors         = array();  	// array to hold validation errors
    $data 			= array(); 		// array to pass back data
    
    include "../../lib/util.php";
require_once("../inc/init.php");

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
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){        
        if (empty($_POST['amount'])) {
            $errors['amount'] = 'Amount is required.';
        }
        else if (!is_numeric($_POST['amount'])){
            $errors['amount'] = 'Enter a valid amount.';
        }
        else {
            $amount = $_POST['amount'];
        }
        if (empty($_POST['user_id'])) {
            $errors['userid'] = 'User cannot be detected.';
        }
        else{
            $userid=$_POST['user_id'];
        }
        
        if ($_POST['payment']== "none") {
            $errors['payment'] = 'Select a payment type.'; 
        }

        else{
            $payment= $_POST['payment'];
            $name= $_POST['name'];                
            $cus_id = $_POST['cus_Id'];              
            $remark= $_POST['remark'];
            $transaction= "customer payment";
            
            $creditcash= $_POST['credit_cash'];
                
            $date = date("Y/m/d");
            $time= date("h:i:s");
            $empty= "";
            //$userid= 26;
        }
    
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


                    if ($creditcash == "on") {
                        $sql = "INSERT INTO customer_transaction (date, time, payment_type, invoice_num, amount, remark, transaction_type, user_id, customer_id) VALUES ('$date', '$time', '$payment', '$empty', '$amount', '$remark', '$transaction', '$userid','$cus_id')";
                        if (!mysqli_query($conn, $sql)) {
                            $data['message'] = "Oops. something went wrong. please try again";
                        } else {
                            $data['message'] = "successful inserting into customer transaction table";
                            $data['success'] = true;
                        }
                    } else {
                        if ($amt_calc > $balance) {
                            //$data['success'] = false;
                            $data['check'] = true;
                            $data['message'] = "Sorry, you do not have enough in your account to perform this transaction";
                        } else {
                            //$amount= mysqli_real_escape_string($conn, $amount);
                            $sql = "INSERT INTO customer_transaction (date, time, payment_type, invoice_num, amount, remark, transaction_type, user_id, customer_id) VALUES ('$date', '$time', '$payment', '$empty', '$amount', '$remark', '$transaction', '$userid','$cus_id')";
                            if (!mysqli_query($conn, $sql)) {
                                $data['message'] = "Oops. something went wrong. please try again";
                            } else {
                                $data['message'] = "successful inserting into customer transaction table";

                                $sql = "INSERT INTO cashstock (date, particulars, ref_code, amount, remark, time, payment_type, transaction_type, user_Id) VALUES('$date', '$name', '$empty', '$amount', '$remark', '$time','$payment', '$transaction', '$userid')";
                                if (!mysqli_query($conn, $sql)) {
                                    $data['message'] = "Oops. something went wrong. please try again";
                                } else {
                                    $data['message'] = "successful inserting into cash stock table";
                                    $data['success'] = true;
                                }
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


                if ($creditcash == "on") {
                    $sql = "INSERT INTO customer_transaction (date, time, payment_type, invoice_num, amount, remark, transaction_type, user_id, customer_id) VALUES ('$date', '$time', '$payment', '$empty', '$amount', '$remark', '$transaction', '$userid','$cus_id')";
                    if (!mysqli_query($conn, $sql)) {
                        $data['message'] = "Oops. something went wrong. please try again";
                    } else {
                        $data['message'] = "successful inserting into customer transaction table";
                        $data['success'] = true;
                    }
                } else {
                    if ($amt_calc > $balance) {
                        //$data['success'] = false;
                        $data['check'] = true;
                        $data['message'] = "Sorry, you do not have enough in your account to perform this transaction";
                    } else {
                        //$amount= mysqli_real_escape_string($conn, $amount);
                        $sql = "INSERT INTO customer_transaction (date, time, payment_type, invoice_num, amount, remark, transaction_type, user_id, customer_id) VALUES ('$date', '$time', '$payment', '$empty', '$amount', '$remark', '$transaction', '$userid','$cus_id')";
                        if (!mysqli_query($conn, $sql)) {
                            $data['message'] = "Oops. something went wrong. please try again";
                        } else {
                            $data['message'] = "successful inserting into customer transaction table";

                            $sql = "INSERT INTO cashstock (date, particulars, ref_code, amount, remark, time, payment_type, transaction_type, user_Id) VALUES('$date', '$name', '$empty', '$amount', '$remark', '$time','$payment', '$transaction', '$userid')";
                            if (!mysqli_query($conn, $sql)) {
                                $data['message'] = "Oops. something went wrong. please try again";
                            } else {
                                $data['message'] = "successful inserting into cash stock table";
                                $data['success'] = true;
                            }
                        }
                    }
                }
            }
        }

        echo json_encode($data);
    }    
    mysqli_close($conn);        
?>