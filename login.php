<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

require('lib/util.php');

$username = "";
$password = "";
$active = 0;
$user_id = "";
$role_id = "";
$role_name = "";
$menu_invoice = "";
$menu_supplier = "";
$menu_customer = "";
$menu_cashstock = "";
$menu_stock = "";
$menu_haulage = "";
$menu_setup = "";
$menu_report = "";
$acceptcustomerpayment = "";
$raisecreditinvoice = "";
$msgToUser= "";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$msg_from_change_password_page = "";

/*check for default admin and superadmin*/
$result = mysqli_query($conn, "SELECT * FROM users WHERE username = 'superadmin' LIMIT 1");
if (mysqli_num_rows($result) > 0) {
	$superadmin_role_id = 0;
	while ($row = mysqli_fetch_array($result)) {
		$superadmin_role_id = $row['role_id'];
	}
}

$result = mysqli_query($conn, "SELECT * FROM users WHERE username = 'admin' LIMIT 1");
if (mysqli_num_rows($result) < 1) {
	$password = md5('password');
	mysqli_query($conn, "INSERT INTO users (username, password, role_id)VALUES ('admin', '$password', '$superadmin_role_id')");
	$password = "";
}
/*end*/

if(isset($_GET['msg'])){
	$msg_from_change_password_page = $_GET['msg'];
}
//
if(isset($_POST['submit'])){
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	//$password = $_POST['password'];

	//$conn = mysqli_connect("127.0.0.1", "root", "", "espread");
	$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$num_of_Rows = mysqli_num_rows($result);
	//echo $num_of_Rows;
	if ($num_of_Rows > 0) {

		while ($row = mysqli_fetch_array($result)) {
			$password = $row["password"];
			$username = $row['username'];
			$active = $row['active'];
			$user_id = $row['user_id'];
			$role_id = $row['role_id'];
		}
		$sql = "SELECT * FROM roles WHERE role_id = '$role_id' LIMIT 1";
		$result = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_array($result)) {
			$role_name = $row["role_name"];
			$menu_invoice = $row['menu_invoice'];
			$menu_supplier = $row['menu_supplier'];
			$menu_customer = $row['menu_customer'];
			$menu_cashstock = $row["menu_cashstock"];
			$menu_stock = $row['menu_stock'];
			$menu_haulage = $row['menu_haulage'];
			$menu_setup = $row['menu_setup'];
			$menu_report= $row['menu_report'];
			$acceptcustomerpayment= $row['acceptcustomerpayment'];
			$raisecreditinvoice = $row['raisecreditinvoice'];
		}


		$_SESSION['user_id'] = $user_id;
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$_SESSION['active'] = $active;
		$_SESSION['role_id'] = $role_id;
		$_SESSION['role_name'] = $role_name;
		$_SESSION['menu_invoice'] = $menu_invoice;
		$_SESSION['menu_supplier'] = $menu_supplier;
		$_SESSION['menu_customer'] = $menu_customer;
		$_SESSION['menu_cashstock'] = $menu_cashstock;
		$_SESSION['menu_stock'] = $menu_stock;
		$_SESSION['menu_haulage'] = $menu_haulage;
		$_SESSION['menu_setup'] = $menu_setup;
		$_SESSION['menu_report'] = $menu_report;
		$_SESSION['acceptcustomerpayment'] = $acceptcustomerpayment;
		$_SESSION['raisecreditinvoice'] = $raisecreditinvoice;
		$_SESSION['first_screen'] = "";
		$_SESSION['last_screen'] = "";
		mysqli_close($conn);

		if($_SESSION['role_name'] == 'operator'){
			$_SESSION['first_screen'] = 'new_invoice.php';
			if($_SESSION['active'] == '1'){
				header("location: " . APP_URL . '/index.php#ajax/new_invoice.php');
				exit();
			}elseif($_SESSION['active'] == '0'){
				header("location: " . APP_URL . '/change-password.php');
				exit();
			}
		}
		if($_SESSION['role_name'] == 'manager'){
			$_SESSION['first_screen'] = 'dashboard.php';
			if($_SESSION['active'] == '1'){
				header("location: " . APP_URL . '/index.php#ajax/dashboard.php');
				exit();
			}elseif($_SESSION['active'] == '0'){
				header("location: " . APP_URL . '/change-password.php');
				exit();
			}
			//header("location: " . APP_URL . '/index.php#ajax/dashboard.php');
			//header("location: " . APP_URL . '/index.php#ajax/new_invoice.php');
		}
		if($_SESSION['role_name'] == 'invoice_tracker'){
			$_SESSION['first_screen'] = 'invoice_tracker.php';
			if($_SESSION['active'] == '1'){
				header("location: " . APP_URL . '/index.php#ajax/invoice_tracker.php');
				exit();
			}elseif($_SESSION['active'] == '0'){
				header("location: " . APP_URL . '/change-password.php');
				exit();
			}
			//header("location: " . APP_URL . '/index.php#ajax/invoice_tracker.php');
		}
		if($_SESSION['role_name'] == 'store_confirmer'){
			$_SESSION['first_screen'] = 'invoice_store_confirm.php';
			if($_SESSION['active'] == '1'){
				header("location: " . APP_URL . '/index.php#ajax/invoice_store_confirm.php');
				exit();
			}elseif($_SESSION['active'] == '0'){
				header("location: " . APP_URL . '/change-password.php');
				exit();
			}
			//header("location: " . APP_URL . '/index.php#ajax/invoice_store_confirm.php');
		}
		if($_SESSION['role_name'] == 'admin'){
			$_SESSION['first_screen'] = 'dashboard.php';
			if($_SESSION['active'] == '1'){

				$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
				if(!$conn){
					die("Connection failed: " . mysqli_connect_error());
				}

				$result = mysqli_query($conn, "SELECT * FROM settings");
				if(mysqli_num_rows($result) < 1){
					$_SESSION['active'] = '0';
					header("location: settings.php");
					mysqli_close($conn);
					exit();
				}

				header("location: " . APP_URL . '/index.php#ajax/dashboard.php');
				exit();
			}elseif($_SESSION['active'] == '0'){
				header("location: " . APP_URL . '/change-password.php');
				exit();
			}
			//header("location: " . APP_URL . '/index.php#ajax/dashboard.php');
		}


		if ($_SESSION['role_name'] == 'superadmin') {
			$_SESSION['first_screen'] = 'dashboard.php';
			if ($_SESSION['active'] == '1') {

				$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$result = mysqli_query($conn, "SELECT * FROM settings");
				if (mysqli_num_rows($result) < 1) {
					$_SESSION['active'] = '0';
					header("location: settings.php");
					mysqli_close($conn);
					exit();
				}

				header("location: " . APP_URL . '/index.php#ajax/dashboard.php');
				exit();
			} elseif ($_SESSION['active'] == '0') {
				header("location: " . APP_URL . '/change-password.php');
				exit();
			}
			//header("location: " . APP_URL . '/index.php#ajax/dashboard.php');
		}
		//http://localhost/espread/index.php#ajax/dashboard.php
		//header("location: " . APP_URL . '/index.php#ajax/dashboard.php');
		//header("location:" . APP_URL . "/index.php");
	}
	else{
		mysqli_close($conn);
		$msgToUser= 'Login failed. Username or Password not recognized';
	}
}
/* Login processing ends */


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Login";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_body_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");
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
				<br/><br/>
				<div class="well no-padding">
					<form action="<?php echo APP_URL; ?>/login.php" id="login-form" class="smart-form client-form" method="POST">
						<header>
							<?php
								if($msg_from_change_password_page != ""){
									if($msg_from_change_password_page == 'success'){
										echo "<span style='color: orange; font-weight: normal;'>Login with your new password</span>";
									}elseif($msg_from_change_password_page == 'failure'){
										echo "<span style='color: red; font-weight: bold;'>Password change failed. Try again!</span>";
									}
								}
								elseif ($msgToUser != ""){
									echo "<span style='font-size: 13px; color: red; font-weight: bold;'>". $msgToUser. "</span>";
								}
								else{
									echo "Login Portal";
								}
							?>
						</header>

						<fieldset>
							
							<section>
								<label class="label">Username</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="text" name="username">
									<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter your username</b></label>
							</section>

							<section>
								<label class="label">Password</label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" name="password">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Please enter your password</b> </label>
								<div class="note">
									<!--<a href="<?php //echo APP_URL; ?>/forgotpassword.php">Forgot password?</a>-->
								</div>
							</section>

							<!--<section>
								<label class="checkbox">
									<input type="checkbox" name="remember" checked="">
									<i></i>Keep me logged in</label>
							</section>-->
						</fieldset>
						<footer>
							<button type="submit" class="btn btn-primary" name="submit">
								Log in
							</button>
						</footer>
					</form>

				</div>
				
