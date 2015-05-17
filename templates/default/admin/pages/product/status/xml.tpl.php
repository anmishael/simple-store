<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 28.02.13
 * Time: 14:45
 * To change this template use File | Settings | File Templates.
 */

?>
<product>
	<id><?php echo $this->_item->get('id'); ?></id>
	<status><?php echo $this->_item->get('status'); ?></status>
	<status_new><?php echo $this->_item->get('status_new'); ?></status_new>
	<status_action><?php echo $this->_item->get('status_action'); ?></status_action>
	<status_topsell><?php echo $this->_item->get('status_topsell'); ?></status_topsell>
</product>