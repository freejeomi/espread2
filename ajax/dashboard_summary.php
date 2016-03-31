<?php

$data = array();
$sql="";
$result_sales= "";
$row_sales="";
$data['success'] = false;
$opening_bal= "";
$cash_in="";
$total_cashin="";
$cash_out= "";
$total_bal= "";
$supplier= "";
$expense= "";
$total_sales_week= "";
$sales_date= "";
$chart_data= "";
$date1= "";
$date2= "";
$sales_day= "Day";

include "../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    $data['message'] = "Oops. something went wrong while connecting to database. please try again";
    $data['success'] = false;
}

//=========================code for dashboard daily summary starts here==========================//
if (isset($_POST['date_request'])) {
    $date_request= $_POST['date_request'];

    //code to retrieve total sales from sales invoice main
    $sql= "SELECT SUM(purchase_amount)as total_sales from salesinvoice_daily WHERE sales_date = '$date_request'";
    $result_sales= mysqli_query($conn, $sql);
    if (mysqli_num_rows($result_sales) > 0) {
        while ($row_sales= mysqli_fetch_assoc($result_sales)) {
            //$data['success'] = true;
            $sales_daily= $row_sales['total_sales'] ;
        }
        $sql = "SELECT SUM(purchase_amount) as total_sales from salesinvoice WHERE sales_date= '$date_request'";
        $result_sales = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result_sales) > 0) {
            while ($row_sales = mysqli_fetch_assoc($result_sales)) {
                $sales_archive= $row_sales['total_sales'];
            }
        }
        else {
            $sales_archive= 0.00;
        }
        $sales_combined = $sales_daily + $sales_archive;
    }
    else {
        $sales_daily= 0.00;
        //code to retrieve total sales from sales invoice main
        $sql = "SELECT SUM(purchase_amount) as total_sales from salesinvoice WHERE sales_date= '$date_request'";
        $result_sales = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result_sales) > 0) {
            while ($row_sales = mysqli_fetch_assoc($result_sales)) {
                $sales_archive = $row_sales['total_sales'];
            }
        }
        else {
            $sales_archive = 0.00;
        }
        $sales_combined = $sales_daily + $sales_archive;
    }

    $data['sales'] = number_format($sales_combined, 2);
    $data['success'] = true;


    //code to retrieve sum of supplier payment
    $sql= "select sum(amount) as total from cashstock where amount < 0 and transaction_type = 'supplier payment' and date = '$date_request'";
    $result_supply= mysqli_query($conn, $sql);
        if (mysqli_num_rows($result_supply) > 0) {
            while ($row_supply = mysqli_fetch_assoc($result_supply)) {
                $supplier= $row_supply['total'];
                //$data['success'] = true;
                $data['supply'] = number_format(0 - $row_supply['total'], 2);

            }
        } else {
            $data['success'] = true;
            $data['supply'] = "0.00";
        }
        //code to retrieve sum of other expenses
        $sql = "select sum(amount) as total from cashstock where amount < 0 and transaction_type = 'other expenses' and date = '$date_request'";
        $result_expenses = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result_expenses) > 0) {
            while ($row_supply = mysqli_fetch_assoc($result_expenses)) {
                //$data['success'] = true;
                $expense= $row_supply['total'];
                $data['expenses'] = number_format(0 - $row_supply['total'], 2);

            }
        } else {
            $data['success'] = true;
            $data['expenses'] = "0.00";
        }
        //code to retrieve opening balance
        $result_opbal= mysqli_query($conn,"SELECT amount from openingbalance where date= '$date_request'");
        if (mysqli_num_rows($result_opbal) > 0) {
            while ($row_opbal = mysqli_fetch_assoc($result_opbal)) {
                //$data['success'] = true;
                $data['opbalance'] = number_format($row_opbal['amount'], 2);
                $opbal= $row_opbal['amount'];

            }
        } else {
            $data['success'] = true;
            $data['opbalance'] = "0.00";
            $opbal= 0.00;
        }
        //code to retrieve cash in
        $sql= "select SUM(amount) as total FROM cashstock WHERE amount > 0 AND transaction_type != 'opening balance' AND date= '$date_request'";
        $result_cashin= mysqli_query($conn, $sql);
        if (mysqli_num_rows($result_cashin) > 0) {
            $row_cashin = mysqli_fetch_assoc($result_cashin);
            if ($row_cashin['total']) {
                $data['cash_in'] = number_format($row_cashin['total'], 2);
                $cash_in = $row_cashin['total'];
            }
            else {
                $data['cash_in'] = "0.00";
                $cash_in = 0.00;
            }
        } else {
            $data['success'] = true;
            $data['cash_in'] = "0.00";
            $cash_in= 0.00;
        }

        //code to retrieve cash out
        $sql= "SELECT sum(amount) as cashout from cashstock where amount < 0 and transaction_type != 'customer payment' and date= '$date_request'";
        $result_cashout= mysqli_query($conn, $sql);
        if (mysqli_num_rows($result_cashout) > 0) {
            $row_cashout = mysqli_fetch_assoc($result_cashout);
            if ($row_cashout['cashout']) {
                $cash_out = $row_cashout['cashout'];
            }
            else {
                $cash_out =  0.00;
            }
            //$cash_out= $haulage + $supplier + $expense;    //calculate cash out
            $total_bal = $opbal + $cash_in + $cash_out;    //calaculate balance
            //echo $row_cashout['total'];
            $data['cash_out'] = number_format(0 - $cash_out, 2);
            //$cash_out= $row_cashout['total'];

            $data['total_balance'] = number_format($total_bal, 2);
            $data['success'] = true;

        } else {
            $data['cash_out'] = "0.00";
            $cash_out = 0.00;

            $total_bal = $opbal + $cash_in + $cash_out;

            $data['total_balance'] = number_format($total_bal, 2 );
            $data['success'] = true;
        }
    echo json_encode($data);
}

