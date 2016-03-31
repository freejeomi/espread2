<?php
include "../../lib/util.php";

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
    
$cus_id= $_GET['cus_Id'];
$page = $_GET['page']; 
$limit = $_GET['rows']; 
$sidx = $_GET['sidx']; 
$sord = $_GET['sord'];
//$cus_id= 4;
//if(!$sidx) $sidx =1; 
//
//$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM customer_transaction where customer_id= $cus_id;");
////$result = mysqli_query($conn, "SELECT * FROM users"); 
//$row = mysqli_fetch_assoc($result); 
//
//$count = $row['count'];
////echo $count;
//if( $count > 0 && $limit > 0) { 
//    $total_pages = ceil($count/$limit); 
//} else { 
//    $total_pages = 0; 
//}
//
//if ($page > $total_pages) $page=$total_pages;
//$start = $limit*$page - $limit;
//if($start <0) $start = 0; 
//$sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND ORDER BY $sidx $sord LIMIT $start , $limit"; 
//$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));


$table = 'customer_transaction';

if(!$sidx) $sidx =1;

$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table where customer_id= $cus_id;");
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
    $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id ORDER BY $sidx $sord LIMIT $start , $limit";
}
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'nc'){//does not contains
        $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'in'){//is in
        $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ni'){//is not in
        $sql = "SELECT customer_transaction.transaction_Id, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, customer_transaction.date, customer_transaction.time, customer_transaction.payment_type, customer_transaction.invoice_num, customer_transaction.remark, customer_transaction.transaction_type, customer.customer_name, users.username FROM customer_transaction INNER join customer on customer.customer_Id = customer_transaction.customer_Id INNER JOIN users ON customer_transaction.user_Id=users.user_Id where customer_transaction.customer_Id = $cus_id AND $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}

$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));

//for the pages and records and pagination
$responce = new StdClass;
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

$i=0;
//$responce= array();

while($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
	$responce->rows[$i]['id']=$row['transaction_Id'];
	$responce->rows[$i]['cell']=array($row['transaction_Id'], $row['date'], $row['time'], $row['invoice_num'] ,$row['credit'],$row['debit'], $row['payment_type'], $row['remark'], $row['transaction_type'], $row['username']);
	$i++;
}
echo json_encode($responce);
?>