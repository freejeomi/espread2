<?php
    $errors         = array();  	
    $data 			= array(); 
    //$_POST = json_decode(file_get_contents('php://input'), true);
    $send_sms_status = true;
	//$country= $_POST ['country'];
	//echo $country;
	include 'dbconn.php';
	if (empty($_POST['email'])) {
		$errors['email'] = 'Email is required.';		
	}
    else if (empty($_POST['pword'])) {
		$errors['pword'] = 'Password is required!';
		$send_sms_status = false;
	}
	else if (empty($_POST['phone'])) {
		$errors['phone'] = 'Phone number is required.';
		$send_sms_status = false;
	}
	else {		
        $email = $_POST['email'];
        $email = filter_var($email,FILTER_SANITIZE_EMAIL);
		$select = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'") or die(mysqli_error());					
		if(mysqli_num_rows($select)) {
			$errors['email']= "This account already exists";
            $send_sms_status = false;
        }
		else if ( filter_var($email,FILTER_VALIDATE_EMAIL) == false){
            $errors['email'] = 'Invalid Email Format.';
            $send_sms_status = false;
        }
        else{
            list($user, $domain) = explode("@", $email);
            if (!checkdnsrr($domain,"MX")) {                
                $errors['email'] = 'Email address does not exist';
                $send_sms_status = false;
            }
			else {
				if (strlen($_POST["pword"]) < 7){
					$errors['pword'] = "Your password must contain at least 7 or more characters";
					$send_sms_status = false;
				}
				else {
					$phone_num = $_POST['code'] . $_POST['phone'];				
					if ( strlen($phone_num ) > 15 ) { 
						$errors['phone']= 'phone number is invalid';
						$send_sms_status = false;
					}
				}
			}
		}
	}	
		
	if ( ! empty($errors)) {
		$data['success'] = false;
		$data['errors']  = $errors;
	}
	else {
			
		$fbid = "";
		$hash= "";
		$random = rand(0, 10000);
		$pword= md5($_POST["pword"]);
		//$country= $_POST ['country'];
		$username= "";
		$active=0;
		//header('location: smsVerify.php');
		
		if ($send_sms_status == true) {
			require_once("oneapi/client.php");
							
			$smsClient = new SmsClient('DigitalQuest', 'SMS*123#');
													
			$smsMessage = new SMSRequest();
			$smsMessage->senderAddress = 'DQ Sign Up';
			$smsMessage->address = $phone_num;            //'+2348133242320';
			$smsMessage->message = 'your verification code is '. $random;
															
			$smsMessageSendResult = $smsClient->sendSMS($smsMessage);												
			// The client correlator is a unique identifier of this api call:
			$clientCorrelator = $smsMessageSendResult->clientCorrelator;														
			// You can use $clientCorrelator or $smsMessageSendResult as an method call argument here:
			$smsMessageStatus = $smsClient->queryDeliveryStatus($smsMessageSendResult);
			$deliveryStatus = $smsMessageStatus->deliveryInfo[0]->deliveryStatus;
															
			//echo 'Success:', $smsMessageStatus->isSuccess(), "\n";
			//echo 'Status:', $deliveryStatus, "\n";
			if( $smsMessageStatus->isSuccess()) {
			//	echo 'Message id:', $smsMessageStatus->exception->messageId, "\n";
			//	echo 'Text:', $smsMessageStatus->exception->text, "\n";
			//	echo 'Variables:', $smsMessageStatus->exception->variables, "\n";
				$random=md5($random);
				
				$email= mysqli_real_escape_string($conn, $email);
				$pword= mysqli_real_escape_string($conn, $pword);
				$random= mysqli_real_escape_string($conn, $random);
				$phone_num= mysqli_real_escape_string($conn, $phone_num);
				$username= mysqli_real_escape_string($conn, $username);
				
				$sql = "INSERT INTO users (email, password, username, active, phonenum, randnum, hash, fbid) VALUES
						('$email', '$pword', '$username', $active, '$phone_num', '$random', '$hash', '$fbid')";
				//mysqli_query($conn, $sql);		
				if (!mysqli_query($conn, $sql)) {
					$data['success']= false;
					$data['message']="Oops. something went wrong. please try again";
				}				
				$data['success']= true;
			}	
		}
		//else {
		//	$data['success']= false;
		//	data['message']= "An error occured. please try again";
		//}		
	}

	echo json_encode($data);
	mysqli_close($conn);
	
?>