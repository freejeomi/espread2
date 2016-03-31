<?php

include "../../lib/util.php";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//$page = $_GET['page'];
//$limit = $_GET['rows'];
//$sidx = $_GET['sidx'];
//$sord = $_GET['sord'];
//
//if(!$sidx) $sidx =1;
//if(isset($_REQUEST['totalrows'])){
//    $totalrows = $_REQUEST['totalrows'];
//}
//
//if($totalrows) { $limit = $totalrows; }
//
//$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM stockledger");
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
//if ($limit<0) $limit = 0;
//$start = $limit*$page - $limit;
//if($start <0) $start = 0;

$itemid= $_GET['id'];
$sql = "SELECT a.promoacct_id, a.quantity, a.item_id, b.stock_name from promoaccount as a inner join stock as b on b.stock_code= a.stock_code where a.item_id= $itemid";
    $result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));

//for the pages and records and pagination
//$responce = new StdClass;
//$responce->page = $page;
//$responce->total = $total_pages;
//$responce->records = $count;

    $i=0;
    $serial= 1;
//$responce= array();
$returned= mysqli_num_rows($result);
if ($returned > 0){
    while($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
        $responce->rows[$i]['id']=$row['promoacct_id'];
        $responce->rows[$i]['cell']=array( $serial, $row['stock_name'], $row['quantity']);
        $i++;
        $serial++;
    }
}
else {
    $responce->rows[$i]['id']='';
    $responce->rows[$i]['cell']=array( '', '', '');
}
    echo json_encode($responce);


//For Search Method




?>