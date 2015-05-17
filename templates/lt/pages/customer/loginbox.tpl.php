<?php
/**
* Created on 18 ���. 2012
* By Mikel Annjuk <anmishael@gmail.com>
* Especially for KinetoscopeMedia Inc.
*/
?>
<div class="content-box loginbox alwaysopened">
	<div class="box-header"></div>
	<div class="box-inner">
		<div class="box-title"><?php echo $this->_core->getModel('Translate/Collection')->get('BOX_LOGIN_TITLE', 'value')->get('value'); ?><div class="icon"></div></div>
		<div class="box-content">
			<form action="<?php echo $this->topFolder; ?>customer/login" method="post">
				<div class="email">
					<div class="input"><input type="text" name="email" /></div>
					<div class="icon"></div>
					<div class="clear"></div>
				</div>
				<div class="password">
					<div class="input"><input type="password" name="password" /></div>
					<div class="icon"></div>
					<div class="clear"></div>
				</div>
				<div class="login">
					<input type="image" src="<?php echo $this->templateDir; ?>css/images/pixel-trans.gif" width="115" height="26" value="<?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN', 'value')->get('value'); ?>" />
					<a href="javascript:;" class="title"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN', 'value')->get('value'); ?></a>
				</div>
			</form>
		</div>
	</div>
	<div class="box-footer"></div>
</div>