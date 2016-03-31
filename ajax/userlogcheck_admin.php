<?php
$role= "admin";
$role_super= "superadmin";
if (!(strtolower($_SESSION['role_name']) == strtolower($role)  || strtolower($_SESSION['role_name']) == strtolower($role_super))) {
    $page= 'login.php';
    header("location: logout.php?page=$page");
    exit();
}

if ($_SESSION['active'] != '1') {
    $page= 'login.php';
    header("location: logout.php?page=$page");
    exit();
}