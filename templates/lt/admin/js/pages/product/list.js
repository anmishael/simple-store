var geocoder;
var map;
var _markers = new Array();
$(document).ready(function() {
	geocoder = new google.maps.Geocoder();
	$('#admin-pages-product-list-search-clear').bind('click', function() {
		window.location = adminUrl+'product/list';
		return false;
	});
	$('a.google-map-passive').bind('click', function() {
		eval('var _cur_loc='+$(this).attr('rel'));
		var latlng = new google.maps.LatLng(_cur_loc.lat, _cur_loc.lng);
		var _md5res = MD5(_cur_loc.lat+':'+_cur_loc.lng);
		if(!$('#admin-product-list-latlong-map')[0]) {
			$(this).raiseInfo('<div id="admin-product-list-latlong-map"></div>');
			$('#dialog-box #content #admin-product-list-latlong-map').css({ height: '100%', width:'100%' });
			
			var options = {
				zoom: 14,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			map = new google.maps.Map(document.getElementById("admin-product-list-latlong-map"), options);
		} else {
			$(this).showDialog();
		}
		if(!_markers[_md5res]) {
			var marker = new google.maps.Marker({
	        	map: map, 
	        	position: latlng,
	        	title: $(this).attr('alt')
	        });
			_markers[_md5res] = latlng;
			map.setCenter(_markers[_md5res]); 
		} else {
			map.setCenter(_markers[_md5res]); 
		}
	});
});