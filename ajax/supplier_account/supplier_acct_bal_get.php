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
//$result = mysqli_query($conn, "SELECT COUNT(amount) AS count FROM supplier_account");
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
//$sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id
//ORDER BY $sidx $sord LIMIT $start , $limit"; 
//$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));


$table = 'supplier_account';

if(!$sidx) $sidx =1;

$result = mysqli_query($conn, "SELECT COUNT(amount) AS count FROM $table");
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
    $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id ORDER BY $sidx $sord LIMIT $start , $limit";
}
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_account.supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id where supplier.$searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id where supplier.$searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id where supplier.$searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id where supplier.$searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id where supplier.$searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id where supplier.$searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id where supplier.$searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'nc'){//does not contains
        $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id where supplier.$searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'in'){//is in
        $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id where supplier.$searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ni'){//is not in
        $sql = "SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id where supplier.$searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
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
	$responce->rows[$i]['id']=$row['supplier_Id'];
	$responce->rows[$i]['cell']=array($row['supplier_Id'], $row['supplier_name'],$row['amount']);
	$i++;
}
echo json_encode($responce);
?>