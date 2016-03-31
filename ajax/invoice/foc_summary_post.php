<?php
$start_date = "";
$end_date = "";
include "../../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset ($_POST['start_date']) && isset ($_POST['end_date'])) {
    if (empty($_POST['start_date'])) {
        $errors['start_date'] = "enter the start date";
    } else {
        $start_date = $_POST['start_date'];
    }

    if (empty($_POST['end_date'])) {
        $errors['end_date'] = 'please enter the end date.';
    } else {
        $end_date = $_POST['end_date'];
    }
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
    }
    echo json_encode($data);
}