<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

class Model_Filter extends Model_Object {
	var $_table = 'filters';
	var $_id = 'id';
	var $_table_desc = 'filter_description';
	var $_table_desc_id = 'fdid';
	var $_table_desc_conn_id = 'fid';
	var $_model = 'Filter';
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
		$this->push('url', trim(strtolower(str_replace(' ', '-', $url))));
		return $this;
	}
	function save($forceinsert = false) {
		$this->prepareUrl();
		return parent::save($forceinsert);
	}
	function disconnect($object) {
		$res = false;
		if($object instanceof Model_Product) {
			$sql = 'DELETE FROM `products_to_filters` WHERE product_id=\'' . $object->get($object->_id) . '\' AND filter_id=\''.$this->get($this->_id).'\'';
			if(!($res = $this->_core->getResource('DB')->getConnection()->setQuery($sql)->query())) {
				$this->_core->raiseError('Cannot disconnect "'.$this->get('id').'" filter from "'.$object->get('code').'" product.');
			}
		}
		return $res;
	}
	/*
	 function save() {
		 $res = false;

		 $columns = $this->_core->getResource('DB')->getConnection()->getTableColumns('filters');
		 $data = $this->_data;
		 foreach($data as $k=>$v) {
			 if(!in_array($k, $columns)) unset($data[$k]);
		 }
		 if($this->get('id')) {
			 $pc = $this->_core->getModel('Filter/Type/Collection')->newInstance()
				 ->addFilter('id', $this->get('id'), 'eq');
			 $res = $this->_core->getResource('DB')->getConnection()->update('filters', $data, $pc);
		 } else {
			 $res = $this->_core->getResource('DB')->getConnection()->insert('filters', $data);
			 if(is_numeric($res)) {
				 $this->set('id', $res);
			 }
		 }
		 return $res;
	 }
	 //*/
}