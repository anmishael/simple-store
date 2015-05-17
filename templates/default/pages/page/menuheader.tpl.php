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
		<span class="separator"><img src="<?php echo $this->templateDir; ?>css/images/pixel-trans.gif" width="2" height="49"" /></span>
	</li>
	<li>|</li>
	<?php $i++; ?>
<?php } ?>
	<li class="login"><?php echo (!$this->_customer->get('id')
			?
			'<a href="/customer/login">'.$this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN', 'value')->get('value').'</a>'
			:
			'<a href="/customer/logout">'.$this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGOUT', 'value')->get('value') . '</a>'); ?></li>
</ul>
<div class="clear"></div>
<?php } ?>
</div>