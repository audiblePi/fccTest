<?php
/**
* Plugin Name: FCC Test Plugin
* Plugin URI: http://www.pippindesign.com
* Description: Custom Plugin for FCC Test Elements
* Version: BETA
* Author: Pippin Design
* Author URI: http://www.pippindesign.com
*
* @author B Hicks
* @version 1.0
*/


/*** Exam Overview ***
* Simluated Exams are created based on a preset length, with a preset percentage of questions from each subtopic.
* Study Mode Exams are customizable and can be resumed.
* If the user enter 'Study Mode', they will prompted whether or not they want to resume their last study session.
* If the user declines, they will no longer be prompted, until their next unfinished study session.
* 'Missed retake' and 'Weak areas' exams retrieve the question array and cross reference each question id with its row in the question table.
* 'Missed retake' finds the last exam by the user and creates a new exam from the missed questions.
* 'Weak areas' are calculated as questions within an element that have been missed at least once out of the last three attempts.
* For a question to no longer be considered a weak area, the user must answer it correctly three times consectuively.
* 'Quick 50' creates an Exam with 50 questions, similar to the simulated exam
*/


/*** Account Dashoboard Overview ***
* 'Study Reports' contains data from simulated exams and study sessions, but filters out exams with less than 5 attempted questions.
* 'Study Reports -> Weak Areas' chart is based on the total number of correct answers out of the total number of answered questions in each element.
*     NOTE: This means the last three attempts of the same question will be accounted for.  This only refers to questions that have been seen.
* 'Study Reports -> Weak vs Learned' shows the percentage of seen questions that have been tagged as weak areas.
*     ASSUMPTION: If the user has not seen a question it is not considered weak or learned.
* 'Leader Board' only refers to smulated exams, showing the top five scores of completed from all registered users.
*     NOTE: The leaderboard uses 'Nickname' profile value for each user.
* A note about grading: In study mode, the user is allowed to skip questions. Skipped questions are counted as missed questions.
*     NOTE: This does not apply to the weak areas algorithm.  Weak areas applies to questions that have been answered.
*/

define('fccTest_FILE', __FILE__);
define('fccTest_PATH', plugin_dir_path(__FILE__));

require fccTest_PATH . 'includes/shortcodes.php';
require fccTest_PATH . 'includes/ajax.php';
#require fccTest_PATH . 'includes/dashboard.php';

$option_name = 'fcc-option';// Name of the array
$data = array('url' => 'fcc','title' => 'FCC Test Options');// Default values

add_action('wp_enqueue_scripts', 'fcc_load_scripts' );
#add_action('admin_init', 'admin_init');
#add_action('admin_menu', 'add_page');

function fcc_load_scripts(){
    wp_enqueue_style( 'fcccss', '/wp-content/plugins/fccTest-custom/includes/css/styles.css' );
    wp_enqueue_style( 'uniformcss', '/wp-content/plugins/fccTest-custom/lib/jquery.uniform/uniform.default.css' );
    wp_enqueue_style( 'jqueryuitheme', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css' );
    wp_enqueue_style( 'morriscss', '/wp-content/plugins/fccTest-custom/lib/jquery.morris/morris.css' );

    wp_enqueue_script( 'fccjs', '/wp-content/plugins/fccTest-custom/includes/js/fccmain.js' );
    wp_enqueue_script( 'jqueryui', '//code.jquery.com/ui/1.11.4/jquery-ui.js' );
    wp_enqueue_script( 'uniformjs', '/wp-content/plugins/fccTest-custom/lib/jquery.uniform/jquery.uniform.min.js' );
    wp_enqueue_script( 'raphael', '/wp-content/plugins/fccTest-custom/lib/jquery.raphael/raphael-min.js' );
    wp_enqueue_script( 'morris', '/wp-content/plugins/fccTest-custom/lib/jquery.morris/morris.js' );
    wp_enqueue_script( 'flot', '/wp-content/plugins/fccTest-custom/lib/flot/jquery.flot.min.js' );
    wp_enqueue_script( 'flotpie', '/wp-content/plugins/fccTest-custom/lib/flot/jquery.flot.pie.js' );
}//end fcc_load_scripts()

?>