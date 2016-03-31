<?php
session_start();
//initilize the page
require_once("inc/init.php");
if(!isset($_SESSION['active'])){
	header("location: " . APP_URL . '/logout.php');
	exit();
}

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

require('lib/util.php');
$page_title = "Change Password";
$page_css[] = "your_style.css";
$no_main_header = true;
$page_body_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");

$password1 = "";
$password2 = "";
$msgToUser = "";
$pass1 = "";
$pass2 = "";
if(isset($_POST['submit'])){
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	if(empty($_POST['password1'])){
		$pass1 = "<span style='color: red; font-size: large; font-weight: bold;'>*</span>";
	}
	if(empty($_POST['password2'])){
		$pass2 = "<span style='color: red; font-size: large; font-weight: bold;'>*</span>";
	}
	if(!empty($_POST['password1']) && !empty($_POST['password2']) ){
		if($_POST['password1'] != $_POST['password2']){
			$msgToUser = "<span style='color: red; font-weight: bold; margin-left: 30px;'>Password fields must match</span>";
		}
	}
	if( isset($_POST['password1']) && !empty($_POST['password1']) && isset($_POST['password2']) && !empty($_POST['password2'])
		&& $_POST['password1'] == $_POST['password2'] ){

		if(strtolower($_POST['password1']) != "password"){
			$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			$logged_in_user_id = $_SESSION['user_id'];
			$active = 1;
			$password1 = md5($_POST['password1']);
			//$password1 = $_POST['password1'];
			$sql = "UPDATE users SET active = '$active', password = '$password1' WHERE user_id = '$logged_in_user_id'";
			$result = mysqli_query($conn, $sql);
			if($result) {
				header("location: " . APP_URL . '/logout.php?msg=success');
				exit();
			}else{
				header("location: " . APP_URL . '/logout.php?msg=failure');
			}
			mysqli_close($conn);
		}else{
			$msgToUser = "<span style='color: red; font-weight: bold; margin-left: 30px;'>Please  enter a different password.</span>";
		}
	}
}

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

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 col-lg-offset-4">
				<div class="well no-padding">
					<form action="<?php echo APP_URL; ?>/change-password.php" id="login-form" class="smart-form client-form" method="POST">
						<header>
							Kindly Change Password to Proceed!
						</header>

						<fieldset>
							
							<section>
								<label class="label">Password <?php echo $pass1; ?></label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" name="password1" value="<?php //echo $password1;?>">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Please enter your password</b></label>
							</section>

							<section>
								<label class="label">Confirm Password <?php echo $pass2; ?></label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" name="password2"  value="<?php //echo $password2;?>">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Please confirm your password</b> </label>
								<div class="note">
									<a href="<?php echo APP_URL; ?>/logout.php">Back to Login</a>
									<?php echo $msgToUser; ?>
								</div>
							</section>
						</fieldset>
						<footer>
							<button type="submit" class="btn btn-primary" name="submit">
								Continue
							</button>
						</footer>
					</form>

				</div>
				
			</div>
		</div>
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
	runAllForms();

	$(function() {
		// Validation
		$("#login-form").validate({
			// Rules for form validation
			rules : {
				username : {
					required : true,
//					email : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				}
			},

			// Messages for form validation
			messages : {
				email : {
					required : 'Please enter your email address',
					email : 'Please enter a VALID email address'
				},
				password : {
					required : 'Please enter your password'
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>