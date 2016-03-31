
<?php
require_once ("inc/init.php");
require_once("../lib/config.php");
require_once("inc/init.php");
include "../lib/util.php";

$message= "";
 $paymentErr = $beneficiaryErr = $remarksErr = "";
 $beneficiary = $remarks =$time = $date = $credit= "";
 $date = date("Y/m/d");
 $time = date("h:i:sa");
 $empty= "";
 $transaction= "other expenses";
 $user_id= $_SESSION['user_id'];
 $is_all_valid = true;
 $payment=0;
//$payment= $_POST['payment'];
//$payment = intval(preg_replace('/[^\d.]/', '', $payment));
 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$remarks=$_POST["remarks"];
	
	if (empty($_POST["payment"])) {
		$paymentErr = "Please fill in the amount field";
		$is_all_valid = false;
	
    }else{
		$_POST["payment"]= str_replace(",", "", $_POST["payment"]);
		if(is_numeric($_POST["payment"])){
			$payment -=$_POST["payment"];
			$amt_calc= $_POST["payment"];
			
			
		}else{
			$paymentErr = "Invalid format";
			$is_all_valid = false;
		}
	}
	
	if (empty($_POST["beneficiary"])) {
		$beneficiaryErr = "Please fill in the beneficiary field";
		$is_all_valid = false;
    }else{
		$beneficiary=strtolower(($_POST["beneficiary"]));
	}
	
	if($is_all_valid){
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($_SESSION['role_name'] != "superadmin") {

            $result_log = mysqli_query($conn, "SELECT upload_date FROM upload_log where upload_date= '$date' AND status = 0");
            if (mysqli_num_rows($result_log) == 0) {


                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } else {
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
                        $message = "account low";
                        header("Location:" . APP_URL . "/#ajax/other_expenses.php?message=" . $message);
                    } else {
                        $sql = "INSERT INTO cashstock (date, particulars, amount, remark, ref_code, time, payment_type, transaction_type, user_id) VALUES ('$date', '$beneficiary', '$payment', '$remarks', '$empty', '$time', '$empty', '$transaction', '$user_id') ";
                        if ($conn->query($sql) === TRUE) {
                            $message = "success";
                            header("Location:" . APP_URL . "/#ajax/other_expenses.php?message=" . $message);
                        } else {
                            $message = "failure";

                            header("Location:" . APP_URL . "/#ajax/other_expenses.php?message=" . $message);
                        }
                    }
                }
            }
            else {
                $message = "locked";
                header("Location:" . APP_URL . "/#ajax/other_expenses.php?message=" . $message);
            }
        }
        else {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
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
                    $message = "account low";
                    header("Location:" . APP_URL . "/#ajax/other_expenses.php?message=" . $message);
                } else {
                    $sql = "INSERT INTO cashstock (date, particulars, amount, remark, ref_code, time, payment_type, transaction_type, user_id) VALUES ('$date', '$beneficiary', '$payment', '$remarks', '$empty', '$time', '$empty', '$transaction', '$user_id') ";
                    if ($conn->query($sql) === TRUE) {
                        $message = "success";
                        header("Location:" . APP_URL . "/#ajax/other_expenses.php?message=" . $message);
                    } else {
                        $message = "failure";

                        header("Location:" . APP_URL . "/#ajax/other_expenses.php?message=" . $message);
                    }
                }
            }
        }
		$conn->close();
   }
   else{
		header("Location:".APP_URL."/#ajax/other_expenses.php?paymentErr=$paymentErr&beneficiaryErr=$beneficiaryErr");
    }

 }

?>