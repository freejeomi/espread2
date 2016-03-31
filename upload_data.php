<?php
include "lib/util.php";
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 14/01/2016
 * Time: 4:02 PM
 */
//ini_set("display_errors","1");
//$servername = "localhost";
//$username = "root";
//$password = "Heaven192";
//$dbname = "espread";

// Create connection



// Check connection

$upload_date = $_POST['upload_date'];

$operation = $_POST['operation'];
$store_name = "OandSon";
$echod = "0";
$error_insert = "1";
$count=0;
$unit=1;
$closing_bal='';
$opening_bal=0;
$cashin=0;
$cashout=0;
$credit_sales=0;
$e='';
$data=array();
$count_row=0;
$cashstock_array=array();


$credit='CREDIT';

//try connection to both servers
try {
    $db1 = new PDO('mysql:dbname=espread;host=127.0.0.1', 'root', 'Heaven192');
    $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db2 = new PDO('mysql:dbname=espread_online;host=127.0.0.1', 'root', 'Heaven192');
    $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // for upload cash stock
    if($operation == 'upload_cash_stock'){
        try
        {
            $query_select = "SELECT cashstock.cashstock_id, cashstock.particulars, cashstock.remark, cashstock.amount,cashstock.date FROM cashstock WHERE cashstock.date=:upload_date ";
            $result = $db1->prepare($query_select);
           $result->bindParam(':upload_date',$upload_date);
            $result->execute();
            //Get each row
            if($result->rowCount()>0){
            foreach ($result as $row){
                //query so that it will be uniquely done
                $echod = "1";
                $data['success']=true;
                $data['message']='query executed';
                try{
                    $query_unique ="SELECT cashstock_id,date,store_name FROM cashstock WHERE cashstock_id=:cashstock_id AND store_name=:store_name AND cashstock.date=:upload_date";
                    $result_unique=$db2->prepare($query_unique);
                    $result_unique->bindParam(':cashstock_id',$row['cashstock_id']);

                    $result_unique->bindParam(':store_name',$store_name);
                    $result_unique->bindParam(':upload_date',$upload_date);
                    $result_unique->execute();

                    //if there is a row
                    if($result_unique->rowCount()>0){
                        $echod = "1";
                        $data['success']=true;
                        $data['update']='cannot update';



                    }
                    else{
                        $echod = "1";
                        $data['success']=true;
                        $data['message']='inserted';
                        try
                        {
                            $sql_insert = "INSERT INTO cashstock(cashstock_id, date, particulars, amount, remark,store_name)  VALUES(:cashstock_id,:upload_date,:particulars,:amount,:remark,:store_name)";
                            $s = $db2->prepare($sql_insert);
                            $s->bindParam(':amount',$row['amount']);
                            $s->bindParam(':remark',$row['remark']);
                            $s->bindParam(':particulars',$row['particulars']);
                            $s->bindParam(':cashstock_id',$row['cashstock_id']);

                            $s->bindParam(':upload_date',$row['date']);
                            $s->bindParam(':store_name',$store_name);
                            $s->execute();

                        }
                        catch (PDOException $e)
                        {
                            $error_insert = 'insert_failed';
                            $data['success']=false;
                            $data['message']=$e->getMessage();

                        }

                    }

                }
                catch (PDOException $e)
                {
                    $error_insert = "select_unique_failed";
                    $data['success']=false;
                    $data['message']=$e->getMessage();
                }


            }
        }
        else{
        $data['success']=false;
        $data['no_record']='No record found';
        }
        }
        catch (PDOException $e)
        {
            $error_insert = "select_failed";
            $data['success']=false;
            $data['message']=$e->getMessage();
        }
    }

    //for stock table update
    if($operation == 'upload_stock_update'){
    //delete stock from online database
        try{
            $query_unique ="DELETE  FROM stock WHERE  store_name=:store_name";
            $result_unique=$db2->prepare($query_unique);

//                    $result_unique->bindParam(':stock_id',$row['stock_id']);
//                    $result_unique->bindParam(':stock_code',$row['stock_code']);
            $result_unique->bindParam(':store_name',$store_name);
            $result_unique->execute();
            $query_unique_pos ="DELETE  FROM stock_position WHERE  store_name=:store_name";
            $result_unique_pos=$db2->prepare($query_unique_pos);


            $result_unique_pos->bindParam(':store_name',$store_name);
            $result_unique_pos->execute();
            //if there is a row
            $data['success']=true;
            $data['message']='stock_deleted';

//                        $echod = "1";



        }
        catch(PDOException $e){
            $error_insert = "select_unique_failed";
            $data['success']=false;
            $data['message']=$e->getMessage();
        }
        //select and insert
        try
        {

            $query_select = 'SELECT stock_id, stock_code, stock_name, costprice, sales_person_price,high_purchase,low_purchase, slab, sprice, block, reorder_level FROM stock';
            $result = $db1->query($query_select);
            $data['success']=true;
            $data['message']='selected stock';
            //Get each row
            foreach ($result as $row){
                //query so that it will be uniquely done
                $echod = "1";

                $data['success']=true;
                $data['message']='inserted stock';
                try
                {
                    $sql_insert = "INSERT INTO stock(stock_id, stock_code, stock_name, costprice, salesperson_price, high_purchase, low_purchase, slab, sprice, block, reorderlevel,store_name,stock_count )VALUES(:stock_id, :stock_code, :stock_name, :costprice,:sales_person_price,:high_purchase,:low_purchase,:slab,:sprice,:block,:reorder_level,:store_name,:stock_count)";

                    $s = $db2->prepare($sql_insert);
                    $s->bindParam(':stock_id',$row['stock_id']);
                    $s->bindParam(':stock_code',$row['stock_code']);
                    $s->bindParam(':stock_name',$row['stock_name']);
                    $s->bindParam(':costprice',$row['costprice']);
                    $s->bindParam(':sales_person_price',$row['sales_person_price']);
                    $s->bindParam(':high_purchase',$row['high_purchase']);
                    $s->bindParam(':low_purchase',$row['low_purchase']);
                    $s->bindParam(':slab',$row['slab']);
                    $s->bindParam(':sprice',$row['sprice']);
                    $s->bindParam(':block',$row['block']);
                    $s->bindParam(':reorder_level',$row['reorder_level']);
                    $s->bindParam(':store_name',$store_name);
                    $s->bindParam(':stock_count',$count);
                    $s->execute();



                }
                catch (PDOException $e)
                {
                    $error_insert = "insert_failed";
                    $data['success']=false;
                    $data['message']=$e->getMessage();

                }
                try
                {
                    $sql_position = "INSERT INTO stock_position(stock_id, store_name, stock_count ) VALUES(:stock_id, :store_name,:stock_count)";
                    //$sql_update = "UPDATE stock_position SET stock_count=:stock_count,unit=:unit WHERE stock_id=:stock_id  AND store_id=:store_id ";
                    $s = $db2->prepare($sql_position);
                    $s->bindParam(':stock_id',$row['stock_id']);
                    $s->bindParam(':store_name',$store_name);
                    // $s->bindParam(':unit',$row['unit']);
                    $s->bindParam(':stock_count',$count);


                    $s->execute();

                }
                catch (PDOException $e)
                {
                    $error_insert = "update_position_failed";

                    $data['success']=false;
                    $data['message']=$e->getMessage();

                }


            }
        }
        catch (PDOException $e)
        {
            $error_insert = "could not upload stock update";
            $data['success']=false;
            $data['message']=$e->getMessage();
        }
    }

    //for upload sales invoice daily
    if($operation == 'upload_sales_invoice'){
        try
        {
            $query_select = 'SELECT invoice_num, sales_date, sales_time, purchase_amount, store,payment_type,status, cashier,store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN users ON salesinvoice_daily.user_id = users.user_id INNER JOIN customer ON salesinvoice_daily.customer_id=customer.customer_id WHERE sales_date=:upload_date';
            $result = $db1->prepare($query_select);
            $result->bindParam(':upload_date',$upload_date);
            $result->execute();
            //check if there is a result
            if($result->rowCount()>0){

            //Get each row
            foreach ($result as $row){
                $echod = "1";
                $data['success']=true;
                $data['message']='query executed';
                //query so that it will be uniquely done
                try{
                    $query_unique ="SELECT invoice_num,store_name FROM sales_invoice_daily WHERE invoice_num=:invoice_num AND store_name=:store_name AND sales_date=:upload_date";
                    $result_unique=$db2->prepare($query_unique);
                    $result_unique->bindParam(':invoice_num',$row['invoice_num']);

                    $result_unique->bindParam(':store_name',$store_name);
                    $result_unique->bindParam(':upload_date',$upload_date);
                    $result_unique->execute();
                    //if there is a row
                    if($result_unique->rowCount()>0){
                        $echod = "1";
                        $data['success']=true;
                        $data['update']='cannot update';


                    }
                    else{
                        $echod = "1";
                        $data['success']=true;
                        $data['message']='query executed';
                        try
                        {
                            $sql_insert = "INSERT INTO sales_invoice_daily(sales_date, sales_time, customer, invoice_num, purchase_amount, store_name, payment_type, operator, status, cashier, store_confirmation)  VALUES(:sales_date,:sales_time,:customer,:invoice_num,:purchase_amount,:store_name,:payment_type,:operator,:status,:cashier,:store_confirmation)";
                            $s = $db2->prepare($sql_insert);
                            $s->bindParam(':sales_date',$upload_date);
                            $s->bindParam(':sales_time',$row['sales_time']);
                            $s->bindParam(':customer',$row['customer_name']);
                            $s->bindParam(':invoice_num',$row['invoice_num']);
                            $s->bindParam(':purchase_amount',$row['purchase_amount']);
                            $s->bindParam(':store_name',$store_name);
                            $s->bindParam(':payment_type',$row['payment_type']);
                            $s->bindParam(':operator',$row['username']);
                            $s->bindParam(':status',$row['status']);
                            $s->bindParam(':cashier',$row['cashier']);
                            $s->bindParam(':store_confirmation',$row['store_confirmation']);
                            $s->execute();

                        }
                        catch (PDOException $e)
                        {
                            $error_insert = "insert_failed";
                            $data['success']=false;
                            $data['message']=$e->getMessage();

                        }

                    }

                }
                catch (PDOException $e)
                {
                    $error_insert = "select_unique_failed";
                    $data['success']=false;
                    $data['message']=$e->getMessage();
                }


            }
        }
            // if no result
            else{
                $data['success']=false;
                $data['no_record']='No record found';
            }

        }
        catch (PDOException $e)
        {
            $error_insert = $e->getMessage();
            $data['success']=false;
            $data['message']=$e->getMessage();
        }
    }


    //upload stock ledger
    if($operation == 'upload_stock_ledger'){
        try
        {
            $query_select = 'SELECT stock_ledger_id, opening_bal, task, quantity, remarks,closing_bal,update_date, stock_id,store.store_name, users.username, update_time FROM stockledger INNER JOIN users ON stockledger.user_id = users.user_id INNER JOIN store ON store.store_id = stockledger.store_id WHERE update_date=:upload_date';
            $result = $db1->prepare($query_select);
            $result->bindParam(':upload_date',$upload_date);
            $result->execute();
            //Get each row
            if($result->rowCount()>0){
            //Get each row
            foreach ($result as $row){
                $echod = "1";
                $data['success']=true;
                $data['message']='query executed';
                //query so that it will be uniquely done
                try{
                    $query_unique ="SELECT stock_id,date,store_name FROM stock_ledger WHERE stock_id=:stock_id AND store_name=:store_name AND date=:update_date";
                    $result_unique=$db2->prepare($query_unique);
                    $result_unique->bindParam(':stock_id',$row['stock_id']);

                    $result_unique->bindParam(':store_name',$store_name);
                    $result_unique->bindParam(':update_date',$row['update_date']);
                    $result_unique->execute();
                    //if there is a row
                    if($result_unique->rowCount()>0){
                        $echod = "1";
                        $data['success']=true;
                        $data['update']='cannot update';

                    }
                    else{
                        $echod = "1";
                        $data['success']=true;
                        $data['message']='query executed';
                        try
                        {
                            $sql_insert = "INSERT INTO stock_ledger( opening_bal, task, quantity, remarks, closing_bal, date, stock_id, store_name, username, time)  VALUES(:opening_bal,:task,:quantity,:remarks,:closing_bal,:update_date,:stock_id,:store_name,:username,:update_time)";
                            $s = $db2->prepare($sql_insert);
                            $s->bindParam(':opening_bal',$row['opening_bal']);
                            $s->bindParam(':task',$row['task']);
                            $s->bindParam(':quantity',$row['quantity']);
                            $s->bindParam(':remarks',$row['remarks']);
                            $s->bindParam(':closing_bal',$row['closing_bal']);
                            $s->bindParam(':update_date',$row['update_date']);
                            $s->bindParam(':store_name',$store_name);
                            $s->bindParam(':stock_id',$row['stock_id']);
                            $s->bindParam(':username',$row['username']);
                            $s->bindParam(':update_time',$row['update_time']);
//                            $s->bindParam(':stock_ledger_id',$row['stock_ledger_id']);
                            $s->execute();

                        }
                        catch (PDOException $e)
                        {
                            $error_insert = 'insert_failed';
                            $data['success']=false;
                            $data['message']=$e->getMessage();

                        }
//                        $echod = "1";
                    }

                }
                catch (PDOException $e)
                {
                    $error_insert = "select_unique_failed";
                    $data['success']=false;
                    $data['message']=$e->getMessage();
                }


            }
        }
            else{
                $data['success']=false;
                $data['no_record']='No record found';
            }

        }
        catch (PDOException $e)
        {
            $error_insert = "select_failed";
            $data['success']=false;
            $data['message']=$e->getMessage();
        }
    }

    //upload stock position
    if($operation == 'upload_stock_position'){
        try
        {
            $query_select = "SELECT DISTINCT(stock_id) FROM stockposition ";
            $result = $db1->query($query_select);
            $data['success']=true;
            $data['message']='query_executed';
            //Get each row
            foreach ($result as $row){

                //query so that it will be uniquely done
                try{
                    $query_unique ="SELECT sum(stock_count) AS stock_count FROM stockposition WHERE stock_id=:stock_id ";
                    $result_unique=$db1->prepare($query_unique);
                    $result_unique->bindParam(':stock_id',$row['stock_id']);
                    $result_unique->execute();
                    $result_stock_count=$result_unique->fetch(PDO::FETCH_ASSOC);
                    //fetch(PDO::FETCH_LAZY);

$count_row=$result_stock_count['stock_count'];


                    //if there is a row
                    if(!$count_row ){
                        $data['success']=true;
                        $data['message']='query_executed';
                        try
                        {
                            $sql_insert = "UPDATE stock SET stock_count=:stock_count WHERE stock_id=:stock_id  AND store_name=:store_name ";
                            // $sql_insert = "INSERT INTO stock_position(stock_id, store_id, unit, stock_count)  VALUES(:stock_id,:store_id,:unit,:stock_count)";
                            $s = $db2->prepare($sql_insert);
                            $s->bindParam(':stock_id',$row['stock_id']);
                            $s->bindParam(':store_name',$store_name);
                            //$s->bindParam(':unit',$row['unit']);
                            $s->bindParam(':stock_count',$count);
                            $s->execute();
                            $data['success']=true;
                            $data['message']='query_executed';
                            try
                            {
                                $sql_insert_position = "INSERT INTO stock_position(stock_id, store_name, stock_count)  VALUES(:stock_id,:store_name,:stock_count)";
                                //$sql_update = "UPDATE stock_position SET stock_count=:stock_count,unit=:unit WHERE stock_id=:stock_id  AND store_id=:store_id ";
                                $s = $db2->prepare($sql_insert_position);
                                $s->bindParam(':stock_id',$row['stock_id']);
                                $s->bindParam(':store_name',$store_name);
                                // $s->bindParam(':unit',$row['unit']);
                                $s->bindParam(':stock_count',$count);


                                $s->execute();

                            }
                            catch (PDOException $e)
                            {
                                $error_insert = "insert_position_failed";
                                $data['success']=false;
                                $data['message']=$e->getMessage();

                            }

                        }
                        catch (PDOException $e)
                        {
                            $error_insert = "insert_failed";
                            $data['success']=false;
                            $data['message']=$e->getMessage();

                        }


                    }
                    else{
                        $echod = "1";
                        $data['success']=true;
                        $data['message']='query_executed';

                        try
                        {
                            $sql_update = "UPDATE stock SET stock_count=:stock_count WHERE stock_id=:stock_id  AND store_name=:store_name ";
                            //$sql_update = "UPDATE stock_position SET stock_count=:stock_count,unit=:unit WHERE stock_id=:stock_id  AND store_id=:store_id ";
                            $s = $db2->prepare($sql_update);
                            $s->bindParam(':stock_id',$row['stock_id']);
                            $s->bindParam(':store_name',$store_name);
                            // $s->bindParam(':unit',$row['unit']);
                            $s->bindParam(':stock_count',$count_row);


                            $s->execute();
                            try
                            {
                                $sql_position = "UPDATE stock_position SET stock_count=:stock_count WHERE stock_id=:stock_id  AND store_name=:store_name ";
                                //$sql_update = "UPDATE stock_position SET stock_count=:stock_count,unit=:unit WHERE stock_id=:stock_id  AND store_id=:store_id ";
                                $s = $db2->prepare($sql_position);
                                $s->bindParam(':stock_id',$row['stock_id']);
                                $s->bindParam(':store_name',$store_name);
                                // $s->bindParam(':unit',$row['unit']);
                                $s->bindParam(':stock_count',$count_row);


                                $s->execute();

                            }
                            catch (PDOException $e)
                            {
                                $error_insert = "insert_failed";
                                $data['success']=false;
                                $data['message']=$e->getMessage();

                            }
//                            $echod = "1";
//                            $data['success']=true;
//                            $data['message']='query_executed';

                        }
                        catch (PDOException $e)
                        {
                            $error_insert = "update_failed";
                            $data['success']=false;
                            $data['message']=$e->getMessage();

                        }
                    }

                }
                catch (PDOException $e)
                {
                    $error_insert = "select_unique_failed";
                    $data['success']=false;
                    $data['message']=$e->getMessage();
                }
                $echod = "1";

            }
        }
        catch (PDOException $e)
        {
            $error_insert = "select_failed";
            $data['success']=false;
            $data['message']=$e->getMessage();
        }
    }

    //Daily Summary
    if($operation == 'upload_daily_summary'){
        $echod = "1";
        $data['success']=true;
        $data['message']='query executed';
        try
        {
            $echod = "1";
            $data['success']=true;
            $data['message']='query executed';
            //Get opening balance

                $query_opening_balance = 'SELECT amount FROM openingbalance WHERE date=:upload_date';
                $result_opening_balance = $db1->prepare($query_opening_balance);
                $result_opening_balance->bindParam(':upload_date',$upload_date);
                $result_opening_balance->execute();
            $row_opening_balance=$result_opening_balance->fetch(PDO::FETCH_LAZY);
                   $opening_bal=$row_opening_balance['amount'];
            if($row_opening_balance['amount']){
                $opening_bal=$row_opening_balance['amount'];
            }
            else{
                $data['success']=false;
                $data['no_record']='No record found';
                $opening_bal=0;
            }


            //Get Cashin

                $query_cashin = 'SELECT sum(amount) AS amount FROM cashstock WHERE amount>0 AND date=:upload_date';
                $result_cashin = $db2->prepare($query_cashin);
                $result_cashin->bindParam(':upload_date',$upload_date);
                $result_cashin->execute();
               $row_cashin= $result_cashin->fetch(PDO::FETCH_LAZY);
                //Get each row

                    //query so that it will be uniquely done
            if($row_cashin['amount']){
                $cashin=$row_cashin['amount'];
            }
            else{
                $data['success']=false;
                $data['no_record']='No record found';
                $cashin=0;
            }






            //Get cash out

                $query_cashout = 'SELECT sum(amount) AS amount FROM cashstock WHERE amount<0 AND date=:upload_date';
                $result_cashout = $db2->prepare($query_cashout);
                $result_cashout->bindParam(':upload_date',$upload_date);
                $result_cashout->execute();
               $row_cashout= $result_cashout->fetch(PDO::FETCH_LAZY);
                //Get each row


                    //query so that it will be uniquely done
                    if($row_cashout['amount']){
                        $cashout=$row_cashout['amount'];
                    }
                    else{
                        $data['success']=false;
                        $data['no_record']='No record found';
                        $cashout=0;
                    }



            //CREDIT SALES

                $query_credit_sales = 'SELECT sum(purchase_amount) AS amount FROM sales_invoice_daily WHERE payment_type=:credit AND sales_date=:upload_date';
                $result_credit_sales = $db2->prepare($query_credit_sales);
                $result_credit_sales->bindParam(':upload_date',$upload_date);
                $result_credit_sales->bindParam(':credit',$credit);
                $result_credit_sales->execute();
               $row_credit_sales= $result_credit_sales->fetch(PDO::FETCH_LAZY);
                //Get each row

                    //query so that it will be uniquely done
            if($row_credit_sales['amount']) {
                $credit_sales = $row_credit_sales['amount'];
            }
            else{
                $data['success']=false;
                $data['no_record']='No record found';
                $credit_sales=0;
            }


            $closing_bal=($opening_bal + $cashin + $cashout);




            //Check for a match
            try{
                $query_unique ="SELECT date,store_name FROM  store_daily_summary WHERE store_name=:store_name AND date=:upload_date ";
                $result_unique=$db2->prepare($query_unique);
                $result_unique->bindParam(':store_name',$store_name);

                $result_unique->bindParam(':upload_date',$upload_date);

                $result_unique->execute();
                //if there is a row
                if($result_unique->rowCount()>0){
                    $echod = "1";
                    $data['success']=true;
                    $data['update']='cannot update';


                }
                else{
                    $echod = "1";
                    $data['success']=true;
                    $data['message']='query executed';
                    try
                    {
                        $sql_insert = "INSERT INTO store_daily_summary(store_name, opening_balance, total_cash_in, total_cash_out, total_credit_sales, closing_balance, date)  VALUES(:store_name,:opening_bal,:cashin,:cashout,:credit_sales,:closing_bal,:upload_date)";
                        $s = $db2->prepare($sql_insert);
                        $s->bindParam(':opening_bal',$opening_bal,PDO::PARAM_INT);
                        $s->bindParam(':store_name',$store_name);
                        $s->bindParam(':cashin',$cashin,PDO::PARAM_INT);
                        $s->bindParam(':cashout',$cashout,PDO::PARAM_INT);
                        $s->bindParam(':credit_sales',$credit_sales,PDO::PARAM_INT);
                        $s->bindParam(':closing_bal',$closing_bal,PDO::PARAM_INT);
                        $s->bindParam(':upload_date',$upload_date);

                        $s->execute();
                        $echod = "1";
                    }
                    catch (PDOException $e)
                    {
                        $error_insert = $e->getMessage();
                        $data['success']=false;
                        $data['message']=$e->getMessage();

                    }

                }

            }
            catch (PDOException $e)
            {
                $error_insert = "select_unique_failed";
                $data['success']=false;
                $data['message']=$e->getMessage();
            }


        }
        catch (PDOException $e)
        {
            $error_insert = "select_failed";
            $data['success']=false;
            $data['message']=$e->getMessage();
        }

    }

}


//if we could not connect to both servers
catch (PDOException $e) {
    $error_insert = 'connection_failed';
    $data['success']=false;
    $data['message']=$e->getMessage();

}

//if($error_insert != "1"){
//
//    //echo $error_insert;
//echo $error_insert;
//
//}
//if($error_insert == "1"){
//    echo $echod;
//}
echo json_encode($data);