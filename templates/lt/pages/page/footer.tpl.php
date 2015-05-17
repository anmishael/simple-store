<?php
/*
 * Created on May 22, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<div class="footer-main">
	<div class="footer-left"></div>
	<div class="footer-inner">
		<div class="left-icons">
		<h3>МЕНЮ</h3>
		<?php $items_block = array_chunk($this->_items, 4); ?>
		<?php foreach($items_block as $items) { ?>
			<ul>
				<?php foreach($items as $item) { ?>
					<li><a href="<?php echo $item->get('url'); ?>"><?php echo $item->get('menutitle'); ?></a></li>
				<?php } ?>
			</ul>
		<?php } ?></div>
		<div class="center-area">
			<?php echo $this->_core->getModel('Translate/Collection')->get('FOOTER_SITE_TEXT')->get('value'); ?>
		</div>
		<div class="right-area">
			<div class="left-icons">
				<div class="text"><?php echo $this->_core->getModel('Translate/Collection')->get('FOOTER_ADDRESS', 'value')->get('value'); ?></div>
			</div>
		</div>
	</div>
	<div class="footer-right"></div>
	<div class="clear"></div>
</div>
<div class="clear"></div>