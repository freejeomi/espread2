<?php

include "../../lib/util.php";
include "../../lib/config.php";

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
$store_count="";
$table="stock";

//GET THE STORES IF PRESENT
$sql_store="SELECT store_id,store_name FROM store WHERE useinreorder=1";
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
        $store_id=new ArrayIterator($store_id);
        $store_name=new ArrayIterator($store_name);
        $storenameid=new MultipleIterator;
        $storenameid->attachIterator($store_id);
        $storenameid->attachIterator($store_name);
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
$serial=1;
if($_GET['_search'] == 'false'){

//    GET THE STOCK
    $i=0;
    $inner=0;

    $sql_stock_dis="SELECT A.stock_id,stock_code,stock_name,reorder_level,stock_count FROM (SELECT stock_code,stock_id,stock_name,reorder_level FROM stock) AS A LEFT JOIN (SELECT stock_id,sum(stock_count) as stock_count FROM stockposition INNER JOIN store ON store.store_id = stockposition.store_id WHERE store.includeingeneral=1 GROUP BY stock_id) AS B ON A.stock_id=B.stock_id GROUP BY A.stock_id ORDER BY $sidx $sord ";

    //QUERY FOR STOCK WORKED
    if($result_dis=mysqli_query($conn,$sql_stock_dis)){

        //THERE ARE STOCKS,
        if(mysqli_num_rows($result_dis)) {

            //GET THE GENERAL STOCK COUNT

            while ($row = mysqli_fetch_assoc($result_dis)) {

//                there is actually reorder
                if(!$row['stock_count']){
                    $row['stock_count']=0;
                }
                if ($row['reorder_level']) {


                    //REORDER LEVEL IS GREATER THAN STOCK COUNT
                    if ($row['reorder_level'] > $row['stock_count']) {
                        $general = "<span style='color: red'>".number_format($row['reorder_level']) . "&nbsp;[" . number_format($row['stock_count']) . "]</span>";
                    } //REORDER LEVEL IS LESS THAN STOCK COUNT
                    else {
                        $general = number_format($row['reorder_level']) . "&nbsp;[" . number_format($row['stock_count']) . "]";
                    }
                }

                //REORDER LEVEL IS NULL OR ZERO
                else {
                    $general = "0&nbsp;[".$row['stock_count']."]";
                }


//            THERE ARE STORES,GET STOCK REORDER AND POSITION

                if ($number_store > 0) {


                    $stockid=$row['stock_id'];
                    $array_reorder[$i]=[$row['stock_name'],$row['stock_code'], $general];

                    foreach ($storenameid as $storeid) {
                        $result_store_dis = mysqli_query($conn, "SELECT reorder_level_store,stock_count FROM stockposition WHERE stock_id=$stockid and store_id=$storeid[0]");
                        if (mysqli_num_rows($result_store_dis)) {
                            $store_reorder = mysqli_fetch_array($result_store_dis);
                            //THE STORE REORDER IS NOT ZERO OR NULL
                            if($store_reorder[0]){

                                //THE STORE REORDER IS GREATER THAN COUNT
                                if($store_reorder[0]>$store_reorder[1]){
                                    $store_count="<a href='".APP_URL."/index.php#ajax/update_stock.php?store_id=".$storeid[0]."&store_name=".$storeid[1]."&stock_id=".$row['stock_id']."&stock_name=".$row['stock_name']."' class='hoverover' title='Update Stock count for ".$row['stock_name']." in ".$storeid[0]."' style='font-weight: bold;color: red'>".number_format($store_reorder[0])."&nbsp;[".number_format($store_reorder[1])."]</a>";
                                }
                                //THE STORE REORDER IS LESS THAN COUNT
                                else{
                                    $store_count=number_format($store_reorder[0])."&nbsp;[".number_format($store_reorder[1])."]";
                                }
                            }
                            //THE STORE REORDER IS ZERO OR NULL
                            else{
                                $store_count="0 &nbsp;[".$store_reorder[1]."]";
                            }
                            array_push($array_reorder[$i], $store_count);
                        }

                        else {
                            array_push($array_reorder[$i], "0&nbsp;[]");
                        }

                    }
                    //PUT IN RESPONCE VALUE
                    $responce->rows[$i]['id'] = $row['stock_id'];
                    $responce->rows[$i]['cell'] = $array_reorder[$i];



                } //NO STORES, JUST ECHO STOCK AND GENERAL
                else {

                    //FETCH THE DATA AND PLACE IT IN RESPONCE


                    $responce->rows[$i]['id'] = $row['stock_id'];
                    $responce->rows[$i]['cell'] = array( $row['stock_id'], $row['stock_name'], $row['stock_code'], $general);

                    //$serial++;

                }
                $i++;
                $serial++;
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




?>