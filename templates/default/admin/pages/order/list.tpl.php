<?php
/**
 * Created on 23 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
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
<div class="clear">
<form id="admin-pages-order-list-search-form" action="<?php echo $this->_core->getSingleton('Config')->adminUrl?>order/list" method="get">
	<input type="text" name="search" value="<?php echo $this->_core->getRequest('search')?>" size="32" />
	<input type="submit" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SEARCH', 'value')->get('value'); ?>" />
	<input id="admin-pages-order-list-search-clear" type="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CLEAR', 'value')->get('value'); ?>" />
</form>
</div>
<hr />
<table class="list" cellspacing="0" cellpadding="0" style="width: 100%;">
	<tr>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ID', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=id&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=id&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CREATED', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=created&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=created&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_FIRST', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=billname_first&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=billname_first&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_LAST', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=billname_last&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=billname_last&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EMAIL', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=email&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=email&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TOTAL', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=total&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=total&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=status&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=status&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SHIPPING', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=shipping_method&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>order/list?sort=shipping_method&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
	</tr>
<?php foreach($this->_items as $k=>$item) { ?>
	<tr>
		<td><strong><?php echo $item->get('id'); ?></strong></td>
		<td><?php echo $item->get('created'); ?></td>
		<td><?php echo $item->get('billname_first'); ?></td>
		<td><?php echo $item->get('billname_last'); ?></td>
		<td><?php echo $item->get('email'); ?></td>
		<td><?php echo $item->get('total') .' ' . $item->get('currency'); ?></td>
		<td><?php echo $this->_statuses[$item->get('status')] instanceof Model_Order_Status?
			$this->_core->getModel('Translate/Collection')->get('ADMIN_ORDER_'.strtoupper($this->_statuses[$item->get('status')]->get('name')))->get('value')
			:$item->get('status'); ?></td>
		<td><?php echo $item->get('shipping_method'); ?></td>
		<td><?php
		foreach($this->_actions as $k=>$v) { ?>
			<a href="<?php echo $v['url'] . '?id=' . $item->get('id'); ?>"<?php if($v['warning']) { 
				echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('name'))).'\');"';
			 } ?>><?php echo $v['name'];?></a>
		<?php } ?></td>
	</tr>
<?php } ?>
</table>
<div class="clear">
	<ul class="pagination">
		<?php if($_p_start>1) { ?>
		<li><a href="?_p=<?php echo ($this->_page-1) . '&' . $this->_core->getAllGetParams(array('_p', '_limit')); ?>"> << </a></li>
		<?php } ?>
		<?php for($k = $_p_start; $k <= $_p_end; $k++) { ?>
		<li><a<?php if($k == $this->_page) { ?> class="selected"<?php } ?> href="?_p=<?php echo $k . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $k; ?></a></li>
		<?php }?>
		<?php if($this->_totalpages>1) { ?>
		<li> &nbsp; </li>
		<li><form action="" method="get">
		<select name="_p" onchange="this.form.submit();">
		<?php for($k = 1; $k <= $this->_totalpages; $k++) { ?>
			<option value="<?php echo $k; ?>"<?php if($k == $this->_page) { ?> selected="selected"<?php } ?>><?php echo $k; ?></option>
		<?php } ?>
		</select></form>
	</li>
		<?php } ?>
		<?php if($_p_end<$this->_totalpages) { ?>
		<li><a href="?_p=<?php echo ($this->_page+1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"> >> </a></li>
		<?php } ?>
		<li><form action="<?php echo $this->_core->getAllGetParams(array('_p', '_limit')); ?>" method="post"><select name="_limit" onchange="this.form.submit();">
			<?php foreach($this->_arrLimit as $limit) { ?>
			<option value="<?php echo $limit; ?>"<?php echo $limit == $this->_limit ? ' selected="selected"': ''; ?>><?php echo $limit; ?> на сторінку</option>
			<?php } ?>
		</select></form></li>
		<li class="clear"></li>
	</ul>
</div>
<div class="clear"></div>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('#admin-pages-order-list-search-clear').bind('click', function() {
		$('#admin-pages-order-list-search-form input[name=search]').attr('value', '');
		$('#admin-pages-order-list-search-form').submit();
	});
	$('table.list a.item-name').hover(
				function() {
					if($(this).attr('rel')) {
						$(this).parent().append('<div class="product-image" style=""><img src="'+$(this).attr('rel')+'" /></div>');
						$(this).parent().mousemove(function(e) {
							$(this).find('.product-image').css({left:(e.pageX+10)+'px'});
						});
					}
				},
				function() {
					if($(this).attr('rel')) {
						$(this).parent().find('.product-image').remove();
					}
				}
			);
});
//-->
</script>