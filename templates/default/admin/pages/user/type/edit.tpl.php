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
	<h2>Edit "<?php echo $this->_item->get('name')?>" usertype</h2>
<?php } ?>
<form action="<?php echo $this->_core->getActionUrl('admin-user-type-save');?>" method="post">
	<table>
	<tr>
	<td><label for="admin-user-type-edit-form-name">Name</label></td>
	<td><input type="text" class="text" id="admin-user-type-edit-form-name" name="name" value="<?php echo $this->_item->get('name')?>" size="32" maxlength="255" /></td>
	</tr>
	</table>
	<ul class="events innerbox">
	<?php foreach($this->arrControllers as $name=>$methods) { ?>
				<li>
					<span class="event-name"><?php echo $name; ?></span>
					<ul class="sublist"><?php foreach($methods as $method=>$value) { ?>
						<li>
						<input type="checkbox" id="<?php echo $name . $method;?>" name="permissions[<?php echo $name; ?>][<?php echo $method; ?>]" value="1"<?php if(is_array($permissions) && $permissions[$name][$method]) { ?> checked="checked"<?php } ?> />
						<label for="<?php echo $name . $method; ?>"><?php echo $method; ?></label></li>
	<?php } ?></ul>
				</li>
	<?php } ?></ul>
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