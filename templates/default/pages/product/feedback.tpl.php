<?php
/*
 * Created on 11 черв. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */
?>
<div id="product-feedback">
<form action="<?php echo $this->topFolder;?>customer/support/message/send" method="post">
<h3 class="color-d-green">Send Us Feedback:</h3>
<table cellspacing="0" cellpadding="5" width="100%">
	<tr>
		<td width="50%">First Name <span class="required">*</span></td>
		<td width="50%">Last Name <span class="required">*</span></td>
	</tr>
	<tr>
		<td><input type="text" name="name_first" value="<?php echo $this->_customer->get('name_first'); ?>" /></td>
		<td><input type="text" name="name_last" value="<?php echo $this->_customer->get('name_last'); ?>" /></td>
	</tr>
	<tr>
		<td>Email <span class="required">*</span></td>
		<td></td>
	</tr>
	<tr>
		<td><input type="text" name="email" value="<?php echo $this->_customer->get('email'); ?>" /></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="2">Subject</td>
	</tr>
	<tr>
		<td colspan="2"><input type="text" name="title" value="<?php echo htmlspecialchars($this->_product->get('name')); ?>" /></td>
	</tr>
	
	<tr>
		<td colspan="2">Message</td>
	</tr>
	
	<tr>
		<td colspan="2"><textarea name="content" rows="10" cols="50"></textarea></td>
	</tr>
</table>
<div style="margin-bottom: 40px;">
	<div class="right"><div class="btn-send-a-message">
		<input type="image" value="Give Me Money" src="/templates/forrent/css/images/pixel-trans.gif" width="182" height="36" class="title" />
	</div></div>
	<div class="left"><span class="required">*</span> - required fields</div>
	<div class="clear"></div>
</div>
</form>
</div>