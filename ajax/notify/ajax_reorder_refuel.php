<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");

?>
<!-- row -->
<?php

include "../lib/util.php";
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 14/01/2016
 * Time: 4:02 PM
 */
//ini_set("display_errors","1");
//$servername = "localhost";
//$username = "root";
//$password = "Heaven192";
//$dbname = "espread";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$query1 = "SELECT store_id, store_name FROM store WHERE useinreorder=1";
$result1 = mysqli_query($conn,$query1);
$response ='';
if(mysqli_num_rows($result1)>0){
    while($row = mysqli_fetch_array($result1)) {
        $response .= '<option value="'.$row[0].'">'.$row[1].'</option>';
    }
}
else{
    $show="<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong> No store to use in reorder</div>";
}




?>


<div class="row"  xmlns="http://www.w3.org/1999/html">

    <!-- col -->
    <!--    For the Stock Task-->



            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-recycle"></i>
                            Stock Refuel </h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" id="closing_button"><i class="fa fa-minus"></i></button>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" id="purge">
                        <form action="reorder_refuel.php" target="_blank" method="post"  class="form-horizontal">


                                <!--    for store selection-->
                                <section class="col-md-3 col-md-offset-1">
                                    Select Store:&nbsp; <label class="input" style="padding-top: 0.5em; height: 3em; margin-left: 2em;">
                                        <select name="select_store" id="select_store"><?php echo $response;?></select>
                                    </label>
                                </section>
                                <section class="col-md-3 ">
                                    Select Buffer:&nbsp; <label class="input" style="padding-top: 0.5em; height: 3em; margin-left: 2em;">
                                        <select name="select_buffer" id="select_buffer"><?php echo $response;?></select>
                                    </label>
                                    <input type="hidden" value="" name="store_select" id="store_select">
                                    <input type="hidden" value="" name="store_buffer" id="store_buffer">


                                </section>
                                <!--                                for selecting date-->

                                <section class="col-md-4 ">
                                    <button type="submit" class="btn btn-lg btn-success" id="display_data" disabled>Display</button>
                                    <span id="show_loader" style="margin-left: 3em"></span>

                                </section>

                            <!--Show Messages-->


                            <!--                            form ends here-->
                        </form>

                        <?php if(isset($show)){
                            echo "<section class='row'><div class='col-md-12 col-sm-12'>".$show."</div></section>";
                        }?>
                    </div><!-- /.box-body -->
                </div>
            </div>


    <!-- /.box -->

    <!-- end col end stock task-->

    <!-- right side of the page for the tables -->
    <!-- col -->


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

    /*
     * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
     * eg alert("my home function");
     *
     * var pagefunction = function() {
     *   ...
     * }
     * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
     *
     * TO LOAD A SCRIPT:
     * var pagefunction = function (){
     *  loadScript(".../plugin.js", run_after_loaded);
     * }
     *
     * OR you can load chain scripts by doing
     *
     * loadScript(".../plugin.js", function(){
     * 	 loadScript("../plugin.js", function(){
     * 	   ...
     *   })
     * });
     */

    // pagefunction
</script>
<script type="text/javascript">
  $('document').ready(function () {

      if($('#select_store').val() == $('#select_buffer').val()){
          $("#display_data").prop('disabled', true);
      }
      else{
          $("#display_data").prop('disabled', false);
          $('#store_buffer').val($("#select_buffer option:selected").text());
          $('#store_select').val($("#select_store option:selected").text());
      }
    $('#select_store, #select_buffer').change(function () {
        if($('#select_store').val() == $('#select_buffer').val()){
            $("#display_data").prop('disabled', true);
        }
        else{
            $("#display_data").prop('disabled', false);
            $('#store_buffer').val($("#select_buffer option:selected").text());
            $('#store_select').val($("#select_store option:selected").text());
        }
    });
  });
</script>