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
 
?>
<ul class="links-list">
<?php foreach($this->_toplinks as $k=>$link) { ?>
	<li><a href="<?php echo $link['url']?>"><?php echo $link['name'];?></a></li>
	<li class="clear"></li>
<?php } ?>
</ul>
<div class="clear">
<form action="<?php echo $this->_core->getSingleton('Config')->adminUrl?>state/city/list" method="get">
	<input type="text" name="search" value="<?php echo $this->_core->getRequest('search')?>" size="32" />
	<input type="submit" value="Search" />
	<input id="admin-pages-state-city-list-search-clear" type="button" value="Clear" />
</form>
</div>
<hr />
<table class="list" cellspacing="0" cellpadding="0" id="admin-pages-state-city-list-table">
	<tr>
		<th><input type="checkbox" class="checkbox" id="admin-pages-state-city-list-checkbox-ids" /></th>
		<th>City name</th>
		<th>ZIP Code</th>
		<th>ZIP Code Type</th>
		<th>Latitude</th>
		<th>Longitude</th>
		<th>County</th>
		<th>State</th>
		<th>Weight</th>
		<th>Action</th>
	</tr>
<?php foreach($this->_items as $k=>$item) { ?>
	<tr>
		<td class="first"><input type="checkbox" class="ids" name="ids[]" value="<?php echo $item->get('id');?>" /></td>
		<td><?php echo $item->get('name');?></td>
		<td><?php echo $item->get('zip');?></td>
		<td><?php echo $item->get('zip_type');?></td>
		<td><?php echo $item->get('latitude');?></td>
		<td><?php echo $item->get('longitude');?></td>
		<td><?php echo (isset($this->_counties[$item->get('county')]) ? $this->_counties[$item->get('county')]->get('name') : '');?></td>
		<td><?php echo $this->_states[$item->get('state')]->get('name') . ', ' . $this->_states[$item->get('state')]->get('code');?></td>
		<td><?php echo $this->_weights[$item->get('weight')];?></td>
		<td><?php
		foreach($this->_actions as $k=>$v) { ?>
			<a href="<?php echo $v['url'] . '?id=' . $item->get('id'); ?>"<?php if($v['warning']) { 
				echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('name'))).'\');"';
			 } ?>><?php echo $v['name'];?></a>
		<? } ?></td>
	</tr>
<?php }?>
</table>
<div class="clear">
	<ul class="pagination">
		<li><form action="?_p=<?php echo ($this->_page-1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>" method="post">
		<select name="_limit" onchange="this.form.submit();">
		<?php foreach($this->_perpage as $k=>$v) { ?>
			<option value="<?php echo $v; ?>"<?php if($v == $this->_limit) { ?> selected="selected"<?php } ?>><?php echo $v; ?></option>
		<?php } ?>
		</select> items per page
	</form></li>
		<?php if($_p_start>1) { ?>
		<li><a href="?_p=<?php echo ($this->_page-1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"> << </a></li>
		<?php } ?>
		<?php for($k = $_p_start; $k < $_p_end; $k++) { ?>
		<li><a<?php if($k == $this->_page) { ?> class="selected"<?php } ?> href="?_p=<?php echo $k . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $k; ?></a></li>
		<?php }?>
		<?php if($this->_totalpages>1) { ?>
		<li> &nbsp; &nbsp; </li>
		<li><form action="?_p=<?php echo ($this->_page-1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>" method="post">
		<select name="_p" onchange="this.form.submit();">
		<?php for($k = 1; $k < $this->_totalpages; $k++) { ?>
			<option value="<?php echo $k; ?>"<?php if($k == $this->_page) { ?> selected="selected"<?php } ?>><?php echo $k; ?></option>
		<?php } ?>
		</select>
	</form></li>
		<?php } ?>
		<?php if($_p_end<$this->_totalpages) { ?>
		<li><a href="?_p=<?php echo ($this->_page+1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"> >> </a></li>
		<?php } ?>
		<li> &nbsp; &nbsp; </li>
		<li>Made changes with selected: </li>
		<li> &nbsp; &nbsp; </li>
		<li><form action="<?php echo $this->_core->getSingleton('Config')->adminUrl?>state/city/apply?<?php echo $this->_core->getAllGetParams(array('ids')); ?>" id="admin-pages-state-city-list-checkbox-ids-apply-form" method="post">
			<div>weight</div>
			<div><select name="weight">
			<option value="-1">No changes</option>
			<?php foreach($this->_weights as $k=>$v) { ?>
			<option value="<?php echo $k; ?>"><?php echo $v;?></option>
			<?php } ?>
			</select></div></form>
		</li>
		<li><a href="javascript:;" id="admin-pages-state-city-list-checkbox-ids-apply">Apply</a></li>
		<li class="clear"></li>
	</ul>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
	$('#admin-pages-state-city-list-search-clear').bind('click', function() {
		window.location = '<?php echo $this->_core->getSingleton('Config')->adminUrl?>state/city/list';
		return false;
	});
	$('table#admin-pages-state-city-list-table tr td').bind('click', function() {
		var el = $(this).parent().find('input.ids');
		if(el.attr('checked') && el.attr('checked') == 'checked') {
			el.attr('checked', false);
		} else {
			el.attr('checked', 'checked');
		}
	});
	$('table#admin-pages-state-city-list-table tr td.first').unbind('click');
	$('input#admin-pages-state-city-list-checkbox-ids').bind('click', function() {
		if($(this).attr('checked') && $(this).attr('checked') == 'checked') {
			$('table#admin-pages-state-city-list-table tr td input.ids').attr('checked', $(this).attr('checked'));
		} else {
			$('table#admin-pages-state-city-list-table tr td input.ids').attr('checked', false);
		}
	});
	$('#admin-pages-state-city-list-checkbox-ids-apply').bind('click', function() {
		$('table#admin-pages-state-city-list-table tr td input.ids[checked=checked]').each(function(i, el) {
			var form = $('#admin-pages-state-city-list-checkbox-ids-apply-form');
			form.append('<input type="hidden" name="ids[]" value="'+$(el).attr('value')+'" />');
		});
		$('#admin-pages-state-city-list-checkbox-ids-apply-form').submit();
	});
});
</script>