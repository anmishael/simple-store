<?php
/**
 * Created on 22 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
?>
<div id="checkout-option" class="sub-content">
<div id="checkout-stages">
<div id="s1_login" class="stage current">
<div class="stagecontent">
<div class="wrapper">
	<div class="content text-content horizontal">
	<form action="/checkout/process" method="post">
	<div class="checkout-confirm">
	<dl class="form">
		<dt><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_BILLING_NAME_FIRST')->get('value'); ?> </dt>
		<dd><?php echo $this->_params['arrCustomer']['name_first']; ?></dd>
		<dt><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_BILLING_NAME_LAST')->get('value'); ?> </dt>
		<dd><?php echo $this->_params['arrCustomer']['name_last']; ?></dd>
		<dt><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_NAME_FIRST')->get('value'); ?> </dt>
		<dd><?php echo $this->_params['arrCustomer']['shipname_first']; ?></dd>
		<dt><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_NAME_LAST')->get('value'); ?> </dt>
		<dd><?php echo $this->_params['arrCustomer']['shipname_last']; ?></dd>
		<dt><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_ADDRESS')->get('value'); ?> </dt>
		<dd><?php echo $this->_params['arrCustomer']['shipcity'] . ', ' . $this->_params['arrCustomer']['shipstate'] . ', ' . $this->_params['arrCustomer']['shipaddress1']; ?></dd>
		<dt><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_PHONE')->get('value'); ?> </dt>
		<dd><?php echo $this->_params['arrCustomer']['shipphone']; ?></dd>
		<dt><?php echo $this->_core->getModel('Translate/Collection')->get('CART_PRODUCT_TOTAL')->get('value'); ?> </dt>
		<dd><?php echo $this->_params['cartTotal']; ?> <?php echo $this->_params['arrCurrency']['label']; ?></td>
		<dt><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_NOTES')->get('value'); ?></dt>
		<dd><?php echo $_SESSION['lastpost']['comment']; ?></dd>
		<dd class="clear">&nbsp;</dd>
			<dd class="submit buttons">
				<button class="btn-next-step continue" type="submit"><span><?php echo $this->_core->getModel('Translate/Collection')->get('CART_CHECKOUT_CONFIRM')->get('value'); ?></span></button>
			</dd>
</dl>
<input type="hidden" name="checkout" value="go" />
</div>
</form>
		<div class="clear"></div>
	</div>
</div>
</div>
</div>
</div>
</div>