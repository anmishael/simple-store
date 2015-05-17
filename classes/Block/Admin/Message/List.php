<?php
/**
 * Created on 20 лип. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Admin_Message_List extends Block_Display {
 	var $_items;
 	function init() {
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Message', 'View')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-message-view'),
	 				'name'=>'view'
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Message', 'Remove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-message-remove'),
	 				'name'=>'remove',
	 				'warning'=>'Are you sure you wish to remove "%s" message?'
	 			);
 		}
 		$this->_items = $this->_core->getModel('Customer/Support/Message/Collection')->newInstance()
 				->addFilter('parent', 0, 'eq')
 				->getCollection();
 		$this->fetch('message', 'list');
 		return $this;
 	}
 }