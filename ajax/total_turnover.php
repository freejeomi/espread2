<?php
require_once("inc/init.php");
require_once("userlogcheck_admin.php");
$_SESSION['last_screen'] = "total_turnover.php";
?>

<?php
//script to retrieve store drop down select
$dataliststore = "";
include "../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$result = mysqli_query($conn, "SELECT store_id, store_name  FROM store") or die("Couldn't execute query." . mysqli_error($conn));

while ($data = mysqli_fetch_assoc($result)) {
    $defaultstore = "<option value='none'>--please select store--</option>";
    $dataliststore = $dataliststore . "<option value='{$data['store_id']}'>{$data['store_name']}</option>";
    //echo $dataliststore;
}
?>

<?php
//script to retrieve customer drop down select
$datalistcustomer= "";
include "../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$result = mysqli_query($conn, "SELECT customer_id, customer_name FROM customer") or die("Couldn't execute query." . mysqli_error($conn));
$datalistcustomer = "";
while ($data = mysqli_fetch_assoc($result)) {
    $defaultcustomer = "<option value='none'>--please select customer--</option>";
    $datalistcustomer = $datalistcustomer . "<option value='{$data['customer_id']}'> {$data['customer_name']}</option>";
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

                    <h2> Total Turnover</h2>
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
                        <form id="sales_allocation" method="POST">
                            <div class="row">

                                <div class="form-group col-sm-4">
                                    <label class="control-label col-md-3" for="customer-select"> Customer</label>

                                    <div class="col-md-9">
                                        <div class="icon-addon addon-sm" id="customer-group">
                                            <select class="form-control" name="customer-select" id="customer-select">
                                                <?php echo $defaultcustomer; ?>
                                                <?php echo $datalistcustomer; ?>
                                            </select>
                                            <label class="glyphicon glyphicon-search" title="" rel="tooltip" for="email"
                                                   data-original-title="email"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-8">
                                    <label class="control-label col-md-1" for="prepend">Period between</label>

                                    <div class="col-md-3" id="startdate-group">
                                        <div class="input-group">
                                            <input type="text" name="mydate1" id="startdate"
                                                   placeholder="Select start date" class="form-control datepicker"
                                                   data-dateformat="yy/mm/dd">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <label class="control-label col-md-1" for="prepend">AND</label>

                                    <div class="col-md-3" id="finishdate-group">
                                        <div class="input-group">
                                            <input type="text" name="mydate2" id="finishdate"
                                                   placeholder="Select end date" class="form-control datepicker"
                                                   data-dateformat="yy/mm/dd">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <label class="control-label col-md-1" for="prepend"></label>
                                    <button class="btn btn-primary col-md-2" type="submit" id="submitallocation">
                                        <i class="fa fa-save"></i>
                                        Allocate to file
                                    </button>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label class="control-label col-md-3" for="prepend"> Store</label>

                                    <div class="col-md-9">
                                        <div class="icon-addon addon-sm" id="store-group">
                                            <select class="form-control" name="store-select" id="store-select">
                                                <?php echo $defaultstore; ?>
                                                <option value="all">All stores</option>
                                                <?php echo $dataliststore; ?>
                                            </select>
                                            <label class="glyphicon glyphicon-search" title="" rel="tooltip" for="email"
                                                   data-original-title="email"></label>
                                        </div>
                                    </div>

                                </div>
                                <div class=" form-group col-sm-8">
                                    <label class="control-label col-md-1" for="prepend">Stock</label>
                                    <div class="col-md-3" id="stock-group">
                                        <div class="icon-addon addon-sm">
                                            <select class="form-control" name="stock-select" id="stock-select">

                                            </select>
                                            <label class="glyphicon glyphicon-search" title="" rel="tooltip" for="email"
                                                   data-original-title="email"></label>
                                        </div>
                                    </div>
                                    <label class="control-label col-md-1" for="prepend">Quantity</label>

                                    <div class="col-md-3" id="stock-count">
                                        <div class="icon-addon addon-sm">
                                            <input class="form-control" type="text" readonly id="quantity">
                                        </div>
                                    </div>
                                    <label class="control-label col-md-1" for="prepend"></label>
                                    <button class="btn btn-danger col-md-2" id="cancelbutton" onclick=""
                                            type="button">
                                        <i class="fa fa times"></i>
                                        Clear Allocation file
                                    </button>
                                </div>
                                <div class="col-sm-4">

                                </div>
                            </div>
                        </form>
                        <div id="success_message" class="row">

                        </div>
                        <div class="row">
                            <div class=" col-sm-12 " id="table_container">

                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col-sm-12  container" style="font-size: 15px; font">
                                <section class="col-sm-10">
<!--                                    <span id="stock_in_file">Stock in allocation file: &nbsp<b> </b></span>-->
                                </section>
                                <section class="col-sm-2">
                                    <a class="btn btn-primary btn-md" href="allocation_list_total.php" target="_blank" id="display_a">Display
                                        Allocation File</a>
                                </section>

                            </div>

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

    $("#store-select").on("change", function () {
        var store_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {store_id: store_id},
            url: "ajax/allocation/stock_select_post.php",
            dataType: 'json',
            success: function (response) {
                // alert(response);
                $('#stock-select').empty().append('<option value="none" id="default_stock" selected>Select stock</option>' + response.stock_select);
                $('#quantity').val('');
            }
        });
    });

    $("#stock-select").on("change", function () {
        var stock_id = $(this).val();
        var store_id = $('#store-select').val();
        //alert (store_);
        //alert (stock_id);
        $.ajax({
            type: "POST",
            data: {stock_id: stock_id, store_id_stock: store_id},
            url: "ajax/allocation/stock_select_post.php",
            dataType: 'json',
            success: function (response) {
                $('#quantity').val(response.stock_count);
            }
        });
    });

    $(document).ready(function () {
        $('#sales_allocation').submit(function (event) {
            $('#customer-group').removeClass('has-error');
            $('#store-group').removeClass('has-error');
            $('#stock-group').removeClass('has-error');
            $('#startdate-group').removeClass('has-error');
            $('#finishdate-group').removeClass('has-error');
            $('.help-block').remove();

            var formData = {
                'customer_id': $('#customer-select').val(),
                'store_id': $('#store-select').val(),
                'stock_id': $('#stock-select').val(),
                'stock_count': $('#quantity').val(),
                'start_date': $('#startdate').val(),
                'end_date': $('#finishdate').val()
            };

            $.ajax({
                type: 'POST',
                url: 'ajax/allocation/total_turnover_post.php',
                data: formData,
                dataType: 'json',
                encode: true
            }).done(function (data) {
                if (!data.success) {
                    if (data.errors.customer) {
                        $('#customer-group').addClass('has-error');
                        $('#customer-group').append('<div class="help-block">' + data.errors.customer + '</div>');
                    }
                    if (data.errors.store) {
                        $('#store-group').addClass('has-error');
                        $('#store-group').append('<div class="help-block">' + data.errors.store + '</div>');
                    }
                    if (data.errors.stock) {
                        $('#stock-group').addClass('has-error'); // add the error class to show red input
                        $('#stock-group').append('<div class="help-block">' + data.errors.stock + '</div>');
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
                    $('#store-select').val('none').trigger('change');
                    $('#customer-select').val('none').trigger('change');
                    $('#stock-select').val('');
                    $('#quantity').val('');
                    $('#startdate').val('');
                    $('#finishdate').val('');
                    $('#success_message').html('<p class="alert alert-success col-md-offset-3 col-md-6" style="text-align: center;"> update Successful </p>').fadeIn('fast').fadeOut(3000);
                    $('#table_container').empty().append(data.table);
                    //alert('success');
                }
            });
            event.preventDefault();
        });
    });
    $('#cancelbutton').on("click", function () {
        $.ajax({
            type: 'POST',
            data: {delete_command: "empty"},
            url: 'ajax/allocation/total_turnover_post.php',
            dataType: 'json',
            encode: true,
            success: function (response) {
                //alert(response);
                $('#table_container').empty().append(response.stock_in_table);
                $('#display_a').prop("disabled", true);
            }
        });
    });

    $('document').ready(function () {
        $.ajax({
            type: 'POST',
            data: {load_command: "fetch"},
            url: 'ajax/allocation/total_turnover_post.php',
            dataType: 'json',
            encode: true,
            success: function (response) {
                $('#table_container').append(response.table);
            }
        });
    })

</script>