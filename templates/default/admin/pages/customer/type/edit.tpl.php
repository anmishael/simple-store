<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$permissions = $this->_item->get('permissions');
?>
<?php if($this->_item->get('id')) { ?>
<h2>Edit "<?php echo $this->_item->get('name')?>" customertype</h2>
<?php } ?>
<form action="<?php echo $this->_core->getActionUrl('admin-customer-type-save');?>" method="post">
	<table>
		<tr>
			<td><label for="admin-customer-type-edit-form-name"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-type-edit-form-name" name="name" value="<?php echo $this->_item->get('name')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-customer-type-edit-form-pricegroup"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?></label></td>
			<td>
				<select class="text" id="admin-customer-type-edit-form-pricegroup" name="pricegroup">
					<option></option>
				<?php foreach($this->_prices as $price) { ?>
					<option value="<?php echo $price->get($price->_id); ?>"<?php echo $price->get($price->_id)==$this->_item->get('pricegroup')?' selected="selected"':''; ?>><?php echo $price->get('name'); ?></option>
				<?php } ?>
				</select>
			</td>
		</tr>
	</table>
	<ul class="events innerbox">
		<?php foreach($this->arrControllers as $name=>$methods) { ?>
		<li>
			<span class="event-name"><a class="controller" rel="<?php echo $name; ?>" href="javascript:;"><?php echo $name; ?></a></span>
			<ul class="sublist" rel="<?php echo $name; ?>"><?php foreach($methods as $method=>$value) { ?>
				<li>
					<input type="checkbox" id="<?php echo $name . $method;?>" name="permissions[<?php echo $name; ?>][<?php echo $method; ?>]" value="1"<?php if(is_array($permissions) && $permissions[$name][$method]) { ?> checked="checked"<?php } ?> />
					<label for="<?php echo $name . $method; ?>"><?php echo $method; ?></label></li>
				<?php } ?></ul>
		</li>
		<?php } ?></ul>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$('#button-cancel').bind('click', function() {
			history.go(-1);
		});
		$('li .event-name a.controller').bind('click', function() {
			if($('ul.sublist[rel='+$(this).attr('rel')+']').find('input[checked=checked]')[0]) {
				$('ul.sublist[rel='+$(this).attr('rel')+']').find('input[type=checkbox]').attr('checked', false);
			} else {
				$('ul.sublist[rel='+$(this).attr('rel')+']').find('input[type=checkbox]').attr('checked', 'checked');
			}
		});
	});
</script>