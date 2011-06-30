 <?php
 $edit = false;
 if(isset($detail['d_coord_lat'])){
	 $edit = true;
 }
 if($edit!= true){
	 $latitude = (osc_item_google_maps_latitude() != '') ? osc_item_google_maps_latitude() : '' ;
	 $longitude = (osc_item_google_maps_longitude() != '') ? osc_item_google_maps_longitude() : '' ;
 }
	 $iplocal = (osc_item_google_maps_use_iplocationtools() != '') ? osc_item_google_maps_use_iplocationtools() : '' ;

?>
 <h1>Drag the pin to automatically determine addresses and coordinates</h1>
  <div id="my_map" style="width: 500px; height: 300px">
	<script type="text/javascript">
	  var map, marker;
	  var markers = [];
	  var inputLat = '#lat';
	  var inputLng = '#lng';
      <?php if(($iplocal == 1) and ($edit != true)){?>
		  var beginLat = ip2location_latitude();
	      var beginLng = ip2location_longitude();
      <?php }elseif($edit != true){?>
		  var beginLat = <?php echo $latitude; ?>;
		  var beginLng =  <?php echo $longitude; ?>;
	  <?php }else{?>
          var beginLat = <?php echo @$detail['d_coord_lat']; ?>;
		  var beginLng =  <?php echo @$detail['d_coord_long']; ?>;
	  <?php }?>
	  var contMap = '#my_map';
	  var geocoder = new google.maps.Geocoder();
      var latlng = new google.maps.LatLng(beginLat, beginLng);
      var myOptions =
          {
          zoom: 12,
          center: latlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
          };

      var map = new google.maps.Map(document.getElementById("my_map"), myOptions);
	  placeMarker(latlng);

		
		function placeMarker(location)
		  {
			// clear previous markers
			if(markers)
			{
			  for(i in markers)
			  {
				markers[i].setMap(null);
			  }
			}
			// create a new marker
			var marker = new google.maps.Marker({
			  position : location,
			  map : map,
			  draggable : true
			});
    
			// add created marker to a global array to be tracked and removed later
			markers.push(marker);
			
			map.setCenter(location);
			
			// extract lat and lng from LatLng location and put values in form
			$(inputLat).val(location.lat());
			$(inputLng).val(location.lng());
			
			/* 
			 * when marker is dragged, extract coordinates, 
			 * change form values and proceed with geocoding
			 */
			google.maps.event.addListener(marker, 'dragend', function(){
			  var coords = marker.getPosition();
			  $(inputLat).val(coords.lat());
			  $(inputLng).val(coords.lng());
			  
			  geocodeCoords(coords);
			  map.setCenter(coords);

			   if($(inputLat).val().trim() == '' ||
				$(inputLng).val().trim() == '')
			  {
				alert('No coordinates or incomplete coordinates specified');
			  }
			  else
			  {
				var lat = $(inputLat).val();
				var lng = $(inputLng).val();
				var location = new google.maps.LatLng(lat, lng);
				
			   
			  }
			});
           }
			  function geocodeLocation(address)
			  {
				geocoder.geocode({'address' : address}, function(result, status){
				  // this returns a latlng
				  var location = result[0].geometry.location;
				  map.setCenter(location);
				  
				  // replace markers
				  placeMarker(location);      
				});
			  }
   </script>
 </div>
  <div id="container_demo">
        <fieldset>
          <ul>
            <li>
              <label for="lat">Latitude</label>
              <input type="text" name="d_coord_lat" id="lat" value="<?php echo @$detail['d_coord_lat']; ?>"/>
            </li>
            
            <li>
              <label for="lng">Longitude</label>
              <input type="text" name ="d_coord_long" id="lng" value="<?php echo @$detail['d_coord_long']; ?>"/>
            </li>
          </ul>
        </fieldset>
	 </div>
	 
  