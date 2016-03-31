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
//$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM stock");
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
//$sql = "SELECT stock.stock_id,stock.stock_name,stock.costprice,stock.sales_person_price,stock.high_purchase,stock.low_purchase,stock.slab,stock.block,stock.reorder_level,supplier.supplier_name,category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id ORDER BY $sidx $sord LIMIT $start , $limit";
//$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));



//$table = 'supplier';

if(!$sidx) $sidx =1;

$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM stock");
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
    $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id ORDER BY $sidx $sord LIMIT $start , $limit";
}
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}
$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));
//end

//for the pages and records and pagination
$responce = new StdClass;
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

$i=0;
$explode_array='';
//$responce= array();
while($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
$explode_array=explode('-',$row['stock_code']);
    $responce->rows[$i]['id']=$row['stock_id'];
    $responce->rows[$i]['cell']=array($row['stock_id'],$row['category_name'], $explode_array[1], $row['stock_code'], $row['stock_name'],$row['costprice'], $row['high_purchase'],$row['low_purchase'],$row['slab'],$row['block'],$row['reorder_level'],$row['supplier_name']);

    $i++;
}
echo json_encode($responce);
?>