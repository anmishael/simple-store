<?php
/*
 * Created on 5 лип. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Model_Product_Video extends Model_Object {
 	function save() {
 		$res = false;
 		$columns = $this->_core->getResource('DB')->getConnection()->getTableColumns('videos');
 		$data = $this->_data;
 		foreach($data as $k=>$v) {
 			if(!in_array($k, $columns)) unset($data[$k]);
 		}
 		if(isset($data['description'])) {
 			$data['description'] = $this->_fixChars($data['description']);
 		}
 		if(isset($data['name'])) {
 			$data['name'] = $this->_fixChars($data['name']);
 		}
 		
 		if(strlen($this->get('name'))>0) {
 			if(!$this->get('mime') || strlen($this->get('mime')) == 0) {
 				$this->_fillMime();
 				$data['mime'] = $this->get('mime');
 			}
 			if($this->get('id')) {
	 			$this->_core->getModel('Product/Video/Collection');
	 			$pc = new Model_Product_Video_Collection();
	 			$pc->addFilter('id', $this->get('id'), 'eq');
	 			$res = $this->_core->getResource('DB')->getConnection()->update('videos', $data, $pc);
	 		} else {
	 			$res = $this->_core->getResource('DB')->getConnection()->insert('videos', $data);
	 			if(is_numeric($res)) {
	 				$this->set('id', $res);
	 			}
	 			else { die($res);}
	 		}
 		}
 		return $res;
 	}
 	function remove() {
 		$res = false;
 		if(strlen($this->get('path'))>0 && file_exists($this->_core->getSingleton('Config')->getPath() . $this->get('path'))) {
 			if(unlink($this->_core->getSingleton('Config')->getPath() . $this->get('path'))) {
 				$res = true;
 			}
 		} else {
 			$res = true;
 		}
 		if($res) {
 			$query = 'DELETE FROM `videos` WHERE id=\'' . $this->get('id') . '\'';
 			$res = $this->_core->getResource('DB')->getConnection()->setQuery($query)->query();
 		}
 		return $res;
 	}
 	function _fillMime() {
 		if(function_exists('mime_content_type')) {
 			$this->push('mime', mime_content_type($this->_core->getSingleton('Config')->getPath() . $this->get('path')));
 		} else {
 			$this->push('mime', $this->get_mime_type($this->_core->getSingleton('Config')->getUnixPath() . $this->get('path')));
 		}
 		return $this;
 	}
 	function _fixChars($str) {
 		$str = str_replace('Ц', '&ndash;', $str);
 		$str = str_replace('С', '&lsquo;', $str);
 		$str = str_replace('Т', '&rsquo;', $str);
 		$str = str_replace('В', '&sbquo;', $str);
 		$str = str_replace('У', '&ldquo;', $str);
 		$str = str_replace('Ф', '&rdquo;', $str);
 		$str = str_replace('Д', '&bdquo;', $str);
 		return $str;
 	}
 	function get_mime_type($filename) {
 		if($this->_core->getSingleton('Config')->getPath() != $this->_core->getSingleton('Config')->getUnixPath()) {
 			$filename = 'C:'.str_replace('/', '\\', $filename);
 		}
 		$mime = explode(';', system("file -bi '$filename'"));
 		if(!is_array($mime) || sizeof($mime)<2) {
 			$fileext = array_pop(explode('.', $filename));
		   if (empty($fileext)) return (false);
		   $regex = "/^([\w\+\-\.\/]+)\s+(\w+\s)*($fileext\s)/i";
		   $lines = file($this->_core->getSingleton('Config')->getUnixPath() . 'mime.types');
		   foreach($lines as $line) {
		      if (substr($line, 0, 1) == '#') continue; // skip comments
		      $line = rtrim($line) . " ";
		      if (!preg_match($regex, $line, $matches)) continue; // no match to the extension
		      $mime = $matches[1];
		      break;
		   } 
 		} else {
 			$mime = $mime[0];
 		}
 		return $mime;
	}
 }