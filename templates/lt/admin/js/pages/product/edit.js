var geocoder;
var map;
var _current_locations;
$(document).ready(function() {
	geocoder = new google.maps.Geocoder();
	$('#admin-product-edit-form-latlong .icon.view-refresh').bind('click', function() {
		var address = $('#admin-product-edit-form-address').attr('value');
		var location = address.trim() + ',' + _current_zip.trim() + ',' + _current_city.trim() + ',' + _current_state.trim();
		$('#admin-product-edit-form-latlong div.title').empty();
		geocoder.geocode(
			{ 'address': location }
		, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
	       		$('#admin-product-edit-form-latlong div.title').empty();
	       		_current_locations = results;
	            for(k = 0; k<results.length; k++) {
	            	var lat = results[k].geometry.location.lat();
	            	var lng = results[k].geometry.location.lng();
	            	$('#admin-product-edit-form-latlong div.title').append('<div><a href="javascript:;" title="Result types: '+results[k].types+'">'+(k+1)+'. '+lat+', '+lng+'</a>'+
	            					'<a class="icon dialog-ok" rel="{ lat:'+lat+',lng:'+lng+',locnum:'+k+' }" href="javascript:;" title="apply"><span class="title">apply</span></a>\n'+
	            					'<a class="icon google-map-passive" rel="{ lat:'+lat+',lng:'+lng+',locnum:'+k+' }" href="javascript:;" title="view on map"><span class="title">view on map</span></a>\n'+
	            					'</div>');
	            }
	            $('#admin-product-edit-form-latlong div.title a.google-map-passive').unbind('click').bind('click', function() {
	            	if(!$('#admin-product-edit-form-latlong-map')[0]) {
	           			$('#admin-product-edit-form-latlong-row').append('<div id="admin-product-edit-form-latlong-map" style="width: 100%; height: 220px; position: relative;"></div>');

	           			var latlng = new google.maps.LatLng(lat, lng);
	           			var options = {
	           					zoom: 14,
	           					center: latlng,
	           					mapTypeId: google.maps.MapTypeId.ROADMAP
	           			}
	           			map = new google.maps.Map(document.getElementById("admin-product-edit-form-latlong-map"), options);
	            	}
		            eval('var _cur_loc='+$(this).attr('rel'));

		            map.setCenter(results[_cur_loc.locnum].geometry.location);
		            var marker = new google.maps.Marker({
		            	map: map, 
		            	position: results[_cur_loc.locnum].geometry.location,
		            	title: (_cur_loc.locnum+1) + '. result: '+_cur_loc.lat+', '+_cur_loc.lng+'\n\n'+_current_locations[_cur_loc.locnum].types
		            });
	            });
	            $('#admin-product-edit-form-latlong div.title a.dialog-ok').unbind('click').bind('click', function() {
	            	eval('var _cur_loc='+$(this).attr('rel'));
	            	$('#admin-product-edit-form-latlong input[name=latitude]').attr('value', _cur_loc.lat);
	            	$('#admin-product-edit-form-latlong input[name=longitude]').attr('value', _cur_loc.lng);
	            	$('#admin-product-edit-form-latlong div.title').empty().append(_cur_loc.lat+', '+_cur_loc.lng);
	            });
			}
		});
	});
});
