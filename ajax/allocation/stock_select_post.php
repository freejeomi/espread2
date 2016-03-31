<?php
$data= array();
include "../../lib/util.php";
include "../../functions/myfunction.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['store_id'])) {
    $store_id= "";
    $stock= "";
    $store_id= $_POST['store_id'];
    if ($store_id == "all"){
        $sql = "SELECT stock_id, stock_name, stock_code FROM stock ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $stock .= "<option value='{$row['stock_id']}'>{$row['stock_code']}: {$row['stock_name']}</option>";
                //echo $stock;
                $data['stock_select'] = $stock;
                //$data['stock_count']= $row['stock_count'];
            }
        }
    }
    else {
        $sql = "SELECT stockposition.stock_id, stock.stock_name, stock.stock_code FROM stockposition INNER JOIN stock on stock.stock_id = stockposition.stock_id WHERE store_id= '$store_id' ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $stock .= "<option value='{$row['stock_id']}'>{$row['stock_code']}: {$row['stock_name']}</option>";
                //echo $stock;
                $data['stock_select'] = $stock;
                //$data['stock_count']= $row['stock_count'];
            }
        }
    }
echo json_encode($data);
}

if (isset($_POST['stock_id']) && isset($_POST['store_id_stock'])){
    $stock_id= $_POST['stock_id'];
    $store_id= $_POST['store_id_stock'];

    if ($store_id == "all") {
        $sql = "SELECT SUM(stock_count) AS quantity FROM stockposition  WHERE stock_id= '$stock_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data['stock_count'] = $row['quantity'];
            }
        }
    }
    else {
        $sql = "SELECT stock_count AS quantity FROM stockposition  WHERE store_id= '$store_id' AND stock_id= '$stock_id' ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data['stock_count']= $row['quantity'];
            }
        }
    }
echo json_encode($data);
}