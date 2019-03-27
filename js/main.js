jQuery(document).ready(function( $ ) {
	
	// Display result message from automatic configuration
	if (typeof result_message !== 'undefined') {
		writeLog(result_message);
	}
});

/**
 * Copy text to clipboard
 */
function copyToClipboard(id) {
  var copyText = document.getElementById(id);
  copyText.select();
  document.execCommand("copy");
}

/**
 * Write to our log textarea on settings page
 */
function writeLog(str){
		jQuery( "#writeLog" ).append(str+"\n");
	}
