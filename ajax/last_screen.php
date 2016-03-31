<?php
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 23/03/2016
 * Time: 17:13
 */
session_start();
if(isset($_SESSION['last_screen']) &&  !empty($_SESSION['last_screen'])){
    echo $_SESSION['last_screen'];
}else{
    if ($_SESSION['role_name'] == 'operator') {
        $_SESSION['last_screen'] = 'new_invoice.php';
        echo $_SESSION['last_screen'];
    }
    elseif ($_SESSION['role_name'] == 'manager'){
        $_SESSION['last_screen'] = 'dashboard.php';
        echo $_SESSION['last_screen'];
    }elseif($_SESSION['role_name'] == 'invoice_tracker'){
        $_SESSION['last_screen'] = 'invoice_tracker.php';
        echo $_SESSION['last_screen'];
    }elseif($_SESSION['role_name'] == 'store_confirmer'){
        $_SESSION['last_screen'] = 'invoice_store_confirm.php';
        echo $_SESSION['last_screen'];
    }elseif($_SESSION['role_name'] == 'admin'){
        $_SESSION['last_screen'] = 'dashboard.php';
        echo $_SESSION['last_screen'];
    }else{
        $_SESSION['last_screen'] = 'logout.php';
        echo $_SESSION['last_screen'];
    }

}

?>