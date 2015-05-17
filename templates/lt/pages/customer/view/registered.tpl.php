<?php
/**
 * Created on 25 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
?>
<div id="page-customer-view-registered">
	<div class="section">
		<table width="100%" cellspacing="0" cellpadding="5">
		<tr class="tabs">
			<td class="current" width="14%" align="center" id="my-profile-tab"><a name="my-profile"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_VIEW_MY_PROFILE')->get('value'); ?></a></td>
			<td width="14%" align="center" id="my-orders-tab"><a name="my-orders"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_VIEW_MY_ORDERS')->get('value'); ?></a></td>
			<td class="rest" width="72%"></td>
		</tr>
		<tr class="content">
			<td colspan="3" class="main">
			<div class="box current">
				<div class="profile-view">
					<table cellspacing="0" cellpadding="5" border="0">
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_FIRST')->get('value'); ?></td>
							<td><?php echo $this->_customer->get('name_first'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_LAST')->get('value'); ?></td>
							<td><?php echo $this->_customer->get('name_last'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_EMAIL')->get('value'); ?></td>
							<td><?php echo $this->_customer->get('email'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_STATE')->get('value'); ?></td>
							<td><?php echo $this->_customer->get('state'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_CITY')->get('value'); ?></td>
							<td><?php echo $this->_customer->get('city'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_ADDRESS1')->get('value'); ?></td>
							<td><?php echo $this->_customer->get('address1'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_ADDRESS2')->get('value'); ?></td>
							<td><?php echo $this->_customer->get('address2'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_PHONE')->get('value'); ?></td>
							<td><?php echo $this->_customer->get('phone'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_CARDCODE')->get('value'); ?></td>
							<td><?php echo $this->_customer->get('cardcode'); ?></td>
						</tr>
						<tr>
							<td colspan="2"><input type="button" class="submit button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('BUTTON_EDIT')->get('value'); ?>" /></td>
						</tr>
					</table>
				</div>
				<div class="profile-edit hidden"><form action="/customer/save" method="post">
					<table cellspacing="0" cellpadding="5" border="0">
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_FIRST')->get('value'); ?></td>
							<td><input type="text" name="name_first" value="<?php echo $this->_customer->get('name_first'); ?>" /></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_LAST')->get('value'); ?></td>
							<td><input type="text" name="name_last" value="<?php echo $this->_customer->get('name_last'); ?>" /></td>
						</tr>
						<!--<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_EMAIL')->get('value'); ?></td>
							<td><input type="text" name="email" value="<?php echo $this->_customer->get('email'); ?>" /></td>
						</tr>-->
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_STATE')->get('value'); ?></td>
							<td><input type="text" name="state" value="<?php echo $this->_customer->get('state'); ?>" /></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_CITY')->get('value'); ?></td>
							<td><input type="text" name="city" value="<?php echo $this->_customer->get('city'); ?>" /></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_ADDRESS1')->get('value'); ?></td>
							<td><input type="text" name="address1" value="<?php echo $this->_customer->get('address1'); ?>" /></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_ADDRESS2')->get('value'); ?></td>
							<td><input type="text" name="address2" value="<?php echo $this->_customer->get('address2'); ?>" /></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_PHONE')->get('value'); ?></td>
							<td><input type="text" name="phone" value="<?php echo $this->_customer->get('phone'); ?>" /></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_CARDCODE')->get('value'); ?></td>
							<td><input type="text" name="cardcode" value="<?php echo $this->_customer->get('cardcode'); ?>" /></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_PASSWORD')->get('value'); ?></td>
							<td><input type="password" name="password" value="" /></td>
						</tr>
						<tr>
							<td><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_PASSWORD_CONFIRM')->get('value'); ?></td>
							<td><input type="password" name="password_confirm" value="" /></td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="button" class="cancel button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('BUTTON_CANCEL')->get('value'); ?>" />
								<input type="submit" class="submit button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('BUTTON_SAVE')->get('value'); ?>" />
							</td>
						</tr>
					</table></form>
				</div>
		</div>
		<div class="box">
			<?php
			$_p_start = $this->_current_page - 2;
			if($_p_start <= 0) {
				$_p_start = 1;
			}
			$_p_end = $this->_current_page + 2;
			if($_p_end > $this->_totalpages) {
				$_p_end = $this->_totalpages;
			}
			$m_items_per_bundle = 5;
			?>
			<div class="orders">
			<?php foreach($this->_orders as $order) { ?>
				<div class="order">
					<div class="date"><?php echo $order->get('created'); ?></div>
					<div class="desc">
						<a href="javascript:;" class="link">
							<span class="order">№<?php echo $order->get($order->_id); ?></span>
							<span class="billname"><?php echo $order->get('billname_first') . ' ' . $order->get('billname_last'); ?></span>
							<span class="total"><?php echo $order->get('total') . ' ' . $order->get('currency'); ?></span>
							<span class="status"><?php echo $order->get('status'); ?></span>
							<span class="shipping"><?php echo $order->get('shipping_method'); ?></span>
							<span class="clear"></span>
						</a>
						<?php $products = $order->fetchProducts()->get('products'); ?>
						<table class="products" cellspacing="0" cellpadding="4">
							<tr>
								<td><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_CODE')->get('value'); ?></td>
								<td><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_SKU')->get('value'); ?></td>
								<td><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_NAME')->get('value'); ?></td>
								<td><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_PRICE')->get('value'); ?></td>
								<td><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_DISCOUNT_QTY')->get('value'); ?></td>
								<td><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_DISCOUNT_SUMM')->get('value'); ?></td>
							</tr>
							<?php foreach($products as $product) { ?>
							<tr>
								<td><?php echo $product->get('code'); ?></td>
								<td><?php echo $product->get('sku'); ?></td>
								<td><?php echo $product->get('name'); ?></td>
								<td><?php echo $product->get('price'); ?></td>
								<td><?php echo $product->get('qty'); ?></td>
								<td><?php echo $product->get('total'); ?></td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			<?php } ?>
			</div>
			<form action="<?php echo $this->_url; ?>">
				<div class="pagination">
					<div class="pages"><?php if($this->_totalpages>1) { ?>
						<ul>
							<?php if($_p_start>1) { ?>
							<li><a href="?_p=<?php echo ($this->_page-1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>#my-orders"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_PREV')->get('value'); ?></a></li>
							<?php } ?>
							<?php for($k = $_p_start; $k <= $_p_end; $k++) { ?>
							<li><a<?php if($k == $this->_page) { ?> class="selected"<?php } ?> href="?_p=<?php echo $k . '&' . $this->_core->getAllGetParams(array('_p')); ?>#my-orders"><?php echo $k; ?></a></li>
							<?php }?>
							<?php if($_p_end<$this->_totalpages) { ?>
							<li><a href="?_p=<?php echo ($this->_page+1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>#my-orders"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_NEXT')->get('value'); ?></a></li>
							<?php } ?>
							<?php if($this->_totalpages>1) { ?>
							<li>&nbsp;</li>
							<li><select name="_p" onchange="this.form.submit();">
								<?php for($k = 1; $k <= $this->_totalpages; $k++) { ?>
								<option value="<?php echo $k; ?>"<?php if($k == $this->_page) { ?> selected="selected"<?php } ?>><?php echo $k; ?></option>
								<?php } ?>
							</select></li>
							<?php } ?>
							<li class="clear"></li>
						</ul><?php } ?>
					</div>
				</div></form>
		</div>
		</td></tr></table>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#page-customer-view-registered .section .box:not(.current)').hide();
	$('#page-customer-view-registered .tabs').delegate('td:not(.current)', 'click', function() {
		if(!$(this).hasClass('rest')) {
			$(this).addClass('current').siblings().removeClass('current')
				.parents('.section').find('.box').eq($(this).index()).fadeIn(150).siblings('.box').hide();
		}
	});
	$('.orders .order .desc .products').hide();
	$('.orders .order .desc .link').bind('click', function() {
		if($(this).parents('.desc').find('.products:hidden')[0]) {
			$(this).parents('.desc').find('.products:hidden').fadeIn('slow');
		} else {
			$(this).parents('.desc').find('.products').not(':hidden').fadeOut('fast');
		}
	});
	$('.profile-edit').removeClass('hidden').hide();
	$('.profile-view input[type=button]').bind('click', function() {
		$('.profile-view').hide();
		$('.profile-edit').show();
	});
	$('.profile-edit input[type=button].cancel').bind('click', function() {
		$('.profile-edit').hide();
		$('.profile-view').show();
	});
	var url = window.location.toString();
	if(url.indexOf('#')>-1) {
		var ctabid = url.toString().substr(url.indexOf('#'))+'-tab';
		if($(ctabid)[0]) {
			$(ctabid).removeClass('current').addClass('current').show().siblings().removeClass('current');
			$('#page-customer-view-registered .tabs').parent().find('.content .box').removeClass('current').hide();
			$('#page-customer-view-registered .tabs').parent().find('.content .box').eq($(ctabid).index()).addClass('current').show();
//			$('#page-customer-view-registered .tabs').delegate('td:not(.current)', 'click', function() {
//				$(this).addClass('current').siblings().removeClass('current')
//						.parents('.section').find('.box').eq($(this).index()).fadeIn(150).siblings('.box').hide();
//			});
		}
	}
});
</script>