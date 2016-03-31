<?php
if (session_id() == '')
    session_start();
session_destroy();
require_once("inc/init.php");
if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
    header("location: " . APP_URL . "/login.php?msg=$msg");
    exit();
}else{
    header("location: " . APP_URL . "/login.php");
    exit();
}
?>


