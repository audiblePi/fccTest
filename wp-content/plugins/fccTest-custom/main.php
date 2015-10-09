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

define('fccTest_FILE', __FILE__);
define('fccTest_PATH', plugin_dir_path(__FILE__));

require fccTest_PATH . 'shortcodes.php';
require fccTest_PATH . 'ajax.php';

$option_name = 'fcc-option';// Name of the array
$data = array('url' => 'fcc','title' => 'FCC Test Options');// Default values

add_action( 'wp_enqueue_scripts', 'fcc_load_scripts' );
add_action('admin_init', 'admin_init');// Admin sub-menu
add_action('admin_menu', 'add_page');

function fcc_load_scripts(){
   wp_enqueue_style( 'fcccss', '/wp-content/plugins/fccTest-custom/styles.css' );
   wp_enqueue_script( 'jqueryui', '//code.jquery.com/ui/1.11.4/jquery-ui.js' );
    wp_enqueue_style( 'jqueryuitheme', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css' );
   wp_enqueue_script( 'fccjs', '/wp-content/plugins/fccTest-custom/fccmain.js' );
    wp_enqueue_script( 'raphael', '/wp-content/plugins/fccTest-custom/jquery.raphael/raphael-min.js' );
    wp_enqueue_script( 'morris', '/wp-content/plugins/fccTest-custom/jquery.morris/morris.js' );
    wp_enqueue_style( 'morriscss', '/wp-content/plugins/fccTest-custom/jquery.morris/morris.css' );
    wp_enqueue_script( 'flot', '/wp-content/plugins/fccTest-custom/flot/jquery.flot.min.js' );
    wp_enqueue_script( 'flotpie', '/wp-content/plugins/fccTest-custom/flot/jquery.flot.pie.js' );
    //wp_enqueue_script( 'date', '/wp-content/plugins/fccTest-custom/date.js' );
}

function admin_init() {
    register_setting('fcc_test_options', 'tz-todo', 'validate');
}

function add_page() {
    add_menu_page('Fcc Test Options', 'Fcc Test Options', 'manage_options', 'fcc_test_options', 'options_page');
}

function options_page() {
    $options = get_option('fcc-option');
    ?>
    <div class="wrap">
        <h2>FCC Test Options</h2>
        <script>
            window.onload = function() {
                var fileInput = document.getElementById('fileInput');
                var fileDisplayArea = document.getElementById('fileDisplayArea');

                fileInput.addEventListener('change', function(e) {
                    var file = fileInput.files[0];
                    var textType = /text.*/;

                    if (file.type.match(textType)) {
                        var reader = new FileReader();
                        console.log(reader);

                        reader.onload = function(e) {
                            fileDisplayArea.innerText = reader.result;
                        }
                        reader.readAsText(file);    
                    } else {
                        fileDisplayArea.innerText = "File not supported!"
                    }
                });
            }
        </script>

        <div id="page-wrapper">
            <div>
                Select a text file: 
                <input type="file" id="fileInput">
            </div>
            <pre id="fileDisplayArea"><pre>
        </div>
    </div>
    <?php
}
?>