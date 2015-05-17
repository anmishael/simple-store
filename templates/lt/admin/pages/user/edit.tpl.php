<?php
/*
 * Created on May 27, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php if($this->_item->get('id')) { ?>
	<h2>Edit user "<?php echo $this->_item->get('username')?>"</h2>
<?php } ?>
<form action="<?php echo $this->_core->getActionUrl('admin-user-save');?>" method="post">
	<table>
		<tr>
			<td><label for="admin-user-edit-form-username">Username</label></td>
			<td>
			<?php if($this->_item->get('id')) { ?>
				<?php echo $this->_item->get('username'); ?>
			<?php } else { ?>
				<input type="text" class="text" id="admin-user-edit-form-username" name="username" value="" />
			<?php } ?>
			</td>
		</tr>
		<tr>
			<td><label for="admin-user-edit-form-typeid">Type</label></td>
			<td>
				<select name="typeid" id="admin-user-edit-form-typeid">
					<?php foreach($this->_types as $type) { ?>
					<option value="<?php echo $type->get('id'); ?>"<?php if($type->get('id') == $this->_item->get('typeid')) { ?> selected="selected"<?php } ?>><?php echo $type->get('name');?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="admin-user-edit-form-email">Email</label></td>
			<td>
			<?php if($this->_item->get('id')) { ?>
				<?php echo $this->_item->get('email'); ?>
			<?php } else { ?>
				<input type="text" class="text" id="admin-user-edit-form-email" name="email" value="" />
			<?php } ?>
			</td>
		</tr>
		<tr>
			<td><label for="admin-user-edit-form-name_first">First Name</label></td>
			<td><input type="text" class="text" id="admin-user-edit-form-name_first" name="name_first" value="<?php echo $this->_item->get('name_first'); ?>" /></td>
		</tr>
		<tr>
			<td><label for="admin-user-edit-form-name_last">Last Name</label></td>
			<td><input type="text" class="text" id="admin-user-edit-form-name_last" name="name_last" value="<?php echo $this->_item->get('name_last'); ?>" /></td>
		</tr>
		<tr>
			<td><label for="admin-user-edit-form-password">Password</label></td>
			<td><input type="password" class="text" id="admin-user-edit-form-password" name="password" value="" /></td>
		</tr>
		<tr>
			<td><label for="admin-user-edit-form-password-confirm">Confirm password</label></td>
			<td><input type="password" class="text" id="admin-user-edit-form-password-confirm" name="password_confirm" value="" /></td>
		</tr>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button" id="button-cancel" value="Cancel" />
	<input type="submit" class="button" value="Save" />
</form>
<script type="text/javascript">
$(document).ready(function() {
	$('#button-cancel').bind('click', function() {
		history.go(-1);
	});
});
</script>