<?php
/**
 * Created on 20 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 $images = $this->_item->get('images');
?>
<product>
	<productid><![CDATA[<?php echo $this->_item->get('id');?>]]></productid>
	<productname><![CDATA[<?php echo $this->_item->get('name');?>]]></productname>
	<cityname><![CDATA[<?php echo $this->_item->get('cityname'); ?>]]></cityname>
	<statename><![CDATA[<?php echo $this->_item->get('statename'); ?>]]></statename>
	<zip><![CDATA[<?php echo $this->_item->get('zip'); ?>]]></zip>
	<description><![CDATA[<?php echo $this->_item->get('description');?>]]></description>
	<address><![CDATA[<?php echo $this->_item->get('address');?>]]></address>
	<units><![CDATA[<?php echo $this->_item->get('units');?>]]></units>
	<price_min><![CDATA[<?php echo $this->_item->get('price_min');?>]]></price_min>
	<price_max><![CDATA[<?php echo $this->_item->get('price_max');?>]]></price_max>
	<beds_min><![CDATA[<?php echo $this->_item->get('beds_min');?>]]></beds_min>
	<beds_max><![CDATA[<?php echo $this->_item->get('beds_max');?>]]></beds_max>
	<bath_min><![CDATA[<?php echo $this->_item->get('bath_min');?>]]></bath_min>
	<bath_max><![CDATA[<?php echo $this->_item->get('bath_max');?>]]></bath_max>
	<squareft_min><![CDATA[<?php echo $this->_item->get('squareft_min');?>]]></squareft_min>
	<squareft_max><![CDATA[<?php echo $this->_item->get('squareft_max');?>]]></squareft_max>
	<phone><![CDATA[<?php echo $this->_item->get('phone');?>]]></phone>
	<type><![CDATA[<?php echo $this->_item->get('type');?>]]></type>
	<typename><![CDATA[<?php echo $this->_item->get('typename');?>]]></typename>
	<image><![CDATA[<?php echo $images['image'][280][0];?>]]></image>
	<latitude><![CDATA[<?php echo $this->_item->get('latitude');?>]]></latitude>
	<longitude><![CDATA[<?php echo $this->_item->get('longitude');?>]]></longitude>
	<items>
		<?php $this->_items = $this->_item->get('items'); foreach($this->_items as $item) { ?>
		<item>
			<id><![CDATA[<?php echo $item->get('id');?>]]></id>	
			<name><![CDATA[<?php echo $item->get('name');?>]]></name>
			<beds><![CDATA[<?php echo $item->get('beds');?>]]></beds>
			<bath><![CDATA[<?php echo $item->get('bath');?>]]></bath>
			<sq_fits><![CDATA[<?php echo $item->get('sq_fits');?>]]></sq_fits>
			<price><![CDATA[<?php echo $item->get('price');?>]]></price>
		</item>
		<?php }?>
	</items>
</product><?php if($this->_customer->get('id')) { ?>
<customer>
	<cid><![CDATA[<?php echo $this->_customer->get('id'); ?>]]></cid>
	<email><![CDATA[<?php echo $this->_customer->get('email'); ?>]]></email>
	<phone><![CDATA[<?php echo $this->_customer->get('phone'); ?>]]></phone>
	<name_first><![CDATA[<?php echo $this->_customer->get('name_first'); ?>]]></name_first>
	<name_last><![CDATA[<?php echo $this->_customer->get('name_last'); ?>]]></name_last>
</customer><?php }?>