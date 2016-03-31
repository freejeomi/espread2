<?php
if(isset($_POST['user_id'])){
    $msgToUser = "";
    require_once("lib/util.php");
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $user_id = $_POST['user_id'];
    $active = 0;
    $password = md5('password');
    //$password1 = $_POST['password1'];
    $sql = "UPDATE users SET active = '$active', password = '$password' WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    if($result) {
        $msgToUser = "success";
    }else{
       $msgToUser = "failure";
    }
    mysqli_close($conn);
    echo $msgToUser;
}