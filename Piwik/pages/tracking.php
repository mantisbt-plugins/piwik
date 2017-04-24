<?php

	header ("Content-Type: text/javascript");

	$t_site_id = plugin_config_get( 'site_id' );
	$t_piwik_uri = plugin_config_get( 'piwik_uri' );
	$t_piwik_uri = string_attribute( array_pop( explode( '://', $t_piwik_uri, 2 ) ) );

	$protocol = "http";

	if(!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") {
		$protocol = "https";
	}

	echo "
		var idSite = ".$t_site_id.";
		var piwikTrackingApiUrl = '".$protocol."://".$t_piwik_uri."/piwik.php';

		var _paq = _paq || [];
		_paq.push(['setTrackerUrl', piwikTrackingApiUrl]);
		_paq.push(['setSiteId', idSite]);
		_paq.push(['trackPageView']);
		_paq.push(['enableLinkTracking']);
	  ";




?>

