<?php
/*
Plugin Name: Google Maps
Plugin URI: http://www.osclass.org/
Description: This plugin shows a Google Map on the location space of every item.
Version: 2.2
Author: OSClass & kingsult & Richard Martin 
Author URI: http://www.osclass.org/
Plugin update URI: http://www.osclass.org/files/plugins/google_maps/update.php
*/

    function google_maps_location() {
        $item = osc_item();
        require 'map.php';
    }

    function osc_google_maps_header() {
		$iplocal = (osc_item_google_maps_use_iplocationtools() != '') ? osc_item_google_maps_use_iplocationtools() : '' ;
        echo '<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>';
		if($iplocal ==1){
			$iplocal_api = (osc_item_google_maps_api_iplocationtools() != '') ? osc_item_google_maps_api_iplocationtools() : '' ;
			echo ' <script language="JavaScript" src="http://www.iplocationtools.com/iplocationtools.js?key='.$iplocal_api.'"></script>';
		}
    }
	
    function insert_geo_location($catId, $itemId) {
		$use_maps = osc_item_google_maps_post_item(); 
		if($use_maps==1){
			//we just need to set latitude and longitude
			$latitude = addslashes(Params::getParam('d_coord_lat'));
			$longitude = addslashes(Params::getParam('d_coord_long'));
			ItemLocation::newInstance()->update (array('d_coord_lat' => $latitude
														  ,'d_coord_long' => $longitude)
													,array('fk_i_item_id' => $itemId));
		}else{
			//default google maps code
			$aItem = Item::newInstance()->findByPrimaryKey($itemId);
			$sAddress = (isset($aItem['s_address']) ? $aItem['s_address'] : '');
			$sRegion = (isset($aItem['s_region']) ? $aItem['s_region'] : '');
			$sCity = (isset($aItem['s_city']) ? $aItem['s_city'] : '');
			$address = sprintf('%s, %s %s', $sAddress, $sRegion, $sCity);
			$response = osc_file_get_contents(sprintf('http://maps.google.com/maps/geo?q=%s&output=json&sensor=false', urlencode($address)));
			$jsonResponse = json_decode($response);
			if (isset($jsonResponse->Placemark) && count($jsonResponse->Placemark[0]) > 0) {
				$coord = $jsonResponse->Placemark[0]->Point->coordinates;
				ItemLocation::newInstance()->update (array('d_coord_lat' => $coord[1]
														  ,'d_coord_long' => $coord[0])
													,array('fk_i_item_id' => $itemId));
			}
		}
    }

	function show_map() {
		require('map_form.php');
		
    }
    function show_map_edit($catId = null, $item_id = null) {
		$conn   = getConnection();
        $detail = $conn->osc_dbFetchResult("SELECT * FROM %st_item_location WHERE fk_i_item_id = %d", DB_TABLE_PREFIX, $item_id);
		require_once('map_form.php');
		
    }
	function osc_item_google_maps_post_item() {
        return(osc_get_preference('google_maps_post_items', 'plugin_google_maps')) ;
    }

	function osc_item_google_maps_longitude() {
        return(osc_get_preference('google_maps_longitude', 'plugin_google_maps')) ;
    }

	function osc_item_google_maps_latitude() {
        return(osc_get_preference('google_maps_latitude', 'plugin_google_maps')) ;
    }

	function osc_item_google_maps_api_iplocationtools() {
        return(osc_get_preference('google_maps_api_iplocationtools', 'plugin_google_maps')) ;
    }

	function osc_item_google_maps_use_iplocationtools() {
        return(osc_get_preference('google_maps_use_iplocationtools', 'plugin_google_maps')) ;
    }

	function google_maps_call_after_install() {
	    $conn = getConnection();
	    $conn->autocommit(false);
		try {
        $conn->commit();
        osc_set_preference('google_maps_post_items', '0', 'plugin_google_maps', 'INTEGER');
		osc_set_preference('google_maps_latitude', '37.772323', 'plugin_google_maps', 'INTEGER');
		osc_set_preference('google_maps_longitude', '-122.214897', 'plugin_google_maps', 'INTEGER');
		osc_set_preference('google_maps_use_iplocationtools', '0', 'plugin_google_maps', 'INTEGER');
		osc_set_preference('google_maps_api_iplocationtools', '', 'plugin_google_maps', 'STRING');
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
		
        }

    function google_maps_call_after_uninstall() {
        // Insert here the code you want to execute after the plugin's uninstall
        // for example you might want to drop/remove a table or modify some values
		 $conn = getConnection();
		 $conn->autocommit(false);
			try {
				osc_delete_preference('google_maps_post_items', 'plugin_google_maps');
				osc_set_preference('google_maps_latitude', 'plugin_google_maps');
				osc_set_preference('google_maps_longitude', 'plugin_google_maps');
				osc_set_preference('google_maps_use_iplocationtools', 'plugin_google_maps');
				osc_set_preference('google_maps_api_iplocationtools',  'plugin_google_maps');
               }   catch (Exception $e) {
				$conn->rollback();
				echo $e->getMessage();
			}
			$conn->autocommit(true);
		}
		$conn = getConnection();
		try {
        
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
	function google_maps_admin() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/config.php') ;
    }
	function google_maps_admin_menu() {
        echo '<h3><a href="#">Google Map</a></h3>
        <ul>
		    <li><a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/config.php') . '">&raquo; ' . __('Configuration', 'google_maps') . '</a></li>
			<li><a href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/help.php') . '">&raquo; ' . __('Help', 'google_maps') . '</a></li>
        </ul>';
    }
	

    // This is needed in order to be able to activate the plugin

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    // Add header 
    osc_add_hook('location', 'google_maps_location') ;
	// This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'google_maps_admin');
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'google_maps_call_after_install');
    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__). '_uninstall', 'google_maps_call_after_uninstall');

    if(osc_item_google_maps_post_item()==1){
        //Adding header
		osc_add_hook('header', 'osc_google_maps_header');
		// When publishing an item we show an extra form with more attributes
		osc_add_hook('item_form', 'show_map');
		// Edit an item special attributes
        osc_add_hook('item_edit', 'show_map_edit');
		//Edit and form post
		osc_add_hook('item_form_post', 'insert_geo_location') ;
		osc_add_hook('item_edit_post', 'insert_geo_location') ;
	}else{
		//No need for the map regular google map functin apply
		//Edit and form post
		osc_add_hook('item_form_post', 'insert_geo_location') ;
		osc_add_hook('item_edit_post', 'insert_geo_location') ;
		
	}

	    osc_add_hook('admin_menu', 'google_maps_admin_menu');

?>