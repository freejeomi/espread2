<?php
//initilize the page
require_once("inc/init.php");
require_once("lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//require('lib/util.php');
$email = "";
$phone = "";
$address = "";
$company = "";
$start_date = "";
$end_date = "";
$store = "";
$upload = "";
$ftp_servername = "";
$ftp_password = "";
$ftp_username = "";
$sms_username = "";
$sms_password = "";
$email_smtp="";
$email_pass="";
$email_user="";
//script to retrieve store drop down select
include "lib/util.php";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT company_name, company_address, company_phone, company_email, accounting_year_start, accounting_year_end, retail_store, upload_url, ftp_server_name, ftp_server_user, ftp_server_password, sms_username, sms_password,email_smtp,email_user,email_pass  FROM settings";

$result_settings = mysqli_query($conn, $sql);
if (!$result_settings) {

} else {
    while ($row = mysqli_fetch_assoc($result_settings)) {
        $email = $row['company_email'];
        $phone = $row['company_phone'];
        $address = $row['company_address'];
        $company = $row['company_name'];
        $start_date = $row['accounting_year_start'];
        $end_date = $row['accounting_year_end'];
        $store = $row['retail_store'];
        $upload = $row['upload_url'];
        $ftp_servername = $row['ftp_server_name'];
        $ftp_password = $row['ftp_server_password'];
        $ftp_username = $row['ftp_server_user'];
        $sms_username = $row['sms_username'];
        $sms_password = $row['sms_password'];
        $email_smtp=$row['email_smtp'];
        $email_pass=$row['email_pass'];
        $email_user=$row['email_user'];
    }
}
$select = "<select name='store' id='store' class='form-control'><option value='none'>select store</option>";
$sql = "SELECT store_name, store_id FROM store";
$result = mysqli_query($conn, $sql);
if ($result) {
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $store_name = $row['store_name'];
        $store_id = $row['store_id'];
        if ($store == $store_id) {
            $select .= "<option selected='selected'  value='$store_id'>$store_name</option>";
        } else {
            $select .= "<option value='$store_id'>$store_name</option>";
        }
    }
    $select .= "</select>";
}
else {
$select= "<input id= 'store' name='store' placeholder='type in the main retail store' type='text' class='form-control'>";
}

}


/* Login processing ends */


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Settings";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_body_prop = array("id" => "extr-page", "class" => "animated fadeInDown");
include("inc/header.php");

