<?php
//
////$stock_code = array();
////$stock_name = array();
////$reorder_level = array();
////$stock_count = array();
////$success= "";
////$i= 0;
//
//include "../../lib/util.php";
//
//$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//    if (!$conn) {
//        die("Connection failed: " . mysqli_connect_error());
//        $success= false;
//        echo $success;
//    }else{
//        $result = mysqli_query($conn, "SELECT stock_code,stock_name,reorder_level,stockposition.stock_count FROM stock INNER JOIN stockposition ON stockposition.stock_id=stock.stock_id WHERE stockposition.stock_count <= stock.reorder_level")or die("Couldn't execute query.".mysqli_error($conn));
//
//        $count = mysqli_num_rows($result);
//  if ($count > 0){
//
//    /*while(  $row = mysqli_fetch_array($result)){
//        $stock_code[$i]= $row['stock_code'];
//        $stock_name[$i]= $row['stock_name'];
//        $reorder_level[$i]= $row['reorder_level'];
//        $stock_count[$i]= $row['stock_count'];
//        $i++;
//        $success= true;
//        echo 'pass'.$success;
//    }
//    echo 'i'.$stock_name[$i];
//    echo 'j'.$reorder_level[$i];
//    echo 'k'.$stock_count[$i];*/
//    $success= 'true';
//    echo $success.$count;
//  }
//  else {
//    $success= 'false';
//    echo $success;
//  }
// mysqli_close($conn);
//}
//

$sql = "";
$result = "";
include "../../lib/util.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$store_id = array();
$store_name = array();
$total_table = "";
$thead = "";
$counter_store = 0;
$counter_stock = 0;
$tbody = "";
$stock_number = 0;
$stock_code = array();
$stock_name = array();
$stock_id = array();
$trow_stock = "";
$serial = 1;
$number_store = 0;
$count_general = 0;
$count_reorder = 0;
$total_debt= "";

