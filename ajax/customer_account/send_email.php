<?php
require_once("../inc/init.php");
require('../../PHPMailer/class.phpmailer.php');
require('../../PHPMailer/class.smtp.php');

include "../../lib/util.php";

$cus_id= "";
$cus_name= "";
$cus_email= "";
$amount_owed= "";

$cus_id_array=array();
$cus_name_array=array();
$cus_email_array=array();
$amount_owed_array=array();

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//$_POST['name'] = "Oseni Yusuf";
//$_POST['amount']="234444";
//$_POST['cus_id']="3";
//$_POST['email']="";

$result_sql = mysqli_query($conn, "SELECT company_name,company_email, email_pass, email_smtp, email_user from settings");
if (mysqli_num_rows($result_sql) > 0) {
    $row = mysqli_fetch_assoc($result_sql);
    $company_name = $row['company_name'];
    $company_email = $row['company_email'];
    $email_servername = $row['email_smtp'];
    $email_user = $row['email_user'];
    $email_pass = $row['email_pass'];

    if (isset($_POST['cus_id'])) {
        $cus_id = $_POST['cus_id'];

        $cus_name = $_POST['name'];
        $cus_email = $_POST['email'];
        $amount_owed = 0 - $_POST['amount'];
        $message = '<h3>Dear ' . $cus_name . ', </h3>' .
            '<p>This is to notify you that you are owing a total sum of <b>' . number_format( $amount_owed,2) . ' NGN</b>. Please endeavour to pay as soon as possible</p></br>';
        if (!empty($cus_email) && $cus_email != "") {


            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Host = $email_servername;
            $mail->Port = 465;
            $mail->AddAddress($cus_email, $cus_name);
            $mail->Username = $email_user;
            $mail->Password = $email_pass;
            $mail->SetFrom($email_user, $company_name);
            $mail->AddReplyTo($company_email, $company_name);

            $mail->MsgHTML($message);
            $mail->Subject = "NOTIFICATION OF DEBT";

            if ($mail->Send()) {
                echo 'email successful';
            } else {
                echo 'email failed';
            }
        } else {
            echo 'no email';
        }
    }
$data_show="";
$email_count=0;
$data_success="";
$data=array();
//ARRAY IS SET, SO use array form
    if (isset($_POST['cus_data'])) {
        $total_array = json_decode($_POST['cus_data']);
        $cus_id_array = $total_array->cus_id;
        $cus_name_array = $total_array->name;
        $cus_email_array = $total_array->email;
        $amount_owed_array = $total_array->amount;

        for($i=0;$i<count($cus_id_array);$i++){
            if(!empty($cus_email_array[$i]) && $cus_email_array[$i]!=""){
            $amount_owed= 0 - $amount_owed_array[$i];
                $message = '<h3>Dear ' . $cus_name_array[$i] . ', </h3>' .
                    '<p>This is to notify you that you are owing a total sum of <b>' .
                    number_format($amount_owed,2) . ' NGN</b>. Please endeavour to pay as soon as possible</p></br>';
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPDebug = 0;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "ssl";
                $mail->Host = $email_servername;
                $mail->Port = 465;
                $mail->AddAddress($cus_email_array[$i], $cus_name_array[$i]);
                $mail->Username = $email_user;
                $mail->Password = $email_pass;
                $mail->SetFrom($email_user, $company_name);
                $mail->AddReplyTo($company_email, $company_name);

                $mail->MsgHTML($message);
                $mail->Subject = "NOTIFICATION OF DEBT";


                if ($mail->Send()) {
                    $data_success= 'email successful';
                } else {
                    $data_show.= 'Email failed to send to customer '.$cus_name_array[$i].' with id '.$cus_id_array[$i];
                    $email_count+=1;
                }
            }
            else{
            $email_count+=1;
            }

        }
    if($data_show!=""){
    $data['data_show']=$data_show;
    }
    elseif($email_count>0){
    $data['email_count']=$email_count;
    }
    else{
   $data['data_success']="Email succesfully sent to all";
    }
    echo json_encode($data);
    }


}
else {
    echo "no settings";
}

?>