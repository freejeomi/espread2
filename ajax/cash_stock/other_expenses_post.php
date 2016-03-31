
<?php
include ("../inc/init.php");
 $paymentErr = $beneficiaryErr = $remarksErr = "";
 $beneficiary = $remarks =$time = $date = $credit= "";
 $date = date("Y/m/d");
 $time = date("h:i:sa");
 $refcode ="";
 $transactiontype ="Other expenses";
 $paymenttype = "";
 $user_id = $_SESSION['user_id'];
 $is_all_valid = true;
 $payment =0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$remarks=$_POST["remarks"];
	
	if (empty($_POST["payment"])) {
		$paymentErr = "Please fill in the amount field";
		$is_all_valid = false;
    }else{
		if(is_numeric ($_POST["payment"])){
			$payment =$_POST["payment"];
		}else{
			$paymentErr = "Invalid format";
			$is_all_valid = false;
		}
	}
	
	if (empty($_POST["beneficiary"])) {
		$beneficiaryErr = "Please fill in the beneficiary field";
		$is_all_valid = false;
    }else{
		$beneficiary= $_POST["beneficiary"];
	}
	
	if($is_all_valid){
		include "../../lib/util.php";

//ini_set("display_errors","1");
//$servername = "localhost";
//$username = "root";
//$password = "Heaven192";
//$dbname = "espread";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);  
		}else {

			$sql = "INSERT INTO cashstock (date, particulars, ref_code, amount,  transaction_type, payment_type, user_Id, time, remark)
			VALUES ('$date', '$beneficiary', '$refcode', '$payment', '$transactiontype', '$paymenttype', '$user_id', '$time', '$remarks')";
			
			if ($conn->query($sql) === TRUE){
			header("Location:".APP_URL."/#ajax/other_expenses.php");
   }else{
		header("Location:".APP_URL."/#ajax/other_expenses.php?paymentErr=$paymentErr				&beneficiaryErr=$beneficiaryErr");
   }
   $conn->close();
		}
 }
	}

/*

    if (empty($_POST["payment"])) {
    $paymentErr = "Please fill in the amount";
     // echo $paymentErr;
    }else {
	  $payment=$_POST["payment"];
     // echo  $payment;
	 if(is_numeric ($_POST["payment"])){
		$payment=$_POST["payment"];
	 }else{
		 $paymentErr = "Please fill in only figure";
		 echo  $paymentErr;
	  if (empty ($_POST["beneficiary"])){
		$beneficiaryErr="Please fill in the beneficiary";
        //echo $beneficiaryErr;
        
	  }else{
		$beneficiary=$_POST["beneficiary"];
       echo $beneficiary;
	  if (empty ($_POST["remarks"])){
		$remarksErr="";
	  }else{
		$remarks=$_POST["remarks"];
	echo $remarks;
  header("Location:".APP_URL. "/#ajax/other_expenses.php?paymentErr=".$paymentErr."beneficiaryErr=".$beneficiaryErr);
    
$servername = "localhost";
$username = "root";
$password = "pass";
$dbname = "espread";



$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
   
}else { 


$sql = "INSERT INTO expenses ( beneficiary, amount, date, remark, time )
VALUES ( '$beneficiary', '$payment','$date' , '$remarks', '$time')";



if ($conn->query($sql) === TRUE) {
    $success= "New record created successfully";
	 //header("Location:".APP_URL."/#ajax/other_expenses.php/"); 
} else {
    $success= "Error: " . $sql . "<br>" . $conn->error;
	
} 

}   
 
      }
    $conn->close();  
	  }
	}   
  }   
}*/


?>