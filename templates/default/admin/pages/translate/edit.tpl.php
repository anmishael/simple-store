<?php
/**
 * Created on 3 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * 
 */
?>
<?php if($this->_item->get($this->_item->_id)) { ?>
	<h2>Edit "<?php echo $this->_item->get('key')?>" page</h2>
<?php } ?>
<form action="<?php echo $this->_core->getActionUrl('admin-translate-save').'?'.$this->_core->getAllGetParams(array('id'));?>" method="post">
	<table>
	<tr>
            <td><label
                    for="admin-translate-edit-form-key"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_KEY', 'value')->get('value'); ?></label>
            </td>
            <td><input type="text" class="text" id="admin-translate-edit-form-key" name="key"
                       value="<?php echo $this->_item->get('key')?>" size="64" maxlength="64"/></td>
	</tr>
	<tr>
            <td><label
                    for="admin-translate-edit-form-value"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VALUE', 'value')->get('value'); ?></label>
            </td>
            <td><textarea class="text" id="admin-translate-edit-form-value"
                          name="value"><?php echo htmlspecialchars($this->_item->get('value'));?></textarea></td>
	</tr>
	<tr>
            <td><label
                    for="admin-translate-edit-form-language"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_LANGUAGE', 'value')->get('value'); ?></label>
            </td>
	<td>
                <select id="admin-translate-edit-form-language"
                        name="language"><?php foreach ($this->_languages as $lang) { ?>
                    <option value="<?php echo $lang->get('id'); ?>"<?php if ($lang->get('id') == $this->_item->get('language')) {
						echo ' selected="selected"';
					}?>><?php echo $lang->get('name'); ?></option>
	<?php } ?></select>
	</td>
	</tr>
	<tr>
            <td><label
                    for="admin-translate-edit-form-type"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TYPE', 'value')->get('value'); ?></label>
            </td>
		<td>
                <input type="radio" id="admin-translate-edit-form-backend" name="backend"
                       value="1"<?php if ($this->_item->get('backend') == 1) {
					echo ' checked="checked"';
				} ?> /> <label for="admin-translate-edit-form-backend">Backend</label>
                <input type="radio" id="admin-translate-edit-form-frontend" name="backend"
                       value="0"<?php if ($this->_item->get('backend') != 1) {
					echo ' checked="checked"';
				} ?> /> <label for="admin-translate-edit-form-frontend">Frontend</label>
		</td>
	</tr>
	</table>
    <input type="hidden" name="<?php echo $this->_item->_id; ?>"
           value="<?php echo $this->_item->get($this->_item->_id); ?>"/>
    <input type="button" class="button" id="button-cancel"
           value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>"/>
    <input type="submit" class="button" name="_save"
           value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value'); ?>"/>
    <input type="submit" class="button" name="_save"
           value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>"/>
</form>
<script type="text/javascript">
$(document).ready(function() {
	$('#button-cancel').bind('click', function() {
		window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-translate-list') . '?' . $this->_core->getAllGetParams(array('id'))); ?>';
	});
});
</script>