<?php
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 16/03/2016
 * Time: 4:07 PM
 */
$sql= "";
$result= "";
include "lib/util.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql="SELECT sum(amount) AS amount FROM cashstock WHERE amount>0 AND date='2016-03-10' AND transaction_type!='CREDIT'";
$result=mysqli_query($conn,$sql);
if($result){
    if(mysqli_num_rows($result)){
        $row=mysqli_fetch_array($result);
        if($row[0]){
            echo "value";
        }
        else{
            echo "null";
        }
    }
    else{
        echo "no rows";
    }
}
else{
    echo "no";
}