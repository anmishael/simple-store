<?php
/*
 * Created on 10 ���. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Model_Template extends Model_Object {
 	var $_table = 'templates';
 	var $_id = 'id';
 	var $_model = 'Template';
 	var $_table_desc = 'template_description';
 	var $_table_desc_id = 'tdid';
 	var $_table_desc_conn_id = 'tid';
 	function applyVars() {
		$this->_applyVar('title')->_applyForeach('content')->_applyVar('content');
		return $this;
 	}
 	function _applyVar($name) {
 		preg_match_all("!{{var.*(.*)}}!U", $this->get($name), $arrBlocks,PREG_SET_ORDER);
		if(sizeof($arrBlocks)>0 && $arrBlocks[0][1]) {
			foreach($arrBlocks as $k=>$v) {
				$v[1] = str_replace('&quot;', '"', $v[1]);
				preg_match_all("!([a-zA-Z].*)=[\"'](.*)[\"']!U",$v[1],$data,PREG_SET_ORDER);
				$params = array();
				foreach($data as $x) {
					$params[$x[1]] = $x[2];
				}
				$_name = $params['name'];
				if( ($var = $this->get($_name)) ) {
					$text = $this->get($name);
//					die($name.'<br><pre>'.print_r($text,1).'</pre>');
					if(is_object($var)) {
						$text = str_replace($v[0], $var->get($params['value']), $text);
					} elseif(is_array($var)) {
						$text = str_replace($v[0], $var[$params['value']], $text);
					} else {
						$text = str_replace($v[0], $var, $text);
					}
					$this->push($name, $text);
				}
				
			}
		}
		return $this;
 	}
 	function _applyForeach($name) {
 		preg_match_all("/\{{2}foreach+(.*)\}{2}(.*)\{{2}\/foreach\}{2}/Ui", $this->get($name), $arrBlocks,PREG_SET_ORDER);
 		if(sizeof($arrBlocks)>0 && $arrBlocks[0][1]) {
 			foreach($arrBlocks as $k=>$v) {
 				$v[1] = str_replace('&quot;', '"', $v[1]);
				preg_match_all("!([a-zA-Z].*)=[\"'](.*)[\"']!U",$v[1],$data,PREG_SET_ORDER);
				$params = array();
				foreach($data as $x) {
					$params[$x[1]] = $x[2];
				}
				$_name = $params['name'];
				$_value = $params['value'];
				$_as = $params['as'];
				$_output = '';
				if( ($var = $this->get($_name)) ) {
					if(is_object($var) && is_array($_var = $var->get($_value))) {
						$obj = $this->_core->getModel('Object')->newInstance();
						foreach($_var as $_value2) {
							$$_as = $_value2;
							preg_match_all("/{{var.*(.*)}}/U", $v[2], $arrBlocks2,PREG_SET_ORDER);
							$_oneline = '';
							if(sizeof($arrBlocks2)>0 && $arrBlocks2[0][1]) {
								$text2 = $v[2];
								foreach($arrBlocks2 as $k2=>$v2) {
									$v2[1] = str_replace('&quot;', '"', $v2[1]);
									preg_match_all("!([a-zA-Z].*)=[\"'](.*)[\"']!U",$v2[1],$data2,PREG_SET_ORDER);
									$params2 = array();
									foreach($data2 as $x2) {
										$params2[$x2[1]] = $x2[2];
									}
									$_name2 = $params2['name'];
									$_value2 = $params2['value'];
									if( ($$_name2) ) {
										if(is_object($$_name2)) {
											$text2 = str_replace($v2[0], $$_name2->get($_value2), $text2);
										} elseif(is_array($$_name2)) {
											$text2 = str_replace($v2[0], $$_name2[$_value2], $text2);
										} else {
											$text2 = str_replace($v2[0], $$_name2, $text2);
										}
									} elseif( ($var2 = $this->get($_name2)) ) {
										if(is_object($var2)) {
											$text2 = str_replace($v2[0], $var2->get($_value2), $text2);
										} elseif(is_array($var2)) {
											$text2 = str_replace($v2[0], $var2[$_value2], $text2);
										} else {
											$text2 = str_replace($v2[0], $var2, $text2);
										}
									}
								}
								$_oneline .= $text2;
							}
							$_output .= $_oneline;
						}
						
					}
				}
				$this->push($name, str_replace($arrBlocks[$k][0], $_output, $this->get($name)));
 			}
 		}
 		return $this;
 	}
}