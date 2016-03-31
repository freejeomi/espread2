<?php
$errors = array();    // array to hold validation errors
$data = array();        // array to pass back data
$stock_name= "";
$stock_id= "";
$total_sales_stock= "";
$sql= "";
$total_amount = "";
$cus_id = "";
$cus_name = "";
$stock = "";
$result= "";
include "../../lib/util.php";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$conn) {
    $data['success'] = false;
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['stock_id'])) {
//validate the waybill number
    if (empty($_POST['store_id'])) {
        $errors['store'] = "select a store please";
    }
    else if($_POST['store_id']== "none"){
        $errors['store'] = "select a store please";
    }
    else {
        $store_id = $_POST['store_id'];
    }
//validate the expenditure amount
    if (empty($_POST['stock_id'])) {
        $errors['stock'] = 'select stock please';
    }
    else if ($_POST['stock_id'] == "none") {
        $errors['stock'] = "select stock please";
    }
    else {
        $stock_id = $_POST['stock_id'];
    }

    if (empty($_POST['start_date'])) {
        $errors['startdate'] = 'Enter the start date';
    } else {
        $startdate = $_POST['start_date'];
    }

    if (empty($_POST['end_date'])) {
        $errors['finishdate'] = 'Enter the end date';
    } else {
        $finishdate = $_POST['end_date'];
    }

    $stock_quantity = $_POST['stock_count'];

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    }
    else {
        $result= mysqli_query($conn, "DELETE FROM allocationfile_sales") or die(mysqli_error($conn));

        $sql= "SELECT SUM(charge) AS total_sales, invoiceitems_daily.stock_id, stock.stock_name FROM invoiceitems_daily, stock WHERE (invoiceitems_daily.stock_id= '$stock_id') AND stock.stock_id= invoiceitems_daily.stock_id AND (trans_date BETWEEN '$startdate' AND '$finishdate')";
        $result= mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row= mysqli_fetch_assoc($result)) {
                $total_sales_stock= $row['total_sales'];
                $stock_id= $row['stock_id'];
                $stock_name= $row['stock_name'];
            }

            $sql_select= "SELECT sum(total_sales)* $stock_quantity / $total_sales_stock as total_sales,customer_id, customer_name, stock_name FROM (SELECT sum(invoiceitems_daily.charge) as total_sales, salesinvoice_daily.customer_id,customer.customer_name, stock.stock_name FROM salesinvoice_daily INNER JOIN invoiceitems_daily ON salesinvoice_daily.invoice_num = invoiceitems_daily.invoice_num RIGHT JOIN customer ON salesinvoice_daily.customer_id = customer.customer_id INNER JOIN stock ON invoiceitems_daily.stock_id = stock.stock_id WHERE sales_date BETWEEN '$startdate' AND '$finishdate' AND invoiceitems_daily.stock_id = '$stock_id' GROUP BY salesinvoice_daily.customer_id
            UNION
            SELECT sum(invoiceitems_daily.charge) as total_sales, salesinvoice.customer_id, customer.customer_name, stock.stock_name FROM salesinvoice INNER JOIN invoiceitems_daily ON salesinvoice.invoice_num = invoiceitems_daily.invoice_num RIGHT JOIN customer ON salesinvoice.customer_id = customer.customer_id INNER JOIN stock ON invoiceitems_daily.stock_id = stock.stock_id WHERE sales_date BETWEEN '$startdate' AND '$finishdate' AND invoiceitems_daily.stock_id = '$stock_id' GROUP BY salesinvoice.customer_id) AS table_union GROUP BY table_union.customer_id";
            $result_select = mysqli_query($conn, $sql_select);
            if (!$result_select) {
                $data['message'] = "An error occured while selecting from invoice items daily";
                $data['success'] = false;
            }
            else {
                if (mysqli_num_rows($result_select) > 0) {
                    while ($row= mysqli_fetch_assoc($result_select)) {
                        $total_amount = $row['total_sales'];
                        $cus_id = $row['customer_id'];
                        $cus_name = $row['customer_name'];
                        $stock = $row['stock_name'];

                        $result_allocate= mysqli_query($conn, "INSERT into allocationfile_sales(stock, customer, quantity) VALUES ('$stock', '$cus_name', '$total_amount')");

                        if (!$result_allocate) {
                            $data['message'] = "An error occured while inserting into allocationfile_sales";
                            $data['success'] = false;
                        } else {
                            $data['success'] = true;
                        }
                        $data['stock_in_table'] = $stock_name;
                    }
                }
            }
        }
    }
    echo json_encode($data);
}

if ( isset($_POST['delete_command']) && $_POST['delete_command']== "empty" ) {
    $result = mysqli_query($conn, "DELETE FROM allocationfile_sales");
    if (!$result) {
        $data['message']= "an error when deleting from allocationfile_sales table on click of the button on the page";
        $data['success'] = false;
    }
    else {
        $data['success'] = true;
    }
    echo json_encode($data);
}

if (isset($_POST['load_command']) && $_POST['load_command'] == "fetch") {
    $result = mysqli_query($conn, "SELECT stock FROM allocationfile_sales");
    if (!$result) {
        $data['message'] = "an error while retrieving from allocationfile_sales table on page load";
        $data['success'] = false;
    } else {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data['stock_in_table'] = $row['stock'];
            }
            $data['success'] = true;
        }
        else {
            $data['stock_in_table'] = "";
        }
    }

    echo json_encode($data);
}

//SELECT SUM(charge) AS total_sales, invoiceitems_daily . stock_id, stock . stock_name FROM invoiceitems_daily, stock WHERE(invoiceitems_daily . stock_id = '13') AND stock . stock_id = invoiceitems_daily . stock_id AND (trans_date BETWEEN '2016-02-17' AND '2016-02-19')

//INSERT into allocationfile_sales(stock, customer, quantity)(SELECT stock . stock_name, customer . customer_name, SUM(charge) * 343186 / 1215.00 AS total_sales  FROM invoiceitems_daily, salesinvoice_daily, customer, stock WHERE(salesinvoice_daily . invoice_num = invoiceitems_daily . invoice_num) AND stock . stock_id = invoiceitems_daily . stock_id AND (invoiceitems_daily . stock_id = '13') AND (trans_date BETWEEN '2016-02-17' AND '2016-02-19') AND (salesinvoice_daily . customer_id = customer . customer_id) GROUP BY salesinvoice_daily . customer_id)

//SELECT SUM(charge) AS total_sales, invoiceitems_daily . stock_id, stock . stock_name FROM invoiceitems_daily, stock WHERE(invoiceitems_daily . stock_id = '9') AND stock . stock_id = invoiceitems_daily . stock_id AND (trans_date BETWEEN '2016-02-15' AND '2016-02-19')

//SELECT SUM(charge) AS total_sales, invoiceitems_daily . stock_id, stock . stock_name, salesinvoice_daily . customer_id FROM invoiceitems_daily, salesinvoice_daily, stock WHERE(invoiceitems_daily . stock_id = '9') AND stock . stock_id = invoiceitems_daily . stock_id AND (trans_date BETWEEN '2016-02-15' AND '2016-02-19') GROUP by customer_id
//SELECT SUM(charge) AS total_sales, stock . stock_name, customer_id FROM invoiceitems_daily, salesinvoice_daily, stock WHERE(invoiceitems_daily . stock_id = '9') AND stock . stock_id = invoiceitems_daily . stock_id AND invoiceitems_daily . invoice_num = salesinvoice_daily . invoice_num AND (trans_date BETWEEN '2016-02-15' AND '2016-02-19') GROUP by customer_id
