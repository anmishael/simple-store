<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 
?>
<?php if($this->_item->get('id')>0) { ?>
	<h2>Edit customer "<?php echo $this->_item->get('email')?>"</h2>
<?php } else { ?>
	<h2><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_CUSTOMER', 'value')->get('value'); ?></h2>
<?php } ?>
<form action="<?php echo $this->_core->getActionUrl('admin-customer-save');?>" method="post" autocomplete="off">
	<table><!--
		<tr>
			<td><label for="admin-customer-edit-form-username"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FIRST', 'value')->get('value'); ?></label></td>
			<td>
			<?php if($this->_item->get('id')) { ?>
				<?php echo $this->_item->get('username'); ?>
			<?php } else { ?>
				<input type="text" class="text" id="admin-customer-edit-form-username" name="username" value="" />
			<?php } ?>
			</td>
		</tr>-->
		<tr>
			<td><label for="admin-customer-edit-form-typeid"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TYPE', 'value')->get('value'); ?></label></td>
			<td>
				<select name="typeid" id="admin-customer-edit-form-typeid">
					<?php foreach($this->_types as $type) { ?>
					<option value="<?php echo $type->get('id'); ?>"<?php if($type->get('id') == $this->_item->get('typeid')) { ?> selected="selected"<?php } ?>><?php echo $type->get('name');?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-pricegroup"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICEGROUP', 'value')->get('value'); ?></label></td>
			<td>
				<select class="text" id="admin-customer-edit-form-pricegroup" name="pricegroup">
					<option></option>
					<?php foreach($this->_prices as $price) { ?>
					<option value="<?php echo $price->get($price->_id); ?>"<?php echo $price->get($price->_id)==$this->_item->get('pricegroup')?' selected="selected"':''; ?>><?php echo $price->get('name'); ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-email"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EMAIL', 'value')->get('value'); ?></label></td>
			<td>
				<input type="text" class="text" id="admin-customer-edit-form-email" name="email" value="<?php echo $this->_item->get('email'); ?>" />
			</td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-cardcode"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?></label></td>
			<td>
				<input type="text" class="text" id="admin-customer-edit-form-cardcode" name="cardcode" value="<?php echo $this->_item->get('cardcode'); ?>" />
			</td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-status"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?></label></td>
			<td>
				<select id="admin-customer-edit-form-status" name="status">
					<option value="0"<?php echo $this->_item->get('status')==0?' selected="selected"':''; ?>><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_INACTIVE', 'value')->get('value'); ?></option>
					<option value="1"<?php echo $this->_item->get('status')==1?' selected="selected"':''; ?>><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTIVE', 'value')->get('value'); ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-name_first"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_FIRST', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-edit-form-name_first" name="name_first" value="<?php echo htmlspecialchars($this->_item->get('name_first')); ?>" /></td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-name_last"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_LAST', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-edit-form-name_last" name="name_last" value="<?php echo htmlspecialchars($this->_item->get('name_last')); ?>" /></td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-phone"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PHONE', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-edit-form-phone" name="phone" value="<?php echo $this->_item->get('phone'); ?>" /></td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-address1"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADDRESS1', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-edit-form-address1" name="address1" value="<?php echo $this->_item->get('address1'); ?>" /></td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-address2"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADDRESS2', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-edit-form-address2" name="address2" value="<?php echo $this->_item->get('address2'); ?>" /></td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-city"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CITY', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-edit-form-city" name="city" value="<?php echo $this->_item->get('city'); ?>" /></td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-state"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATE', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-customer-edit-form-state" name="state" value="<?php echo $this->_item->get('state'); ?>" /></td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-password"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PASSWORD', 'value')->get('value'); ?></label></td>
			<td<?php echo strlen($this->_item->get('password'))==0?' class="error"':''; ?>><input type="password" class="text" id="admin-customer-edit-form-password" name="password" value="" /><div id="edit-item-password-generate-div"></div></td>
		</tr>
		<tr>
			<td><label for="admin-customer-edit-form-password-confirm"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PASSWORD_CONFIRM', 'value')->get('value'); ?></label></td>
			<td<?php echo strlen($this->_item->get('password'))==0?' class="error"':''; ?>><input type="password" class="text" id="admin-customer-edit-form-password-confirm" name="password_confirm" value="" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="button" class="edit-item-password-generate" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_GENERATE_PASSWORD', 'value')->get('value'); ?>" /></td>
		</tr>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
	function randString(n)
	{
		if(!n)
		{
			n = 5;
		}

		var text = '';
		var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';

		for(var i=0; i < n; i++)
		{
			text += possible.charAt(Math.floor(Math.random() * possible.length));
		}

		return text;
	}
$(document).ready(function() {
	$('#button-cancel').bind('click', function() {
		history.go(-1);
	});
	if(!$('#import-item-list-area')[0]) {
		var _dv = $('<div id="edit-item-password-area"><div class="header"><h3><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_GENERATE_PASSWORD', 'value')->get('value'); ?></h3></div><div class="wrapper"><p class="password"></p><input type="button" class="edit-item-password-generate" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_GENERATE_PASSWORD', 'value')->get('value'); ?>" /></div><div class="footer"><div class="btn-close"></div></div></div>');
		_dv.css({ position:'absolute', marginTop: '-50px', width: '300px', background: '#ffffff', border: '1px solid #cccccc', padding: '10px', overflow: 'visible' });
		_dv.find('.wrapper').css({ overflow: 'auto' });
		_dv.find('.footer').css({ position: 'relative' });
		_dv.find('.footer').find('.btn-close').css({ position: 'absolute', right: '0px'	 });
		_dv.find('.footer').find('.btn-close').bind('click', function() {
			_dv.hide();
		});
		_dv.hide();
		$('#edit-item-password-generate-div').append(_dv);
	}
	$('.edit-item-password-generate').bind('click', function() {
		var pass = randString(6);
		$('#edit-item-password-area').show();
		$('#edit-item-password-area .password').empty().append($('<b>'+pass+'</b>'));
		$('#admin-customer-edit-form-password').val(pass);
		$('#admin-customer-edit-form-password-confirm').val(pass);
	});
});
</script>