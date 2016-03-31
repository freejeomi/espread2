<!-- PAGE FOOTER -->
<div class="page-footer">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<span class="txt-color-white"><span class="hidden-xs"> </span>
		</div>

		<div class="col-xs-6 col-sm-6 text-right hidden-xs">
			<div class="txt-color-white inline-block">
				<i class="txt-color-blueLight hidden-mobile">Logged in since <i class="fa fa-clock-o"></i> &nbsp;<strong id="login_timer">0 mins &nbsp;</strong>&nbsp;ago </i>
				<!--<div class="btn-group dropup">
					<button class="btn btn-xs dropdown-toggle bg-color-blue txt-color-white" data-toggle="dropdown">
						<i class="fa fa-link"></i> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right text-left">
						<li>
							<div class="padding-5">
								<p class="txt-color-darken font-sm no-margin">Download Progress</p>
								<div class="progress progress-micro no-margin">
									<div class="progress-bar progress-bar-success" style="width: 50%;"></div>
								</div>
							</div>
						</li>
						<li class="divider"></li>
						<li>
							<div class="padding-5">
								<p class="txt-color-darken font-sm no-margin">Server Load</p>
								<div class="progress progress-micro no-margin">
									<div class="progress-bar progress-bar-success" style="width: 20%;"></div>
								</div>
							</div>
						</li>
						<li class="divider"></li>
						<li>
							<div class="padding-5">
								<p class="txt-color-darken font-sm no-margin">Memory Load <span class="text-danger">*critical*</span></p>
								<div class="progress progress-micro no-margin">
									<div class="progress-bar progress-bar-danger" style="width: 70%;"></div>
								</div>
							</div>
						</li>
						<li class="divider"></li>
						<li>
							<div class="padding-5">
								<button class="btn btn-block btn-default">refresh</button>
							</div>
						</li>
					</ul>
				</div>-->
			</div>
		</div>
	</div>
</div>
<!-- END PAGE FOOTER -->
<script>

	function getCurrentTimeInSeconds() {
		var now = new Date();
		var hr = now.getHours();
		var min = now.getMinutes();
		var sec = now.getSeconds();
		var hr_to_seconds = hr * 60 * 60;
		var min_to_seconds = min * 60;
		var time_in_seconds = sec + min_to_seconds + hr_to_seconds;
		return time_in_seconds;
	}

	setInterval(function () {
		var login_time;
		var current_time;
		var time_spent;
		var hr;
		var min;
		var sec;
		if (localStorage.getItem("login_timer") == '') {
			time_spent = 0;
			localStorage.setItem("login_timer", getCurrentTimeInSeconds());
		} else {
			login_time = parseInt(localStorage.getItem("login_timer"));
			current_time = getCurrentTimeInSeconds();
			if (current_time > login_time) {
				time_spent = current_time - login_time;
			} else {
				time_spent = (24 * 60 * 60) - login_time + current_time;
			}
		}

		hr = Math.floor(time_spent / (1 * 60 * 60));
		min = Math.floor((time_spent - (hr * 60 * 60)) / (1 * 60));
		sec = Math.floor((time_spent - (hr * 60 * 60) - (min * 60) ) / (1));
		$("#login_timer").empty().html(hr + "h :" + min + "m :" + sec + "s");

	}, 500);
</script>