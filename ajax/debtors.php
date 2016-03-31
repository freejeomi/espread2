<?php
require_once ("inc/init.php");
require_once("userlogcheck_admin.php");
//include("../rest_function.php");
include("../lib/util.php");
$_SESSION['last_screen'] = "debtors.php";

$company_name = "";
$company_email = "";
$sms_username = "";
$sms_password = "";
$upload_url = "";
// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
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

$result_sql = mysqli_query($conn, "SELECT company_name,company_email, upload_url, sms_username, sms_password from settings");
if (mysqli_num_rows($result_sql) > 0) {
    $row= mysqli_fetch_assoc($result_sql);
    $company_name = $row['company_name'];
    $company_email = $row['company_email'];
    $upload_url = $row['upload_url'];
    $upload_url = add_http($upload_url);
    $sms_username = $row['sms_username'];
    $sms_password = $row['sms_password'];
}
?>

<!--
The ID "widget-grid" will start to initialize all widgets below
You do not need to use widgets if you dont want to. Simply remove
the <section></section> and you can use wells or panels instead
-->

<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="message_div"></div>
            <table id="jqgrid"></table>
            <div id="pjqgrid">
                <button class='btn btn-sm btn-info' style="margin-right: 5px;" id="general_sms">SMS</button> <button class='btn btn-sm btn-danger' id="general_email">Email</button>
            </div>

            <br>
           
            <div id="post_result"></div>
            <input type="hidden" value="" id="jsondata">
        </article>
        <!-- WIDGET END -->

    </div>

    <!-- end row -->

