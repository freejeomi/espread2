<?php
 define('HOST','localhost');
 define('USERNAME', 'root');
 define('PASSWORD','');
 define('DB','espread');
 
 $con = mysqli_connect(HOST,USERNAME,PASSWORD,DB);
 
 
 $sql = "select role_name from roles";
 
 $res = mysqli_query($con,$sql);
 
 $result = "";
 
 while($row = mysqli_fetch_array($res)){
 $result = $result . $row['role_name'] . ':' . $row['role_name'] .  '#';  //{values: manager:manager; OP: operator}
 }
 $result = substr($result, 0, strlen($result) -1);
 
 echo $result;
 
 mysqli_close($con);
?>