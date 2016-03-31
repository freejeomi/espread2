<?php

include "lib/util.php";
include "rest_function.php";
$data=array();

//CHECK IF THERE IS A DATE SENT
if(isset($_POST['date']) && !empty($_POST['date'])){
    $date=$_POST['date'];

    //AT LEAST, SO START OTHER THINGS
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
    if (!$conn) {
        $data['success']=false;
        $data['message']=("Connection failed: " . mysqli_connect_error());
    }

    // TO ADD HTTP
    function add_http($url) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }

        return $url;
    }
//$url_store="";

    $query1 = "SELECT company_name,upload_url,company_id,company_address FROM settings LIMIT 1";
    $result1 = mysqli_query($conn, $query1);
    if(mysqli_num_rows($result1)>0) {
        $url_row = mysqli_fetch_array($result1);
        $url_store=$url_row[1];
        $url_store = add_http($url_store);
        $store_name=$url_row[0];
        $company_id=$url_row[2];
        $address=$url_row[3];

        $rest_result=rest_func($url_store,"",$store_name,$company_id,$address);

        //THERE WAS NO ERROR
        if(substr($rest_result,0,4)=="true"){
            // CHECK IF THE COMPANY ID WAS RETURNED
            $array_true=explode(",",$rest_result);

            //COMPANY ID WAS RETURNED SO DO OPERATION
            if($array_true[1]!=""){
                $result_update= mysqli_query($conn, "UPDATE settings SET company_id=$array_true[1] WHERE check_=1");

                if ($result_update) {
                    $data['company_id']=$array_true[1];
                    $data['success']=true;

                }
                else {
                    $data['message']="Could not insert into database";
                    $data['success']=false;
                }
            }

            else{
                $data['company_id']=$company_id;
            }
        }
        else{
            if(substr($rest_result,0,5)=="Sorry"){
                $data['success']=false;
                $data['sorry']=$rest_result;
            }
            else if(substr($rest_result,0,5)==false){
                $data['success']=false;
                $data['internet']="none";
            }
            else{
                $data['success']=false;
                $data['message']=$rest_result;
            }

        }
    }
    else{
        $data['success']=false;
        $data['message']="Please update your settings and try again";
    }
    if(isset($data['company_id'])&& $data['company_id']){
        $data['success']=true;
        $data['upload_url']=$url_store;
        $data['store_name']=$store_name;
    }
}
else{
    $data['message']="Please select a date for upload";
    $data['success']=false;
}

echo json_encode($data);

?>