<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");
$_SESSION['last_screen'] = "transfer_sales_ledger.php";

include "../lib/util.php";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$min_date= "";
$max_date= "";
$message= "";
if (!$conn) {
    $data['success'] = false;
    die("Connection failed: " . mysqli_connect_error());
}
$result_check= mysqli_query($conn, "select * from salesinvoice_daily");
if (mysqli_num_rows($result_check) > 0) {
    $result = mysqli_query($conn, "SELECT MIN(sales_date) as min_date, MAX(sales_date) as max_date FROM salesinvoice_daily");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $min_date = $row['min_date'];
            $max_date = $row['max_date'];
        }
        $script_date = date("d/m/Y", strtotime($min_date));
        // echo $script_date;
    }
    ?><script>//$('#transfer').prop("disabled", true);</script><?php
}
else {
    $message= "<b class='alert alert-default' style='border: 1px solid whitesmoke;'>there are no records in the sales ledger at the moment</b>";
    ?>
    <script>
        $('#transfer').prop("disabled", true);
        $('#startdate').prop("disabled", true);
    </script>

    <?php
}

 ?>
<!-- row -->

<!-- end row -->

<!--
	The ID "widget-grid" will start to initialize all widgets below
	You do not need to use widgets if you dont want to. Simply remove
	the <section></section> and you can use wells or panels instead
	-->

<!-- widget grid -->
<section id="widget-grid" class="col-sm-6 col-sm-offset-6 col-md-6 col-md-offset-3 text-center">

</section>
<!-- end widget grid -->
<div class="row ">
    <section class="col-md-6 col-md-offset-3 text-center">
        <h2><b>Welcome to Sales Repository Manager</b></h2>
        <div class=" well" id="errorappend">

            <p class="" style="font-size: 15px;">
                You can choose to transfer all sales transaction to sales archive.
            </p>

            <div id="empty">
            <?php if ($message != "") { echo $message; } else {?>
            Select a date range between
                <b id="min_date"><?php echo date("l, F d, Y", strtotime($min_date));?></b> and
                <b id="max_date"> <?php echo date("l, F d, Y", strtotime($max_date)); ?></b>
            <?php }?>
            </div><br>

            <div id="date-group">
                <div class="input-group col-sm-6 col-sm-offset-3">
                    <input type="text" name="startdate" placeholder="Select a date" class="form-control datepicker" data-dateformat="yy/mm/dd" id="startdate">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div><br>
            <div>
                <p class="" style="font-size: 15px;">
                    Click the button below to transfer now
                </p>
            </div>
            <div id="image">

                <img src="arrow.png" alt="arrow down" height="35" width="30" >
            </div><br>

            <div>
                <button class="btn btn-primary btn-lg" style="margin-bottom: 20px;" type="button" id="transfer">Transfer Now</button>
                <div class="alert alert-warning" id="append-error">
                    <strong>Warning! &nbsp &nbsp &nbsp &nbsp</strong>All sales from today up to the selected date will
                    be
                    archived.
                </div>
            </div>


        </div>

    </section>
</div>
<div class="row">
    <section class="col-md-4 col-md-offset-4 text-center">

    </section>
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
    $('document').ready(function () {
        $('#transfer').prop("disabled", true);
//            var min_date= <?php //echo "$script_date" ?>//;
//            alert (min_date);
//            $('#startdate').datepicker("setDate", min_date);
    });

    var pagefunction = function () {
        // clears the variable if left blank



        $("#startdate").bind("click keyup", function () {
            $('#transfer').prop("disabled", false);
        });
        $('#transfer').click(function (event) {
            $('#date-group').removeClass();
            $('#error_input_div').remove();
            $('#error_mesage_div').remove();
//            $('.help-block').remove();
//            $('.alert').remove();
//            $('.alert-danger').remove();
//            $('.alert-success').remove();
            event.preventDefault();
            //alert($('#invoice_num_hidden').val());
            var formData = {
                'move_date': $('#startdate').val()
            };
            $.ajax({
                type: 'POST',
                url: 'ajax/invoice/transfer_sales_ledger_post.php',
                data: formData,
                dataType: 'json',
                encode: true
            })
                .done(function (data) {
                    if (!data.success) {
                        if (data.error) {
                            $('#date-group').addClass('has-error');
                            $('#date-group').append('<div class="help-block" id="error_input_div">' + data.error + '</div>');
                        }
                        else {
                            $('#widget-grid').empty().append('<div class="alert alert-danger help-block" id="error_mesage_div">' + data.message + '</div>');
                        }

                    }
                    else {
                        $('#widget-grid').append('<div class="alert alert-success help-block">' + data.message + '</div>');
                        $('#startdate').val('');
                        $('#transfer').prop('disabled', true);
                        $('#min_date').empty().text(data.min_date);
                        $('#max_date').empty().text(data.max_date);
                        if (data.display) {
                            $('#empty').empty().html(data.display);
                        }
                    }
                })
        });
     };

    // end pagefunction

    // run pagefunction
    pagefunction();

</script>
