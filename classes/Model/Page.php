<?php
/**
 * File: Page.php
 * Created on 19.05.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

class Model_Page extends Model_Object {
	var $_menus;
	var $_table = 'pages';
	var $_model = 'Page';
	var $_id = 'id';
	var $_table_desc = 'pages_description';
	var $_table_desc_id = 'pdid';
	var $_table_desc_conn_id = 'pid';
	function getChildren($menu = null, $all = false) {
		$pcoll = $this->_core->getModel('Page/Collection')->newInstance()
			->addFilter('parent', $this->get($this->_id), 'eq');
		if($menu !== null) {
			$pcoll->addTable('pages_to_mennus', 'p2m', array('menu'))->addFilter('menu',$menu,'eq')->addFilter('page', 'id', 'eq');
		}
		$coll = $pcoll->getCollection(false, true, true);
		if($all) {
			foreach($coll as $k=>$v) {
				$coll[$k]->getChildren($menu, $all);
			}
		}
		$this->push('children', $coll);
		return $this;
	}
	function getParent($menu = null) {
		$pcoll = $this->_core->getModel('Page/Collection')->newInstance()
			->addFilter('id', $this->get('parent'), 'eq');
		if($menu !== null) {
			$pcoll->addTable('pages_to_mennus', 'p2m', array('menu'))->addFilter('menu',$menu,'eq')->addFilter('page', 'id', 'eq');
		}
		$parent = $pcoll->getOne(false, true, true);
		return $parent;
	}
	function getParents($menu = null, $cycle = array(), $key = false) {
		if((int)$this->get('parent')>0) {
			if($key) {
				$parent = $this->getParent($menu);
				$cycle[$parent->get($key)] = $parent;
				$cycle = $parent->getParents($menu, $cycle, $key);
			} else {
				$cycle[] = $this->getParent($menu);
				$cycle = $cycle[sizeof($cycle)-1]->getParents($menu, $cycle);
			}
		}
		return $cycle;
	}
	function fetchProducts($limit, $filters = false, $sortby = false, $featured = false, $exclude = array(), $status = null, $price = null) {
		/** @var $pcoll Model_Product_Collection */
		$pcoll = $this->_core->getModel('Product/Collection')->newInstance()
			->addOption('SQL_CALC_FOUND_ROWS')
			->addTable('products_to_pages', 'p2p')
			->addFilter('prid','prid=id','logic')
			->addFilter('pgid', $this->get($this->_id), 'eq');
		if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield')) {
			$pcoll->addField($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield') . ' AS price');
		}
		foreach($exclude as $k=>$v) {
			$pcoll->addFilter('prid', $v, 'neq');
		}
		if($featured) {
			$pcoll->addFilter('featured', 0, 'neq');
		}
		if($limit) {
			$pcoll->setLimit($limit);
		}
		if($status!==null) {
			$pcoll->addFilter('status', $status, 'eq');
		}
		if($this->_core->notNull($filters)) {

			$ids = array();
			$size = 0;
			foreach($filters as $k=>$v) {
				if(is_array($v)) {
					$ids = array_merge($ids, $v);
					$size++;
				} elseif((int)$v>0) {
					$ids[] = $v;
					$size++;
				}
			}
			if(sizeof($ids)>0) {
				$_filters = $this->_core->getModel('Filter/Collection')->newInstance()
					->addFilter('id', $ids, 'in')
					->getCollection(false,false,true);
				$_arr_ft = array();
				foreach($_filters as $k=>$v) {
					if(!is_array($_arr_ft[$v->get('type')])) $_arr_ft[$v->get('type')] = array();
					$_arr_ft[$v->get('type')][] = $v->get($v->_id);
				}
//				print_r($_arr_ft);
				foreach($_arr_ft as $k=>$v) {
					$pcoll->addTable('products_to_filters', 'p2f'.$k)->addFilter('p2f'.$k.'.product_id', 'p2f'.$k.'.product_id=prid', 'logic');
					$pcoll->addFilter('p2f'.$k.'.filter_id', $v, 'in');
				}
//				$pcoll->addGroupHaving('COUNT(p2f'.$k.'.product_id)>='.$size);
				$pcoll->setGroup('p2f'.$k.'.product_id');

//				$pcoll->addTable('products_to_filters', 'p2f')->addFilter('p2f.product_id', 'p2f.product_id=prid', 'logic');
//				$pcoll->addFilter('p2f.filter_id', $ids, 'in');
//				$pcoll->addGroupHaving('COUNT(p2f.product_id)>='.$size);
//				$pcoll->setGroup('p2f.product_id');
			}
		}

		if($sortby) {
			$pcoll->setOrder($sortby['order']);
			$pcoll->setOrderWay($sortby['way']);
		}
		$pcoll->addTable('products_to_bundles', 'p2b', array('p2b.bundle_id'), 'p2b.product_id=`products`.id')
			->setGroup('bundle_ids')
			->addField('IF(p2b.bundle_id IS NULL, CONCAT(RAND(3), \'null\', id), CONCAT(p2b.bundle_id, \'\')) as bundle_ids');
