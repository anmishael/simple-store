<div id="checkout-option" class="sub-content">
<div id="checkout-stages">
<div id="s1_login" class="stage current">
<div class="stagecontent">
<div class="wrapper">
	<div class="content text-content horizontal">
		<form action="/checkout/confirm" method="post">
		<div>
		<h3>{$arrTrans.text_prepare_form_title}</h3>
		<dl class="form">
			<dt>
				<label for="shipname_first">{$arrTrans.shipname_first}</label>
			</dt>
			<dd>
				<input class="textinput" type="text" id="shipname_first" name="shipname_first" value="{$arrCustomer.shipname_first}" />
			</dd>
			<dt>
				<label for="shipname_last">{$arrTrans.shipname_last}</label>
			</dt>
			<dd>
				<input class="textinput" type="text" id="shipname_last" name="shipname_last" value="{$arrCustomer.shipname_last}" />
			</dd>
			<dt>
				<label for="shipcity">{$arrTrans.shipcity}</label>
			</dt>
			<dd>
				<input class="textinput" type="text" id="shipcity" name="shipcity" value="{$arrCustomer.shipcity}" />
			</dd>
			<dt>
				<label for="shipstate">{$arrTrans.shipstate}</label>
			</dt>
			<dd>
				<select class="textinput" name="shipstate">
				{foreach from=$arrStates item=item}
					<option value="{$item.zone_name}">{$item.zone_name}</option>
				{/foreach}
				</select>
			</dd>
			<dt>
				<label for="shipaddress1">{$arrTrans.shipaddress1}</label>
			</dt>
			<dd>
				<input class="textinput" type="text" id="shipaddress1" name="shipaddress1" value="{$arrCustomer.shipaddress1}" />
			</dd>
			<dt>
				<label for="shipphone">{$arrTrans.shipphone}</label>
			</dt>
			<dd>
				<input class="textinput" type="text" id="shipphone" name="shipphone" value="{$arrCustomer.shipphone}" />
			</dd>
			<dt>
				<dl>
					<h3>{$arrTrans.text_select_shipping}</h3>
					{foreach from=$arrShipping item=item}
					<dt style="white-space: nowrap;"><input type="radio" name="shipping_method" value="{$item.name}" id="shipping-{$item.name}"{if $item.name eq $shipping_method} checked="checked"{/if} /> <label style="display:inline;" for="shipping-{$item.name}">{$item.label}</label></dt>
					<dd> &nbsp; </dd>
					{/foreach}
				</dl>
			</dt>
			<dd class="submit">
				<button class="btn-med continue" type="submit"><span>{$arrTrans.btn_continue}</span></button>
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