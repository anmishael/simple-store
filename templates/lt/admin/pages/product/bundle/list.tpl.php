<?php
/**
 * list.tpl.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 19.02.13
 * Time: 22:06
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
<ul class="links-list">
	<?php foreach($this->_toplinks as $k=>$link) { ?>
	<li><a href="<?php echo $link['url']?>"><?php echo $link['name'];?></a></li>
	<li class="clear"></li>
	<?php } ?>
</ul>
<form action="<?php echo $this->_core->getSingleton('Config')->adminUrl . $this->_url; ?><?php echo strlen(trim($this->_core->getRequest('search')))>0?'?search=' . urlencode(trim($this->_core->getRequest('search'))):''; ?>" method="post" id="admin-pages-product-bundle-list-form">
	<table class="list" cellspacing="0" cellpadding="0" id="admin-<?php echo $this->_id_part; ?>-table" style="width: 100%;">
		<tr>
			<?php foreach($this->_columns as $column) { ?>
			<th><?php echo $column['title']; ?></th>
			<?php } ?>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
		</tr>
		<?php foreach($this->_items as $k=>$item) { ?>
		<?php if($item instanceof Model_Product_Bundle) $item->fetchProducts(); ?>
		<tr<?php echo (sizeof($item->get('products'))<1)?' class="empty"':''; ?>>
			<?php foreach($this->_columns as $column) { ?>
			<td><?php echo $item->get($column['field']); ?></td>
			<?php } ?>
			<td><?php
				foreach($this->_actions as $k=>$v) { ?>
					<a href="<?php echo $v['url'] . '?id=' . $item->get($item->_id) . '&' . $this->_core->getAllGetParams(array('id')); ?>"<?php if($v['warning']) {
						echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('name'))).'\');"';
					} ?>><?php echo $v['name'];?></a>
					<?php } ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="4">
				<ul class="symbols">
					<li>
						<div class="box empty"></div>
						<span><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EMPTY_PRODUCT_BUNDLE', 'value')->get('value'); ?></span>
					</li>
				</ul>
			</td>
		</tr>
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
					<select name="_p" id="admin-pages-product-bundle-list-pagination">
						<?php for($k = 1; $k <= $this->_totalpages; $k++) { ?>
							<option value="<?php echo $k; ?>"<?php if($k == $this->_page) { ?> selected="selected"<?php } ?>><?php echo $k; ?></option>
						<?php } ?>
					</select>
					<!--/form--></li>
			<?php } ?>
			<?php if($_p_end<$this->_totalpages) { ?>
				<li><a href="?_p=<?php echo ($this->_page+1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"> >> </a></li>
			<?php } ?>
			<li><select name="_limit" onchange="this.form.submit();">
					<?php foreach($this->_arrLimit as $limit) { ?>
						<option value="<?php echo $limit; ?>"<?php echo $limit == $this->_limit ? ' selected="selected"': ''; ?>><?php echo $limit; ?> на сторінку</option>
					<?php } ?>
				</select></li>
			<li class="clear"></li>
		</ul>
	</div>
	<div class="clear"></div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#admin-pages-product-bundle-list-pagination').bind('change', function() {
			$('#admin-pages-product-bundle-list-form').attr('method', 'get');
<!--			$('#admin-pages-product-bundle-list-form input[name=search]').val('--><?php //echo strlen(trim($this->_core->getRequest('search')))>0?'?search=' . urlencode(trim($this->_core->getRequest('search'))):''; ?><!--');-->
			$('#admin-pages-product-bundle-list-form').submit();
		});
	});
</script>