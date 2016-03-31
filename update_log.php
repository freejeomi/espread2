<?php
include "lib/util.php";


// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_POST['date'])){
    $date=$_POST['date'];
    $status=0;

    // FIRST CHECK IF THAT DATE EXISTS
    $result_dis=mysqli_query($conn,"SELECT upload_date FROM upload_log WHERE upload_date='$date'");
    if($result_dis){
        if(mysqli_num_rows($result_dis)>0){
            $result_update=mysqli_query($conn,"UPDATE upload_log SET status=$status,request=$status WHERE upload_date='$date'");
            if($result_update){
                echo "1";
            }
            else{
                echo "0";
            }
        }
        else{
            $result_insert=mysqli_query($conn,"INSERT INTO upload_log(upload_date, status)  VALUES('$date',$status) ");
            if($result_insert){
                echo "1";
            }
            else{
                echo "0";
            }
        }
    }
    else{
        echo "0";
    }


}
