<?php
/**
 * separator.tpl.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 14.02.13
 * Time: 17:41
 */

?>
<script type="text/javascript" src="<?php echo $this->templateDir . 'js/tracker.js'?>"></script>
<h2><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMPORT_PRODUCT_PREPARE', 'value')->get('value'); ?></h2>
<form id="admin-product-import-form" action="<?php echo $this->_core->getActionUrl('admin-product-import');?>" method="post" enctype="multipart/form-data">
	<table class="list">
		<tr>
			<td><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMPORT_PRODUCT_SEPARATOR_SELECT', 'value')->get('value'); ?></td>
			<td><input type="hidden" name="path" value="<?php echo $this->_path; ?>" />
				<select name="sep">
					<option></option>
					<?php foreach($this->_arrSep as $sep) { ?>
					<option value="<?php echo $sep; ?>"<?php echo $sep == $this->_sep?' selected="selected"':'';?>><?php echo $sep; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php foreach($this->_fields as $field=>$name) { ?>
		<tr>
			<td><label for="record<?php echo $field; ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_' . strtoupper(str_replace(' ', '_', $name)), 'value')->get('value');; ?></label></td>
			<td>
				<select id="record<?php echo $field; ?>" name="record[<?php echo $field; ?>]">
					<option></option>
					<?php foreach($this->_cols as $k=>$col) { ?>
					<option value="<?php echo $k; ?>"<?php echo is_numeric($this->_record[$field]) && $this->_record[$field] == $k ? ' selected="selected"' : ''; ?>><?php echo $col; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php } ?>
	</table>
	<div>
		<input id="includefirstline" type="checkbox" name="includefirstline" value="1"<?php echo $this->_core->getRequest('includefirstline')?' selected="selected"':''; ?> /> <label for="includefirstline"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMPORT_INCLUDEFIRSTLINE', 'value')->get('value'); ?></label>
	</div>
	<input type="button" class="button button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_apply" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_import" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMPORT', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$('.button-cancel').bind('click', function() {
			window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-product-import') . '?' . $this->_core->getAllGetParams(array('id', 'path'))); ?>';
		});
	});
	var btn = $('#admin-product-import-form input[name=_import]');
	$('#admin-product-import-form').append($('<a class="import-file-link" href="<?php echo $this->_core->getActionUrl('admin-product-import');?>" rel="<?php echo $this->_tmpFile;?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMPORT', 'value')->get('value'); ?></a>'));
	btn.remove();
	$('.import-file-link').each(function() {
		$(this).tracker({form:'#admin-product-import-form'});
	});
</script>