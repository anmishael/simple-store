var geocoder;
var map;
var _markers = new Array();
$(document).ready(function() {
	if($("#product-list-list-map")[0]) {
		if(google) {
		geocoder = new google.maps.Geocoder();
			var lat = 0;
			var lng = 0;
			var latlng = new google.maps.LatLng(lat, lng);
			var options = {
					zoom: 14,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
			map = new google.maps.Map($("#product-list-list-map")[0], options);
			var bounds = new google.maps.LatLngBounds();
			var _markerIcon = new google.maps.MarkerImage(
					templateDir+'css/images/icons/pin.png',
					new google.maps.Size(26, 49),
					new google.maps.Point(0, 0),
					new google.maps.Point(5, 37)
				);
			$('.product-list-item .location .product-name').each(function(i,v) {
				eval('var _loc=' + $(this).attr('rel'));
				var latlng = new google.maps.LatLng(_loc.lat, _loc.lng);
				var _md5res = $().crypt( { method: 'md5', source: _loc.lat+':'+_loc.lng } );
				if(!_markers[_md5res]) {
					var marker = new google.maps.Marker({
			        	map: map, 
			        	position: latlng,
			        	icon: _markerIcon,
			        	title: $(this).text()
			        });
					_markers[_md5res] = latlng;
					map.setCenter(_markers[_md5res]); 
				} else {
					map.setCenter(_markers[_md5res]); 
				}
				bounds.extend(_markers[_md5res]);
			});
			map.fitBounds(bounds);
		}
		$('#btn-page-contract-map').bind('click', function() {
			$('#product-list-list-map').hide();
			$('#btn-page-contract-map').hide();
			$('#btn-page-expand-map').show();
			return false;
		});
		$('#btn-page-expand-map').bind('click', function() {
			$('#product-list-list-map').show();
			$('#btn-page-expand-map').hide();
			$('#btn-page-contract-map').show();
			return false;
		});
		$('#btn-page-contract-map').removeClass('hidden').show();
		$('#btn-page-expand-map').removeClass('hidden').hide();
	}
	
	//Add to favorites
	$('a.add-to-favorites').bind('click', function() {
		var item = this;
		$.ajax({
			url: $(this).attr('href')+'&doctype=xml',
			dataType: 'xml',
			success: function(data) {
				$(this).removeLoading();
				if($(data).find('result') && $(data).find('result').text() == 'ERROR') {
					$(this).displayErrors(data);
				} else {
					if($(data).find('result').text() == 'SUCCESS') {
						$(item).parent().find('.in-favorites').removeClass('hidden');
						$(item).addClass('hidden');
					}
				}
			}
		});
		return false;
		return false;
	});
});