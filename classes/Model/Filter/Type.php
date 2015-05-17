<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

class Model_Filter_Type extends Model_Object {
	var $_table = 'filter_types';
	var $_id = 'id';
	var $_model = 'Filter/Type';
	var $_table_desc = 'filter_type_description';
	var $_table_desc_id = 'ftdid';
	var $_table_desc_conn_id = 'ftid';
	var $_arrDisplay = array('checkbox','select','multiselect');
	var $_loaded = false;
	function fetchFilters($ids = null, $key = false, $lowercase = false, $where = false, $filters = array(), $exclude_filters = null) {
//		echo 'IDS: '.print_r($ids,1).', Filters: '.print_r($filters,1).', Exclude:'.print_r($exclude_filters,1).'<br/>';
		$this->set('filters', array());
		if($this->get($this->_id)) {
			$coll = $this->_core->getModel('Filter/Collection')->newInstance()
				->addFilter('`filters`.type', $this->get('id'), 'eq')
			->setOrder('name')
			->setOrderWay('ASC');
			if(is_array($where)) {
				foreach($where as $wr) {
					$coll->addFilter($wr['key'], $wr['value'], 'eq');
				}
			}
			if($filters['page']) {
				if($filters['filters']) {
					if($exclude_filters) {
						$coll->addTable(
							'`products_to_filters` p2f, `products_to_filters` p2f2, `products_to_pages` p2p, products p',
							false,
							array('COUNT(p2f.product_id) AS products_count'),'p.id=p2p.prid AND p.status=1 AND p2f.filter_id=`filters`.id AND p2f.filter_id IN ('.implode(', ', $filters['filters']).') AND p2p.prid=p2f.product_id AND p2p.pgid AND p2p.pgid=' . $filters['page'] . ' AND p2f2.product_id=p.id AND p2f2.filter_id IN ('.implode(',', $exclude_filters).')'
						)
							->setGroup('`filters`.id');
					} else {
						$coll->addTable(
							'`products_to_filters` p2f, `products_to_pages` p2p, products p',
							false,
							array('COUNT(p2f.product_id) AS products_count'),'p.id=p2p.prid AND p.status=1 AND p2f.filter_id=`filters`.id AND p2f.filter_id IN ('.implode(', ', $filters['filters']).') AND p2p.prid=p2f.product_id AND p2p.pgid AND p2p.pgid=' . $filters['page']
						)
							->setGroup('`filters`.id');
					}
				} else {
					if($exclude_filters) {
						$coll->addTable(
							'`products_to_filters` p2f, `products_to_filters` p2f2, `products_to_pages` p2p, products p',
							false,
							array('COUNT(p2f.product_id) AS products_count'),'p.id=p2p.prid AND p.status=1 AND p2f.filter_id=`filters`.id AND p2f.filter_id=`filters`.id AND p2p.prid=p2f.product_id AND p2p.pgid AND p2p.pgid=' . $filters['page'] . ' AND p2f2.product_id=p.id AND p2f2.filter_id IN ('.implode(',', $exclude_filters).')'
						)->setGroup('`filters`.id');
					} else {
						$coll->addTable(
							'`products_to_filters` p2f, `products_to_pages` p2p, products p',
							false,
							array('COUNT(p2f.product_id) AS products_count'),'p.id=p2p.prid AND p.status=1 AND p2f.filter_id=`filters`.id AND p2f.filter_id=`filters`.id AND p2p.prid=p2f.product_id AND p2p.pgid AND p2p.pgid=' . $filters['page']
						)->setGroup('`filters`.id');
					}
				}
			}
			if(is_array($ids) && $this->_core->notNull($ids)) {
				$coll->addFilter('`filters`.'.$coll->_id, $ids, 'in');
			}
//			$this->_core->setDebug(99);
			$this->set('filters', $coll->getCollection($key,true,true));
//			$this->_core->setDebug(0);
			if($lowercase) {
				$filters = $this->get('filters');
				foreach($filters as $k=>$v) {
					unset($filters[$k]);
					$filters[strtolower($k)] = $v;
				}
				reset($filters);
				$this->push('filters', $filters);
			}
			$this->_loaded = true;
		}
		return $this;
	}
	function getFilters($ids = null, $key = false, $lowercase = false, $force = false) {
		if(!$this->_loaded || $force) {
			$this->fetchFilters($ids, $key, $lowercase);
		}
		return $this->get('filters');
	}
	function convertCyrToLat($str) {
		$tr = array(
			'ґ'=>'g', 'Ґ'=>'G', 'ї'=>'yi', 'Ї'=>'YI', 'і'=>'i', 'І'=>'I', 'є'=>'ye','Є'=>'YE',
			"А"=>"a", "Б"=>"b", "В"=>"v", "Г"=>"g", "Д"=>"d",
			"Е"=>"e", "Ё"=>"yo", "Ж"=>"zh", "З"=>"z", "И"=>"i",
			"Й"=>"j", "К"=>"k", "Л"=>"l", "М"=>"m", "Н"=>"n",
			"О"=>"o", "П"=>"p", "Р"=>"r", "С"=>"s", "Т"=>"t",
			"У"=>"u", "Ф"=>"f", "Х"=>"kh", "Ц"=>"ts", "Ч"=>"ch",
			"Ш"=>"sh", "Щ"=>"sch", "Ъ"=>"", "Ы"=>"y", "Ь"=>"",
			"Э"=>"e", "Ю"=>"yu", "Я"=>"ya", "а"=>"a", "б"=>"b",
			"в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo",
			"ж"=>"zh", "з"=>"z", "и"=>"y", "й"=>"j", "к"=>"k",
			"л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p",
			"р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f",
			"х"=>"kh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch",
			"ъ"=>"", "ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu",
			"я"=>"ya", " "=>"-", "."=>"", ","=>"", "/"=>"-",
			":"=>"", ";"=>"","—"=>"", "–"=>"-"
		);
		return strtr($str,$tr);
	}
	function prepareUrl() {
		$url = $this->convertCyrToLat($this->get('url'));
		$url = preg_replace('/[^a-z\d ]/i', '', $url);
		$this->push('url', str_replace(' ', '-', $url));
		return $this;
	}
	function save($forceinsert = false) {
		$this->prepareUrl();
		return parent::save($forceinsert);
	}
	/*
	 function save() {
		 $res = false;

		 $columns = $this->_core->getResource('DB')->getConnection()->getTableColumns('filter_types');
		 $data = $this->_data;
		 foreach($data as $k=>$v) {
			 if(!in_array($k, $columns)) unset($data[$k]);
		 }
		 if($this->get('id')) {
			 $pc = $this->_core->getModel('Filter/Type/Collection')->newInstance()
				 ->addFilter('id', $this->get('id'), 'eq');
			 $res = $this->_core->getResource('DB')->getConnection()->update('filter_types', $data, $pc);
		 } else {
			 $res = $this->_core->getResource('DB')->getConnection()->insert('filter_types', $data);
			 if(is_numeric($res)) {
				 $this->set('id', $res);
			 }
		 }
		 return $res;
	 }*/
}