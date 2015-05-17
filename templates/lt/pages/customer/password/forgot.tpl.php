<?php
/*
 * Created on 25 лип. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<div id="customer-password-forgot-area">
	<div>&nbsp;</div>
	<div class="title"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_PASSWORD_FORGOT_TITLE')->get('value'); ?></div>
	<hr class="light" />
	<div class="icon"></div>
	<div class="form"><form action="/customer/password/reset" method="post">
		<div class="username">
			<label for="username-field"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_PASSWORD_FORGOT_EMAIL')->get('value'); ?> <span class="required">&#42;</span></label>
			<input type="text" name="email" value="" />
		</div>
		<div class="clear"></div>
		<p></p>
		<div class="buttons">
			<input width="129" type="submit" height="26" class="btn-next-step" src="/templates/forrent/css/images/pixel-trans.gif" value="<?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_PASSWORD_FORGOT_REFINE')->get('value'); ?>">
		</div>
		<div class="text">
			<div class="required-help"><p>
				<span class="required">&#42;</span> &ndash; <?php echo $this->_core->getModel('Translate/Collection')->get('REQUIRED_FIELDS')->get('value'); ?>
			</p></div>
		</div>
	</form></div>
	<div>&nbsp;</div>
</div>