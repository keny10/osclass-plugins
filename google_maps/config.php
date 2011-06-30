<?php

    $post_item            = '';
    $dao_preference = new Preference();
    if(Params::getParam('post_item') != '') {
        $post_item = Params::getParam('post_item');
    } else {
        $post_item = (osc_item_google_maps_post_item() != '') ? osc_item_google_maps_post_item() : '' ;
    }

	$iplocal            = '';
    $dao_preference = new Preference();
    if(Params::getParam('iplocal') != '') {
        $iplocal = Params::getParam('iplocal');
    } else {
        $iplocal = (osc_item_google_maps_use_iplocationtools() != '') ? osc_item_google_maps_use_iplocationtools() : '' ;
    }

	$iplocal_api            = '';
    $dao_preference = new Preference();
    if(Params::getParam('iplocal_api') != '') {
        $iplocal_api = Params::getParam('iplocal_api');
    } else {
        $iplocal_api = (osc_item_google_maps_api_iplocationtools() != '') ? osc_item_google_maps_api_iplocationtools() : '' ;
    }

	$latitude            = '';
    $dao_preference = new Preference();
    if(Params::getParam('latitude') != '') {
        $latitude = Params::getParam('latitude');
    } else {
        $latitude = (osc_item_google_maps_latitude() != '') ? osc_item_google_maps_latitude() : '' ;
    }

	$longitude            = '';
    $dao_preference = new Preference();
    if(Params::getParam('longitude') != '') {
        $longitude = Params::getParam('longitude');
    } else {
        $longitude = (osc_item_google_maps_longitude() != '') ? osc_item_google_maps_longitude() : '' ;
    }
    
    
    if( Params::getParam('option') == 'post' ) {
        $dao_preference->update(array("s_value" => $post_item), array("s_section" => "plugin_google_maps", "s_name" => "google_maps_post_items")) ;
		$dao_preference->update(array("s_value" => $iplocal), array("s_section" => "plugin_google_maps", "s_name" => "google_maps_use_iplocationtools")) ;
		$dao_preference->update(array("s_value" => $iplocal_api), array("s_section" => "plugin_google_maps", "s_name" => "google_maps_api_iplocationtools")) ;
		$dao_preference->update(array("s_value" => $latitude), array("s_section" => "plugin_google_maps", "s_name" => "google_maps_latitude")) ;
		$dao_preference->update(array("s_value" => $longitude), array("s_section" => "plugin_google_maps", "s_name" => "google_maps_longitude")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'google_maps') . '.</p></div>';
    }
    unset($dao_preference) ;
    
?>

<form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="google_maps/config.php" />
    <input type="hidden" name="option" value="post" />
    <div>
    <fieldset>
        <h2><?php _e('Google Map Preferences', 'google_maps'); ?></h2>
		<label for="item" style="font-weight: bold;"><?php _e('Show a dragable map in post add page ?', 'google_maps'); ?></label><br />
        <select name="post_item" id="post_item"> 
        	<option <?php if($post_item == 0){echo 'selected="selected"';}?>value='0'><?php _e('No', 'google_maps'); ?></option>
        	<option <?php if($post_item == 1){echo 'selected="selected"';}?>value='1'><?php _e('Yes', 'google_maps'); ?></option>
        </select>
		<?php if($post_item == 1){?>
		<br />
		<label for="iplocal" style="font-weight: bold;"><?php _e('Use iplocationtools.com service ? (see help for more info)', 'google_maps'); ?></label>
		<br />
        <select name="iplocal" id="iplocal"> 
        	<option <?php if($iplocal == 0){echo 'selected="selected"';}?>value='0'><?php _e('No', 'google_maps'); ?></option>
        	<option <?php if($iplocal == 1){echo 'selected="selected"';}?>value='1'><?php _e('Yes', 'google_maps'); ?></option>
        </select>
		<?php if($iplocal == 1){?>
		<br />
		<label for="iplocal_api" style="font-weight: bold;"><?php _e('Enter your iplocationtools.com api key', 'google_maps'); ?></label>
        <input type="text" name="iplocal_api" id="iplocal_api" value="<?php echo $iplocal_api; ?>" />
		<?php }else{?>
        <br />
		<label for="latitude" style="font-weight: bold;"><?php _e('Enter the default latitude point', 'google_maps'); ?></label>
        <input type="text" name="latitude" id="latitude" value="<?php echo $latitude; ?>" />
		<br />
		<label for="longitude" style="font-weight: bold;"><?php _e('Enter the default longitude point', 'google_maps'); ?></label>
        <input type="text" name="longitude" id="longitude" value="<?php echo $longitude; ?>" />
		<?php }?>
		<?php }?>
        <br />
        <br />
        <input type="submit" value="<?php _e('Save', 'google_maps'); ?>" />
     </fieldset>
    </div>
</form>
