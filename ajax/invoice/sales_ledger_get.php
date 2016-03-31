<?php

include "../../lib/util.php";
//$responce= array();
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


//begin

$table = 'salesinvoice';

$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];

if (!$sidx) $sidx = 1;
//if(isset($_REQUEST['totalrows'])){
//    $totalrows = $_REQUEST['totalrows'];
//}
//
//if($totalrows) { $limit = $totalrows; }

$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table");
//$result = mysqli_query($conn, "SELECT * FROM users");
$row = mysqli_fetch_assoc($result);

$count = $row['count'];
if ($count > 0 && $limit > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}

if ($page > $total_pages) $page = $total_pages;
//if ($limit<0) $limit = 0;
$start = $limit * $page - $limit;
if ($start < 0) $start = 0;

if ($_GET['_search'] == 'false') {
    $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id ORDER BY $sidx $sord LIMIT $start , $limit";
} elseif ($_GET['_search'] == 'true') {
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if ($searchOper == 'eq') {//equals to
        $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id WHERE $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'ne') {//not equals to
        $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id WHERE $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'bw') {//begins with
        $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id WHERE $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'bn') {//does not begin with
        $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'ew') {//ends with
        $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id WHERE $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'en') {//does not end with
        $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id WHERE $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'cn') {//contains
        $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'nc') {//does not contains
        $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'in') {//is in
        $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if ($searchOper == 'ni') {//is not in
        $sql = " SELECT invoice_num, sales_date, sales_time, purchase_amount, cashier, store.store_name, payment_type, status, store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN store ON store.store_id= salesinvoice_daily.store INNER JOIN users ON users.user_id= salesinvoice_daily.user_id INNER JOIN customer ON customer.customer_id= salesinvoice_daily.customer_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}

$result = mysqli_query($conn, $sql) or die("Couldn't execute query." . mysqli_error($conn));
//end

//for the pages and records and pagination
$responce = new StdClass;
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

$i = 0;
//$responce= array();
while ($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
    $responce->rows[$i]['id'] = $row['invoice_num'];
    $responce->rows[$i]['cell'] = array($row['invoice_num'], $row['invoice_num'], $row['sales_date'], $row['sales_time'], $row['customer_name'], $row['cashier'], $row['store_name'], $row['purchase_amount'], $row['payment_type'], $row['status'], $row['username'], $row['store_confirmation']);
    $i++;
}
echo json_encode($responce);
?>