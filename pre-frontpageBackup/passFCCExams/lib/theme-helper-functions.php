<?php

/*Get all pages and allow user to select from a dynamically generated Select List inside of Theme Options*/
function get_all_pages(){
	$pages = get_posts( array( 'post_status' => 'publish', 'post_type' => 'service' ) );
	$all_pages = array();
	// var_dump($pages);
	$index = 0;
	while ($index < count($pages)) {
		// var_dump($pages[$index]->guid);
		// $guidFormatted = str_replace('&', '&#038;', $pages[$index]->guid);
		$all_pages[$pages[$index]->post_title] = array(
	       'name' => $pages[$index]->post_title,
	       'title' => $pages[$index]->post_title
	    );
		$index++;
	}
	// var_dump($all_pages);
	return $all_pages;
}

/*Return Site Logo from Admin theme options to front end*/
function custom_logo(){
	global $up_options;
	return $up_options->site_logo;
}

/*Helper to retrieve images in a slider (typically front page)*/
function load_slider_images(){
	global $up_options;
	ob_start(); ?>

	<img src="<?php echo $up_options->home_page_slider_image1 ?>" alt="" />
	<img src="<?php echo $up_options->home_page_slider_image2 ?>" alt="" />
	<img src="<?php echo $up_options->home_page_slider_image3 ?>" alt="" />

	<?php ob_end_flush();
}