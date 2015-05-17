<?php
/**
 * Created on 22 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
?>
<div id="cart-box">
	<div class="title"><a href="<?php echo $this->topFolder; ?>cart/list"><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_BOX_TITLE')->get('value'); ?></a></div>
	<div class="count"><?php echo $this->_cart->size()>0
		?sprintf($this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_COUNT')->get('value'),$this->_cart->size()) . ' <b style="white-space:nowrap;"><span class="price">' . $this->_cart->subtotalsumm() . '</span> <span class="price-label">' . $this->_currency->get('label') . '</span></b>'
		:$this->_core->getModel('Translate/Collection')->get('CART_NO_PRODUCTS')->get('value'); ?></div>
	<div class="button"><a href="<?php echo $this->topFolder; ?>checkout"><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_BOX_CHECKOUT')->get('value'); ?></a></div>
</div>