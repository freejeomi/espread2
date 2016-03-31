<?php
$errors = array();    // array to hold validation errors
$data = array();        // array to pass back data
$stock_name = "";
$customer_name= "";
$stock_id = "";
$total_sales_stock = "";
$sql = "";
$result = "";
$items_row="";
$items_table = '<div id="items_table" class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12"><table class="table table-striped table-hover"><thead><tr><th>S/N</th><th>Stock</th><th>Customer</th><th>Allocation</th></tr></thead><tbody>';
$items_end_table= '</tbody></table></div>';

include "../../lib/util.php";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$conn) {
    $data['success'] = false;
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['customer_id'])) {
    if (empty($_POST['customer_id'])) {
        $errors['customer'] = "select a customer please";
    } else if ($_POST['customer_id'] == "none") {
        $errors['customer'] = "select a customer please";
    } else {
        $customer_id = $_POST['customer_id'];
        $result_cus= mysqli_query($conn, "SELECT customer_name from customer where customer_id = '$customer_id'");
        while ($row= mysqli_fetch_assoc($result_cus)) {
            $customer_name= $row['customer_name'];
        }
    }

    if (empty($_POST['store_id'])) {
        $errors['store'] = "select a store please";
    } else if ($_POST['store_id'] == "none") {
        $errors['store'] = "select a store please";
    } else {
        $store_id = $_POST['store_id'];
    }
//validate the expenditure amount
    if (empty($_POST['stock_id'])) {
        $errors['stock'] = 'select stock please';
    } else if ($_POST['stock_id'] == "none") {
        $errors['stock'] = "select stock please";
    } else {
        $stock_id = $_POST['stock_id'];
        $result_stock = mysqli_query($conn, "SELECT stock_name from stock where stock_id = '$stock_id'");
        while ($row = mysqli_fetch_assoc($result_stock)) {
            $stock_name = $row['stock_name'];
        }
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
    } else {
        //retrieve total sales from sales invoice daily table
        $result_total= mysqli_query($conn, "SELECT SUM(purchase_amount) as total_sales From salesinvoice_daily where sales_date BETWEEN '$startdate' AND '$finishdate'");
        if (mysqli_num_rows($result_total) > 0) {
            while ($row= mysqli_fetch_assoc($result_total)) {
                $total_daily= $row['total_sales'];
            }
        }
        else {
            $total_daily = 0.00;
        }
        //retrieve total sales from sales invoice table
        $result_total = mysqli_query($conn, "SELECT SUM(purchase_amount) as total_sales From salesinvoice where sales_date BETWEEN '$startdate' AND '$finishdate'");
        if (mysqli_num_rows($result_total) > 0) {
            while ($row = mysqli_fetch_assoc($result_total)) {
                $total_archive = $row['total_sales'];
            }
        }
        else {
            $total_archive = 0.00;
        }
        //add up the totsl sales from both tables
        $total_sales= $total_daily + $total_archive;
        //retrieve total sales for customer from sales invoice daily
        $result_customer_total = mysqli_query($conn, "SELECT SUM(purchase_amount) as total_sales From salesinvoice_daily where sales_date BETWEEN '$startdate' AND '$finishdate' AND customer_id= $customer_id");
        if (mysqli_num_rows($result_total) > 0) {
            while ($row = mysqli_fetch_assoc($result_customer_total)) {
                $total_customer_daily = $row['total_sales'];
            }
        } else {
            $total_customer_daily = 0.00;
        }
        //retrieve total sales for customer from sales invoice
        $result_customer_total = mysqli_query($conn, "SELECT SUM(purchase_amount) as total_sales From salesinvoice where sales_date BETWEEN '$startdate' AND '$finishdate' AND customer_id= $customer_id");
        if (mysqli_num_rows($result_total) > 0) {
            while ($row = mysqli_fetch_assoc($result_customer_total)) {
                $total_customer_archive = $row['total_sales'];
            }
        } else {
            $total_customer_archive = 0.00;
        }
        //add the customer sales from both tables
        $customer_total_sales= $total_customer_daily + $total_customer_archive;

        //compute the allocation amount for the customer
//        echo $customer_total_sales .'<br>';
//        echo $total_sales . '<br>';
//        echo $stock_quantity . '<br>';
        $allocation= $customer_total_sales * $stock_quantity / $total_sales;

        //insert the computation into the allocation table
        $result_allocate= mysqli_query($conn, "INSERT INTO allocationfile_turnover (stock, customer, quantity)  VALUES ('$stock_name', '$customer_name', '$allocation')");
        if (!$result_allocate) {
            $data['message'] = "An error occured while inserting into allocationfile_sales";
            $data['success'] = false;
        } else {
            $result_display= mysqli_query($conn, "SELECT * FROM allocationfile_turnover");
            $s= 1;
            if (mysqli_num_rows($result_display) > 0 ) {
                while ($row= mysqli_fetch_assoc($result_display)) {
                    $items_row .= '<tr><td>' . $s . '</td><td>' . $row['stock'] . '</td><td>' . $row['customer'] . '</td><td>' . $row['quantity'].'</td></tr>';
                    $s++;
                }

                $data['table'] = $items_table. $items_row. $items_end_table;
                //$data['item_row'] = $items_row;
                $data['success'] = true;
            }
            else {
                $items_row= "";
                $data['table'] = $items_table . $items_row . $items_end_table;
                //$data['table_head']= $items_table;
                //$data['item_row']= "";
                $data['success'] = true;
            }
        }
    }
    echo json_encode($data);
}

