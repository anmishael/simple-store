<?php
/**
 * Created on 27 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
?>
<settings>
<?php foreach($this->_items as $item) { ?>
	<setting>
		<key><![CDATA[<?php echo $item->get('key'); ?>]]></key>
		<value><![CDATA[<?php echo $item->get('value'); ?>]]></value>
	</setting>
<?php } ?>
</settings>