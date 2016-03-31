<?php
$errors = array();    // array to hold validation errors
$data = array();        // array to pass back data

require_once( "../inc/init.php");
include "../../lib/util.php";
include "../../lib/config.php";

$expenditure= "";
$bbfwd= "";
// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//validate the waybill number
    if (empty($_POST['waybill'])) {
        $errors['waybill'] = "enter the waybill number";
    } else {
        $waybill = $_POST['waybill'];
    }
//validate the expenditure amount
    if (empty($_POST['expenditure'])) {
        $errors['expenditure'] = 'please enter the amount.';
    } else if (!is_numeric($_POST['expenditure'])) {
        $errors['expenditure'] = 'Enter a valid amount.';
    } else {
        $expenditure = $_POST['expenditure'];
        $amt_calc= $_POST['expenditure'];
    }

    $vehicle_id= $_POST['vehicle_id'];


    $vehicle_name= $_POST['vehicle_name'];
    $note = $_POST['note'];
    $debit_cashstock = $_POST['cashstock'];


    //echo $closing_bal;
    $date = date("Y-m-d");
    $time = date("h:i:s");

    $transaction = "haulage expense";
    $empty = "";
    $user_id= $_SESSION['user_id'];


    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    }
    else {
        if ($_SESSION['role_name'] != "superadmin") {
            $result_log = mysqli_query($conn, "SELECT upload_date FROM upload_log where upload_date= '$date' AND status = 0");
            if (mysqli_num_rows($result_log) == 0) {
                if ($debit_cashstock == "on") {
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

                    if ($amt_calc > $balance) {
                        $data['success'] = true;
                        $data['error_message'] = "Sorry, you do not have enough in your account to perform this transaction";
                    } else {


                        //retrieve the current balance of the vehicle by checking the haulage table or the vehicle table
                        $result_search = mysqli_query($conn, "SELECT vehicle_id FROM haulage WHERE vehicle_id= '$vehicle_id'");
                        if (mysqli_num_rows($result_search) > 0) {
                            //echo "hello";
                            $result_search = mysqli_query($conn, "SELECT  MIN(balance) AS current_balance FROM haulage WHERE vehicle_id= '$vehicle_id'");
                            while ($row = mysqli_fetch_assoc($result_search)) {
                                $bbfwd = $row['current_balance'];
                                $closing_bal = (0 - $expenditure) + $bbfwd;
                                $data['message'] = "successfully retrieved the balance from haulage";

                            }
                        } else {
                            //echo "hi";
                            $result_search = mysqli_query($conn, "SELECT balance FROM vehicle WHERE vehicle_id= '$vehicle_id'");
                            if (mysqli_num_rows($result_search) > 0) {
                                while ($row = mysqli_fetch_assoc($result_search)) {
                                    $bbfwd = $row['balance'];
                                    $closing_bal = (0 - $expenditure) + $bbfwd;
                                    //echo "within the while loop for vehicle".$bbwfd;
                                    $data['message'] = "successfully retrieved the balance from vehicle";
                                }
                            } else {
                                $data['success'] = false;
                                $data['message'] = "No record was returned while retrieving balance from vehicle";
                            }
                        }
                        //echo "outside the while loop for vehicle" . $bbwfd;
                        $sql = "INSERT INTO haulage (trans_date, trans_time, waybill, note, expenditure, bbfwd, balance, vehicle_id) VALUES ('$date', '$time', '$waybill', '$note', '$expenditure', '$bbfwd', '$closing_bal', '$vehicle_id')";
                        $result_insert = mysqli_query($conn, $sql);
                        if (!$result_search) {
                            $data['message'] = "An error occured while inserting into haulage";
                            $data['success'] = false;
                        } else {
                            $data['message'] = "successful insertion into haulage";
                            //if the debit my cashstock is checked, enter this block of code
                            $expenditure = 0 - $expenditure;
                            $sql = "INSERT INTO cashstock (date, particulars, ref_code, amount, remark, time, payment_type, transaction_type, user_Id) VALUES('$date', '$vehicle_name', '$waybill', '$expenditure', '$note', '$time','$empty', '$transaction', '$user_id')";
                            if (!mysqli_query($conn, $sql)) {
                                $data['message'] = "Oops. something went wrong. please try again";
                                $data['success'] = false;
                            } else {
                                $data['message'] = "successful inserting into cash stock table";
                                $data['success'] = true;
                            }
                        }
                    }
                }
                else {

                    //retrieve the current balance of the vehicle by checking the haulage table or the vehicle table
                    $result_search = mysqli_query($conn, "SELECT vehicle_id FROM haulage WHERE vehicle_id= '$vehicle_id'");
                    if (mysqli_num_rows($result_search) > 0) {
                        //echo "hello";
                        $result_search = mysqli_query($conn, "SELECT  MIN(balance) AS current_balance FROM haulage WHERE vehicle_id= '$vehicle_id'");
                        while ($row = mysqli_fetch_assoc($result_search)) {
                            $bbfwd = $row['current_balance'];
                            $closing_bal = (0 - $expenditure) + $bbfwd;
                            $data['message'] = "successfully retrieved the balance from haulage";

                        }
                    } else {
                        //echo "hi";
                        $result_search = mysqli_query($conn, "SELECT balance FROM vehicle WHERE vehicle_id= '$vehicle_id'");
                        if (mysqli_num_rows($result_search) > 0) {
                            while ($row = mysqli_fetch_assoc($result_search)) {
                                $bbfwd = $row['balance'];
                                $closing_bal = (0 - $expenditure) + $bbfwd;
                                //echo "within the while loop for vehicle".$bbwfd;
                                $data['message'] = "successfully retrieved the balance from vehicle";
                            }
                        } else {
                            $data['success'] = false;
                            $data['message'] = "No record was returned while retrieving balance from vehicle";
                        }
                    }
                    //echo "outside the while loop for vehicle" . $bbwfd;
                    $sql = "INSERT INTO haulage (trans_date, trans_time, waybill, note, expenditure, bbfwd, balance, vehicle_id) VALUES ('$date', '$time', '$waybill', '$note', '$expenditure', '$bbfwd', '$closing_bal', '$vehicle_id')";
                    $result_insert = mysqli_query($conn, $sql);
                    if (!$result_search) {
                        $data['message'] = "An error occured while inserting into haulage";
                        $data['success'] = false;
                    } else {
                        $data['message'] = "successful insertion into haulage";
                        $data['success'] = true;
                    }
                }
            }
            else {
                $data['locked'] = "Sorry, you are unable to carry out transaction until the next business day";
                $data['success'] = true;
            }
        }
        else {
            if ($debit_cashstock == "on") {
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

                if ($amt_calc > $balance) {
                    $data['success'] = true;
                    $data['error_message'] = "Sorry, you do not have enough in your account to perform this transaction";
                } else {


                    //retrieve the current balance of the vehicle by checking the haulage table or the vehicle table
                    $result_search = mysqli_query($conn, "SELECT vehicle_id FROM haulage WHERE vehicle_id= '$vehicle_id'");
                    if (mysqli_num_rows($result_search) > 0) {
                        //echo "hello";
                        $result_search = mysqli_query($conn, "SELECT  MIN(balance) AS current_balance FROM haulage WHERE vehicle_id= '$vehicle_id'");
                        while ($row = mysqli_fetch_assoc($result_search)) {
                            $bbfwd = $row['current_balance'];
                            $closing_bal = (0 - $expenditure) + $bbfwd;
                            $data['message'] = "successfully retrieved the balance from haulage";

                        }
                    } else {
                        //echo "hi";
                        $result_search = mysqli_query($conn, "SELECT balance FROM vehicle WHERE vehicle_id= '$vehicle_id'");
                        if (mysqli_num_rows($result_search) > 0) {
                            while ($row = mysqli_fetch_assoc($result_search)) {
                                $bbfwd = $row['balance'];
                                $closing_bal = (0 - $expenditure) + $bbfwd;
                                //echo "within the while loop for vehicle".$bbwfd;
                                $data['message'] = "successfully retrieved the balance from vehicle";
                            }
                        } else {
                            $data['success'] = false;
                            $data['message'] = "No record was returned while retrieving balance from vehicle";
                        }
                    }
                    //echo "outside the while loop for vehicle" . $bbwfd;
                    $sql = "INSERT INTO haulage (trans_date, trans_time, waybill, note, expenditure, bbfwd, balance, vehicle_id) VALUES ('$date', '$time', '$waybill', '$note', '$expenditure', '$bbfwd', '$closing_bal', '$vehicle_id')";
                    $result_insert = mysqli_query($conn, $sql);
                    if (!$result_search) {
                        $data['message'] = "An error occured while inserting into haulage";
                        $data['success'] = false;
                    } else {
                        $data['message'] = "successful insertion into haulage";
                        //if the debit my cashstock is checked, enter this block of code
                        $expenditure = 0 - $expenditure;
                        $sql = "INSERT INTO cashstock (date, particulars, ref_code, amount, remark, time, payment_type, transaction_type, user_Id) VALUES('$date', '$vehicle_name', '$waybill', '$expenditure', '$note', '$time','$empty', '$transaction', '$user_id')";
                        if (!mysqli_query($conn, $sql)) {
                            $data['message'] = "Oops. something went wrong. please try again";
                            $data['success'] = false;
                        } else {
                            $data['message'] = "successful inserting into cash stock table";
                            $data['success'] = true;
                        }
                    }
                }
            }
            else {

                //retrieve the current balance of the vehicle by checking the haulage table or the vehicle table
                $result_search = mysqli_query($conn, "SELECT vehicle_id FROM haulage WHERE vehicle_id= '$vehicle_id'");
                if (mysqli_num_rows($result_search) > 0) {
                    //echo "hello";
                    $result_search = mysqli_query($conn, "SELECT  MIN(balance) AS current_balance FROM haulage WHERE vehicle_id= '$vehicle_id'");
                    while ($row = mysqli_fetch_assoc($result_search)) {
                        $bbfwd = $row['current_balance'];
                        $closing_bal = (0 - $expenditure) + $bbfwd;
                        $data['message'] = "successfully retrieved the balance from haulage";

                    }
                } else {
                    //echo "hi";
                    $result_search = mysqli_query($conn, "SELECT balance FROM vehicle WHERE vehicle_id= '$vehicle_id'");
                    if (mysqli_num_rows($result_search) > 0) {
                        while ($row = mysqli_fetch_assoc($result_search)) {
                            $bbfwd = $row['balance'];
                            $closing_bal = (0 - $expenditure) + $bbfwd;
                            //echo "within the while loop for vehicle".$bbwfd;
                            $data['message'] = "successfully retrieved the balance from vehicle";
                        }
                    } else {
                        $data['success'] = false;
                        $data['message'] = "No record was returned while retrieving balance from vehicle";
                    }
                }
                //echo "outside the while loop for vehicle" . $bbwfd;
                $sql = "INSERT INTO haulage (trans_date, trans_time, waybill, note, expenditure, bbfwd, balance, vehicle_id) VALUES ('$date', '$time', '$waybill', '$note', '$expenditure', '$bbfwd', '$closing_bal', '$vehicle_id')";
                $result_insert = mysqli_query($conn, $sql);
                if (!$result_search) {
                    $data['message'] = "An error occured while inserting into haulage";
                    $data['success'] = false;
                } else {
                    $data['message'] = "successful insertion into haulage";
                    $data['success'] = true;
                }
            }
        }

    }
    echo json_encode($data);
}
