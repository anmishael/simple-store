<div id="checkout-option" class="sub-content">
<div id="checkout-stages">
<div id="s1_login" class="stage current">
<div class="stagecontent">
<div class="wrapper">
	<div class="content text-content horizontal">
	<form action="/checkout/process" method="post">
	<div>
	<dl class="form">
		<dt>{$arrTrans.billname_first}: </dt>
		<dd>{$arrCustomer.name_first}</dd>
		<dt>{$arrTrans.shipname_first}: </dt>
		<dd>{$arrCustomer.shipname_first}</dd>
		<dt>{$arrTrans.shipname_last}: </dt>
		<dd>{$arrCustomer.shipname_last}</dd>
		<dt>{$arrTrans.shipaddress1}: </dt>
		<dd>{$arrCustomer.shipcity}, {$arrCustomer.shipstate}, {$arrCustomer.shipaddress1}</dd>
		<dt>{$arrTrans.shipphone}: </dt>
		<dd>{$arrCustomer.shipphone}</dd>
		<dt>{$arrTrans.text_amount}: </dt>
		<dd>{$cartTotal} {$arrCurrency.label}</td>
			<dd class="submit">
				<button class="btn-med continue" type="submit"><span>{$arrTrans.btn_continue}</span></button>
			</dd>
</dl>
<input type="hidden" name="checkout" value="go" />
</div>
</form>
		<div class="clear"></div>
	</div>
</div>
</div>
</div>
</div>
</div>