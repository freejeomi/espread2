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
	
	$sup_id="";	

if (isset($_GET['sup_Id'])) {
	$sup_id= $_GET['sup_Id'];
}

if (isset($_GET['supselect_id'])) {
	$sup_id=  $_GET['supselect_id'];
}
	
	
		$page = $_GET['page']; 
		 $limit = $_GET['rows']; 
		 $sidx = $_GET['sidx']; 
		 $sord = $_GET['sord'];
		//$sup_id= $_GET['sup_Id'];
		//$cus_id= 4;
		//if(!$sidx) $sidx =1; 
		//
		//$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM supplier_account where supplier_Id= $sup_id");
		////$result = mysqli_query($conn, "SELECT * FROM users"); 
		//$row = mysqli_fetch_assoc($result); 
		//
		//$count = $row['count'];
		////echo $count;
		//if( $count > 0 && $limit > 0) { 
		//	$total_pages = ceil($count/$limit); 
		//} else { 
		//	$total_pages = 0; 
		//}
		//
		//if ($page > $total_pages) $page=$total_pages;
		//$start = $limit*$page - $limit;
		//if($start <0) $start = 0;
		//
		//$sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND ORDER BY $sidx $sord LIMIT $start , $limit"; 
		//
		//$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));
		
		
		$table = 'supplier_account';

if(!$sidx) $sidx =1;

$result = mysqli_query($conn, "SELECT COUNT(amount) AS count FROM $table where supplier_Id= $sup_id");
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
    $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id ORDER BY $sidx $sord LIMIT $start , $limit";
}
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
		if($searchField == 'credit' || $searchField == 'debit'){
			$searchField = 'amount';
		}
        $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
		
		if($searchField == 'delivery' || $searchField == 'payment'){
			$searchField = 'amount';
		}
		
        $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
		if($searchField == 'delivery' || $searchField == 'payment'){
			$searchField = 'amount';
		}
        $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
		if($searchField == 'delivery' || $searchField == 'payment'){
			$searchField = 'amount';
		}
        $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
		if($searchField == 'delivery' || $searchField == 'payment'){
			$searchField = 'amount';
		}
        $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
		if($searchField == 'delivery' || $searchField == 'payment'){
			$searchField = 'amount';
		}
        $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
		if($searchField == 'delivery' || $searchField == 'payment'){
			$searchField = 'amount';
		}
        $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'nc'){//does not contains
		if($searchField == 'delivery' || $searchField == 'payment'){
			$searchField = 'amount';
		}
        $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'in'){//is in
		if($searchField == 'delivery' || $searchField == 'payment'){
			$searchField = 'amount';
		}
        $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ni'){//is not in
		if($searchField == 'delivery' || $searchField == 'payment'){
			$searchField = 'amount';
		}
        $sql = "SELECT supplier_account.suppliertrans_Id,if(payment_type='delivery', amount, 0.00) AS delivery, if(payment_type='payment', amount, 0.00) AS payment, supplier_account.payment_date, supplier_account.payment_time, supplier_account.payment_type, supplier_account.ref, supplier_account.remark, supplier_account.transaction_type, supplier.supplier_name, users.username FROM supplier_account INNER join supplier on supplier.supplier_id = supplier_account.supplier_id INNER JOIN users ON supplier_account.user_Id=users.user_id where supplier_account.supplier_id = $sup_id AND $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
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
			$responce->rows[$i]['id']=$row['suppliertrans_Id'];
			$responce->rows[$i]['cell']=array($row['suppliertrans_Id'], $row['payment_date'], $row['payment_time'], $row['ref'] ,$row['delivery'],$row['payment'], $row['payment_type'], $row['transaction_type'], $row['remark'], $row['username']);
			$i++;
		}		
	//}
echo json_encode($responce);
?>