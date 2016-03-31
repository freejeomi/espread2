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

$table = 'vehicle';

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
    $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_id ORDER BY $sidx $sord LIMIT $start , $limit";
} elseif ($_GET['_search'] == 'true') {
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if ($searchOper == 'eq') {//equals to
        $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_id WHERE $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'ne') {//not equals to
        $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_id WHERE $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'bw') {//begins with
        $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_id WHERE $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'bn') {//does not begin with
        $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_idWHERE $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'ew') {//ends with
        $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_id WHERE $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'en') {//does not end with
        $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_id WHERE $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'cn') {//contains
        $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'nc') {//does not contains
        $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'in') {//is in
        $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'ni') {//is not in
        $sql = "select vehicle.vehicle_id, vehicle.vehicle_name, MIN(haulage.balance) AS current_balance FROM vehicle LEFT JOIN haulage on haulage.vehicle_id= vehicle.vehicle_id GROUP BY vehicle.vehicle_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}

$result = mysqli_query($conn, $sql) or die("Couldn't execute query." . mysqli_error($conn));
//end

$i = 0;
//$responce= array();
while ($row = mysqli_fetch_assoc($result)) {
if ($row['current_balance']== NULL) {
$balance= '0.00';
}
else {
$balance= $row['current_balance'];
}
////	//$responce[]= $row;
    $responce->rows[$i]['id'] = $row['vehicle_id'];
    $responce->rows[$i]['cell'] = array($row['vehicle_id'], $row['vehicle_name'], $balance);
    $i++;
}
echo json_encode($responce);
?>