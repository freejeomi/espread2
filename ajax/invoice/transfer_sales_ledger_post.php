<?php
$data = array();
$result="";
$sql= "";
include "../../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    $data['message'] = "Oops. something went wrong while connecting to database. please try again";
    $data['success'] = false;
}
if (isset($_POST['move_date'])) {
    $start_date = $_POST['move_date'];
    $end_date = date("Y-m-d");

    if (empty($start_date)) {
        $data['error']= "Please select a date";
        $data['success']= false;
    }
    else {
        $start_date = date("Y-m-d", strtotime($start_date) );
        $query = mysqli_query($conn, "SELECT sales_date FROM salesinvoice_daily WHERE sales_date= '$start_date'");
        if (mysqli_num_rows($query) < 1) {
            $data['error'] = "Please choose a date within the specified range above";
            $data['success'] = false;
            $data['date'] = $start_date;
            $data['enddate'] = $end_date;
        }
        else {
            $sql = "INSERT into salesinvoice (invoice_num, sales_date, sales_time, purchase_amount, store, payment_type, status, cashier, store_confirmation, user_id, customer_id ) SELECT * FROM salesinvoice_daily WHERE sales_date BETWEEN '$start_date' AND '$end_date'";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                $data['message'] = "an error occured while inserting into the sales invoice table";
                $data['success'] = false;
            } else {
                $result = mysqli_query($conn, "DELETE FROM salesinvoice_daily WHERE sales_date BETWEEN '$start_date' AND '$end_date' ");
                if (!$result) {
                    $data['message'] = "an error occured while deleting from sales invoice table";
                    $data['success'] = false;
                } else {
                    $result_check = mysqli_query($conn, "select * from salesinvoice_daily");
                    if (mysqli_num_rows($result_check) > 0) {
                        $result = mysqli_query($conn, "SELECT MIN(sales_date) as min_date, MAX(sales_date) as max_date FROM salesinvoice_daily");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $min_date = $row['min_date'];
                                $max_date = $row['max_date'];
                            }
                            $data['message'] = "Transfer successful!!!";
                            $data['min_date'] = date("l, F d, Y", strtotime($min_date));
                            $data['max_date']= date("l, F d, Y", strtotime($max_date));
                            $data['success'] = true;
                            // echo $script_date;
                        }
                    } else {
                        $data['display'] = "<b class='alert alert-default' style='border: 1px solid whitesmoke;'>there are no records in the sales ledger at the moment</b>";
                        $data['message'] = "Transfer successful!!!";
                        $data['success'] = true;
                    }
                }
            }
        }
    }
}
echo json_encode($data);
?>