$stock_count_array = array();
if (isset($_GET['alert']) && $_GET['alert'] == 'alert') {
//QUERY FOR STORE
    $sql_store = "SELECT store_id,store_name FROM store WHERE useinreorder=1";
    $result_store = mysqli_query($conn, $sql_store);

//QUERY WAS EXECUTED
    if ($result_store) {

//THERE ARE STORES
        if (mysqli_num_rows($result_store) > 0) {

            $number_store = mysqli_num_rows($result_store);
            $thead = "<thead id=" . $number_store . "><tr ><th class='text-center' colspan='" . ($number_store + 5) . "' style='font-size: 2em;'>Reorder Level [Stock Position]</th></tr><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th><th>General</th>";
            while ($row_store = mysqli_fetch_assoc($result_store)) {
                $thead .= "<th>" . $row_store['store_name'] . "</th>";
                $store_id[$counter_store] = $row_store['store_id'];
                $counter_store++;

//END OF WHILE LOOP
            }
            $thead .= "</tr></thead>";

        }


    }
//Get the Stock ID and Name And Stock Code
    $sql_stock = "SELECT stock_id,stock_code,stock_name,reorder_level FROM stock";
    $result_stock = mysqli_query($conn, $sql_stock);

//IF THE QUERY RAN
    if ($result_stock) {
// CHECK IF THERE IS A STOCK AT ALL
        if (mysqli_num_rows($result_stock) > 0) {

// IF THERE IS START TBODY
            $tbody = "<tbody>";

// GET THE NUMBER OF THE STOCK I.E THE COUNT
            $stock_number = mysqli_num_rows($result_stock);

// FETCH EACH RESULT
            while ($row_stock = mysqli_fetch_assoc($result_stock)) {
// GET THE STOCK ID
                $stock_id[$counter_stock] = $row_stock['stock_id'];

                // MAKE THE TBODY HAVE A SERIAL NUMBER
                $tbody .= "<tr><td>" . $serial . "</td><td><input type='hidden' value='" . $row_stock['stock_id'] . "'>" . $row_stock['stock_name'] . "</td><td>" . $row_stock['stock_code'] . "</td>";
                // LOOP THRU THE STORES AND GET THE COUNT FOR EACH STOCK
                $sql_general = "SELECT SUM(stock_count) as general_count FROM stockposition INNER JOIN store ON store.store_id = stockposition.store_id  WHERE store.includeingeneral=1 AND stock_id=$stock_id[$counter_stock]";
                $result_general = mysqli_query($conn, $sql_general);
                $row_general = mysqli_fetch_array($result_general);
                if ($row_general[0] !== null) {
                    if ($row_general[0] && $row_stock['reorder_level'] >= $row_general[0]) {
                        $tbody .= "<td style='color: red;font-weight: bold'>" . number_format($row_stock['reorder_level']) . "[" . number_format($row_general[0]) . "]</td>";
                        $count_general++;

                    } else {
                        $tbody .= "<td >" . $row_stock['reorder_level'] . "[" . number_format($row_general[0]) . "]</td>";
                    }
                }
                else {
                    if($row_stock['reorder_level'])
                    {
                        $count_general++;
                    }
                    $tbody .= "<td >" . $row_stock['reorder_level'] . "[ ]</td>";
                }
                $i = 0;
                foreach ($store_id as $store) {

//GET THE STOCK COUNT
                    $sql_position = "SELECT reorder_level_store as reorder_level,stock_count FROM stockposition WHERE stock_id='$stock_id[$counter_stock]' AND store_id='$store'";
                    $result_position = mysqli_query($conn, $sql_position);

                    // IF THE QUERY RAN....
                    if ($result_position) {
                        // CHECK IF THERE IS A ROW
                        if (mysqli_num_rows($result_position) > 0) {
                            // GET THE STOCK COUNT AND RUN THROUGH IT AGAIN
                            while ($row_position = mysqli_fetch_assoc($result_position)) {
                                if ($row_position['reorder_level'] > 0 && $row_position['reorder_level'] >= $row_position['stock_count']) {

                                    $tbody .= "<td style='color: red;font-weight: bold'>" . $row_position['reorder_level'] . "[" . number_format($row_position['stock_count']) . "]</td>";
                                    $count_reorder++;
                                    $count_general++;
                                } else {
                                    $tbody .= "<td>" . $row_position['reorder_level'] . "[" . number_format($row_position['stock_count']) . "]</td>";
                                }

                                //$stock_count_array[$i]=$row_position['stock_count2'];
                            }
                        } // IF THERE IS NO ROW, GIVE THE COUNT AS A ZERO
                        else {
                            $tbody .= "<td>0[]</td>";
                            $stock_count_array[$i] = 0;
                        }

                    }
                    $i++;
                }


                $tbody .= "</tr>";
                $serial++;


                $counter_stock++;
            }

            $tbody .= "</tbody>";
        }

    }

    if ($count_general == 0) {
        echo "false";
    } else {
        echo "true" . $count_general;
    }
}

if (isset($_GET['task']) && $_GET['task'] == 'check') {
//echo hi;
$sql= "SELECT customer.customer_Id, customer_name, phone, email, customer_transaction.amount from customer join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id WHERE amount < 0";
$result= mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row= mysqli_fetch_assoc($result)) {
        $total_debt= $total_debt + $row['amount'];
    }
    if ($total_debt >= 0) {
        echo "false";
    }
    else {
        echo "true" . number_format($total_debt, 2);
    }
}
else {
    echo "false";
}

}


if (isset($_GET['task']) && $_GET['task'] == 'pending') {
    $sql = "select status from salesinvoice_daily where status='OPEN'";
    $result = mysqli_query($conn, $sql);
    $pend_num= mysqli_num_rows($result);
    if ($pend_num > 0) {
        echo "true" . number_format($pend_num);
    }
    else {
        echo "false";
    }
}
?>
