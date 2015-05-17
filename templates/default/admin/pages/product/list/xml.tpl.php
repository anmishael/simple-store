<?php
/**
 * xml.tpl.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 20.02.13
 * Time: 13:06
 */

?>
<products>
	<?php foreach($this->_items as $k=>$item) { $images = $item->fetchImages()->get('images'); ?>
	<product>
		<id><?php echo $item->get('id'); ?></id>
		<name><![CDATA[<?php echo $item->get('name'); ?>]]></name>
		<pack><![CDATA[<?php echo $item->get('packing'); ?>]]></pack>
		<price><?php echo $item->get('price'); ?></price>
	</product>
	<?php } ?>
</products>