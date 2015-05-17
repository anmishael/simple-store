<?php
/*
 * Created on 25 ����. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<h1><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN', 'value')->get('value'); ?></h1>
<hr />
<div id="customer-login-area">
<div>&nbsp;</div>
<?php //include(substr($this->_core->getSingleton('Config')->templateDir, 1) . 'pages/dialog/dialog-login.html'); ?>
	<form action="<?php echo $this->topFolder; ?>customer/login" method="post" id="customer-login-form">
		<label for="customer-login-email"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN_EMAIL', 'value')->get('value'); ?></label>
		<input id="customer-login-email" type="text" name="email" />
		<label for="customer-login-password"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN_PASSWORD', 'value')->get('value'); ?></label>
		<input id="customer-login-password" type="password" name="password" />
		<div class="login">
			<input width="52" type="submit" height="30" value="<?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN')->get('value'); ?>" src="<?php echo $this->templateDir; ?>css/images/pixel-trans.gif">
			<!--<a href="javascript:;" onclick="document.getElementById('customer-login-form').submit()" class="title"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN', 'value')->get('value'); ?></a>-->
		</div><?php if($_SESSION['redirect']) { ?>
		<input type="hidden" name="redirect" value="<?php echo $_SESSION['redirect']; ?>" />
		<?php } ?>
	</form>
<div>&nbsp;</div>
</div>