<?php
if ($_SERVER['HTTP_ORIGIN'] == "http://localhost") {

    header('Access-Control-Allow-Origin: http://localhost');
//    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
//    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    //header('Content-type: application/json, text/javascript, */*; q=0.01');
    //readfile('arunerDotNetResource.xml');
}
require_once("oneapi/client.php");
$sms_user = "";
$sms_pass = "";
$phone_num = "";
$amount = "";
$company = "";
$customer = "";

$cus_id_array = array();
$cus_name_array = array();
$cus_sms_array = array();
$amount_owed_array = array();

$data_show = "";
$email_count = 0;
$data_success = "";
$data = array();
//ARRAY IS SET, SO use array form
if (isset($_POST['cus_data'])) {
    $total_array = json_decode($_POST['cus_data']);

    $cus_id_array = $total_array->cus_id;
    $cus_name_array = $total_array->name;
    $cus_sms_array = $total_array->phone;
    $amount_owed_array = $total_array->amount;

    $company= $total_array->company_name;
    $sms_pass= $total_array->sms_password;
    $sms_user= $total_array->sms_username;

    for ($i = 0; $i < count($cus_id_array); $i++) {
        if (!empty($cus_sms_array[$i]) && $cus_sms_array[$i] != "") {
            $amount_owed = 0 - $amount_owed_array[$i];
            $smsClient = new SmsClient($sms_user, $sms_pass);

            $smsMessage = new SMSRequest();
            $smsMessage->senderAddress = $company;
            $smsMessage->address = $cus_sms_array[$i];            //'+2348133242320';
            $smsMessage->message = 'Hello ' . $cus_name_array[$i] . ', this is to notify you that you are owing a total sum of ' . number_format($amount_owed, 2) . 'NGN. Please endeavour to pay your debt as soon as possible.';

            $smsMessageSendResult = $smsClient->sendSMS($smsMessage);
            // The client correlator is a unique identifier of this api call:
            $clientCorrelator = $smsMessageSendResult->clientCorrelator;
            // You can use $clientCorrelator or $smsMessageSendResult as an method call argument here:
            $smsMessageStatus = $smsClient->queryDeliveryStatus($smsMessageSendResult);
            $deliveryStatus = $smsMessageStatus->deliveryInfo[0]->deliveryStatus;

            //echo 'Success:', $smsMessageStatus->isSuccess(), "\n";
            //echo 'Status:', $deliveryStatus, "\n";
            if ($smsMessageStatus->isSuccess()) {
            $data_success = 'sms successful';
            }
            else {
            $data_show .= 'SMS failed to send to customer ' . $cus_name_array[$i] . ' with id ' . $cus_id_array[$i];
            $email_count += 1;
            }
        }
        else {
            $email_count += 1;
        }
    }
    if ($data_show != "") {
        $data['data_show'] = $data_show;
    } elseif ($email_count > 0) {
        $data['email_count'] = $email_count;
    } else {
        $data['data_success'] = "SMS has been sent successfully to all";
    }
    echo json_encode($data);
}
else {
    echo "no settings";
}