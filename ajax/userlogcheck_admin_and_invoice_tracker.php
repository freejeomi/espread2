<?php
$role_admin = "admin";
$role_tracker = "invoice_tracker";
$role_super= "superadmin";



if (!(strtolower($_SESSION['role_name']) == strtolower($role_admin) || strtolower($_SESSION['role_name']) == strtolower($role_super) || strtolower($_SESSION['role_name']) == strtolower($role_tracker))) {
    $page = 'login.php';
    header("location: logout.php?page=$page");
    exit();
}
if ($_SESSION['active'] != '1') {
    $page = 'login.php';
    header("location: logout.php?page=$page");
    exit();
}
