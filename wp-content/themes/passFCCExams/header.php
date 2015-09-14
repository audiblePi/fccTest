<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="x-ua-compatible" content="IE=edge" >
	<title><?php wp_title( ' | ', true, 'right' ); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
	<?php wp_head(); ?>
</head>

<div class="header1">
	<div class="container">
		<div class="row">
			<div class="twelve columns">
				<ul class="admin-nav">
					<?php
						$current_user = wp_get_current_user();
						$current_user_name = $current_user->display_name;
						if ( is_user_logged_in() ) {
							?>
							<script>
								jQuery(function($){
									$('.welcome-msg').css('display', 'inline-block');	
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
</div>

<div class="header2">
	<div class="container">
		<div class="row">
			<div class="three columns">	
				<div class="logo" >
					<a href="<?php echo site_url(); ?>"><img src="/wp-content/themes/passFCCExams/assets/images/logo.png"></a>
				</div>
			</div>
			<div class="nine columns">
				<div class="menu-wrapper">
					<?php wp_nav_menu( array( 'theme_location' => 'main-menu') ); ?>
				</div>
				<div class="mobile-menu-wrapper">
					<?php #wp_nav_menu( array( 'theme_location' => 'main-menu') ); ?>
					<i class="icon-menu"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<body <?php body_class(); ?>>