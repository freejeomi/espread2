<?php
require_once("inc/init.php");
require_once("userlogcheck_admin.php");
$_SESSION['last_screen'] = "sales_summary.php";
?>

<?php
//script to retrieve store drop down select
include "../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$result = mysqli_query($conn, "SELECT store_id, store_name FROM store") or die("Couldn't execute query." . mysqli_error($conn));
$dataliststore = "";
while ($data = mysqli_fetch_assoc($result)) {
    $defaultstore = "<option value='none'>--please select store--</option>";
    $dataliststore = $dataliststore . "<option value='{$data['store_id']}'>{$data['store_name']}</option>";
}
?>
<!--widget grid-->
<section id="widget-grid" class="">
    <!--row -->
    <div class="row" id="newinvoice-slide">

        <!--NEW WIDGET START-->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <!--Widget ID(each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-deletebutton="false"
                 data-widget-editbutton="false">
                <header>
                    <span class="widget-icon"> <i class=""></i> </span>

                    <h2> Sales Summary</h2>
                </header>

                <!--widget div-->
                <div>
                    <!--widget edit box-->
                    <div class="jarviswidget-editbox">
                        <!--This area used as dropdown edit box-->
                        <input class="form-control" type="text">
                    </div>
                    <!--end widget edit box-->

                    <!--widget content-->
                    <div class="widget-body">
                        <form id="sales_summary" method="POST">
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label class="control-label col-md-3" for="prepend"> Store</label>

                                    <div class="col-md-9">
                                        <div class="icon-addon addon-sm" id="store-group">
                                            <select class="form-control" name="store-select" id="store-select">
                                                <?php echo $defaultstore; ?>
                                                <option value="all">All stores</option>
                                                <?php echo $dataliststore; ?>
                                            </select>
                                            <label class="glyphicon glyphicon-search" title="" rel="tooltip" for="email" data-original-title="email"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-9">
                                    <label class="control-label col-md-1" for="prepend">Period between</label>
                                    <div class="col-md-3" id="startdate-group">
                                        <div class="input-group">
                                            <input type="text" name="mydate1" id="startdate" placeholder="start date" class="form-control datepicker" data-dateformat="yy/mm/dd">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <label class="control-label col-md-1" for="prepend">AND</label>
                                    <div class="col-md-3" id="finishdate-group">
                                        <div class="input-group">
                                            <input type="text" name="mydate2" id="finishdate"
                                                   placeholder="end date" class="form-control datepicker"
                                                   data-dateformat="yy/mm/dd">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <label class="control-label col-md-1" for="prepend"></label>
                                    <button class="btn btn-primary col-md-1" type="submit" id="sales_summary">
                                        <i class="fa fa-save"></i>
                                        Display
                                    </button>
                                    <label class="control-label col-md-1" for="prepend"></label>
                                    <button class="btn btn-danger col-md-1" id="cancelbutton" onclick=""
                                            type="button">
                                        <i class="fa fa times"></i>
                                        Clear
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7">
                                    <p class="alert alert-warning" style="text-align: center;"><b>Warning!</b>&nbsp
                                        &nbsp This report will be based on your ledger selection. Please select ledger of choice before proceeding<span class="fa fa-arrow" style="color: green;"></span></p>
                                </div>
                                <div class="form-group col-sm-5" id="radio-group">
                                    <label class="radio-inline">
                                        <input type="radio" name="optradio" value="temp" id="main_radio" checked> Sales Ledger
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optradio" value="main"> Sales Ledger Archive
                                    </label>

                                </div>

                            </div>
                        </form>
                        <div class="row">
                            <div class="col-sm-1"></div>

                            <div class="col-sm-2"></div>
                        </div>
                        <div id="success_message" class="row">

                        </div>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->
        </article>
        <!-- WIDGET END -->
    </div>
</section>

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
     * OR
     *
     * loadScript(".../plugin.js", run_after_loaded);
     */

    // pagefunction

    var pagefunction = function () {
//var store_id;
//var stock_id;

        // START AND FINISH DATE
        $('#startdate').datepicker({
            dateFormat: 'dd.mm.yy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onSelect: function (selectedDate) {
                $('#finishdate').datepicker('option', 'minDate', selectedDate);
            }
        });
        $('#finishdate').datepicker({
            dateFormat: 'dd.mm.yy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onSelect: function (selectedDate) {
                $('#startdate').datepicker('option', 'maxDate', selectedDate);
            }
        });
    };

    

    
    $(document).ready(function () {
        $('#sales_summary').submit(function (event) {

            $('#store-group').removeClass('has-error');
            $('#startdate-group').removeClass('has-error');
            $('#finishdate-group').removeClass('has-error');
            $('.help-block').remove();
            var table_check = "";
            if (document.getElementById("main_radio").checked) {
                table_check = "temp";
            }
            else {
                table_check = "main";
            }
            var formData = {
                'store_id': $('#store-select').val(),
                'start_date': $('#startdate').val(),
                'end_date': $('#finishdate').val(),
            };

            $.ajax({
                type: 'POST',
                url: 'ajax/invoice/sales_summary_post.php',
                data: formData,
                dataType: 'json',
                encode: true
            }).done(function (data) {
               
                if (!data.success) {
                    if (data.errors.store) {
                        $('#store-group').addClass('has-error'); // add the error class to show red input
                        $('#store-group').append('<div class="help-block">' + data.errors.store + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.startdate) {
                        $('#startdate-group').addClass('has-error'); // add the error class to show red input
                        $('#startdate-group').append('<div class="help-block">' + data.errors.startdate + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.finishdate) {
                        $('#finishdate-group').addClass('has-error'); // add the error class to show red input
                        $('#finishdate-group').append('<div class="help-block">' + data.errors.finishdate + '</div>'); // add the actual error message under our input
                    }
                }
                else {
                    
        window.open('sales_summary_list.php?store_id=' + formData.store_id + '&start_date=' + formData.start_date + '&end_date=' + formData.end_date + '&tab=' + table_check );
                    $('#store-select').val('none').trigger('change');
                    
                    $('#startdate').val('');
                    $('#finishdate').val('');
                  
                }
            });
            event.preventDefault();
        });
    });

    $('#cancelbutton').on("click", function () {
        $('#startdate').val('');
        $('#finishdate').val('');
    });
    
    
</script>