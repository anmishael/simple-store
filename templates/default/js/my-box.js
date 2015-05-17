/**
 * Created with JetBrains PhpStorm.
 * User: mikel
 * Date: 14.01.13
 * Time: 9:31
 * To change this template use File | Settings | File Templates.
 */
var tag = document.createElement('script');
tag.src = "//www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var players = new Array();
(function( $ ) {
	$.fn.myBox = function(options) {
		this.defaultOptions = {
			thumbArea: '.thumbnails',
			thumbItem: '.mybox-thumb',
			thumbImageClass: '.image',
			thumbVideoClass: '.video',
			largeCo: 0.7
		}
		var _this = this;
		var inited = false;
		this.images = new Array();
		this.popupBlock = null;
		this.init = function (options) {
			this.options = $.extend({}, this.defaultOptions, options);
			if(!this.inited) {
//				var a=document.createElement("script");
//				a.setAttribute("type","text/javascript");
//				a.setAttribute("src","http://www.youtube.com/player_api");
//				a.onload = function() { _this.myBox(); this.inited = true; }
//				a.onreadystatechange = function(){
//					if (this.readyState=="complete"||this.readyState=="loaded") _this.myBox();
//				};
//				(document.getElementsByTagName("head")[0]||document.documentElement).appendChild(a);
//
				this.myBox();
				this.inited = true;
			}
			return this;
		}
		this.hideBoxDialog = function() {
			this.stopVideos();
			$('#my-box-back').hide();
			$('#my-box').hide();
			return false;
		}
		this.showBoxDialog = function() {
			$('#my-box-back').show();
//			$('#my-box').append(_this.popupBlock);
			this.applyLinks();
			$('#my-box').show();
			this.show();
		}
		this.myBox = function() {

			if(_this.inited) return false;
			_this.inited = true;
			_this.popupBlock = $('<div class="inner-block">'+
				'<div class="image-block table"><ul class="tr"></ul></div><div class="thumb-block table"><ul class="tr"></ul></div>'+'</div>');
			_this.popupBlock.prepend('<div class="arrow arrow-left"><div class="icon"></div></div><div class="arrow arrow-right"><div class="icon"></div></div>');
			_this.popupBlock.css({display: 'block'});
			_this.popupBlock.find('.arrow').hide();

			if(!$('#my-box-back')[0]) {
				$('body').append('<div id="my-box-back"></div>');
				$('#my-box-back').css({width: $(document).width()+'px', height: $(document).height()+'px'});
				$('body').append('<div id="my-box"></div>');

				$('#my-box-back').unbind('click').bind('click', function() {
					_this.hideBoxDialog();
					return false;
				});
			}
			if(!$(this).find('.mybox-large')[0]) {
				$(this).prepend($('<div class="mybox-large box-rounded table"></div>'));
			}
			$(this).find('.mybox-large').empty();
			$('#my-box').empty().append(_this.popupBlock).hide();
			this.loadImages();
		}
		this.loadImages = function() {
			var iter = 0;
			$(this).find(_this.options.thumbArea+' '+_this.options.thumbItem).each(function() {
				var link = $('<li class="td"></li>');
				var large = $('<li class="td"></li>');
				_this.popupBlock.find('.thumb-block ul').append(link);
				_this.popupBlock.find('.image-block ul').append(large);
				if($(this).hasClass(_this.options.thumbImageClass.substr(1))) {
					_this.loadImage($(this), iter);
				} else if($(this).hasClass(_this.options.thumbVideoClass.substr(1))) {
					_this.loadVideo($(this), iter);
				}
				iter++;
			});
			this.applyLinks();
		}
		this.loadVideo = function(el, i) {
			if(!$(_this.popupBlock.find('.thumb-block ul li')[i]).find('a')[0] && $.isPlainObject(YT)) {
				var rnd = _this.getRandomNumber();
				var link = $('<a href="javascript:;"></a>');
				link.append($('<img src="'+templateDir+'css/images/video.png" border="0">'));
				var videourl = decodeURIComponent($(el).attr('href'));
				while(videourl.indexOf('+')>-1) {
					videourl = videourl.replace('+', ' ');
				}
				$(_this.popupBlock.find('.image-block ul li')[i]).append($('<div class="embed-video" id="video-'+rnd+'"></div>')).hide();


//				alert(_this.popupBlock.find('.image-block ul li')[i]);
				$(el).unbind('click').bind('click', function() {
					_this.showBoxDialog();
					return false;
				});
				link.bind('click', function() {
					$(_this.popupBlock.find('.image-block ul li')[i]).show().siblings().hide();
					return false;
				});
				$(_this.popupBlock.find('.thumb-block ul li')[i]).append(link);

//				var video = $(videourl);
				var video = {width: 640, height: 480 }
				videourl = 'G__AjMWL4aE';
//				videourl = video.attr('src').split('/');
//				videourl = videourl[videourl.length-1];
//				console.log(rnd + ' ' + video.attr('width')+' ' + video.attr('height') +  ' ' + videourl);
//				$('#my-box').empty().append(_this.popupBlock);
//				alert($('#video-'+rnd).attr('id'));

				players[players.length] = new YT.Player(_this.popupBlock.find('#video-'+rnd)[0], {
					width: video.width,
					height: video.height,
					videoId: videourl
				});
			}
		}
		this.loadImage = function(el, i) {
			eval('var rel = '+$(el).attr('rel'));
			if(!_this.find('.mybox-large .tr')[0]) { _this.find('.mybox-large').append('<div class="tr"></div>'); }
			if(!_this.find('.mybox-large .tr .td')[i]) {
				_this.find('.mybox-large .tr').append('<div class="td mybox-row"><a class="mybox-thumb large" href="'+rel.large+'" onclick="return false;"></a></div>');
			}

			var images = {};
			if(!_this.images[i]) {
				if(!$('#imgLoaderArea')[0]) {
					$('body').prepend('<div id="imgLoaderArea"><div>');
				}
				_this.images[i] = images;
				if(!$('#imgLoaderAreaImageSmallID'+i)[0]) {
					images.small = new Image();
					$(images.small).attr('id', 'imgLoaderAreaImageSmallID'+i);
					images.small.src = rel.small;
					$('#imgLoaderArea').css({position: 'absolute', marginTop: '-2000px', marginLeft: '-2000px' })
						.append(images.small);
				}
				if(!$('#imgLoaderAreaImageMediumID'+i)[0]) {
					images.medium = new Image();
					$(images.medium).attr('id', 'imgLoaderAreaImageMediumID'+i);
					images.medium.src = rel.medium;
					$('#imgLoaderArea').css({position: 'absolute', marginTop: '-2000px', marginLeft: '-2000px' })
						.append(images.medium);
					images.medium.onload = function() {
//						console.log('Medium loaded['+i+']');
						$(images.medium).attr('width', images.medium.width);
						$(images.medium).attr('height', images.medium.height);
						if(i>0) {
							$(_this.find('.mybox-large .tr .td')[i]).hide();
						}
						if(!$(_this.find('.mybox-large .tr .td')[i]).find('a.large img')[0]) {
							$(_this.find('.mybox-large .tr .td')[i]).find('a.large').append(images.medium);

						}
						_this.applyLinks();
					}
				}
				if(!$('#imgLoaderAreaImageLargeID'+i)[0]) {
					images.large = new Image();
					$(images.large).attr('id', 'imgLoaderAreaImageLargeID'+i);
					images.large.src = rel.large;
					$('#imgLoaderArea').css({position: 'absolute', marginTop: '-2000px', marginLeft: '-2000px' })
						.append(images.large);
					images.large.onload = function() {
//								console.log('Large loaded['+i+']');
						var res = _this.resize(images.large);
						$(images.large).attr('width', res.width);
						$(images.large).attr('height', res.height);
						$(_this.popupBlock.find('.image-block ul li')[i]).append(images.large).hide();
						$(_this.find('.mybox-large .tr .td')[i]).find('a.large').unbind('click').bind('click', function() {

						});
						_this.applyLinks();
					}
				}

				if(!$(_this.popupBlock.find('.thumb-block ul li')[i]).find('a')[0]) {
					var link = $('<a href="'+rel.large+'"></a>');
					link.append(images.small);
					$(_this.popupBlock.find('.thumb-block ul li')[i]).append(link);
				}
			}
		}

		this.next = function() {
			var ind = $('#my-box .image-block ul li:visible').index();
			if(!ind) ind = 0;
			if($('#my-box .image-block ul li')[ind+1]) {
				ind++;
			}
			this.displayPopupImage(ind);
		}
		this.prev = function() {
			var ind = $('#my-box .image-block li:visible').index();
			if(!ind) ind = 0;
			if($('#my-box .image-block ul li')[ind-1]) {
				ind--;
			}
			this.displayPopupImage(ind);
		}
		this.showArrows = function(elindex) {
			$('#my-box .arrow').css({height: parseInt($('#my-box .image-block').height())+'px'});//.show();
			if($('#my-box .image-block li').size()>0) {
				if(!$('#my-box .image-block li').eq(elindex).prev()[0]) {
					$('#my-box .arrow-left').hide();
				} else {
					$('#my-box .arrow-left').show();
				}
				if(!$('#my-box .image-block li').eq(elindex).next()[0]) {
					$('#my-box .arrow-right').hide();
				} else {
					$('#my-box .arrow-right').show();
				}
			}
		}
		this.hideArrows = function() {
			$('#my-box .arrow').hide();
		}
		this.moveBlock = function() {
//			$('#my-box .image-block').animate({height:parseInt(height)+'px',width:parseInt(width)+'px'}, 500, function() {
//				_this.alignBox();
//			});
		}
		this.alignBox = function() {
			$('#my-box').animate({left:parseInt(($(window).width()-$('#my-box').width())/2)+'px'}, 500);
		}
		this.stopVideos = function() {
			for(k in players) {
				if(typeof players[k].stopVideo !== 'undefined') {
					players[k].stopVideo();
				}
			}
		}
		this.displayPopupImage = function(ind) {
			this.stopVideos();
			var el = $(_this.popupBlock.find('.image-block ul li')[ind]).find('img');
			var width = el.attr('width');
			_this.hideArrows();
			$('#my-box .image-block').animate({width:parseInt(width)+'px'}, 500);
			$('#my-box').animate({left:parseInt(($(window).width()-parseInt(width))/2)+'px'}, 500);
			$(_this.popupBlock.find('.image-block ul li')[ind]).css({opacity:0});
			$(_this.popupBlock.find('.image-block ul li')[ind]).show().siblings().hide();
			$(_this.popupBlock.find('.image-block ul li')[ind]).fadeTo('slow', 1.0, function() {
				if($(this).find('iframe')[0]) {
					_this.hideArrows();
				} else {
					_this.showArrows(ind);
				}
			});
		}
		this.bindArrows = function() {
			$('#my-box .arrow-left').unbind('click').bind('click', function() {
				_this.prev();
			});
			$('#my-box .arrow-right').unbind('click').bind('click', function() {
				_this.next();
			});
		}
		this.applyLinks = function() {
			$(this).find(_this.options.thumbArea+' '+_this.options.thumbItem).bind('hover', function() {
				$(_this.find('.mybox-large .tr .td')[$(this).parent().index()]).show().siblings().hide();
				return false;
			});
			this.find('.mybox-large .tr .td a').unbind('click').bind('click', function() {
				_this.displayPopupImage($(this).parent().index());
				_this.showBoxDialog();
				return false;
			});
			$(this).find(_this.options.thumbArea+' '+_this.options.thumbItem).unbind('click').bind('click', function() {
				_this.displayPopupImage($(this).parent().index());
				_this.showBoxDialog();
				return false;
			});
			$(_this.popupBlock.find('.thumb-block ul li a')).unbind('click').bind('click', function() {
				_this.displayPopupImage($(this).parent().index());
				return false;
			});
			this.bindArrows();
		}
		this.resize = function(img) {
			var width = img.width;
			var height = img.height;
			var ratio_wh = width/height;
			if(width>$(window).width()*_this.options.largeCo) {
				width = $(window).width()*_this.options.largeCo;
				height = width/ratio_wh;
			}
			if(height>$(window).height()*_this.options.largeCo) {
				height = $(window).height()*_this.options.largeCo;
				width = height*ratio_wh;
			}
			var res = { width: parseInt(width), height: parseInt(height) };
			return res;
		}
		this.getRandomNumber = function() {
			return Math.floor( Math.random()*99999 );
		}
		this.init(options);
		return this;
	}
})( jQuery );
function onYouTubePlayerAPIReady() {
	$('.mybox-view').myBox();
}