<?php
/**
 * list.tpl.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 13.01.13
 * Time: 14:15
 */

$_p_start = $this->_page - 5;
if($_p_start <= 0) {
	$_p_start = 1;
}
$_p_end = $this->_page + 5;
if($_p_end > $this->_totalpages) {
	$_p_end = $this->_totalpages;
}
?>
<form action="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/review/list<?php echo strlen(trim($this->_core->getRequest('search')))>0?'?search=' . urlencode(trim($this->_core->getRequest('search'))):''; ?>" method="post" id="admin-pages-product-review-list-form">
	<table class="list" cellspacing="0" cellpadding="0" id="admin-pages-product-review-list-table" style="width: 100%;">
		<tr>
			<th><input type="checkbox" name="selection" /></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ID', 'value')->get('value'); ?></th>
			<th>
				<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?>
				<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/review/list?sort=name&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
				<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/review/list?sort=name&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
			</th>
			<th>
				<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EMAIL', 'value')->get('value'); ?>
				<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/review/list?sort=email&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
				<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/review/list?sort=email&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
			</th>
			<th>
				<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?>
				<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/review/list?sort=status&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
				<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/review/list?sort=status&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
			</th>
			<th>
				<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADDED', 'value')->get('value'); ?>
				<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/review/list?sort=added&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
				<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/review/list?sort=added&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
			</th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
		</tr>
		<?php foreach($this->_items as $k=>$item) { ?>
		<tr>
			<td><input type="checkbox" name="id[]" value="<?php echo $item->get('id'); ?>" /></td>
			<td><?php echo $item->get('id'); ?></td>
			<td>
				<div class="name">
					<?php echo $item->get('name'); ?>
					<div class="hidden content"><?php echo $item->get('content');?></div>
				</div>
			</td>
			<td><?php echo $item->get('email'); ?></td>
			<td><a class="status-<?php echo $item->get('status'); ?>" href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/review/status?id=<?php echo $item->get('id') . '&' . $this->_core->getAllGetParams(array('id')); ?>"></a></td>
			<td><?php echo $item->get('added'); ?></td>
			<td><?php
				foreach($this->_actions as $k=>$v) { ?>
					<a href="<?php echo $v['url'] . '?id=' . $item->get('id') . '&' . $this->_core->getAllGetParams(array('id')); ?>"<?php if($v['warning']) {
						echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('name'))).'\');"';
					} ?>><?php echo $v['name'];?></a>
					<?php } ?></td>
		</tr>
		<?php } ?>
	</table>
	<div class="clear">
		<ul class="pagination">
			<?php if($_p_start>1) { ?>
			<li><a href="?_p=<?php echo ($this->_page-1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"> << </a></li>
			<?php } ?>
			<?php for($k = $_p_start; $k <= $_p_end; $k++) { ?>
			<li><a<?php if($k == $this->_page) { ?> class="selected"<?php } ?> href="?_p=<?php echo $k . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $k; ?></a></li>
			<?php }?>
			<?php if($this->_totalpages>1) { ?>
			<li> &nbsp; </li>
			<li><!--form action="" method="get"-->
				<select name="_p" id="admin-pages-product-list-pagination">
					<?php for($k = 1; $k <= $this->_totalpages; $k++) { ?>
					<option value="<?php echo $k; ?>"<?php if($k == $this->_page) { ?> selected="selected"<?php } ?>><?php echo $k; ?></option>
					<?php } ?>
				</select>
				<!--/form--></li>
			<?php } ?>
			<?php if($_p_end<$this->_totalpages) { ?>
			<li><a href="?_p=<?php echo ($this->_page+1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"> >> </a></li>
			<?php } ?>
			<li class="clear"></li>
		</ul>
	</div>
	<div class="clear"></div>

<script type="text/javascript">
	$(document).ready(function() {
		$('div.content').removeClass('hidden').hide();
		$('#admin-pages-product-review-list-table tr').hover(function() {
			$(this).find('.content').show();
		}, function() {
			$(this).find('.content').hide();
		});
	});
</script>