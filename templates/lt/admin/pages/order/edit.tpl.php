<?php
/**
 * Created on 23 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
?>
<ul class="links-list">
	<?php foreach($this->_toplinks as $k=>$link) { ?>
    <li><a href="<?php echo $link['url'] . '?id='.$this->_item->get('id'); ?>"><?php echo $link['name'];?></a></li>
    <li class="clear"></li>
	<?php } ?>
</ul>
<?php if($this->_item->get('id')) { ?>
	<h2>Edit "#<?php echo $this->_item->get('id')?>" order</h2>
<?php if($this->_item->get('user')) { ?>
	<strong><?php
	echo sprintf(
		$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_OPENED', 'value')->get('value'),
		$this->_item->get('username'),
		$this->_item->get('opened'));
	?></strong>
<?php } ?>
<?php } else { ?>
	<h2><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_ORDER', 'value')->get('value'); ?></h2>
<?php } ?>
<form id="admin-order-edit-form" action="<?php echo $this->_core->getActionUrl('admin-order-save');?>" method="post">
	<table>
	<tr>
		<td><label for="admin-order-edit-form-id"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ORDER_NUMBER', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('id'); ?></td>
	</tr>
	<tr class="no-print">
		<td><label for="admin-order-edit-form-status"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?></label></td>
		<td>
			<?php $stat = $this->_statuses[$this->_item->get('status')] instanceof Model_Order_Status ? $this->_statuses[$this->_item->get('status')]->get('name') : $this->_item->get('status'); ?>
			<select name="status">
			<?php foreach($this->_statuses as $status) { ?>
				<option value="<?php echo $status->get($status->_id); ?>"<?php echo ($status->get($status->_id) == $this->_item->get('status'))?' selected="selected"':''; ?>><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_ORDER_'.strtoupper($status->get('name')))->get('value'); ?></option>
			<?php } ?>
			</select></td>
	</tr>
		<tr>
			<td><label for="admin-order-edit-form-code"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?></label></td>
			<td><?php echo $this->_item->get('cardcode'); ?></td>
		</tr>
	<tr>
		<td><label for="admin-order-edit-form-name-first"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_FIRST', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('name_first'); ?></td>
	</tr>
	<tr>
		<td><label for="admin-order-edit-form-name-last"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_LAST', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('name_last'); ?></td>
	</tr>
	<tr class="no-print">
		<td><label for="admin-order-edit-form-email"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EMAIL', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('email'); ?></td>
	</tr>
	<tr>
		<td><label for="admin-order-edit-form-phone"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PHONE', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('phone'); ?></td>
	</tr>
	<tr class="no-print">
		<td><label for="admin-order-edit-form-email"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EMAIL', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('email'); ?></td>
	</tr>
	<tr class="no-print">
		<td><label for="admin-order-edit-form-billname-first"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_BILLNAME_FIRST', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('billname_first'); ?></td>
	</tr>
	<tr class="no-print">
		<td><label for="admin-order-edit-form-billname-last"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_BILLNAME_LAST', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('billname_last'); ?></td>
	</tr>
	<tr class="no-print">
		<td><label for="admin-order-edit-form-shipname-first"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SHIPNAME_FIRST', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('shipname_first'); ?></td>
	</tr>
	<tr class="no-print">
		<td><label for="admin-order-edit-form-shipname-last"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SHIPNAME_LAST', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('shipname_last'); ?></td>
	</tr>
	<tr>
		<td><label for="admin-order-edit-form-shipaddress1"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SHIPADDRESS', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('shipaddress1'); ?>, <?php echo $this->_item->get('shipcity'); ?>, <?php echo $this->_item->get('shipstate'); ?></td>
	</tr>
	<tr>
		<td><label for="admin-order-edit-form-shipphone"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SHIPPHONE', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('shipphone'); ?></td>
	</tr>
	<tr>
		<td><label for="admin-order-edit-form-shipping-method"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SHIPPING_METHOD', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('shipping_method'); ?></td>
	</tr>
		<tr>
			<td><label for="admin-order-edit-form-comment"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_COMMENT', 'value')->get('value'); ?></label></td>
			<td><?php echo $this->_item->get('comment'); ?></td>
		</tr>
	<tr>
		<td><label for="admin-order-edit-form-total"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TOTAL', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('total'); ?> <?php echo $this->_item->get('currency'); ?></td>
	</tr>
	<tr>
		<td><label for="admin-order-edit-form-created"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CREATED', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('created'); ?></td>
	</tr>
	<tr class="no-print">
		<td><label for="admin-order-edit-form-changed"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CHANGED', 'value')->get('value'); ?></label></td>
		<td><?php echo $this->_item->get('changed'); ?></td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRODUCTS', 'value')->get('value'); ?></td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="product-list" cellspacing="0" cellpadding="4" border="1">
				<tr>
					<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?></th>
					<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SKU', 'value')->get('value'); ?></th>
					<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?></th>
					<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?></th>
					<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_QTY', 'value')->get('value'); ?></th>
					<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TOTAL', 'value')->get('value'); ?></th>
				</tr>
				<?php $products = $this->_item->get('products'); ?>
				<?php foreach($products as $product) { ?>
				<?php
				/** @var $item Model_Product */
				$bundle = null;
				$bundles = $product->fetchBundles()->get('bundles');

				if(sizeof($bundles)>0) {
					$bundle = array_shift($bundles);
				}
				?>
				<tr>
					<td><?php echo $product->get('code'); ?></td>
					<td><?php echo $product->get('sku'); ?></td>
					<td><?php if($bundle instanceof Model_Product_Bundle) { echo $bundle->get('name'); }?> <?php echo $product->get('name'); ?></td>
					<td><?php echo $product->get('price'); ?> <span  class="no-print"><?php echo $this->_item->get('currency'); ?></span></td>
					<td><?php echo $product->get('qty'); ?></td>
					<td><?php echo $product->get('total'); ?> <span class="no-print"><?php echo ($this->_currency instanceof Model_Currency) ? $this->_currency->get('label') : $this->_item->get('currency'); ?></span></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="5" align="right"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TOTAL', 'value')->get('value'); ?></td>
					<td><strong><?php echo $this->_item->get('total'); ?> <?php echo ($this->_currency instanceof Model_Currency) ? $this->_currency->get('label') : $this->_item->get('currency'); ?></strong></td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
</form>