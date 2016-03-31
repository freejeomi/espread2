<?php require_once("inc/init.php"); ?>
<!-- row -->
<?php
$_SESSION['last_screen'] = "upload_daily_summary2.php";
include "../lib/util.php";
include "../rest_function.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
function add_http($url)
{
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }

    return $url;
}

//$url_store="";
$query1 = "SELECT company_name,upload_url,company_id,company_address FROM settings LIMIT 1";
$result1 = mysqli_query($conn, $query1);
if (mysqli_num_rows($result1) > 0) {
    $url_row = mysqli_fetch_array($result1);
    $url_store = $url_row[1];
    $url_store = add_http($url_store);
    $store_name = $url_row[0];
    $company_id = $url_row[2];
    $address = $url_row[3];
} else {
    $store_name = "";
    $company_id = "";
    $url_store = "";
    $address = "";
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
        <section class="form-group col-md-12" style="padding-bottom: 2em; display:none;" id="show_result"></section>
        <h2><b>Daily Upload Summary</b></h2>

        <div class=" well" id="errorappend">

            <p class="" style="font-size: 15px;">
                Select a date you want to upload
            </p>


            <div id="date-group">
                <div class="input-group col-sm-6 col-sm-offset-3">
                    <input type="text" name="startdate" placeholder="Select upload date" class="form-control"
                           data-dateformat="yy/mm/dd" id="startdate" value="<?php echo date('Y-m-d'); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <br>

            <div>
                <p class="" style="font-size: 15px;">
                    Click the button below to upload now
                </p>
            </div>


            <div class="text-center">
                <div id="icon_show">
                    <i class="fa fa-arrow-circle-up fa-5x"></i>


                </div>
                <br>
                <button class="btn btn-primary btn-lg" style="margin-bottom: 20px; " type="button"
                        id="upload_everything">Upload
                </button>
                <div id="show_loader" style="display: none"></div>
                <div class="alert alert-warning" id="append-error">
                    <strong>Warning! &nbsp &nbsp &nbsp &nbsp</strong>This should be done at the <b>close of the day</b>.
                    You will need to contact the Administrator for re-uploading.
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

    var pagefunction = function () {
        loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);


        function run_jqgrid_function() {
// Customize the grid


            //I'm submitting the form now


//            Show tool Tip
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
            var run_sql;
            var store_name;
            var log_data;


//            $('button').click(function (event) {
//                event.preventDefault;
//                if($(this).attr('id') == 'upload_everything'){
//                    upload_cash_stock.trigger('click');
//                }
//            });
            var result_rest;
            $(' button').click(function (event) {


                startdate_val = $('#startdate').val();

                event.preventDefault;
       if ($(this).attr('id') == 'upload_everything') {

        $('#upload_everything').prop('disabled', true);
        $('#show_loader').show(200).html('<img src="btn-ajax-loader.gif">&nbsp;...Uploading Data');

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
            if (data1.internet) {
                $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Please connect to the internet and retry again</div>");
                $('#show_loader').hide(200).html('');
            }
            else if (data1.sorry) {
              $('#show_loader').hide(200).html('');
              $('#show_warning').hide('fast');
              $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong></strong>" + data1.sorry + "</div>");

              setTimeout(function () {
                  window.location.href = getBaseUrl() + "settings.php";
              }, 5000);
            }
            else {
                $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>" + data1.message + "</div>");
                $('#show_loader').hide(200).html('');
            }

           }
           else {
            if (data1.company_id) {
                company_id = data1.company_id;
                store_name = data1.store_name;
                url_store = data1.upload_url;
                //THERE IS A COMAPNY ID, SO START OTHER THINGS
                post_data = {
                    upload_date: startdate_val,
                    store_name: store_name,
                    company_id: company_id
                };
//Check if the posted date is already on the server
            $.ajax({
                type: 'GET',
                url: url_store + '/date_upload_check.php',
                data: post_data,
                cache: false
                                        //dataType 	: 'json',
                                        // encode 		: true
            })
                                        // using the done promise callback
            .done(function (data) {
              if (data != "1") {

                                                //alert(data.message);
               $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>" + data + "</div>");
               $('#show_warning').hide('fast');
               $('#close_alert').click(function () {
               $('#show_warning').show('fast');
               });
               $('#show_loader').hide(200).html('');

               }
           else {

                  //if that date is not in database
                  // alert(data.message);
            $.ajax({
              type: 'GET',
              url: 'upload_data_mysql.php',
              data: post_data,
              dataType: 'json',
              encode: true,
              cache: false
            })
                // using the done promise callback
            .done(function (result) {
             if (result.success) {
             run_sql = {file_name: store_name, company_id: company_id};


             $.ajax({
                 type: 'GET',
                 url: url_store + '/run_mysql.php',
                 data: run_sql,
                 cache: false
                 //dataType 	: 'json',
                 //encode 		: true
             })
                 // using the done promise callback
                 .done(function (result1) {
                     if (result1 === "1") {
                        log_data= {date: startdate_val};
                         // UPDATE LOG
                         $.post('update_log.php',log_data, function (log_show) {
                             if(log_show ==="1"){
                                 $('#show_loader').hide(200).html('');
                                 $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-success text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Success! </strong>  Daily Upload was Successful</div>");
                                 $('#show_warning').hide('fast');
                             }
                             else{
                                 $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-warning text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Could not log result. Daily Upload Successful</div>");
                                 $('#show_loader').hide(200).html('');
                                 $('#show_warning').hide('fast');
                             }
                         });   

                         // alert(result1.message);


                     }

                     else {
                                                                        //alert(result.message);
                         $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>" + result1 + "</div>");
                         $('#show_loader').hide(200).html('');
                         $('#show_warning').hide('fast');

                         // $('#show_loader').html('');
                     }
                 })
                 .fail(function () {
                     $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Upload Not Succesful, please retry</div>");
                     $('#show_loader').hide(200).html('');
                     $('#show_warning').hide('fast');

                 });

             }
             else {
                 $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>" + result.message + "</div>");
                 $('#show_loader').hide(200).html('');
                 $('#show_warning').hide('fast');

             }
                });

              }

                })
                .fail(function () {
                    $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Upload Not Succesful, please retry</div>");
                    $('#show_loader').hide(200).html('');
                    $('#show_warning').hide('fast');

                });

            }
            else {
                $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Upload Not Succesful, please retry</div>");
                $('#show_loader').hide(200).html('');
            }
           }

                $('#upload_everything').prop('disabled', false);
            })
            .fail(function () {
                $('#show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center' style='font-size:1em'><button class='close' id='close_alert' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp; </strong>Upload Not Succesful, please retry</div>");
                $('#show_loader').hide(200).html('');
                $('#upload_everything').prop('disabled', false);
            });


       }

//        For closing the box
                else if ($(this).attr('id') == 'closing_button') {
                }
//    for a button clicked


            });


            //for the button tool to close the box
            $('.btn-box-tool').click(function () {
                $('.box-body').slideToggle('slow');
                $('.btn-box-tool i').toggleClass('fa-plus fa-minus');
            });


        }// end function

    }
    loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);

</script>
