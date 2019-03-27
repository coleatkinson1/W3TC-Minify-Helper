/**
 * Get our render blocking-blocking resources from pagespeed API
 *
 * phpvars - sent from wp_localize_script
 * url = url of the site
 * strategy = desktop or mobile
 * key = our API key
 * print = true/false
 */
 
jQuery(document).ready(function( $ ) {
	var resultData;
  const url = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url="+php_vars.url+"&key="+php_vars.key+"&strategy="+php_vars.strategy+"&category=performance";
  writeLog("Fetching data for: "+url)
  fetch(url)
    .then(response => response.json())
    .then(json => {
      const data = json.lighthouseResult.audits['render-blocking-resources'].details.items;
      resultData = getUrls(data, php_vars.print);
    });

	/**
	 * Outputs the render-blocking resources' URLs
	 */
	function getUrls(data) {
		writeLog("Processing JSON data");
		
		var result = [];
		var count = 0;
		
		// Get the URLs
		writeLog("Manual Mode: Outputting URLs to page");
		for (key in data){
			result.push(data[key].url);
			$("#mh_manual_output").append("<input style='width: 50%;' type='text' value='"+data[key].url+"' id='"+count+"'/><button onclick='javascript:copyToClipboard("+count+")'>Copy text</button><br />");
			count ++;
		}
		// Put the result data into the automatic update form
		$("#json_data").val(encodeURIComponent(JSON.stringify(result)));
		// Enable update button
		//todo
		writeLog("Completed Successfully");
		return result;
	}
});

