<?php
/**
 * xml.tpl.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 20.02.13
 * Time: 13:12
 */

header('Content-type: text/xml;charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
?>

<document>
	<?php if($this->_core->getModel('Error/Collection')->size()>0) { ?>
	<result>ERROR</result>
	<?php $this->displayBlock('error', false); ?>
	<?php } elseif($this->_core->_return_status) { ?>
	<result><?php echo $this->_core->_return_status; ?></result>
	<?php } else { ?>
	<result>SUCCESS</result>
	<?php } ?>
	<?php $this->displayBlock('content', false); ?>
</document>