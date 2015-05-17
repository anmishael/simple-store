<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 28.03.13
 * Time: 17:20
 * To change this template use File | Settings | File Templates.
 */

?>
<?php if($this->_item->get('id')>0) { ?>
	<h2>"<?php echo $this->_item->get('name')?>"</h2>
<?php } else { ?>
	<h2><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_PRICEGROUP', 'value')->get('value'); ?></h2>
<?php } ?>
<form action="<?php echo $this->_core->getActionUrl('admin-customer-pricegroup-save');?>" method="post">
	<table>
		<tr>
			<td><label for="admin-customer-pricegroup-edit-form-name"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-pricegroup-edit-form-name" name="name" value="<?php echo $this->_item->get('name')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-customer-pricegroup-edit-form-code"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-pricegroup-edit-form-code" name="code" value="<?php echo $this->_item->get('code')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-customer-pricegroup-edit-form-field"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FIELD', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-pricegroup-edit-form-field" name="field" value="<?php echo $this->_item->get('field')?>" size="32" maxlength="255" /></td>
		</tr>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$('#button-cancel').bind('click', function() {
			history.go(-1);
		});
	});
</script>