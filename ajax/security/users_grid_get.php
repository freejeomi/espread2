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
//$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM users");
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
//$sql = "SELECT users.user_id, users.username, users.password, roles.role_name FROM users inner join roles on roles.role_id= users.role_id ORDER BY $sidx $sord LIMIT $start , $limit"; 
//$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));


$table = 'users';

if(!$sidx) $sidx =1;

$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table WHERE username != 'superadmin' AND username != 'teamalpha'");
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
    $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id AND username != 'superadmin' AND username != 'teamalpha' ORDER BY $sidx $sord LIMIT $start , $limit";
}
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id WHERE $searchField = '$searchString' AND username != 'superadmin' AND username != 'teamalpha'ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id WHERE $searchField != '$searchString' AND username != 'superadmin' AND username != 'teamalpha'ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id WHERE $searchField LIKE '$searchString%' AND username != 'superadmin' AND username != 'teamalpha' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id WHERE $searchField NOT LIKE '$searchString%' AND username != 'superadmin' AND username != 'teamalpha' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id WHERE $searchField LIKE '%$searchString' AND username != 'superadmin' AND username != 'teamalpha' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id WHERE $searchField NOT LIKE '%$searchString' AND username != 'superadmin' AND username != 'teamalpha' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id WHERE $searchField LIKE '%$searchString%' AND username != 'superadmin' AND username != 'teamalpha' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'nc'){//does not contains
        $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id WHERE $searchField NOT LIKE '%$searchString%' AND username != 'superadmin' AND username != 'teamalpha' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'in'){//is in
        $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id WHERE $searchField LIKE '%$searchString%' AND username != 'superadmin' AND username != 'teamalpha' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ni'){//is not in
        $sql = "SELECT users.user_id, users.username, roles.role_name FROM users inner join roles on roles.role_id= users.role_id WHERE $searchField NOT LIKE '%$searchString%' AND username != 'superadmin' AND username != 'teamalpha' ORDER BY $sidx $sord LIMIT $start , $limit";
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
//$responce= array();
while($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
	$responce->rows[$i]['id']=$row['user_id'];
	$responce->rows[$i]['cell']= array($row['user_id'], $row['user_id'], $row['username'], $row['role_name']);
	$i++;
}
echo json_encode($responce);
?>