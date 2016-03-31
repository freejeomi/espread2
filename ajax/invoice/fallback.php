<?php
$data = array();
include "../../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    $data['message'] = "Oops. something went wrong while connecting to database. please try again";
    $data['success'] = false;
}
$itemid = "";
$stock = "";
$storeid = "";
$qty = "";
$store = "";
$result = "";
$prqty = "";
$prstockid = "";


//if ( isset($_POST['oper'])) {

$store = $_POST['store_name'];
$item_id = $_POST['item_id'];
//echo $store;
//echo $item_id;
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
    $sql = "select quantity, stock.stock_id from promoaccount INNER JOIN stock on stock.stock_code= promoaccount.stock_code WHERE item_id= $item_id";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $data['message'] = "Oops. something went wrong while retrieving quantity from promoaccount. please try again";
        $data['success'] = false;
    } else {
        $returnedpromo = mysqli_num_rows($result);
        if ($returnedpromo > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $prqty = $row['quantity'];
                $prstockid = $row['stock_id'];
            }
        } else {
        }

        $result1 = mysqli_query($conn, "DELETE from invoiceitems_daily where item_id= $item_id");
        if (!$result1) {
            $data['message'] = "Oops. something went wrong while deleting from invoiceitems_daily. please try again";
        } else {
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
                $sql = "UPDATE stockposition SET stock_count= stock_count + $qty WHERE stock_id= $stockid  AND store_id= $storeid ";

                $result3 = mysqli_query($conn, $sql);
                if (!$result3) {
                    $data['message'] = "Oops. something went wrong while updating stock count in stock postion. please try again";
                    $data['success'] = false;
                } else {
                    //echo 'id'.$storeid;
                    //echo 'qty'.$prqty;
                    //echo 'id'.$prstockid;
                    $result5c = mysqli_query($conn, "SELECT stock_id, store_id FROM stockposition WHERE stock_id= $prstockid  AND store_id= $storeid");
                    if (!$result5c) {
                        $data['message'] = "Oops. something went wrong while selecting stockid storeid in stock postion. please try again";
                    } else {
                        $returnedresult = mysqli_num_rows($result5c);
                        if ($returnedresult > 0) {
                            $sql = "UPDATE stockposition SET stock_count= stock_count + $prqty WHERE stock_id= $prstockid  AND store_id= $storeid ";

                            $result4 = mysqli_query($conn, $sql);
                            if (!$result4) {
                                $data['message'] = "Oops. something went wrong while updating stock count in stock postion from promo account. please try again";
                                $data['success'] = false;
                            } else {
                                $data['success'] = true;
                            }
                        } else {
                            $data['success'] = true;
                        }
                    }
                }
            }
        }
    }
}
echo json_encode($data);
//}

?>


<?php
//$num= 500;
//echo number_format($num, 2 '.', ',') ;
?>
