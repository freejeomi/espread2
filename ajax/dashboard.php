<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");
$_SESSION['last_screen']= "dashboard.php";
?>
<!--
	The ID "widget-grid" will start to initialize all widgets below 
	You do not need to use widgets if you dont want to. Simply remove 
	the <section></section> and you can use wells or panels instead 
	-->

<!-- widget grid -->
<section id="widget-grid" class="">
	<div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Sales</span>
                  <span class="info-box-number" id="acct_sales">0.00</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 70%" id="progress_bar_sales"></div>
                  </div>
                  <span class="progress-description" id="acct_sales_text">
                    <span id="acct_sales2">70</span>% Increase
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-plus"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Purchases</span>
                  <span class="info-box-number" id="acct_purchase">0.00</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 70%" id="progress_bar_purchase"></div>
                  </div>
                  <span class="progress-description" id="acct_purchase_text">
                    <span id="acct_purchase2">70</span>% Increase
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-minus"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Expenses</span>
                  <span class="info-box-number" id="acct_expense">0.00</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 70%" id="progress_bar_expense"></div>
                  </div>
                  <span class="progress-description" id="acct_expense_text">
                    <span id="acct_expense2">70</span>% Increase
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box bg-green">
                <span class="info-box-icon"><b class="">&#8358;</b></span>
                <div class="info-box-content">
                  <span class="info-box-text">Profit/Loss</span>
                  <span class="info-box-number" id="acct_profit">0.00</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 70%" id="progress_bar_profit"></div>
                  </div>
                  <span class="progress-description" id="acct_profit_text">
                    <span id="acct_profit2">70</span>% Increase
                  </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
	
	
	<div class="row">
		<article class="col-sm-12">
			<!-- new widget -->
			<div class="jarviswidget jarviswidget-color-oceanBlue" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
				<!-- widget options:
				usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
