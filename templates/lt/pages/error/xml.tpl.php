<?php
/**
 * Created on 19 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */


if(sizeof($this->_items)>0) {
?>
	<messages>
<?php
	foreach($this->_items as $item) {
?>
		<message>
			<title><![CDATA[<?php echo $item->get('title');?>]]></title>
			<content><![CDATA[<?php echo $item->get('content');?>]]></content>
		</message>
<?php
	}
?>
	</messages><?php
}
?>