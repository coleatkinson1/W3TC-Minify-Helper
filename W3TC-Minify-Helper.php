<?php
/**
 * Plugin Name: W3TC Minify Helper
 * Description: Detects and loads CSS/JS scripts that require render-blocking setup into W3TC
 * Version: 1.0
 * Author: Cole Atkinson
 * Author URI: http://coleatkinson.nz
 */

 /**
 * Note:
 * This is my first (public) wordpress plugin! I am currently improving my knowledge and coding ability so that I can work on more projects like this.
 * Any suggestions/tips/contributions are greatly appreciated and welcome!
 *
 * I am also very interested in a career in programming, whether it be wordpress/JS/PHP related or something else. To find out more, and to support me, please visit:
 * http://coleatkinson.nz
 */
 
 /**
 * Create settings page
 */
function w3tc_mh_settings_menu(){
        add_menu_page( 'W3TC Minify Helper Settings', 'W3TC Minify Helper', 'manage_options', 'W3TC-Minify-Helper', 'w3tcmh_init' );
}
add_action('admin_menu', 'w3tc_mh_settings_menu');

// Exit script if running outside settings page
 if (isset($_GET['page']) && ($_GET['page'] != 'W3TC-Minify-Helper')){
return;
 }
 
// Useful constants
define("PDIR", "/wp-content/plugins/W3TC-Minify-Helper");
define("W3DIR", "/plugins/w3-total-cache");

/**
 * Enqueue any javascripts
 */
function mh_js(){
	wp_register_script( 'mh_js_main', PDIR . '/js/main.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( "mh_js_main" );
}
add_action( 'admin_enqueue_scripts', 'mh_js' );
 
/**
 * Load Settings Page
 */
function w3tcmh_init(){
    require_once(__DIR__ . "/templates/settings.php");
}

/**
 * Automatic config update
 */
 if ( isset( $_REQUEST['mh_update'] ) && $_REQUEST['mh_update'] && isset( $_REQUEST['json_data'] )){
	require_once(__DIR__ . "/w3tc-config.php");
 }
 
/**
 * Detect
 */
if ( isset( $_REQUEST['detect'] ) ){	
	add_action('admin_enqueue_scripts', 'mh_js_fetch');
}

/**
* Fetch data
*/
function mh_js_fetch() {
	
	//Fetch data and validate
	$url = get_site_url();
	
	// Validate query vars
	$print_opts = array(true, false);
	$strategy_opts = array("Desktop", "Mobile");		

	$strategy = in_array($_REQUEST['mh_strategy'], $strategy_opts) ? $_REQUEST['mh_strategy'] : die("Invalid 'strategy'");
	$print = in_array($_REQUEST['detect'], $print_opts) ? $_REQUEST['detect'] : die("Invalid 'detect'");
	$key = preg_match('/[a-zA-Z0-9]/', $_REQUEST['mh_key']) ? $_REQUEST['mh_key'] : die("Invalid 'key'");
	
	// Register the javascript and send our vars through
	wp_register_script( 'mh_js_fetch', PDIR . '/js/fetchData.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script('mh_js_fetch');
	wp_localize_script('mh_js_fetch', 'php_vars', array(
			'url' => $url,
			'strategy' => $strategy,
			'key' => $key,
			'print' => $print
		)
	);
}



?>