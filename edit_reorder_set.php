<?php
$sql= "";
$result= "";
include "lib/util.php";
$success_func=false;
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$data=array();
if(isset($_POST['stock_id'])){
$stock_id=$_POST['stock_id'];

    if(isset($_POST['general'])){
        $general=$_POST['general'];
        $sql_general="UPDATE stock SET reorder_level=$general WHERE stock_id=$stock_id";
        $result_general=mysqli_query($conn,$sql_general);
    if($result_general){
        if(isset($_POST['data'])){
            $arrray_to_change=json_decode($_POST['data']);
            // print_r($arrray_to_change) ;
            $reorder=$arrray_to_change->reorder;
            //$reorder=$arrray_to_change->reorder;
            $stores=$arrray_to_change->store_id;
            // echo print_r($reorder);
            $reorder=$arrray_to_change->reorder;
            $reorder=$arrray_to_change->reorder;
            $stores=$arrray_to_change->store_id;
            // print_r($reorder) ;
            $reorder=new ArrayIterator($reorder);

            $stores=new ArrayIterator($stores);
            $reorder_store = new MultipleIterator;
            $reorder_store->attachIterator($reorder);
            $reorder_store->attachIterator($stores);

            foreach($reorder_store as $update) {
               // echo $update[0], ' | ', $update[1], "\n";
                $sql_select="SELECT * FROM stockposition WHERE stock_id=$stock_id AND store_id=$update[1]";
                $result_select=mysqli_query($conn,$sql_select);
                if(mysqli_num_rows($result_select) > 0){
                    $sql_update="UPDATE stockposition SET reorder_level_store=$update[0] WHERE stock_id=$stock_id AND store_id=$update[1]";
                    $result_update=mysqli_query($conn,$sql_update);
                }
                else{
                $sql_insert="INSERT INTO stockposition ( stock_id, store_id, unit, stock_count,reorder_level_store) VALUES($stock_id,$update[1],'0','0',$update[0])";
                $result_insert=mysqli_query($conn,$sql_insert);

                }

            }
//echo print_r($reorder);
            $success_func=true;

        }
    else{
    $data['success']=false;
    $data['message']="error";
    }

    }
    else{
        $data['success']=false;
        $data['message']="error";
    }

    }

    else{
        $data['success']=false;
        $data['message']="error";
    }
}
else{
    $data['success']=false;
    $data['message']="error";
}
if($success_func){
    //Data Success
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

    $stock_count_array=array();
//QUERY FOR STORE
    $sql_store="SELECT store_id,store_name FROM store WHERE useinreorder=1";
    $result_store=mysqli_query($conn,$sql_store);

//QUERY WAS EXECUTED
    if($result_store){

//THERE ARE STORES
        if(mysqli_num_rows($result_store) > 0)
        {
            $number_store=mysqli_num_rows($result_store);
            $thead="<thead id=".$number_store."><tr ><th class='text-center' colspan='".($number_store + 5)."' style='font-size: 2em;'>Edit Reorder Level</th></tr><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th><th>General</th>";
            while($row_store=mysqli_fetch_assoc($result_store)){
                $thead.="<th>".$row_store['store_name']."</th>";
                $store_id[$counter_store]=$row_store['store_id'];
                $counter_store++;

//END OF WHILE LOOP
            }
            $thead.="<th>Update</th></tr></thead>";

        }
        else{
            $thead="<thead id=".$number_store."><tr ><th class='text-center hidden-print' colspan='".($number_store + 5)."' style='font-size: 2em;'>Edit Reorder Level</th></tr><tr ><th class='text-center visible-print' colspan='".($number_store + 4)."' style='font-size: 2em;'>Manage Reorder Level<span class='text-danger'>(Only General Store)</span></th></tr><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th><th>General</th><th class='hidden-print'>Update</th></tr></thead>";
        }


    }
//Get the Stock ID and Name And Stock Code
    $sql_stock="SELECT stock_id,stock_code,stock_name,reorder_level FROM stock";
    $result_stock=mysqli_query($conn,$sql_stock);

//IF THE QUERY RAN
    if($result_stock){
// CHECK IF THERE IS A STOCK AT ALL
        if(mysqli_num_rows($result_stock)>0){

// IF THERE IS START TBODY
            $tbody="<tbody>";

// GET THE NUMBER OF THE STOCK I.E THE COUNT
            $stock_number=mysqli_num_rows($result_stock);

// FETCH EACH RESULT
            while($row_stock=mysqli_fetch_assoc($result_stock)){
// GET THE STOCK ID
                $stock_id[$counter_stock]=$row_stock['stock_id'];

                // MAKE THE TBODY HAVE A SERIAL NUMBER
                $tbody.="<tr><td>".$serial."</td><td><input type='hidden' value='".$row_stock['stock_id']."'>".$row_stock['stock_name']."</td><td>".$row_stock['stock_code']."</td><td><input type='text' value='".$row_stock['reorder_level']."'></td>";
                // LOOP THRU THE STORES AND GET THE COUNT FOR EACH STOCK
                $i=0;
                foreach($store_id as $store){

//GET THE STOCK COUNT
                    $sql_position="SELECT reorder_level_store as reorder_level FROM stockposition WHERE stock_id='$stock_id[$counter_stock]' AND store_id='$store'";
                    $result_position=mysqli_query($conn,$sql_position);

                    // IF THE QUERY RAN....
                    if($result_position){
                        // CHECK IF THERE IS A ROW
                        if(mysqli_num_rows($result_position)>0){
                            // GET THE STOCK COUNT AND RUN THROUGH IT AGAIN
                            while($row_position=mysqli_fetch_assoc($result_position)){
                                $tbody.="<td><input type='text' class='reorder_level' value='".$row_position['reorder_level']."'><input type='hidden'  class='store_reorder' value='".$store."'></td>";
                                //$stock_count_array[$i]=$row_position['stock_count2'];
                            }
                        }

                        // IF THERE IS NO ROW, GIVE THE COUNT AS A ZERO
                        else{
                            $tbody.="<td><input type='text' class='reorder_level' value='0'><input type='hidden'  class='store_reorder' value='".$store."'></td>";
                            $stock_count_array[$i]=0;
                        }



                    }
                    $i++;
                }


                $tbody.="<td><button class='btn btn-primary btn-sm btn_update' onclick='updateItem(this)'>Update</button></td></tr>";
                $serial++;


                $counter_stock++;
            }

            $tbody.="</tbody>";
        }

    }
    $data['success']=true;
    $data['message']=$thead.$tbody;



}
echo json_encode($data);
