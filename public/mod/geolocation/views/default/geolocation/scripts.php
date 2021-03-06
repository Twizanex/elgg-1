<script type="text/javascript">
var where_i_am_marker=null;
var search_position_marker=null;

function markerClick(url, latlng) {
	return function() {
		map.openInfoWindowHtml(latlng, url, {maxWidth:300, maxHeight:300, autoScroll:true});
	}
}


function add_Listener_To_Where_I_Am_Marker() {
    GEvent.addListener(where_i_am_marker, "dragstart", function() {
            map.closeInfoWindow();
    });

    GEvent.addListener(where_i_am_marker, "dragend", function(latlng) {
            store_point_location(latlng);
    });
}

function set_location(new_latlng, dragg){
	if (map.getZoom() < 10) {
		map.setZoom(12);
	}

        // Remove old marker
        if (where_i_am_marker != null) {
            map.removeOverlay(where_i_am_marker);
        }

        var whereIcon = new GIcon(G_DEFAULT_ICON);

        if (!dragg) { // new icon
            whereIcon.image = '/mod/geolocation/graphics/markers/circle-blue.png';
            whereIcon.iconSize = new GSize(50,50);
            whereIcon.shadowSize = new GSize(0,0);
        } else { // icon user        
            whereIcon.image = '/mod/geolocation/graphics/markers/user.png';
        }

        where_marker_options = {icon:whereIcon, draggable:dragg};
        where_i_am_marker = new GMarker(new_latlng, where_marker_options );

        map.addOverlay(where_i_am_marker);
        map.setCenter(new_latlng, 12);

        if (dragg) {
            store_point_location(new_latlng);
            add_Listener_To_Where_I_Am_Marker();
        }
}

function set_position(latlng) {
     // Remove old position marker
    if (search_position_marker!= null) {
        map.removeOverlay(search_position_marker);
    }
    search_position_marker=new GMarker(latlng);

    map.addOverlay(search_position_marker);
    map.setCenter(latlng, 12);
}



function get_current_location_by_ip(){
	var lat = geoip_latitude();
	var lng = geoip_longitude();
	var latlng = new GLatLng(lat, lng);
	return latlng;
}

function geocode() {
	var query = document.getElementById("query").value;
	if (/\s*^\-?\d+(\.\d+)?\s*\,\s*\-?\d+(\.\d+)?\s*$/.test(query)) {
		var latlng = parseLatLng(query);
		if (latlng == null) {
			document.getElementById("query").value = "";
		} else {
			reverseGeocode(latlng);
		}
	} else {
		forwardGeocode(query);
	}
}

function initGeocoder(query) {
	selected = null;
	
	var hash = 'q=' + query;
	var geocoder = new GClientGeocoder();
	
	hashFragment = '#' + escape(hash);
	window.location.hash = escape(hash);
	return geocoder;
}

function forwardGeocode(address) {
        
	var geocoder = initGeocoder(address);
	geocoder.getLocations(address, function(response) {
		showResponse(response, false);
	});
}

function reverseGeocode(latlng) {
	var geocoder = initGeocoder(latlng.toUrlValue(6));
	geocoder.getLocations(latlng, function(response) {
		showResponse(response, true);
	});
}

function parseLatLng(value) {
	value.replace('/\s//g');
	var coords = value.split(',');
	var lat = parseFloat(coords[0]);
	var lng = parseFloat(coords[1]);
	if (isNaN(lat) || isNaN(lng)) {
		return null;
	} else {
		return new GLatLng(lat, lng);
	}
}

function showResponse(response, reverse) { 
	if (! response) {
		alert("Geocoder request failed");
	} else {
		latlng = new GLatLng(response.Placemark[0].Point.coordinates[1],
							 response.Placemark[0].Point.coordinates[0]);
		set_position(latlng);
	}
}

function doGeolocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(positionSuccess, positionError);
		} else {
                        latlng =get_current_location_by_ip();
                        positionSuccess(latlng);
		}
	}

function positionError(err) {
	//
	//alert(err);
}

function positionSuccess(position) {
	// Centre the map on the new location
        
        if (position instanceof GLatLng) { // it is google wifi geolocation or ip geolocation?
            var new_latLng = position;
        } else {
            var coords = position.coords;
            var new_latLng = new GLatLng(coords.latitude, coords.longitude);
        }
	
        set_location(new_latLng, false);
}

$(document).ready(function () {
	$('a.view-map-link').click(function () {
		$(this.parentNode.parentNode).children(".map").slideToggle("fast");
		return false;
	});
});

function getObjectClass(obj) {
    if (obj && obj.constructor && obj.constructor.toString) {
        var arr = obj.constructor.toString().match(
            /function\s*(\w+)/);

        if (arr && arr.length == 2) {
            return arr[1];
        }
    }

    return undefined;
}



</script>