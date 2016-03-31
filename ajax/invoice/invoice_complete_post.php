<?php
    $errors         = array();  	// array to hold validation errors
    $data 			= array();      // array to pass back data
   
    include "../../lib/util.php";
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }   
    
    if (isset($_POST['invoice_num'])){
        if (empty($_POST['invoice_num'])){
            $data['message']= "Sorry, an error occured in invoice post. please try again";
            $data['success'] = false;
        }
        else {
            $invoicenum= $_POST['invoice_num'];
        }
        
        if (empty($_POST['total_amount'])){
            $data['message']= "Sorry, an error occured in amount post. please try again";
            $data['success'] = false;
        }
        else {
            $totalamount= $_POST['total_amount'];
            //$a = "1,435";
            $b = str_replace( ',', '', $totalamount );

            if( is_numeric( $b ) ) {
                $totalamount = $b;
            }
        }
        
        if (empty($_POST['customer'])){
            $data['message']= "Sorry, an error occured in customer post. please try again";
            $data['success'] = false;
        }
        else {
            $customer= $_POST['customer'];
            $result= mysqli_query($conn, "SELECT customer_id from customer WHERE customer_name= '$customer'");
            if (!$result) {
                $data['message']= "Sorry, an error occured in retrieving customer ID. please try again";
            }
            else {
                while($row = mysqli_fetch_assoc($result)) {
				$customerid= $row['customer_id']; 
                }
            }
        }
        
        if (empty($_POST['payment'])){
            $data['message']= "Sorry, an error occured in payment post. please try again";
            $data['success'] = false;
        }
        else {
            $paymenttype= $_POST['payment'];
        }
        if (empty($_POST['user_id'])){
            $data['message']= "Sorry, an error occured in retrieving user id. please try again";
            $data['success'] = false;
        }
        else {
            $userid= $_POST['user_id'];
        }
        
        if (empty($_POST['cashstock'])) {
            $data['message']= "Sorry, an error occured in cashstock post. please try again";
            $data['success'] = false;
        }        
        else {
            $cashstock = $_POST['cashstock'];
            
            $status= "CLOSED";
            $date= date('Y-m-d');
            $time= date('h:i:s');
            $transactiontype= "customer payment";
            //$userid=26;
            $empty= "";
            $invoicenum= $_POST['invoice_num'];
            
            $sql= "UPDATE salesinvoice_daily SET purchase_amount= $totalamount, status= '$status', sales_date= '$date', sales_time= '$time' WHERE invoice_num= $invoicenum";
            $result= mysqli_query($conn, $sql);
            if (!$result) {
                $data['message']= "An error occured while updating sales invoice daily";
                $data['success']=false;
            }
            else{
                if($paymenttype=="CREDIT"){
                //insert into the customer acct with the amount as negative
                    $totalamount=0-$totalamount;
                    $sql = "INSERT into customer_transaction (date, time, payment_type, invoice_num, amount, remark, transaction_type, user_id, customer_id) VALUES ('$date', '$time', '$paymenttype', '$invoicenum', '$totalamount', '$empty', '$transactiontype', '$userid', '$customerid')";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        $data['message'] = "An error occured while inserting into customer transaction";
                        $data['success'] = false;

                    }
                }
                //enter the customer account twice as negative then positive
                elseif ($paymenttype == "CASH") {

                    //insert into the customer acct with the amount as negative
                    $totalamount = 0 - $totalamount;
                    $sql = "INSERT into customer_transaction (date, time, payment_type, invoice_num, amount, remark, transaction_type, user_id, customer_id) VALUES ('$date', '$time', '$paymenttype', '$invoicenum', '$totalamount', '$empty', '$transactiontype', '$userid', '$customerid')";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        $data['message'] = "An error occured while inserting into customer transaction";
                        $data['success'] = false;

                    }

                    else {
                        //insert into the customer acct with the amount as positive
                        $totalamount= 0 - $totalamount;
                        $sql = "INSERT into customer_transaction (date, time, payment_type, invoice_num, amount, remark, transaction_type, user_id, customer_id) VALUES ('$date', '$time', '$paymenttype', '$invoicenum', '$totalamount', '$empty', '$transactiontype', '$userid', '$customerid')";
                        $result = mysqli_query($conn, $sql);
                        if (!$result) {
                            $data['message'] = "An error occured while inserting into customer transaction";
                            $data['success'] = false;

                        }
                    }
                }

                if ($cashstock=="on"){
                    //check if that invoice num is already there
                    $sql_select="SELECT ref_code,payment_type FROM cashstock WHERE ref_code='$invoicenum' AND transaction_type='$transactiontype' LIMIT 1";
                    $result_select=mysqli_query($conn,$sql_select);
                    if($result_select){
                    // if that customer has already been put in the cashstock
                        if(mysqli_num_rows($result_select)>0){
                            $sql_update="UPDATE cashstock SET amount=$totalamount WHERE ref_code='$invoicenum' AND transaction_type='$transactiontype'";
                            $result_update=mysqli_query($conn,$sql_update);
                            if (!$result_update) {
                                $data['message']= "An error occured while updating into cash stock";
                                $data['success'] = false;

                            }
                            else {
                                $data['success']= true;
                            }
                        }
                        //else insert into cash stock
                        else{
                            $sql= "INSERT into cashstock (date, particulars, amount, remark, ref_code, time, payment_type, transaction_type, user_id) VALUES ('$date', '$customer', '$totalamount', '$empty', '$invoicenum', '$time', '$paymenttype', '$transactiontype', '$userid')";
                            $result= mysqli_query($conn, $sql);
                            if (!$result) {
                                $data['message']= "An error occured while inserting into cash stock";
                                $data['success'] = false;

                            }
                            else {
                                $data['success']= true;
                            }
                        }
                    }
                    else{
                        $data['message']= "An error occured while selecting from cash stock";
                    }

                }
                else {
                //cash stock is off
                    $data['success'] = true;
                }
            }
        }
    echo json_encode($data);
    }
    
?>