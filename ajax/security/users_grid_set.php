<?php
    include "../../lib/util.php";

//ini_set("display_errors","1");
//$servername = "localhost";
//$username = "root";
//$password = "Heaven192";
//$dbname = "espread";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    //else {
    //    echo "connected";
    //}
if ($_POST['oper']== "edit") {
 $user_id = $_POST['id'];
 $username = $_POST['username'];
 $password = $_POST['password'];
 $role_name = $_POST['role_name'];

 if (substr($user_id,0, 3) == "jqg") {
     $password = md5($_POST['password']);
    mysqli_query($conn, "INSERT INTO users (username, password, role_id)VALUES ('$username', '$password', '$role_name')")
    or die(mysqli_error($conn));
 }
else {
    mysqli_query($conn, "UPDATE users SET username='$username',password='$password',role_id='$role_name' where user_id='$user_id'")
 or die(mysqli_error($conn));  
}
}

if ($_POST['oper']== "del") {
 $user_id = $_POST['id'];

 mysqli_query($conn, "DELETE from users where user_id='$user_id'")
 or die(mysqli_error($conn));
}

if ($_POST['oper']== "add") {
 $username = $_POST['username'];
 $password = md5('password');
 $role_name = $_POST['role_name'];

 mysqli_query($conn, "INSERT INTO users (username, password, role_id)VALUES ('$username', '$password', '$role_name')")
 or die(mysqli_error($conn));
}
 mysqli_close($conn);


?>