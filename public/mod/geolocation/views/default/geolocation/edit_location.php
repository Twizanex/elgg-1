<?php $user = $_SESSION['user']; ?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?= $GLOBALS['google_api'] ?>"></script>
<script type="text/javascript" src="http://j.maxmind.com/app/geoip.js"></script>
<?php if (isloggedin() && $user->getGUID() == $vars['entity']->getGUID()):

	if($vars['page'] == 'home') {
		$lat = $vars['entity']->home_latitude or
				$lat = 0;
		$lng = $vars['entity']->home_longitude or
				$lng = 0;
	} else {
		$lat = $vars['entity']->current_latitude or
				$lat = 0;
		$lng = $vars['entity']->current_longitude or
				$lng = 0;
	}

        

function get_user_profile_values($vars) {    
    $html=''; 
    foreach($vars['config']->profile as $shortname => $valtype) {
            if ($metadata = get_metadata_byname($vars['entity']->guid, $shortname)) {
                    if (is_array($metadata)) {
                            $value = '';
                            foreach($metadata as $md) {
                                    if (!empty($value)) $value .= ', ';
                                    $value .= $md->value;
                                    $access_id = $md->access_id;
                            }
                    } else {
                            $value = $metadata->value;
                            $access_id = $metadata->access_id;
                    }
            } else {
                    $value = '';
                    $access_id = ACCESS_DEFAULT;
            }
            $html.= '<input type="hidden" value="'.$value.'" name="'.$shortname.'" />'.chr(13);
    }
  return $html;
}


?>
<div style="position:relative;width:650px;margin:0 10px;">
<div class="geosearch single">
	<form name="geosearch" id="geosearch" onsubmit="return false;">
		<input type="text" name="query" id="query" value=""/>
		<input type="submit" id="query_submit" value="Search" />
	</form>
</div>
<div id="my_location_button" onclick="javascript:doGeolocation()"  title="Where am I?"></div>
<div id="map">
	<div style="padding: 1em; color: gray">Loading...</div>
</div></div>
<form action="<?php echo $vars['url']; ?>action/profile/edit" method="post" id="location_form" style="margin:0 10px;">
		<?php echo elgg_view('input/securitytoken') ; ?>

        <?php echo get_user_profile_values($vars); ?>

	<input type="hidden" value="<?php echo $lat; ?>" name="<?php echo $vars['page']; ?>_latitude" id="<?php echo $vars['page']; ?>_geolocation_latitude" />
	<input type="hidden" value="<?php echo $lng; ?>" name="<?php echo $vars['page']; ?>_longitude" id="<?php echo $vars['page']; ?>_geolocation_longitude" />
	<?php if ($vars['page'] == 'current'): ?>
	<input type="hidden" value="1" name="set_geolocation_auto_current_location" />	
	<input type="checkbox" value="yes" name="geolocation_auto_current_location" <?php if($user->geolocation_auto_current_location == 'yes') echo ' checked=checked' ;?>/> <?php echo elgg_echo('geolocation:auto_location_by_ip');  ?><br />
	<?php endif; ?>
	<input type="submit" id="save_location" name="save" value="Save" />
</form>

<script type="text/javascript">
	var form = $('#location_form');

	function store_point_location(point) {
		form.find('#<?php echo $vars['page']; ?>_geolocation_latitude').val(point.y);
		form.find('#<?php echo $vars['page']; ?>_geolocation_longitude').val(point.x);
	}

	function showResponse(response, reverse) {
		if (! response) {
			alert("Geocoder request failed");
		} else {
			if (!response.Placemark || !response.Placemark[0]) {
				return;
			}

			box = response.Placemark[0].ExtendedData.LatLonBox;
			latlng = new GLatLng(response.Placemark[0].Point.coordinates[1],
			response.Placemark[0].Point.coordinates[0]);

			set_location(latlng, true);
		}
	}

	var lat = <?= $lat ?> || geoip_latitude();
	var lng = <?= $lng ?> || geoip_longitude();


	if (GBrowserIsCompatible()) {

		map = new google.maps.Map2(document.getElementById("map"));
		map.setUIToDefault();
		var latlng = new GLatLng(lat, lng);

                set_location(latlng, true);

//		GEvent.addListener(map, "click", function(latlng) {
//			set_location(latlng, true);
//		});


		$('#geosearch').submit(function() {
			geocode();
			return false;
		});
	}

function positionSuccess(position) {
	// Centre the map on the new location

        if (position instanceof GLatLng) { // it is google wifi geolocation or ip geolocation?
            var new_latLng = position;
        } else {
            var coords = position.coords;
            var new_latLng = new GLatLng(coords.latitude, coords.longitude);
        }

        set_location(new_latLng, true);
}






</script>
<?php endif; ?>