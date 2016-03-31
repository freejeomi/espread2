<?php
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 23/03/2016
 * Time: 14:41
 */

function rest_func_sms($url_var, $initial_comp, $final_comp, $money, $phone, $customer, $company)
{
    //extract data from the post
    //set POST variables
    $url = $url_var . "/sms_send_process.php";
    $fields_string = "";
    $fields = array(
        'sms_username' => urlencode($initial_comp),
        'sms_password' => urlencode($final_comp),
        'amount' => urlencode($money),
        'phone' => urlencode($phone),
        'customer' => urlencode($customer),
        'company_name' => urldecode($company)
    );

//url-ify the data for the POST
    foreach ($fields as $key => $value) {
        $fields_string .= $key . '=' . $value . '&';
    }
    rtrim($fields_string, '&');

//open connection
    $ch = curl_init();

//set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
    $result = curl_exec($ch);

//close connection
    curl_close($ch);

    return $result;
}