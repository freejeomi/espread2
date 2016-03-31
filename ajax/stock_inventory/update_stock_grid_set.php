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
//else {
//    echo "connected";
//}
$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];

if(!$sidx) $sidx =1;
if(($_GET['_search']) == 'true'){

//    initialize values for stock_name, stock description and supplier name

    if(isset($_GET['stock_name']) ){$stock_name = $_GET['stock_name'];}
    if(isset($_GET['stock_code'])){$stock_code = $_GET['stock_code'];}
    if(isset($_GET['supplier_name'])){$supplier_name = $_GET['supplier_name'];}
    $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM stock");
//$result = mysqli_query($conn, "SELECT * FROM users");
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
    $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE stock.stock_name LIKE '%$stock_name%' OR stock.stock_code LIKE '%$stock_code%'OR supplier.supplier_name LIKE '%$supplier_name%'ORDER BY $sidx $sord LIMIT $start , $limit";
    $result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));

    $i=0;
//$responce= array();
    while($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
        $responce->rows[$i]['id']=$row['stock_id'];
        $responce->rows[$i]['cell']=array($row['stock_id'], $row['stock_name'],$row['stock_code'], $row['supplier_name']);
        $i++;
    }
    echo json_encode($responce);}
mysqli_close($conn);


?>