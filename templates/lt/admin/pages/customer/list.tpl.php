<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
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
<?php } ?>
</ul>
<div class="clear">
	<form action="<?php echo $this->_core->getSingleton('Config')->adminUrl?>customer/list" method="get" id="admin-pages-customer-list-search-form">
		<input type="text" name="search" value="<?php echo $this->_core->getRequest('search')?>" size="32" />
		<input type="submit" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SEARCH', 'value')->get('value'); ?>" />
		<input id="admin-pages-customer-list-search-clear" type="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CLEAR', 'value')->get('value'); ?>" />
	</form>
</div>
<hr />
<form action="<?php echo $this->_core->getSingleton('Config')->adminUrl?>customer/list" method="get" id="admin-pages-customer-list-form">
<table class="list" cellspacing="0" cellpadding="0" id="admin-pages-customer-list-table">
	<tr>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=code&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=code&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_FIRST', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=name_first&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=name_first&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_LAST', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=name_last&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=name_last&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADDRESS1', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=address1&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=address1&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<!--<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADDRESS2', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=address2&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=address2&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>-->
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PHONE', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=phone&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=phone&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EMAIL', 'value')->get('value'); ?></th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICEGROUP', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=pricegroup&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=pricegroup&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TYPE', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=typeid&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=typeid&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=status&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/list?sort=status&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
	</tr>
<?php foreach($this->_items as $k=>$item) { ?>
	<tr>
		<td><?php echo $item->get('cardcode');?></td>
		<td><?php echo $item->get('name_first');?></td>
		<td><?php echo $item->get('name_last');?></td>
		<td><?php echo $item->get('address1');?></td>
		<!--<td><?php echo $item->get('address2');?></td>-->
		<td><?php echo $item->get('phone');?></td>
		<td><?php echo $item->get('email');?></td>
		<td><?php echo $this->_prices[$item->get('pricegroup')] instanceof Model_Customer_Pricegroup?$this->_prices[$item->get('pricegroup')]->get('name'):'';?></td>
		<td><?php echo $this->_arrtypes[$item->get('typeid')]['name'];?></td>
		<td class="middle"><a rel="status" class="status status-<?php echo $item->get('status'); ?>" href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>customer/status?id=<?php echo $item->get('id') . '&' . $this->_core->getAllGetParams(array('id')); ?>"></a></td>
		<td><?php
		foreach($this->_actions as $k=>$v) { ?>
			<a href="<?php echo $v['url'] . '?id=' . $item->get('id'); ?>"<?php if($v['warning']) { 
				echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('username'))).'\');"';
			 } ?>><?php echo $v['name'];?></a>
		<?php } ?></td>
	</tr>
<?php }?>
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
			<select name="_p" id="admin-pages-customer-list-pagination">
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
</form>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
	$('#admin-pages-customer-list-search-clear').bind('click', function() {
		$('#admin-pages-customer-list-search-form input[name=search]').attr('value', '');
		$('#admin-pages-customer-list-search-form').submit();
	});
	$('#admin-pages-customer-list-table a.status').unbind('click').bind('click', function() {
		var item = $(this);
		item.attr('class', '');
		item.addClass('status');
		item.addClass('status-loading');
		$.ajax({
			url: $(this).attr('href'),
			data: { doctype: 'xml' },
			dataType: 'xml',
			success: function(data) {
				if($(data).find('result').text() == 'SUCCESS') {
					item.attr('class', '');
					item.addClass('status');
					item.addClass('status-'+$(data).find(item.attr('rel')).text());
				} else {
					var txt = '';
					$(data).find('messages message').each(function() {
						txt += $(this).text()+'\n';
					});
					alert(txt);
				}
			}
		});
		return false;
	});
	$('#admin-pages-customer-list-pagination').bind('change', function() {
		$('#admin-pages-customer-list-form').attr('action', '<?php echo $this->_core->getSingleton('Config')->adminUrl;?>customer/list').attr('method', 'get');
		$('#admin-pages-customer-list-form input[name=search]').val('<?php echo strlen(trim($this->_core->getRequest('search')))>0?'?search=' . urlencode(trim($this->_core->getRequest('search'))):''; ?>');
		$('#admin-pages-customer-list-form').submit();
	});
});
</script>
