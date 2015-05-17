<?php
/**
 * Created on 10 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

 class Block_Admin_Template_List extends Block_Display {
 	var $_items;
 	function init() {
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Template', 'Edit')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-template-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-template-edit'),
	 				'name'=>'Add new template'
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Template', 'Remove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-template-remove'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
	 				'warning'=>'Are you sure you wish to remove "%s" template?'
	 			);
 		}
 		$this->_items = $this->_core->getModel('Template/Collection')->newInstance()->getCollection(false,true,true);
 		$this->fetch('template', 'list');
 		return $this;
 	}
 }