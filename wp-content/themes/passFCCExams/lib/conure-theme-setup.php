<?php

/*This file is used for setting up WP Core theme options*/

/*Enqueue Scripts*/
function conure_load_scripts(){
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'bxslidercss', get_template_directory_uri() . '/assets/js/jquery.bxslider/jquery.bxslider.css' );
	wp_enqueue_script( 'bxsliderjs', get_template_directory_uri() . '/assets/js/jquery.bxslider/jquery.bxslider.js' );
	wp_enqueue_style( 'concrete', get_template_directory_uri() . '/assets/css/concrete/concrete.css' );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.js' );
	wp_enqueue_style( 'whgg', get_template_directory_uri() . '/assets/css/whhg.css' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() .'/assets/bootstrap/js/bootstrap.min.js' );
	wp_enqueue_style( 'bootstrapcss', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css' );
}

function conure_title( $title ){
	if ( $title == '' ) {
		return '&rarr;';
	} else {
		return $title;
	}
}

/*Append Blog Name to Page Title*/
function conure_filter_wp_title( $title ){
	return $title . esc_attr( get_bloginfo( 'name' ) );
}

/*Setup Widgets*/
function conure_widgets_init(){
	register_sidebar( array (
	                 'name' => __( 'Sidebar 1', 'conure' ),
	                 'id' => 'primary-widget-area-1',
	                 'before_widget' => '',
	                 'after_widget' => "",
	                 'before_title' => '<h3 class="widget-title">',
	                 'after_title' => '</h3>',
	                 ) );

	register_sidebar( array (
	                 'name' => __( 'Sidebar 2', 'conure' ),
	                 'id' => 'primary-widget-area-2',
	                 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	                 'after_widget' => "</li>",
	                 'before_title' => '<h3 class="widget-title">',
	                 'after_title' => '</h3>',
	                 ) );

	register_sidebar( array (
	                 'name' => __( 'Sidebar 3', 'conure' ),
	                 'id' => 'primary-widget-area-3',
	                 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	                 'after_widget' => "</li>",
	                 'before_title' => '<h3 class="widget-title">',
	                 'after_title' => '</h3>',
	                 ) );

	register_sidebar( array (
	                 'name' => __( 'Sidebar 4', 'conure' ),
	                 'id' => 'primary-widget-area-4',
	                 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	                 'after_widget' => "</li>",
	                 'before_title' => '<h3 class="widget-title">',
	                 'after_title' => '</h3>',
	                 ) );

	register_sidebar( array (
	                 'name' => __( 'Footer Widget Left', 'conure' ),
	                 'id' => 'footer-widget-left',
	                 'before_widget' => '',
	                 'after_widget' => "",
	                 'before_title' => '<h3 class="widget-title">',
	                 'after_title' => '</h3>',
	                 ) );

	register_sidebar( array (
	                 'name' => __( 'Footer Widget Right', 'conure' ),
	                 'id' => 'footer-widget-right',
	                 'before_widget' => '',
	                 'after_widget' => "",
	                 'before_title' => '<h3 class="widget-title">',
	                 'after_title' => '</h3>',
	                 ) );
}

/*Skin WP-Admin login screen*/
function custom_login_logo(){
	echo '
	<style type="text/css">
	body.login { background-color: #9B9B9B !important; }
	#loginform { background-color: #515151 !important; }
	.login #nav a, .login #backtoblog a { color: #fff !important; }
	.wp-core-ui .button-primary { background: #000000; border-color: #000000 !important; -webkit-box-shadow: inset 0 1px 0 rgba(230, 230, 230, 0.5),0 1px 0 rgba(0,0,0,.15) !important; box-shadow: inset 0 1px 0 rgba(230,230,230,.5),0 1px 0 rgba(0,0,0,.15); color: #fff; text-decoration: none; }
	.wp-core-ui .button-primary:hover { background-color: #2E2E2E !important; }
	h1 a { width: 100% !important; background-size:100% !important; background-image: url(/wp-content/uploads/2014/09/griglaw-logo-3SB-300x68_blk.png) !important; }
	.login form { background-color: #333333 !important; }
	#login form p, .login label { color: #fff; }
	.login .message { border-left: 4px solid #C62602; }
	</style>';
}

/*Remove admin menu items*/
function my_remove_menu_pages(){
	// remove_menu_page('edit.php?post_type=acf');
	// remove_menu_page( 'index.php' );                  //Dashboard
	remove_menu_page( 'edit.php' );                   //Posts
	// remove_menu_page( 'upload.php' );                 //Media
	// remove_menu_page( 'edit.php?post_type=page' );    //Pages
	remove_menu_page( 'edit-comments.php' );          //Comments
	// remove_menu_page( 'themes.php' );                 //Appearance
	// remove_menu_page( 'plugins.php' );                //Plugins
	#remove_menu_page( 'users.php' );                  //Users
	remove_menu_page( 'tools.php' );                  //Tools
	// remove_menu_page( 'options-general.php' );        //Settings
}

/*Change URL of WP-Admin logo*/
function my_login_logo_url(){
    return get_bloginfo( 'url' );
}

/*Remove Wordpress Logo in Admin Bar*/
function remove_wp_logo(){
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}