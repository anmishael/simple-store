<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */
?>
<?php if($this->_item->get('id')) { ?>
	<h2>Edit "<?php echo $this->_item->get('name')?>" filter type</h2>
<?php } ?>
<?php $desc = $this->_item->get('description'); ?>
<form action="<?php echo $this->_core->getActionUrl('admin-filter-save');?>" method="post" enctype="multipart/form-data">
	<table>
		<?php foreach($this->_languages as $lang) { ?>
			<tr>
				<td><label for="admin-filter-edit-form-name-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
				<td><input type="text" class="text" id="admin-filter-edit-form-name-<?php echo $lang->get('id'); ?>" name="name[<?php echo $lang->get('id'); ?>]" value="<?php echo $desc[$lang->get('id')]?$desc[$lang->get('id')]->get('name'):''; ?>" size="32" maxlength="255" /></td>
			</tr>
		<?php } ?>
		<tr>
			<td><label for="admin-filter-edit-form-url"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_URL', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-filter-edit-form-url" name="url" value="<?php echo $this->_item->get('url')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-filter-edit-form-type"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TYPE', 'value')->get('value'); ?></label></td>
			<td><select name="type" id="admin-filter-edit-form-type"><?php foreach($this->_types as $k=>$type) { ?>
						<option value="<?php echo $type->get('id')?>"<?php echo ((int)$this->_item->get('type') == $type->get('id') || (!$this->_item->get('type')) && $type->get('id') == $this->_core->getRequest('typeid')) ? ' selected="selected"' : ''?>><?php echo $type->get('name');?></option>
					<?php } ?>
				</select></td>
		</tr>

		<tr>
			<td><label for="admin-filter-edit-form-image"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMAGE', 'value')->get('value'); ?></label></td>
			<td><input type="file" name="image" /><div>
					<?php if($this->_item->get('image')) { ?>
						<img src="<?php echo $this->_item->get('image'); ?>" border="0" />
					<?php } ?>
				</div></td>
		</tr>
		<tr>
			<td><label for="admin-filter-edit-form-display_hp"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_DISPLAY_HOMEPAGE', 'value')->get('value'); ?></label></td>
			<td><select name="display_hp" id="admin-filter-edit-form-display_hp">
					<option value="0"<?php echo (int)$this->_item->get('display_hp') == 0 ? ' selected="selected"' : ''?>>Off</option>
					<option value="1"<?php echo (int)$this->_item->get('display_hp') == 1 ? ' selected="selected"' : ''?>>On</option>
				</select></td>
		</tr>
		<tr>
			<td><label for="admin-filter-edit-form-status"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?></label></td>
			<td><select name="status" id="admin-filter-edit-form-status">
					<option value="0"<?php echo (int)$this->_item->get('status') == 0 ? ' selected="selected"' : ''?>>Off</option>
					<option value="1"<?php echo (int)$this->_item->get('status') == 1 ? ' selected="selected"' : ''?>>On</option>
				</select></td>
		</tr>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$('#button-cancel').bind('click', function() {
			window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-filter-list')) . ((int)$this->_core->getRequest('typeid')>0?'?typeid='.$this->_core->getRequest('typeid'):''); ?>';
		});
	});
</script>