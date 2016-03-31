<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

if ($_SESSION['active'] != '1') {
	header("location: login.php");
}

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC. */



/* ---------------- END PHP Custom Scripts ------------- */

//include he//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">

	</div>
	<!-- END MAIN CONTENT -->

	<div class="modal fade" style="display: none; background-color: rgba(0,0,0, 0.8);"  id="modal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"><br><br><br><br>
		<div class="modal-dialog">
			<div class="modal-content" style="background-color: rgba(0,0,0, 0); ">
                <div class="modal-header" style=" color: white;">
                    <div class="row">
                        <h1 style="text-align: center; font-weight: bold; text-shadow: 1px 1px 1px #cccccc,2px 2px 2px #cccccc,3px 3px 3px #cccccc ;">ESPREAD APP</h1>
                    </div>
                </div>
                <div class="modal-body" style="background-color: white;">
                    <form id="lock" method="POST">
                        <div class="row">
                            <div class="col-sm-8 col-md-8 col-sm-offset-2 col-md-offset-2">


                                <h1 style="text-align: center; font-weight: 500; color: black;">
                                    <img src="dist/img/lock_2.png" alt="user" height="80" width="80"><br>
                                    </i><?php echo $_SESSION["username"] ?>&nbsp;

                                </h1>
                                <small style="color: red;"><i class="fa fa-lock "></i> &nbsp;Locked</small>
                                <div class="input-group">
                                    <input class="form-control" type="password" name="password_lock"
                                           placeholder="Password" id="password_lock">

                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="submit" id='lock_submit'>
                                            <i class="fa fa-key"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="show_return_err"></div>


                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="background-color: white;">
                    <p class="no-margin " id="lock_group" style="color: black;text-align: center;">
                        Login as someone else? <a href="logout.php"> Click here</a>
                    </p>
                </div>

		    </div>
	    </div>
    </div>
    <!-- END MODAL -->
</div>
<!-- END MAIN PANEL -->

<!-- FOOTER -->
	<?php
		include("inc/footer.php");
	?>
<!-- END FOOTER -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php
	//include required scripts
	include("inc/scripts.php");
	//include footer
//	include("inc/google-analytics.php");
?>

<script src="js/activity_monitor.js"></script>
<script>

	var pass_error = '<div class="error">password is required</div>';

	/*if (localStorage.getItem("show_lock_screen") == "true") {
		var last_screen = localStorage.getItem("last_screen");
		location.href = "index.php#ajax/" + last_screen;
	}*/

	$('#lock').submit(function (event) {
        $('#lock_submit').prop("disabled", true);
		$('#lock-group').removeClass('has-error');
        $('.input-group').removeClass('has-error');
		$('.help-block').remove();
		// remove the error text
		// get the form data
		var formData = {
			'password_lock': $('#password_lock').val()
		};
		// process the form
		$.ajax({
			type: 'POST',
			url: 'lock_post.php',
			data: formData
		})
			.done(function (data) {
                $('#lock_submit').prop("disabled", false);
				if (data == "success") {
					$('input[name= password_lock]').val('');
					localStorage.setItem("show_lock_screen", "false");
					$('#modal').modal('hide');
					//var last_screen = localStorage.getItem("last_screen");
					//location.href = "index.php#ajax/" + last_screen;
				}
				else {
                    $('.input-group').addClass('has-error');
					$('#show_return_err').show().html('<div class="help-block" style="color: red;">' + data + '</div>').fadeOut(5000);
				}
			});
		event.preventDefault();
	});


</script>
