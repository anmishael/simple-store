<?php
/**
* Created on 25 ���. 2012
* By Mikel Annjuk <anmishael@gmail.com>
* Especially for KinetoscopeMedia Inc.
*/
$arrMessages = array();
if(sizeof($this->_items)>0) { ?>,
	messages:
	<?php foreach($this->_items as $item) { ?>
	<?php $arrMessages[] = ' [{ title: \'' . htmlspecialchars($item->get('title')) . '\', content: \''.htmlspecialchars($item->get('content')).'\' }]'; ?>
	<?php } ?>
	<?php echo implode(','."\n", $arrMessages); ?>
<?php } ?>