<?php require_once("inc/init.php");
require_once("../lib/config.php");
?>

<?php

include "../lib/util.php";

$amount = "";
$message = "";
$supplier_name = "";

if( isset($_POST['submit_payment']) &&  !empty($_POST['amount']) && !empty($_POST['supplier'])) {
	$_POST["amount"]= str_replace(",", "", $_POST["amount"]);
	$supplier_id = $_POST['supplier']; //beneficiary
	
	$amount = $_POST['amount'];
	$amt_calc= $_POST['amount'];
	$amount= 0-$amount;
	$remark= $_POST['remarks'];
	$date = date("Y/m/d");
	$time = date('H:i:s', time());
	$empty= "";
	$transaction= "supplier payment";
	$user_id= $_SESSION['user_id'];

	// Create connection
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$sql = "SELECT * FROM supplier WHERE supplier_id = '$supplier_id' LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if($result){
		while ($row = mysqli_fetch_array($result)) {
			$supplier_name = $row["supplier_name"];
		}
	}


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

    if ($_SESSION['role_name'] != "superadmin") {

        $result_log = mysqli_query($conn, "SELECT upload_date FROM upload_log where upload_date= '$date' AND status = 0");
        if (mysqli_num_rows($result_log) == 0) {
            if ($amt_calc > $balance) {
                $message = "account low";
                header("Location:" . APP_URL . "/#ajax/other_expenses.php?message=" . $message);
            } else {
                $sql = "INSERT INTO cashstock (date, particulars, amount, remark, ref_code, time, payment_type, transaction_type, user_id) VALUES ('$date', '$supplier_name', '$amount', '$remark', '$empty', '$time', '$empty', '$transaction', '$user_id') ";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $message = 'success';
                    header('location:' . APP_URL . '/#ajax/payment_to_supplier.php?message=' . $message);
                } else {
                    $message = 'failure';
                    header('location:' . APP_URL . '/#ajax/payment_to_supplier.php?message=' . $message);
                }
            }
        }
        else {
            $message = "locked";
            header("Location:" . APP_URL . "/#ajax/other_expenses.php?message=" . $message);
        }
    }
    else {
        if ($amt_calc > $balance) {
            $message = "account low";
            header("Location:" . APP_URL . "/#ajax/other_expenses.php?message=" . $message);
        } else {
            $sql = "INSERT INTO cashstock (date, particulars, amount, remark, ref_code, time, payment_type, transaction_type, user_id) VALUES ('$date', '$supplier_name', '$amount', '$remark', '$empty', '$time', '$empty', '$transaction', '$user_id') ";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $message = 'success';
                header('location:' . APP_URL . '/#ajax/payment_to_supplier.php?message=' . $message);
            } else {
                $message = 'failure';
                header('location:' . APP_URL . '/#ajax/payment_to_supplier.php?message=' . $message);
            }
        }
    }

	mysqli_close($conn);
}
else{
	$message = 'failure';
	header('location:' . APP_URL . '/#ajax/payment_to_supplier.php?message=' . $message);
}