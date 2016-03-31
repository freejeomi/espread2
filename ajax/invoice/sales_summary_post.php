<?php
$errors = array();    // array to hold validation errors
$data = array();        // array to pass back data

$stock_name= "";
$store_id= "";

if (isset($_POST['store_id'])) {
//validate the waybill number
    if (empty($_POST['store_id'])) {
        $errors['store'] = "select a store please";
    }
    else if($_POST['store_id']== "none"){
        $errors['store'] = "select a store please";
    }
    else {
        $store_id = $_POST['store_id'];
    }
//validate the expenditure amount
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