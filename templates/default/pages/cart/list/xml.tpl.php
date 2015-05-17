<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 03.04.13
 * Time: 23:19
 * To change this template use File | Settings | File Templates.
 */

?>
<cart total="<?php echo $this->_total; ?>" currency="<?php echo $this->_currency; ?>">
	<?php foreach($this->_items as $item) { ?>
	<item>
		<id><?php echo $item->get($item->_id); ?></id>
		<code><![CDATA[<?php echo $item->get('code'); ?>]]></code>
		<sku><![CDATA[<?php echo $item->get('sku'); ?>]]></sku>
		<name><![CDATA[<?php echo $item->get('name'); ?>]]></name>
		<price><![CDATA[<?php echo $item->get('price'); ?>]]></price>
		<qty><?php echo $item->get('qty'); ?></qty>
	</item>
	<?php } ?>
</cart>