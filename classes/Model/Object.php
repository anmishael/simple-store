<?php
/**
 * Created on May 18, 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
/**
 * @property Core $_core
 */
class Model_Object {
	var $_data;
	var $_core;
	function __construct($data = array()) {
		$this->_core = Core::getSingleton('Core');
		$this->setData($data);
	}
	function setData($data) {
		$this->_data = $data;
		return $this;
	}
	function mergeData($data = array(), $exclude = array()) {
		foreach($data as $k=>$val) {
			if(isset($this->_data[$k]) && !in_array($k, $exclude)) $this->push($k, $val);
		}
		return $this;
	}
	function set($key, $val) {
		$this->push($key, $val);
		return $this;
	}
	function setVar($name, $val) {
		$this->$name = $val;
		return $this;
	}

	/**
	 * @param $key
	 * @param $val
	 * @return $this mixed|Model_Object|Model_Collection_Abstract
	 */
	function push($key, $val) {
		$this->_data[$key] = $val;
		return $this;
	}
	function get($key) {
		return isset($this->_data[$key])?$this->_data[$key]:null;
	}
	function pop($key) {
		$res = $this->get($key);
		unset($this->_data[$key]);
		return $res;
	}
	function toArray() {
		return $this->_data;
	}

	/**
	 * @param null|mixed $args
	 * @return mixed|Model_Object|Model_Collection_Abstract
	 */
	function newInstance($args = null) {
		return $this->_core->newInstance($this, $args);
	}
	function save($forceinsert = false) {
		$res = false;
		$id = false;
		if(!$this->_id) {
			$this->_core->raiseError('Table ID name is not defind!');
			return false;
		}
		$columns = $this->_core->getResource('DB')->getConnection()->getTableColumns($this->_table);
		$data = $this->_data;
		foreach($data as $k=>$v) {
			if(!in_array($k, $columns)) unset($data[$k]);
		}
		if($this->get($this->_id) && !$forceinsert) {
			if(is_object($this->_core->getModel($this->_model . '/Collection'))) {
				$pc = $this->_core->getModel($this->_model . '/Collection')->newInstance()
					->addFilter($this->_id, $this->get($this->_id), 'eq');
				unset($data[$this->_id]);
				$res = $this->_core->getResource('DB')->getConnection()->update($this->_table, $data, $pc);
			} else {
				$this->_core->raiseError('Model "' . $this->_model . '/Collection" does not exists. Called from "' . get_class($this) . '" object.');
			}
		} else {
			$res = $this->_core->getResource('DB')->getConnection()->insert($this->_table, $data);
			if(is_numeric($res)) {
				$this->set($this->_id, $res);
			}
		}
		if($this->_table_desc && $this->_table_desc_conn_id && $this->get($this->_id)) {
			$langs = $this->_core->getModel('Language/Collection')->getAllLanguages();
			$columns = $this->_core->getResource('DB')->getConnection()->getTableColumns($this->_table_desc);
			$data = $this->_data;
			foreach($langs as $lang) {
				$dt = array();
				foreach($data as $k=>$v) {
					if(is_array($v)) {
						$dt[$k] = (is_string($v[$lang->get('id')]) && trim($v[$lang->get('id')])=='<br>')?'':$v[$lang->get('id')];
					}
				}
				$dt['language'] = $lang->get('id');
				$dt[$this->_table_desc_conn_id] = $this->get($this->_id);
				reset($dt);
				foreach($dt as $k=>$v) {
					if(!in_array($k, $columns)) unset($dt[$k]);
				}
//  				$this->_core->getResource('DB')->getConnection()->debug=1;
				$obj = $this->_core->getModel('Collection')
					->newInstance()
					->setVar('_table', $this->_table_desc)
// 						->setVar('_id', $this->_table_desc_id)
					->setVar('_model', 'Object')
					->addFilter($this->_table_desc_conn_id, $this->get($this->_id), 'eq')
					->addFilter('language', $lang->get('id'), 'eq');
				if($this->_table_desc_id) {
					$obj->setVar('_id', $this->_table_desc_id);
				}
				if(!($_obj = $obj->getOne()) || !$_obj->get($this->_table_desc_id)) {
					$this->_core->getResource('DB')->getConnection()->insert($this->_table_desc, $dt);
				} else {
					$upd = $this->_core->getResource('DB')->getConnection()->update($this->_table_desc, $dt, $obj);
				}
//  				$this->_core->getResource('DB')->getConnection()->debug=0;
			}
			reset($data);
		}
		return $res;
	}
	function fetchDescription($lng = false) {
		if($this->_table_desc && $this->_table_desc_id && $this->_table_desc_conn_id) {
//  			$this->_core->getResource('DB')->getConnection()->debug=1;
			if($lng) {
				$this->push(
					'description',
					$this->_core->getModel($this->_model . '/Collection')->newInstance()
						->setVar('_table',  $this->_table_desc)
						->setVar('_table_desc', null)
						->setVar('_id', $this->_table_desc_id)
						->setVar('_model', 'Object')
						->addFilter($this->_table_desc_conn_id, $this->get($this->_id), 'eq')
						->addFilter('language', $lng, 'eq')
						->getOne()
				);
				$this->applyDescription();
			} else {
				$this->push(
					'description',
					$this->_core->getModel($this->_model . '/Collection')->newInstance()
						->setVar('_table',  $this->_table_desc)
						->setVar('_table_desc', null)
						->setVar('_id', $this->_table_desc_id)
						->setVar('_model', 'Object')
						->addFilter($this->_table_desc_conn_id, $this->get($this->_id), 'eq')
						->getCollection('language')
				);
			}
//  			$this->_core->getResource('DB')->getConnection()->debug=0;
		}
		return $this;
	}
	function applyDescription() {
		$data = $this->get('description');
		if(is_object($data)) {
			$data = $data->toArray();
			foreach($data as $k=>$v) {
				$this->push($k, $v);
			}
		}
		return $this;
	}
	function remove() {
		$res = false;
		if(!$this->_id) {
			$this->_core->raiseError('Table ID name is not defind!');
			return false;
		}
		if($this->_table_desc_conn_id && $this->_table_desc) {
			$obj = $this->_core->getModel('Collection')->newInstance()
				->addFilter($this->_table_desc_conn_id, $this->get($this->_id), 'eq');
			$res = $this->_core->getResource('DB')->getConnection()->remove($this->_table_desc, $obj);
		}
		$obj = $this->_core->getModel('Collection')->newInstance()
			->addFilter($this->_id, $this->get($this->_id), 'eq');
		$res = $this->_core->getResource('DB')->getConnection()->remove($this->_table, $obj);
		return $res;
	}
}