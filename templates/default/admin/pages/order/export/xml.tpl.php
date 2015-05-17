<?php
/**
 * xml.tpl.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 19.11.12
 * Time: 9:13
 */
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
?>
<orders>
	<order>
		<oid><?php echo $this->_item->get('id'); ?></oid>
        <cid><?php echo $this->_item->get('cid'); ?></cid>
		<created><![CDATA[<?php echo $this->_item->get('created'); ?>]]></created>
		<customer><![CDATA[<?php echo $this->_item->get('name_first') . ' ' . $this->_item->get('name_last'); ?>]]></customer>
        <cardcode><![CDATA[<?php echo $this->_item->get('cardcode'); ?>]]></cardcode>
        <ordertotal><?php echo $this->_item->get('total'); ?></ordertotal>
        <currency><?php echo $this->_item->get('currency'); ?></currency>
		<products><?php $products = $this->_item->get('products'); foreach($products as $k=>$product) { ?>

			<product>
				<code><![CDATA[<?php echo $product->get('code'); ?>]]></code>
                <qty><?php echo $product->get('qty'); ?></qty>
                <price><?php echo $product->get('price'); ?></price>
                <total><?php echo $product->get('total'); ?></total>
			</product><?php } ?>

		</products>
	</order>
</orders>