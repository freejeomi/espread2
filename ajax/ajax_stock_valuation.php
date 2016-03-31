<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");
$_SESSION['last_screen'] = "ajax_stock_valuation.php";
include "../lib/util.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$store_id=array();
$store_name=array();
$total_table="";
$thead="";
$counter_store=0;
$counter_stock=0;
$tbody="";
$stock_number=0;
$stock_code=array();
$stock_name=array();
$stock_id=array();
$trow_stock="";
$serial=1;
$sum_count=0;
$total_value=array();
$totalval_stock=0;
$tfoot="";
$store_number=0;

$stock_count_array=array();
//QUERY FOR STORE
$sql_store="SELECT store_id,store_name FROM store";
$result_store=mysqli_query($conn,$sql_store);

//QUERY WAS EXECUTED
if($result_store){

//THERE ARE STORES
    if(mysqli_num_rows($result_store) > 0)
    {
    $store_number=mysqli_num_rows($result_store);
        $thead="<thead ><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th>";
        while($row_store=mysqli_fetch_assoc($result_store)){
            $thead.="<th>".$row_store['store_name']."</th>";
            $store_id[$counter_store]=$row_store['store_id'];
            $counter_store++;

//END OF WHILE LOOP
        }
        $thead.="<th>Total Quantity</th><th>Price</th><th>Total Value</th></tr></thead>";

    }


}
//Get the Stock ID and Name And Stock Code
$sql_stock="SELECT stock_id,stock_code,stock_name,costprice FROM stock";
$result_stock=mysqli_query($conn,$sql_stock);

//IF THE QUERY RAN
if($result_stock){
// CHECK IF THERE IS A STOCK AT ALL
    if(mysqli_num_rows($result_stock)>0){

// IF THERE IS START TBODY
        $tbody="<tbody>";
        $tfoot="<tfoot>";

// GET THE NUMBER OF THE STOCK I.E THE COUNT
        $stock_number=mysqli_num_rows($result_stock);

// FETCH EACH RESULT
        while($row_stock=mysqli_fetch_assoc($result_stock)){
// GET THE STOCK ID
            $stock_id[$counter_stock]=$row_stock['stock_id'];

            // MAKE THE TBODY HAVE A SERIAL NUMBER
            $tbody.="<tr><td>".$serial."</td><td>".$row_stock['stock_name']."</td><td>".$row_stock['stock_code']."</td>";
            // LOOP THRU THE STORES AND GET THE COUNT FOR EACH STOCK
            $i=0;
            foreach($store_id as $store){

//GET THE STOCK COUNT
                $sql_position="SELECT FORMAT(stock_count,0) as stock_count,stock_count as stock_count2 FROM stockposition WHERE stock_id='$stock_id[$counter_stock]' AND store_id='$store'";
                $result_position=mysqli_query($conn,$sql_position);

                // IF THE QUERY RAN....
                if($result_position){
                    // CHECK IF THERE IS A ROW
                    if(mysqli_num_rows($result_position)>0){
                        // GET THE STOCK COUNT AND RUN THROUGH IT AGAIN
                        while($row_position=mysqli_fetch_assoc($result_position)){
                            $tbody.="<td>".$row_position['stock_count']."</td>";
                            $stock_count_array[$i]=$row_position['stock_count2'];
                        }
                    }

                    // IF THERE IS NO ROW, GIVE THE COUNT AS A ZERO
                    else{
                        $tbody.="<td>0</td>";
                        $stock_count_array[$i]=0;
                    }



                }
                $i++;
            }

            $sum_count=array_sum($stock_count_array);
            $totalval_stock=$sum_count * $row_stock['costprice'];
            $tbody.="<td>".number_format(array_sum($stock_count_array))."</td><td>".number_format($row_stock['costprice'],2)."</td><td>".number_format($totalval_stock,2)."</td></tr>";
            $serial++;

        $total_value[$counter_stock]=$totalval_stock;
            $counter_stock++;
        }
        $tfoot.="<tr class='text-center success' style='font-size: 1.5em; font-weight: bold;'><td colspan='".($store_number+4)."'>Sum</td><td colspan='2'>".number_format(array_sum($total_value),2)."</td></tr></tfoot>";
        $tbody.="</tbody>";

    }

}



?>
<!-- row -->


<div class="row"  xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <h1 style="display: inline;">Stock Valuation</h1>
        <span class="pull-right" style="margin-right: 2em;"><a href="stock_valuation.php" target="_blank">view printable version</a></span>
    </div>
</div>

<div class="row "  xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-hover table-bordered ">
            <?php echo $thead; //print_r($store_id);?>
            <?php echo $tbody;?>
            <?php echo $tfoot;?>
        </table>


    </div>
</div>

<script type="text/javascript">

    /* DO NOT REMOVE : GLOBAL FUNCTIONS!
     *
     * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
     *
     * // activate tooltips
     * $("[rel=tooltip]").tooltip();
     *
     * // activate popovers
     * $("[rel=popover]").popover();
     *
     * // activate popovers with hover states
     * $("[rel=popover-hover]").popover({ trigger: "hover" });
     *
     * // activate inline charts
     * runAllCharts();
     *
     * // setup widgets
     * setup_widgets_desktop();
     *
     * // run form elements
     * runAllForms();
     *
     ********************************
     *
     * pageSetUp() is needed whenever you load a page.
     * It initializes and checks for all basic elements of the page
     * and makes rendering easier.
     *
     */

    pageSetUp();



    var pagefunction = function() {}
    //console.log("cleared");

    /* // DOM Position key index //

     l - Length changing (dropdown)
     f - Filtering input (search)
     t - The Table! (datatable)
     i - Information (records)
     p - Pagination (paging)
     r - pRocessing
     < and > - div elements
     <"#id" and > - div with an id
     <"class" and > - div with a class
     <"#id.class" and > - div with an id and class

     Also see: http://legacy.datatables.net/usage/features
     */

    /* BASIC ;*/





    // load related plugins

    loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
        loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
            loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
                loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
                    loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
                });
            });
        });
    });
</script>

<script type="text/javascript">

</script>