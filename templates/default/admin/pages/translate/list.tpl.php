<?php
/**
 * Created on 3 Sep. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * 
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
    <li><a href="<?php echo $link['url'].'?'.($this->_core->getRequest('_p')?'&_p='.$this->_core->getRequest('_p'):'')?>"><?php echo $link['name'];?></a></li>
<?php } ?>
</ul>
<div class="clear">
<form action="<?php echo $this->_core->getSingleton('Config')->adminUrl?>translate/list" method="get">
	<input type="text" name="search" value="<?php echo $this->_core->getRequest('search')?>" size="32" />
	<input type="submit" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SEARCH', 'value')->get('value'); ?>" />
	<input id="admin-pages-translate-list-search-clear" type="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CLEAR', 'value')->get('value'); ?>" />
</form>
</div>
<table class="list" cellspacing="0" cellpadding="0">
	<tr>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_KEY', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VALUE', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_LANGUAGE', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_BACKEND', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
	</tr>
<?php foreach($this->_items as $k=>$item) { ?>
	<?php
		$value = explode(' ', str_replace('  ', ' ', strip_tags($item->get('value'))));
		if(sizeof($value)>19) {
			$value = array_chunk($value, 20);
			$value = implode(' ', $value[0]) . '...';
		} else {
			$value = implode(' ', $value);
		}
	?>
	<tr>
		<td><?php echo $item->get('key');?></td>
		<td><?php echo $value;?></td>
		<td><?php echo $this->_languages[$item->get('language')]->get('name');?></td>
		<td><?php echo ($item->get('backend')==1?$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_YES', 'value')->get('value'):$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NO', 'value')->get('value'));?></td>
		<td class="action"><?php
			foreach ($this->_actions as $k => $v) {
				?>
                <a href="<?php echo $v['url'] . '?' . (isset($v['var']) ? $v['var'] : 'id') . '=' . $item->get($item->_id).'&'.$this->_core->getAllGetParams(array((isset($v['var']) ? $v['var'] : 'id'))); ?>"<?php if (isset($v['warning'])) {
				echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('name'))).'\');"';
			 } ?>><?php echo $v['name'];?></a>
		<?php } ?></td>
	</tr>
<?php }?>
</table>
<div class="clear">
	<ul class="pagination">
		<?php if($_p_start>1) { ?>
        <li><a href="?_p=<?php echo ($this->_page - 1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"> << </a>
        </li>
		<?php } ?>
		<?php for($k = $_p_start; $k <= $_p_end; $k++) { ?>
        <li><a<?php if ($k == $this->_page) { ?> class="selected"<?php } ?>
                                                 href="?_p=<?php echo $k . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $k; ?></a>
        </li>
		<?php }?>
		<?php if($this->_totalpages>1) { ?>
		<li> &nbsp; </li>
        <li>
            <form action="" method="get">
		<select name="_p" onchange="this.form.submit();">
		<?php for($k = 1; $k <= $this->_totalpages; $k++) { ?>
                    <option value="<?php echo $k; ?>"<?php if ($k == $this->_page) { ?>
                            selected="selected"<?php } ?>><?php echo $k; ?></option>
		<?php } ?>
		</select>
            </form>
        </li>
		<?php } ?>
		<?php if($_p_end<$this->_totalpages) { ?>
        <li><a href="?_p=<?php echo ($this->_page + 1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"> >> </a>
        </li>
		<?php } ?>
		<li class="clear"></li>
	</ul>
</div>
<div class="clear"></div>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('#admin-pages-translate-list-search-clear').bind('click', function() {
		$('#admin-pages-translate-list-search-form input[name=search]').attr('value', '');
		$('#admin-pages-translate-list-search-form').submit();
	});
});
//-->
</script>