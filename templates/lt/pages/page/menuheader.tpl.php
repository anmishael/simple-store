<?php
/**
* Created on 18 ���. 2012
* By Mikel Annjuk <anmishael@gmail.com>
*/
?>
<div id="menu-header-inner">
<?php if(sizeof($this->_items)>0) { ?>
<ul>
<?php $i = 0; $iSize = sizeof($this->_items)-1; ?>
<?php foreach($this->_items as $k=>$item) { ?>
	<li class="<?php echo (($i==0) ? 'first ': ($i==$iSize ? 'last ' : 'inner ')); ?>">
		<a href="<?php echo $item->get('url'); ?>" class="<?php echo (($i==0) ? 'first ': ($i==$iSize ? 'last ' : 'inner ')); ?><?php if( ($item->get('url')!='/' && stristr($this->_core->getUrl(), $item->get('url'))) || $this->_core->getUrl() == $item->get('url') ) { echo 'selected'; } ?>" style="z-index: <?php echo (sizeof($this->_items)-$i); ?>; ">
			<div class="title"><span><?php echo $item->get('menutitle'); ?></span></div>
		</a>
	</li>
	<?php $i++; ?>
<?php } ?>
</ul>
<div class="clear"></div>
<?php } ?>
</div>