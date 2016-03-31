<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");
$_SESSION['last_screen'] = "request_manager.php";

include "../lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    $data['success'] = false;
    die("Connection failed: " . mysqli_connect_error());
}
$table_record= "";
$result_log= mysqli_query($conn, "select * from upload_log where request != 0 OR status != 0 order by upload_date DESC ");
if (mysqli_num_rows($result_log) > 0) {
    while ($row= mysqli_fetch_assoc($result_log) ) {
        $date= $row['upload_date'];
        $remark= $row['remark'];
        $status= $row['status'];
        $request= $row['request'];

        if ($status == 0 && $request == 1) {
            $current_state= "pending";
        }
        else {
            $current_state= "approved";
        }
        $table_record.= '<tr><td>' . date("d-m-Y",strtotime($date)) . '</td><td>' . $remark . '</td><td>'. $current_state. '</td><td><button class="btn btn-primary btn-xs check_approval" onclick="do_request(this)"><input type="hidden"  value="'.$date.'">Check Approval</button></td></tr>';
    }
}
?>


<div class="row ">
    <h1 style="text-align: center;"><b>Make a request</b></h1>
    <section class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2  well">
        <div class="row">
            <div class="col-sm-5">
                <div id="date-group">
                    <div class="input-group col-sm-12 ">
                        <input type="text" name="startdate" placeholder="Select a date" class="form-control "
                               data-dateformat="yy/mm/dd" id="startdate" value="<?php echo date('Y-m-d'); ?>">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <textarea rows="4" id="remark" name="remark" class="form-control" placeholder="Enter Reason"></textarea>
                </div>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary" style="margin-bottom: 20px; " type="button" id="make_request" onclick='do_request(this)'>
                    <i class="fa fa-arrow-up"></i> <span class="hidden-mobile">Send Request</span>
                </button>
                <button class="btn btn-danger" style="margin-bottom: 20px; " type="button" id="cancel_request" onclick='do_request(this)'>
                    <i class="fa fa-refresh"></i> <span class="hidden-mobile">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Clear&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </button>
            </div>
        </div><br><br>
        <div id="show_result" style="display:none"></div>
        <div class="row">
            <div id="items_table" class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Request Date</th>
                            <th>Remark</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="show_records">
                        <?php echo $table_record;?>
                    </tbody>
                </table>
        </div>
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

    var pagefunction = function () {
        loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);


        function run_jqgrid_function() {


    }

    };
    loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);

