<?php
require_once("ajax/inc/init.php");
if (isset ($_SESSION['password'])) {
    if (isset($_POST['password_lock'])) {
        if (empty($_POST['password_lock'])) {
            echo "Please enter a password to unlock screen.";
        } else {
            $pass_lock = md5($_POST["password_lock"]);

            //$_SESSION['password_lock'] =$pass_lock;
            $password = $_SESSION['password'];

            if ($pass_lock == $password) {
                //$_SESSION['first_screen'] = 'dashboard.php';
                //header("location: " . APP_URL . '/index.php#ajax/dashboard.php');
                echo "success";

            } else {
                echo "Password is wrong, try again.";
            }
        }
    }
}
else {
    header('location: logout.php');
}
?>