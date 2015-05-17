<?php
/**
 * edit.tpl.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 19.02.13
 * Time: 22:15
 */
?>
<form action="<?php echo $this->_action . '?' . $this->_core->getAllGetParams(array('id'));?>" method="post">
	<table>
		<?php foreach($this->_columns as $k=>$column) { ?>
		<tr>
			<td><label for="admin-<?php echo $this->_id_part; ?>-form-<?php echo $column['field']; ?>"><?php echo $column['title']; ?></label></td>
			<td><input type="text" class="text" id="admin-<?php echo $this->_id_part; ?>-form-<?php echo $column['field']; ?>" name="<?php echo $column['field']; ?>" value="<?php echo $this->_item->get($column['field'])?>" size="32" maxlength="255" /></td>
		</tr>
		<?php } ?>
	</table>
	<input type="button" id="product-append" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRODUCT_APPEND', 'value')->get('value'); ?>">
	<div id="product-append-area">
		<div class="products"></div>
		<div class="input"><ul></ul></div>
	</div>
	<div class="clear"></div>
	<input type="hidden" name="<?php echo $this->_item->_id; ?>" value="<?php echo $this->_item->get($this->_item->_id); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_apply" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
	var _search_length = 0;
	$(document).ready(function() {
		$('#button-cancel').bind('click', function() {
			window.location = '<?php echo addslashes($this->_action_back); ?>';
		});
		$('#product-append').bind('click', function() {
			if(!$('#product-append-area .products select[name=prod]')[0]) {
				$('#product-append-area .products').append($('<input type="text" name="_search" value="" size="10" title="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SEARCH', 'value')->get('value'); ?>" />'));
				$('#product-append-area .products').append($('<select name="prod" style="width: 300px;"></select>'));
				$('#product-append-area .products').append($('<input type="button" name="add-product" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPEND', 'value')->get('value'); ?>" />'));
				$.ajax({
					url: adminUrl + 'product/list?doctype=xml',
					dataType: 'xml',
					success: function(data) {
						if($(data).find('result').text() == 'SUCCESS') {
							$(data).find('products product').each(function() {
								$('#product-append-area .products select[name=prod]').append('<option value="'+$(this).find('id').text()+'">'+($(this).find('name').text().length>0?$(this).find('name').text():'ID:'+$(this).find('id').text())+' '+$(this).find('pack').text()+'</option>');
							});
						}
					}
				});
				$('#product-append-area .products input[name=_search]').bind('keyup', function() {
					var ln = 2;
					var _cr = $(this).val().trim().length;
					if(_cr>ln || _search_length>ln) {
						$('#product-append-area .products select[name=prod]').empty();
							$.ajax({
								url: adminUrl + 'product/list?doctype=xml'+(_cr>ln?'&search='+$(this).val().trim():''),
								dataType: 'xml',
								success: function(data) {
									if($(data).find('result').text() == 'SUCCESS') {
										$(data).find('products product').each(function() {
											$('#product-append-area .products select[name=prod]').append('<option value="'+$(this).find('id').text()+'">'+$(this).find('name').text()+' '+$(this).find('pack').text()+'</option>');
										});
									}
								}
							});
					}
					_search_length = $(this).val().trim().length;
				});
				$('#product-append-area .products input[name=add-product]').bind('click', function() {
					var el = $('<li><input type="hidden" name="pid[]" value="'+$('#product-append-area .products select[name=prod]').val()+'" /> '+$('#product-append-area .products select[name=prod]').find(":selected").text()+' <a href="javascript:;" class="remove"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'); ?></a></li>');
					$(el).find('a.remove').bind('click', function() {
						$(this).parents('li').remove();
					});
					$('#product-append-area .input ul').append(el);
				});
			}
		});
	});
</script>
<?php if( sizeof($products = $this->_item->get('products'))>0 ) { ?>
	<h3>Товари</h3>
	<table>
		<tr>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PACKING', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
		</tr>
	<?php foreach($products as $item) { ?>
		<tr>
			<td><a href="<?php echo $this->_core->getActionUrl('admin-product-edit').'?id=' . $item->get('id');?>" target="_blank"><?php echo $item->get('name');?></a></td>
			<td><a href="<?php echo $this->_core->getActionUrl('admin-product-edit').'?id=' . $item->get('id');?>" target="_blank"><?php echo $item->get('packing'); ?></a></td>
			<td><?php
			foreach($this->_actions as $k=>$v) { ?>
				<a href="<?php echo $v['url'] . '?id=' . $this->_item->get($this->_item->_id) . '&pid=' . $item->get($item->_id); ?>"<?php if($v['warning']) {
					echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('name') .' '.$item->get('packing'))).'\');"';
				} ?>><?php echo $v['name'];?></a>
				<?php } ?>
			</td>
		</tr>
	<?php } ?>
	</table>
<?php } ?>