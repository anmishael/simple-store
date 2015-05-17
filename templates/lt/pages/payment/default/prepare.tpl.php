<?php
/**
 * Created on 22 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
?>
<h1><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_TITLE')->get('value'); ?></h1>
<hr />
<div id="checkout-option" class="sub-content">
<div id="checkout-stages">
<div id="s1_login" class="stage current">
<div class="stagecontent">
<div class="wrapper">
	<div class="content text-content horizontal">
		<form action="/checkout/confirm" method="post">
		<div>
		<dl class="form">
			<dt>
				<dl class="shipping-info">
			<dt>
				<label for="shipname_first"><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_NAME_FIRST')->get('value'); ?> <span class="required">*</span></label>
			</dt>
			<dd>
				<input class="textinput" type="text" id="shipname_first" name="shipname_first" value="<?php echo $_SESSION['lastpost']['shipname_first']?$_SESSION['lastpost']['shipname_first']:$this->_params['arrCustomer']['shipname_first']?$this->_params['arrCustomer']['shipname_first']:$this->_params['arrCustomer']['name_first']; ?>" />
			</dd>
			<dt>
				<label for="shipname_last"><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_NAME_LAST')->get('value'); ?></label>
			</dt>
			<dd>
				<input class="textinput" type="text" id="shipname_last" name="shipname_last" value="<?php echo $_SESSION['lastpost']['shipname_last']?$_SESSION['lastpost']['shipname_last']:$this->_params['arrCustomer']['shipname_last']?$this->_params['arrCustomer']['shipname_last']:$this->_params['arrCustomer']['name_last']; ?>" />
			</dd>
			<dt>
				<label for="shipcity"><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_CITY')->get('value'); ?></label>
			</dt>
			<dd>
				<input class="textinput" type="text" id="shipcity" name="shipcity" value="<?php echo $_SESSION['lastpost']['shipcity']?$_SESSION['lastpost']['shipcity']:$this->_params['arrCustomer']['shipcity']?$this->_params['arrCustomer']['shipcity']:$this->_params['arrCustomer']['city']; ?>" />
			</dd>
			<dt>
				<label for="shipstate"><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_STATE')->get('value'); ?></label>
			</dt>
			<dd><input class="textinput" type="text" id="shipstate" name="shipstate" value="<?php echo $_SESSION['lastpost']['shipstate']?$_SESSION['lastpost']['shipstate']:$this->_params['arrCustomer']['shipstate']?$this->_params['arrCustomer']['shipstate']:$this->_params['arrCustomer']['state']; ?>" /><!--
				<select class="textinput" name="shipstate">
				{foreach from=$arrStates item=item}
					<option value="{$item.zone_name}">{$item.zone_name}</option>
				{/foreach}
				</select>-->
			</dd>
			<dt>
				<label for="shipaddress1"><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_ADDRESS')->get('value'); ?></label>
			</dt>
			<dd>
				<input class="textinput" type="text" id="shipaddress1" name="shipaddress1" value="<?php echo $this->_params['arrCustomer']['shipaddress1']?$this->_params['arrCustomer']['shipaddress1']:$this->_params['arrCustomer']['address1']; ?>" />
			</dd>
			<dt>
				<label for="shipphone"><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_PHONE')->get('value'); ?> <span class="required">*</span></label>
			</dt>
			<dd>
				<input class="textinput" type="text" id="shipphone" name="shipphone" value="<?php echo $this->_params['arrCustomer']['shipphone']?$this->_params['arrCustomer']['shipphone']:$this->_params['arrCustomer']['phone']; ?>" />
			</dd>
			<dt><label for="comment"><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_NOTES')->get('value'); ?></label></dt>
			<dd><textarea id="comment" class="text" name="comment" cols="64" rows="5"><?php echo $_SESSION['lastpost']['comment']; ?></textarea><br /><br /></dd>
				</dl>
			</dt>
			<dt class="shipping-methods">
				<dl>
					<h3><?php echo $this->_core->getModel('Translate/Collection')->get('CHECKOUT_SHIPPING_SELECT')->get('value'); ?></h3>
					<?php foreach($this->_params['objShipping'] as $k=>$item) { ?>
					<dt style="white-space: nowrap;"><input<?php echo ($k==0 && !isset($this->_params['shipping_method']))?' checked="checked"':'' ?> type="radio" name="shipping_method" value="<?php echo $item->get('name'); ?>" id="shipping-<?php echo $item->get('name'); ?>"<?php echo ($item->get('name') == $this->_params['shipping_method'] ? 'checked="checked"':'');?> /> <label style="display:inline;" for="shipping-<?php echo $item->get('name'); ?>"><?php echo $item->get('label'); ?></label></dt>
					<dd> &nbsp; </dd>
					<?php } ?>
				</dl>
			</dt>
			<dt class="clear"></dt>
			<dt class="clear"><span class="required">*</span> <label><?php echo $this->_core->getModel('Translate/Collection')->get('REQUIRED_FIELDS')->get('value'); ?></label><br /><br /></dt>
			<dd class="submit">
				<button class="btn-next-step continue" type="submit"><span><?php echo $this->_core->getModel('Translate/Collection')->get('NEXT_STEP')->get('value'); ?></span></button>
			</dd>
		</dl>
		</div>
		</form>
		<div class="clear"></div>
	</div>
</div>
</div>
</div>
</div>
</div>