-
				data-widget-colorbutton="false"
				data-widget-editbutton="false"
				data-widget-togglebutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="false"
				data-widget-custombutton="false"
				data-widget-collapsed="true"
				data-widget-sortable="false"

				-->
				<header>
					<span class="widget-icon"> <i class="glyphicon glyphicon-stats txt-color-darken"></i> </span>
					<h2>Live Feeds </h2>

					<ul class="nav nav-tabs pull-right in" id="myTab">
						<li class="active">
							<a data-toggle="tab" href="#s1"><i class="fa fa-clock-o"></i> <span class="hidden-mobile hidden-tablet">Daily</span></a>
						</li>

						<li>
							<a data-toggle="tab" href="#s2"><i class="fa fa-clock-o"></i> <span class="hidden-mobile hidden-tablet">Weekly</span></a>
						</li>

						<li>
							<a data-toggle="tab" href="#s3"><i class="fa fa-clock-o"></i> <span class="hidden-mobile hidden-tablet">Monthly</span></a>
						</li>
					</ul>

				</header>

				<!-- widget div-->
				<div class="no-padding">
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">

					</div>
					<!-- end widget edit box -->

					<div class="widget-body">
						<!-- content -->
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane fade active in padding-10 no-padding-bottom" id="s1">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                        <div class="row " style="background-color: rgb(250, 250, 250) ;  border: none; margin: inherit; margin-top: 5px; padding-bottom: 5px;">
                                            <div class="col-sm-4"
                                                 style="padding-top: 10px; border-right: 3px solid white;">
                                                <a href="#ajax/daily_sales_ledger.php"><h5><span style="font-size: 1.0em;">Pending Invoices</span>
											 <span class="" style="font-size: 1.0em; color: darkgrey;"><i
                                                     class="fa fa-shopping-cart">
                                                 </i></span><span class="pull-right"><b class="badge" id="pend" style="background-color: green; color: white;">0 </b></span>
                                                    </h5></a>
                                            </div>
                                            <div class="col-sm-4" style="padding-top: 10px; border-right: 3px solid white;">
                                                <a href="#ajax/debtors.php">
                                                <h5><span style="font-size: 1.0em;">Customer Debts</span>
                                                <span class="" style="font-size: 1.0em; color: darkgrey;"><i class="fa fa-arrow-circle-up"></i></span>
                                                <span class="pull-right"><b  class="badge" id="debt" style="background-color: green; color: white;"><i>&#8358;</i>0.00 </b></span></h5></a>
                                            </div>

                                            <div class="col-sm-4" style="margin-top: 10px;">
                                                <a href="#ajax/ajax_manage_reorder.php" target=""><h5><span style="font-size: 1.0em;"> Re-order alert</span><span class="" style="font-size: 1em;color: darkgrey;"><i class="fa fa-bell"></i></span> <span class="pull-right "><b id="blinker" class="badge" style="background-color: grey; color: white;">0 </b></span>
                                                    </h5></a>
                                            </div>
                                        </div>
										<div class="table-responsive" style="padding-top:2px; padding-bottom:15px;">
							<table class="table  table-hover" style="font-size: 16px;">
								<tbody>
                                <tr style="height: 40px; background-color: rgb(240, 240, 240);">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
									<tr >
										<td>Total sales</td>
										<td id="t_sales">0.00</td>
										<td>Cash stock opening balance</td>
										<td id="opening_bal">0.00</td>
									</tr>
									<tr >
										<td>Supplier Payments</td>
										<td id="supplier_total">0.00</td>
										<td>Cash In</td>
										<td id="cash_in">0.00</td>
									</tr>
									<tr>
										<td>Other expenses</td>
										<td id="expenses_total">0.00</td>
										<td>Cash Out</td>
										<td id="cash_out">0.00</td>
									</tr>
									<tr >
										<td></td>
										<td></td>
										<td>Balance</td>
										<td id="balance">0.00</td>
									</tr>
                                <tr style="height: 44px; background-color: rgb(240, 240, 240);">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
								</tbody>
							</table>
						</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 show-stats">
							<div class="row" id="wid-id-1">
								<div id="my-calendar" class="col-xs-6 col-sm-6 col-md-12 col-lg-12 "></div>
							</div>
						</div>
						</div>
						</div>
							<!-- end s1 tab pane -->
						<div class="tab-pane fade" id="s2">
<!--						WEEKLY HEADER TO DISPLAY-->
							<div class="row">
								<div class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12">
									<table id="daily_table" class="table table-hover table-bordered">
										<thead>
										<tr>

											<th colspan="7" id="week_current" style="text-align: center;"></th>

										</tr>
										<tr id="week_header" >

										</tr>
										</thead>
										<tbody id="week_val"></tbody>
									</table>
								</div>
							</div>
								<div class="padding-10 row">
								<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
									<div id="weekly_graph" class="has-legend-unique" style="width: 100%;height: 260px;"></div>
								</div>
								</div>
						</div>

							<!-- end s2 tab pane -->

							<div class="tab-pane fade" id="s3">

