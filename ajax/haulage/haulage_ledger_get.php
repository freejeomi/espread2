<?php

include "../../lib/util.php";



// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];

//if(!$sidx) $sidx =1;
//
//$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM cashier");
////$result = mysqli_query($conn, "SELECT * FROM users");
//$row = mysqli_fetch_assoc($result);
//
//$count = $row['count'];
//if( $count > 0 && $limit > 0) {
//    $total_pages = ceil($count/$limit);
//} else {
//    $total_pages = 0;
//}
//
//if ($page > $total_pages) $page=$total_pages;
//$start = $limit*$page - $limit;
//if($start <0) $start = 0;
//$sql = "SELECT * FROM cashier ORDER BY $sidx $sord LIMIT $start , $limit";
//$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));


//begin

$table = 'haulage';

if (!$sidx) $sidx = 1;

$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table");
$row = mysqli_fetch_assoc($result);

$count = $row['count'];
if ($count > 0 && $limit > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}

if ($page > $total_pages) $page = $total_pages;
$start = $limit * $page - $limit;
if ($start < 0) $start = 0;

if ($_GET['_search'] == 'false') {
    $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id ORDER BY $sidx $sord LIMIT $start , $limit";
} elseif ($_GET['_search'] == 'true') {
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if ($searchOper == 'eq') {//equals to
        $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id WHERE $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'ne') {//not equals to
        $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id WHERE $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'bw') {//begins with
        $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id WHERE $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'bn') {//does not begin with
        $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id WHERE $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'ew') {//ends with
        $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id WHERE $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'en') {//does not end with
        $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id WHERE $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'cn') {//contains
        $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'nc') {//does not contains
        $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'in') {//is in
        $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'ni') {//is not in
        $sql = "SELECT haulage_id, trans_date, trans_time, waybill, note, expenditure, bbfwd, haulage.balance, vehicle.vehicle_name  FROM $table INNER JOIN vehicle on vehicle.vehicle_id= haulage.vehicle_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}

$result = mysqli_query($conn, $sql) or die("Couldn't execute query." . mysqli_error($conn));
//end

$i = 0;
//$responce= array();
while ($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
    $responce->rows[$i]['id'] = $row['haulage_id'];
    $responce->rows[$i]['cell'] = array($row['haulage_id'], $row['trans_date'], $row['trans_time'], $row['waybill'], $row['note'], $row['expenditure'], $row['bbfwd'], $row['balance'], $row['vehicle_name']);
    $i++;
}
echo json_encode($responce);
?>