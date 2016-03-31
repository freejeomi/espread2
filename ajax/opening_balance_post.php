<?php
require_once("inc/init.php");
require_once("../lib/config.php");

 ?>


<?php
$amount = "";
$msgToUser = "";
$message = "";

 include "../lib/util.php";

if( isset($_POST['reset_opening_balance']) ) {
	$amount = str_replace(',', '', $_POST['amount']);
	$date = date("Y/m/d");

	// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ($_SESSION['role_name'] != "superadmin") {

		$result_log = mysqli_query($conn, "SELECT upload_date FROM upload_log where upload_date= '$date' AND status = 0");
		if (mysqli_num_rows($result_log) == 0) {
			$sql = "SELECT * FROM openingbalance WHERE date = '$date'";
			$result = mysqli_query($conn, $sql);

			$existCount = mysqli_num_rows($result);
			if ($existCount > 0) {
				$sql = "UPDATE openingbalance SET amount = '$amount' WHERE date = '$date'";
				$result = mysqli_query($conn, $sql);
				if ($result) {
					$message = 'update_success';
				} else {
					$message = 'update_failure';
				}
			} else {
				$sql = "INSERT INTO openingbalance (amount, date) VALUES ('$amount', '$date')";
				$result = mysqli_query($conn, $sql);
				if ($result) {
					$transaction = "opening balance";
					$name = "Opening Balance";
					$time = date('h:m:s');
					$empty = "";
					$user_id = $_SESSION['user_id'];
					$sql = "INSERT INTO cashstock (date, particulars, amount, remark, ref_code, time, payment_type, transaction_type, user_id) VALUES ('$date', '$name', '$amount', '$empty', '$empty', '$time', '$empty', '$transaction', '$user_id') ";
					$result = mysqli_query($conn, $sql);
					if ($result) {
						$message = 'insert_success';
					} else {
						$message = 'insert_failure';
					}
				}
			}
		}
		else {
			$message= 'locked';
		}
	}
	else {
		$sql = "SELECT * FROM openingbalance WHERE date = '$date'";
		$result = mysqli_query($conn, $sql);

		$existCount = mysqli_num_rows($result);
		if ($existCount > 0) {
			$sql = "UPDATE openingbalance SET amount = '$amount' WHERE date = '$date'";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				$message = 'update_success';
			} else {
				$message = 'update_failure';
			}
		} else {
			$sql = "INSERT INTO openingbalance (amount, date) VALUES ('$amount', '$date')";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				$transaction = "opening balance";
				$name = "Opening Balance";
				$time = date('h:m:s');
				$empty = "";
				$user_id = $_SESSION['user_id'];
				$sql = "INSERT INTO cashstock (date, particulars, amount, remark, ref_code, time, payment_type, transaction_type, user_id) VALUES ('$date', '$name', '$amount', '$empty', '$empty', '$time', '$empty', '$transaction', '$user_id') ";
				$result = mysqli_query($conn, $sql);
				if ($result) {
					$message = 'insert_success';
				} else {
					$message = 'insert_failure';
				}
			}
		}
	}
	mysqli_close($conn);
}

header("location:" . APP_URL . "/#ajax/opening_balance.php?message=$message");