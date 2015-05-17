<?php
/**
 * Created on 18 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
?>
<h1><?php echo $this->_core->getModel('Translate/Collection')->get('BOX_LOGIN_REGISTRATION', 'value')->get('value'); ?></h1>
<hr />
<div id="block-customer-register">
	<form action="<?php echo $this->topFolder; ?>customer/register" method="post">
		<div class="inner-area">
			<div class="row">
				<label class="td" for="block-customer-register-name-first"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_FIRST')->get('value'); ?></label>
				<input class="td" id="block-customer-register-name-first" type="text" name="name_first" value="<?php echo $this->_post['name_first']; ?>" size="32" maxlength="255" />
			</div>
			<div class="row">
				<label class="td" for="block-customer-register-name-last"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_LAST')->get('value'); ?></label>
				<input class="td" id="block-customer-register-name-last" type="text" name="name_last" value="<?php echo $this->_post['name_last']; ?>" size="32" maxlength="255" />
			</div>
			<div class="row">
				<label class="" for="block-customer-register-email"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_EMAIL')->get('value'); ?></label>
				<input class="" id="block-customer-register-email" type="text" name="email" value="<?php echo $this->_post['email']; ?>" size="32" maxlength="255" />
			</div>
			<div class="row">
				<label class="" for="block-customer-register-password"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_PASSWORD')->get('value'); ?></label>
				<input class="" id="block-customer-register-password" type="password" name="password" value="" size="32" maxlength="255" />
			</div>
			<div class="row">
				<label class="" for="block-customer-register-password-confirm"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_PASSWORD_CONFIRM')->get('value'); ?></label>
				<input class="td" id="block-customer-register-password-confirm" type="password" name="password_confirm" value="" size="32" maxlength="255" />
			</div>
			<div class="row">
				<label class="" for="block-customer-register-state"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_STATE')->get('value'); ?></label>
				<input class="" id="block-customer-register-state" type="text" name="state" value="<?php echo $this->_post['state']; ?>" size="32" maxlength="255" />
			</div>
			<div class="row">
				<label class="" for="block-customer-register-state"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_CITY')->get('value'); ?></label>
				<input class="" id="block-customer-register-city" type="text" name="city" value="<?php echo $this->_post['city']; ?>" size="32" maxlength="255" />
			</div>
			<div class="row">
				<label class="" for="block-customer-register-address1"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_ADDRESS1')->get('value'); ?></label>
				<input class="" id="block-customer-register-address1" type="text" name="address1" value="<?php echo $this->_post['address1']; ?>" size="32" maxlength="255" />
			</div>
			<div class="row">
				<label class="" for="block-customer-register-address2"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_ADDRESS2')->get('value'); ?></label>
				<input class="" id="block-customer-register-address2" type="text" name="address2" value="<?php echo $this->_post['address2']; ?>" size="32" maxlength="255" />
			</div>
			<div class="row">
				<label class="" for="block-customer-register-phone"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_NAME_PHONE')->get('value'); ?></label>
				<input class="" id="block-customer-register-phone" type="text" name="phone" value="<?php echo $this->_post['phone']; ?>" size="32" maxlength="255" />
			</div>
			<div class="row">
				<label class="" for="block-customer-register-phone"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_CARDCODE')->get('value'); ?></label>
				<input class="" id="block-customer-register-phone" type="text" name="cardcode" value="<?php echo $this->_post['cardcode']; ?>" size="32" maxlength="255" />
			</div>
		</div>
		<div class="button">
			<input type="submit" value="<?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTTRATION_CONTINUE')->get('value'); ?>" />
		</div>
	</form>
</div>