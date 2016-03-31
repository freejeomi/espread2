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

$today=date("Y-m-d");

$table = 'stockledger';

if(!$sidx) $sidx =1;
$empty="";

$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table");
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
//if there is a search
if(isset($_GET['stock_name']) && isset($_GET['startdate']) && isset($_GET['finishdate'])){
$stock_name=$_GET['stock_name'];
$startdate=$_GET['startdate'];
$finishdate=$_GET['finishdate'];
//There is finish date selected
if(!empty($finishdate) && $finishdate!=""){

    if($stock_name == 'all_stock'){
        $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table WHERE stockledger.update_date BETWEEN '$startdate' AND '$finishdate'");
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
    $sql="SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE stockledger.update_date BETWEEN '$startdate' AND '$finishdate' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
    else{
        $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table WHERE stockledger.update_date BETWEEN '$startdate' AND '$finishdate' AND stockledger.stock_id=$stock_name");
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
        $sql="SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE stockledger.update_date BETWEEN '$startdate' AND '$finishdate' AND stockledger.stock_id=$stock_name ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}

//There is no finish date selected
else{
    if($stock_name == 'all_stock'){
        $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table WHERE stockledger.update_date='$startdate'");
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
        $sql="SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE stockledger.update_date='$startdate' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
    else{
        $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table WHERE stockledger.update_date='$startdate' AND stockledger.stock_id=$stock_name");
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
        $sql="SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE stockledger.update_date='$startdate' AND stockledger.stock_id=$stock_name ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}

}
else{
    $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table WHERE stockledger.update_date ='$today'");
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
    $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE stockledger.update_date='$today' ORDER BY $sidx $sord LIMIT $start , $limit";
}

}
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'nc'){//does not contains
        $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'in'){//is in
        $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ni'){//is not in
        $sql = "SELECT stockledger.stock_ledger_id, stockledger.update_date,stockledger.update_time,stock.stock_name,store.store_name,stockledger.task,stockledger.opening_bal,stockledger.quantity,stockledger.closing_bal,stockledger.remarks,users.username FROM stockledger INNER JOIN stock ON stockledger.stock_id = stock.stock_id INNER JOIN store ON stockledger.store_id = store.store_id INNER JOIN users ON stockledger.user_id = users.user_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}
    $result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));
$responce = new StdClass;
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

    $i=0;
//$responce= array();
if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
        $responce->rows[$i]['id']=$row['stock_ledger_id'];
        $responce->rows[$i]['cell']=array( $row['update_date'],$row['update_time'],$row['stock_name'],$row['store_name'],$row['task'],($row['opening_bal']), $row['quantity'],$row['closing_bal'],$row['remarks'],$row['username']);
        $i++;
    }
}
else{
    $responce->rows[$i]['id']=$empty;
    $responce->rows[$i]['cell']=array( $empty,$empty,$empty,$empty,$empty,$empty, $empty,$empty,$empty,$empty);
}

    echo json_encode($responce);

//For Search Method




?>