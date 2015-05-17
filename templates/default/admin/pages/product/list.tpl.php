<?php
/*
 * Created on May 25, 2012
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
// echo $_p_start .' ...' . $_p_end;
?>
<ul class="links-list">
<?php foreach($this->_toplinks as $k=>$link) { ?>
	<li><a href="<?php echo $link['url']?>"><?php echo $link['name'];?></a></li>
	<li class="clear"></li>
<?php } ?>
</ul>
<div class="clear">
<form action="<?php echo $this->_core->getSingleton('Config')->adminUrl?>product/list" method="get" id="admin-pages-product-list-search-form">
	<input type="text" name="search" value="<?php echo $this->_core->getRequest('search')?>" size="32" />
	<input type="submit" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SEARCH', 'value')->get('value'); ?>" />
	<input id="admin-pages-product-list-search-clear" type="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CLEAR', 'value')->get('value'); ?>" />
</form>
</div>
<hr />
<form action="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list<?php echo strlen(trim($this->_core->getRequest('search')))>0?'?search=' . urlencode(trim($this->_core->getRequest('search'))):''; ?>" method="post" id="admin-pages-product-list-form">
<table class="list" cellspacing="0" cellpadding="0" id="admin-pages-product-list-table" style="width: 100%;">
	<tr>
		<th><input type="checkbox" name="selection" /></th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ID', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=id&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=id&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMAGE', 'value')->get('value'); ?></th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=name&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=name&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_BUNDLES', 'value')->get('value'); ?>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FILTERS', 'value')->get('value'); ?>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=code&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=code&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<!--<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SKU', 'value')->get('value'); ?></th>-->
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_QTY', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=qty&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=qty&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=price&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=price&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADDITIONAL', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=additional&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=additional&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<!--<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TYPE', 'value')->get('value'); ?></th>-->
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADDED', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=added&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=added&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=status&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=status&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS_NEW', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=status_new&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=status_new&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS_ACTION', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=status_action&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=status_action&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th>
			<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS_TOPSELL', 'value')->get('value'); ?>
			<div></div>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=status_topsell&way=asc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-ascending"><span class="title">Asc</span></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/list?sort=status_topsell&way=desc&<?php echo $this->_core->getAllGetParams(array('sort', 'way')); ?>" class="icon view-sort-descending"><span class="title">Desc</span></a>
		</th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
	</tr>
<?php foreach($this->_items as $k=>$item) { ?>
	<?php $item->fetchImages()->fetchFilters(true)->fetchBundles(); $images = $item->get('images'); ?>
	<tr>
		<td><input type="checkbox" name="pid[]" value="<?php echo $item->get('id'); ?>" /></td>
		<td><?php echo $item->get('id'); ?></td>
		<td><img src="<?php echo $images['image'][100][0]; ?>" /></td>
		<td class="product-name">
			<?php if($item->get('bundles')) { $bundles = $item->get('bundles'); ?>
			<a href="<?php echo $this->_core->getActionUrl('admin-product-bundle-edit') . '?id=' . $bundles[0]->get($bundles[0]->_id); ?>" class="status-1" title="Приєднаний до в`язки"></a>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/edit?id=<?php echo $item->get('id') ?>" class="item-name" <?php echo ($images['image'][100][0]?' rel="'.$images['image'][100][0].'"':''); ?>><?php echo $item->get('name'); ?></a>
			<div class="bundles">
				<ul>
				<?php foreach($bundles as $bundle) { ?>
					<li><a href="<?php echo $this->_core->getActionUrl('admin-product-bundle-edit') . '?id=' . $bundle->get($bundle->_id); ?>"><?php echo $bundle->get('name'); ?></a></li>
				<?php } ?>
				</ul>
			</div>
			<?php } else { ?>
			<a href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/edit?id=<?php echo $item->get('id') ?>" class="item-name" <?php echo ($images['image'][100][0]?' rel="'.$images['image'][100][0].'"':''); ?>><?php echo $item->get('name'); ?></a>
			<?php } ?>
		</td>
		<td><?php if($item->get('bundles')) { $bundles = $item->get('bundles'); ?>
				<div class="bundles">
					<?php foreach($bundles as $bundle) { ?>
					<div><a href="<?php echo $this->_core->getActionUrl('admin-product-bundle-edit') . '?id=' . $bundle->get($bundle->_id); ?>"><?php echo $bundle->get('name'); ?></a></div>
					<?php } ?>
				</div>
		<?php } ?></td>
		<td><?php $filters = $item->get('filters'); $arr = array(); foreach($filters as $filter) { $arr[] = $filter->get('name'); } echo implode(', ', $arr); ?></td>
		<td><?php echo $item->get('code'); ?></td>
		<!--<td><?php echo $item->get('sku'); ?></td>-->
		<td><?php echo $item->get('quantity'); ?></td>
		<td><?php echo $item->get('price'); ?></td>
		<!--<td><?php echo $item->get('typename'); ?></td>-->
    <td><?php echo $item->get('additional'); ?></td>
		<td><?php echo $item->get('added'); ?></td>
		<td class="middle"><a rel="status" class="status status-<?php echo $item->get('status'); ?>" href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/status?id=<?php echo $item->get('id') . '&' . $this->_core->getAllGetParams(array('id')); ?>"></a></td>
		<td class="middle"><a rel="status_new" class="status status-<?php echo $item->get('status_new'); ?>" href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/statusnew?id=<?php echo $item->get('id') . '&' . $this->_core->getAllGetParams(array('id')); ?>"></a></td>
		<td class="middle"><a rel="status_action" class="status status-<?php echo $item->get('status_action'); ?>" href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/statusaction?id=<?php echo $item->get('id') . '&' . $this->_core->getAllGetParams(array('id')); ?>"></a></td>
		<td class="middle"><a rel="status_topsell" class="status status-<?php echo $item->get('status_topsell'); ?>" href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>product/statustopsell?id=<?php echo $item->get('id') . '&' . $this->_core->getAllGetParams(array('id')); ?>"></a></td>
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
		<li><select name="_limit" onchange="this.form.submit();">
			<?php foreach($this->_arrLimit as $limit) { ?>
			<option value="<?php echo $limit; ?>"<?php echo $limit == $this->_limit ? ' selected="selected"': ''; ?>><?php echo $limit; ?> на сторінку</option>
			<?php } ?>
		</select></li>
		<li class="clear"></li>
	</ul>
</div>
<div class="clear"></div>
<div>
	<h2 id="admin-product-list-form-pages-h2"><a href="javascript:;"><span class="icon list-add"></span> <?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PAGES', 'value')->get('value'); ?></a></h2>
	<div id="admin-product-list-form-pages">
		<ul class="links-list-vertical">
		<?php foreach($this->_pages as $page) { ?>
			<li><input id="page-<?php echo $page->get('id') ?>" type="checkbox" class="checkbox" name="pages[]" value="<?php echo $page->get('id'); ?>" /> <label for="page-<?php echo $page->get('id'); ?>"><?php echo $page->get('name') . ' (' . $page->get('url') . ')' ?></label></li>
		<?php } ?>
		</ul>
	</div>
	<h2 id="admin-product-list-form-filters-h2"><a href="javascript:;"><span class="icon list-add"></span> <?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FILTERS', 'value')->get('value'); ?></a></h2>
	<div id="admin-product-list-form-filters"><?php foreach($this->_filter_types as $filtertype) { ?>
		<h4><?php echo $filtertype->get('name'); ?></h4>
		<ul class="links-list">
			<?php foreach($filtertype->get('filters') as $k=>$v) { ?>
			<li><input id="product-list-filter-<?php echo $v->get('id'); ?>" type="checkbox" name="filters[]" value="<?php echo $v->get('id'); ?>" /> <label for="product-list-filter-<?php echo $v->get('id'); ?>"><?php echo $v->get('name');?></label></li>
			<?php } ?>
		</ul>
		<?php } ?></div>
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
	<input type="submit" id="products-remove" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'); ?>" />
</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
	var _saveUrl = '<?php echo $this->_core->getSingleton('Config')->adminUrl;?>product/save?<?php echo $this->_core->getAllGetParams(array('pids', 'pages', 'filters')); ?>';
	var _listUrl = '<?php echo $this->_core->getSingleton('Config')->adminUrl;?>product/list?<?php echo $this->_core->getAllGetParams(array('pids', 'pages', 'filters')); ?>';
	var _removeUrl = '<?php echo $this->_core->getSingleton('Config')->adminUrl;?>product/remove?<?php echo $this->_core->getAllGetParams(array('pids', 'pages', 'filters')); ?>';
	$('#admin-pages-product-list-search-clear').bind('click', function() {
		$('#admin-pages-product-list-search-form input[name=search]').attr('value', '');
		$('#admin-pages-product-list-search-form').submit();
	});
	$('#admin-pages-product-list-table tr th input[name=selection]').bind('change', function() {
		if($(this).attr('checked')) {
			$('#admin-pages-product-list-table tr td input[type=checkbox]').attr('checked', true);
			$('#admin-pages-product-list-form').attr('action', _saveUrl);
		} else {
			$('#admin-pages-product-list-table tr td input[type=checkbox]').attr('checked', false);
			$('#admin-pages-product-list-form').attr('action', _listUrl);
		}
	});
	$('#admin-pages-product-list-pagination').bind('change', function() {
		$('#admin-pages-product-list-form').attr('action', '<?php echo $this->_core->getSingleton('Config')->adminUrl;?>product/list').attr('method', 'get');
		$('#admin-pages-product-list-form input[name=search]').val('<?php echo strlen(trim($this->_core->getRequest('search')))>0?'?search=' . urlencode(trim($this->_core->getRequest('search'))):''; ?>');
		$('#admin-pages-product-list-form').submit();
	});
	$('#admin-pages-product-list-table tr td input[type=checkbox]').bind('change', function() {
		$('#admin-pages-product-list-form').attr('action', _saveUrl);
	});
	$('#admin-product-list-form-pages').hide();
	$('#admin-product-list-form-pages-h2').bind('click', function() {
		if($('#admin-product-list-form-pages').css('display') == 'none') {
			$('#admin-product-list-form-pages').show();
			$('#admin-product-list-form-pages-h2 span.icon').removeClass('list-add').addClass('list-remove');
		} else {
			$('#admin-product-list-form-pages').hide();
			$('#admin-product-list-form-pages-h2 span.icon').removeClass('list-remove').addClass('list-add');
		}
	});
	$('#admin-product-list-form-filters').hide();
	$('#admin-product-list-form-filters-h2').bind('click', function() {
		if($('#admin-product-list-form-filters').css('display') == 'none') {
			$('#admin-product-list-form-filters').show();
			$('#admin-product-list-form-filters-h2 span.icon').removeClass('list-add').addClass('list-remove');
		} else {
			$('#admin-product-list-form-filters').hide();
			$('#admin-product-list-form-filters-h2 span.icon').removeClass('list-remove').addClass('list-add');
		}
	});
	$('#admin-pages-product-list-table a.status').unbind('click').bind('click', function() {
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
	$(document).bind('scroll', function() {
		if(!$('.admin-pages-product-list-table-clone')[0]) {
			var el = $('#admin-pages-product-list-table');
			var cl = el.clone();
			cl.addClass('admin-pages-product-list-table-clone');
			cl.attr('id', 'admin-pages-product-list-table-clone');
			cl.find('tr').not(':first').remove();
			cl.css({width: (el.width()+2)+'px'})
			el.find('tr:first').find('th').each(function(i) {
				$(cl.find('tr:first th')[i]).css({width: $(this).width()+'px'});
			});
			$('#admin-pages-product-list-form').append(cl);
			$('#admin-pages-product-list-table-clone input[type=checkbox]').unbind('change').bind('change', function() {
				$('#admin-pages-product-list-table input[type=checkbox]').attr('checked', $(this).attr('checked')?true:false);
			});
		}
		if(window.pageYOffset>$('#admin-pages-product-list-table').offset().top) {
			$('.admin-pages-product-list-table-clone').css({top: '0px', position: 'fixed'}).show();
//			$('#admin-pages-product-list-table th').css({display: 'fixed'});
		} else {
			$('.admin-pages-product-list-table-clone').hide();
//			$('#admin-pages-product-list-table th').css({display: 'table-row'});
		}
	});
	$('#products-remove').bind('click', function() {
		var res = confirm('Are you sure you wish to remove all selected products?');
		if(res) {
			$(this).parents('form').attr('action', _removeUrl);
		}
		return res;
	});
});
/*
$(document).ready(function() {
	$('#admin-pages-product-list-search-clear').bind('click', function() {
		$('#admin-pages-product-list-search-form input[name=search]').attr('value', '');
		$('#admin-pages-product-list-search-form').submit();
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
*/
</script>