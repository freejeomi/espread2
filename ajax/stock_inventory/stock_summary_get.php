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

//VARIABLES NEEDED
$store_id=array();
$store_name=array();
$total_table="";
$thead="";
$counter_store=0;
$counter_stock=0;
$tbody="";
$stock_number=0;
$stock_code=array();
$stock_name=array();
$stock_id=array();
$trow_stock="";
$serial=1;
$number_store=0;
$array_reorder=array();

$stock_count_array=array();
$empty="";
$array_store=[$empty,$empty,$empty];
$table='stock';


//GET THE STORES IF PRESENT
$sql_store="SELECT store_id,store_name FROM store";
$result_store=mysqli_query($conn,$sql_store);

//QUERY WAS EXECUTED
if($result_store){

//THERE ARE STORES
    if(mysqli_num_rows($result_store) > 0)
    {
        //SAVE THE NUMBER OF STORES
        $number_store=mysqli_num_rows($result_store);

//        FECTH THE STORE ID AND STORE NAME, SAVE IN A N ARRAY
        while($row_store=mysqli_fetch_array($result_store)){
            $store_id[$counter_store]=$row_store[0];
            $store_name[$counter_store]=$row_store[1];
            $counter_store++;
        }

    }
    else{
        $number_store=0;
    }
}

$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];




if(!$sidx) $sidx =1;
if(isset($_REQUEST['totalrows'])){
    $totalrows = $_REQUEST['totalrows'];
}

if($totalrows) { $limit = $totalrows; }

$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM $table");
//$result = mysqli_query($conn, "SELECT * FROM users");
$row = mysqli_fetch_assoc($result);

$count = $row['count'];
if( $count > 0 && $limit > 0) {
    $total_pages = ceil($count/$limit);
} else {
    $total_pages = 0;
}

if ($page > $total_pages) $page=$total_pages;
if ($limit<0) $limit = 0;
$start = $limit*$page - $limit;
if($start <0) $start = 0;
if($_GET['_search'] == 'false'){

//    GET THE STOCK
    $i=0;
    $inner=0;

    $sql_stock_dis="SELECT sum(stock_count) as stock_count,stock.stock_id,stock_name,stock_code FROM stock LEFT JOIN stockposition ON stock.stock_id = stockposition.stock_id GROUP BY stock.stock_id  ORDER BY $sidx $sord ";

    //QUERY FOR STOCK WORKED
    if($result_dis=mysqli_query($conn,$sql_stock_dis)){

        //THERE ARE STOCKS,
        if(mysqli_num_rows($result_dis)){

//            THERE ARE STORES
            if($number_store>0){
                $i=0;
                $serial=1;

                while($row = mysqli_fetch_assoc($result_dis)) {
                    if(!$row['stock_count']){
                        $row['stock_count']=0;
                    }
                    $array_reorder[$i]=[$row['stock_name'],$row['stock_code']];
                    $stockid=$row['stock_id'];
                    foreach($store_id as $storeid){
                        $result_store_dis=mysqli_query($conn,"SELECT stock_count FROM stockposition WHERE stock_id=$stockid and store_id=$storeid");
                        if(mysqli_num_rows($result_store_dis)){
                            $store_reorder=mysqli_fetch_array($result_store_dis);
                            array_push($array_reorder[$i],$store_reorder[0]);
                        }
                        else{
                            array_push($array_reorder[$i],0);
                        }

                    }
                    array_push($array_reorder[$i],$row['stock_count']);
                    //PUT IN RESPONCE VALUE
                    $responce->rows[$i]['id']=$row['stock_id'];
                    $responce->rows[$i]['cell']=$array_reorder[$i];
                    $i++;
                    $serial++;
                }

            }

            //NO STORES, JUST ECHO STOCK AND GENERAL
            else{
                $i=0;
                $serial=1;
                //FETCH THE DATA AND PLACE IT IN RESPONCE
                while($row = mysqli_fetch_assoc($result_dis)) {


                    $responce->rows[$i]['id']=$row['stock_id'];
                    $responce->rows[$i]['cell']=array($row['stock_name'],$row['stock_code'], $row['stock_count']);

                    $i++;
                    $serial++;
                }
            }

        }

        //NO STOCK, NO ARRAY
        else {
//            THERE ARE STORES, SO JUST PUSH IN MORE EMPTY
            if($number_store>0){
                foreach($store_id as $storeid1){
                    array_push($array_store,$empty);
                }
            }
            array_push($array_store,$empty,$empty);


            $responce->rows[$i]['id']=$empty;
            $responce->rows[$i]['cell']=$array_store;
        }
//        END OF ELSE

        echo json_encode($responce);
    }
//    END OF SEARCH TRUE,ECHO RESULT

    //ATLEAST THERE IS A STORE







//end

//for the pages and records and pagination




}

//IF THERE SEARCH CONDUCTED, THEN
elseif($_GET['_search'] == 'true'){
    $searchField = $_GET['searchField'];
    $searchString = $_GET['searchString'];
    $searchOper = $_GET['searchOper'];

    if($searchOper == 'eq'){//equals to
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField = '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ne'){//not equals to
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField != '$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bw'){//begins with
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'bn'){//does not begin with
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField NOT LIKE '$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'ew'){//ends with
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'en'){//does not end with
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField NOT LIKE '%$searchString' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    if($searchOper == 'cn'){//contains
        $sql = "SELECT stock.stock_id, stock.stock_code, stock.stock_name, stock.costprice,  stock.high_purchase, stock.low_purchase, stock.slab,stock.block, stock.reorder_level, supplier.supplier_name, category.category_name FROM stock INNER JOIN supplier ON supplier.supplier_id = stock.supplier_id INNER JOIN category ON stock.category_id = category.category_id WHERE $searchField LIKE '%$searchString%' ORDER BY $sidx $sord LIMIT $start , $limit";
    }

    $result = mysqli_query( $conn, $sql) or die("Couldn't execute query.".mysqli_error($conn));
//end

//for the pages and records and pagination


    $i=0;
    $explode_array='';
//$responce= array();
    while($row = mysqli_fetch_assoc($result)) {
////	//$responce[]= $row;
        $explode_array=explode('-',$row['stock_code']);
        $responce->rows[$i]['id']=$row['stock_id'];
        $responce->rows[$i]['cell']=array($row['stock_id'],$row['category_name'], $explode_array[1], $row['stock_code'], $row['stock_name'],$row['costprice'], $row['high_purchase'],$row['low_purchase'],$row['slab'],$row['block'],$row['reorder_level'],$row['supplier_name']);

        $i++;
    }
    echo json_encode($responce);
}

?>