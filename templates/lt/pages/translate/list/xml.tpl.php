<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 04.04.13
 * Time: 2:56
 * To change this template use File | Settings | File Templates.
 */

?>
<translate>
	<?php foreach($this->_items as $item) { ?>
	<item>
		<key><![CDATA[<?php echo $item->get('key'); ?>]]></key>
		<value><![CDATA[<?php echo $item->get('value'); ?>]]></value>
	</item>
	<?php } ?>
</translate>