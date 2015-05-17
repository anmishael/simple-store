<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Model_Collection_Abstract extends Model_Object {
	var $_collection = array();
	var $_filter;
	var $_limit;
	var $_split = 'AND';
	var $_mainsplit = 'AND';
	var $_order_by;
	var $_order_way = 'desc';
	var $_total;
	var $_group = false;
	var $_options = array();
	var $_group_having = array();
	var $_tables = array();
	var $_field_split = array();
	var $_fields = array();
	var $_group_filter = array();
	var $_group_filter_split = array();
	var $_group_filter_main_split = array();
	var $_table_desc = null;
	var $_table_desc_id = null;
	var $_table_desc_conn_id = null;
	function get($key, $force_return) {
		$res = null;
		if($this->_collection[$key]) {
			$res = $this->_collection[$key];
		} elseif($force_return) {
			$res = new Model_Object(array($force_return=>$key));
		}
		return $res;
	}
	function put($obj, $key = false) {
		if($key) {
			$this->push($key, $obj);
		} else {
			$this->_collection[] = $obj;
		}
		return $this;
	}
	function push($key, $obj) {
		$this->_collection[$key] = $obj;
		return $this;
	}
	function remove($key) {
		unset($this->_collection[$key]);
		return $this;
	}
	function removeFromDb() {
		$arr = array();
		foreach($this->_collection as $k=>$v) {
			$arr[] = $v->get($v->_id);
		}
		if(sizeof($arr)>0) {
			$model = $this->_core->getModel($this->_model . '/Collection')->newInstance()
				->addFilter($this->_id, $arr, 'in');
			$this->_core->getResource('DB')->getConnection()->remove($this->_table, $this);
		}
		return $this;
	}
	function pop($key) {
		$res = $this->get($key);
		unset($this->_collection[$key]);
		return $res;
	}
	function clear() {
		$this->_collection = array();
		$this->_filter = array();
		$this->_limit = false;
		$this->_split = ' OR ';
		$this->_included = array();
		$this->_excluded = array();
		return $this;
	}
	function size() {
		return sizeof($this->_collection);
	}
	function toArray() {
		$res = array();
		foreach($this->_collection as $k=>$v) {
			if(is_object($v)) {
				$res[$k] = $v->toArray();
			}
		}
		return $res;
	}
	function setLimit($limit) {
		$this->_limit = $limit;
		$this->updated = false;
		return $this;
	}
	function addGroupFilter($group_name, $col, $value, $type, $autoquote = true) {
		if(!isset($this->_group_filter[$group_name])) $this->_group_filter[$group_name] = array();
		$this->_group_filter[$group_name][] = array('col'=>$col, 'val'=>$value, 'type'=>$type, 'quote'=>$autoquote);
		$this->_updated = false;
		return $this;
	}
	function setGroupSplit($group_name, $split) {
		$this->_group_filter_split[$group_name] = $split;
		$this->_updated = false;
		return $this;
	}
	function setGroupMainSplit($group_name, $split) {
		$this->_group_filter_main_split[$group_name] = $split;
		$this->_updated = false;
		return $this;
	}

	/**
	 * addFilter						Add fields and values to filter query result
	 *
	 * @param String col				Column name
	 * @param (String|String[]) value	Value
	 * @param String type				Comparation type: [eq,neq,in,more,moreeq,like,less,lesseq,null,notnull,logic]
	 * @param Boolean autoquote			Enable/disable autoquote
	 */
	function addFilter($col, $value, $type, $autoquote = true) {
		if(!isset($this->_filter[$type]) || !is_array($this->_filter[$type])) $this->_filter[$type] = array();
		$this->_filter[$type][] = array('col'=>$col, 'val'=>$value, 'quote'=>$autoquote);
		$this->_updated = false;
		return $this;
	}

	/**
	 * @param String name		Table name
	 * @param String alias		Table alias name
	 * @param String[] fields	Array of table field names
	 */
	function addTable($name, $alias, $fields = array(), $join = false) {
		$this->_tables[] = array('name'=>$name, 'alias'=>$alias, 'fields' => $fields, 'join'=>$join);
		return $this;
	}
	function addFieldSplit($field, $split = 'AND') {
		$this->_field_split[$field] = $split;
		return $this;
	}
	function addField($record) {
		$this->_fields[] = $record;
		return $this;
	}
	function setGroup($str) {
		$this->_group = $str;
		return $this;
	}
	function addGroupHaving($exp) {
		$this->_group_having[] = $exp;
		return $this;
	}
	function addOption($option) {
		$this->_options[] = $option;
		return $this;
	}
	function setSqlSplit($split) {
		$this->_split = $split;
		$this->updated = false;
		return $this;
	}
	function setSqlMainSplit($split) {
		$this->_mainsplit = $split;
		$this->updated = false;
		return $this;
	}
	function setOrder($order) {
		$this->_order_by = $order;
		return $this;
	}
	function setOrderWay($way) {
		$this->_order_way = $way;
		return $this;
	}

	/**
	 * getOne			form query to database and return one row of result as object
	 * 					if _model param filled or as simple array
	 *
	 * @param String usekey		Use result field in collection array as key
	 * @param Boolean withdesc	Join description from another table
	 * @param Boolean lng		Filter by current language
	 */
	function getOne($usekey = false, $withdesc = true, $lng =false) {
		$res = false;
		$collection = $this->getCollection($usekey, $withdesc, $lng);
		if(isset($collection[0])) {
			$res = $collection[0];
		}
		return $res;
	}
	function fetchCollection($usekey = false, $withdesc = true, $lng =false) {
		$this->getCollection($usekey = false, $withdesc = true, $lng =false);
		return $this;
	}
	/**
	 * getCollection 	form query to database and return data result as array of objects
	 * 					if _model class name filled or simple items arrays in other case.
	 *
	 * @param String usekey		Use result field in collection array as key
	 * @param Boolean withdesc	Join description from another table
	 * @param Boolean lng		Filter by current language
	 *
	 */
	function getCollection($usekey = false, $withdesc = true, $lng =false) {
		if($this->size() == 0 && strlen($this->_table)>0) {
			$query = 'SELECT ' . implode(' ', $this->_options) . ' `' . $this->_table . '`.*  ';
			$from = array();
			$join = array();
			if(sizeof($this->_tables)>0) {
				foreach($this->_tables as $table) {
					if(sizeof($table['fields'])>0) {
						$query .= ', ' . implode(', ', $table['fields']);
					}
					if($table['join']) {
						if(strstr($table['name'], '`')) {
							$join[] = 'LEFT JOIN ('.$table['name'] .') ON (' . $table['join'] . ')';
						} else {
							$join[] = 'LEFT JOIN (`'.$table['name'].'` ' . $table['alias'] .') ON (' . $table['join'] . ')';
						}
					} else {
						$from[] = '`'.$table['name'].'` ' . $table['alias'];
					}
				}
			}
			if(sizeof($this->_fields)>0) {
				$query .= ', ' . implode(', ', $this->_fields) . ' ';
			}
			if($withdesc && $this->_table_desc) {
				$query .= ', `'.$this->_table_desc.'`.* ';
			}
			$query .= ' FROM `' . $this->_table . '` '.$this->_table_alias . ' ';
			if($withdesc && $this->_table_desc && $this->_table_desc_conn_id) {
				$query .= ' LEFT JOIN (`'.$this->_table_desc.'` '.$this->_table_desc_alias.') ON (`'.$this->_table_desc_conn_id.'`=`'.$this->_table.'`.`'.$this->_id.'`';
				if($lng) {
					if($lng instanceof Model_Language) {
						$query .= ' AND `language`='.$lng->get($lng->_id);
					} else {
						$query .= ' AND `language`='.$this->_core->getModel('Language/Collection')->getCurrentLanguage()->get('id');
					}
				}
				$query .= ')';
			}
			if(sizeof($join)>0) {
				$query .= ' ' . implode(', ', $join);
			}
			if(sizeof($from)>0) {
				$query .= ', ' . implode(', ', $from);
			}
			if(sizeof($this->_filter)>0 || sizeof($this->_group_filter)>0) {
				$query .= ' WHERE ' . $this->_core->getResource('DB')->getConnection()->getFilterSql($this);
			}
			if($this->_group) {
				$query .= ' GROUP BY ' . $this->_group;
				if(sizeof($this->_group_having)>0) {
					$ag = array();
					foreach($this->_group_having as $exp) {
						$ag[] = ' HAVING ' . $exp;
					}
					$query .= implode(' AND ', $ag);
				}
			}
			if($this->_order_by) {
				$query .= ' ORDER BY ' . $this->_order_by . ' ' . $this->_order_way;
			}
			if($this->_limit) {
				$query .= ' LIMIT ' . $this->_limit;
			}
//			if($lng) {
//				echo '{'.$this->_model.':'.$query.'}<br />';
//			}
			$this->_core->getResource('DB')->getConnection()->setQuery($query);
			if($usekey) {
				$this->_collection = $this->_core->getResource('DB')->getConnection()->getResult($this->_model, $usekey);
			} else {
				$this->_collection = $this->_core->getResource('DB')->getConnection()->getResult($this->_model);
			}
		}
		return $this->_collection;
	}
	function getLastTotal() {
		$res = $this->_core->getResource('DB')->getConnection()->setQuery('SELECT FOUND_ROWS() as total')->getResult();
		$res = $res[0]['total'];
		return $res;
	}
	function setCollection($coll) {
		$this->_collection = $coll;
		return $this;
	}
	function returnCollection() {
		return $this->_collection;
	}
	function getTotal($usekey = false,$withdesc = false, $lng =false, $count_by = false) {
		$res = 0;
		if(strlen($this->_table)>0) {
			$query = 'SELECT COUNT(DISTINCT `'.($count_by?$count_by:$this->_id).'`) as total  ';
			$from = array();
			$join = array();
			if(sizeof($this->_tables)>0) {
				foreach($this->_tables as $table) {
					if(sizeof($table['fields'])>0) {
						$query .= ', ' . implode(', ', $table['fields']);
					}
					if($table['join']) {
						if(strstr($table['name'], '`')) {
							$join[] = 'LEFT JOIN ('.$table['name'] .') ON (' . $table['join'] . ')';
						} else {
							$join[] = 'LEFT JOIN (`'.$table['name'].'` ' . $table['alias'] .') ON (' . $table['join'] . ')';
						}
					} else {
						$from[] = '`'.$table['name'].'` ' . $table['alias'];
					}
				}
			}
			if(sizeof($this->_fields)>0) {
				$query .= ', ' . implode(', ', $this->_fields) . ' ';
			}
			if($withdesc && $this->_table_desc) {
				$query .= ', `'.$this->_table_desc.'`.* ';
			}
			$query .= ' FROM `' . $this->_table . '` '.$this->_table_alias . ' ';
			if($withdesc && $this->_table_desc && $this->_table_desc_conn_id) {
				$query .= ' LEFT JOIN (`'.$this->_table_desc.'` '.$this->_table_desc_alias.') ON (`'.$this->_table_desc_conn_id.'`=`'.$this->_table.'`.`'.$this->_id.'`'.($lng?' AND `language`='.(int)($lng===true?$this->_core->getModel('Language/Collection')->getCurrentLanguage()->get('id'):$lng):'').')';
			}
			if(sizeof($join)>0) {
				$query .= ' ' . implode(', ', $join);
			}
			if(sizeof($from)>0) {
				$query .= ', ' . implode(', ', $from);
			}
			if(sizeof($this->_filter)>0 || sizeof($this->_group_filter)>0) {
				$query .= ' WHERE ' . $this->_core->getResource('DB')->getConnection()->getFilterSql($this);
			}
			if($this->_group) {
				$query .= ' GROUP BY ' . $this->_group;
				if(sizeof($this->_group_having)>0) {
					$ag = array();
					foreach($this->_group_having as $exp) {
						$ag[] = ' HAVING ' . $exp;
					}
					$query .= implode(' AND ', $ag);
				}
			}
			if($this->_order_by) {
				$query .= ' ORDER BY ' . $this->_order_by . ' ' . $this->_order_way;
			}
			if($this->_limit) {
				$query .= ' LIMIT ' . $this->_limit;
			}
			$this->_core->getResource('DB')->getConnection()->setQuery($query);
			$total = $this->_core->getResource('DB')->getConnection()->getResult();
			$res = 0;
			if(sizeof($total)>1) {
				foreach($total as $k=>$row) {
					$res += $row['total'];
				}
			} else {
				$res = $total[0]['total'];
			}
		}
		return $res;
	}
}