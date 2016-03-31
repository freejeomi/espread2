<!DOCTYPE html>
<html lang="en-us" <?php echo implode(' ', array_map(function($prop, $value) {
			return $prop.'="'.$value.'"';
		}, array_keys($page_html_prop), $page_html_prop)) ;?>>
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> <?php echo $page_title != "" ? $page_title." - " : ""; ?>SmartAdmin </title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/font-awesome.min.css">
		
		<!--<link rel="stylesheet" type="text/css" media="screen" href="<?//php echo ASSETS_URL; ?>/css/bootstrap-datepicker.css">-->
		<link rel="stylesheet" type="text/css" media="screen" href= "<?php echo ASSETS_URL; ?>/css/zabuto_calendar.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/your_style.css">
		<!--										-->
		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support is under construction-->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-rtl.min.css">
<!--		<link rel="stylesheet" type="text/css" media="screen" href="--><?php //echo ASSETS_URL; ?><!--/css/week-picker-view.css">-->
		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
			 <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/your_style.css"> -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-skin-non-minified.css">

		<?php

			if ($page_css) {
				foreach ($page_css as $css) {
					echo '<link rel="stylesheet" type="text/css" media="screen" href="'.ASSETS_URL.'/css/'.$css.'">';
				}
			}
		?>


		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<!--<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/demo.min.css">-->

		<!-- FAVICONS -->
		<link rel="shortcut icon" href="<?php echo ASSETS_URL; ?>/img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo ASSETS_URL; ?>/img/favicon/favicon.ico" type="image/x-icon">

		<!-- GOOGLE FONT -->
<!--		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">-->

		<!-- Specifying a Webpage Icon for Web Clip
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="<?php echo ASSETS_URL; ?>/img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-ipad-retina.png">

		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

    <!-- Font Awesome -->
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
    <!-- Ionicons -->
<!--    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->


    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapi.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css">
		<!-- Required Stylesheets -->
	</head>
	<body class="menu-on-top" <?php echo implode(' ', array_map(function($prop, $value) {
			return $prop.'="'.$value.'"';
		}, array_keys($page_body_prop), $page_body_prop)) ;?>>
		<!-- POSSIBLE CLASSES: minified, fixed-ribbon, fixed-header, fixed-width
			 You can also add different skin classes such as "smart-skin-1", "smart-skin-2" etc...-->
		<?php
			if (!$no_main_header) {

		?>

		<?php
			}
		?>