</section>
<!-- end widget grid -->

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
     */
    function sendEmail(clicked_id) {
        var customer_id= $(clicked_id).children('.email_id').val();
        var customer_name= $(clicked_id).children('.cus_name').val();
        //var customer_phone= $(clicked_id).children('.cus_phone').val();
        var debt_amount= $(clicked_id).children('.money_owed').val();
        var customer_email= $(clicked_id).children('.cus_email').val();
        $.blockUI({
            message: '<h1 style=""><img style="" width="100" height="100" src="dist/img/ajax_loader_blue.gif" />Loading...</h1>',
            css: {backgroundColor: '#grey', opacity: 0.3, color: '#fff', border: '0px solid #C1DAD7'}

        });
        $.ajax({
            url: 'ajax/customer_account/send_email.php',
            type: 'POST',
            //async: false,
            //datatype: JSON,
            data: { cus_id: customer_id,
                    name: customer_name,
                    email: customer_email,
                    amount: debt_amount
            }
        }).done(function (data) {
            $.unblockUI();
            if (data == "no email") {
                $('#message_div').empty().append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> there is no email address for the selected customer</div>');
            }
            else if (data == "email successful") {
                $('#message_div').empty().append('<div class="alert alert-success" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Email has been sent successfully!</div>');
            }
            else {
                $('#message_div').empty().append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Sorry, email could not be sent. Please try again</div>');
            }
        });
    }

    function sendSms(click_id){
        var customer_id = $(click_id).children('.email_id_s').val();
        var customer_name = $(click_id).children('.cus_name_s').val();
        var customer_phone= $(click_id).children('.cus_phone_s').val();
        var debt_amount = $(click_id).children('.money_owed_s').val();
        //var customer_email = $(clicked_id).children('.cus_email').val();
        $.blockUI({
            message: '<h1 style=""><img style="" width="100" height="100" src="dist/img/ajax_loader_blue.gif" />Loading...</h1>',
            css: {backgroundColor: '#grey', opacity: 0.3, color: '#fff', border: '0px solid #C1DAD7'}

        });
        $.ajax({
            url: 'ajax/customer_account/send_sms.php',
            type: 'POST',
            //async: false,
            //datatype: JSON,
            data: {
                cus_id: customer_id,
                name: customer_name,
                phone: customer_phone,
                amount: debt_amount
            }
        }).done(function (data) {
            $.unblockUI();
            if (data == "no sms") {
                $('#message_div').empty().append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> there is no phone number for the selected customer</div>');
            }
            else if (data == "sms successful") {
                $('#message_div').empty().append('<div class="alert alert-success" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> SMS has been sent successfully!</div>');
            }
            else {
                $('#message_div').empty().append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Sorry, SMS could not be sent. Please try again</div>');
            }
        });
    }

    var pagefunction = function() {
        loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);


        function run_jqgrid_function() {
            var selected_row;
            jQuery("#jqgrid").jqGrid({
                //data : jqgrid_data,
                url: "ajax/customer_account/debtors_get.php",
                datatype: "json",
                mtype: "GET",
                height : 'auto',
                colNames : ['Customer Id', 'Name of customer', 'Account Balance', 'Phone Number', 'Email','Action'],
				colModel : [
				{
					name : 'customer_Id',
					index : 'customer_Id',
					sortable : true,
					editable:false

				}, {
					name : 'customer_name',
					index : 'customer_name',
					editable : false
				}, {
					name : 'current_bal',
					index : 'current_bal',
                        //formatter:'currency',
					editable : false
				},
				{
					name : 'phone',
					index : 'phone',
					editable : false
				},
				{
					name : 'email',
					index : 'email',
					editable : false
				},
				{
					name : 'act',
					index : 'act',
					sortable : false,
//					formatter: 'showlink',
//					formatoptions: {baseLinkUrl: "#ajax/", showAction: "customer_payment.php", idName: "cus_Id" }
				}
				],
				rowNum : 10,
				rowList : [10, 20, 30],
				pager : '#pjqgrid',
				sortname : 'customer_Id',
				toolbarfilter : true,
				viewrecords : true,
				sortorder : "asc",
				gridComplete : function() {
					var ids = jQuery("#jqgrid").jqGrid('getDataIDs');
						//alert(rolenames);

					for (var i = 0; i < ids.length; i++) {
						var cl = ids[i];
                        var cus_name = jQuery("#jqgrid").jqGrid('getCell', cl, 'customer_name');
                        var cus_phone= jQuery("#jqgrid").jqGrid('getCell', cl, 'phone');
                        var cus_email= jQuery("#jqgrid").jqGrid('getCell', cl, 'email');
                        var money_owed= jQuery("#jqgrid").jqGrid('getCell', cl, 'current_bal');

						mp= "<a class='btn btn-sm btn-success' style='margin-right: 3px;' href='#ajax/customer_payment.php?cus_Id=" + cl + "'>Make payment</a>";


						sm= "<button class='btn btn-sm btn-danger' id='email_button' style='margin-right: 3px;' onclick='sendEmail(this)'>Email " +
                            "<input type='hidden'  class='email_id' value='" + cl + "'>" +
                            "<input type='hidden'  class='cus_name' value='" + cus_name + "'>" +
                            "<input type='hidden'  class='cus_phone' value='" + cus_phone + "'>" +
                            "<input type='hidden'  class='cus_email' value='" + cus_email + "'>" +
                            "<input type='hidden' class='money_owed' value='" + money_owed + "'>" +
                            "</button>";


						em= "<button class='btn btn-sm btn-primary' id='sms_button' style='margin-right: 3px;' onclick='sendSms(this)' >SMS" +
                            "<input type='hidden'  class='email_id_s' value='" + cl + "'>" +
                            "<input type='hidden'  class='cus_name_s' value='" + cus_name + "'>" +
                            "<input type='hidden'  class='cus_phone_s' value='" + cus_phone + "'>" +
                            "<input type='hidden'  class='cus_email_s' value='" + cus_email + "'>" +
                            "<input type='hidden' class='money_owed_s' value='" + money_owed + "'>" +
                            "</button>";

						jQuery("#jqgrid").jqGrid('setRowData', ids[i], {
							act : mp + sm + em
						});
					}


				},
                editurl : "ajax/setup/customer_grid_set.php",
                caption : "Customer Table",
                multiselect : true,
                autowidth : true

            });
            jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
                edit : false,
                add : false,
                del : false,
                search: true
            });
            //jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
            ///* Add tooltips */
            //$('.navtable .ui-pg-button').tooltip({
            //    container : 'body'
            //});

            // remove classes
            $(".ui-jqgrid").removeClass("ui-widget ui-widget-content");
            $(".ui-jqgrid-view").children().removeClass("ui-widget-header ui-state-default");
            $(".ui-jqgrid-labels, .ui-search-toolbar").children().removeClass("ui-state-default ui-th-column ui-th-ltr");
            $(".ui-jqgrid-pager").removeClass("ui-state-default");
            $(".ui-jqgrid").removeClass("ui-widget-content");

            // add classes
            $(".ui-jqgrid-htable").addClass("table table-bordered table-hover");
            $(".ui-jqgrid-btable").addClass("table table-bordered table-striped");

            $(".ui-pg-div").removeClass().addClass("btn btn-sm btn-primary");
            $(".ui-icon.ui-icon-plus").removeClass().addClass("fa fa-plus");
            $(".ui-icon.ui-icon-pencil").removeClass().addClass("fa fa-pencil");
            $(".ui-icon.ui-icon-trash").removeClass().addClass("fa fa-trash-o");
            $(".ui-icon.ui-icon-search").removeClass().addClass("fa fa-search");
            $(".ui-icon.ui-icon-refresh").removeClass().addClass("fa fa-refresh");
            $(".ui-icon.ui-icon-disk").removeClass().addClass("fa fa-save").parent(".btn-primary").removeClass("btn-primary").addClass("btn-success");
            $(".ui-icon.ui-icon-cancel").removeClass().addClass("fa fa-times").parent(".btn-primary").removeClass("btn-primary").addClass("btn-danger");

            $(".ui-icon.ui-icon-seek-prev").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-prev").removeClass().addClass("fa fa-backward");

            $(".ui-icon.ui-icon-seek-first").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-first").removeClass().addClass("fa fa-fast-backward");

            $(".ui-icon.ui-icon-seek-next").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-next").removeClass().addClass("fa fa-forward");

            $(".ui-icon.ui-icon-seek-end").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-end").removeClass().addClass("fa fa-fast-forward");

            // update buttons

            $(window).on('resize.jqGrid', function() {
                $("#jqgrid").jqGrid('setGridWidth', $("#content").width());
            });


            //$('#post_result').html(jqgrid_data);
            //});
            //alert ($('#jsondata').val());
            //alert (jqgrid_data);

