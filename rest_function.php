<?php
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 07/03/2016
 * Time: 2:56 PM
 */

function rest_func($url_var,$initial_comp,$final_comp,$store_id,$location){
    //extract data from the post
//set POST variables
    $url = $url_var."/store_insert.php";
    $fields_string="";
    $fields = array(
        'store_name' => urlencode($initial_comp),
        'store_name2' => urlencode($final_comp),
        'store_id'=>urlencode($store_id),
        'location'=>urlencode($location)

    );

//url-ify the data for the POST
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');

//open connection
    $ch = curl_init();

//set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

//execute post
    $result = curl_exec($ch);

//close connection
    curl_close($ch);

    return $result;
}
//$result2=rest_func("http://www.ijeoma.dqdemos.com","","OandSonssss","","Abuja");
//echo $result2;
