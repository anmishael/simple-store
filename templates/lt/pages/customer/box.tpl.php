<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 02.04.13
 * Time: 0:53
 * To change this template use File | Settings | File Templates.
 */

?>
<div class="content-box customerbox alwaysopened">
	<div class="box-header"></div>
	<div class="box-inner">
		<div class="box-title"><?php echo $this->_core->getModel('Translate/Collection')->get('BOX_CUSTOMER_TITLE', 'value')->get('value'); ?><div class="icon"></div></div>
		<div class="box-content">
			<dl>
				<dt><?php echo sprintf($this->_core->getModel('Translate/Collection')->get('BOX_CUSTOMER_LOGGED_AS', 'value')->get('value'), ''); ?></dt>
				<dd><b><?php echo $this->_customer->get('name_first') . ' ' . $this->_customer->get('name_last'); ?></b></dd>
				<dt><a href="<?php echo $this->topFolder; ?>customer/view"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_VIEW_MY_PROFILE', 'value')->get('value'); ?></a></dt>
				<dt><a href="<?php echo $this->topFolder; ?>customer/view#my-orders"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_VIEW_MY_ORDERS')->get('value'); ?></a></dt>
				<dt>
				<div class="logout">
					<input width="115" type="image" height="26" value="<?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGOUT', 'value')->get('value'); ?>" src="/templates/default/css/images/pixel-trans.gif">
					<a class="title" href="<?php echo $this->topFolder; ?>customer/logout"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGOUT', 'value')->get('value'); ?></a>
				</div>
				<div class="clear"></div>
				</dt>
			</dl>
		</div>
	</div>
	<div class="box-footer"></div>
</div>