//        $sql = "SELECT SUM(purchase_amount) AS total_sales, invoiceitems_daily.stock_id, stock.stock_name FROM invoiceitems_daily, stock WHERE (invoiceitems_daily.stock_id= '$stock_id') AND stock.stock_id= invoiceitems_daily.stock_id AND (trans_date BETWEEN '$startdate' AND '$finishdate')";
//        $result = mysqli_query($conn, $sql);
//        if (mysqli_num_rows($result) > 0) {
//            while ($row = mysqli_fetch_assoc($result)) {
//                $total_sales_stock = $row['total_sales'];
//                $stock_id = $row['stock_id'];
//                $stock_name = $row['stock_name'];
//            }
//
//            $sql = "(SELECT stock.stock_name, customer.customer_name, SUM(charge) * $stock_quantity / $total_sales_stock AS total_sales  FROM invoiceitems_daily, salesinvoice_daily, customer, stock WHERE(salesinvoice_daily . invoice_num = invoiceitems_daily . invoice_num) AND stock.stock_id= invoiceitems_daily.stock_id AND (invoiceitems_daily.stock_id = '$stock_id') AND (trans_date BETWEEN '$startdate' AND '$finishdate') AND (salesinvoice_daily .customer_id = customer . customer_id) AND salesinvoice_daily.customer_id= '$customer_id')";
//            $result = mysqli_query($conn, $sql);
//            if (!$result) {
//                $data['message'] = "An error occured while inserting into allocationfile_sales";
//                $data['success'] = false;
//            } else {
//                $result= mysqli_query($conn, "SELECT * FROM allocationfile_turnover");
//                $s= 1;
//                if (mysqli_num_rows($result) > 0 ) {
//                    while ($row= mysqli_fetch_assoc($result)) {
//                        $items_row .= '<tr><td>' . $s . '</td><td>' . $row['stock'] . '</td><td>' . $row['customer'] . '</td><td>' . $row['quantity'].'</td></tr>';
//                        $s++;
//                    }
//
//                    $data['table'] = $items_table. $items_row. $items_end_table;
//                    //$data['item_row'] = $items_row;
//                    $data['success'] = true;
//                }
//                else {
//                    $items_row= "";
//                    $data['table'] = $items_table . $items_row . $items_end_table;
//                    //$data['table_head']= $items_table;
//                    //$data['item_row']= "";
//                    $data['success'] = true;
//                }
//            }
//        }
//    }
//    echo json_encode($data);
//}


if (isset($_POST['load_command']) && $_POST['load_command'] == "fetch") {
    $result = mysqli_query($conn, "SELECT * FROM allocationfile_turnover");
    if (!$result) {
        $data['message'] = "an error while retrieving from allocationfile_sales table on page load";
        $data['success'] = false;
    } else {
        $s = 1;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $items_row .= '<tr><td>' . $s . '</td><td>' . $row['stock'] . '</td><td>' . $row['customer'] . '</td><td>' . $row['quantity'] . '</td></tr>';
                $s++;
            }

            $data['table'] = $items_table . $items_row . $items_end_table;
            //$data['item_row'] = $items_row;
            $data['success'] = true;
        }
        else {
            $items_row= "";
            $data['table'] = $items_table . $items_row . $items_end_table;
            $data['success'] = true;
        }
    }
    echo json_encode($data);
}


if (isset($_POST['delete_command']) && $_POST['delete_command'] == "empty") {
    $result = mysqli_query($conn, "DELETE FROM allocationfile_turnover");
    if (!$result) {
        $data['message'] = "an error when deleting from allocationfile_turnover table on click of the button on the page";
        $data['success'] = false;
    } else {
        $items_row= "";
        $data['stock_in_table'] = $items_table . $items_row . $items_end_table;
        $data['success'] = true;
    }
    echo json_encode($data);
}
//INSERT into allocationfile_turnover(stock, customer, quantity)