</script>
<script>
    var date_picked;
    var startdate_val;

    function getBaseUrl() {
        var re = new RegExp(/^.*\//);
        return re.exec(window.location.href);
    }


    $('#startdate').datepicker({
        dateFormat: 'yy-mm-dd',

        maxDate: '0d',
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        onSelect: function (selectedDate) {
            $('#finishdate').datepicker('option', 'minDate', selectedDate);
            date_picked = selectedDate;
            $('#hidden_date').val(date_picked);
        }
    });


    var company_id;
    var url_store;
    var post_data;
    var run_data;
    var store_name;
    var log_data;
    var request_made;
    var check_approv="";



    var result_rest;

    function do_request(clicked) {
        request_made ="";
//                event.preventDefault();
        if($(clicked).attr('id') == 'cancel_request'){
            $('#remark').val('');
            $('#startdate').val('<?php echo date("Y-m-d");?>');
        }


        else{
            $.blockUI({
                message: '<h1 style=""><img style="" width="100" height="100" src="dist/img/ajax_loader_blue.gif" />Loading...</h1>',
                css: {backgroundColor: '#grey', opacity: 0.3, color: '#fff', border: '0px solid #C1DAD7'}});
            if($(clicked).attr('id') == 'make_request'){
                request_made="make_request";

            }
            else {
                request_made="check_approval";

            }
            startdate_val = $('#startdate').val();
            $.ajax({
                type: 'POST',
                url: 'do_rest_check.php',
                data: {date: startdate_val},
                cache: false,
                dataType: 'json',
                encode: true
            })
                // using the done promise callback
                .done(function (data1) {

                    if (!data1.success) {
                        $.unblockUI();
                        if (data1.internet) {
                            $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Please connect to the internet and retry </div>");
                            $('#show_loader').hide(200).html('');
                        }
                        else if (data1.sorry) {
                            $('#show_loader').hide(200).html('');
                            $('#show_warning').hide('fast');
                            $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong></strong>" + data1.sorry + "</div>");

                            setTimeout(function () {
                                window.location.href = getBaseUrl() + "settings.php";
                            }, 4000);
                        }
                        else {
                            $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>" + data1.message + "</div>");
                            $('#show_loader').hide(200).html('');
                        }

                    }
                    //THERE IS SUCCESS FROM THE RST FUNCTION, SO...
                    else {
                        if (data1.company_id) {
                            company_id = data1.company_id;
                            store_name = data1.store_name;
                            url_store = data1.upload_url;
                            //THERE IS A COMPANY ID, SO START OTHER THINGS

                            //THIS CODE CHECKS IF IT IS MAKE REQUEST OR CHECK FOR APPROVAL
                            if(request_made!=""){
                                if(request_made=="make_request"){
                                    post_data = {
                                        upload_date: startdate_val,
                                        request: $('#remark').val(),
                                        company_id: company_id
                                    };
                                }
                                else{
                                    post_data = {
                                        upload_date: startdate_val,

                                        company_id: company_id
                                    };
                                }
                                //Check if the posted date is already on the server
                                $.ajax({
                                    type: 'POST',
                                    url: url_store + '/request_unlock.php',
                                    data: post_data,
                                    cache: false,
                                    dataType 	: 'json',
                                    encode 		: true
                                })
                                    // using the done promise callback
                                    .done(function (data) {
                                        if(!data.success){
                                            $.unblockUI();
                                            $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>"+data.message+"</div>");
                                        }
                                        else{

                                            if(data.message!="true" && data.message!=1){
                                                $.unblockUI();
                                                $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Approval has not yet been granted. Try again later</div>");

                                            }
                                            else{
                                                if(data.message=="true"){
                                                    run_data = {
                                                        upload_date: startdate_val,

                                                        request:1,
                                                        remark:$('#remark').val()
                                                    };
                                                }
                                                else if(data.message==1){
                                                    run_data = {
                                                        upload_date: startdate_val,

                                                        status:1,
                                                        request:0
                                                    };
                                                }
                                                $.post('update_logrun.php',run_data, function (show_result) {
                                                    $.unblockUI();
                                                    if(!show_result.success){
                                                        $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>"+show_result.message+"</div>");
                                                    }
                                                    else{
                                                        $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-success text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Success!&nbsp; </strong>"+show_result.message+"</div>");
                                                        $('#show_records').empty().append(show_result.table);
                                                    }
                                                },'json');

                                            }

                                        }

                                    })
                                    .fail(function () {
                                        $.unblockUI();
                                        $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Request not successfully sent, please retry</div>");
                                        $('#show_loader').hide(200).html('');
                                        $('#show_warning').hide('fast');

                                    });
                            }
                            else{
                                $.unblockUI();
                                $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Cannot process request, please retry</div>");
                            }




                        }
                        //THERE IS NO COMPANY ID SO DISPLAY ERROR MESSAGE
                        else {
                            $.unblockUI();
                            $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Request Not Successfully sent, please retry</div>");
                            $('#show_loader').hide(200).html('');
                        }}
                    $('#upload_everything').prop('disabled', false);
                })
                .fail(function () {
                    $.unblockUI();
                    $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Request Not Succesfully sent, please retry</div>");
                    $('#show_loader').hide(200).html('');
                    $('#upload_everything').prop('disabled', false);
                });
        }

    }
</script>