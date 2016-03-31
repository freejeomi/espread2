<?php
require_once("inc/init.php");
require_once("userlogcheck_admin.php");
$_SESSION['last_screen'] = "customer_acct_bal.php";
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
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<table id="jqgrid"></table>
			<div id="pjqgrid"></div>
			
			<br>
			
			<div id="post_result"></div>
<input type="hidden" value="" id="jsondata">
		</article>
		<!-- WIDGET END -->
		
	</div>

	<!-- end row -->

	<!-- row -->

	<div class="row">

		<!-- a blank row to get started -->
		<div class="col-sm-12">
			<!-- your contents here -->
		</div>
			
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
				url: "ajax/customer_account/customer_acct_bal_get.php",
				datatype: "json",
				mtype: "GET",
				height : 'auto',				
				colNames : ['Customer Id', 'Name of customer', 'Current Balance', 'Account Statement', 'Payment'],
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
						formatter:'currency',
					editable : false					
				},
				{
					name : 'act',
					index : 'act',
					sortable : false,
					formatter: 'showlink',
					formatoptions: {baseLinkUrl: "#ajax/", showAction: "customer_acct_detail.php", idName: "cus_Id" }
				},
				{
					name : 'act2',
					index : 'act2',
					sortable : false,
					formatter: 'showlink',
					formatoptions: {baseLinkUrl: "#ajax/", showAction: "customer_payment.php", idName: "cus_Id" }
				}				
				],
				rowNum : 10,
				rowList : [10, 20, 30],
				pager : '#pjqgrid',
				sortname : 'customer_Id',
				toolbarfilter : true,
				viewrecords : true,
				sortorder : "asc",
				
				//beforeSelectRow: function (rowid, e) {
				//	var $td = $(e.target).closest("td"),
				//    iCol = $.jgrid.getCellIndex($td[0]);
				//	if (this.p.colModel[iCol].name === 'note') {
				//	    window.location = "/ajax/customer_account/customer_acct_detail.php/" + encodeURIComponent(rowid);
				//    return false;
				//	}
				//},
				gridComplete : function() {
					var ids = jQuery("#jqgrid").jqGrid('getDataIDs');					
						//alert(rolenames);
						
					for (var i = 0; i < ids.length; i++) {
						var cl = ids[i];
						
						vs= "<p class='btn btn-sm btn-primary'>View Account Statement</p>";
						mp= "<p class='btn btn-sm btn-success'>Make payment</p>";
						v = "<a class='btn btn-sm btn-primary' data-original-title='View Account Statement'  href= \" ajax/customer_account/customer_acct_detail.php?id=" + cl + "\" style= \" margin-right: 20px; \"><i class='fa fa-history'>View statement</i></a>";
						
						m = "<a class='btn btn-sm btn-success' data-original-title='Make Payment' href= \" ajax/customer_account/customer_payment.php?id=" + cl + "\"><i class='fa fa-credit-card'>Make Payment</i></button>";
						
						//be = "<button class='btn btn-xs btn-default' data-original-title='Edit Row' onclick=\"jQuery('#jqgrid').editRow('" + cl + "');\"><i class='fa fa-pencil'></i></button>";
						//se = "<button class='btn btn-xs btn-default' data-original-title='Save Row' onclick=\"jQuery('#jqgrid').saveRow('" + cl + "');\"><i class='fa fa-save'></i></button>";
						//ca = "<button class='btn btn-xs btn-default' data-original-title='Cancel' onclick=\"jQuery('#jqgrid').restoreRow('" + cl + "');\"><i class='fa fa-times'></i></button>";
						//ce = "<button class='btn btn-xs btn-default' onclick=\"jQuery('#jqgrid').restoreRow('"+cl+"');\"><i class='fa fa-times'></i></button>";
						//jQuery("#jqgrid").jqGrid('setRowData',ids[i],{act:be+se+ce});
						jQuery("#jqgrid").jqGrid('setRowData', ids[i], {
							act : vs,
							act2: mp
						});
					}
				},
				editurl : "ajax/customer_account/customer_acct_bal_set.php",
				caption : "Customer Account Balance",
				multiselect : false,
				autowidth : true,

			});
			jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
				edit : false,
				add : false,
				del : false,
				search: true,
				view: false
			});
			//jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
			///* Add tooltips */
			//$('.navtable .ui-pg-button').tooltip({
			//	container : 'body'
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
			$(".ui-icon.ui-icon-document").removeClass().addClass("fa fa-file");
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


