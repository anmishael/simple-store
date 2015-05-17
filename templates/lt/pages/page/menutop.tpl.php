<?php
/**
 * File: menutop.tpl.php
 * Created on 20.05.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */
?>
<div id="menu-top">
<?php if(sizeof($this->_items)>0) { ?>
<ul>
<?php $i = 0; $iSize = sizeof($this->_items)-1; ?>
<?php foreach($this->_items as $k=>$item) { ?>
	<li class="<?php echo (($i==0) ? 'first ': ($i==$iSize ? 'last ' : 'inner ')); ?>topitem">
		<a href="<?php echo $item->get('url'); ?>" class="<?php echo (($i==0) ? 'first ': ($i==$iSize ? 'last ' : 'inner ')); ?><?php if( ($item->get('url')!='/' && stristr($this->_core->getUrl(), $item->get('url'))) || $this->_core->getUrl() == $item->get('url') ) { echo 'selected'; } ?>" style="z-index: <?php echo (sizeof($this->_items)-$i); ?>; ">
			<div class="title"><span><?php echo $item->get('menutitle'); ?></span></div>
		</a>
		<?php if($item->get('children')) { ?>
		<div class="pulldown">
		<ul class="submenu"><?php echo $this->generateTree($item->get('children')); ?></ul>
		</div>
		<?php } ?>
	</li>
	<?php $i++; ?>
<?php } ?>
</ul>
<div class="clear"></div>
<?php } ?>
</div>
<div class="clear"></div>