<!--								<div class="widget-body-toolbar bg-color-white form-inline" id="rev-toggles">-->
<!--									<div class="form-group col-sm-6">-->
<!--										<label class="control-label col-md-3" for="">Select year to view</label>-->
<!--										<div class="col-md-9" id="store-group">-->
<!--											<div class="icon-addon addon-sm">-->
<!--												<select id="year_picked" class="form-control">-->
<!--													--><?php
//													$opt="";
//													for ($i = 2000; $i <= date('Y'); $i++) {
//														if ($i == date('Y')) {
//														$opt.= "<option value='$i' selected='selected'>$i</option>";
//														}
//														else {
//															$opt .= "<option value='$i'>$i</option>";
//														}
//													}
//													echo $opt;
//													?>
<!--												</select>-->
<!--											</div>-->
<!--										</div>-->
<!--									</div>-->
<!--									</div>-->
								<div class="row">
									<div class="table-responsive col-md-12 col-lg-12 col-xs-12 col-sm-12">
										<table id="weekly_table" class="table table-hover table-bordered" >
										<thead>
											<tr>
												<th id="year_previous">
													<button class="btn btn-default btn-xs" id="btn_prev"> <<</button>
												</th>
												<th colspan="10" id="year_current" style="text-align: center;"></th>
												<th id="year_next">
													<button class="btn btn-default btn-xs pull-right" id="btn_next" type="button"> >></button>
												</th>
											</tr>
											<tr>
												<th>Jan</th>
												<th>Feb</th>
												<th>Mar</th>
												<th>Apr</th>
												<th>May</th>
												<th>Jun</th>
												<th>Jul</th>
												<th>Aug</th>
												<th>Sept</th>
												<th>Oct</th>
												<th>Nov</th>
												<th>Dec</th>
											</tr>
										</thead>
										<tbody id="year_val"></tbody>
										</table>
									</div>
								</div>

								<div class="padding-10 row">
								<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
									<div id="monthly_graph" class="has-legend-unique" style="width: 100%;height: 260px;"></div>
								</div>
								</div>
							</div>

					<!-- end content -->
					</div>
				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->
		</article>
	</div>
	<div class="row">

	</div>

	
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
	var flot_updating_chart, flot_statsChart, flot_multigraph;
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
		function getTooltip(label, x, y) {
			return "Your sales for " + x + " was &#8358;" + numberWithCommas(y);
		}
		function numberWithCommas(x) {
			return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}


//GRAPH AND MONTHTLY TABLE TO SHOW WHEN DOCUMENT LOAD
		$('document').ready(function () {
			var year_obj = new Date();
			var current_year = year_obj.getFullYear();
			var year_select = current_year;
			$('#year_current').empty().text(current_year);
			var year_display = $('#year_current').text();

			if (year_display == current_year) {
				$('#btn_next').prop('disabled', true);
				//$('#btn_next').attr('disabled', 'disabled');
			}
			else {
				$('#btn_next').prop('disabled', false);
			}
			$.get("ajax/dashboard_summary.php?year_val=" + year_select, function (response, status) {
				//alert (response);
				var data3 = JSON.parse(response);
				//alert(data3);
				$(function () {
					// jQuery Flot Chart
					var form = [{
						//label: "Weekly Sales",
						data: data3,
						bars: {
							show: true,
							barWidth: 0.6,
							align: "center"
						}
					}];

					var options = {
						grid: {
							hoverable: true
						},
						colors: ["#A84040"],
						tooltip: true,
						tooltipOpts: {
							content: getTooltip,
							defaultTheme: false
						},
						xaxis: {
							mode: "categories",
							tickLength: 0
							//tickDecimals: 0
						},
						yaxis: {min: 0},
						selection: {
							mode: "x"
						}
					};

					flot_statsChart = $.plot($("#monthly_graph"), form, options);
				});
				var data = response.split(',');
				var year_value = "<tr>";
				var result;
				for (i = 0; i < data.length; i++) {
					i = i + 1;
					if (i < data.length - 1) {
						result = data[i].substring(0, data[i].length - 1);
						result = stripEndQuotes(result);

						//result.replace(/"/g, '');
						year_value = year_value + "<td>" + numberWithCommas(result) + "</td>";

					}
					else {
						result = data[i].substring(0, data[i].length - 2);
						result = stripEndQuotes(result);
						//result.replace(/"/g, '');
						year_value = year_value + "<td>" + numberWithCommas(result) + "</td>";
					}

				}
				year_value = year_value + "</tr>";
				$('#year_val').empty().html(year_value);
				//var table_data= jQuery.parseJSON(response);
				//alert (table_data);
			});
		});


