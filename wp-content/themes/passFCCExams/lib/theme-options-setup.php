<?php

/*This file is used for bootstrapping the UpThemes Framework*/
if( file_exists(get_template_directory().'/options/options.php') )
	include_once(get_template_directory().'/options/options.php');

if( file_exists(get_template_directory().'/options/theme-options.php') )
	include_once(get_template_directory().'/options/theme-options.php');

function register_global_up_options_variable(){
	upfw_get_options();
	global $up_options;
}