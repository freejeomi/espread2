<?php

include "../../lib/util.php";
$empty= "";
//ini_set("display_errors","1");
//$servername = "localhost";
//$username = "root";
//$password = "Heaven192";
//$dbname = "espread";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//else {
//    echo "connected";
//}


$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];

//if(!$sidx) $sidx =1;
//
//$result = mysqli_query($conn, "SELECT COUNT(amount) AS count FROM customer_transaction WHERE amount < 0");
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
//$sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 ORDER BY $sidx $sord LIMIT $start , $limit";
//$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));


$table = 'customer_transaction';

if(!$sidx) $sidx =1;

$result = mysqli_query($conn, "SELECT COUNT(amount) AS count FROM $table WHERE amount < 0");
$row = mysqli_fetch_assoc($result);

$count = $row['count'];
if( $count > 0 && $limit > 0) {
    $total_pages = ceil($count/$limit);
} else {
    $total_pages = 0;
}

if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit;
if($start <0) $start = 0;

if($_GET['_search'] == 'false'){
    $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 ORDER BY $sidx $sord LIMIT $start , $limit";
}elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 AND $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 AND $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 AND $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 AND $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 AND $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 AND $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 AND $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'nc'){//does not contains
        $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 AND $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'in'){//is in
        $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 AND $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ni'){//is not in
        $sql = "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0 AND $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}

$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));

$responce = new StdClass;
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$i=0;
//$responce= array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
        $responce->rows[$i]['id'] = $row['customer_Id'];
        $responce->rows[$i]['cell'] = array($row['customer_Id'], $row['customer_name'], number_format($row['amount']) , $row['phone'], $row['email']);
        $i++;
    }
}
else {
    $responce->rows[$i]['id'] = $empty;
    $responce->rows[$i]['cell'] = array($empty, $empty, $empty, $empty, $empty);
    $i++;
}
echo json_encode($responce);
?>