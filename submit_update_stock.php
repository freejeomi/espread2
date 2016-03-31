<?php
include "lib/util.php";
include "inc/init.php";
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 14/01/2016
 * Time: 4:02 PM
 */
//ini_set("display_errors","1");
//$servername = "localhost";
//$username = "root";
//$password = "Heaven192";
//$dbname = "espread";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$task='';

if(isset($_POST['task'])){
    $task = $_POST['task'];
if(isset($_POST['remark'])){
    if(empty($_POST['remark'])|| $_POST['remark']==""){

    $remark="No remark";
}
    else{
        $remark = $_POST['remark'];
    }
}
$quantity = $_POST['quantity'];

$closingbal1 = $_POST['closingbal'];
$closingbal =intval($closingbal1);
$stock_id = $_POST['stock_id'];
$store_id = $_POST['store_id'];
    $user_id=$_POST['user_id'];
 $date = date('Y/m/d');
 $time = date('h:i:s');
//$user_id = '26';
$openingbal='not';
$queryupdate = '';
$unit = 1;
$continue=1;
if($_SESSION['role_name']!="superadmin"){
    $result_log=mysqli_query($conn,"SELECT upload_date FROM upload_log WHERE upload_date='$date' AND status=0");
    if(mysqli_num_rows($result_log)){
        $continue=0;
    }
    else{
        $continue=1;
    }
}
    if($continue!=0){

        $querycount = "SELECT stock_count FROM stockposition WHERE stock_id='$stock_id' AND store_id='$store_id'";
        $resultcount = mysqli_query($conn,$querycount);

        if (mysqli_num_rows($resultcount) > 0){
            while($row = mysqli_fetch_array($resultcount)) {
                $openingbal=$row[0];
                $queryupdate="UPDATE stockposition SET stock_count='$closingbal' where stock_id='$stock_id' AND store_id='$store_id'";
            }
        }
        else{
            $queryupdate="INSERT INTO stockposition(stock_id, store_id,unit,stock_count) VALUES('$stock_id','$store_id','$unit','$closingbal') ";
        }


//To insert  data into stock ledger table
        $queryinsert="INSERT INTO stockledger(opening_bal,task,quantity,remarks,closing_bal,update_date,stock_id,store_id,user_id,update_time) VALUES ( '$openingbal', '$task','$quantity','$remark','$closingbal','$date','$stock_id','$store_id','$user_id','$time')";


        if(mysqli_query($conn,$queryinsert) && mysqli_query($conn,$queryupdate)){echo  "1";}
        else{echo "0";}
    }
else{
    echo "no";
}
}


