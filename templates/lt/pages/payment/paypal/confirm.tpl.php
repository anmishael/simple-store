<?php
/**
 * Created on 16 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
?>
<div id="block-payment-paypal-confirm">
<h2>Please finalize order process:</h2>
<form action="/checkout/process" method="post"><table>
	<tr>
		<td>Name First: </td>
		<td><?php echo $this->_params['arrBuyer']['FIRSTNAME']; ?></td>
	</tr>
	<tr>
		<td>Name Last: </td>
		<td><?php echo $this->_params['arrBuyer']['LASTNAME']; ?></td>
	</tr>
	<tr>
		<td>Business: </td>
		<td><?php echo $this->_params['arrBuyer']['BUSINESS']; ?></td>
	</tr>
	<tr>
		<td>Email: </td>
		<td><?php echo $this->_params['arrBuyer']['EMAIL']; ?></td>
	</tr>
	<tr>
		<td>Amount: </td>
		<td>$<?php echo $this->_params['arrBuyer']['AMT']; ?></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
</table>
<div class="actions">
	<div class="cancel">
		<a class="btn-cancel" href="/cart/list"><span>cancel</span></a>
		<input type="hidden" name="checkout" value="go" />
	</div>
		<div class="confirm">
		<input type="image" src="/templates/forrent/css/images/pixel-trans.gif" class="btn-finalize" border="0" />
	</div>
	<div class="clear"></div>
</div></form></div>