?>
    <!-- ==========================CONTENT STARTS HERE ========================== -->
    <!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
    <header id="header">
        <span id="logo"></span>

        <div id="logo-group">
            <span id="logo"> <img src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="SmartAdmin"> </span>

            <!-- END AJAX-DROPDOWN-->
        </div>


    </header>

    <div id="main" role="main">

        <!-- MAIN CONTENT -->
        <div id="content" class="container">

            <article class="row">
                <div class="col-sm-12 col-md-10 col-lg-10 col-md-offset-1" style="background-color: white;">

                    <!--    FORM TO SUBMIT BEGINS-->
                    <form class="form-horizontal" role="form" id="settings" method="POST">

                        <!--        COMPANY FIELDSET-->
                        <fieldset>
                            <legend>Company</legend>

                            <!--            NAME, SMS, EMAIL AND PHONE NUMBER OF THE COMPANY-->
                            <div class="row">
                                <!--                NAME-->
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="email">Name:</label>
                                    </div>
                                    <div class="col-md-10" id="company-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="company" name="company"
                                                   value="<?php echo $company; ?>">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        </div>

                                    </div>
                                </div>
                                <!--                PHONE NUMBER-->
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="email">Phone Number:</label>
                                    </div>
                                    <div class="col-md-10" id="phone-group">
                                        <div class="input-group">
                                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <!--                ADDRESS-->
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="email">Address:</label>
                                    </div>
                                    <div class="col-md-10" id="address-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="address" name="address"
                                                   value="<?php echo $address; ?>">
                                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <!--                EMAIL-->
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="email">Email:</label>
                                    </div>
                                    <div class="col-md-10" id="email-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <!--CREDITIANLS-->
                        <fieldset>
                            <legend>Credentials</legend>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="ftp_servername">ftp Server name:</label>
                                    </div>
                                    <div class="col-md-10" id="ftp_servername-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="ftp_servername"
                                                   name="ftp_servername"
                                                   value="<?php echo $ftp_servername; ?>">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="sms_username">SMS Username:</label>
                                    </div>
                                    <div class="col-md-10" id="sms_username-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="sms_username"
                                                   name="sms_username" value="<?php echo $sms_username; ?>">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="ftp_serverpassword">ftp Server Password:</label>
                                    </div>
                                    <div class="col-md-10" id="ftp_serverpassword-group">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="ftp_serverpassword" name="ftp_serverpassword" value="<?php echo $ftp_password; ?>">
                                            <span class="input-group-addon"><a id="ftp_hide_password" data-toggle="tooltip" data-placement="top" title=""><i style="" class="fa fa-eye"></i></a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="sms_password">SMS Password:</label>
                                    </div>
                                    <div class="col-md-10" id="sms_password-group">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="sms_password"
                                                   name="sms_password" value="<?php echo $sms_password; ?>">
                                            <span class="input-group-addon"><a id="sms_hide_password" data-toggle="tooltip" data-placement="top" title=""><i style="" class="fa fa-eye"></i></a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="ftp_serveruser">ftp Server Username:</label>
                                    </div>
                                    <div class="col-md-10" id="ftp_serveruser-group">
                                        <div class="input-group">
                                            <input type="tel" class="form-control" id="ftp_serveruser" name="ftp_serveruser" value="<?php echo $ftp_username; ?>">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="email_smtp">Email SMTP:</label>
                                    </div>
                                    <div class="col-md-10" id="email_smtp-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="email_smtp" name="email_smtp"
                                                   value="<?php echo $email_smtp; ?>">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="email_user">Email Username:</label>
                                    </div>
                                    <div class="col-md-10" id="email_user-group">
                                        <div class="input-group">
                                            <input type="tel" class="form-control" id="email_user" name="email_user"
                                                   value="<?php echo $email_user; ?>">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="col-md-2">
                                        <label for="email_pass">Email Password:</label>
                                    </div>
                                    <div class="col-md-10" id="email_pass-group">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="email_pass"
                                                   name="email_pass"
                                                   value="<?php echo $email_pass; ?>">
                                            <span class="input-group-addon"><a id="email_hide_password" data-toggle="tooltip" data-placement="top" title=""><i style="" class="fa fa-eye"></i></a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Accounting Year</legend>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label class="control-label col-md-1" for="prepend">Period between</label>

                                    <div class="col-md-5" id="startdate-group">
                                        <div class="input-group">
                                            <input type="text" name="mydate1" id="startdate" placeholder="start date"
                                                   class="form-control"
                                                   value="<?php echo $start_date; ?>">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <label class="control-label col-md-1" for="prepend">AND</label>

                                    <div class="col-md-5" id="finishdate-group">
                                        <div class="input-group col-sm-12">
                                            <input type="text" name="mydate2" id="finishdate" placeholder="end date"
                                                   class="form-control"
                                                   value="<?php echo $end_date; ?>">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Other Details</legend>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="col-md-2" for="upload">Upload url:</label>
                                    <div class="col-md-10" id="upload-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="upload" name="upload"
                                                   value="<?php echo $upload; ?>">
                                            <span class="input-group-addon"><i class="fa fa-arrow-circle-up"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-md-2" for="retail">Retail Store:</label>
                                    <div class="col-md-10" id="store-group">
                                        <div class="input-group">
                                            <?php echo $select; ?>
                                            <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </fieldset><br><br>

                        <div id="message_div"></div>
                        <fieldset>
                            <div class="row">
                                <div class="col-sm-3">
                                    <button class="btn btn-primary" type="submit" id="submitsettings">
                                        <i class="fa fa-save"></i>
                                        submit
                                    </button>
                                </div>
                            </div>
                        </fieldset><br><br>
                    </form>

                </div>
            </article>
        </div>


    </div>

    <!-- END MAIN PANEL -->
    <!-- ==========================CONTENT ENDS HERE ========================== -->

