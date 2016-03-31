<?php
include "lib/util.php";
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 14/01/2016
 * Time: 4:02 PM
 */
//ini_set("display_errors","1");
$servername = "localhost";
$username = "root";
$password = "Heaven192";
$dbname = "espread";

// Create connection



// Check connection

$upload_date = $_GET['upload_date'];

//$operation = $_POST['operation'];

$store_name = $_GET['store_name'];
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
$stockpos_array=array();
$stockcount_array=array();
$salesinvoice_array=array();
$dailysummary_array=array();
$stockledger_array=array();
$i_cashstock=0;
$i_stockpos=0;
$i_stockcount=0;
$i_stockledger=0;
$i_salesledger=0;
$stockcount_empty="";
$stockpos_empty="";

$cashstock_insert="";
$stockpos_insert="";
$stockcount_insert="";
$salesinvoice_insert="";
$dailysummary_insert="";
$stockledger_insert="";
$stockpos_update="";
$stockcount_update="";
$file_insert='file_insert.sql';
$file_trial=$store_name.'.sql';
$total_insert="";
$invoice_item_insert="";
$salesarchive="";
$invoice_daily="";
$supaccount_insert="";
$cusaccount_insert="";
$supaccount_empty="";
$cusaccount_empty="";

//$ftp_server="";
//$ftp_username="";
//$ftp_userpass="";