//===================================================================================================//

		var date1;
		var date2;

		//function used by the calender for weekly tab
		function weekpick(date) {
			var d = new Date(date);
			var d1 = new Date(date);
			var index = d.getDay();

			// console.log(index)
			if (index == 0) {
				d.setDate(d.getDate());
				d1.setDate(d1.getDate() + 6);
			}
			else if (index == 1) {
				d.setDate(d.getDate() - 1);
				d1.setDate(d1.getDate() + 5);
			}
			else if (index != 1 && index > 0) {
				d.setDate(d.getDate() - index);
				console.log(d.getDate());
				//alert(index);
				d1.setDate(d1.getDate() + 6);///(index + 6));

				if (d.getDate() + 6 > 31) {
					d1.setDate(0 + 6);
				} else {
					d1.setDate(d.getDate() + 6);
				}
				//date.setdate(date.getdate + 7);
				//console.log(d.getDate() - (index - 1))
			}
			date1 = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
			date2 = d1.getFullYear() + '-' + (d1.getMonth() + 1) + '-' + d1.getDate();

			console.log("start date::" + date1);
			console.log("End date::" + date2);
		}

//get the current date and change it to the first and last date
		var utc = new Date().toJSON().slice(0, 10);
		weekpick(utc);
		$.get("ajax/dashboard_summary.php?week_date1=" + date1 + "&week_date2=" + date2, function (data, status) {
			var data2 = JSON.parse(data);
			$(function () {
				// jQuery Flot Chart
				var form = [{
					label: "Weekly Sales",
					data: data2,
					lines: {
						show: true,
						lineWidth: 0.5,
						fill: true,
						fillColor: {
							colors: [{
								opacity: 0.1
							}, {
								opacity: 0.13
							}]
						}
					},
					points: {
						show: true
					}
				}];

				var options = {
					grid: {
						hoverable: true
					},
					colors: ["#568A89", "#3276B1"],
					tooltip: true,
					tooltipOpts: {
						content: getTooltip,
						defaultTheme: false
					},
					xaxis: {
						mode: "categories",
						tickLength: 0
						//tickDecimals: 0
					},
					yaxis: {min: 0},
					selection: {
						mode: "x"
					}
				};

				flot_statsChart = $.plot($("#weekly_graph"), form, options);
			});
			//end of flot chart

			//START THE WEEK CHANGE
			var array_week=data2;
			var week_header="";
			var week_value="<tr class='text-center'>";
			//alert(array_week);
			for(var i=0;i<array_week.length;i++){

				console.log(array_week[i]);
				week_header+= "<th class='text-center'>"+ array_week[i][0]+"</th>";
				week_value+="<td>"+numberWithCommas(array_week[i][1])+"</td>";
			}
			week_value+="</tr>";
			$('#week_header').empty().html(week_header);
			$('#week_val').empty().html(week_value);
		});

