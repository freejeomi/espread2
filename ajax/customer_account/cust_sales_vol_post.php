<?php
$start_date = "";
$end_date = "";
include "../../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset ($_POST['start_date']) && isset ($_POST['end_date'])) {
    if (empty($_POST['start_date'])) {
        $errors['start_date'] = "enter the start date";
    } else {
        $start_date = $_POST['start_date'];
    }

    if (empty($_POST['end_date'])) {
        $errors['end_date'] = 'please enter the end date.';
    } else {
        $end_date = $_POST['end_date'];
    }
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
    }
    echo json_encode($data);
}

//(SELECT SUM(salesinvoice . purchase_amount) as total_salesinvoice FROM salesinvoice WHERE salesinvoice . sales_date BETWEEN '2016-02-12' AND '2016-02-19' GROUP by salesinvoice . customer_id)UNION (SELECT SUM(salesinvoice_daily . purchase_amount) as total_salesinvoicedaily FROM salesinvoice_daily WHERE salesinvoice_daily . sales_date BETWEEN '2016-02-12' AND '2016-02-19' GROUP by salesinvoice_daily . customer_id)

//(SELECT customer . customer_name, SUM(salesinvoice . purchase_amount) as total FROM salesinvoice, customer WHERE customer . customer_id = salesinvoice . customer_id AND salesinvoice . sales_date BETWEEN '2016-02-12' AND '2016-02-19' GROUP by salesinvoice . customer_id) UNION (SELECT customer . customer_name, SUM(salesinvoice_daily . purchase_amount) as total FROM salesinvoice_daily, customer WHERE customer . customer_id = salesinvoice_daily . customer_id AND salesinvoice_daily . sales_date BETWEEN '2016-02-12' AND '2016-02-19' GROUP by salesinvoice_daily . customer_id)


//SELECT promoaccount . quantity, customer . customer_name, stock . stock_name, invoiceitems_daily . invoice_num, stock . costprice FROM promoaccount
//INNER JOIN stock ON stock . stock_code = promoaccount . stock_code
//INNER JOIN invoiceitems_daily ON invoiceitems_daily . item_id = promoaccount . item_id
//INNER JOIN salesinvoice ON salesinvoice . invoice_num = invoiceitems_daily . invoice_num
//INNER JOIN customer on customer . customer_id = salesinvoice . customer_id
//WHERE promoaccount . trans_date BETWEEN '2016-02-20' AND '2016-02-23'
//GROUP BY promoaccount . stock_code