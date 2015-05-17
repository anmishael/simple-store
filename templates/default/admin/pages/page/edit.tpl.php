<?php
/*
 * Created on May 25, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php if($this->_item->get('id')) { ?>
	<h2>Edit "<?php echo $this->_item->get('name')?>" page</h2>
<?php } ?>
<?php $desc = $this->_item->get('description'); ?>
<form action="<?php echo $this->_core->getActionUrl('admin-page-save');?>" method="post">
	<table>
	<tr>
	<td><label for="admin-page-edit-form-url"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_URL', 'value')->get('value'); ?></label></td>
	<td><input type="text" class="text" id="admin-page-edit-form-url" name="url" value="<?php echo $this->_item->get('url')?>" size="32" maxlength="255" /></td>
	</tr>
	<tr>
	<td><label for="admin-page-edit-form-parent"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PARENT', 'value')->get('value'); ?></label></td>
	<td><select name="parent" id="admin-page-edit-form-parent">
		<option></option>
		<?php foreach($this->_pages as $page) { ?>
		<option value="<?php echo $page->get('id'); ?>"<?php if($page->get('id')==$this->_item->get('parent')) { echo ' selected="selected"'; }?>><?php echo $page->get('name') . ' &nbsp; &nbsp; &nbsp; ('.$page->get('url').')'; ?></option>
		<?php } ?>
	</select></td>
	</tr>
	<?php foreach($this->_languages as $lang) { ?>
	<tr>
	<td><label for="admin-page-edit-form-name-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><input type="text" class="text" id="admin-page-edit-form-name-<?php echo $lang->get('id'); ?>" name="name[<?php echo $lang->get('id'); ?>]" value="<?php echo $desc[$lang->get('id')]?$desc[$lang->get('id')]->get('name'):''; ?>" size="64" maxlength="255" /></td>
	</tr>
	<?php } ?>
	<?php foreach($this->_languages as $lang) { ?>
	<tr>
	<td><label for="admin-page-edit-form-menutitle-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TITLE', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><input type="text" class="text" id="admin-page-edit-form-menutitle-<?php echo $lang->get('id'); ?>" name="menutitle[<?php echo $lang->get('id'); ?>]" value="<?php echo $desc[$lang->get('id')]?$desc[$lang->get('id')]->get('menutitle'):''; ?>" size="64" maxlength="255" /></td>
	</tr>
	<?php } ?>
	<tr>
	<td><label for="admin-page-edit-form-menu"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_MENU', 'value')->get('value'); ?></label></td>
	<td><?php foreach($this->_menus as $k=>$menu) { ?>
		<div>
			<input type="checkbox" id="menu-<?php echo $menu->get('id'); ?>" name="menu[]" value="<?php echo $menu->get('id'); ?>"<?php if(in_array($menu->get('id'), $this->_inmenus)) { echo ' checked="checked"'; }?> />
			<input type="text" name="sortorder[<?php echo $menu->get('id');?>]" value="<?php echo $this->_sortorder[$menu->get('id')]; ?>" alt="Sort order" title="Sort order" size="2" style="width: 20px;" />
			<label for="menu-<?php echo $menu->get('id'); ?>"><?php echo $menu->get('title'); ?></label>
		</div>
		<?php } ?>
	</td>
	</tr>
        <tr>
            <td><label><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CATEGORY', 'value')->get('value'); ?></label></td>
            <td>
				<input type="radio" name="category" value="0"<?php echo $this->_item->get('category')==0?' checked="checked':''; ?> id="admin-page-edit-form-category-off" /><label for="admin-page-edit-form-category-off"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_OFF', 'value')->get('value'); ?></label><br />
                <input type="radio" name="category" value="1"<?php echo $this->_item->get('category')==1?' checked="checked':''; ?> id="admin-page-edit-form-category-on" /><label for="admin-page-edit-form-category-on"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ON', 'value')->get('value'); ?></label>
			</td>
        </tr>
	<?php foreach($this->_languages as $lang) { ?>
	<tr>
	<td><label for="admin-page-edit-form-metakey-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_METAKEY', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><textarea id="admin-page-edit-form-metakey-<?php echo $lang->get('id'); ?>" name="metakey[<?php echo $lang->get('id'); ?>]" rows="4" cols="64" wrap="off"><?php echo $desc[$lang->get('id')]?$desc[$lang->get('id')]->get('metakey'):''; ?></textarea></td>
	</tr>
	<tr>
	<td><label for="admin-page-edit-form-metadescription-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_METADESCRIPTION', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><textarea id="admin-page-edit-form-metadescription-<?php echo $lang->get('id'); ?>" name="metadescription[<?php echo $lang->get('id'); ?>]" rows="4" cols="64" wrap="off"><?php echo $desc[$lang->get('id')]?$desc[$lang->get('id')]->get('metadescription'):''; ?></textarea></td>
	</tr>
	<tr>
	<td><label for="admin-product-edit-form-searchdescription-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SEARCHDESCRIPTION', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><textarea id="admin-product-edit-form-searchdescription-<?php echo $lang->get('id'); ?>" name="searchdescription[<?php echo $lang->get('id'); ?>]" cols="64" rows="8"><?php echo $desc[$lang->get('id')]?$desc[$lang->get('id')]->get('searchdescription'):''; ?></textarea></td>
	</tr>
	<?php } ?>
	<?php foreach($this->_languages as $lang) { ?>
	<tr>
	<td><label for="admin-page-edit-form-content-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CONTENT', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><textarea class="editor" id="admin-page-edit-form-content-<?php echo $lang->get('id'); ?>" name="content[<?php echo $lang->get('id'); ?>]" rows="30" cols="64" wrap="off"><?php echo $desc[$lang->get('id')]?$desc[$lang->get('id')]->get('content'):''; ?></textarea></td>
	</tr>
	<?php } ?>
	<?php foreach($this->_languages as $lang) { ?>
	<tr>
	<td><label for="admin-page-edit-form-content-left-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CONTENT_LEFT', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><textarea class="editor" id="admin-page-edit-form-content-left-<?php echo $lang->get('id'); ?>" name="content_left[<?php echo $lang->get('id'); ?>]" rows="10" cols="64" wrap="off"><?php echo $desc[$lang->get('id')]?$desc[$lang->get('id')]->get('content_left'):''; ?></textarea></td>
	</tr>
	<?php } ?>
	<?php foreach($this->_languages as $lang) { ?>
	<tr>
	<td><label for="admin-page-edit-form-content-right-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CONTENT_RIGHT', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><textarea class="editor" id="admin-page-edit-form-content-right-<?php echo $lang->get('id'); ?>" name="content_right[<?php echo $lang->get('id'); ?>]" rows="10" cols="64" wrap="off"><?php echo $desc[$lang->get('id')]?$desc[$lang->get('id')]->get('content_right'):''; ?></textarea></td>
	</tr>
	<?php } ?>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<?php if($this->_item->get('id')) { ?>
	<h2><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_UPLOAD_IMAGE', 'value')->get('value'); ?></h2>
<form action="<?php echo $this->_core->getActionUrl('admin-page-upload');?>" method="post" enctype="multipart/form-data">
	<table id="admin-page-edit-form-upload">
		<tr>
			<td colspan="5"><input type="file" name="image" /></td>
		</tr>
		<tr>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VIEW', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PATH', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SIZE', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_MIME', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
		</tr>
		<?php foreach($this->_images as $k=>$v) { ?>
		<?php if($v->get('width')) { ?>
		<tr>
			<td><img src="<?php echo str_replace('//','/',$this->_core->getSingleton('Config')->topFolder . $v->get('url'));?>" <?php echo ($v->get('width')>200?'width="200"':$v->get('html')); ?> border="0" /></td>
			<td><?php echo $v->get('url');?></td>
			<td><?php echo $v->get('width');?>x<?php echo $v->get('height');?></td>
			<td><?php echo $v->get('mime');?></td>
			<td></td>
		</tr>
		<?php } ?>
		<?php } ?>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<?php } ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#button-cancel').bind('click', function() {
		window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-page-list')); ?>';
	});
});
</script>