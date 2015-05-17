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
if(is_object($this->_customer) && $this->_customer->get('id')) { ?>
<customer>
	<cid><![CDATA[<?php echo $this->_customer->get('id'); ?>]]></cid>
	<email><![CDATA[<?php echo $this->_customer->get('email'); ?>]]></email>
	<phone><![CDATA[<?php echo $this->_customer->get('phone'); ?>]]></phone>
	<name_first><![CDATA[<?php echo $this->_customer->get('name_first'); ?>]]></name_first>
	<name_last><![CDATA[<?php echo $this->_customer->get('name_last'); ?>]]></name_last>
</customer><?php }?>