<?php
    $data 			= array();
$dataliststock = "";    // array to pass back data
    
    include "../../lib/util.php";
include "../../functions/myfunction.php";

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }   
    
    //script to retrieve info for invoice form
    if (isset($_POST['opts']) && isset($_POST['store_name'])) {
        $stockselect = $_POST['opts'];
        $store_name=$_POST['store_name'];
        $store_id='';
        //get store_id
        $sql_store="SELECT store_id FROM store WHERE store_name='$store_name'";
        $result_store=mysqli_query( $conn, $sql_store);
        while($row_store = mysqli_fetch_array($result_store)){
            $store_id=$row_store[0];
        }


        $sql= "SELECT stock.stock_id, slab, stock_code, high_purchase, low_purchase, stockposition.stock_count FROM stock INNER JOIN stockposition ON stockposition.stock_id= stock.stock_id WHERE stock.stock_id= '$stockselect' AND stockposition.store_id='$store_id'";
        $result = mysqli_query( $conn, $sql);
        if (!$result) {
            $data['message']="Oops. something went wrong while retrieving from database. please try again";
        }
        else {
            while($row = mysqli_fetch_assoc($result)) {
                $data['slab']= quantity_number($row['slab']) ;
                $data['lower_price']= refined_number($row['low_purchase']) ;
                $data['higher_price']= refined_number($row['high_purchase']) ;
                $data['count']= quantity_number($row['stock_count']) ;
                $data['stock_code']= $row['stock_code'];
            }
        }
        echo json_encode($data);
    }

//script to cancel invoice form
if(isset($_POST['invoice_num_cancel']) && isset($_POST['store'])){
        $invoice_num_cancel=$_POST['invoice_num_cancel'];
    $store_name=$_POST['store'];
    $se=0;
    $result_query=array();
   // $item_id="";

    //FIRST UPDATE THE STOCK
    $sql_select="SELECT stock_id,quantity,item_id FROM invoiceitems_daily WHERE invoice_num='$invoice_num_cancel'";
    $result_select=mysqli_query($conn,$sql_select);
    //select took place
    if($result_select){
        while($row=mysqli_fetch_assoc($result_select)){
            $stock_id=$row['stock_id'];
            $quantity=$row['quantity'];
            $item_id=$row['item_id'];
            $sql_update="UPDATE stockposition INNER JOIN store ON store.store_id=stockposition.store_id SET stock_count=stock_count+$quantity WHERE stock_id=$stock_id AND store_name='$store_name' ";
            if(mysqli_query($conn,$sql_update)){

            //DELETE THE PROMO ITEMS AND UPDATE STOCK POSITION
                $sql = "SELECT promoaccount.quantity, stock.stock_id FROM promoaccount INNER JOIN stock ON stock.stock_code = promoaccount.stock_code
  INNER JOIN invoiceitems_daily ON invoiceitems_daily.item_id = promoaccount.item_id
  WHERE invoiceitems_daily.item_id = $item_id";
                $result3 = mysqli_query($conn, $sql);
                if (!$result3) {
                    $data['message'] = "Oops. something went wrong while retrieving quantity from promoaccount. please try again";
                    $data['success'] = false;
                }

               //SELECT WORKED, YEA!!!
                 else {
                    $returnedpromo = mysqli_num_rows($result3);
                     //there is something tied to the invoice on the rpomo account table
                    if ($returnedpromo > 0) {
                        while ($row = mysqli_fetch_assoc($result3)) {
                            $prqty = $row['quantity'];
                            $prstockid = $row['stock_id'];

                            //update the stock table
                            $sql = "UPDATE stockposition INNER JOIN store ON store.store_id=stockposition.store_id SET stock_count= stock_count + $prqty WHERE stock_id= $prstockid  AND store_name= '$store_name' ";

                            $result5 = mysqli_query($conn, $sql);
                            if($result5){

                            }
                            else{
                                $result_query[$se]="false";
                            }
                            $se++;
                        }

                        //if all the updates worked
                        if (empty($result_query)) {
                            $data['success'] = true;
                            $data['message'] = 'deleted';
                        }

//                        THEN, THERE IS AN ERROR SOMEWHERE
                        else{
                            $data['success'] = false;
                            $data['message'] = 'could not update stockposition';
                        }
                        }
    //END OF ELSE SELECT
                }




            }

            //SELECT DID NOT WORK
            else{
                $data['success']=false;
                $data['message']='could not update stockposition';

            }
        }

        $sql_del="DELETE FROM salesinvoice_daily WHERE invoice_num='$invoice_num_cancel'";
        if(mysqli_query($conn,$sql_del)){
            $data['success'] = true;
            $data['message']='deleted';
        }
        else{
            $data['success']=false;
            $data['message']='could not connect';
        }
    }
    else{
        $data['success']=false;
        $data['message']='could not connect';
    }


    //delet from salesinvoice daily


    echo json_encode($data);
    }


    if (isset ($_POST['status']) && isset ($_POST['invoice_num_select']) ) {
        $invoicenum= $_POST['invoice_num_select'];
        $status= $_POST['status'];
        $sql= "UPDATE salesinvoice_daily SET status= '$status' WHERE invoice_num= $invoicenum";
        $result= mysqli_query($conn, $sql);
        if(!$result){
            $data['message'] = "Oops. something went wrong while updating status in database. please try again";
            $data['success'] = false;
        }
        else{
            $data['success'] = true;
            $data['message'] = 'updated';
        }
        echo json_encode($data);
    }

if(isset($_POST['store_name_stock'])) {

    $store_name= $_POST['store_name_stock'];
    $sql_store = "SELECT store_id FROM store WHERE store_name='$store_name'";
    $result_store = mysqli_query($conn, $sql_store);
    while ($row_store = mysqli_fetch_array($result_store)) {
        $store_id = $row_store[0];
        //echo $store_id;
    }
    $result = mysqli_query($conn, "SELECT stockposition.stock_id, stock.stock_name, store_id FROM stockposition, stock WHERE stockposition.stock_id= stock.stock_id AND stockposition.store_id= $store_id AND stock.block != 1") or die("Couldn't execute query." . mysqli_error($conn));

    while ($row = mysqli_fetch_assoc($result)) {
        //$defaultstock = "<option value='none'>--please select stock--</option>";
        $dataliststock = $dataliststock . "<option value='{$row['stock_id']}'>{$row['stock_name']}</option>";

        $data['stock_list']= $dataliststock;
        $data['success'] = true;
    }
    echo json_encode($data);
}

mysqli_close($conn);
?>