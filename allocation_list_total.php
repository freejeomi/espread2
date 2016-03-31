<?php
require_once("ajax/inc/init.php");
$role = "admin";
if (strtolower($_SESSION['role_name']) != strtolower($role)) {
    $page = 'login.php';
    ///header("location: /espread/#ajax/logout.php?page=$page");
    header("location: /espread/login.php");
    exit();
}

$sql= "";
$result= "";
include "lib/util.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$table1= "";
$table2 = "";
$table3 = "";

$table1_count= 0;
$table2_count = 0;
$table3_count = 0;

$result = mysqli_query($conn, "SELECT * FROM allocationfile_turnover");
$count_row= mysqli_num_rows($result);
//$count_row= 7;
$three= 3;
$half = floor($count_row / $three);

$table1_count = $half;
$table2_count = $half;
$table3_count = $half;

$table1_counthalf= $half* $three;

for ($i=0; $i< $count_row- $table1_counthalf; $i++) {
    if($table1_count <= $half) {
        $table1_count++;
        continue;
    }

    if ($table2_count <= $half) {
        $table2_count++;
        continue;
    }

    if ($table3_count <= $half) {
        $table3_count++;
        continue;
    }
}

$count = 1;
$s = 1;

//echo $table3_count. 'three ';
//echo $table1_count. 'one ';
//echo $table2_count. 'two';

while ($row = mysqli_fetch_assoc($result)) {
//echo $count;
    if ($count <= $table1_count) {
        $s= $count;
        $table1 .= '<tr><td>' . $s . '</td>' . '<td>' . $row['stock'] . '</td>' . '<td>' . $row['customer'] . '</td>' . '<td>' . $row['quantity'] . '</td></tr>';

    }
    if ($count > $table1_count && $count <= ($table1_count + $table2_count)) {
        $s = $count;
        $table2 .= '<tr><td>' . $s . '</td>' . '<td>' . $row['stock'] . '</td>' . '<td>' . $row['customer'] . '</td>' . '<td>' . $row['quantity'] . '</td></tr>';

    }
        // ...
     if ($count > $table1_count+ $table2_count && $count <= ($table1_count + $table2_count + $table3_count)) {
         $s = $count;
         $table3 .= '<tr><td>' . $s . '</td>' . '<td>' . $row['stock'] . '</td>' . '<td>' . $row['customer'] . '</td>' . '<td>' . $row['quantity'] . '</td></tr>';

     }
     $count++;
    //$s++;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Allocation List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="row">
    <div class="col-sm-4">
        <div id="items_table1" class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <table class="table table-hover table-bordered">
                <thead style="background-color: lightgrey">
                <tr>
                    <th>S/N</th>
                    <th>Stock</th>
                    <th>Customer</th>
                    <th>Allocation</th>
                </tr>
                </thead>
                <tbody>
        <?php echo $table1; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-sm-4">
        <div id="items_table2" class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <table class="table table-bordered table-hover">
                <thead style="background-color: lightgrey">
                <tr>
                    <th>S/N</th>
                    <th>Stock</th>
                    <th>Customer</th>
                    <th>Allocation</th>
                </tr>
                </thead>
                <tbody>
                <?php echo $table2; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-sm-4">
        <div id="items_table3" class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <table class="table table-bordered table-hover ">
                <thead style="background-color: lightgrey">
                <tr>
                    <th>S/N</th>
                    <th>Stock</th>
                    <th>Customer</th>
                    <th>Allocation</th>
                </tr>
                </thead>
                <tbody>
                <?php echo $table3; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <script src="js/libs/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    </body>
</html>
