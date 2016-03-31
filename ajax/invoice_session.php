<?php
require_once("inc/init.php");
//$_SESSION['invoice_num_retrieved']= "";
if (isset($_POST['invoice_num'])) {
    $_SESSION['invoice_num_retrieved']= $_POST['invoice_num'];
     $_SESSION['print_invoice'] = $_POST['invoice_num'];
    //echo $_SESSION['invoice_num_retrieved'];
 }
 elseif(isset($_POST['ledger_invoice_number']) && isset($_POST['task'])){
     $_SESSION['invoice_num_retrieved'] = $_POST['ledger_invoice_number'];
     $_SESSION['task']="print";
     //$_SESSION['print_invoice'] = $_POST['invoice_num'];
 }
