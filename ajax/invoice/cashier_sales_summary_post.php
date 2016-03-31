<?php
$errors = array();    // array to hold validation errors
$data = array();        // array to pass back dat
$startdate="";
$finishdate="";
if (isset($_POST['start_date'])|| ($_POST['end_date']) ) {
//validate the waybill number

    if (empty($_POST['start_date'])) {
        $errors['startdate'] = 'Enter the start date';
    } else {
        $startdate = $_POST['start_date'];
    }

    if (empty($_POST['end_date'])) {
        $errors['finishdate'] = 'Enter the end date';
    } else {
        $finishdate = $_POST['end_date'];
    }
  if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    }
    else {
        $data['success']=true;
    }
   echo json_encode($data);
}