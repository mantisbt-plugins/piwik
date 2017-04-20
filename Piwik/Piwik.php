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
			'MantisCore' => '2.0.0',
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
			'EVENT_PLUGIN_INIT' => 'set_custom_security_headers'
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

		$t_piwik_uri = plugin_config_get( 'piwik_uri' );
		$t_piwik_uri = string_attribute( array_pop( explode( '://', $t_piwik_uri, 2 ) ) );

		if ( is_blank( $t_piwik_uri ) ||
			( !$t_track_admins && access_has_global_level( $t_admin_threshold ) ) ) {
			return;
		}

		// assuming that the local protocol is the same as the one of remote piwik server
		if(!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") {
			$pkBaseURL = "https://" . $t_piwik_uri;
		} else {
			$pkBaseURL = "http://" . $t_piwik_uri;
		}

		

		$t_piwik_js = '
			<!-- Piwik -->
			<script src="'.$pkBaseURL.'/piwik.js" async defer></script>
			<script type="text/javascript" src="' . plugin_page( 'tracking.php' ) . '"></script>
			<!-- End Piwik Tag -->
		';

		return $t_piwik_js;
	}


	function set_custom_security_headers() {

		$t_piwik_uri = plugin_config_get( 'piwik_uri' );
		$t_piwik_uri = string_attribute( array_pop( explode( '://', $t_piwik_uri, 2 ) ) );

		if(!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") {
			$pkBaseURL = "https://" . $t_piwik_uri;
		} else {
			$pkBaseURL = "http://" . $t_piwik_uri;
		}

		http_csp_add( 'script-src', $pkBaseURL );
		http_csp_add( 'img-src', $pkBaseURL );

	}
}

