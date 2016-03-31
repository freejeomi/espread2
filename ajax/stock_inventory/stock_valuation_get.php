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
$array_store=[$empty,$empty,$empty,$empty];
$table='stock';
$total=0;
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

    $sql_stock_dis="SELECT sum(stock_count) as stock_count,(sum(stock_count)*costprice) as total,stock.stock_id,stock_name,stock_code,costprice FROM stock LEFT JOIN stockposition ON stock.stock_id = stockposition.stock_id GROUP BY stock.stock_id  ORDER BY $sidx $sord";

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
                    if(!$row['total']){
                        $row['total']=0;
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
                    array_push($array_reorder[$i],$row['stock_count'],$row['costprice'],number_format($row['total'],2));
                    //PUT IN RESPONCE VALUE
                    $responce->rows[$i]['id']=$row['stock_id'];
                    $responce->rows[$i]['cell']=$array_reorder[$i];
                    $i++;
                    $serial++;
                    $total+=$row['total'];
                }

            }

            //NO STORES, JUST ECHO STOCK AND GENERAL
            else{
                $i=0;
                $serial=1;
                //FETCH THE DATA AND PLACE IT IN RESPONCE
                while($row = mysqli_fetch_assoc($result_dis)) {


                    $responce->rows[$i]['id']=$row['stock_id'];
                    $responce->rows[$i]['cell']=array($row['stock_name'],$row['stock_code'], $row['stock_count'],$row['costprice'],number_format($row['total'],2));
                $total=$row['total'];
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
            array_push($array_store,$empty,$empty,$empty,$empty);


            $responce->rows[$i]['id']=$empty;
            $responce->rows[$i]['cell']=$array_store;
        }
//        END OF ELSE
        $responce->userdata=['stock_code'=>'<span style="font-size: 1.5em">Total</span>','total_val'=> '<span id="grid_total" style="font-size: 1.5em;color: blue;">'.number_format($total).'</span>'];
        echo json_encode($responce);
    }
//    END OF SEARCH TRUE,ECHO RESULT

    //ATLEAST THERE IS A STORE







//end

//for the pages and records and pagination




}



?>