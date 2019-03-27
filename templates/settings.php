<div class="wrap">
<h1>W3TC Minify Helper by Cole Atkinson<h1>
<p>This software is free and open-source. If you find it useful, please make a donation here so that I can continue to make more plugins.</p>
<p>The intention of this plugin is to speed-up the process of loading scripts into W3TC -> Minify to prevent render blocking.</p>
<h3>Complete the following before continuing:</h3>
<ul style="list-style-type: square;">
<li>Install W3TC and enable minify</li>
<li>Backup your W3TC folder</li>
<li>Get a pagespeed insights API key</li>
</ul>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>">
<span>AIzaSyCnn6jCunuWqNmhclJeGPGF6KoEOxdPyZg</span>
<label>API Key:</label><br /><input name="mh_key" type="text" style="width: 50%;" />
<select name="mh_strategy"><option selected>Desktop</option><option>Mobile</option></select>

<h3>Manual Control</h3>
<p>This will generate a list of the render-blocking resources</p>
<input type="hidden" name="detect" value="true" />
<input type="hidden" name="page" value="W3TC-Minify-Helper" />
<input type="submit" value="Detect">
</form>
<div id="mh_manual_output">
</div>
<h3>Automatic</h3>
<p>This will override any scripts you currently have loaded in W3TC config</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="mh_update" value="true" />
<input type="hidden" name="page" value="W3TC-Minify-Helper" />
<input type="hidden" id="json_data" name="json_data" />
<input type="submit" value="Update W3TC config" />
</form>
<h3>Log</h3>
<textarea id="writeLog" style="width: 50%; height: 200px;" ></textarea>
</div>