<?php
/**
 * Created on 5 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @version 1.0
 */
 
 
?>
<script type="text/javascript" src="<?php echo $this->templateDir . 'js/tracker.js'?>"></script>
<h2><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMPORT_PRODUCT', 'value')->get('value'); ?></h2>
<form id="admin-product-import-form" action="<?php echo $this->_core->getActionUrl('admin-product-import');?>" method="post" enctype="multipart/form-data">
<table>
	<tr>
		<td><input type="file" name="import" /></td>
	</tr>
</table>
<input type="button" class="button button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_UPLOAD', 'value')->get('value'); ?>" />
</form>
<h2><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FILES', 'value')->get('value'); ?></h2>
	<table>
		<tr>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FILE', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_MIME', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SIZE', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
		</tr>
	<?php foreach($this->_items as $k=>$item) { ?>
		<tr>
			<td><a rel="<?php echo $this->_tmpFile; ?>" href="?path=<?php echo $item['path']; ?>" class="import-file-link<?php echo in_array($item['mime'], array('text/xml', 'application/xml')) ? ' xml' : ''; ?>"><?php echo $item['name']; ?></a></td>
			<td><?php echo $item['mime']; ?></td>
			<td><?php echo $item['size']; ?></td>
			<td><?php
				foreach($this->_actions as $k=>$v) { ?>
					<a href="<?php echo $v['url'] . '?filename=' . $item['path']; ?>"<?php if($v['warning']) {
						echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item['name'])).'\');"';
					} ?>><?php echo $v['name'];?></a>
				<?php } ?></td>
		</tr>
	<?php } ?>
	</table>
<h2><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMPORT_HISTORY', 'value')->get('value'); ?></h2>
<table>
	<tr>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FILE', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_DATE', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
	</tr>
	<?php foreach($this->_imports as $item) { ?>
	<tr>
		<td><?php echo $item->get('filename'); ?></td>
		<td><?php echo $item->get('date'); ?></td>
		<td><?php
			foreach($this->_actions2 as $k=>$v) { ?>
				<a<?php echo $v['class']?' class="'.$v['class'].'"':''; ?> href="<?php echo $v['url'] . '?iid=' . $item->get('id'); ?>"<?php if($v['warning']) {
					echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('filename'))).'\');"';
				} ?>><?php echo $v['name'];?></a>
			<?php } ?></td>
	</tr>
	<?php } ?>
</table>
<script type="text/javascript">
$(document).ready(function() {
	$('.button-cancel').bind('click', function() {
		window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('id'))); ?>';
	});
	if(!$('#import-item-list-area')[0]) {
		var _dv = $('<div id="import-item-list-area"><div class="header"><h3>Список імпортованих товарів</h3></div><div class="wrapper"></div><div class="footer"><div class="btn-close"></div></div></div>');
		_dv.css({ position:'absolute', top: '25%', width: '50%', height: '50%', left: '25%', background: '#ffffff', border: '1px solid #cccccc', padding: '10px', overflow: 'visible' });
		_dv.find('.wrapper').css({ overflow: 'auto', height: '86%' });
		_dv.find('.footer').css({ position: 'relative' });
		_dv.find('.footer').find('.btn-close').css({ position: 'absolute', right: '0px', bottom: '-47px' });
		_dv.find('.footer').find('.btn-close').bind('click', function() {
			_dv.hide();
		});
		_dv.hide();
		$('body').append(_dv);
	}
	$('.import-item-list').bind('click', function() {
		$('#import-item-list-area').show();
		$.ajax({
			url: $(this).attr('href')+'&doctype=xml',
			docType: 'xml',
			success: function(data) {
				if($(data).find('result').text() == 'SUCCESS') {
					$('#import-item-list-area .wrapper').empty().append($('<table cellspacing="0" cellpadding="2"><tr><th>ID</th><th>ID Товару</th><th>Код</th><th>Тип</th><th>Результат</th></tr></table>'));
					var tbl = $('#import-item-list-area table');
					$(data).find('import_history item').each(function() {
						tbl.append(
							$('<tr class="'+$(this).find('res').text()+'"><td>'+$(this).find('id').text()+'</td><td>'+$(this).find('item_id').text()+'</td><td><a target="_blank" href="<?php echo $this->_core->getActionUrl('admin-product-edit'); ?>?id='+$(this).find('item_id').text()+'">'+$(this).find('code').text()+'</a></td><td>'+$(this).find('type').text()+'</td><td>'+$(this).find('res').text()+'</td></tr>')
						);
					});
				}
			}
		});
		return false;
	});
	$('.import-file-link.xml').each(function() {
		$(this).tracker();
	});
});
</script>