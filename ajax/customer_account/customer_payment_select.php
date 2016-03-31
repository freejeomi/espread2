<?php
    include "../../lib/util.php";

//ini_set("display_errors","1");
//$servername = "localhost";
//$username = "root";
//$password = "Heaven192";
//$dbname = "espread";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if (isset($_GET['cus_Id'])) {
        $id = trim($_GET['cus_Id']);
        $result = array();
        $id = mysqli_real_escape_string($id);
        
        $res = mysqli_query($conn, "SELECT * FROM subcategories WHERE category_id = $id");
        
        while ($row = mysql_fetch_array($res)) {
    
        $result[] = array(
          'id' => $row['subcatid'],
          'name' => $row['description']
        );
    
        }
        echo json_encode($result);
    }
?>