//=============================code for weekly graph starts here================================//
$date_array = array();
if (isset($_GET['week_date1']) && isset($_GET['week_date2'])) {
    $date1 = $_GET['week_date1'];
    $date2 = $_GET['week_date2'];
    $date_array[0] = $_GET['week_date1'];
    //$date_array[6]=$date2;
    $changing_date = $date1;
    $date_time = "";
    for ($i = 1; $i < 7; $i++) {

        $date_time = strtotime($changing_date . ' +1 day');
        $date_array[$i] = date('Y-m-d', $date_time);
        $changing_date = $date_array[$i];
        //echo $changing_date;
    }
    $chart_data = array();
    foreach ($date_array as $date_picked) {

        $sql_week = "(SELECT SUM(purchase_amount)as total_sales, sales_date from salesinvoice_daily WHERE sales_date='$date_picked')UNION (SELECT SUM(purchase_amount)as total_sales2, sales_date from salesinvoice WHERE sales_date='$date_picked')";
        $result_week = mysqli_query($conn, $sql_week);
        if (!$result_week) {
            $error = "an error occured while retrieving from sales invoice";
            //$data['success'] = false;
        } else {
            if (mysqli_num_rows($result_week) > 0) {
                $total_sales_week = 0;
                while ($row = mysqli_fetch_assoc($result_week)) {
                    if ($row['total_sales'] == null) {
                        $total_sales_week += 0;
                    } else {
                        $total_sales_week += $row['total_sales'];
                    }

                }


                //$data['success'] = true;
                //$i++;
                array_push($chart_data, array(date('l,d', strtotime($date_picked)), $total_sales_week));

            } else {
                $total_sales_week = 0;
                $sales_date = 0;
                array_push($chart_data, array($date_picked, $total_sales_week));
//            $chart_data .= '{ "' . $sales_day . '": "' . $date_picked . '", "sales": ' . $total_sales_week . '},';
                //$data['message'] = "no record found";
                //$data['success'] = true;
            }
        }

    }
//$chart_data.=']';

//    $chart_data = substr($chart_data, 0, strlen($chart_data) - 1);
//    $chart_data = '[' . $chart_data . ']';
    echo json_encode($chart_data);
    mysqli_close($conn);
}