//WHEN THE CALENDAR LOADS AND WHEN IT CHANGES
		$(document).ready(function () {
			//$("#my-calendar").zabuto_calendar({language: "en"});
			localStorage.setItem("prev_clicked_id", "");
			$("#my-calendar").zabuto_calendar({
				action: function () {
					var id = "#" + this.id;
					var date = $(id).data("date");
					weekpick(date);
					//var date_array = date.split("-");
					if (localStorage.getItem("prev_clicked_id") != "") {
						var prev_clicked_id = localStorage.getItem("prev_clicked_id");
						$(prev_clicked_id).css("background-color", "");
					}
					localStorage.setItem("prev_clicked_id", id);
					$(id).css("background-color", "silver");
					//alert(date);
					$.ajax({
						type: 'POST',
						url: 'ajax/dashboard_summary.php',
						data: {date_request: date},
						dataType: 'json',
						encode: true
					})
						.done(function (data) {
							if (data.success) {
								//alert ("success");
								$('#t_sales').empty().text(data.sales);
								$('#supplier_total').empty().text(data.supply);
								$('#expenses_total').empty().text(data.expenses);
								$('#opening_bal').empty().text(data.opbalance);
								$('#cash_in').empty().text(data.cash_in);
								$('#cash_out').empty().text(data.cash_out);
								$('#balance').empty().text(data.total_balance);
							}
						});

					//get code for weekly graph flot chart tab 2
					$.get("ajax/dashboard_summary.php?week_date1=" + date1 + "&week_date2=" + date2, function (data, status) {
					var data2=JSON.parse(data);
						$(function () {
							// jQuery Flot Chart
							var form = [{
								label: "Weekly Sales",
								data: data2,
								lines: {
									show: true,
									lineWidth: 0.5,
									fill: true,
									fillColor: {
										colors: [{
											opacity: 0.1
										}, {
											opacity: 0.13
										}]
									}
								},
								points: {
									show: true
								}
							}];

							var options = {
								grid: {
									hoverable: true
								},
								colors: ["#568A89", "#3276B1"],
								tooltip: true,
								tooltipOpts: {
									content: getTooltip,
									defaultTheme: false
								},
								xaxis: {
									mode: "categories",
									tickLength: 0
									//tickDecimals: 0
								},
								yaxis: {min: 0},
								selection: {
									mode: "x"
								}
							};

							flot_statsChart = $.plot($("#weekly_graph"), form, options);
						});
//						CHANGE THE WEEK TABLE
						var array_week = data2;
						var week_header = "";
						var week_value = "<tr class='text-center'>";
						//alert(array_week);
						for (var i = 0; i < array_week.length; i++) {

							console.log(array_week[i]);
							week_header += "<th class='text-center'>" + array_week[i][0] + "</th>";
							week_value += "<td>" + numberWithCommas(array_week[i][1]) + "</td>";
						}
						week_value += "</tr>";
						$('#week_header').empty().html(week_header);
						$('#week_val').empty().html(week_value);
						//end of flot chart
					});
					//end of get
				},
				//end of action property in zabuto
				today: true
			});
			//end of zabuto
		});
		//end of document . ready
	};
	//end of pagefunction
	
	// run pagefunction

	// load all flot plugins
	loadScript("js/plugin/flot/jquery.flot.cust.min.js", function () {
		loadScript("js/plugin/flot/jquery.flot.resize.min.js", function () {
			loadScript("js/plugin/flot/jquery.flot.time.min.js", function () {
				loadScript("js/plugin/flot/jquery.flot.categories.min.js", function () {
					loadScript("js/plugin/flot/jquery.flot.tooltip.min.js", pagefunction);
				});
			});
		});
	});

</script>



