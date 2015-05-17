<?php
/**
 * edit.tpl.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 18.02.13
 * Time: 21:04
 */

?>
<form action="<?php echo $this->_action;?>" method="post">
	<table>
		<?php foreach($this->_columns as $k=>$column) { ?>
		<tr>
			<td><label for="admin-<?php echo $this->_id_part; ?>-form-<?php echo $column['field']; ?>"><?php echo $column['title']; ?></label></td>
			<td><input type="text" class="text" id="admin-<?php echo $this->_id_part; ?>-form-<?php echo $column['field']; ?>" name="<?php echo $column['field']; ?>" value="<?php echo $this->_item->get($column['field'])?>" size="32" maxlength="255" /></td>
		</tr>
		<?php } ?>
	</table>
	<div class="clear"></div>
	<input type="hidden" name="<?php echo $this->_item->_id; ?>" value="<?php echo $this->_item->get($this->_item->_id); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$('#button-cancel').bind('click', function() {
			window.location = '<?php echo addslashes($this->_action_back); ?>';
		});
	});
</script>