$credit='CREDIT';
$status='CLOSED';
$upload_time=date('h:i:s');
$stock_id_row='';
$company_id="";
$transaction_type="opening balance";
$transaction_cus="customer payment";
$sales_daily=0;
$salesarchive_daily=0;
$credit_archive=0;
$total_credit=0;
$total_sales=0;
$upload_log="";
//try connection to both servers
try {
    $db1 = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $db2 = new PDO('mysql:dbname=espread_online;host=127.0.0.1', 'root', 'Heaven192');
//    $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //first check if the settings table has been added
    try{
        $company_select="SELECT company_id,ftp_server_name,ftp_server_password,ftp_server_user FROM settings";
        $result_company = $db1->query($company_select);
        //check if the settings table has been set
        if($result_company->rowCount()>0){
            //Yes there is settings, obtain info
            $row_company=$result_company->fetch(PDO::FETCH_ASSOC);
            $company_id=$row_company['company_id'];
            $ftp_server=$row_company['ftp_server_name'];
            $ftp_username=$row_company['ftp_server_user'];
            $ftp_userpass=$row_company['ftp_server_password'];


//            ALL OTHER THINGS OF THE PAGE COME IN HERE

            // CHECK IF THE OPENING BALANCE HAS BEEN SET
            try{
                $query_check_balance = 'SELECT amount FROM openingbalance WHERE date=:upload_date';
                $result_check_balance = $db1->prepare($query_check_balance);
                $result_check_balance->bindParam(':upload_date',$upload_date);
                $result_check_balance->execute();

                //WHEN THERE IS OPENING BALANCE, DO...
                if($result_check_balance->rowCount()>0) {
                    //FIRST GET CASH STOCK
                    try
                    {
                        $query_select = "SELECT cashstock.cashstock_id, cashstock.particulars, cashstock.remark, cashstock.amount,cashstock.date,cashstock.payment_type,cashstock.transaction_type FROM cashstock WHERE cashstock.date=:upload_date ";
                        $result = $db1->prepare($query_select);
                        $result->bindParam(':upload_date',$upload_date);
                        $result->execute();

                        $echod = "1";
                        $data['success']=true;
                        $data['message']='query executed';
                        //Get each row
                        if($result->rowCount()>0){

                            $cashstock_insert="INSERT INTO `cashstock` (`cashstock_id`, `particulars`, `remark`, `amount`, `date`, `store_id`,`payment_type`,`transaction_type`) VALUES";
                            foreach ($result as $row){
                                $cashstock_insert.="(".$row['cashstock_id'].",'".$row['particulars']."','".$row['remark']."',".$row['amount'].",'".$row['date']."','".$company_id."','".$row['payment_type']."','".$row['transaction_type']."'),";
                                //query so that it will be uniquely done




                            }
                            $cashstock_insert=rtrim($cashstock_insert,",");
                            $cashstock_insert.=";\n";
                            //$total_insert.=$cashstock_insert;
                        }

                        $total_insert.=$cashstock_insert;

                    }
                    catch (PDOException $e)
                    {
                        $error_insert = "select_failed";
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                        $cashstock_insert='';
                    }


                    //FOR STOCK AND STOCK POSITION

                    //select and insert
                    try {

                        $query_select = 'SELECT stock_id, stock_code, stock_name, costprice, sales_person_price,high_purchase,low_purchase, slab, sprice, block, reorder_level FROM stock';
                        $result = $db1->query($query_select);
                        $data['success'] = true;
                        $data['message'] = 'selected stock';
                        if ($result->rowCount() > 0) {
                            $stockcount_empty="DELETE FROM `stock` WHERE `store_id`='$company_id';\n";
                            $stockpos_empty="DELETE FROM `stock_position` WHERE `store_id`='$company_id';\n";
                            //Get each row
                            $stockcount_insert = "INSERT INTO `stock` (`stock_id`, `stock_code`, `stock_name`,`store_id`, `stock_count`) VALUES";
                            $stockpos_insert = "INSERT INTO `stock_position` ( `stock_id`, `store_id`, `unit`, `stock_count`) VALUES";

                            foreach ($result as $row) {
                                $stockcount_insert .= "(" . $row['stock_id'] . ",'" . $row['stock_code'] . "','" . $row['stock_name'] . "','" . $company_id . "'," . $count . "),";
                                $stockpos_insert .= "(" . $row['stock_id'] . ",'" . $company_id . "'," . $unit . "," . $count . "),";

                                //query so that it will be uniquely done


                            }
                            $stockcount_insert = rtrim($stockcount_insert, ",");
                            $stockpos_insert = rtrim($stockpos_insert, ",");
                            $stockcount_insert .= ";\n";
                            $stockpos_insert .= ";\n";
                            $total_insert.=$stockcount_empty;
                            $total_insert.=$stockpos_empty;
                            $total_insert .= $stockcount_insert;
                            $total_insert .= $stockpos_insert;
                            // file_put_contents($file_insert, $total_insert);
                        }
                    }
                    catch (PDOException $e)
                    {
                        $error_insert = "could not upload stock update";
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                        $stockcount_insert='';
                    }


                    //FOR CUSTOMER ACCOUNT

                    //select and insert
                    //select and insert
                    try {

                        $query_select = 'SELECT customer.customer_Id, customer_name, customer_transaction.amount from customer left join ( select customer_Id, sum(amount) as amount from customer_transaction group by customer_Id )customer_transaction on customer.customer_Id= customer_transaction.customer_Id';
                        $result = $db1->query($query_select);
                        $data['success'] = true;
                        $data['message'] = 'selected supplier';
                        if ($result->rowCount() > 0) {
                            $cusaccount_empty="DELETE FROM `customer_account` WHERE `store_id`='$company_id';\n";

                            //Get each row
                            $cusaccount_insert = "INSERT INTO `customer_account` (`customer_id`, `customer_name`, `amount`,`store_id`) VALUES";


                            foreach ($result as $row) {
                                if(!$row['amount']){
                                    $row['amount']=0;
                                }
                                $cusaccount_insert .= "(" . $row['customer_Id'] . ",'" . $row['customer_name'] . "'," . $row['amount'] . ",'" . $company_id . "'),";


                                //query so that it will be uniquely done


                            }
                            $cusaccount_insert = rtrim($cusaccount_insert, ",");

                            $cusaccount_insert .= ";\n";

                            $total_insert.=$cusaccount_empty;

                            $total_insert .= $cusaccount_insert;

                            // file_put_contents($file_insert, $total_insert);
                        }
                    }
                    catch (PDOException $e)
                    {
                        $error_insert = "could not upload customer account";
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                        $cusaccount_insert='';
                    }


                    //SUPPLIER ACCOUNT
                    //select and insert
                    try {

                        $query_select = 'SELECT supplier.supplier_Id, supplier_name, supplier_account.amount from supplier left join ( select supplier_Id, sum(amount) as amount from supplier_account group by supplier_Id )supplier_account on supplier.supplier_Id= supplier_account.supplier_Id';
                        $result = $db1->query($query_select);
                        $data['success'] = true;
                        $data['message'] = 'selected supplier';
                        if ($result->rowCount() > 0) {
                            $supaccount_empty="DELETE FROM `supplier_account` WHERE `store_id`='$company_id';\n";

                            //Get each row
                            $supaccount_insert = "INSERT INTO `supplier_account` (`supplier_id`, `supplier_name`, `amount`,`store_id`) VALUES";


                            foreach ($result as $row) {
                                if(!$row['amount']){
                                    $row['amount']=0;
                                }
                                $supaccount_insert .= "(" . $row['supplier_Id'] . ",'" . $row['supplier_name'] . "'," . $row['amount'] . ",'" . $company_id . "'),";


                                //query so that it will be uniquely done


                            }
                            $supaccount_insert = rtrim($supaccount_insert, ",");

                            $supaccount_insert .= ";\n";

                            $total_insert.=$supaccount_empty;

                            $total_insert .= $supaccount_insert;

                            // file_put_contents($file_insert, $total_insert);
                        }
                    }
                    catch (PDOException $e)
                    {
                        $error_insert = "could not upload stock update";
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                        $supaccount_insert='';
                    }

                    //SALES INVOICE DAILY

                    try
                    {
                        $query_select = 'SELECT invoice_num, sales_date, sales_time, purchase_amount, store,payment_type,status, cashier,store_confirmation, users.username, customer.customer_name FROM salesinvoice_daily INNER JOIN users ON salesinvoice_daily.user_id = users.user_id INNER JOIN customer ON salesinvoice_daily.customer_id=customer.customer_id WHERE sales_date=:upload_date AND status=:status';

                        $result = $db1->prepare($query_select);
                        $result->bindParam(':upload_date',$upload_date);
                        $result->bindParam(':status',$status);
                        $result->execute();
                        $echod = "1";
                        $data['success']=true;
                        $data['message']='query executed';
                        //check if there is a result
                        if($result->rowCount()>0){
                            $salesinvoice_insert="INSERT INTO `sales_invoice_daily` (`sales_date`, `sales_time`, `purchase_amount`, `store_id`, `payment_type`, `status`, `cashier`, `store_confirmation`, `operator`, `customer`, `invoice_num`) VALUES";
                            //Get each row
                            foreach ($result as $row){
                                $salesinvoice_insert.="('".$row['sales_date']."','".$row['sales_time']."',".$row['purchase_amount'].",'".$company_id."','".$row['payment_type']."','".$row['status']."','".$row['cashier']."','".$row['store_confirmation']."','".$row['username']."','".$row['customer_name']."',".$row['invoice_num']."),";

                                //query so that it will be uniquely done



                            }
                            $salesinvoice_insert=rtrim($salesinvoice_insert,",");
                            $salesinvoice_insert.=";\n";
                            // $stockpos_insert=rtrim($stockpos_insert,",");

                            // $total_insert.=$stockpos_insert;


                        }
                        // if no result

                        $total_insert.=$salesinvoice_insert;
                    }
                    catch (PDOException $e)
                    {
                        $error_insert = $e->getMessage();
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                    }

                    //FOR SALESINVOICE ARCHIVE
                    try
                    {
                        $query_select = 'SELECT invoice_num, sales_date, sales_time, purchase_amount, store,payment_type,status, cashier,store_confirmation, users.username, customer.customer_name FROM salesinvoice INNER JOIN users ON salesinvoice.user_id = users.user_id INNER JOIN customer ON salesinvoice.customer_id=customer.customer_id WHERE sales_date=:upload_date AND status=:status';

                        $result = $db1->prepare($query_select);
                        $result->bindParam(':upload_date',$upload_date);
                        $result->bindParam(':status',$status);
                        $result->execute();
                        $echod = "1";
                        $data['success']=true;
                        $data['message']='query executed';
                        //check if there is a result
                        if($result->rowCount()>0){
                            $salesarchive="INSERT INTO `sales_invoice_daily` (`sales_date`, `sales_time`, `purchase_amount`, `store_id`, `payment_type`, `status`, `cashier`, `store_confirmation`, `operator`, `customer`, `invoice_num`) VALUES";
                            //Get each row
                            foreach ($result as $row){
                                $salesarchive.="('".$row['sales_date']."','".$row['sales_time']."',".$row['purchase_amount'].",'".$company_id."','".$row['payment_type']."','".$row['status']."','".$row['cashier']."','".$row['store_confirmation']."','".$row['username']."','".$row['customer_name']."',".$row['invoice_num']."),";

                                //query so that it will be uniquely done



                            }
                            $salesarchive=rtrim($salesarchive,",");
                            $salesarchive.=";\n";
                            // $stockpos_insert=rtrim($stockpos_insert,",");

                            // $total_insert.=$stockpos_insert;


                        }
                        // if no result

                        $total_insert.=$salesarchive;
                    }
                    catch (PDOException $e)
                    {
                        $error_insert = $e->getMessage();
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                    }


                    //For INVOICE ITEMS FROM SALES INVOICE
                    try
                    {
                        $query_select = 'SELECT invoiceitems_daily.item_id, invoiceitems_daily.quantity, invoiceitems_daily.trans_date,  invoiceitems_daily.stock_id,invoiceitems_daily.invoice_num FROM invoiceitems_daily INNER JOIN salesinvoice ON salesinvoice.invoice_num=invoiceitems_daily.invoice_num WHERE sales_date=:upload_date AND status=:status';

                        $result = $db1->prepare($query_select);
                        $result->bindParam(':upload_date',$upload_date);
                        $result->bindParam(':status',$status);
                        $result->execute();
                        $echod = "1";
                        $data['success']=true;
                        $data['message']='query executed';
                        //check if there is a result
                        if($result->rowCount()>0){
                            $invoice_item_insert="INSERT INTO `invoice_item` ( `trans_date`, `item_quantity`, `stock_id`, `store_id`, `item_id`,`invoice_num`) VALUES";
                            //Get each row
                            foreach ($result as $row){
                                $invoice_item_insert.="('".$row['trans_date']."',".$row['quantity'].",".$row['stock_id'].",'".$company_id."',".$row['item_id'].",".$row['invoice_num']."),";

                                //query so that it will be uniquely done



                            }
                            $invoice_item_insert=rtrim($invoice_item_insert,",");
                            $invoice_item_insert.=";\n";
                            // $stockpos_insert=rtrim($stockpos_insert,",");

                            // $total_insert.=$stockpos_insert;


                        }
                        // if no result

                        $total_insert.=$invoice_item_insert;
                    }
                    catch (PDOException $e)
                    {
                        //$error_insert = $e->getMessage();
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                    }


                    //FOR INVOICE ITEMS FROM SALES INVOICE
                    try
                    {
                        $query_select = 'SELECT invoiceitems_daily.item_id, invoiceitems_daily.quantity, invoiceitems_daily.trans_date,  invoiceitems_daily.stock_id,invoiceitems_daily.invoice_num FROM invoiceitems_daily INNER JOIN salesinvoice_daily ON salesinvoice_daily.invoice_num=invoiceitems_daily.invoice_num WHERE sales_date=:upload_date AND status=:status';

                        $result = $db1->prepare($query_select);
                        $result->bindParam(':upload_date',$upload_date);
                        $result->bindParam(':status',$status);
                        $result->execute();
                        $echod = "1";
                        $data['success']=true;
                        $data['message']='query executed';
                        //check if there is a result
                        if($result->rowCount()>0){
                            $invoice_daily="INSERT INTO `invoice_item` ( `trans_date`, `item_quantity`, `stock_id`, `store_id`, `item_id`,`invoice_num`) VALUES";
                            //Get each row
                            foreach ($result as $row){
                                $invoice_daily.="('".$row['trans_date']."',".$row['quantity'].",".$row['stock_id'].",'".$company_id."',".$row['item_id'].",".$row['invoice_num']."),";

                                //query so that it will be uniquely done



                            }
                            $invoice_daily=rtrim($invoice_daily,",");
                            $invoice_daily.=";\n";
                            // $stockpos_insert=rtrim($stockpos_insert,",");

                            // $total_insert.=$stockpos_insert;


                        }
                        // if no result

                        $total_insert.=$invoice_daily;
                    }
                    catch (PDOException $e)
                    {
                        //$error_insert = $e->getMessage();
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                    }


                    //FOR STOCK LEDGER
                    try
                    {
                        $query_select = 'SELECT stock_ledger_id, opening_bal, task, quantity, remarks,closing_bal,update_date, stock_id,store.store_name, users.username, update_time FROM stockledger INNER JOIN users ON stockledger.user_id = users.user_id INNER JOIN store ON store.store_id = stockledger.store_id WHERE update_date=:upload_date';
                        $echod = "1";
                        $data['success']=true;
                        $data['message']='query executed';
                        $result = $db1->prepare($query_select);
                        $result->bindParam(':upload_date',$upload_date);
                        $result->execute();
                        //Get each row
                        if($result->rowCount()>0){
                            $stockledger_insert="INSERT INTO `stock_ledger` ( `stock_ledger_id`,`opening_bal`, `task`, `quantity`, `remarks`, `closing_bal`, `date`, `stock_id`, `store_id`, `username`, `time`) VALUES";
                            //Get each row
                            foreach ($result as $row){
                                $stockledger_insert.="(".$row['stock_ledger_id'].",".$row['opening_bal'].",'".$row['task']."',".$row['quantity'].",'".$row['remarks']."',".$row['closing_bal'].",'".$row['update_date']."',".$row['stock_id'].",'".$company_id."','".$row['username']."','".$row['update_time']."'),";

                                //query so that it will be uniquely done



                            }
                            $stockledger_insert=rtrim($stockledger_insert,",");
                            $stockledger_insert.=";\n";
                        }
                        else{

                        }
                        $total_insert.=$stockledger_insert;
                    }
                    catch (PDOException $e)
                    {
                        $error_insert = "select_failed";
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                    }


                    //UPDATE STOCK POSITION AND STOCK

                    try
                    {
                        $query_select = "SELECT DISTINCT(stock_id) FROM stockposition ";
                        $result = $db1->query($query_select);
                        $data['success']=true;
                        $data['message']='query_executed';
                        //Get each row
                        foreach ($result as $row){
                            $stock_id_row=$row['stock_id'];
                            //query so that it will be uniquely done
                            try{
                                $query_unique ="SELECT sum(stock_count) AS stock_count FROM stockposition WHERE stock_id=:stock_id ";
                                $result_unique=$db1->prepare($query_unique);
                                $result_unique->bindParam(':stock_id',$row['stock_id']);
                                $result_unique->execute();
                                $result_stock_count=$result_unique->fetch(PDO::FETCH_ASSOC);
                                //fetch(PDO::FETCH_LAZY);

                                $count_row=$result_stock_count['stock_count'];


                                //if there is no row so sum count was null

                                //sum count gave a value, use the value
                                if($count_row){
                                    $echod = "1";
                                    $data['success']=true;
                                    $data['message']='query_executed';
                                    $stockcount_update.="UPDATE `stock` SET `stock`.`stock_count`=$count_row WHERE `stock`.`store_id`='$company_id' AND `stock`.`stock_id`='$stock_id_row';\n";
                                    $stockpos_update.="UPDATE `stock_position` SET `stock_position`.`stock_count`=$count_row WHERE `stock_position`.`store_id`='$company_id' AND `stock_position`.`stock_id`='$stock_id_row';\n";

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
                        $total_insert.=$stockcount_update;
                        $total_insert.=$stockpos_update;
                    }
                    catch (PDOException $e)
                    {
                        $error_insert = "select_failed";
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                    }


                    //DAILY SUMMARY AND UPLOAD LOG


                    try
                    {
                        $echod = "1";
                        $data['success']=true;
                        $data['message']='query executed';

                        //Get OPENING BALANCE
                        try{
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

                        }
                        catch (PDOException $e)
                        {
                            $error_insert = "select_failed";
                            $data['success']=false;
                            $data['message']=$e->getMessage();
                        }


                        //CASHIN

                        try{
                            $query_cashin = 'SELECT sum(amount) AS amount FROM cashstock WHERE amount>0 AND date=:upload_date AND transaction_type!=:transaction_tp';
                            $result_cashin = $db1->prepare($query_cashin);
                            $result_cashin->bindParam(':upload_date',$upload_date);
                            $result_cashin->bindParam(':transaction_tp',$transaction_type);
                            $result_cashin->execute();
                            $row_cashin= $result_cashin->fetch(PDO::FETCH_LAZY);
                            //Get each row

                            //query so that it will be uniquely done
                            if($row_cashin['amount']){
                                $cashin=$row_cashin['amount'];
                                //$cashin=$cashin-$opening_bal;
                            }
                            else{
                                $data['success']=false;
                                $data['no_record']='No record found';
                                $cashin=0;
                            }
                        }
                        catch (PDOException $e)
                        {
                            $error_insert = "select_failed";
                            $data['success']=false;
                            $data['message']=$e->getMessage();
                        }





                        //CASH OUT

                        try{
                            $query_cashout = 'SELECT sum(amount) AS amount FROM cashstock WHERE amount<0 AND date=:upload_date AND transaction_type!=:transaction_cus';
                            $result_cashout = $db1->prepare($query_cashout);
                            $result_cashout->bindParam(':upload_date',$upload_date);
                            $result_cashout->bindParam(':transaction_cus',$transaction_cus);
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
                        }
                        catch (PDOException $e)
                        {
                            $error_insert = "select_failed";
                            $data['success']=false;
                            $data['message']=$e->getMessage();
                        }

                        //CREDIT SALES
                        try{

                            //CREDIT SALES FROM SALES INVOICE DAILY
                            try{
                                $query_credit_sales = 'SELECT sum(purchase_amount) AS amount FROM salesinvoice_daily WHERE payment_type=:credit AND sales_date=:upload_date AND status=:status';
                                $result_credit_sales = $db1->prepare($query_credit_sales);
                                $result_credit_sales->bindParam(':upload_date',$upload_date);
                                $result_credit_sales->bindParam(':credit',$credit);
                                $result_credit_sales->bindParam(':status',$status);
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
                            }
                            catch (PDOException $e)
                            {
                                $error_insert = "select_failed";
                                $data['success']=false;
                                $data['message']=$e->getMessage();
                            }

                            //CREDIT SALES FROM SALES INVOICE
                            try{
                                $query_credit_salesa = 'SELECT sum(purchase_amount) AS amount FROM salesinvoice WHERE payment_type=:credit AND sales_date=:upload_date AND status=:status';
                                $result_credit_salesa = $db1->prepare($query_credit_salesa);
                                $result_credit_salesa->bindParam(':upload_date',$upload_date);
                                $result_credit_salesa->bindParam(':credit',$credit);
                                $result_credit_salesa->bindParam(':status',$status);
                                $result_credit_salesa->execute();
                                $row_credit_salesa= $result_credit_salesa->fetch(PDO::FETCH_LAZY);
                                //Get each row

                                //query so that it will be uniquely done
                                if($row_credit_salesa['amount']) {
                                    $credit_archive = $row_credit_salesa['amount'];
                                }
                                else{
                                    $data['success']=false;
                                    $data['no_record']='No record found';
                                    $credit_archive=0;
                                }
                            }
                            catch (PDOException $e)
                            {
                                $error_insert = "select_failed";
                                $data['success']=false;
                                $data['message']=$e->getMessage();
                            }


                            $total_credit=$credit_archive + $credit_sales;




                        }

                        catch (PDOException $e)
                        {
                            $error_insert = "select_failed";
                            $data['success']=false;
                            $data['message']=$e->getMessage();
                        }



                        //TOTAL SALES

                        try{

                            //TOTAL SALES FROM SALES INVOICE DAILY
                            try{
                                $query_total_sales = 'SELECT sum(purchase_amount) AS amount FROM salesinvoice_daily WHERE sales_date=:upload_date AND status=:status';
                                $result_total_sales = $db1->prepare($query_total_sales);
                                $result_total_sales->bindParam(':upload_date',$upload_date);

                                $result_total_sales->bindParam(':status',$status);
                                $result_total_sales->execute();
                                $row_total_sales= $result_total_sales->fetch(PDO::FETCH_LAZY);
                                //Get each row

                                //query so that it will be uniquely done
                                if($row_total_sales['amount']) {
                                    $sales_daily = $row_total_sales['amount'];
                                }
                                else{
                                    $data['success']=false;
                                    $data['no_record']='No record found';
                                    $sales_daily=0;
                                }
                            }
                            catch (PDOException $e)
                            {
                                $error_insert = "select_failed";
                                $data['success']=false;
                                $data['message']=$e->getMessage();
                            }

                            //TOTAL SALES FROM SALES INVOICE
                            try{
                                $query_total_salesa = 'SELECT sum(purchase_amount) AS amount FROM salesinvoice WHERE sales_date=:upload_date AND status=:status';
                                $result_total_salesa = $db1->prepare($query_total_salesa);
                                $result_total_salesa->bindParam(':upload_date',$upload_date);

                                $result_total_salesa->bindParam(':status',$status);
                                $result_total_salesa->execute();
                                $row_total_salesa= $result_total_salesa->fetch(PDO::FETCH_LAZY);
                                //Get each row

                                //query so that it will be uniquely done
                                if($row_total_salesa['amount']) {
                                    $salesarchive_daily= $row_total_salesa['amount'];
                                }
                                else{
                                    $data['success']=false;
                                    $data['no_record']='No record found';
                                    $salesarchive_daily=0;
                                }
                            }
                            catch (PDOException $e)
                            {
                                $error_insert = "select_failed";
                                $data['success']=false;
                                $data['message']=$e->getMessage();
                            }

                            $total_sales=$sales_daily + $salesarchive_daily;




                        }

                        catch (PDOException $e)
                        {
                            $error_insert = "select_failed";
                            $data['success']=false;
                            $data['message']=$e->getMessage();
                        }



                        //CLOSING BALANCE
                        $closing_bal=($opening_bal + $cashin + $cashout);


                        $dailysummary_insert="INSERT INTO `store_daily_summary` ( `store_id`, `opening_balance`,`total_sales`, `total_cash_in`, `total_cash_out`, `total_credit_sales`, `closing_balance`, `date`,  `time`) VALUES('$company_id',$opening_bal,$total_sales,$cashin,$cashout,$total_credit,$closing_bal,'$upload_date','$upload_time');";


                        $total_insert.=$dailysummary_insert;






                        //Check for a match



                    }
                    catch (PDOException $e)
                    {
                        $error_insert = "select_failed";
                        $data['success']=false;
                        $data['message']=$e->getMessage();
                    }

                    //fopen($file_trial,'w+');

                    //put contents into file
                    file_put_contents($file_trial,$total_insert,FILE_USE_INCLUDE_PATH);
                    file_put_contents($file_insert, $total_insert);

                    //$ftp_server = "ijeoma.dqdemos.com";
                    if($ftp_conn = ftp_connect($ftp_server)){
                        //$ftp_username = "ijeoma@dqdemos.com";
                        //$ftp_userpass = "Ijeoma*123#";
                        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
                        ftp_pasv($ftp_conn, true);
                        $file = $file_trial;

// upload file
                        if (ftp_put($ftp_conn, $file, $file, FTP_BINARY)) {
                            $data['success'] = true;
                            $data['message'] = "Successfully uploaded $file.";
                        } else {
                            $data['success'] = false;
                            $data['message'] = "Error uploading $file.";
                        }

// close connection
                        ftp_close($ftp_conn);

                    }
                    else
                    {
                        $data['success'] = false;
                        $data['message'] ="Could not connect to".$ftp_server;

                    }

                }
                else{
                    $data['success'] = false;
                    $data['message'] ="No opening balance set for the day. Set opening balance and retry sending";

                }

            }
            catch (PDOException $e)
            {
                $error_insert = "select_failed";
                $data['success']=false;
                $data['message']=$e->getMessage();
            }


        }
        else{
//            No settings, then throw error
            $data['success']=false;
            $data['message']="No settings yet, please update your settings table";
        }
    }
    catch (PDOException $e)
    {
        $error_insert = "select_failed";
        $data['success']=false;
        $data['message']=$e->getMessage();
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