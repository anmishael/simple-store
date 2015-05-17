<?php
/*
 * Created on May 30, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php if($this->_item->get('id')) { ?>
	<h2>Edit "<?php echo $this->_item->get('name')?>" city</h2>
<?php } ?>
<form action="<?php echo $this->_core->getActionUrl('admin-state-city-save');?>" method="post">
	<table>
	<tr>
	<td><label for="admin-state-city-edit-form-name">Name</label></td>
	<td><input type="text" class="text" id="admin-state-city-edit-form-name" name="name" value="<?php echo $this->_item->get('name')?>" size="64" maxlength="255" /></td>
	</tr>
	<td><label for="admin-page-edit-form-state">State</label></td>
	<td><select id="admin-page-edit-form-state" name="state"><?php foreach($this->_states as $k=>$state) { ?>
		<option value="<?php echo $state->get('id')?>"<?php if($state->get('id') == $this->_item->get('state')) { ?> selected="selected"<?php } ?>><?php echo $state->get('name') . ', ' . $state->get('code'); ?></option>
		<?php } ?></select>
	</td>
	</tr>
	<tr>
	<td><label for="admin-state-city-edit-form-weight">City weight</label></td>
	<td><select id="admin-page-edit-form-state" name="weight"><?php foreach($this->_weights as $k=>$weight) { ?>
		<option value="<?php echo $k?>"<?php if($k == $this->_item->get('weight')) { ?> selected="selected"<?php } ?>><?php echo $weight; ?></option>
		<?php } ?></select></td>
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