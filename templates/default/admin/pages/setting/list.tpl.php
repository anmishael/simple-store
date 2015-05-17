<?php
/**
 * Created on 19 ���. 2012
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
<form id="admin-pages-setting-list-search-form" action="<?php echo $this->_core->getSingleton('Config')->adminUrl?>setting/list" method="get">
	<?php foreach($this->_core->getRequestGet() as $k=>$v) { ?>
	<?php if($k!='search') { ?>
	<input type="hidden" name="<?php echo $k; ?>" value="<?php echo $v; ?>" />
	<?php } ?>
	<?php } ?>
	<input type="text" name="search" value="<?php echo $this->_core->getRequest('search')?>" size="32" />
	<input type="submit" value="Search" />
	<input id="admin-pages-setting-list-search-clear" type="button" value="Clear" />
</form>
</div>
<hr />
<table class="list" cellspacing="0" cellpadding="0">
	<tr>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ID', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_KEY', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VALUE', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PUBLIC', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
	</tr>
<?php foreach($this->_items as $k=>$item) { ?>
	<tr>
		<td><?php echo $item->get('id');?></td>
		<td><?php echo $item->get('key');?></td>
		<td><?php if($item->get('type') == 'password') { echo ' &bull; &bull; &bull; &bull; &bull; &bull; &bull; &bull; &bull; &bull; &bull; '; } else {
			$txt = explode(' ', trim(htmlspecialchars($item->get('value'))));
			$txt = array_chunk($txt, 10);
			echo implode(' ', $txt[0]) . (sizeof($txt)>1?' ...':'');
		} ?></td>
		<td><?php echo ($item->get('public')==1?$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_YES', 'value')->get('value'):$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NO', 'value')->get('value'));?></td>
		<td><?php
		foreach($this->_actions as $k=>$v) { ?>
			<a href="<?php echo $v['url'] . '?id=' . $item->get('id') . '&' . $this->_core->getAllGetParams(array('id')); ?>"<?php if($v['warning']) { 
				echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('key'))).'\');"';
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
		<li>&nbsp;</li>
		<li><form action="" method="get">
		<select name="_p" onchange="this.form.submit();">
		<?php for($k = 1; $k <= $this->_totalpages; $k++) { ?>
			<option value="<?php echo $k; ?>"<?php if($k == $this->_page) { ?> selected="selected"<?php } ?>><?php echo $k; ?></option>
		<?php } ?>
		</select>
	</form></li>
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
	$('#admin-pages-setting-list-search-clear').bind('click', function() {
		$('#admin-pages-setting-list-search-form input[name=search]').attr('value', '');
		$('#admin-pages-setting-list-search-form').submit();
	});
});
</script>