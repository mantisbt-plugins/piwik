<?php

# Copyright (C) 2010 John Reese
# Licensed under the MIT license

access_ensure_global_level( ADMINISTRATOR );

$f_piwik_uri = gpc_get_string( 'piwik_uri', '' );
$f_site_id = gpc_get_string( 'site_id', '' );
$f_admin_threshold = gpc_get_int( 'admin_threshold' );
$f_track_admins = gpc_get_bool( 'track_admins', false );

plugin_config_set( 'piwik_uri', $f_piwik_uri );
plugin_config_set( 'site_id', $f_site_id );
plugin_config_set( 'admin_threshold', $f_admin_threshold );
plugin_config_set( 'track_admins', $f_track_admins );

print_successful_redirect( plugin_page( 'config', true ) );