//=======================code for monthly graph begins code=====================================//
if (isset($_GET['year_val'])) {
    $year_chart_data = array();
    $year_selected = $_GET['year_val'];

    for ($m = 1; $m < 13; $m++) {
        $x = date($year_selected . "-" . $m);

        $mdate1 = date('Y-m-01', strtotime($x));
        $mdate2 = date('Y-m-t', strtotime($x));

        $date_picked_ = $mdate1;

        $result_year_summ = mysqli_query($conn, "(SELECT SUM(purchase_amount)as total_sales, sales_date from salesinvoice_daily WHERE sales_date BETWEEN '$mdate1' AND '$mdate2') UNION (SELECT SUM(purchase_amount)as total_sales, sales_date from salesinvoice WHERE sales_date BETWEEN '$mdate1' AND '$mdate2')");
        if (mysqli_num_rows($result_year_summ) > 0) {
            $total_sales_week = 0;
            while ($row = mysqli_fetch_assoc($result_year_summ)) {
                if ($row['total_sales']) {
                    $total_sales_week += $row['total_sales'];
                } else {
                    $total_sales_week += 0;
                }
            }
            array_push($year_chart_data, array(date('M', strtotime($date_picked_)), $total_sales_week));


        } else {
            $total_sales_week = 0;
            $sales_date = 0;
            array_push($year_chart_data, array($date_picked_, $total_sales_week));
        }

    }
    echo json_encode($year_chart_data);
    mysqli_close($conn);
}


