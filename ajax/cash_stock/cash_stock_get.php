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



$table = 'cashstock';

if(!$sidx) $sidx =1;

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
    $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id ORDER BY $sidx $sord LIMIT $start , $limit";
}
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id WHERE $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id WHERE $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id WHERE $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id WHERE $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id WHERE $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id WHERE $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'nc'){//does not contains
        $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'in'){//is in
        $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ni'){//is not in
        $sql = "SELECT cashstock_id, particulars, if(amount >0, amount, 0.00) AS credit, if(amount <0, amount, 0.00) AS debit, date, remark, time, transaction_type, users.username FROM cashstock INNER JOIN users on users.user_id= cashstock.user_id WHERE $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
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
	$responce->rows[$i]['id']=$row['cashstock_id'];
	$responce->rows[$i]['cell']=array($row['cashstock_id'], $row['particulars'], number_format($row['credit'],2), number_format($row['debit'],2), $row['date'], $row['remark'], $row['time'], $row['transaction_type'], $row['username']);
	$i++;
}

// total cashin from cashstock
$sql_total1 = "SELECT sum(amount) AS cashin from cashstock WHERE amount > 0 and transaction_type !='opening balance'";
$result_total1 = mysqli_query($conn, $sql_total1);
//put them in a table
while ($row_total1 = mysqli_fetch_assoc($result_total1)) {
    $total1= number_format($row_total1['cashin'],2);
}
// total cashout from cashstock
$sql_total2 = "SELECT sum(amount) AS cashout from cashstock WHERE amount < 0 and transaction_type !='customer payment'";
$result_total2 = mysqli_query($conn, $sql_total2);
//put them in a table
while ($row_total2 = mysqli_fetch_assoc($result_total2)) {
    $total2= number_format($row_total2['cashout'],2);
    
}
$responce->userdata=['particulars'=>'<span style="font-size: 1.5em">Total</span>','credit'=>'<span style="font-size: 1.5em;color: blue;">'.$total1.'</span>','debit'=>'<span style="font-size: 1.5em;color: blue;">'.$total2.'</span>'];
echo json_encode($responce);
?>

