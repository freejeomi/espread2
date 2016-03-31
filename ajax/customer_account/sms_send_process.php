<?php

require_once("oneapi/client.php");

$sms_user = "";
$sms_pass = "";
$phone_num = "";
$amount = "";
$company = "";
$customer = "";

if ( isset($_POST['sms_username']) && isset($_POST['sms_password']) ) {
    $sms_user= $_POST['sms_username'];
    $sms_pass= $_POST['sms_password'];
    $phone_num= $_POST['phone'];
    $amount= $_POST['amount'];
    $company= $_POST['company_name'];
    //echo $company;
    //$company= "Charles";
    $customer= $_POST['customer'];

    $smsClient = new SmsClient($sms_user, $sms_pass);


        $smsMessage = new SMSRequest();
        $smsMessage->senderAddress = $company;
        $smsMessage->address = $phone_num;            //'+2348133242320';
        $smsMessage->message = 'Hello' . $customer . 'this is to notify you that you are owing a total sum of '.number_format($amount,2).' NGN. Please endeavour to pay your debt as soon as possible.';
       $smsMessageSendResult = $smsClient->sendSMS($smsMessage);


       // The client correlator is a unique identifier of this api call:
       $clientCorrelator = $smsMessageSendResult->clientCorrelator;
       // You can use $clientCorrelator or $smsMessageSendResult as an method call argument here:
       $smsMessageStatus = $smsClient->queryDeliveryStatus($smsMessageSendResult);
       $deliveryStatus = $smsMessageStatus->deliveryInfo[0]->deliveryStatus;


    //echo "success";
    //echo 'Success:', $smsMessageStatus->isSuccess(), "\n";
    //echo 'Status:', $deliveryStatus, "\n";
    if ($smsMessageStatus->isSuccess()) {
        echo "success";
    } else {
        echo "failed";
    }
}
else {
    echo "no settings";
}

