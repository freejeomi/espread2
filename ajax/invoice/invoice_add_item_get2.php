<?php
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 09/02/2016
 * Time: 10:19
 */
include "../../lib/util.php";
include "../../functions/myfunction.php";
$returned = "";
$button="";
// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    $invoiceid = $_GET['invoice_id'];


$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];
$items_promo_array=array();
$promo='PROMO';
$total='';


$table = 'invoiceitems_daily';
$items_each=array();

if (!$sidx) $sidx = 1;

$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table");
$row = mysqli_fetch_assoc($result);

$count = $row['count'];
if ($count > 0 && $limit > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}

if ($page > $total_pages) $page = $total_pages;
$start = $limit * $page - $limit;
if ($start < 0) $start = 0;
$amttot=0;
if ($_GET['_search'] == 'false') {
    $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid  ORDER BY $sidx $sord";

}

//search is true
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid AND $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid AND $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid AND $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid AND $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid AND $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid AND $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid AND $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'nc'){//does not contains
        $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid AND $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'in'){//is in
        $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid AND $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ni'){//is not in
        $sql = "SELECT item_id, stock.stock_name, selling_price, quantity, charge, discount FROM invoiceitems_daily INNER JOIN stock on stock.stock_id= invoiceitems_daily.stock_id where invoice_num= $invoiceid AND $searchField NOT LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }
}

$result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));
$empty= "";
//$responce = new StdClass;
//$responce->page = $page;
//$responce->total = $total_pages;
//$responce->records = $count;
$i=0;
$serial= 1;
$serial_2=1;
$s=1;
$returned= mysqli_num_rows($result);
if ($returned > 0){
	while($row = mysqli_fetch_assoc($result)) {

		$responce->rows[$i]['id']=$row['item_id'];
		$responce->rows[$i]['cell']=array($serial, $row['stock_name'],refined_number($row['selling_price']), quantity_number($row['quantity']) , refined_number($row['charge']) , refined_number($row['discount']));
        $items_each[$i] = $row['item_id'];
		$i++;
		$serial++;
$s++;
	}
}
else {
	$responce->rows[$i]['id']= $empty;
	$responce->rows[$i]['cell']=array($empty, $empty, $empty, $empty, $empty, $empty);
}
//for total
$sql_invoicesum = "SELECT sum(charge) as total_amount FROM invoiceitems_daily WHERE invoice_num='$invoiceid'";
$result_invoicesum = mysqli_query($conn, $sql_invoicesum);
//put them in a table
while ($row_invoicesum = mysqli_fetch_assoc($result_invoicesum)) {
    $total= refined_number($row_invoicesum['total_amount']);
}
//for promo
if(!empty($items_each)){
    $responce->rows[$i]['id'] = $empty;
    $responce->rows[$i]['cell'] = array($empty, $empty, $empty, '<span><b>Promo Items</b></span>',  $empty, $empty);
    $i++;
foreach($items_each as $item_promo){
    $sql_promo = mysqli_query($conn, "SELECT stock.stock_name,quantity FROM promoaccount INNER JOIN stock ON stock.stock_code=promoaccount.stock_code WHERE item_id='$item_promo'");
    if (mysqli_num_rows($sql_promo) > 0) {
        //$promo_table = '';



        while ($row_promo = mysqli_fetch_assoc($sql_promo)) {

            $responce->rows[$i]['id'] = $empty;
            $responce->rows[$i]['cell'] = array($serial_2,  $row_promo['stock_name'],'0.00',  $row_promo['quantity'], '0.00','0.00');
            $serial_2++;

        }
        $i++;
    }



}




}


$responce->userdata=['stock'=>'<span style="font-size: 1.5em">Total</span>','unit_price'=>'','quantity'=>'','purchase_amount'=> '<span id="grid_total" style="font-size: 1.5em;color: blue;">'.$total.'</span>','discount'=>''];
echo json_encode($responce);