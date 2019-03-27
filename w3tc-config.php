<?php

/**
 * Edit the configuration in the master.php file in W3TC
 *
 * Note that the themes are listed by their 'theme key' which is a weird hash made up of some random stuff.
 * I replicated the process in which W3TC creates this key, only for our current theme. I need to do some 
 * more research on the reason they use this theme key, as I have not come across it before.
 */
 
 // W3TC config file
 $filename = ABSPATH . "/wp-content/w3tc-config/master.php";
 
 // Decode our encoded JSON
 $data = json_decode(urldecode($_REQUEST['json_data']));
 
 $result_message = "";
 
 if (edit_config($data)){
	 // Success
	 $result_message = "Successfully updated W3TC Configuration file.";
 }else{
	 // Fail
	 $result_message = "Error: Could not update settings. Please add the files manually.";
 }
 
 // Display the result of the update
 echo "<script type='text/javascript'>var result_message = '".$result_message."';</script>";
 
/**
* Get the W3TC style theme key for active theme.
*/
 function get_theme_key(){
	$theme = wp_get_theme();
	$theme_root = $theme->get_theme_root();
	$theme_path = ltrim( str_replace( WP_CONTENT_DIR, '', normalize_path( $theme_root ) ), '/' );
	$template = $theme->get_template();
	$stylesheet = $theme->get_stylesheet();
	$theme_key = substr( md5( $theme_path . $template . $stylesheet ), 0, 5 );
	return $theme_key;
 }

/** 
 * Normalize path (from W3TC Util_Environment.php)
 */
function normalize_path( $path ) {
		$path = preg_replace( '~[/\\\]+~', '/', $path );
		$path = rtrim( $path, '/' );

		return $path;
	}

/** 
 * Load the master.php config
 */
	function load_config(){
	global $filename;
		if ( file_exists( $filename )) {

			$content = @file_get_contents( $filename );
			$config = @json_decode( substr( $content, 14 ), true );

			if ( is_array( $config ) ) {
				return $config;
			}else{
				return null;
			}
		}else{
			error_log("Error: File does not exist.");
		}
}

/** 
 * Edit the master.php config
 */
function edit_config( $files ){
	global $filename;
	$theme_key = get_theme_key();
	if ($theme_key == ""){
		error_log("Error: Could not get theme key.");
		return false;
	}
	$data = load_config();
	if (!is_null($data)){
		$data["minify.js.groups"][$theme_key]["default"]["include"]["files"] = $files;
		$output = json_encode($data, JSON_PRETTY_PRINT );
		
		if ( file_exists( $filename )) {
			$result = file_put_contents( $filename, "<?php exit; ?>" . $output );
			if ( $result ){
				return true;
			}else{
				error_log("Error: Could not update file contents.");
			}
		}else{
			error_log("Error: File does not exist.");
		}
		
	}else{
		error_log("Error: Data is empty.");
		return false;
	}
	return;
}
?>