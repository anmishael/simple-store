var _maps = new Object();
var _loaded = 0;
var _interval;
function fixVisibility() {
	if(_loaded>=3) {
		$('.scroll-pane').jScrollPane( { showArrows :false, verticalDragMaxHeight: 42 } );
		$('#public-area div.section div.box').removeClass('visible');
		$('#public-area div.section div.box:first').addClass('visible');
		clearInterval(_interval);
	}
}
$(document).ready(function() {
	var locname = $('#product-view h1').text();
	var latlng = new Array();
	var options = new Array();
	var _i = 0;
	if(google) {
	var _markerIcon = new google.maps.MarkerImage(
			templateDir+'css/images/icons/pin.png',
			new google.maps.Size(26, 49),
			new google.maps.Point(0, 0),
			new google.maps.Point(5, 37)
		);
	for(k_place in allplaces) {
		var k_place_css_name = k_place.replace('_', '-');
		
		latlng[_i] = new google.maps.LatLng(lat, lng);
		options[_i] = {
				zoom: 14,
				center: latlng[_i],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
		
		_maps[k_place] = new Object();
		_maps[k_place].map = new google.maps.Map($('#public-area-'+k_place_css_name+'-map')[0], options[_i]);
		$('#public-area-'+k_place_css_name+'-list').append('<ul></ul>');
		_maps[k_place].list = $('#public-area-'+k_place_css_name+'-list ul:first');
		_maps[k_place].markericon = new google.maps.MarkerImage(
				templateDir+allplacesicons[k_place],
				new google.maps.Size(26, 49),
				new google.maps.Point(0, 0),
				new google.maps.Point(5, 37)
			);
		_maps[k_place].markers = new Array();
		_maps[k_place].infowindows = new Array();
		_maps[k_place].markers[_i] = new google.maps.Marker({
	    	map: _maps[k_place].map,
	    	icon: _markerIcon,
	    	position: latlng[_i],
	    	title: locname
	    });
		
		_maps[k_place].bounds = new google.maps.LatLngBounds();
		_maps[k_place].bounds.extend(latlng[_i]);
		_ix = 0;
		for(kx_place in allplaces[k_place]) {
			var _place_item = allplaces[k_place][kx_place];
			var kx_loc = new google.maps.LatLng(_place_item.latitude, _place_item.longitude);
			_maps[k_place].markers[_ix] = new google.maps.Marker({
				index: _ix,
				place: k_place,
            	map: _maps[k_place].map,
            	icon: _maps[k_place].markericon,
            	position: kx_loc,
            	title: _place_item.name+_place_item.phone
            });
			_maps[k_place].list.append('<li>'+_place_item.name+'</li>');
			_maps[k_place].map.setCenter(kx_loc);
			_maps[k_place].bounds.extend(kx_loc);
			var _txt = '<div><b>'+_place_item.name+'</b></div>';
			for(k in _place_item.extra) {
				_txt += '<div>'+_place_item.extra[k].name+': '+_place_item.extra[k].content+'</div>';
			}
			_maps[k_place].infowindows[_ix] = new google.maps.InfoWindow({
				content: _txt
			});
			google.maps.event.addListener(_maps[k_place].markers[_ix], 'click', function () {
				var _index = this.index;
				var _place = this.place;
				_maps[_place].infowindows[_index].open(_maps[_place].map, _maps[_place].markers[_index]);
			});
			_ix++;
		}
		_maps[k_place].map.fitBounds(_maps[k_place].bounds);
		_loaded++;
		_i++;
	}
//cnt_students:Students;cnt_male:Male;cnt_female:Female;cnt_native:Native;cnt_asian:Asian;cnt_black:Afro American;cnt_hispanic:Hispanic;cnt_white:White;cnt_freelunch:Freelunch;cnt_reduced:Reduced
//e_address:Address;e_zip_full:Zip;biz_phone:Phone;web_url:Web site;
	
	_interval = setInterval('fixVisibility()', 500);
	
	$('ul.videos a.video.path').each(function(i, _v) {
		eval('var rel = '+$(this).attr('rel'));
		rel.path = $(this).attr('href');
		$('#'+rel.prefix+'-player').jPlayer({
			ready: function () {
//				alert('/videos/products/'+rel.pid+'/'+rel.path);
//				$(this).jPlayer("setFile",'/videos/products/'+rel.pid+'/'+rel.path).play();
				switch (rel.mimepart) {
				case 'webm':
				case 'webmv':
					$(this).jPlayer("setMedia", {
						webmv: siteUrl+rel.path
					});
					break;
					break;
				case 'ogv':
				case 'ogg':
					$(this).jPlayer("setMedia", {
						ogv: siteUrl+rel.path
					});
					break;
					break;
				case 'x-m4v':
					$(this).jPlayer("setMedia", {
						m4v: siteUrl+rel.path
					});
					break;
				default:
					break;
				}
				
			},
			swfPath: "/templates/forrent/js/Jplayer.swf",
			supplied: "webmv, ogv, m4v",
			size: {
				cssClass: "jp-video-270p"
			},
			cssSelectorAncestor: '#'+rel.prefix+'-container',
			errorAlerts: true,
			warningAlerts: true
		});
	});
	}
	$('.print').bind('click', function() {
		var container = $(this).attr('rel');
		$('#' + container).printArea();
		return false;
	});
});