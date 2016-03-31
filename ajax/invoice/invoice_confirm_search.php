<?php
$data 			= array();
include "../../lib/util.php";
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        $data['message']="Oops. something went wrong while connecting to database. please try again";
        $data['success']=false;
    }
    //Get post params
//$cashier_select='';
$invoice_num_obtained='';
$invoice_num_hidden='';
//to assign cashier
if(isset($_POST['invoice_num_obtained'])){
    //$cashier_select=$_POST['cashier_selected'];
    $supply= "SUPPLIED";
    $invoice_num_obtained=$_POST['invoice_num_obtained'];

    $result= mysqli_query($conn, "SELECT invoice_num from salesinvoice_daily where invoice_num= '$invoice_num_obtained'");
    if(mysqli_num_rows($result)> 0) {
        mysqli_query($conn, "UPDATE salesinvoice_daily SET store_confirmation='$supply' where invoice_num='$invoice_num_obtained'");
        $data['message'] = "Invoice Num <b>" . $invoice_num_obtained . " </b>has been marked as <b>" . $supply . "</b>.";
        $data['success'] = true;
    }
    else {
        mysqli_query($conn, "UPDATE salesinvoice SET store_confirmation='$supply' where invoice_num='$invoice_num_obtained'");
        $data['message'] = "Invoice Num <b>" . $invoice_num_obtained . " </b>has been marked as <b>" . $supply . "</b>.";
        $data['success'] = true;
    }
}
//to unassign cashier
elseif(isset($_POST['invoice_num_hidden'])){
    $invoice_num_hidden=$_POST['invoice_num_hidden'];

    $result = mysqli_query($conn, "SELECT invoice_num from salesinvoice_daily where invoice_num= '$invoice_num_obtained'");
    if (mysqli_num_rows($result) > 0) {
        mysqli_query($conn, "UPDATE salesinvoice_daily SET store_confirmation='NOT SUPPLIED' where invoice_num='$invoice_num_obtained'");
        $data['message'] = "Invoice Num <b>" . $invoice_num_obtained . " </b>has been marked as <b>" . $supply . "</b>.";
        $data['success'] = true;
    } else {
        mysqli_query($conn, "UPDATE salesinvoice SET store_confirmation='NOT SUPPLIED' where invoice_num='$invoice_num_hidden'");
        $data['message'] = "Invoice Num <b>" . $invoice_num_hidden . " </b> has been reset to <b>NOT SUPPLIED</b>.";
        $data['success'] = true;
    }
}
//to display table
else {
    $invoice_num = $_POST['invoice_num'];
    $invoice_customer = '';
    $invoice_supply = '';
    $item_id = array();
    $item_quantity = array();
    $item_charge = array();
    $item_stockname = array();
    $items_row = '';
    $i = 0;
    $promo_table='';
    $s=1;
    $p=1;


    $items_table = '<div id="items_table" class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12"><table class="table table-striped table-hover"><thead><tr><th>S/N</th><th>Item</th><th>Quantity</th><th>Charge</th></tr></thead><tbody>';
    $items_total = '';


    // check if the invoice num is empty
    if (empty($invoice_num)) {
        $data['invoice'] = "Please enter the invoice number";
        $data['success'] = false;
    } //there is an invoice number/// check database oooo
    else {
        $sql_salesinvoice = "SELECT invoice_num,customer_name,store_confirmation FROM salesinvoice_daily INNER JOIN customer ON customer.customer_id = salesinvoice_daily.customer_id WHERE invoice_num='$invoice_num'";
        $result_invoice = mysqli_query($conn, $sql_salesinvoice);

        //check if the invoice exists
        if (mysqli_num_rows($result_invoice) == 0) {
//if it does not exist in the sales invoice daily table, check the sales invoice table
            $sql_salesinvoice = "SELECT invoice_num,customer_name,store_confirmation FROM salesinvoice INNER JOIN customer ON customer.customer_id = salesinvoice.customer_id WHERE invoice_num= '$invoice_num'";
            $result_invoice = mysqli_query($conn, $sql_salesinvoice);
            if (mysqli_num_rows($result_invoice) == 0) {
                $data['invoice'] = "Invoice Number does not exist";
                $data['success'] = false;
            }
            else {
                while ($row_invoice = mysqli_fetch_assoc($result_invoice)) {
                    $invoice_customer = $row_invoice['customer_name'];
                    $invoice_supply = $row_invoice['store_confirmation'];
                }
                if ($invoice_supply == "SUPPLIED") {
                    $data['message'] = "marked as supplied";
                    $data['success'] = false;
                } //no cashier...keep on
                else {
                    $sql_invoiceitem = "SELECT item_id,quantity,charge,stock.stock_name FROM invoiceitems_daily INNER JOIN stock ON stock.stock_id = invoiceitems_daily.stock_id WHERE invoice_num='$invoice_num'";
                    $result_invoiceitem = mysqli_query($conn, $sql_invoiceitem);
                    if (mysqli_num_rows($result_invoiceitem) > 0) {
                        //put them in a table
                        while ($row_invoiceitem = mysqli_fetch_assoc($result_invoiceitem)) {
                            $items_row .= '<tr><td>' . $s . '</td><td>' . $row_invoiceitem['stock_name'] . '</td><td>' . number_format($row_invoiceitem['quantity']) . '</td><td>' . number_format($row_invoiceitem['charge'],2) . '</td></tr>';
                            $s++;

                            $item_id[$i] = $row_invoiceitem['item_id'];

                            $sql_promo = mysqli_query($conn, "SELECT stock.stock_name,quantity FROM promoaccount INNER JOIN stock ON stock.stock_code=promoaccount.stock_code WHERE item_id='$item_id[$i]'");
                            if (mysqli_num_rows($sql_promo) > 0) {
                                while ($row_promo = mysqli_fetch_assoc($sql_promo)) {
                                    $promo_table .= '<tr><td>' . $p . '</td><td>' . $row_promo['stock_name'] . '</td><td>' . number_format($row_promo['quantity']) . '</td><td>0.00</td></tr>';
                                    $p++;
                                }
                            }
                            //invoice exists so search the items daily table

                            $item_quantity[$i] = $row_invoiceitem['quantity'];
                            $item_charge[$i] = $row_invoiceitem['charge'];
                            $item_stockname[$i] = $row_invoiceitem['stock_name'];
                            $i++;

                        }
                        $promoheader = '<tr style = "background-color: #474544;color: white" ><td colspan = "4" class="text-center" ><b > Promo Items </b ></td ></tr >';
                        $sql_invoicesum = "SELECT sum(charge) as total_amount FROM invoiceitems_daily WHERE invoice_num='$invoice_num'";
                        $result_invoicesum = mysqli_query($conn, $sql_invoicesum);
                        //put them in a table
                        while ($row_invoicesum = mysqli_fetch_assoc($result_invoicesum)) {
                            $items_row .= $promoheader . $promo_table . '<tr class="bg-success"><td colspan="3" class="text-center"><b>TOTAL</b></td><td><b>' . number_format($row_invoicesum['total_amount'],2) . '</b></td></tr>';
                        }
                        $items_table .= $items_row . '</tbody></table></div>';
                        //display total in a table
//                    $items_total .= '<div style="padding-bottom:3em"><span class="col-md-4 col-lg-4 col-xs-12 col-sm-12"><b>Invoice Number:&nbsp;<span id="invoice_num_obtained">' . $invoice_num . '</span></b></span><span class="col-md-4 col-lg-4 col-xs-12 col-sm-12 pull-right"><b>Customer Name:&nbsp;' . $invoice_customer . '</b></span></div>' . $items_table;
//                    $data['message'] = $items_total;
                        $cust = '<span class="col-md-12 col-lg-12 col-xs-12 col-sm-12">Customer Name:&nbsp;' . '<b>' . $invoice_customer . '</b></span>';

                        $invnum = '<span class="col-md-12 col-lg-12 col-xs-12 col-sm-12">Invoice Number:&nbsp;<span id="invoice_num_obtained"><b>' . $invoice_num . '</b></span></span>';

                        $data['invnum'] = $invnum;
                        $data['cust'] = $cust;
                        $data['message'] = $items_table;
                        $data['success'] = true;
                    } else {

                        $data['success'] = false;
                        $data['empty'] = "This invoice number has no invoice items";
                    }
                }
            }


        } //invoice exists so search the items daily table
        else {
            while ($row_invoice = mysqli_fetch_assoc($result_invoice)) {
                $invoice_customer = $row_invoice['customer_name'];
                $invoice_supply = $row_invoice['store_confirmation'];
            }
                //if there is cashier, alert that there is cahsier
                if ($invoice_supply == "SUPPLIED") {
                    $data['message'] = "marked as supplied";
                    $data['success'] = false;
                } //no cashier...keep on
                else {
                    $sql_invoiceitem = "SELECT item_id,quantity,charge,stock.stock_name FROM invoiceitems_daily INNER JOIN stock ON stock.stock_id = invoiceitems_daily.stock_id WHERE invoice_num='$invoice_num'";
                    $result_invoiceitem = mysqli_query($conn, $sql_invoiceitem);
                    if(mysqli_num_rows($result_invoiceitem)> 0) {
                        //put them in a table
                        while ($row_invoiceitem = mysqli_fetch_assoc($result_invoiceitem)) {
                            $items_row .= '<tr><td>'.$s.'</td><td>' . $row_invoiceitem['stock_name'] . '</td><td>' . number_format($row_invoiceitem['quantity']) . '</td><td>' . number_format($row_invoiceitem['charge'],2) . '</td></tr>';
                            $s++;

                            $item_id[$i] = $row_invoiceitem['item_id'];

                            $sql_promo = mysqli_query($conn, "SELECT stock.stock_name,quantity FROM promoaccount INNER JOIN stock ON stock.stock_code=promoaccount.stock_code WHERE item_id='$item_id[$i]'");
                            if (mysqli_num_rows($sql_promo) > 0) {
                                while ($row_promo = mysqli_fetch_assoc($sql_promo)) {
                                    $promo_table .= '<tr><td>'.$p.'</td><td>' . $row_promo['stock_name'] . '</td><td>' .  number_format($row_promo['quantity']) . '</td><td>0.00</td></tr>';
                                    $p++;
                                }
                            }
                            //invoice exists so search the items daily table

                            $item_quantity[$i] = $row_invoiceitem['quantity'];
                            $item_charge[$i] = $row_invoiceitem['charge'];
                            $item_stockname[$i] = $row_invoiceitem['stock_name'];
                            $i++;

                        }
                        $promoheader = '<tr style = "background-color: #474544;color: white" ><td colspan = "4" class="text-center" ><b > Promo Items </b ></td ></tr >';
                        $sql_invoicesum = "SELECT sum(charge) as total_amount FROM invoiceitems_daily WHERE invoice_num='$invoice_num'";
                        $result_invoicesum = mysqli_query($conn, $sql_invoicesum);
                        //put them in a table
                        while ($row_invoicesum = mysqli_fetch_assoc($result_invoicesum)) {
                            $items_row .= $promoheader . $promo_table . '<tr class="bg-success"><td colspan="3" class="text-center"><b>TOTAL</b></td><td><b>' . number_format( $row_invoicesum['total_amount'],2) . '</b></td></tr>';
                        }
                        $items_table .= $items_row . '</tbody></table></div>';
                        //display total in a table
//                    $items_total .= '<div style="padding-bottom:3em"><span class="col-md-4 col-lg-4 col-xs-12 col-sm-12"><b>Invoice Number:&nbsp;<span id="invoice_num_obtained">' . $invoice_num . '</span></b></span><span class="col-md-4 col-lg-4 col-xs-12 col-sm-12 pull-right"><b>Customer Name:&nbsp;' . $invoice_customer . '</b></span></div>' . $items_table;
//                    $data['message'] = $items_total;
                        $cust = '<span class="col-md-12 col-lg-12 col-xs-12 col-sm-12">Customer Name:&nbsp;' . '<b>' . $invoice_customer . '</b></span>';

                        $invnum = '<span class="col-md-12 col-lg-12 col-xs-12 col-sm-12">Invoice Number:&nbsp;<span id="invoice_num_obtained"><b>' . $invoice_num . '</b></span></span>';

                        $data['invnum'] = $invnum;
                        $data['cust'] = $cust;
                        $data['message'] = $items_table;
                        $data['success'] = true;
                    }
                    else {

                        $data['success'] = false;
                        $data['empty']= "This invoice number has no invoice items";
                    }
                }

        }
    }
}
echo json_encode($data);
?>