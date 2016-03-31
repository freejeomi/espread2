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

//if(!$sidx) $sidx =1;
//
//$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM promo");
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
//
//$sql = "SELECT promo.promo_id,promo.stock_name,promo.purchase_qty,promo.stock_name2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo  ORDER BY $sidx $sord LIMIT $start , $limit";
//$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));

$table = 'promo';

if(!$sidx) $sidx =1;

$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table");
$row = mysqli_fetch_assoc($result);

$count = $row['count'];
if( $count > 0 && $limit > 0) {
    $total_pages = ceil($count/$limit);
}
 else {
    $total_pages = 0;
}

if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit;
if($start <0) $start = 0;

if($_GET['_search'] == 'false'){
    $sql = "SELECT promo.promo_id,promo.stock_code,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo ORDER BY $sidx $sord LIMIT $start , $limit";
}
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT promo.promo_id,promo.stock_code,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo WHERE $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT promo.promo_id,promo.stock_code,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo WHERE $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT promo.promo_id,promo.stock_code,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo WHERE $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT promo.promo_id,promo.stock_code,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo WHERE $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT promo.promo_id,promo.stock_code,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo WHERE $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT promo.promo_id,promo.stock_code,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo WHERE $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT promo.promo_id,promo.stock_code,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'nc'){//does not contains
        $sql = "SELECT promo.promo_id,promo.stock_name,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'in'){//is in
        $sql = "SELECT promo.promo_id,promo.stock_code,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ni'){//is not in
        $sql = "SELECT promo.promo_id,promo.stock_code,promo.purchase_qty,promo.stock_code2,promo.purchase_qty2,promo.giveaway_stock,promo.giveaway_qty,promo.promo_status FROM promo WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}

$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));
//end

//for the pages and records and pagination
$responce = new StdClass;
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$sql2="";
$stockcode1="";
$stockcode2="";
$stockcode3="";
$i=0;
$row_stockcode2_exact="";
while($row = mysqli_fetch_assoc($result)) {
    //GET EACH ROW STOCK CODE 1 AND 2 AND THE GIVEAWAY STOCK CODE
    $stockcode1=$row['stock_code'];
    $stockcode2=$row['stock_code2'];
    $stockcode3=$row['giveaway_stock'];
   // echo $stockcode2;

//    GET THEIR STOCK NAMES

// FOR STOCK CODE 1
    $sql_stockcode1="SELECT stock_name FROM stock WHERE stock_code = '$stockcode1' LIMIT 1";
    $result_stockcode1 = mysqli_query( $conn, $sql_stockcode1) or die("Couldn't execute query.".mysqli_error($conn));
    $row_stockcode1 = mysqli_fetch_array($result_stockcode1);

//    FOR STOCK CODE 2
    if(!empty($stockcode2) && $stockcode2!=""){
        $sql_stockcode2="SELECT stock_name FROM stock WHERE stock_code = '$stockcode2' LIMIT 1";
        $result_stockcode2 = mysqli_query( $conn, $sql_stockcode2) or die("Couldn't execute query.".mysqli_error($conn));
        $row_stockcode2 = mysqli_fetch_array($result_stockcode2);
        $row_stockcode2_exact=$row_stockcode2[0];

    }
    else{
        $row_stockcode2_exact="";
    }

    // FOR STOCKCODE 3
    $sql_stockcode3="SELECT stock_name FROM stock WHERE stock_code = '$stockcode3' LIMIT 1";
    $result_stockcode3 = mysqli_query( $conn, $sql_stockcode3) or die("Couldn't execute query.".mysqli_error($conn));
    $row_stockcode3 = mysqli_fetch_array($result_stockcode3);

    $responce->rows[$i]['id']=$row['promo_id'];
    $responce->rows[$i]['cell']=array($row['promo_id'], $row_stockcode1[0],$row['purchase_qty'],$row_stockcode2_exact,$row['purchase_qty2'],$row_stockcode3[0], $row['giveaway_qty'],$row['promo_status']);

    $i++;
}
echo json_encode($responce);
?>