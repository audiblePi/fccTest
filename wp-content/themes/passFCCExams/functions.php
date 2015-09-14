<?php
/**
  * Bootstrap the Theme Options Framework
  * and initialize options
  */
require get_template_directory() . '/lib/theme-options-setup.php';
require get_template_directory() . '/lib/conure-theme-setup.php';
require get_template_directory() . '/lib/conure-theme-addons.php';
require get_template_directory() . '/lib/theme-helper-functions.php';

/**
  * Set up Theme Options and Support
  */
add_action( 'after_setup_theme', 'conure_setup' );
function conure_setup()
{
	#Not currently using language support
	#load_theme_textdomain( 'conure', get_template_directory() . '/languages' );

	/**
	* Register global options from theme options "up_options"
	*/
	add_action( 'init', 'register_global_up_options_variable' );
	add_action( 'wp_enqueue_scripts', 'conure_load_scripts' );
	add_action( 'widgets_init', 'conure_widgets_init' );
	add_action( 'login_enqueue_scripts', 'custom_login_logo' );
	add_filter( 'login_headerurl', 'my_login_logo_url' );
	add_action( 'wp_before_admin_bar_render', 'remove_wp_logo' );
	#add_action( 'admin_init', 'my_remove_menu_pages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menus( array(
	    	'main-menu' => __( 'Main Menu', 'conure' ),
	    	'admin-menu' => __( 'Admin Menu', 'conure' ),
	    	'dashboard-menu' => __( 'Dashboard Menu', 'conure' ) 
	    )
	);
	add_filter( 'wp_title', 'conure_filter_wp_title' );
	add_filter( 'the_title', 'conure_title' );
}

function google_map( $atts, $content = null ) {
	extract(
		shortcode_atts(
				array(
		        'address'   => false,
		        'width'  => '100%',
		        'height'    => '400px',
	        ), 
		$atts)
	);
	global $up_options;
	$address = $up_options->office_location;
	if( $address ) :
		wp_print_scripts( 'google-maps-api' );
	$coordinates = google_map_get_coordinates( $address );
	// var_dump($coordinates);
	if( !is_array( $coordinates ) )
		return;
	$map_id = uniqid( 'google_map_' );
	ob_start(); ?>
	<div class="google_map_canvas" id="<?php echo esc_attr( $map_id ); ?>" style="height: <?php echo esc_attr( $atts['height'] ); ?>; width: <?php echo esc_attr( $atts['width'] ); ?>"></div>
	<script type="text/javascript">
	var map_<?php echo $map_id; ?>;
	function ale_run_map_<?php echo $map_id ; ?>(){
		// var location = new google.maps.LatLng("30.25459", "-81.58827");
		var location = new google.maps.LatLng("<?php echo $coordinates['lat']; ?>", "<?php echo $coordinates['lng']; ?>");
		var map_options = {
			zoom: 15,
			center: location,
			scrollwheel: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map_<?php echo $map_id ; ?> = new google.maps.Map(document.getElementById("<?php echo $map_id ; ?>"), map_options);
		var marker = new google.maps.Marker({
			position: location,
			map: map_<?php echo $map_id ; ?>
		});
	}
	ale_run_map_<?php echo $map_id ; ?>();
	</script>
	<?php
	endif;
	return ob_get_clean();
}
add_shortcode('google_map', 'google_map');

//Loads Google Map API
function google_map_load_scripts(){
	wp_register_script( 'google-maps-api', 'http://maps.google.com/maps/api/js?sensor=false' );
}
add_action( 'wp_enqueue_scripts', 'google_map_load_scripts' );

//Retrieve coordinates for an address
function google_map_get_coordinates( $address, $force_refresh = false ) {
	$address_hash = md5( $address );
	$coordinates = get_transient( $address_hash );
	if ($force_refresh || $coordinates === false) {
		$args       = array( 'address' => urlencode( $address ), 'sensor' => 'false', 'key' => 'AIzaSyA4-ZxE3QqrSWpnwsjSke4Bs5DDN1LeFB0' );
		$url        = add_query_arg( $args, 'https://maps.googleapis.com/maps/api/geocode/json' );
		// var_dump($url);
		$response 	= wp_remote_get( $url );
		if( is_wp_error( $response ) )
			return;
		$data = wp_remote_retrieve_body( $response );
		if( is_wp_error( $data ) )
			return;
		if ( $response['response']['code'] == 200 ) {
			// var_dump($data);
			$data = json_decode( $data );
			if ( $data->status === 'OK' ) {
				$coordinates = $data->results[0]->geometry->location;
				$cache_value['lat'] 	= $coordinates->lat;
				$cache_value['lng'] 	= $coordinates->lng;
				$cache_value['address'] = (string) $data->results[0]->formatted_address;
				// // cache coordinates for 3 months
				// set_transient($address_hash, $cache_value, 3600*24*30*3);
				// $data = $cache_value;
				// var_dump($data->status);
			} elseif ( $data->status === 'ZERO_RESULTS' ) {
				return __( 'No location for the address.', 'aletheme' );
			} elseif( $data->status === 'INVALID_REQUEST' ) {
				return __( 'Bad request. Did you enter an address name?', 'aletheme' );
			} else {
				return ($data->status);
				// return __( 'Error, please check if you have entered the shortcode correctly.', 'aletheme' );
			}
		} else {
			return __( 'Can\'t connect Google API.', 'aletheme' );
		}
	} else {
		// return cached results
		$data = $coordinates;
	}
	// return (array) $data;
	$coords = array();
	// var_dump($data);
	// print("<pre>".print_r($data,true)."</pre>");
	// var_dump($data->results[0]->geometry->location->lat);
	$coords['lat'] = $data->results[0]->geometry->location->lat;
	$coords['lng'] = $data->results[0]->geometry->location->lng;
	// var_dump($data->results[0]->geometry->location->lng);
	return $coords;
}

//Fix bug with responsive
function google_map_css() {
	echo '<style type="text/css">
	.google_map_canvas img {
		max-width: none;
	}</style>';
}
add_action( 'wp_head', 'google_map_css' );
