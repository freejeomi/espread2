<?php
require_once("inc/init.php");
require_once("userlogcheck_admin.php");
$_SESSION['last_screen'] = "users.php";
?>
<!-- row -->
<div class="row">

</div>
<!-- end row -->

<!--
The ID "widget-grid" will start to initialize all widgets below
You do not need to use widgets if you dont want to. Simply remove
the <section></section> and you can use wells or panels instead
-->

<!-- widget grid -->
<section id="widget-grid" class="">
	<div id="password-reset-alert" class="row">

	</div>
	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<table id="jqgrid"></table>
			<div id="pjqgrid"></div>
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

	function resetPassword(_this){
		var user_id = $(_this).children('input:hidden').val();
		$.post("reset-password.php", {user_id: user_id}, function(result){
			var _success = '<div class="alert alert-success fade in" style="margin-left: 13px; margin-right: 13px;">'
				+ '<buttton class="close" data-dismiss="alert"> <i class="fa-fw fa fa-times"></i></buttton>'
				+ '<i class="fa-fw fa fa-check"></i> <strong>Success!</strong> Password reset successfully.</div>';

			var failure = '<div class="alert alert-danger fade in" style="margin-left: 13px; margin-right: 13px;">'
				+ '<buttton class="close" data-dismiss="alert"><i class="fa-fw fa fa-times"></i></buttton>'
				+ '<i class="fa-fw fa fa-times"></i><strong>Failed!</strong> Error in accomplishing task.</div>';

			if(result == 'success'){
				$("#password-reset-alert").html(_success).fadeOut(10000, "swing");
			}else{
				$("#password-reset-alert").html(failure).fadeOut(10000, "swing");
			}
		});
	}


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


	var pagefunction = function() {
		loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);
		

		function run_jqgrid_function() {
			
			//var url= "ajax/ajaxgrid.php";
			//var email = 'email';
			//var jqgrid_data;			
			//$.post(url, {email:email}, function(data) {
			//	//jqgrid_data = data;
			//	//$('#jsondata').val(data);
			//	var jqgrid_data = JSON.parse(data);
			
								
						
						
				jQuery("#jqgrid").jqGrid({
				//data : jqgrid_data,					 
				url: "ajax/security/users_grid_get.php",
				datatype: "json",
				mtype: "GET",
				height : 'auto',
				colNames : ['Actions', 'User Id', 'User Name', 'Profile', 'Reset'],
				colModel : [
					{
					name : 'act',
					index : 'act',
					sortable : false
					}, {
					
					name : 'user_id',
					index : 'user_id',
					sortable : true,
					editable:false
				}, {
					name : 'username',
					index : 'username',
					editable : true
				}, {
					name : 'role_name',
					index : 'role_name',
					//align : "right",
					sortable : true,
					editable : true,
					edittype:"select",
					editoptions:{dataUrl:"get_roles.php",cacheUrlData:true}
				}, {
						name : 'reset',
						index : 'reset'
					}],
				rowNum : 10,
				rowList : [10, 20, 30],
				pager : '#pjqgrid',
				sortname : 'user_id',
				toolbarfilter : true,
				viewrecords : true,
				sortorder : "asc",
				gridComplete : function() {
					var ids = jQuery("#jqgrid").jqGrid('getDataIDs');					
						//alert(rolenames);
						
					for (var i = 0; i < ids.length; i++) {
						var cl = ids[i];

						
						be = "<button class='btn btn-xs btn-default' data-original-title='Edit Row' onclick=\"jQuery('#jqgrid').editRow('" + cl + "');\"><i class='fa fa-pencil'></i></button>";
						se = "<button class='btn btn-xs btn-default' data-original-title='Save Row' onclick=\"jQuery('#jqgrid').saveRow('" + cl + "');\"><i class='fa fa-save'></i></button>";
						ca = "<button class='btn btn-xs btn-default' data-original-title='Cancel' onclick=\"jQuery('#jqgrid').restoreRow('" + cl + "');\"><i class='fa fa-times'></i></button>";
						//ce = "<button class='btn btn-xs btn-default' onclick=\"jQuery('#jqgrid').restoreRow('"+cl+"');\"><i class='fa fa-times'></i></button>";
						//jQuery("#jqgrid").jqGrid('setRowData',ids[i],{act:be+se+ce});
						//mp= "<p class='btn btn-sm btn-success'>Reset Password</p>";
						//_reset = "<a class='btn btn-sm btn-primary' data-original-title='Reset Password'  href= \" ajax/customer_account/customer_acct_detail.php?id=" + cl + "\" style= \" margin-right: 20px; \"><i class='fa fa-history'>Reset Password</i></a>";
						_reset = "<button class='btn btn-sm btn-default' onclick='resetPassword(this)' data-original-title='Reset Password' style= 'margin-right: 20px;'>" +
							"<span>Reset Password</span>" +
							"<input type='hidden' value=\"" + cl + "\" /></button>";

						jQuery("#jqgrid").jqGrid('setRowData', ids[i], {
							act : be + se + ca,
							reset : _reset
						});
					}
				},
				editurl : "ajax/security/users_grid_set.php",
				caption : "Users",
				multiselect : true,
				autowidth : true,

			});
			jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
				edit : false,
				add : false,
				del : true,
				search: true
			});
			jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid",{
				addParams:{
					addRowParams:{
						"keys":true,
						"oneditfunc": function () {
							$('tr.jqgrid-new-row td:last-child').children('button').hide('fast');
						}

					}
				}
			});
			/* Add tooltips */
			$('.navtable .ui-pg-button').tooltip({
				container : 'body'
			});



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

		}// end function

	}
	loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);
	

</script>
