<?php
$data 			= array();
    include "../../lib/util.php";
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        $data['message']="Oops. something went wrong while connecting to database. please try again";
        $data['success'] = false;
    }
    $itemid= "";
    $stock= "";
    $storeid="";
    $qty= "";
    $store= "";
    $result= "";
    $prqty= "";
    $prstockid="";
    $result= "";
    $sql= "";

if(isset($_GET['store_name'])){
    $store = $_GET['store_name'];
}
else{
    $store = $_POST['store_name'];
}
if(isset($_POST['id'])){
$item_id=$_POST['id'];
}
else{
    $item_id = $_POST['item_id'];
}


//select from invoice items table to get quantity and stock_id of item to be deleted
$sql = "select quantity, stock_id from invoiceitems_daily where item_id= $item_id";
$result = mysqli_query($conn, $sql);
if (!$result) {
    $data['message'] = "Oops. something went wrong while retrieving quantity from invoiceitems_daily. please try again";
    $data['success'] = false;
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $qty = $row['quantity'];
        $stockid = $row['stock_id'];
    }
    $result2 = mysqli_query($conn, "SELECT store_id from store WHERE store_name= '$store'");
    if (!$result2) {
        $data['message'] = "Oops. something went wrong while retrieving store id from store. please try again";
        $data['success'] = false;
    } else {
        while ($row = mysqli_fetch_assoc($result2)) {
            $storeid = $row['store_id'];
            //echo 'storeid:'.$storeid;
            //echo'ii'. $item_id;
        }
        //select quantity and stock_id in promoaccount for the item promo to be deleted
        $sql = "select quantity, stock.stock_id from promoaccount INNER JOIN stock on stock.stock_code= promoaccount.stock_code WHERE item_id= $item_id";
        $result3 = mysqli_query($conn, $sql);
        if (!$result3) {
            $data['message'] = "Oops. something went wrong while retrieving quantity from promoaccount. please try again";
            $data['success'] = false;
        }
        else {
            $returnedpromo = mysqli_num_rows($result3);
            if ($returnedpromo > 0) {
                while ($row = mysqli_fetch_assoc($result3)) {
                    $prqty = $row['quantity'];
                    $prstockid = $row['stock_id'];
                }
                //delete item frpm invoice items table..also affects the promo table due to itemid link
                $result4 = mysqli_query($conn, "DELETE from invoiceitems_daily where item_id= $item_id");
                if (!$result4) {
                    $data['message'] = "Oops. something went wrong while deleting from invoiceitems_daily. please try again";
                } else {
                    //update stock position quantity of item deleted from invoice items table
                    $sql = "UPDATE stockposition SET stock_count= stock_count + $qty WHERE stock_id= $stockid  AND store_id= $storeid ";

                    $result5 = mysqli_query($conn, $sql);
                    if (!$result5) {
                        $data['message'] = "Oops. something went wrong while updating stock count in stock postion. please try again";
                        $data['success'] = false;
                    } else {
                        //echo 'id'.$storeid;
                        //echo 'qty'.$prqty;
                        //echo 'id'.$prstockid;

                        //update stock position quantity of promo item deleted from promo account
                        $result6= mysqli_query($conn, "UPDATE stockposition SET stock_count= stock_count + $prqty WHERE stock_id= $prstockid  AND store_id= $storeid");
//                        $result6 = mysqli_query($conn, "SELECT stock_id, store_id FROM stockposition WHERE stock_id= $prstockid  AND store_id= $storeid");
                        if (!$result6) {
                            $data['message'] = "Oops. something went wrong while selecting stockid storeid in stock postion. please try again";
                            $data['success'] = false;
                        } else {
                            $data['success'] = true;
                        }
                    }
                }
            }
            else {
            //promo quantity check doesnt bring out result. go ahead to delete item from invoice item table
                $result7 = mysqli_query($conn, "DELETE from invoiceitems_daily where item_id= $item_id");
                if (!$result7) {
                    $data['message'] = "Oops. something went wrong while deleting from invoiceitems_daily. please try again";
                    $data['success'] = false;
                } else {
                    //update stock position quantity of item deleted from invoice items table
                    $sql = "UPDATE stockposition SET stock_count= stock_count + $qty WHERE stock_id= $stockid  AND store_id= $storeid ";

                    $result8 = mysqli_query($conn, $sql);
                    if (!$result8) {
                        $data['message'] = "Oops. something went wrong while updating stock count in stock postion. please try again";
                        $data['success'] = false;
                    } else {
                        $data['success'] = true;
                    }
                }
            }
        }
    }
    echo json_encode($data);
}
?>

<?php
function format_number($raw_num) {
    $format_num= "";
    $format_num= $raw_num;
    echo number_format($format_num, 2, '.', ',') ;
}
//$num= 500;
//echo number_format($num, 2, '.', ',') ;
?>
