<?php

# Copyright (C) 2010 John Reese
# Licensed under the MIT license

access_ensure_global_level( ADMINISTRATOR );

html_page_top1( plugin_lang_get( 'title' ) );
html_page_top2();

$t_admin_threshald = plugin_config_get( 'admin_threshold' );
$t_track_admins = plugin_config_get( 'track_admins' );

?>
<br/>

<form action="<?php echo plugin_page( 'config_update' ) ?>" method="post">
<table class="width50" align="center" cellspacing="1">

<tr>
<td class="form-title" colspan="2"><?php echo plugin_lang_get( 'title' ) ?></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'piwik_uri' ) ?></td>
<td><input name="piwik_uri" value="<?php echo string_attribute( plugin_config_get( 'piwik_uri' ) ) ?>"/></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'site_id' ) ?></td>
<td><input name="site_id" value="<?php echo string_attribute( plugin_config_get( 'site_id' ) ) ?>"/></td>
</tr>

<tr>
<td class="spacer"></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'admin_threshold' ) ?></td>
<td><select name="admin_threshold"><?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'admin_threshold' ) ) ?></select></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'track_admins' ) ?></td>
<td><input name="track_admins" type="checkbox" <?php echo (ON == $t_track_admins ? 'checked="checked"' : '') ?>></td>
</tr>

<tr>
<td class="center" colspan="2"><input type="submit"/></td>
</tr>

</table>
</form>

<?php
html_page_bottom1( __FILE__ );