//            selected_row = jQuery("#jqgrid").jqGrid('getGridParam', 'selarrow');
//
//            if (selected_row.length) {
//                $('#general_email').prop('disabled', true);
//            }
//            else {
//                $('#general_email').prop('disabled', false);
//            }
    //ARRAY HOLDING THE CUSTOMER NAME, PHONE, EMAIL, AND MONEY OWED
var cus_name_array=[];
var cus_phone_array=[];
var cus_email_array=[];
var money_owed_array=[];
var no_email=[];
var no_sms= [];
var cus_id_array=[];

//WHEN THE GENERAL (BULK) EMAIL BUTTON IS CLICKED
            $('#general_email').click(function () {

            //GET THE NUMBER OF SELECTED ROWS
                selected_row = jQuery("#jqgrid").jqGrid('getGridParam', 'selarrrow');

                //THERE ARE SELECTED ROWS SO...
                if(selected_row.length){
                for(var s= 0; s<selected_row.length; s++){
                    cus_name_array[s] = jQuery("#jqgrid").jqGrid('getCell', selected_row[s], 'customer_name');
                    cus_phone_array[s] = jQuery("#jqgrid").jqGrid('getCell', selected_row[s], 'phone');
                    cus_email_array[s] = jQuery("#jqgrid").jqGrid('getCell', selected_row[s], 'email');
                    money_owed_array[s] = jQuery("#jqgrid").jqGrid('getCell', selected_row[s], 'current_bal');
                    cus_id_array[s]=selected_row[s];

                    if(!cus_email_array[s]){
                    no_email[s]=selected_row[s];
                    }
                }
                    $.blockUI({
                        message: '<h1 style=""><img style="" width="100" height="100" src="dist/img/ajax_loader_blue.gif" />Loading...</h1>',
                        css: {backgroundColor: '#grey', opacity: 0.3, color: '#fff', border: '0px solid #C1DAD7'}

                    });
                    $.ajax({
                        type: 'POST',
                        url: 'ajax/customer_account/send_email.php',
                        data: {
                            cus_data: JSON.stringify({
                                cus_id:cus_id_array ,
                                name: cus_name_array,
                                email: cus_email_array,
                                amount: money_owed_array})
                        },
                        dataType: 'json',
                        encode: true,
                        cache:false

                    })
                        // using the done promise callback
                        .done(function (data) {
                            $.unblockUI();
                            jQuery("#jqgrid").jqGrid('resetSelection');
                            if (data.data_show ) {
                                $('#message_div').empty().append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i>'+data.data_show+'</div>');
                            }
                            else if (data.data_success) {
                                $('#message_div').empty().append('<div class="alert alert-success" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Email has been sent successfully to all!</div>');
                            }
                            else if(data.email_count){
                                $('#message_div').empty().append('<div class="alert alert-warning" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Could not send '+data.email_count+' email(s).&nbsp;Please check if all selected customers have email addresses.. Others has been sent successfully sent!</div>');

                            }
                            else {
                                $('#message_div').empty().append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Sorry, email could not be sent. Please try again</div>');
                            }
                        });




                }
                //NO SELECTED ROW, ALERT THE SENDER
                else{
                alert('no selected row');
                }
            });

            //WHEN THE GENERAL (BULK) SMS BUTTON IS CLICKED
            $('#general_sms').click(function () {
                var upload_url= '<?php echo $upload_url ?>';
                //GET THE NUMBER OF SELECTED ROWS
                selected_row = jQuery("#jqgrid").jqGrid('getGridParam', 'selarrrow');

                //THERE ARE SELECTED ROWS SO...
                if (selected_row.length) {
                    for (var s = 0; s < selected_row.length; s++) {
                        cus_name_array[s] = jQuery("#jqgrid").jqGrid('getCell', selected_row[s], 'customer_name');
                        cus_phone_array[s] = jQuery("#jqgrid").jqGrid('getCell', selected_row[s], 'phone');
                        cus_email_array[s] = jQuery("#jqgrid").jqGrid('getCell', selected_row[s], 'email');
                        money_owed_array[s] = jQuery("#jqgrid").jqGrid('getCell', selected_row[s], 'current_bal');
                        cus_id_array[s] = selected_row[s];

                        if (!cus_email_array[s]) {
                            no_sms[s] = selected_row[s];
                        }
                    }
                    $.blockUI({
                        message: '<h1 style=""><img style="" width="100" height="100" src="dist/img/ajax_loader_blue.gif" />Loading...</h1>',
                        css: {backgroundColor: '#grey', opacity: 0.3, color: '#fff', border: '0px solid #C1DAD7'}

                    });
                    $.ajax({
                        type: 'POST',
                        url: upload_url+'/sms_send_process_bulk.php',
                        data: {
                            cus_data: JSON.stringify({
                                cus_id: cus_id_array,
                                name: cus_name_array,
                                phone: cus_phone_array,
                                amount: money_owed_array,
                                sms_password: '<?php echo $sms_password; ?>',
                                sms_username: '<?php echo $sms_username; ?>',
                                company_name: '<?php echo $company_name; ?>'
                            }),

                        },
                        dataType: 'json',
                        encode: true,
                        cache: false

                    })
                        // using the done promise callback
                        .done(function (data) {
                            $.unblockUI();
                            jQuery("#jqgrid").jqGrid('resetSelection');
                            if (data.data_show) {
                                $('#message_div').empty().append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i>' + data.data_show + '</div>');
                            }
                            else if (data.data_success) {
                                $('#message_div').empty().append('<div class="alert alert-success" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i>' +data.data_success+'</div>');
                            }
                            else if (data.email_count) {
                                $('#message_div').empty().append('<div class="alert alert-warning" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Could not send ' + data.email_count + ' SMS(s).&nbsp;You may need to check if all selected customers have phone numbers. Others have been sent successfully sent!</div>');

                            }
                            else {
                                $('#message_div').empty().append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Sorry, SMS could not be sent. Please try again</div>');
                            }
                        })
                        .fail(function () {
                            $.unblockUI();
                            $('#message_div').empty().append('<div class="alert alert-danger" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Sorry, SMS could not be sent. Please try again</div>');
                        });


                }
                //NO SELECTED ROW, ALERT THE SENDER
                else {
                    alert('no selected row');
                }
            });


        }// end function

    }
    loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);

</script>