<?php
//include required scripts
include("inc/scripts.php");
?>

    <!-- PAGE RELATED PLUGIN(S)
    <script src="..."></script>-->

    <script type="text/javascript">
        //runAllForms();

        // START AND FINISH DATE
        $('#startdate').datepicker({
            dateFormat: 'yy/mm/dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onSelect: function (selectedDate) {
                $('#finishdate').datepicker('option', 'minDate', selectedDate);
            }
        });
        $('#finishdate').datepicker({
            dateFormat: 'yy/mm/dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+100",
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onSelect: function (selectedDate) {
                $('#startdate').datepicker('option', 'maxDate', selectedDate);
            }
        });

        $(document).ready(function () {
            $("#sms_hide_password").click(function () {
                var state = document.getElementById("sms_password").getAttribute("type");
                if (state == 'text') {
                    document.getElementById("sms_password").setAttribute("type", "password");
                } else if (state == 'password') {
                    document.getElementById("sms_password").setAttribute("type", "text");
                }
            });
            $("#ftp_hide_password").click(function () {
                var state = document.getElementById("ftp_serverpassword").getAttribute("type");
                if (state == 'text') {
                    document.getElementById("ftp_serverpassword").setAttribute("type", "password");
                } else if (state == 'password') {
                    document.getElementById("ftp_serverpassword").setAttribute("type", "text");
                }
            });
            $("#email_hide_password").click(function () {
                var state = document.getElementById("email_pass").getAttribute("type");
                if (state == 'text') {
                    document.getElementById("email_pass").setAttribute("type", "password");
                } else if (state == 'password') {
                    document.getElementById("email_pass").setAttribute("type", "text");
                }
            });
            var asset_url;
            $('#settings').submit(function (event) {

                $('#phone-group').removeClass('has-error');
                $('#company-group').removeClass('has-error');
                $('#upload-group').removeClass('has-error');
                $('#email-group').removeClass('has-error');
                $('#store-group').removeClass('has-error');
                $('#address-group').removeClass('has-error');
                $('#startdate-group').removeClass('has-error');
                $('#finishdate-group').removeClass('has-error');
                $('#ftp_servername-group').removeClass('has-error');
                    $('#ftp_serveruser-group').removeClass('has-error');
                    $('#ftp_serverpassword-group').removeClass('has-error');
                    $('#sms_username-group').removeClass('has-error');
                    $('#sms_password-group').removeClass('has-error');
                $('#email_smtp-group').removeClass('has-error');
                $('#email_pass-group').removeClass('has-error');
                $('#email_user-group').removeClass('has-error');
                $('.help-block').remove();


                var formData = {
                    'phone': $('#phone').val(),
                    'company': $('#company').val(),
                    'upload': $('#upload').val(),
                    'email': $('#email').val(),
                    'store': $('#store').val(),
                    'address': $('#address').val(),
                    'start_date': $('#startdate').val(),
                    'end_date': $('#finishdate').val(),
                    'ftp_servername':$('#ftp_servername').val(),
                    'ftp_serveruser':$('#ftp_serveruser').val(),
                    'ftp_serverpassword':$('#ftp_serverpassword').val(),
                    'sms_username':$('#sms_username').val(),
                    'sms_userpass':$('#sms_password').val(),
                    'email_smtp':$('#email_smtp').val(),
                    'email_user':$('#email_user').val(),
                    'email_pass':$('#email_pass').val()
                };


                $.ajax({
                    type: 'POST',
                    url: 'ajax/setup/settings_post.php',
                    data: formData,
                    dataType: 'json',
                    encode: true,
                    cache:false
                })
                    .done(function (data) {
                        if (!data.success) {
                            if (data.errors.phone) {
                                $('#phone-group').addClass('has-error'); // add the error class to show red input
                                $('#phone-group').append('<div class="help-block">' + data.errors.phone + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.company) {
                                $('#company-group').addClass('has-error'); // add the error class to show red input
                                $('#company-group').append('<div class="help-block">' + data.errors.company + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.upload) {
                                $('#upload-group').addClass('has-error'); // add the error class to show red input
                                $('#upload-group').append('<div class="help-block">' + data.errors.upload + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.email) {
                                $('#email-group').addClass('has-error'); // add the error class to show red input
                                $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // add the actual error message under our input
                            }

                            if (data.errors.store) {
                                $('#store-group').addClass('has-error'); // add the error class to show red input
                                $('#store-group').append('<div class="help-block">' + data.errors.store + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.address) {
                                $('#address-group').addClass('has-error'); // add the error class to show red input
                                $('#address-group').append('<div class="help-block">' + data.errors.address + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.startdate) {
                                $('#startdate-group').addClass('has-error'); // add the error class to show red input
                                $('#startdate-group').append('<div class="help-block">' + data.errors.startdate + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.finishdate) {
                                $('#finishdate-group').addClass('has-error'); // add the error class to show red input
                                $('#finishdate-group').append('<div class="help-block">' + data.errors.finishdate + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.ftp_servername) {
                                $('#ftp_servername-group').addClass('has-error'); // add the error class to show red input
                                $('#ftp_servername-group').append('<div class="help-block">' + data.errors.ftp_servername + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.ftp_serveruser) {
                                $('#ftp_serveruser-group').addClass('has-error'); // add the error class to show red input
                                $('#ftp_serveruser-group').append('<div class="help-block">' + data.errors.ftp_serveruser + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.ftp_serverpassword) {
                                $('#ftp_serverpassword-group').addClass('has-error'); // add the error class to show red input
                                $('#ftp_serverpassword-group').append('<div class="help-block">' + data.errors.ftp_serverpassword + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.sms_username) {
                                $('#sms_username-group').addClass('has-error'); // add the error class to show red input
                                $('#sms_username-group').append('<div class="help-block">' + data.errors.sms_username + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.sms_userpass) {
                                $('#sms_password-group').addClass('has-error'); // add the error class to show red input
                                $('#sms_password-group').append('<div class="help-block">' + data.errors.sms_userpass + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.email_smtp) {
                                $('#email_smtp-group').addClass('has-error'); // add the error class to show red input
                                $('#email_smtp-group').append('<div class="help-block">' + data.errors.email_smtp + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.email_user) {
                                $('#email_user-group').addClass('has-error'); // add the error class to show red input
                                $('#email_user-group').append('<div class="help-block">' + data.errors.email_user + '</div>'); // add the actual error message under our input
                            }
                            if (data.errors.email_pass) {
                                $('#email_pass-group').addClass('has-error'); // add the error class to show red input
                                $('#email_pass-group').append('<div class="help-block">' + data.errors.email_pass + '</div>'); // add the actual error message under our input
                            }
                        }
                        else {
                            /* window.open('cashier_sales_summary_get.php?start_date=' + formData.start_date + '&end_date=' + formData.end_date );*/
                            //window.location(true);
                            //alert('success');
                            $('#message_div').empty().fadeIn(1000).append('<div class="alert alert-success" ><buttton class="close" data-dismiss="alert"><i class= "fa-fw fa fa-times"></i></buttton><i class = "fa-fw fa fa-times"></i> Details saved Successfully!!!</div>').fadeOut(2000);
                            setTimeout(function () {
                                <?php $_SESSION['active'] = 1; $_SESSION['last_screen']= "dashboard.php";?>
                                location.href = '<?php echo APP_URL;?>/index.php#ajax/dashboard.php';
                            }, 3000);

                        }
                    });
                event.preventDefault();
            });
        });
    </script>

<?php
//include footer
//include("inc/google-analytics.php");
?>