<!--				<h5 class="text-center"> - Or sign in using -</h5>-->
<!--													-->
<!--								<ul class="list-inline text-center">-->
<!--									<li>-->
<!--										<a href="javascript:void(0);" class="btn btn-primary btn-circle"><i class="fa fa-facebook"></i></a>-->
<!--									</li>-->
<!--									<li>-->
<!--										<a href="javascript:void(0);" class="btn btn-info btn-circle"><i class="fa fa-twitter"></i></a>-->
<!--									</li>-->
<!--									<li>-->
<!--										<a href="javascript:void(0);" class="btn btn-warning btn-circle"><i class="fa fa-linkedin"></i></a>-->
<!--									</li>-->
<!--								</ul>-->
				
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
	localStorage.setItem("show_lock_screen", "");
	runAllForms();

	$(function() {
		// Validation
		$("#login-form").validate({
			// Rules for form validation
			rules : {
				username : {
					required : true
					//email : true
				},
				text : {
					required: true
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
				text : {
					required : 'Please enter your username'
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
	<script>
		localStorage.setItem("login_timer", "");

        //localStorage.setItem("monitor_login", "1");
	</script>
    <script src="js/activity_monitor.js"></script>
<script>
    //localStorage.setItem("monitor_login", "0");
</script>

<?php 
	//include footer
	//include("inc/google-analytics.php");
?>