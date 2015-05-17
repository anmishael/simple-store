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
			<div class="phone">
				<div class="icon"></div>
				<div class="text"><?php echo $this->_core->getModel('Translate/Collection')->get('FOOTER_ADDRESS', 'value')->get('value'); ?></div>
				<div class="clear"></div>
			</div>
			<div class="address">&nbsp;<?php //echo $this->_core->getModel('Translate/Collection')->get('FOOTER_ADDRESS', 'value')->get('value'); ?></div>
			<div class="email"><?php echo $this->_core->getModel('Translate/Collection')->get('FOOTER_EMAIL', 'value')->get('value'); ?></div>
			<div class="icons">
				<ul>
					<li><a href="javascript:;" class="twitter"></a></li>
					<li><a href="javascript:;" class="facebook"></a></li>
					<li><a href="javascript:;" class="google"></a></li>
					<li><a href="javascript:;" class="t4l"></a></li>
				</ul>
			</div>
		</div>
		<div class="center-area"><?php $items_block = array_chunk($this->_items, 4); ?>
			<table>
			<tr>
				<th><?php echo $this->_core->getModel('Translate/Collection')->get('FOOTER_SITE_TEXT')->get('value'); ?></th>
				<th><?php echo $this->_core->getModel('Translate/Collection')->get('FOOTER_ACCOUNT_TEXT')->get('value'); ?></th>
			</tr>
			<tr>
			<td>
			<?php foreach($items_block as $items) { ?>
			<ul>
				<?php foreach($items as $item) { ?>
				<li><a href="<?php echo $item->get('url'); ?>"><?php echo $item->get('menutitle'); ?></a></li>
				<?php } ?>
			</ul>
			<?php } ?>
			</td>
			<td>
			<ul class="account">
				<?php if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id')) { ?>
				<li><a href="/customer/view"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_PROFILE')->get('value'); ?></a></li>
				<?php } else { ?>
				<li><a href="/customer/login"><?php echo $this->_core->getModel('Translate/Collection')->get('FOOTER_LOGIN_TEXT')->get('value'); ?></a></li>
				<?php } ?>
				<li><a href="/questions"><?php echo $this->_core->getModel('Translate/Collection')->get('FOOTER_QUESTIONS_TEXT')->get('value'); ?></a></li>
			</ul>
			</td></tr>
			</table>
		</div>
		<div class="right-area">
			<table>
				<tr>
					<th>Пошук по сайту</th>
				</tr>
				<tr>
					<td><form action="<?php echo $this->topFolder; ?>search" method="get"><div class="search">
						<table width="98%" height="100%" cellspacing="0" cellpadding="0" align="right">
						<tr>
							<td><input type="text" name="search" value="<?php echo htmlspecialchars($this->_core->getRequestGet('search')); ?>" /></td>
							<td><input type="image" src="<?php echo $this->templateDir; ?>css/images/pixel-trans.gif" width="34" height="30" /></td>
						</tr>
						</table>
					</div></form></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="footer-right"></div>
	<div class="clear"></div>
</div>
<div class="clear"></div>