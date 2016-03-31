<?php
require_once("inc/init.php");
require_once ("../lib/config.php");
session_destroy();
?>
<!--[if IE 9]>
	<style>
		.error-text {
			color: #333 !important;
		}
	</style>
<![endif]-->

	<!-- row -->
	<div class="row">
	<?php
	$page = "";
	if(isset( $_GET['page'])){
		$page = $_GET['page'];
	}
	?>
		<!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	
			<div class="row">
				<div class="col-sm-12">
					<div class="text-center error-box">
						<h1 class="error-text tada animated"><i class="fa fa-times-circle text-danger error-icon-shadow"></i> Error 500</h1>
						<h2 class="font-xl"><strong>Oooops, Something went wrong!</strong></h2>
						<br />
						<p class="lead semi-bold">
							<strong>You have experienced a technical error. We apologize.</strong><br><br>
							<small>
								We are working hard to correct this issue. Please wait a few moments and try your search again. <br> In the meantime, check out whats new on SmartAdmin:
							</small>
						</p>
						<ul class="error-search text-left font-md">
				            <li style="list-style: none;"><a href="/espread/login.php"><small>Go to Login Page <i class="fa fa-arrow-right"></i></small></a></li>
				        </ul>
					</div>
	
				</div>
	
			</div>
	
		</div>-->
		
	</div>
	<!-- end row -->

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

	// PAGE RELATED SCRIPTS
	
	
	// pagefunction
	
	var pagefunction = function() {
		$("#search-error").focus();
		window.location.assign("<?php echo APP_URL ?>" + "/" + "<?php if($page != "")  echo $page; else echo 'login.php';?>");
	};

	// end pagefunction
	
	// run pagefunction on load
	
	pagefunction();
	
	</script>
