<?php
/**
 * Created on 19 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
?>
<div id="block-cart-list" class="product-list" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
	<?php if(sizeof($this->_items)>0) { ?>
	<table cellspacing="0" cellpadding="5" width="100%" class="bundleproducts">
		<tr>
			<th class="first"> &nbsp; </th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_CODE')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_SKU')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_NAME')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_PRICE')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_DISCOUNT_QTY')->get('value'); ?></th>
			<th class="last"><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_DISCOUNT_SUMM')->get('value'); ?></th>
		</tr>
	<?php foreach($this->_items as $k=>$item) { ?>
		<?php
		/** @var $item Model_Product */
		$bundle = null;
		$bundles = $item->fetchBundles()->get('bundles');

		if(sizeof($bundles)>0) {
			$bundle = array_shift($bundles);
		}
		?>
		<?php $images = $item->fetchImages()->get('images'); ?>
		<tr>
			<td class="remove"><a class="remove" href="<?php echo $this->topFolder; ?>cart/remove?id=<?php echo $item->get('id'); ?>" title="remove"><span class="title">remove</span></a></td>
			<td><?php echo $item->get('code'); ?></td>
			<td><?php echo $item->get('sku'); ?></td>
			<td><?php if($bundle instanceof Model_Product_Bundle) { echo $bundle->get('name'); }?> <?php echo $item->get('name'); ?></td>
			<td class="nowrap"><?php echo $item->getFormattedPrice() . ' ' . $this->_currency->get('label'); ?></td>
			<td class="nowrap buy">
				<form class="product-form" action="<?php echo $this->topFolder; ?>cart/add" method="get">
					<table cellspacing="0" cellpadding="0"><tr>
					<td><a class="remove" rel="<?php echo $item->get('id'); ?>"></a></td>
					<td><input type="text" class="qty" name="qty[<?php echo $item->get('id'); ?>]" value="<?php echo (int)$item->get('qty'); ?>" /></td>
					<td><a class="add" rel="<?php echo $item->get('id'); ?>"></a></td>
					</tr>
					</table>
					<input type="hidden" name="id" value="<?php echo $item->get('id'); ?>" />
            	</form>
			</td>
			<td class="nowrap"><?php echo number_format($item->get('qty')*$item->getPrice(), 2, '.', ' ') . ' ' . $this->_currency->get('label'); ?></td>
		</tr>
	<?php } ?>
	</table>
	<div class="total">
		<div class="summ"><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_TOTAL')->get('value') . ' ' . $this->_cart->subtotalsumm() . ' ' . $this->_currency->get('label'); ?></div>
		<div class="clear"></div>
	</div>
	<div class="buttons">

		<div class="btn-return link">
			<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('GO_BACK')->get('value'); ?></a>
		</div>
		<div class="btn-next-step link">
			<a href="<?php echo $this->topFolder; ?>checkout"><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PROCEED_TO_CHECKOUT')->get('value'); ?></a>
		</div>
	</div>
	<?php } else { ?>
		<?php echo $this->_core->getModel('Translate/Collection')->get('CART_NO_PRODUCTS')->get('value'); ?>
	<p>&nbsp;</p>
	<div class="buttons">
		<div class="btn-return link">
			<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('GO_BACK')->get('value'); ?></a>
		</div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('form.product-form input.qty').bind('change', function() {
			var _form = $(this).parents('form.product-form');
			$.ajax({
				url: _form.attr('action')+'?doctype=xml',
				type: _form.attr('method'),
				data: _form.serialize(),
                dataType: 'xml',
				success: function(data) {

				}
			});
		});

		$('.product-list .bundleproducts td.buy .add').unbind('click').bind('click', function() {
			if(!$(this).parents('.buy').hasClass('disabled')) {
				var val = parseInt($(this).parents('.buy').find('input.qty').val());
				if(isNaN(val)) val = 1;
				else val++;
				$(this).parents('.buy').find('input.qty').val(val);
			}
		});
		$('.product-list .bundleproducts td.buy .remove').unbind('click').bind('click', function() {
			if(!$(this).parents('.buy').hasClass('disabled')) {
				var val = parseInt($(this).parents('.buy').find('input.qty').val());
				if(isNaN(val)) val = 0;
				else if(val>0) val--;
				$(this).parents('.buy').find('input.qty').val(val);
			}
		});
		$('.btn-return a').bind('click', function() {
			history.go(-1);
			return false;
		});
	});
</script>