<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 23.03.13
 * Time: 19:42
 * To change this template use File | Settings | File Templates.
 */
?>
<import_history>
<?php foreach($this->_items as $item) { ?>
	<item>
		<id><?php echo $item->get('id'); ?></id>
		<code><?php echo $item->get('code'); ?></code>
		<item_id><?php echo $item->get('item_id'); ?></item_id>
		<type><?php echo $item->get('type'); ?></type>
		<res><?php echo $item->get('result'); ?></res>
	</item>
<?php } ?>
</import_history>