<script type="application/javascript">
	function getTooltip(label, x, y) {
		return "Your sales for " + x + " was &#8358;" + y;
	}
	$('document').ready(function () {
		var date = "<?php echo date('Y-m-d');?>";
		$.ajax({
			type: 'POST',
			url: 'ajax/dashboard_summary.php',
			data: {date_request: date},
			dataType: 'json',
			encode: true
		})
		.done(function (data) {
			if (data.success) {
				//alert ("success");
				$('#t_sales').empty().text(data.sales);
				$('#supplier_total').empty().text(data.supply);
				$('#expenses_total').empty().text(data.expenses);
				$('#opening_bal').empty().text(data.opbalance);
				$('#cash_in').empty().text(data.cash_in);
				$('#cash_out').empty().text(data.cash_out);
				$('#balance').empty().text(data.total_balance);
			}
		});
	});

	$(document).ready(function() {
		var check_acct= "check";
		$.ajax({
			type: 'POST',
			url: 'ajax/dashboard_summary.php',
			data: {year_summary: check_acct},
			dataType: 'json',
			encode: true
		})
			.done(function (data) {
				if (data.success) {
					//alert ("success");
					$('#acct_sales').empty().text(data.sales_total_acct);
					$('#acct_purchase').empty().text(data.purchase_total_acct);
					$('#acct_expense').empty().text(data.expense_total_acct);
					$('#acct_profit').empty().text(data.profit);

					if(data.sales_total_acct_prev == "nothing") {
						$('#progress_bar_sales').hide();
						$('#acct_sales_text').hide();
					}
					else {
						$('#progress_bar_sales').show();
						$('#acct_sales_text').show();
						$('#acct_sales2').empty().text(data.sales_total_acct_prev);
					}

					if(data.purchase_total_acct_prev == "nothing") {
						$('#progress_bar_purchase').hide();
						$('#acct_purchase_text').hide();
					}
					else {
						$('#progress_bar_purchase').show();
						$('#acct_purchase_text').show();
						$('#acct_purchase2').empty().text(data.purchase_total_acct_prev);
					}

					if (data.expense_total_acct_prev == "nothing") {
						$('#progress_bar_expense').hide();
						$('#acct_expense_text').hide();
					}
					else {
						$('#progress_bar_expense').show();
						$('#acct_expense_text').show();
						$('#acct_expense2').empty().text(data.expense_total_acct_prev);
					}

					if (data.profit_prev== "nothing") {
						$('#progress_bar_profit').hide();
						$('#acct_profit_text').hide();
					}
					else {
						$('#progress_bar_profit').show();
						$('#acct_profit_text').show();
						$('#acct_profit2').empty().text(data.profit_prev);
					}
				}
			});
	});

	setInterval(function () {
	var alert= "alert";
			$.get("ajax/stock_inventory/alert_reorderlevel_post.php?alert=" +alert, function (data, status) {
				//alert(data);
				if (data == 'false') {
					$("#blinker").css("background-color", "green");
				} else {
				var returned_data= data;
				//alert(returned_data);
					var stock_num = returned_data.substr(4,returned_data.length);
					//alert (stock_num);
					$("#blinker").text(stock_num).css({"background-color": "red", "color": "white" });
					setTimeout(function () {
						$("#blinker").fadeToggle();
					}, 500);
				}
			});

			var pend = "pending";
			$.get("ajax/stock_inventory/alert_reorderlevel_post.php?task=" + pend, function (data, status) {
				//alert(data);
				if (data == 'false') {
					$("#pend").css("background-color", "green");
				} else {
					var returned_data = data;
					//alert(returned_data);
					var stock_num = returned_data.substr(4, returned_data.length);
					//alert (stock_num);
					$("#pend").text(stock_num).css({"background-color": "red", "color": "white"});
//                setTimeout(function () {
//                    $("#pend").fadeToggle();
//                }, 500);
				}
			});

			var debt = "check";
			$.get("ajax/stock_inventory/alert_reorderlevel_post.php?task=" + debt, function (data, status) {
				//alert(data);
				if (data == 'false') {
					$("#debt").css("background-color", "green");
				} else {
					var returned_data = data;
					//alert(returned_data);
					var stock_num = returned_data.substr(4, returned_data.length);
					//alert (stock_num);
					//$("debt_color").css({"background-color": "red", "color": "white"});
					$("#debt").text(stock_num).css({"background-color": "red", "color": "white"});
				}
			});
		}, 500);

</script>

<script>
//code to load the year summary on the table for tab 3
function getTooltip(label, x, y) {
	return "Your sales for " + x + " was &#8358;" + y;
}
function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