//=======================code for yearly dashboard summary starts here========================//
$acct_date1= "";
$acct_date2= "";
$acct_sales_main= "";
$acct_sales_temp= "";
$acct_sales_total= "";
$acct_purchase= "";
$acct_expense= "";
$profit= "";
$acct_sales_main2 = "";
$acct_sales_temp2 = "";
$acct_sales_total2 = "";
$acct_purchase2 = "";
$acct_expense2 = "";
$profit2 = "";
if (isset($_POST['year_summary']) && $_POST['year_summary']== "check") {
    //retrieve the start and end date for the accounting year from settings
    $result_accounting_year= mysqli_query($conn, "SELECT accounting_year_start, accounting_year_end FROM settings");
    if (mysqli_num_rows($result_accounting_year) > 0) {
    //there is an accounting period. save it to variables and continue processing
        while ($row = mysqli_fetch_assoc($result_accounting_year)) {
            $acct_date1= $row['accounting_year_start'];
            $acct_date2 = $row['accounting_year_end'];
        }
        //query for total sales made within the accounting year period from sales invoice
        $result_acct_sales = mysqli_query($conn, "SELECT sum(purchase_amount) as total_sales FROM salesinvoice WHERE sales_date BETWEEN '$acct_date1' AND '$acct_date2'");
        if (mysqli_num_rows($result_acct_sales) > 0) {
            while ($row= mysqli_fetch_assoc($result_acct_sales)) {
                $acct_sales_main= $row['total_sales'];
            }
        }
        else {
            $acct_sales_main = 0.00;
        }
        $result_acct_sales2 = mysqli_query($conn, "SELECT sum(purchase_amount) as total_sales FROM salesinvoice_daily WHERE sales_date BETWEEN '$acct_date1' AND '$acct_date2'");
        if (mysqli_num_rows($result_acct_sales2) > 0) {
            while ($row = mysqli_fetch_assoc($result_acct_sales2)) {
                $acct_sales_temp = $row['total_sales'];
            }
        } else {
            $acct_sales_temp = 0.00;
        }
        //echo $acct_sales_temp. " ";
        //echo $acct_sales_main;
        $acct_sales_total= $acct_sales_main + $acct_sales_temp;
        $data['sales_total_acct'] = number_format($acct_sales_total, 2);
        //$data['success']= true;

        //query for suppplier payment (purchases) from cash stock
        $result_acct_purchase= mysqli_query($conn, "SELECT sum(amount) as total_purchase FROM cashstock WHERE amount < 0 and transaction_type='supplier payment' AND date BETWEEN '$acct_date1' AND '$acct_date2'");
        if (mysqli_num_rows($result_acct_purchase) > 0) {
            while ($row = mysqli_fetch_assoc($result_acct_purchase)) {
                $acct_purchase = $row['total_purchase'];
                $data['purchase_total_acct'] = number_format((0-$acct_purchase), 2);
                //$data['success']= true;
            }
        } else {
            $acct_purchase = 0;
            $data['purchase_total_acct'] = number_format((0-$acct_purchase), 2);
            //$data['success'] = true;
        }

        //query to get haulage expense
        $result_haulage_expense= mysqli_query($conn, "SELECT sum(amount) as haulage_expense FROM cashstock WHERE transaction_type='haulage expenses' AND (date BETWEEN '$acct_date1' AND '$acct_date2')");
        if (mysqli_num_rows($result_haulage_expense) > 0) {
            $row= mysqli_fetch_assoc($result_haulage_expense);
            $haulage_expense= $row['haulage_expense'];
        }
        else {
            $haulage_expense = 0.00;
        }
        //query for other expenses from cash stock
        $result_other_expense= mysqli_query($conn, "SELECT sum(amount) as other_expense FROM cashstock WHERE transaction_type='other expenses' AND (date BETWEEN '$acct_date1' AND '$acct_date2')");
        if (mysqli_num_rows($result_other_expense) > 0) {
            $row= mysqli_fetch_assoc($result_other_expense);
            $other_expense = $row['other_expense'];

            $acct_expense= $haulage_expense + $other_expense;
            $data['expense_total_acct'] = number_format((0 - $acct_expense), 2);
            //calaculate the profit/loss using the result of sales, purchase and expenses queries
            $profit = $acct_sales_total + ($acct_purchase + $acct_expense);
            $data['profit'] = number_format($profit, 2);

            //$data['success'] = true;
        }
        else {
            $other_expense = 0;
            $acct_expense = $haulage_expense + $other_expense;
            $data['expense_total_acct'] = number_format((0-$acct_expense), 2);
            //calaculate the profit/loss using the result of sales, purchase and expenses queries
            $profit = $acct_sales_total + ($acct_purchase + $acct_expense);
            $data['profit'] = number_format($profit, 2);

            //$data['success'] = true;
        }
//=========CODE TO CALCULATE PERCENT INCREASE BEGINS HERE======================================//
        //get one year minus the accounting date
        $acct_date_ = strtotime($acct_date1 . ' -1 year');
        $acct_date2_ = strtotime($acct_date2 . ' -1 year');

        $acct_date_start_prev = date('Y-m-d', $acct_date_);
        $acct_date_end_prev = date('Y-m-d', $acct_date2_);


        //query for total sales made within the accounting year period from sales invoice
        $result_acct_sales = mysqli_query($conn, "SELECT sum(purchase_amount) as total_sales FROM salesinvoice WHERE sales_date BETWEEN '$acct_date_start_prev' AND '$acct_date_end_prev'");
        if (mysqli_num_rows($result_acct_sales) > 0) {
            while ($row = mysqli_fetch_assoc($result_acct_sales)) {
                $acct_sales_main2 = $row['total_sales'];
            }
        } else {
            $acct_sales_main2 = 0.00;
        }
        $result_acct_sales2 = mysqli_query($conn, "SELECT sum(purchase_amount) as total_sales FROM salesinvoice_daily WHERE sales_date BETWEEN '$acct_date_start_prev' AND '$acct_date_end_prev'");
        if (mysqli_num_rows($result_acct_sales2) > 0) {
            while ($row = mysqli_fetch_assoc($result_acct_sales2)) {
                $acct_sales_temp2 = $row['total_sales'];
            }
        } else {
            $acct_sales_temp2 = 0.00;
        }
        //echo $acct_sales_temp2. " ";
        //echo $acct_sales_main2;
        $acct_sales_total2 = $acct_sales_main2 + $acct_sales_temp2;
        if($acct_sales_total2 == 0.00) {
            $data['sales_total_acct_prev'] = "nothing";
        }
        else {
            $pcent_sales = ($acct_sales_total - $acct_sales_total2) * 100 / $acct_sales_total2;
            $data['sales_total_acct_prev'] = number_format($pcent_sales, 2);
        }



        //$data['success'] = true;

        //query for suppplier payment (purchases) from cash stock
        $result_acct_purchase = mysqli_query($conn, "SELECT sum(amount) as total_purchase FROM cashstock WHERE transaction_type='supplier payment' AND date BETWEEN '$acct_date_start_prev' AND '$acct_date_end_prev'");
        if (mysqli_num_rows($result_acct_purchase) > 0) {
            while ($row = mysqli_fetch_assoc($result_acct_purchase)) {
                $acct_purchase2 = $row['total_purchase'];
                //$data['purchase_total_acct_prev'] = number_format($acct_purchase2, 2);
                //$data['success'] = true;
            }
        } else {
            $acct_purchase2 = 0.00;
            //$data['purchase_total_acct_prev'] = number_format($acct_purchase2, 2);
            //$data['success'] = true;
        }
        if ($acct_purchase2 == 0.00) {
            $data['purchase_total_acct_prev'] = "nothing";
        }
        else {
            $pcent_purchase = ($acct_purchase - $acct_purchase2) * 100 / $acct_purchase2;
            $data['purchase_total_acct_prev'] = number_format($pcent_purchase, 2);
        }


        //$data['success'] = true;

        //query for other expenses and haulage from cash stock
        $result_acct_expense = mysqli_query($conn, "SELECT sum(amount) as total_expense FROM cashstock WHERE (transaction_type='other expenses' OR transaction_type='Haulage expense') AND (date BETWEEN '$acct_date_start_prev' AND '$acct_date_end_prev')");
        if (mysqli_num_rows($result_acct_expense) > 0) {
            while ($row = mysqli_fetch_assoc($result_acct_expense)) {
                $acct_expense2 = $row['total_expense'];
                //$data['expense_total_acct_prev'] = number_format($acct_expense2, 2);
                //calaculate the profit/loss using the result of sales, purchase and expenses queries
                $profit2 = $acct_sales_total2 - ($acct_purchase2 + $acct_expense2);
//                $data['profit_prev'] = number_format($profit2, 2);
//                $data['success'] = true;
            }
        } else {
            $acct_expense2 = 0.00;
           // $data['expense_total_acct_prev'] = number_format($acct_expense2, 2);
            //calaculate the profit/loss using the result of sales, purchase and expenses queries
//            echo acct_purchase2;
//            echo $acct_expense2;
//            echo $acct_sales_total2;

            $profit2 = $acct_sales_total2 - ($acct_purchase2 + $acct_expense2);
//            $data['profit_prev'] = number_format($profit2, 2);
//            $data['success'] = true;
        }

        if ($acct_expense2 == 0.00) {
            $data['expense_total_acct_prev'] = "nothing";
        }
        else {
            $pcent_expense = ($acct_expense - $acct_expense2) * 100 / $acct_expense2;
            $data['expense_total_acct_prev'] = number_format($pcent_expense, 2);
        }

        if ($profit2 == 0.00) {
            $data['profit_prev'] = "nothing";
        }
        else {
            $pcentprofit = ($profit - $profit2) * 100 / $profit2;
            $data['profit_prev'] = number_format($pcentprofit, 2);
        }

        $data['success'] = true;
    }
    else {
        //no accounting year period in the settings table
        $data['expense_total_acct']= "0.00";
        $data['purchase_total_acct']= "0.00";
        $data['sales_total_acct']= "0.00";
        $data['profit']= "0.00";
        $data['expense_total_acct_prev'] = "0";
        $data['purchase_total_acct_prev'] = "0";
        $data['sales_total_acct_prev'] = "0";
        $data['profit_prev'] = "0";
        $data['success'] = true;
    }
    echo json_encode($data);
}