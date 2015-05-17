/**
 * Created with JetBrains PhpStorm.
 * User: mikel
 * Date: 03.04.13
 * Time: 22:57
 * To change this template use File | Settings | File Templates.
 */
(function( $ ) {
	$.fn.shoppingCart = function(options) {
		this.defaultOptions = {
		}
		var _this = this;
		var inited = false;
		this.images = new Array();
		this.popupBlock = null;
		this.init = function (options) {
			this.options = $.extend({}, this.defaultOptions, options);
			if(!this.inited) {
				this.inited = true;
			}
			return this;
		}
		this.submitForm = function() {
			$.ajax({
				url: _this.attr('action')+'?doctype=xml',
				data: _this.serialize(),
				dataType: 'xml',
				type: 'post',
				success: function(data) {
					if($(data).find('result').text() == 'SUCCESS') {
//						if(!$('#cart-box .price')[0]) {
						$('#cart-box .count').empty().append(sprintf(Translate.get('CART_PRODUCT_COUNT'),$(data).find('cart item').length)+' \n ');
						$('#cart-box .count').append($('<a href="/cart/list"><b style="white-space:nowrap;"><span class="price">'+$(data).find('cart').attr('total')+'</span> <span class="price-label">'+$(data).find('cart').attr('currency')+'</span></b></a>'));
//						}
//						$('#cart-box .price').empty().append($(data).find('cart').attr('total'));
//						$('#cart-box .price-label').empty().append($(data).find('cart').attr('currency'));
					}
				}
			});
			return false;
		}
		this.bind('submit', function() {
			return _this.submitForm();
		});
		if(!this.inited) {
			this.init(options);
		}
		return this;
	}
})(jQuery);
$(document).ready(function() {
	$('form.add-to-cart-form').shoppingCart();
});