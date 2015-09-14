<?php
/*
Plugin Name: FCC Test Custom Plugin
Plugin URI: http://www.pippindesign.com
Description: Custom FCC Test functions
Version: 1
Author: Pippin Design
Author URI: http://www.pippindesign.com
*/

add_shortcode('fccTest_Debug', 'debug');

function debug() {
	$link = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
    mysql_select_db(DB_NAME, $link);

	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;

	$result = mysql_query("SELECT * FROM wp_mlw_results WHERE user = $current_user_id;") OR DIE(mysql_error());
	$row = mysql_fetch_array(@$result);

	if($row) {
		echo '<div>';
		do {
			echo '<div style="">';	
			if($row["quiz_name"]) { echo $row["quiz_name"].': '; }
			/*if($row["correct"])*/ { echo $row["correct_score"].'% <br><br>'; }
			echo '</div>';
		} 
		while ($row = mysql_fetch_array($result));
	} else { 
		 echo "No Results found..."; 
	}
	echo '</div>';
}

?>