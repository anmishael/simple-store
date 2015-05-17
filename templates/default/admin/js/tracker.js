/**
 * Created with JetBrains PhpStorm.
 * User: mikel
 * Date: 30.03.13
 * Time: 11:38
 * To change this template use File | Settings | File Templates.
 */
(function( $ ) {
	$.fn.tracker = function(options) {
		this.defaultOptions = {
			refresh: 1000
		}
		this.inited = false;
		this._continue = false;
		this.interval = null;
		this.iter = 0;
		var _this = this;
		this.init = function (options) {
			this.options = $.extend({}, this.defaultOptions, options);
			if(!this.inited) {
				this.tracker();
				this.inited = true;
			}
			return this;
		}
		this.fetch = function() {
			var file = $(this).attr('rel');
			var time = new Date().getTime();
			$.ajax({
				url: file+'?time='+time,
				dataType: 'html',
				success: function(data) {
					if(data.trim().length>0 && parseInt(data.indexOf('html'))<0) {
						eval('var data = {'+data+'}');
						$(document).raiseInfo('...', data);
					} else {
						data = { current:0, records:1 }
					}
					if(_this._continue == true && (data.current<data.records||_this.iter<5)) {
						_this.interval = setTimeout(function() { _this.fetch(); }, _this.options.refresh);
						_this.iter++;
					}
				}
			});
		}
		this.start = function() {
			_this.interval = setTimeout(function() { _this.fetch(); }, _this.options.refresh);
			_this._continue = true;
			_this.iter = 0;
		}
		this.stop = function() {
			_this._continue = false;
			clearInterval(_this.interval);
		}
		this.tracker = function() {
			if(_this.inited) return false;
			this.bind();
		}
		this.bind = function() {
			if(_this.options.form) {
				if($(this).prop('tagName')=='A' || $(this).prop('tagName')=='a') {
					$(this).bind('click', function() {
						var form = $(_this.options.form);
						var data = $(form).serialize()+'&_import=1&doctype=xml';
						$.ajax({
							url: $(form).attr('action')+'?doctype=xml',
							data: data,
							type: $(form).attr('method'),
							success: function() {
								$(document).raiseInfo('Done');
							}
						});
						_this.start();
						return false;
					});
				}
			} else {
				$(this).bind('click', function() {
					_this.start();
					$.ajax({
						url: $(this).attr('href')+'&doctype=xml',
						success: function() {
							$(document).raiseInfo('Done');
						}
					});
					return false;
				});
			}
			$('#dialog-box #content a.dialog-close').bind('click', function() {
				_this.stop();
			});
		}
		this.init(options);
	}
})(jQuery);