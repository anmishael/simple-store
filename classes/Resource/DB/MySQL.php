<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Resource_DB_MySQL extends Resource_DB_Abstract {
	var $_conn;
	var $_core;
	var $_query, $_sql;
// 	var $_query_type = MYSQL_FETCH_ASSOC;
	var $_result;
	var $debug = false;
	var $_functions = array('NOW()', 'CURRENT_TIMESTAMP()');
	function __construct() {
		parent::__construct();
	}
	function __destruct() {
		$this->_disconnect();
	}
	function _connect() {
		if(!$this->_conn || $this->_conn == null) {
			$this->_conn = mysql_connect($this->_core->getSingleton('Config')->DB['host'], $this->_core->getSingleton('Config')->DB['user'], $this->_core->getSingleton('Config')->DB['pass'])
				or die('Could not connect to DB!');
			if(!(mysql_select_db($this->_core->getSingleton('Config')->DB['name'], $this->_conn))) {
				die('Could not select DB!');
			} else {
 				mysql_query('SET CHARSET \'utf8\'', $this->_conn);
			}

		}
		return $this;
	}
	function _disconnect() {
		if($this->_conn) {
			mysql_close($this->_conn);
			$this->_conn = null;
		}
		return $this;
	}
	function setQuery($query) {
		$this->_sql = $query;
		return $this;
	}
	function getQuery() {
		return $this->_sql;
	}
	function _query() {
		if($this->_core->getDebug()>1) {
			echo '<p>Query: '.htmlspecialchars($this->getQuery()).'</p>';
		}
		if(!($this->_query = mysql_query($this->getQuery(), $this->_conn)) || mysql_errno($this->_conn)>0) {
			if($this->debug > 0) {
				$this->raiseError();
			}
			$this->error = 1;
//			echo mysql_errno($this->_conn) .': '.mysql_error($this->_conn).'<br />';
		}
//		echo mysql_errno($this->_conn) .': '.mysql_errno($this->_conn).': '.mysql_errno($this->_conn).'<br />';
		return $this;
	}
	function query() {
		return $this->_query();
	}
	function getResult($objType = null, $keyname = false) {
		$result = array();
		if(strlen(trim($this->_sql))>0) {
			$this->_query();
			if($objType === null) {
				if($keyname) {
					while($row = mysql_fetch_assoc($this->_query)) {
						$result[$row[$keyname]] = $row;
					}
				} else {
					while($row = mysql_fetch_assoc($this->_query)) {
						$result[] = $row;
					}
				}
			} else {
				$mName = ('Model_' . str_replace('/', '_', $objType));
				if(!$this->_core->getModel($objType) instanceof $mName) {
					die('Fatal error: missing model '.$mName.'!');
				}
//  				$this->_core->getSingleton(str_replace('_', '/', $objType));
				$this->_core->getModel($objType);
				if($keyname) {
					while($row = mysql_fetch_assoc($this->_query)) {
// 			 			$result[$row[$keyname]] = new $objType($row);
//						echo $keyname.': '.$row[$keyname].'<br>';
						$result[$row[$keyname]] = $this->_core->getModel($objType)->newInstance($row);
					}
				} else {
					while($row = mysql_fetch_assoc($this->_query)) {
// 			 			$result[] = new $objType($row);
						$result[] = $this->_core->getModel($objType)->newInstance($row);
					}
				}
			}
			mysql_free_result($this->_query);
		}
		return $result;
	}
	function insert($table, $data, $autoquote = true, $ignore = false) {
		$this->error = false;
		$columns = $this->getTableColumns($table);
		$arr = array('keys'=>array(), 'values'=>array());
		if($autoquote) {
			foreach($columns as $column) {
				if($data[$column]) {
					$arr['keys'][] = $column;
					$arr['values'][] = !in_array(trim($data[$column]), $this->_functions) ? '\''.mysql_real_escape_string(isset($data[$column])?$data[$column]:'').'\'' : $data[$column];
				}
			}
		} else {
			foreach($columns as $column) {
				if($data[$column]) {
					$arr['keys'][] = $column;
					$arr['values'][] = $data[$column];
				}
			}
		}
		$query = 'INSERT'.($ignore?' IGNORE':'').' INTO `'.$table.'` (`'.implode('`, `', $arr['keys']).'`) VALUES (' . implode(', ', $arr['values']) . ')';
		$this->setQuery($query)->_query();
		if($this->error) {
			$this->error = false;
			$id = false;
		} else {
			$id = mysql_insert_id($this->_conn);
		}

		return $id;
	}
	function update($table, $data, $objcoll = null, $autoquote = true) {
		$this->error = false;
		$columns = $this->getTableColumns($table);
		$arr = array();
		$query = 'UPDATE `' . $table . '` SET';

		if($autoquote) {
			foreach($data as $column=>$value) {
				if(!in_array(trim($data[$column]), $this->_functions)) {
					$arr[] = ' `' . $column . '`=\'' . mysql_real_escape_string($value) . '\'';
				} else {
					$arr[] = ' `' . $column . '`=' . $value;
				}
			}
		} else {
			foreach($data as $column=>$value) {
				$arr = ' `' . $column . '`=\'' . $value . '\'';
			}
		}
		$query .= ' ' . implode(', ', $arr);

		if(is_object($objcoll)) {
			$query .= ' WHERE ' . $this->getFilterSql($objcoll);
		}
		$this->setQuery($query);
		$this->_query();
		return true;//mysql_affected_rows($this->_conn);
	}
	/**
	 * remove					method used for data removing from DB
	 * @param string $table		DB tablec name
	 * @param object $objcoll	object extended from Model_Collection_Abstract
	 * 							used to filter items
	 */
	function remove($table, $objcoll) {
		$query = 'DELETE FROM `' . $table . '`';
		if(is_object($objcoll)) {
			$query .= ' WHERE ' . $this->getFilterSql($objcoll);
		}
		$this->setQuery($query);
		return $this->query();
	}
	function addRow($table, $name, $type) {
		$query = 'ALTER TABLE `' . $table . '` ADD COLUMN `' . $name . '` ' . $type . ' NULL;';
		$this->setQuery($query);
		return $this->_query();
	}
	function getTableColumns($table) {
		$sql = 'SHOW COLUMNS FROM ' . $table;
		$arrColumnsSql = $this->setQuery($sql)->getResult();
		$arrColumns = array();
		foreach($arrColumnsSql as $k=>$v) {
			$arrColumns[] = $v['Field'];
		}
		return $arrColumns;
	}
	function getFilterSql(&$object) {
		$sql = array();
		if(sizeof($object->_filter)>0) {
			foreach($object->_filter as $key=>$val) {
				$split = $object->_split ? ' ' . $object->_split . ' ' : ' OR ';
				$arrSql = array();
				foreach($val as $k=>$v) {
					if(isset($object->_field_split[$v['col']])) {
						$split = ' ' . $object->_field_split[$v['col']] . ' ';
					}
					switch ( $key ) {
						case 'eq':
							if($v['quote']) {
								$arrSql[] = $v['col'].'=\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'='.$v['val'];
							}
							break;
						case 'in':
							if($v['quote']) {
								if(is_array($v['val'])) {
									$arrSql[] = $v['col'].' IN (\''.implode('\',\'', $v['val']).'\')';
								} else {
									$arrSql[] = $v['col'].' IN (\''.addslashes($v['val']).'\')';
								}
							} else {
								if(is_array($v['val'])) {
									$arrSql[] = $v['col'].' IN ('.implode(',', $v['val']).')';
								} else {
									$arrSql[] = $v['col'].' IN ('.$v['val'].')';
								}
							}
							break;
						case 'notin':
							if($v['quote']) {
								if(is_array($v['val'])) {
									$arrSql[] = $v['col'].' NOT IN (\''.implode('\',\'', $v['val']).'\')';
								} else {
									$arrSql[] = $v['col'].' NOT IN (\''.addslashes($v['val']).'\')';
								}
							} else {
								if(is_array($v['val'])) {
									$arrSql[] = $v['col'].' NOT IN ('.implode(',', $v['val']).')';
								} else {
									$arrSql[] = $v['col'].' NOT IN ('.$v['val'].')';
								}
							}
							break;
						case 'neq':
							if($v['quote']) {
								$arrSql[] = $v['col'].'<>\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'<>'.$v['val'];
							}
							break;
						case 'more':
							if($v['quote']) {
								$arrSql[] = $v['col'].'>\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'>'.$v['val'];
							}
							break;
						case 'moreeq':
							if($v['quote']) {
								$arrSql[] = $v['col'].'>=\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'>='.$v['val'];
							}
							break;
						case 'less':
							if($v['quote']) {
								$arrSql[] = $v['col'].'<\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'<'.$v['val'];
							}
							break;
						case 'lesseq':
							if($v['quote']) {
								$arrSql[] = $v['col'].'<=\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'<='.$v['val'];
							}
							break;
						case 'like':
							if(is_array($v['val'])) {
								$arrSs = array();
								if($v['quote']) {
									foreach($v['val'] as $ss) {
										$arrSs[] = $v['col'].' LIKE \'%'.addslashes($ss).'%\'';
									}
								} else {
									foreach($v['val'] as $ss) {
										$arrSs[] = $v['col'].' LIKE '.$ss.'';
									}
								}
								$arrSql[] = ' ( ' . implode(' AND ', $arrSs) . ' ) ';
							} else {
								$arrSql[] = $v['col'].' LIKE \'%'.addslashes($v['val']).'%\'';
							}
							break;
						case 'null':
							$arrSql[] = $v['col'].' IS NULL OR ' . $v['col'] . '=\'\' ';
							break;
						case 'notnull':
							$arrSql[] = $v['col'].' IS NOT NULL AND ' . $v['col'] . '<>\'\' ';
							break;
						case 'logic':
							$arrSql[] = $v['val'];
							break;
						default:
							break;
					}
				}
				$sql[] = ' (' . implode($split, $arrSql) . ') ';
			}
		}
		$sql = array_merge($sql, $this->getGroupFilterSqlArr($object));
		return implode(' ' . $object->_mainsplit . ' ', $sql);
	}
	function getGroupFilterSqlArr(&$object) {
		$sql = array();
		if(sizeof($object->_group_filter)>0) {
			foreach($object->_group_filter as $key=>$val) {
				$arrSql = array();
				$split = $object->_group_filter_split[$key] ? ' ' . $object->_group_filter_split[$key] . ' ' : ' OR ';
				foreach($val as $k=>$v) {
					switch ( $v['type'] ) {
						case 'eq':
							if($v['quote']) {
								$arrSql[] = $v['col'].'=\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'='.$v['val'];
							}
							break;
						case 'in':
							if($v['quote']) {
								if(is_array($v['val'])) {
									$arrSql[] = $v['col'].' IN (\''.implode('\',\'', $v['val']).'\')';
								} else {
									$arrSql[] = $v['col'].' IN (\''.addslashes($v['val']).'\')';
								}
							} else {
								if(is_array($v['val'])) {
									$arrSql[] = $v['col'].' IN ('.implode(',', $v['val']).')';
								} else {
									$arrSql[] = $v['col'].' IN ('.$v['val'].')';
								}
							}
							break;
						case 'neq':
							if($v['quote']) {
								$arrSql[] = $v['col'].'<>\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'<>'.$v['val'];
							}
							break;
						case 'more':
							if($v['quote']) {
								$arrSql[] = $v['col'].'>\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'>'.$v['val'];
							}
							break;
						case 'moreeq':
							if($v['quote']) {
								$arrSql[] = $v['col'].'>=\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'>='.$v['val'];
							}
							break;
						case 'less':
							if($v['quote']) {
								$arrSql[] = $v['col'].'<\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'<'.$v['val'];
							}
							break;
						case 'lesseq':
							if($v['quote']) {
								$arrSql[] = $v['col'].'<=\''.addslashes($v['val']).'\'';
							} else {
								$arrSql[] = $v['col'].'<='.$v['val'];
							}
							break;
						case 'like':
							if(is_array($v['val'])) {
								$arrSs = array();
								if($v['quote']) {
									foreach($v['val'] as $ss) {
										$arrSs[] = $v['col'].' LIKE \'%'.addslashes($ss).'%\'';
									}
								} else {
									foreach($v['val'] as $ss) {
										$arrSs[] = $v['col'].' LIKE '.$ss.'';
									}
								}
								$arrSql[] = ' ( ' . implode(' AND ', $arrSs) . ' ) ';
							} else {
								$arrSql[] = $v['col'].' LIKE \'%'.addslashes($v['val']).'%\'';
							}
							break;
						case 'null':
							$arrSql[] = $v['col'].' IS NULL OR ' . $v['col'] . '=\'\' ';
							break;
						case 'notnull':
							$arrSql[] = $v['col'].' IS NOT NULL AND ' . $v['col'] . '<>\'\' ';
							break;
						default:
							break;
					}
				}
				$sql[] = ' (' . implode($split, $arrSql) . ') ';
			}
		}
		return $sql;
	}
}