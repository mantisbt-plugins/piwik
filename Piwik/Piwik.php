<?php

# Copyright (C) 2010 John Reese
# Licensed under the MIT license

class PiwikPlugin extends MantisPlugin {

	function register() {
		$this->name = plugin_lang_get( 'title' );
		$this->description = plugin_lang_get( 'description' );
		$this->page = 'config';

		$this->version = '1.0';
		$this->requires = array(
			'MantisCore' => '1.2',
		);

		$this->author = 'John Reese';
		$this->contact = 'jreese@leetcode.net';
		$this->url = 'http://leetcode.net';
	}

	function config() {
		return array(
			'admin_threshold' => ADMINISTRATOR,
			'track_admins' => true,

			'piwik_uri' => 'http://localhost/piwik/',
			'site_id' => 0,
		);
	}

	function hooks() {
		return array(
			'EVENT_LAYOUT_BODY_END' => 'footer',
		);
	}

	function footer() {
		# Don't use analytics on login pages
		$t_file = $_SERVER['SCRIPT_FILENAME'];
		if ( strpos( basename( $t_file ), 'login' ) ) {
			return;
		}

		$t_admin_threshold = plugin_config_get( 'admin_threshold' );
		$t_track_admins = plugin_config_get( 'track_admins' );

		$t_site_id = plugin_config_get( 'site_id' );
		$t_piwik_uri = plugin_config_get( 'piwik_uri' );
		$t_piwik_uri = string_attribute( array_pop( explode( '://', $t_piwik_uri, 2 ) ) );

		if ( is_blank( $t_piwik_uri ) ||
			( !$t_track_admins && access_has_global_level( $t_admin_threshold ) ) ) {
			return;
		}

		$t_piwik_js = <<< EOT
<!-- Piwik -->
<script type="text/javascript">
	var pkBaseURL = (("https:" == document.location.protocol) ? "https://{$t_piwik_uri}" : "http://{$t_piwik_uri}");
	document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
	try {
		var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", {$t_site_id});
		piwikTracker.trackPageView();
		piwikTracker.enableLinkTracking();
	} catch( err ) {}
</script><noscript><p><img src="http://{$t_piwik_uri}piwik.php?idsite={$t_site_id}" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tag -->
EOT;

		return $t_piwik_js;
	}
}