//STRIPS THE QUOTATION MARK OFF
function stripEndQuotes(s) {
	var t = s.length;
	if (s.charAt(0) == '"') s = s.substring(1, t--);
	if (s.charAt(--t) == '"') s = s.substring(0, t);
	return s;
}
//script for clicking previous button for monthly table
$('#btn_prev').click(function() {
	var year_obj = new Date();
	var current = year_obj.getFullYear();


	var current_year= $('#year_current').text();
	var d = new Date(current_year);
	d.setFullYear(d.getFullYear() - 1);
	var year_select = d.getFullYear();
	//alert(year_select);
	$('#year_current').empty().text(year_select);

	var year_display = $('#year_current').text();
	// CHECK IF THE YEAR IS EQUAL TO OR GREATER THAN THE CURRENT YEAR
	if (year_display == current) {
		$('#btn_next').prop('disabled', true);
		//$('#btn_next').attr('disabled', 'disabled');
	}
	else {
		$('#btn_next').prop('disabled', false);
	}

	$.get("ajax/dashboard_summary.php?year_val=" + year_select, function (response, status) {
	// MONTHLY GRAPH TO DISPLAY

		var data3 = JSON.parse(response);
		//alert(data3);
		$(function () {
			// jQuery Flot Chart
			var form = [{
				//label: "Weekly Sales",
				data: data3,
				bars: {
					show: true,
					barWidth: 0.6,
					align: "center"
				}
			}];

			var options = {
				grid: {
					hoverable: true
				},
				colors: ["#A84040"],
				tooltip: true,
				tooltipOpts: {
					content: getTooltip,
					defaultTheme: false
				},
				xaxis: {
					mode: "categories",
					tickLength: 0
					//tickDecimals: 0
				},
				yaxis: {min: 0},
				selection: {
					mode: "x"
				}
			};

			flot_statsChart = $.plot($("#monthly_graph"), form, options);
		});

		//alert (response);
		var data = response.split(',');
		var year_value = "<tr>";
		var result;
		for (i = 0; i < data.length; i++) {
			i = i + 1;
			if (i < data.length - 1) {
				result = data[i].substring(0, data[i].length - 1);
				result = stripEndQuotes(result);

				//result.replace(/"/g, '');
				year_value = year_value + "<td>" + numberWithCommas(result) + "</td>";

			}
			else {
				result = data[i].substring(0, data[i].length - 2);
				result = stripEndQuotes(result);
				//result.replace(/"/g, '');
				year_value = year_value + "<td>" + numberWithCommas(result) + "</td>";
			}

		}
		year_value = year_value + "</tr>";
		$('#year_val').empty().html(year_value);
		//var table_data= jQuery.parseJSON(response);
		//alert (table_data);
	});
})
$('#btn_next').click(function () {
	var year_obj = new Date();
	var current = year_obj.getFullYear();

	var current_year = $('#year_current').text();

	var d = new Date(current_year);
	d.setFullYear(d.getFullYear() + 1);
	var year_select = d.getFullYear();

	//alert(year_select);

	$('#year_current').empty().text(year_select);
	var year_display= $('#year_current').text();
	if (year_display == current) {
		$('#btn_next').prop('disabled', true);
		//$('#btn_next').attr('disabled', 'disabled');
	}
	else {
		$('#btn_next').prop('disabled', false);
	}
	$.get("ajax/dashboard_summary.php?year_val=" + year_select, function (response, status) {
	//MONTHLY GRAPH TO DISPLAY

		var data3 = JSON.parse(response);
		//alert(data3);
		$(function () {
			// jQuery Flot Chart
			var form = [{
				//label: "Weekly Sales",
				data: data3,
				bars: {
					show: true,
					barWidth: 0.6,
					align: "center"
				}
			}];

			var options = {
				grid: {
					hoverable: true
				},
				colors: ["#A84040"],
				tooltip: true,
				tooltipOpts: {
					content: getTooltip,
					defaultTheme: false
				},
				xaxis: {
					mode: "categories",
					tickLength: 0
					//tickDecimals: 0
				},
				yaxis: {min: 0},
				selection: {
					mode: "x"
				}
			};

			flot_statsChart = $.plot($("#monthly_graph"), form, options);
		});

		//alert (response);
		var data = response.split(',');
		var year_value = "<tr>";
		var result;
		for (i = 0; i < data.length; i++) {
			i = i + 1;
			if (i < data.length - 1) {
				result = data[i].substring(0, data[i].length - 1);
				result = stripEndQuotes(result);

				//result.replace(/"/g, '');
				year_value = year_value + "<td>" + numberWithCommas(result) + "</td>";

			}
			else {
				result = data[i].substring(0, data[i].length - 2);
				result = stripEndQuotes(result);
				//result.replace(/"/g, '');
				year_value = year_value + "<td>" + numberWithCommas(result) + "</td>";
			}

		}
		year_value = year_value + "</tr>";
		$('#year_val').empty().html(year_value);
		//var table_data= jQuery.parseJSON(response);
		//alert (table_data);
	});
})
</script>