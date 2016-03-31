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
//For Normal Reload
if(($_GET['_search']) == 'false'){

    $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id ORDER BY $sidx $sord ";
    }
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'nc'){//does not contains
        $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'in'){//is in
        $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ni'){//is not in
        $sql = "SELECT stock.stock_id,stock.stock_code, stock.stock_name,supplier.supplier_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}
    $result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));

$responce = new StdClass;
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
    $i=0;
//$responce= array();
    while($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
        $responce->rows[$i]['id']=$row['stock_id'];
        $responce->rows[$i]['cell']=array($row['stock_id'],$row['stock_code'], $row['stock_name'], $row['supplier_name']);
        $i++;

    }
echo json_encode($responce);
//For Search Method




?>