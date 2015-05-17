<?php
/**
 * Created on 26 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
?>
<products currency="<?php echo $this->_core->getModel('Currency/Collection')->fetch()->get('label'); ?>">
<?php foreach($this->_items as $k=>$item) { $images = $item->fetchImages()->get('images'); ?>
	<product>
		<id><?php echo $item->get('id'); ?></id>
		<name><![CDATA[<?php echo $item->get('name'); ?>]]></name>
		<price><?php echo $item->get('price'); ?></price>
		<image><?php echo $images['image'][100][0]; ?></image>
		<image_large><?php echo $images['image']['large'][0]; ?></image_large>
		<?php $brand = $item->getFilterByName('brand', true); if($brand instanceof Model_Filter) { ?>
		<brand>
			<b_name><![CDATA[<?php echo $brand->get('name') ?>]]></b_name>
			<b_url><![CDATA[<?php echo $brand->get('filter_type_url') ?>]]></b_url>
			<b_image><![CDATA[/images/filters/brand/<?php echo $brand->get('url'); ?>-small.png]]></b_image>
		</brand>
		<?php } ?>
	</product>
<?php } ?>
</products>