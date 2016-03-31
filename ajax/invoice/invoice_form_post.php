<?php
    $errors         = array();  	// array to hold validation errors
    $data 			= array();      // array to pass back data
    
    $store="";
    $stock="";
    
    
    
    
    $itemid=  "";
    $invoicenum= "";
    $stockcode= "";
    $invoiceqty= "";
    $result= "";
    $storeid="";
    
    $promoid= "";
    $promostock1= "";
    $promoqty1= "";
    $promogiveawaystock= "";
    $promogiveawayqty= "";
    $promostock2= "";
    $promoqty2= "";
    $promostatus= "";
    $promotracker= "";
    $promostockid="";
    
    //$store= "";
    //$stock= "";
    $invoiceqty2= "";
    $givaway="";
    
    include "../../lib/util.php";

    include "../../functions/myfunction.php";
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }   
    
    
    //if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['check'])) {
        
        if (empty($_POST['invoice_num'])){
            $errors['message']= "Sorry an error occured in invoice number";
        }
        else {
            $invoice= $_POST['invoice_num'];
        }
        if ($_POST['quantity']=="none"){
            $errors['quantity']= "enter quantity";
        }
        else {
            $quantity= $_POST['quantity'];
        }
        
        if ($_POST['stock']=="none") {
            $errors['stock'] = 'select stock';
        }        
        else {
            $stock = $_POST['stock'];
        }
        
        if ($_POST['agreed-price']== "") {
            $errors['message'] = 'Sorry an error occured in agreed price.';
        }
        elseif ($_POST['agreed-price']== "0") {
            $errors['message'] = 'Sorry agreed price cannot be 0. Please confirm stock price from the stock setup';
        }
        else{
            $agreedprice= $_POST['agreed-price'];            
        }
        if ($_POST['total-price'] == "") {
            $errors['message'] = 'Sorry an error occured in total price.';
        }
        elseif ($_POST['total-price']== "0") {
            $errors['message'] = 'Sorry total price cannot be 0. Please confirm stock price from the stock setup';
        }
        else{
            $totalprice= $_POST['total-price'];            
        }
         
        if (empty($_POST['store'])) {
            $errors['message'] = 'Sorry an error occured in store.';
        }
        else{
            $store= $_POST['store'];
            
            $result = mysqli_query( $conn, "SELECT store_id from store where store_name= '$store'");
            if (! $result) {
                $data['message']="Oops. something went wrong while retrieving store id from store. please try again";
            }         
            else {
                while($row = mysqli_fetch_assoc($result)) {
                    $storeid= $row['store_id'];
                }
            }
        }
        $date= date("y:m:d");         
        
            
        if ( ! empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        }
        else {	     
            $sql = "INSERT INTO invoiceitems_daily(selling_price, quantity, charge, trans_date, stock_id, invoice_num) VALUES
                ('$agreedprice', '$quantity', '$totalprice', '$date', '$stock', '$invoice')";
            if (!mysqli_query($conn, $sql)) {
                $data['message']="Oops. something went wrong while inserting into database. please try again";
            }
            else {
                
                $last_id = mysqli_insert_id($conn);
                //echo $last_id;
                $sql = "Select SUM(charge) AS total from invoiceitems_daily where invoice_num= $invoice";
                $result= mysqli_query($conn, $sql);
                if (! $result) {
                    $data['message']="Oops. something went wrong while inserting into database. please try again";
                }         
                else {
                    while($row = mysqli_fetch_assoc($result)) {
                        $data['total'] =refined_number($row['total']);
                        //format_number('980766');
                        //$data['success']= true;
                    }
                    
                    $sql= "UPDATE stockposition SET stock_count= stock_count-$quantity WHERE stock_id=$stock AND store_id= $storeid ";
                     $result = mysqli_query( $conn, $sql);
                    if (!$result) {
                        $data['message']="Oops. something went wrong while updating stock count in stock postion. please try again";
                    }
                    $sql= "SELECT item_id, stock.stock_code, invoice_num, quantity FROM invoiceitems_daily inner join stock on stock.stock_id = invoiceitems_daily.stock_id where item_id= $last_id";
                    //echo $last_id;
                    $result = mysqli_query( $conn, $sql);
                    if (!$result) {
                        $data['message']="Oops. something went wrong while retrieving from invoiceitems_daily. please try again";
                    }
                    else {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $itemid=  $row['item_id'];
                            $invoicenum= $row['invoice_num'];
                            $stockcode= $row['stock_code'];
                            $invoiceqty= $row['quantity'];                         
                        }                    
                        $result1 = mysqli_query( $conn, "SELECT * from promo where (stock_code= '$stockcode' AND $invoiceqty >= purchase_qty AND promo_status= 'active') OR (stock_code2= '$stockcode' AND $invoiceqty >= purchase_qty2 AND promo_status= 'active') ");
                        if (!$result1) {
                            $data['message']="Oops. something went wrong while retrieving from promo. please try again";
                        }
                        else {
                            $returnedrow= mysqli_num_rows($result);
                            //echo 'match row  '.$returnedrow;
                            if ($returnedrow > 0) {

                                //as long as there is a match in the promo table, enter this block of code
                                while ($row = mysqli_fetch_assoc($result1)) {
                                    $promoid = $row['promo_id'];
                                    $promostock1 = $row['stock_code'];
                                    $promoqty1 = $row['purchase_qty'];
                                    $promogiveawaystock = $row['giveaway_stock'];
                                    $promogiveawayqty = $row['giveaway_qty'];
                                    $promostock2 = $row['stock_code2'];
                                    $promoqty2 = $row['purchase_qty2'];
                                    $promostatus = $row['promo_status'];
                                    $promotracker = $row['tracker'];

                                    //enters this block of code if promo tracker is 1
                                    if ($promotracker == 1)
                                    {
                                        $promoquantity = floor($invoiceqty / $promoqty1) * $promogiveawayqty;
                                        $promodate = date('y/m/d');
                                        $sql = "INSERT into promoaccount (quantity, trans_date, stock_code, promo_id, item_id) VALUES ('$promoquantity', '$promodate', '$promogiveawaystock', '$promoid', '$itemid' )";
                                        $result = mysqli_query($conn, $sql);
                                        if (!$result) {
                                            $data['message'] = "Oops. something went wrong while inserting into promoacct. please try again";
                                        } else {
                                            $result = mysqli_query($conn, "SELECT stock_id from stock where stock_code= '$promogiveawaystock'");
                                            if (!$result) {
                                                $data['message'] = "Oops. something went wrong while retrieving stock id from stock for promo product. please try again";
                                            } else {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $promostockid = $row['stock_id'];
                                                   // echo $promogiveawaystock;
                                                   // echo $promostockid;
                                                }
                                                $sql = "UPDATE stockposition SET stock_count= stock_count-$promoquantity WHERE stock_id='$promostockid' AND store_id= $storeid ";
                                                $result = mysqli_query($conn, $sql);
                                                if (!$result) {
                                                    $data['message'] = "Oops. something went wrong while updating stock count in stock postion from promo. please try again";
                                                } else {
                                                    $data['success'] = true;
                                                }
                                            }
                                            //echo 'promo tracker is 1';
                                        }
                                    }
                                    // enters this block of code if promo tracker is 2

                                    else if ($promotracker == 2)
                                    {
                                        
                                        if ($stockcode == $promostock1)
                                        {
                                            $sql = "SELECT item_id, stock.stock_code, invoice_num, quantity FROM invoiceitems_daily inner join stock on stock.stock_id = invoiceitems_daily.stock_id where invoice_num= $invoice";
                                            $resultc = mysqli_query($conn, $sql);
                                            if (!$resultc) {
                                                $data['message'] = "Oops. something went wrong while retrieving from invoiceitems_daily stock2. please try again";
                                                //echo $promogiveawaystock;
                                            } else {
                                                //$returnedrow2= mysqli_num_rows($result);
                                                //echo 'row2' .$returnedrow2;
                                                //if ($returnedrow2> 0)
                                                //{
                                                while ($row = mysqli_fetch_assoc($resultc)) {
                                                    $itemid2 = $row['item_id'];
                                                    //$invoicenum2= $row['invoice_num'];
                                                    $stockcode2 = $row['stock_code'];
                                                    $invoiceqty2 = $row['quantity'];
                                                    if (($stockcode2 == $promostock2) && ($invoiceqty2 >= $promoqty2)) {
                                                        //echo 'stock code 2: '.$stockcode2;
                                                        //echo $promogiveawaystock;
                                                        $givaway = 0;
                                                        while (($invoiceqty >= $promoqty1) && ($invoiceqty2 >= $promoqty2)) {
                                                            $invoiceqty = $invoiceqty - $promoqty1;
                                                            $invoiceqty2 = $invoiceqty2 - $promoqty2;
                                                            $givaway += $promogiveawayqty;
                                                            //echo 'giveaway is: '.$givaway;
                                                        }
                                                        $promodate = date('y/m/d');

                                                        //$data['success']= true;
                                                        $sql = "INSERT into promoaccount (quantity, trans_date, stock_code, promo_id, item_id) VALUES ('$givaway', '$promodate', '$promogiveawaystock', '$promoid', '$itemid' )";
                                                        $result2 = mysqli_query($conn, $sql);
                                                        if (!$result2) {
                                                            $data['message'] = "Oops. something went wrong while retrieving from promoacct. please try again";
                                                        } else {
                                                            $result = mysqli_query($conn, "SELECT stock_id from stock where stock_code= '$promogiveawaystock'");
                                                            //echo $promogiveawaystock;
            if (!$result) {
                                                                $data['message'] = "Oops. something went wrong while retrieving stock id from stock for promo product tracker 2. please try again";
                                                            } else {
                                                                while ($row= mysqli_fetch_assoc($result)) {
                                                                    $promostockid = $row['stock_id'];
                                                                }
                                                                $sql = "UPDATE stockposition SET stock_count= stock_count-$givaway WHERE stock_id=$promostockid AND store_id= $storeid ";
                                                                $result = mysqli_query($conn, $sql);
                                                                if (!$result) {
                                                                    $data['message'] = "Oops. something went wrong while updating stock count in stock postion from promo. please try again";
                                                                } else {
                                                                    $data['success'] = true;
                                                                }
                                                            }
                                                            //$data['success'] = true;
                                                            //echo 'promo tracker is 1';
                                                        }
                                                    }
                                                }
                                                //}
                                            }
                                        }
                                        else if ($stockcode == $promostock2)
                                        {
                                            $sql = "SELECT item_id, stock.stock_code, invoice_num, quantity FROM invoiceitems_daily inner join stock on stock.stock_id = invoiceitems_daily.stock_id where invoice_num= $invoice";
                                            $results = mysqli_query($conn, $sql);
      if (!$results) {
                                                $data['message'] = "Oops. something went wrong while retrieving from invoiceitems_daily stock2. please try again";
                                            }
                                            else
                                            {
                                                while ($row = mysqli_fetch_assoc($results))
                                                {
                                                    $itemid2 = $row['item_id'];
                                                    //$invoicenum2= $row['invoice_num'];
                                                    $stockcode2 = $row['stock_code'];
                                                    $invoiceqty2 = $row['quantity'];


                                                    if (($stockcode2 == $promostock1) && ($invoiceqty2 >= $promoqty1))
                                                    {
                                                        //echo 'stock code 2: '.$stockcode2;
                                                        $givaway = 0;
                                                        while (($invoiceqty >= $promoqty1) && ($invoiceqty2 >= $promoqty2))
                                                        {
                                                            $invoiceqty = $invoiceqty - $promoqty1;
                                                            $invoiceqty2 = $invoiceqty2 - $promoqty2;
                                                            $givaway += $promogiveawayqty;
                                                            //echo 'giveaway is: '.$givaway;
                                                        }
                                                        $promodate = date('y/m/d');

                                                        //echo 'outside: '.$givaway;

                                                        //$data['success']= true;
                                                        
                                                        $sql = "INSERT into promoaccount (quantity, trans_date, stock_code, promo_id, item_id) VALUES ('$givaway', '$promodate', '$promogiveawaystock', '$promoid', '$itemid' )";
                                                        $result3 = mysqli_query($conn, $sql);
                                                        if (!$result3) {
                                                            $data['message'] = "Oops. something went wrong while inserting into promoacct. please try again";
                                                        } else
                                                        {
                                                            $result = mysqli_query($conn, "SELECT stock_id from stock where stock_code= '$promogiveawaystock'");
                                                            if (!$result) {
                                                                $data['message'] = "Oops. something went wrong while retrieving stock id from stock for promo product. please try again";
                                                            } else
                                                            {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $promostockid = $row['stock_id'];
                                                                }
                                                                $sql = "UPDATE stockposition SET stock_count= stock_count-$givaway WHERE stock_id=$promostockid AND store_id= $storeid ";
                                                                $result = mysqli_query($conn, $sql);
                                                                if (!$result) {
                                                                    $data['message'] = "Oops. something went wrong while updating stock count in stock postion from promo. please try again";
                                                                } else {
                                                                    $data['success'] = true;
                                                                }
                                                            }
                                                            

                                                            //$data['success'] = true;
                                                            //echo 'promo tracker is 1';
                                                        }
                                                    }
                                                }
                                                //}                 
                                            }
                                        }
                                        else {
                                            $data['success'] = true;
                                        }
                                    }
                                    //promo tracker 2 ends
                                }
                                //while promo loop ends
                            }
                            else {
                                $data['success'] = true;
                                $data['message']= "no record was returned";
                            }
                            $data['success']= true;
                        }
                        //else condition for promo match ends
                    }
                    //retrieval of last id record is successful
                }
                //sum of amount is done successfully
            }
            //if inserted into invoiceitems_daily successfully
        }
        //if no data.errors
        echo json_encode($data);
    }
    //}
    //if submitted true POST
    mysqli_close($conn);        
?>