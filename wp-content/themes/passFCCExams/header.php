<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="x-ua-compatible" content="IE=edge" >
	<title><?php wp_title( ' | ', true, 'right' ); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
	<link href='https://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>	<?php wp_head(); ?>
		<link href='https://fonts.googleapis.com/css?family=Cantarell:400,700' rel='stylesheet' type='text/css'>
</head>

<div class="header1 container">
		<div class="row">
			<div class="twelve columns">
				<ul class="admin-nav">
					<li class="social-container">
						<ul class="social-icons">
							<li> <img src="/wp-content/themes/passFCCExams/assets/images/linkedin1.png"> </li>
							<li> <img src="/wp-content/themes/passFCCExams/assets/images/googleplus1.png"> </li>
							<li> <img src="/wp-content/themes/passFCCExams/assets/images/twitter1.png"> </li>
							<li> <img src="/wp-content/themes/passFCCExams/assets/images/facebook1.png"> </li>
						</ul>
					</li>
					<?php
						$current_user = wp_get_current_user();
						$current_user_name = $current_user->display_name;
						if ( is_user_logged_in() ) {
							?>
							<script>
								jQuery(function($){
									$('.welcome-msg').css('display', 'inline-block');
									$('#sidr .menu-sidebar-menu-container').css('display', 'block');
									$('#menu-admin-menu li:nth-child(1)').css('display', 'inline-block');
									$('#menu-admin-menu li:nth-child(2)').css('display', 'none');
								});
							</script>
							<?
						}
					?>
					<li class="welcome-msg">
						Welcome, <?php echo $current_user_name ?>!
					</li>
					<li>
						<?php wp_nav_menu( array( 'theme_location' => 'admin-menu') ); ?>
					</li>
				</ul>
			</div>
		</div>
</div>

<div class="header2 container">
		<div class="row">
			<div class="">	
				<div class="logo" >
					<a href="<?php echo site_url(); ?>"><img src="/wp-content/themes/passFCCExams/assets/images/logo.png"></a>
				</div>
			</div>
			<div class="twelve columns">
				<div class="menu-wrapper">
					<?php wp_nav_menu( array( 'theme_location' => 'main-menu') ); ?>
				</div>
				<div class="mobile-menu-wrapper">
					<i class="icon-menu"></i>
				</div>
			</div>
		</div>
</div>

<div id="sidr">
	<a href="" id="close-mobile-menu"> Close Menu &gt;&gt;</a>
	<?php wp_nav_menu( array( 'theme_location' => 'main-menu') ); ?>
	<?php wp_nav_menu( array( 'theme_location' => 'sidebar-menu' ) ); ?>
</div>
<body <?php body_class(); ?>>