// 		$this->_core->setDebug(2);
		$cloned = clone($pcoll);
//		echo '<br/>---------------------------------<br/>';
		$res = $cloned->setOrder('`products`.price')->setOrderWay('DESC')->getOne(false, true, true);
//		echo '<br/>---------------------------------<br/>';
		if($res instanceof Model_Product) {
			$this->push('max_price', ceil($res->get('price')));
		}
		unset($res);
		unset($cloned);
		if($price['max']) {
			$pcoll->addFilter('price', (float)$price['max'], 'lesseq');
			$pcoll->addFilter('price', (float)$price['min'], 'moreeq');
		}
//		$this->_core->setDebug(2);
//		die('<pre>'.print_r($pcoll->getCollection(false, true, true),1));
		$this->push('products', $pcoll->getCollection(false, true, true));
		$this->_total_rows = $pcoll->getLastTotal();
// 		$this->_core->setDebug(0);
		return $this;
	}
	function getProductsTotal($filters = false, $status = null, $featured = false, $exclude = array(), $price = null) {
		/** @var $pcoll Model_Product_Collection */
		/*
		$pcoll = $this->_core->getModel('Product/Collection')->newInstance();
		$pcoll->addTable('products_to_pages', 'p2p')
			->addFilter('prid','prid=id','logic')
			->addFilter('pgid', $this->get('id'), 'eq')
			->addTable('products_to_bundles', 'p2b', array('p2b.bundle_id'), 'p2b.product_id=`products`.id')
			->setGroup('bundle_ids')
			->addField('IF(p2b.bundle_id IS NULL, CONCAT(RAND(3), \'null\', id), p2b.bundle_id) as bundle_ids');
		foreach($exclude as $k=>$v) {
			$pcoll->addFilter('prid', $v, 'neq');
		}
		if($featured) {
			$pcoll->addFilter('featured', 0, 'neq');
		}
		if($limit) {
			$pcoll->setLimit($limit);
		}
		if($status!==null) {
			$pcoll->addFilter('status', $status, 'eq');
		}
		if($this->_core->notNull($filters)) {
			$ids = array();
			$size = 0;
			foreach($filters as $k=>$v) {
				if(is_array($v)) {
					$ids = array_merge($ids, $v);
					$size++;
				} elseif((int)$v>0) {
					$ids[] = $v;
					$size++;
				}
			}
			if(sizeof($ids)>0) {
				$pcoll->addTable('products_to_filters', 'p2f')->addFilter('p2f.product_id', 'p2f.product_id=prid', 'logic');
				$pcoll->addFilter('p2f.filter_id', $ids, 'in');
				$pcoll->addGroupHaving('COUNT(p2f.product_id)>='.$size);
				$pcoll->setGroup('p2f.product_id');
			}
		}
		if($price['max']) {
			$pcoll->addFilter('price', (float)$price['max'], 'lesseq');
			$pcoll->addFilter('price', (float)$price['min'], 'moreeq');
		}

		return $pcoll->getTotal(false, true, true, 'bundle_ids');
		*/
		return $this->_total_rows;
	}
	function fetchProductFilterIDs($limit, $sortby = false, $featured = false, $exclude = array(), $status = null) {
		$pcoll = $this->_core->getModel('Product/Collection')->newInstance()
			->addField('p2f.filter_id')
			->addTable('products_to_pages', 'p2p')
			->addFilter('prid','prid=id','logic')
			->addFilter('pgid', $this->get('id'), 'eq');
		foreach($exclude as $k=>$v) {
			$pcoll->addFilter('prid', $v, 'neq');
		}
		if($featured) {
			$pcoll->addFilter('featured', 0, 'neq');
		}
		if($status!==null) {
			$pcoll->addFilter('status', $status, 'eq');
		}
		$pcoll->addTable('products_to_filters', 'p2f')->addFilter('p2f.product_id', 'p2f.product_id=prid', 'logic');

		$pcoll->setGroup('p2f.filter_id');
		if($sortby) {
			$pcoll->setOrder($sortby['order']);
			$pcoll->setOrderWay($sortby['way']);
		}
		$coll = $pcoll->getCollection(false, true, true);
		$ids = array();
		foreach($coll as $filter) {
			$ids[] = $filter->get('filter_id');
		}
		$this->push('filter_ids', $ids);
		return $this;
	}
	function fetchChildren() {
		$this->getChildren($this->get('menu'));
		if($this->get('children')) {
			$children = $this->get('children');
			foreach($children as $k=>$v) {
				$children[$k] = $v->fetchChildren();
			}

			$this->push('children', $children);
		}
		return $this;
	}
	function fetchParents() {
		$cycle = array();
		$this->push('parents', $this->getParents(null, $cycle));
		return $this;
	}
	function getMenus() {
		if($this->get('id')) {
			$query = 'SELECT m.*, pm.sortorder FROM `pages_to_menus` pm LEFT JOIN (`menus` m) ON (m.id=pm.menu) WHERE pm.page=\''.$this->get('id').'\' ORDER BY `sortorder`';
			$this->_menus = $this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult('Page/Menu');
		}
		return $this->_menus;
	}
	function disconnect($item) {
		if($item instanceof Model_Product) {

		}
	}
	function save() {
		$res = false;
		$res = parent::save();
		if(isset($this->_data['menu'])) {
			$m = $this->get('menu');
			$query = 'DELETE FROM `pages_to_menus` WHERE page=\'' . $this->get('id') . '\'';
			$this->_core->getResource('DB')->getConnection()->setQuery($query)->query();
			foreach($m as $k=>$v) {
				$this->_core->getResource('DB')->getConnection()->insert('pages_to_menus', array('page'=>$this->get('id'), 'menu'=>$v, 'sortorder'=>$this->_data['sortorder'][$v]));
			}
		}
		return $res;
	}
	function _fixChars($str) {
		$str = str_replace('–', '&ndash;', $str);
		$str = str_replace('‘', '&lsquo;', $str);
		$str = str_replace('’', '&rsquo;', $str);
		$str = str_replace('‚', '&sbquo;', $str);
		$str = str_replace('“', '&ldquo;', $str);
		$str = str_replace('”', '&rdquo;', $str);
		$str = str_replace('„', '&bdquo;', $str);
		return $str;
	}
	function remove() {
		$query = 'DELETE FROM `pages_to_menus` WHERE page=\'' . $this->get('id') . '\'';
		$this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult();

		$query = 'DELETE FROM `pages` WHERE id=\'' . $this->get('id') . '\'';
		$this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult();

		return $this;
	}
}